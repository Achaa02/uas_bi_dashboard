import os
import json
import warnings
import pandas as pd
import numpy as np
from statsmodels.tsa.arima.model import ARIMA
from aggregate_transactions import aggregate_monthly_transactions
from validate_timeseries import validate_timeseries

warnings.filterwarnings('ignore')

def grid_search_arima(ts, p_values=range(0, 4), d_values=(0, 1), q_values=range(0, 4)):
    """
    Perform rigorous grid search over ARIMA(p,d,q) orders using AIC and BIC.
    Ensures model parameters are selected based on empirical quantitative evidence.
    """
    best_aic = float('inf')
    best_bic = float('inf')
    best_order = None
    best_model_fit = None
    grid_results = []
    
    for d in d_values:
        for p in p_values:
            for q in q_values:
                # Skip (0,0,0) trivial model
                if p == 0 and d == 0 and q == 0:
                    continue
                try:
                    model = ARIMA(ts, order=(p, d, q))
                    fit = model.fit()
                    aic = float(fit.aic)
                    bic = float(fit.bic)
                    grid_results.append({
                        'p': p, 'd': d, 'q': q,
                        'order': f"({p},{d},{q})",
                        'aic': aic,
                        'bic': bic,
                        'converged': bool(fit.mle_retvals.get('converged', True))
                    })
                    if aic < best_aic:
                        best_aic = aic
                        best_bic = bic
                        best_order = (p, d, q)
                        best_model_fit = fit
                except Exception as e:
                    continue
                    
    # Sort grid results by AIC ascending
    grid_results.sort(key=lambda x: x['aic'])
    return best_order, best_model_fit, grid_results

def train_arima_model(df=None):
    """
    Train ARIMA model on monthly e-commerce net transactions.
    """
    if df is None:
        df = aggregate_monthly_transactions(save_to_file=False)
        
    # Validate series first
    val_report = validate_timeseries(df)
    if not val_report['is_feasible']:
        raise ValueError(f"Time series validation failed: {val_report['recommendation']}")
        
    ts = df['nilai_transaksi_netto_idr'].values
    periods = df['period'].tolist()
    
    print("[train_arima] Starting Grid Search for optimal ARIMA(p, d, q)...")
    best_order, best_fit, grid_results = grid_search_arima(ts)
    print(f"[train_arima] Best model identified: ARIMA{best_order} with AIC: {best_fit.aic:.2f}, BIC: {best_fit.bic:.2f}")
    
    # Save training configuration and parameters
    # Extract params as list or dict
    params_list = [float(x) for x in best_fit.params]
    param_names = list(best_fit.param_names) if hasattr(best_fit, 'param_names') else [f"p_{i}" for i in range(len(params_list))]
    params_dict = dict(zip(param_names, params_list))

    model_config = {
        'model_name': 'ARIMA',
        'order': list(best_order),
        'order_str': f"ARIMA{best_order}",
        'training_start': periods[0],
        'training_end': periods[-1],
        'total_observations': len(ts),
        'aic': float(best_fit.aic),
        'bic': float(best_fit.bic),
        'hqic': float(best_fit.hqic) if hasattr(best_fit, 'hqic') else None,
        'sigma2': float(params_dict.get('sigma2', params_list[-1] if params_list else 0)),
        'parameters': params_dict,
        'top_5_tested_models': grid_results[:5]
    }
    
    os.makedirs('data/processed', exist_ok=True)
    config_path = 'data/processed/arima_model_config.json'
    with open(config_path, 'w', encoding='utf-8') as f:
        json.dump(model_config, f, indent=4)
        
    print(f"[train_arima] Model configuration saved to {config_path}")
    return best_order, best_fit, model_config, df

if __name__ == '__main__':
    best_order, best_fit, config, df = train_arima_model()
    print("\nTop 5 Evaluated Models by AIC:")
    for m in config['top_5_tested_models']:
        print(f"  {m['order']} -> AIC: {m['aic']:.2f}, BIC: {m['bic']:.2f}")
