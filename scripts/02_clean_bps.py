import os
import re
import pandas as pd
import numpy as np
from geo_reference import PROVINCES_INDONESIA, clean_province_name

BPS_PROVINCE_REF = PROVINCES_INDONESIA

def parse_bps_number(val):
    if pd.isna(val) or val is None:
        return np.nan
    s = str(val).strip().replace(' ', '').replace('\xa0', '').replace(',', '.')
    if s == '' or s == '-' or s == '...' or 'data' in s.lower():
        return np.nan
    try:
        return float(s)
    except ValueError:
        return np.nan

def clean_bps_data():
    os.makedirs('data/cleaned', exist_ok=True)
    os.makedirs('data/reports', exist_ok=True)
    
    print("Loading and cleaning BPS raw files...")
    
    # 1. Parse BPS 2011-2025 raw csv
    raw_path = 'data/raw/bps_pengeluaran_2011_2025.csv'
    with open(raw_path, 'r', encoding='utf-8') as f:
        lines = [line.rstrip('\r\n') for line in f]
        
    # Line index 2 (line 3): "Provinsi,Makanan,,,,,,,,,,,,,,,Bukan makanan,,,,,,,,,,,,,,,Jumlah,,,,,,,,,,,,,,,,"
    # Line index 3 (line 4): ",2011,2012,...,2025,2011,2012,...,2025,2011,2012,...,2025"
    years = [str(y) for y in range(2011, 2026)] # 15 years
    
    records = []
    for line in lines[4:]:
        parts = [p.strip() for p in line.split(',')]
        if not parts or not parts[0]:
            continue
            
        raw_prov = parts[0]
        prov = clean_province_name(raw_prov)
        
        # Stop at footnotes or summary
        if prov in ["Indonesia", "Catatan", "Sumber"] or "Data masih" in raw_prov or raw_prov.startswith('"'):
            continue
            
        if prov not in BPS_PROVINCE_REF:
            continue
            
        meta = BPS_PROVINCE_REF[prov]
        
        # Slices:
        # Col 0: Prov
        # Col 1..15: Makanan 2011-2025 (len 15)
        # Col 16..30: Non-Makanan 2011-2025 (len 15)
        # Col 31..45: Jumlah 2011-2025 (len 15)
        makanan_vals = parts[1:16]
        non_makanan_vals = parts[16:31]
        jumlah_vals = parts[31:46]
        
        for idx, yr in enumerate(years):
            m_val = parse_bps_number(makanan_vals[idx]) if idx < len(makanan_vals) else np.nan
            nm_val = parse_bps_number(non_makanan_vals[idx]) if idx < len(non_makanan_vals) else np.nan
            tot_val = parse_bps_number(jumlah_vals[idx]) if idx < len(jumlah_vals) else np.nan
            
            # Recalculate or fill if total is missing
            if np.isnan(tot_val) and not np.isnan(m_val) and not np.isnan(nm_val):
                tot_val = m_val + nm_val
            elif not np.isnan(tot_val) and np.isnan(m_val) and not np.isnan(nm_val):
                m_val = tot_val - nm_val
            elif not np.isnan(tot_val) and not np.isnan(m_val) and np.isnan(nm_val):
                nm_val = tot_val - m_val
                
            pct_m = (m_val / tot_val * 100.0) if (tot_val and tot_val > 0) else np.nan
            pct_nm = (nm_val / tot_val * 100.0) if (tot_val and tot_val > 0) else np.nan
            
            records.append({
                "provinsi": prov,
                "kode_bps": meta["kode_bps"],
                "pulau": meta["pulau"],
                "tahun": int(yr),
                "pengeluaran_makanan_idr": m_val,
                "pengeluaran_non_makanan_idr": nm_val,
                "total_pengeluaran_idr": tot_val,
                "persentase_makanan": round(pct_m, 2) if not np.isnan(pct_m) else None,
                "persentase_non_makanan": round(pct_nm, 2) if not np.isnan(pct_nm) else None
            })
            
    df_panel = pd.DataFrame(records)
    
    # 2. Integrate official 2024 & 2025 persentase files if present
    for yr, p_path in [(2024, 'data/raw/bps_persentase_pengeluaran_2024.csv'), (2025, 'data/raw/bps_persentase_pengeluaran_2025.csv')]:
        if os.path.exists(p_path):
            df_pct = pd.read_csv(p_path)
            col_m = [c for c in df_pct.columns if 'Makanan' in c and 'Bukan' not in c][0]
            col_nm = [c for c in df_pct.columns if 'Bukan Makanan' in c][0]
            
            for _, r in df_pct.iterrows():
                p_clean = clean_province_name(r['Provinsi'])
                if p_clean in BPS_PROVINCE_REF:
                    mask = (df_panel['provinsi'] == p_clean) & (df_panel['tahun'] == yr)
                    if mask.any():
                        df_panel.loc[mask, 'persentase_makanan'] = round(float(r[col_m]), 2)
                        df_panel.loc[mask, 'persentase_non_makanan'] = round(float(r[col_nm]), 2)
                        
    # Sort cleanly
    df_panel.sort_values(by=['kode_bps', 'tahun'], inplace=True)
    df_panel.reset_index(drop=True, inplace=True)
    
    # Save cleaned files
    out_csv = 'data/cleaned/cleaned_bps_pengeluaran_panel.csv'
    out_parquet = 'data/cleaned/cleaned_bps_pengeluaran_panel.parquet'
    
    df_panel.to_csv(out_csv, index=False, encoding='utf-8')
    df_panel.to_parquet(out_parquet, index=False)
    
    print(f"Cleaned BPS Panel saved: {out_csv} ({len(df_panel)} records across {df_panel['provinsi'].nunique()} provinces)")
    
    # Generate audit report
    audit_md = 'data/reports/bps_cleaning_audit.md'
    with open(audit_md, 'w', encoding='utf-8') as f:
        f.write("# Laporan Audit Pembersihan Data BPS (BPS Cleaning Audit)\n\n")
        f.write(f"- **Total Observasi**: {len(df_panel)} baris panel (Provinsi-Tahun)\n")
        f.write(f"- **Cakupan Wilayah**: {df_panel['provinsi'].nunique()} Provinsi (38 Provinsi BPS)\n")
        f.write(f"- **Rentang Periode**: {df_panel['tahun'].min()} s.d. {df_panel['tahun'].max()}\n\n")
        f.write("## Ringkasan Agregat Nasional (Rata-rata 2024–2025)\n\n")
        recent = df_panel[df_panel['tahun'].isin([2024, 2025])].groupby('tahun').agg({
            'pengeluaran_makanan_idr': 'mean',
            'pengeluaran_non_makanan_idr': 'mean',
            'total_pengeluaran_idr': 'mean',
            'persentase_makanan': 'mean',
            'persentase_non_makanan': 'mean'
        }).reset_index()
        
        f.write("| Tahun | Rata-rata Makanan (Rp) | Rata-rata Non-Makanan (Rp) | Rata-rata Total Pengeluaran (Rp) | % Makanan | % Non-Makanan |\n")
        f.write("| :--- | :--- | :--- | :--- | :--- | :--- |\n")
        for _, r in recent.iterrows():
            f.write(f"| {int(r['tahun'])} | Rp {r['pengeluaran_makanan_idr']:,.0f} | Rp {r['pengeluaran_non_makanan_idr']:,.0f} | Rp {r['total_pengeluaran_idr']:,.0f} | {r['persentase_makanan']:.2f}% | {r['persentase_non_makanan']:.2f}% |\n")
            
        f.write("\n## Catatan Transformasi:\n")
        f.write("1. Spasi ribuan pada data mentah BPS telah dikonversi ke numerik standar.\n")
        f.write("2. Nama provinsi dengan anotasi catatan kaki (misal `Kalimantan Utara 1)`) telah dinormalisasi.\n")
        f.write("3. Wilayah diklasifikasikan ke dalam 6 gugus pulau utama di Indonesia.\n")
        f.write("4. Kode BPS resmi 2-digit disematkan untuk menjamin kompatibilitas relasional.\n")
        
    print(f"BPS Audit Report written to {audit_md}")

if __name__ == '__main__':
    clean_bps_data()
