import os
import json
import pandas as pd
import numpy as np
from statsmodels.tsa.stattools import adfuller
from aggregate_transactions import aggregate_monthly_transactions

def validate_timeseries(df=None):
    """
    Validate the monthly e-commerce time series data for ARIMA suitability:
    - Continuity of periods (detect any gaps in months)
    - Observation count requirements
    - Missing values and invalid (negative/null) values
    - Outliers (IQR method)
    - Stationarity check using Augmented Dickey-Fuller (ADF) Test
    - Generates feasibility report in Markdown and JSON.
    """
    if df is None:
        df = aggregate_monthly_transactions(save_to_file=False)
        
    report = {
        'total_observations': len(df),
        'start_period': df['period'].min(),
        'end_period': df['period'].max(),
        'target_column': 'nilai_transaksi_netto_idr',
        'checks': {},
        'stationarity': {},
        'is_feasible': True,
        'recommendation': ''
    }
    
    # 1. Check Missing Values & Invalid Values
    null_count = int(df['nilai_transaksi_netto_idr'].isnull().sum())
    neg_count = int((df['nilai_transaksi_netto_idr'] < 0).sum())
    zero_count = int((df['nilai_transaksi_netto_idr'] == 0).sum())
    
    report['checks']['missing_values'] = null_count
    report['checks']['negative_values'] = neg_count
    report['checks']['zero_values'] = zero_count
    
    if null_count > 0 or neg_count > 0:
        report['is_feasible'] = False
        report['checks']['validity_status'] = 'FAIL: Terdapat nilai null atau negatif.'
    else:
        report['checks']['validity_status'] = 'PASS: Tidak ada nilai null atau negatif.'
        
    # 2. Check Temporal Continuity (Gap Detection)
    date_range = pd.date_range(start=df['date'].min(), end=df['date'].max(), freq='MS')
    expected_periods = len(date_range)
    actual_periods = len(df)
    missing_dates = set(date_range) - set(df['date'])
    
    report['checks']['expected_periods'] = expected_periods
    report['checks']['actual_periods'] = actual_periods
    report['checks']['has_period_gaps'] = len(missing_dates) > 0
    report['checks']['missing_dates'] = [d.strftime('%Y-%m') for d in missing_dates]
    
    if len(missing_dates) > 0:
        report['is_feasible'] = False
        report['checks']['continuity_status'] = f'FAIL: Terdapat {len(missing_dates)} periode yang hilang: {report["checks"]["missing_dates"]}'
    else:
        report['checks']['continuity_status'] = 'PASS: Seluruh periode berurutan secara kontinu tanpa gap.'
        
    # 3. Check Observation Sample Size
    # Box-Jenkins generally recommends at least 24-30 observations for ARIMA
    report['checks']['sample_size_adequate'] = actual_periods >= 24
    if actual_periods < 24:
        report['is_feasible'] = False
        report['checks']['sample_size_status'] = f'WARNING/FAIL: Jumlah observasi ({actual_periods}) di bawah ambang batas ideal (24 bulan).'
    else:
        report['checks']['sample_size_status'] = f'PASS: Jumlah observasi ({actual_periods} bulan) mencukupi untuk pemodelan deret waktu bulanan.'
        
    # 4. Outlier Analysis (IQR Method)
    q1 = df['nilai_transaksi_netto_idr'].quantile(0.25)
    q3 = df['nilai_transaksi_netto_idr'].quantile(0.75)
    iqr = q3 - q1
    lower_bound = q1 - 1.5 * iqr
    upper_bound = q3 + 1.5 * iqr
    outliers = df[(df['nilai_transaksi_netto_idr'] < lower_bound) | (df['nilai_transaksi_netto_idr'] > upper_bound)]
    report['checks']['outlier_count'] = len(outliers)
    report['checks']['outlier_periods'] = outliers['period'].tolist()
    
    # 5. Stationarity Test: Augmented Dickey-Fuller (ADF)
    ts = df['nilai_transaksi_netto_idr'].values
    adf_result = adfuller(ts, autolag='AIC')
    adf_statistic = float(adf_result[0])
    p_value = float(adf_result[1])
    critical_values = {k: float(v) for k, v in adf_result[4].items()}
    
    is_stationary = p_value < 0.05
    report['stationarity']['raw_series'] = {
        'adf_statistic': adf_statistic,
        'p_value': p_value,
        'critical_values': critical_values,
        'is_stationary': is_stationary,
        'conclusion': 'Stasioner (p < 0.05)' if is_stationary else 'Non-stasioner (perlu differencing d>=1)'
    }
    
    # Check 1st Difference if non-stationary
    diff_ts = np.diff(ts)
    adf_diff = adfuller(diff_ts, autolag='AIC')
    is_diff_stationary = float(adf_diff[1]) < 0.05
    report['stationarity']['first_difference'] = {
        'adf_statistic': float(adf_diff[0]),
        'p_value': float(adf_diff[1]),
        'critical_values': {k: float(v) for k, v in adf_diff[4].items()},
        'is_stationary': is_diff_stationary,
        'conclusion': 'Stasioner pada first difference (d=1)' if is_diff_stationary else 'Perlu differencing order lebih tinggi'
    }
    
    # Overall recommendation
    if report['is_feasible']:
        diff_order = 0 if is_stationary else 1
        report['recommendation'] = f"Data deret waktu layak untuk ARIMA. Differencing yang direkomendasikan adalah d={diff_order}."
    else:
        report['recommendation'] = "Data tidak memenuhi syarat kelayakan ARIMA bulanan."
        
    # Write Markdown & JSON reports
    os.makedirs('data/reports', exist_ok=True)
    json_path = 'data/reports/timeseries_feasibility_report.json'
    md_path = 'data/reports/timeseries_feasibility_report.md'
    
    with open(json_path, 'w', encoding='utf-8') as f:
        json.dump(report, f, indent=4)
        
    md_content = f"""# Laporan Kelayakan Deret Waktu (Time Series Feasibility Report)
**Tanggal Audit:** {pd.Timestamp.now().strftime('%Y-%m-%d %H:%M:%S')}  
**Target Prediksi:** `{report['target_column']}` (Total Nilai Transaksi Netto Bulanan IDR)  

## 1. Ringkasan Observasi
- **Total Observasi:** {report['total_observations']} periode bulanan
- **Rentang Periode:** {report['start_period']} s.d. {report['end_period']}
- **Kelayakan Model:** **{'LAYAK (FEASIBLE)' if report['is_feasible'] else 'TIDAK LAYAK'}**

## 2. Pemeriksaan Kualitas & Kontinuitas
| Item Pemeriksaan | Hasil | Status |
| :--- | :--- | :--- |
| Missing Values | {report['checks']['missing_values']} | {report['checks']['validity_status']} |
| Nilai Negatif / Tidak Valid | {report['checks']['negative_values']} | {report['checks']['validity_status']} |
| Kontinuitas Periode | {report['checks']['actual_periods']}/{report['checks']['expected_periods']} bulan | {report['checks']['continuity_status']} |
| Kecukupan Sampel | {report['checks']['actual_periods']} bulan | {report['checks']['sample_size_status']} |
| Deteksi Outlier (IQR) | {report['checks']['outlier_count']} observasi | {', '.join(report['checks']['outlier_periods']) if report['checks']['outlier_periods'] else 'Tidak ada outlier ekstrem'} |

## 3. Uji Stasioneritas (Augmented Dickey-Fuller)
- **Deret Asli (Level, d=0):**
  - ADF Statistic: {report['stationarity']['raw_series']['adf_statistic']:.4f}
  - p-value: {report['stationarity']['raw_series']['p_value']:.4f}
  - Kesimpulan: {report['stationarity']['raw_series']['conclusion']}
- **First Difference (d=1):**
  - ADF Statistic: {report['stationarity']['first_difference']['adf_statistic']:.4f}
  - p-value: {report['stationarity']['first_difference']['p_value']:.4f}
  - Kesimpulan: {report['stationarity']['first_difference']['conclusion']}

## 4. Kesimpulan & Rekomendasi
{report['recommendation']}
"""
    with open(md_path, 'w', encoding='utf-8') as f:
        f.write(md_content)
        
    print(f"[validate_timeseries] Report generated at {json_path} and {md_path}")
    return report

if __name__ == '__main__':
    rep = validate_timeseries()
    print("\n--- Feasibility Result ---")
    print(f"Feasible: {rep['is_feasible']}")
    print(f"Recommendation: {rep['recommendation']}")
