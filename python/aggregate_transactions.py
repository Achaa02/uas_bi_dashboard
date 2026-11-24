import os
import pandas as pd
from database import get_db_engine

def aggregate_monthly_transactions(save_to_file=True):
    """
    Extract and aggregate e-commerce transactions on a monthly frequency.
    Aggregates 'nilai_transaksi_netto_idr' and associated metrics from fact_ecommerce_bulanan.
    
    Formula:
    Monthly Net GMV = SUM(total_netto_idr) for each year-month period.
    """
    engine = get_db_engine()
    
    query = """
    SELECT 
        tahun_bulan as period,
        tahun,
        bulan,
        SUM(total_transaksi) as total_transaksi,
        SUM(total_kuantitas) as total_kuantitas,
        SUM(total_bruto_idr) as total_bruto_idr,
        SUM(total_diskon_voucher_idr) as total_diskon_voucher_idr,
        SUM(total_ongkir_riil_idr) as total_ongkir_riil_idr,
        SUM(total_subsidi_ongkir_idr) as total_subsidi_ongkir_idr,
        SUM(total_netto_idr) as nilai_transaksi_netto_idr
    FROM fact_ecommerce_bulanan
    GROUP BY tahun_bulan, tahun, bulan
    ORDER BY tahun_bulan ASC
    """
    
    df = pd.read_sql(query, engine)
    
    # Format period to standard datetime (first day of month)
    df['date'] = pd.to_datetime(df['period'] + '-01')
    df['nilai_transaksi_netto_idr'] = df['nilai_transaksi_netto_idr'].astype(float)
    df['total_transaksi'] = df['total_transaksi'].astype(int)
    
    # Sort chronologically
    df = df.sort_values('date').reset_index(drop=True)
    
    if save_to_file:
        os.makedirs('data/processed', exist_ok=True)
        csv_path = 'data/processed/ecommerce_monthly_timeseries.csv'
        parquet_path = 'data/processed/ecommerce_monthly_timeseries.parquet'
        df.to_csv(csv_path, index=False)
        df.to_parquet(parquet_path, index=False)
        print(f"[aggregate_transactions] Successfully aggregated {len(df)} monthly periods.")
        print(f"[aggregate_transactions] Saved to {csv_path} & {parquet_path}")
        
    return df

if __name__ == '__main__':
    df = aggregate_monthly_transactions(save_to_file=True)
    print("\nSummary of Monthly Aggregation:")
    print(df[['period', 'total_transaksi', 'nilai_transaksi_netto_idr']].head())
    print("...")
    print(df[['period', 'total_transaksi', 'nilai_transaksi_netto_idr']].tail())
