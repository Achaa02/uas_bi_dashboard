import os
import pyarrow.parquet as pq
import pandas as pd
import numpy as np
from geo_reference import PROVINCES_INDONESIA, clean_province_name

def run_integration():
    os.makedirs('data/processed', exist_ok=True)
    os.makedirs('data/reports', exist_ok=True)
    
    print("=" * 60)
    print("STARTING BIG DATA ETL: AGGREGATION & MULTI-SOURCE INTEGRATION")
    print("=" * 60)
    
    # 1. Load Cleaned BPS Panel
    bps_path = 'data/cleaned/cleaned_bps_pengeluaran_panel.csv'
    if not os.path.exists(bps_path):
        raise FileNotFoundError(f"Cleaned BPS panel not found at {bps_path}. Run 02_clean_bps.py first.")
    df_bps = pd.read_csv(bps_path)
    print(f"Loaded Cleaned BPS panel: {len(df_bps)} rows (Years: {df_bps['tahun'].min()} - {df_bps['tahun'].max()})")
    
    # 2. Stream Parquet 5M rows and aggregate by (provinsi, tahun, bulan, platform, kategori)
    raw_parquet_path = 'data/raw/big_data_ecommerce_5juta.parquet'
    pf = pq.ParquetFile(raw_parquet_path)
    
    print(f"Streaming {pf.metadata.num_rows:,} rows across {pf.num_row_groups} row groups...")
    
    # Accumulators for monthly aggregation
    agg_chunks = []
    sample_records = []
    
    cols_to_read = [
        'order_id', 'transaksi_id', 'kategori_produk', 'platform_ecommerce',
        'provinsi_penjual', 'provinsi_pembeli', 'wilayah_pengiriman',
        'nilai_transaksi_bruto_idr', 'diskon_voucher_platform_idr',
        'ongkos_kirim_riil_idr', 'subsidi_gratis_ongkir_idr', 'nilai_transaksi_netto_idr',
        'metode_pembayaran', 'layanan_ekspedisi', 'durasi_pengiriman_hari',
        'status_keterlambatan_pengiriman', 'rating_produk', 'status_repeat_order',
        'usia_pembeli', 'gender_pembeli', 'timestamp_transaksi',
        'indeks_sensitivitas_ongkir', 'skor_loyalitas_pelanggan', 'kategori_risiko_churn',
        'rasio_efektivitas_diskon', 'jumlah_beli', 'harga_produk', 'total_belanja'
    ]
    
    # Collect 10,000 samples per row group = 50,000 real samples total for drilldown
    sample_size_per_rg = 10000
    
    for rg_idx in range(pf.num_row_groups):
        print(f"Reading Row Group {rg_idx + 1}/{pf.num_row_groups}...")
        df_chunk = pf.read_row_group(rg_idx, columns=cols_to_read).to_pandas()
        
        # Standardize buyer province
        df_chunk['provinsi_pembeli'] = df_chunk['provinsi_pembeli'].apply(clean_province_name)
        df_chunk['provinsi_penjual'] = df_chunk['provinsi_penjual'].apply(clean_province_name)
        
        # Add BPS code
        df_chunk['kode_bps'] = df_chunk['provinsi_pembeli'].apply(lambda p: PROVINCES_INDONESIA.get(p, {}).get('kode_bps', '00'))
        
        # Parse timestamp
        dt = pd.to_datetime(df_chunk['timestamp_transaksi'], errors='coerce')
        df_chunk['tahun'] = dt.dt.year
        df_chunk['bulan'] = dt.dt.month
        df_chunk['tahun_bulan'] = dt.dt.strftime('%Y-%m')
        
        # Indicator flags for fast aggregation
        df_chunk['is_repeat'] = (df_chunk['status_repeat_order'] == 'Ya').astype(int)
        df_chunk['is_tepat_waktu'] = (df_chunk['status_keterlambatan_pengiriman'] == 'Tepat Waktu').astype(int)
        df_chunk['is_churn_tinggi'] = (df_chunk['kategori_risiko_churn'] == 'Tinggi').astype(int)
        
        # Aggregate chunk
        grouped = df_chunk.groupby(['kode_bps', 'provinsi_pembeli', 'tahun', 'bulan', 'tahun_bulan', 'platform_ecommerce', 'kategori_produk']).agg(
            total_transaksi=('order_id', 'count'),
            total_kuantitas=('jumlah_beli', 'sum'),
            total_bruto_idr=('nilai_transaksi_bruto_idr', 'sum'),
            total_diskon_voucher_idr=('diskon_voucher_platform_idr', 'sum'),
            total_ongkir_riil_idr=('ongkos_kirim_riil_idr', 'sum'),
            total_subsidi_ongkir_idr=('subsidi_gratis_ongkir_idr', 'sum'),
            total_netto_idr=('nilai_transaksi_netto_idr', 'sum'),
            rating_sum=('rating_produk', 'sum'),
            repeat_count=('is_repeat', 'sum'),
            tepat_waktu_count=('is_tepat_waktu', 'sum'),
            durasi_hari_sum=('durasi_pengiriman_hari', 'sum'),
            sensitivitas_ongkir_sum=('indeks_sensitivitas_ongkir', 'sum'),
            loyalitas_sum=('skor_loyalitas_pelanggan', 'sum'),
            churn_tinggi_count=('is_churn_tinggi', 'sum')
        ).reset_index()
        
        agg_chunks.append(grouped)
        
        # Sample extraction (10k per group)
        step = max(1, len(df_chunk) // sample_size_per_rg)
        sample_subset = df_chunk.iloc[::step].head(sample_size_per_rg).copy()
        sample_records.append(sample_subset)
        
    print("Combining chunk aggregations...")
    all_aggs = pd.concat(agg_chunks, ignore_index=True)
    
    # Group again across chunks
    fact_ecom_monthly = all_aggs.groupby(['kode_bps', 'provinsi_pembeli', 'tahun', 'bulan', 'tahun_bulan', 'platform_ecommerce', 'kategori_produk']).agg(
        total_transaksi=('total_transaksi', 'sum'),
        total_kuantitas=('total_kuantitas', 'sum'),
        total_bruto_idr=('total_bruto_idr', 'sum'),
        total_diskon_voucher_idr=('total_diskon_voucher_idr', 'sum'),
        total_ongkir_riil_idr=('total_ongkir_riil_idr', 'sum'),
        total_subsidi_ongkir_idr=('total_subsidi_ongkir_idr', 'sum'),
        total_netto_idr=('total_netto_idr', 'sum'),
        rating_sum=('rating_sum', 'sum'),
        repeat_count=('repeat_count', 'sum'),
        tepat_waktu_count=('tepat_waktu_count', 'sum'),
        durasi_hari_sum=('durasi_hari_sum', 'sum'),
        sensitivitas_ongkir_sum=('sensitivitas_ongkir_sum', 'sum'),
        loyalitas_sum=('loyalitas_sum', 'sum'),
        churn_tinggi_count=('churn_tinggi_count', 'sum')
    ).reset_index()
    
    # Calculate weighted averages
    fact_ecom_monthly['avg_nilai_transaksi'] = (fact_ecom_monthly['total_netto_idr'] / fact_ecom_monthly['total_transaksi']).round(2)
    fact_ecom_monthly['avg_rating'] = (fact_ecom_monthly['rating_sum'] / fact_ecom_monthly['total_transaksi']).round(2)
    fact_ecom_monthly['persentase_repeat_order'] = ((fact_ecom_monthly['repeat_count'] / fact_ecom_monthly['total_transaksi']) * 100).round(2)
    fact_ecom_monthly['persentase_tepat_waktu'] = ((fact_ecom_monthly['tepat_waktu_count'] / fact_ecom_monthly['total_transaksi']) * 100).round(2)
    fact_ecom_monthly['avg_durasi_hari'] = (fact_ecom_monthly['durasi_hari_sum'] / fact_ecom_monthly['total_transaksi']).round(2)
    fact_ecom_monthly['avg_sensitivitas_ongkir'] = (fact_ecom_monthly['sensitivitas_ongkir_sum'] / fact_ecom_monthly['total_transaksi']).round(4)
    fact_ecom_monthly['avg_skor_loyalitas'] = (fact_ecom_monthly['loyalitas_sum'] / fact_ecom_monthly['total_transaksi']).round(4)
    fact_ecom_monthly['persentase_churn_tinggi'] = ((fact_ecom_monthly['churn_tinggi_count'] / fact_ecom_monthly['total_transaksi']) * 100).round(2)
    
    # Drop intermediate sum columns
    fact_ecom_monthly.drop(columns=['rating_sum', 'repeat_count', 'tepat_waktu_count', 'durasi_hari_sum', 'sensitivitas_ongkir_sum', 'loyalitas_sum', 'churn_tinggi_count'], inplace=True)
    fact_ecom_monthly.rename(columns={'provinsi_pembeli': 'provinsi'}, inplace=True)
    
    # Save fact_ecommerce_bulanan
    fact_ecom_monthly_path = 'data/processed/fact_ecommerce_bulanan.csv'
    fact_ecom_monthly.to_csv(fact_ecom_monthly_path, index=False, encoding='utf-8')
    fact_ecom_monthly.to_parquet('data/processed/fact_ecommerce_bulanan.parquet', index=False)
    print(f"Saved {fact_ecom_monthly_path} ({len(fact_ecom_monthly):,} rows)")
    
    # 3. Create Sample 50k Real Transactions Table
    print("Assembling 50,000 real sample transaction table...")
    df_sample_50k = pd.concat(sample_records, ignore_index=True)
    df_sample_50k.rename(columns={'provinsi_pembeli': 'provinsi'}, inplace=True)
    df_sample_50k.to_csv('data/processed/sample_transaksi_50k.csv', index=False, encoding='utf-8')
    df_sample_50k.to_parquet('data/processed/sample_transaksi_50k.parquet', index=False)
    print(f"Saved 50k Sample Table ({len(df_sample_50k)} records)")
    
    # 4. Create Dimension Tables
    print("Building Dimension Tables...")
    # dim_wilayah
    dim_wilayah_rows = []
    for prov_name, meta in PROVINCES_INDONESIA.items():
        dim_wilayah_rows.append({
            "kode_bps": meta["kode_bps"],
            "nama_provinsi": prov_name,
            "pulau": meta["pulau"],
            "latitude": meta["lat"],
            "longitude": meta["lng"]
        })
    dim_wilayah = pd.DataFrame(dim_wilayah_rows).sort_values('kode_bps').reset_index(drop=True)
    dim_wilayah.to_csv('data/processed/dim_wilayah.csv', index=False, encoding='utf-8')
    
    # dim_kategori
    categories = sorted(list(fact_ecom_monthly['kategori_produk'].unique()))
    dim_kategori = pd.DataFrame([{"kategori_id": idx + 1, "nama_kategori": cat} for idx, cat in enumerate(categories)])
    dim_kategori.to_csv('data/processed/dim_kategori.csv', index=False, encoding='utf-8')
    
    # dim_platform
    platforms = sorted(list(fact_ecom_monthly['platform_ecommerce'].unique()))
    dim_platform = pd.DataFrame([{"platform_id": idx + 1, "nama_platform": plat} for idx, plat in enumerate(platforms)])
    dim_platform.to_csv('data/processed/dim_platform.csv', index=False, encoding='utf-8')
    
    # dim_waktu
    waktu_unique = fact_ecom_monthly[['tahun', 'bulan', 'tahun_bulan']].drop_duplicates().sort_values(['tahun', 'bulan']).reset_index(drop=True)
    waktu_unique['kuartal'] = waktu_unique['bulan'].apply(lambda m: f"Q{(m-1)//3 + 1}")
    waktu_unique['waktu_id'] = range(1, len(waktu_unique) + 1)
    dim_waktu = waktu_unique[['waktu_id', 'tahun', 'bulan', 'tahun_bulan', 'kuartal']]
    dim_waktu.to_csv('data/processed/dim_waktu.csv', index=False, encoding='utf-8')
    
    # 5. Create Fact BPS Ekonomi
    dim_wilayah_map = {r['nama_provinsi']: r['kode_bps'] for _, r in dim_wilayah.iterrows()}
    df_bps['kode_bps'] = df_bps['provinsi'].map(dim_wilayah_map)
    df_bps.to_csv('data/processed/fact_bps_ekonomi.csv', index=False, encoding='utf-8')
    df_bps.to_parquet('data/processed/fact_bps_ekonomi.parquet', index=False)
    
    # 6. Build Integrated Research Panel (fact_integrasi_daya_beli)
    print("Synthesizing Harmonized fact_integrasi_daya_beli panel...")
    # E-Commerce Annual Provincial Aggregation
    ecom_annual = fact_ecom_monthly.groupby(['provinsi', 'kode_bps', 'tahun']).agg(
        ecom_total_transaksi=('total_transaksi', 'sum'),
        ecom_total_kuantitas=('total_kuantitas', 'sum'),
        ecom_total_bruto_idr=('total_bruto_idr', 'sum'),
        ecom_total_diskon_voucher_idr=('total_diskon_voucher_idr', 'sum'),
        ecom_total_ongkir_riil_idr=('total_ongkir_riil_idr', 'sum'),
        ecom_total_subsidi_ongkir_idr=('total_subsidi_ongkir_idr', 'sum'),
        ecom_total_netto_idr=('total_netto_idr', 'sum'),
        avg_rating=('avg_rating', 'mean'),
        persentase_repeat_order=('persentase_repeat_order', 'mean'),
        avg_durasi_hari=('avg_durasi_hari', 'mean'),
        avg_sensitivitas_ongkir=('avg_sensitivitas_ongkir', 'mean'),
        avg_skor_loyalitas=('avg_skor_loyalitas', 'mean')
    ).reset_index()
    
    ecom_annual['ecom_aov_idr'] = (ecom_annual['ecom_total_netto_idr'] / ecom_annual['ecom_total_transaksi']).round(2)
    
    # Merge with BPS (for overlapping years: 2024, 2025; and project 2026 BPS trend if needed)
    # Let's project 2026 BPS by province using average growth rate 2023->2025
    bps_projections = []
    for prov in PROVINCES_INDONESIA.keys():
        sub = df_bps[df_bps['provinsi'] == prov].sort_values('tahun')
        row_2024 = sub[sub['tahun'] == 2024]
        row_2025 = sub[sub['tahun'] == 2025]
        if not row_2025.empty and not row_2024.empty:
            growth = (row_2025['total_pengeluaran_idr'].values[0] / row_2024['total_pengeluaran_idr'].values[0]) - 1.0
            tot_26 = row_2025['total_pengeluaran_idr'].values[0] * (1.0 + growth)
            pct_nm_26 = row_2025['persentase_non_makanan'].values[0]
            pct_m_26 = 100.0 - pct_nm_26
            nm_26 = tot_26 * (pct_nm_26 / 100.0)
            m_26 = tot_26 - nm_26
            bps_projections.append({
                "provinsi": prov,
                "kode_bps": PROVINCES_INDONESIA[prov]['kode_bps'],
                "pulau": PROVINCES_INDONESIA[prov]['pulau'],
                "tahun": 2026,
                "pengeluaran_makanan_idr": round(m_26, 2),
                "pengeluaran_non_makanan_idr": round(nm_26, 2),
                "total_pengeluaran_idr": round(tot_26, 2),
                "persentase_makanan": round(pct_m_26, 2),
                "persentase_non_makanan": round(pct_nm_26, 2)
            })
    df_bps_extended = pd.concat([df_bps, pd.DataFrame(bps_projections)], ignore_index=True)
    
    # Merge E-Commerce Annual with BPS Extended
    integrated = pd.merge(
        ecom_annual,
        df_bps_extended,
        on=['provinsi', 'kode_bps', 'tahun'],
        how='inner'
    )
    
    # ACADEMIC INTEGRATED METRICS
    # 1. Ratio of Digital Order Value (AOV) to BPS Monthly Non-Food Per Capita Expenditure
    # Mengukur proporsi pengeluaran per keranjang belanja online terhadap alokasi bulanan non-makanan riil
    integrated['rasio_aov_thd_non_makanan_bps'] = (integrated['ecom_aov_idr'] / integrated['pengeluaran_non_makanan_idr']).round(4)
    
    # 2. Digital Spend per Transaction to Total BPS Monthly Expenditure
    integrated['rasio_aov_thd_total_pengeluaran_bps'] = (integrated['ecom_aov_idr'] / integrated['total_pengeluaran_idr']).round(4)
    
    # 3. Composite Purchasing Power & Digital Affinity Typology
    # Mengklasifikasikan wilayah ke 4 kuadran berdasarkan median pengeluaran riil BPS dan median volume transaksi e-commerce
    med_bps = integrated['total_pengeluaran_idr'].median()
    med_ecom = integrated['ecom_total_transaksi'].median()
    
    def assign_typology(row):
        bps_high = row['total_pengeluaran_idr'] >= med_bps
        ecom_high = row['ecom_total_transaksi'] >= med_ecom
        if bps_high and ecom_high:
            return "Kuadran I: Daya Beli Riil Tinggi & Belanja Digital Tinggi"
        elif bps_high and not ecom_high:
            return "Kuadran II: Daya Beli Riil Tinggi & Penetrasi Digital Moderat"
        elif not bps_high and ecom_high:
            return "Kuadran III: Daya Beli Riil Menengah & Belanja Digital Dinamis"
        else:
            return "Kuadran IV: Daya Beli Riil Berkembang & Penetrasi Digital Awal"
            
    integrated['tipologi_daya_beli_digital'] = integrated.apply(assign_typology, axis=1)
    
    # Save fact_integrasi_daya_beli
    fact_integrasi_path = 'data/processed/fact_integrasi_daya_beli.csv'
    integrated.to_csv(fact_integrasi_path, index=False, encoding='utf-8')
    integrated.to_parquet('data/processed/fact_integrasi_daya_beli.parquet', index=False)
    print(f"Saved {fact_integrasi_path} ({len(integrated)} provincial annual panel records)")
    
    # 7. Generate Transformation Log Report
    log_md_path = 'data/reports/etl_transformation_log.md'
    with open(log_md_path, 'w', encoding='utf-8') as f:
        f.write("# Log Transformasi ETL & Metodologi Integrasi Data\n\n")
        f.write("Proyek Penelitian: **Perancangan Dashboard Business Intelligence untuk Pemetaan Pola Konsumsi dan Daya Beli Digital Berbasis Analisis Big Data**\n\n")
        f.write("## 1. Ringkasan Pipeline Ekstraksi dan Transformasi\n\n")
        f.write(f"- **Dataset Mentah E-Commerce**: `big_data_ecommerce_5juta.parquet` ({pf.metadata.num_rows:,} baris, 34 kolom).\n")
        f.write(f"- **Dataset Mentah BPS**: `bps_pengeluaran_2011_2025.csv` & persentase 2024–2025.\n")
        f.write(f"- **Metode Pemrosesan**: Streaming Row-Group Processing (5 chunks x 1,000,000 baris) dengan teknik agregasi in-memory untuk efisiensi RAM.\n")
        f.write(f"- **Tabel Agregat Bulanan**: `fact_ecommerce_bulanan` ({len(fact_ecom_monthly):,} baris dimensi waktu-wilayah-platform-kategori).\n")
        f.write(f"- **Tabel Panel Integrasi**: `fact_integrasi_daya_beli` ({len(integrated)} baris panel tahunan provinsi).\n")
        f.write(f"- **Tabel Granular Sampel**: `sample_transaksi_50k` ({len(df_sample_50k):,} baris transaksi observasi asli untuk audit/drilldown).\n\n")
        f.write("## 2. Harmonisasi Spasial dan Waktu\n\n")
        f.write("1. **Harmonisasi Nama Wilayah**: Varian string e-commerce (misal `'Kep. Bangka Belitung'`) dinormalisasi secara otomatis menjadi `'Kepulauan Bangka Belitung'` mengacu pada referensi resmi 38 Provinsi BPS.\n")
        f.write("2. **Harmonisasi Periode Waktu**: Timestamp transaksi diekstraksi ke level tahun, bulan, dan tahun-bulan (`YYYY-MM`). Periode irisan komparatif dengan BPS difokuskan pada tahun 2024, 2025, dan proyeksi tren 2026.\n\n")
        f.write("## 3. Formulasi Metrik Penelitian Terintegrasi\n\n")
        f.write("1. **Rasio AOV terhadap Pengeluaran Non-Makanan BPS**:\n")
        f.write("   $$\\text{Rasio AOV} = \\frac{\\text{Average Order Value E-Commerce (Rp)}}{\\text{Rata-rata Pengeluaran Non-Makanan per Kapita Sebulan BPS (Rp)}}$$\n")
        f.write("   *Justifikasi Akademis*: Belanja online komoditas UMKM (fashion, kriya, kecantikan, gawai/aksesoris) merupakan komponen pengeluaran sekunder/tersier (non-makanan). Metrik ini mengukur seberapa signifikan pengeluaran per satu keranjang digital relatif terhadap kapasitas alokasi pengeluaran non-pangan bulanan masyarakat setempat.\n\n")
        f.write("2. **Tipologi Kuadran Daya Beli Digital**:\n")
        f.write("   - Memadukan daya beli riil wilayah (pengeluaran per kapita total BPS) dengan intensitas konsumsi digital (volume transaksi e-commerce).\n")
        f.write("   - Menghasilkan 4 kuadran klasifikasi wilayah yang bebas bias penyamaan langsung antara GMV digital dengan pendapatan masyarakat.\n")
        
    print(f"ETL Transformation log saved to {log_md_path}")
    print("=" * 60)
    print("ETL AND MULTI-SOURCE INTEGRATION COMPLETED SUCCESSFULLY!")
    print("=" * 60)

if __name__ == '__main__':
    run_integration()
