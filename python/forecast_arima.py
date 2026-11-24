import os
import sys
import json
import argparse
import warnings
import pandas as pd
import numpy as np
from datetime import datetime
from dateutil.relativedelta import relativedelta
from statsmodels.tsa.arima.model import ARIMA

from database import get_db_engine, get_mysql_connection
from aggregate_transactions import aggregate_monthly_transactions
from train_arima import train_arima_model
from evaluate_arima import evaluate_arima

warnings.filterwarnings('ignore')

def generate_forecast(horizon=12, train_cutoff=None, save_to_db=True):
    """
    Generate ARIMA forecasts for the specified horizon (default 12 months).
    Calculates 95% confidence intervals (lower and upper bounds).
    Stores results in MySQL 'forecast_runs' and 'transaction_forecasts'.
    """
    df = aggregate_monthly_transactions(save_to_file=False)
    
    # Check if train_cutoff is specified (e.g. '2024-12' to predict 2025 as in research design)
    if train_cutoff:
        train_df = df[df['period'] <= train_cutoff].copy()
        future_actuals = df[df['period'] > train_cutoff].set_index('period')['nilai_transaksi_netto_idr'].to_dict()
    else:
        train_df = df.copy()
        future_actuals = {}
        
    ts = train_df['nilai_transaksi_netto_idr'].values
    train_periods = train_df['period'].tolist()
    
    if len(ts) < 10:
        raise ValueError(f"Insufficient training observations ({len(ts)} periods).")
        
    # Get model order and evaluation metrics
    config_path = 'data/processed/arima_model_config.json'
    eval_path = 'data/reports/arima_evaluation_report.json'
    
    if os.path.exists(config_path) and os.path.exists(eval_path):
        with open(config_path, 'r', encoding='utf-8') as f:
            cfg = json.load(f)
            order = tuple(cfg['order'])
        with open(eval_path, 'r', encoding='utf-8') as f:
            eval_data = json.load(f)
            mae = eval_data['arima_metrics']['mae']
            rmse = eval_data['arima_metrics']['rmse']
            mape = eval_data['arima_metrics']['mape']
    else:
        order, _, cfg, _ = train_arima_model(train_df)
        eval_data = evaluate_arima(train_df)
        mae = eval_data['arima_metrics']['mae']
        rmse = eval_data['arima_metrics']['rmse']
        mape = eval_data['arima_metrics']['mape']
        
    print(f"[forecast_arima] Training ARIMA{order} on {len(ts)} historical periods ({train_periods[0]} to {train_periods[-1]})...")
    
    model = ARIMA(ts, order=order)
    model_fit = model.fit()
    
    # Forecast forward steps
    forecast_res = model_fit.get_forecast(steps=horizon)
    predicted_means = forecast_res.predicted_mean
    conf_int = forecast_res.conf_int(alpha=0.05) # 95% confidence interval
    
    # Generate future period labels (YYYY-MM)
    last_date = pd.to_datetime(train_df['date'].max())
    future_dates = [last_date + relativedelta(months=i) for i in range(1, horizon + 1)]
    future_periods = [d.strftime('%Y-%m') for d in future_dates]
    
    forecast_start = future_periods[0]
    forecast_end = future_periods[-1]
    
    # Calculate forecast summary
    total_predicted = float(np.sum(predicted_means))
    avg_monthly_predicted = float(np.mean(predicted_means))
    
    # Calculate baseline growth vs prior 12 months (or available training months)
    prior_sum = float(np.sum(ts[-horizon:])) if len(ts) >= horizon else float(np.sum(ts))
    growth_rate = round(((total_predicted - prior_sum) / prior_sum) * 100, 2) if prior_sum > 0 else 0.0
    
    print(f"[forecast_arima] Forecast generated for {forecast_start} to {forecast_end} ({horizon} months).")
    print(f"  Total Predicted Net GMV: Rp {total_predicted:,.0f}")
    print(f"  Avg Monthly Net GMV:    Rp {avg_monthly_predicted:,.0f}")
    print(f"  Growth Rate vs Prior:   {growth_rate:+.2f}%")
    print(f"  Model MAPE:             {mape:.2f}%")
    
    # Format forecast rows
    forecast_records = []
    for i in range(horizon):
        p_str = future_periods[i]
        p_date = future_dates[i].strftime('%Y-%m-%d')
        pred_val = float(max(0, predicted_means[i]))
        low_val = float(max(0, conf_int[i, 0]))
        up_val = float(max(pred_val, conf_int[i, 1]))
        act_val = float(future_actuals.get(p_str)) if p_str in future_actuals else None
        
        # Calculate YoY growth if prior year period exists
        prior_year_period = (future_dates[i] - relativedelta(years=1)).strftime('%Y-%m')
        prior_val = df[df['period'] == prior_year_period]['nilai_transaksi_netto_idr'].values
        yoy_growth = None
        if len(prior_val) > 0 and prior_val[0] > 0:
            yoy_growth = round(((pred_val - prior_val[0]) / prior_val[0]) * 100, 2)
            
        forecast_records.append({
            'period': p_str,
            'period_date': p_date,
            'actual_value': act_val,
            'predicted_value': pred_val,
            'lower_bound': low_val,
            'upper_bound': up_val,
            'growth_vs_prior_year_pct': yoy_growth
        })
        
    # Save to MySQL
    if save_to_db:
        conn = get_mysql_connection()
        cursor = conn.cursor(dictionary=True)
        try:
            # Set previously active runs to inactive
            cursor.execute("UPDATE forecast_runs SET is_active = 0 WHERE is_active = 1")
            
            # Insert new forecast run
            insert_run_sql = """
            INSERT INTO forecast_runs (
                model_name, model_order, training_start, training_end,
                forecast_start, forecast_end, horizon_months,
                total_predicted_idr, avg_monthly_predicted_idr, growth_rate_pct,
                mae, rmse, mape, aic, bic, training_status, parameters_json, is_active,
                created_at, updated_at
            ) VALUES (
                %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW(), NOW()
            )
            """
            params_json = json.dumps({
                'aic': float(model_fit.aic),
                'bic': float(model_fit.bic),
                'params': [float(x) for x in model_fit.params]
            })
            run_vals = (
                'ARIMA', f"ARIMA{order}", train_periods[0], train_periods[-1],
                forecast_start, forecast_end, horizon,
                total_predicted, avg_monthly_predicted, growth_rate,
                mae, rmse, mape, float(model_fit.aic), float(model_fit.bic),
                'completed', params_json, 1
            )
            cursor.execute(insert_run_sql, run_vals)
            run_id = cursor.lastrowid
            
            # Insert individual forecast periods
            insert_detail_sql = """
            INSERT INTO transaction_forecasts (
                forecast_run_id, period, period_date, actual_value,
                predicted_value, lower_bound, upper_bound,
                growth_vs_prior_year_pct, created_at, updated_at
            ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, NOW(), NOW())
            """
            for rec in forecast_records:
                cursor.execute(insert_detail_sql, (
                    run_id, rec['period'], rec['period_date'], rec['actual_value'],
                    rec['predicted_value'], rec['lower_bound'], rec['upper_bound'],
                    rec['growth_vs_prior_year_pct']
                ))
                
            conn.commit()
            print(f"[forecast_arima] Saved forecast run ID {run_id} with {len(forecast_records)} periods to MySQL.")
        except Exception as e:
            conn.rollback()
            print(f"[forecast_arima] Database insertion failed: {e}")
            raise e
        finally:
            cursor.close()
            conn.close()
            
    # Also save to JSON file
    out_file = 'data/reports/latest_forecast_output.json'
    with open(out_file, 'w', encoding='utf-8') as f:
        json.dump({
            'model_name': f"ARIMA{order}",
            'training_start': train_periods[0],
            'training_end': train_periods[-1],
            'forecast_start': forecast_start,
            'forecast_end': forecast_end,
            'horizon_months': horizon,
            'total_predicted_idr': total_predicted,
            'avg_monthly_predicted_idr': avg_monthly_predicted,
            'growth_rate_pct': growth_rate,
            'mape': mape,
            'forecast_records': forecast_records
        }, f, indent=4)
        
    return forecast_records

if __name__ == '__main__':
    parser = argparse.ArgumentParser(description="ARIMA Transaction Value Forecast")
    parser.add_argument('--horizon', type=int, default=12, help="Forecast horizon in months")
    parser.add_argument('--train-cutoff', type=str, default=None, help="Optional train cutoff period (e.g. 2024-12)")
    args = parser.parse_args()
    
    generate_forecast(horizon=args.horizon, train_cutoff=args.train_cutoff, save_to_db=True)
