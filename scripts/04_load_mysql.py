import os
import pandas as pd
import mysql.connector
from datetime import datetime

# MySQL config matching Laragon .env
DB_CONFIG = {
    'host': '127.0.0.1',
    'port': 3306,
    'user': 'root',
    'password': '',
    'database': 'bi_dashboard'
}

def load_data_to_mysql():
    print("=" * 60)
    print("LOADING PROCESSED BI DATA MARTS INTO MYSQL")
    print("=" * 60)
    
    conn = mysql.connector.connect(**DB_CONFIG)
    cursor = conn.cursor()
    
    now_str = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    
    # 1. Load dim_wilayah
    print("Loading dim_wilayah...")
    df_wilayah = pd.read_csv('data/processed/dim_wilayah.csv')
    cursor.execute("DELETE FROM dim_wilayah")
    insert_wilayah = """
    INSERT INTO dim_wilayah (kode_bps, nama_provinsi, pulau, latitude, longitude, created_at, updated_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s)
    """
    wilayah_data = [
        (r['kode_bps'], r['nama_provinsi'], r['pulau'], float(r['latitude']), float(r['longitude']), now_str, now_str)
        for _, r in df_wilayah.iterrows()
    ]
    cursor.executemany(insert_wilayah, wilayah_data)
    conn.commit()
    print(f"  Loaded {len(wilayah_data)} records into dim_wilayah.")
    
    # 2. Load dim_kategori
    print("Loading dim_kategori...")
    df_kategori = pd.read_csv('data/processed/dim_kategori.csv')
    cursor.execute("DELETE FROM dim_kategori")
    insert_kategori = """
    INSERT INTO dim_kategori (kategori_id, nama_kategori, created_at, updated_at)
    VALUES (%s, %s, %s, %s)
    """
    kategori_data = [
        (int(r['kategori_id']), r['nama_kategori'], now_str, now_str)
        for _, r in df_kategori.iterrows()
    ]
    cursor.executemany(insert_kategori, kategori_data)
    conn.commit()
    print(f"  Loaded {len(kategori_data)} records into dim_kategori.")
    
    # 3. Load dim_platform
    print("Loading dim_platform...")
    df_platform = pd.read_csv('data/processed/dim_platform.csv')
    cursor.execute("DELETE FROM dim_platform")
    insert_platform = """
    INSERT INTO dim_platform (platform_id, nama_platform, created_at, updated_at)
    VALUES (%s, %s, %s, %s)
    """
    platform_data = [
        (int(r['platform_id']), r['nama_platform'], now_str, now_str)
        for _, r in df_platform.iterrows()
    ]
    cursor.executemany(insert_platform, platform_data)
    conn.commit()
    print(f"  Loaded {len(platform_data)} records into dim_platform.")
    
    # 4. Load dim_waktu
    print("Loading dim_waktu...")
    df_waktu = pd.read_csv('data/processed/dim_waktu.csv')
    cursor.execute("DELETE FROM dim_waktu")
    insert_waktu = """
    INSERT INTO dim_waktu (waktu_id, tahun, bulan, tahun_bulan, kuartal, created_at, updated_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s)
    """
    waktu_data = [
        (int(r['waktu_id']), int(r['tahun']), int(r['bulan']), str(r['tahun_bulan']), str(r['kuartal']), now_str, now_str)
        for _, r in df_waktu.iterrows()
    ]
    cursor.executemany(insert_waktu, waktu_data)
    conn.commit()
    print(f"  Loaded {len(waktu_data)} records into dim_waktu.")
    
    # 5. Load fact_bps_ekonomi
    print("Loading fact_bps_ekonomi...")
    df_bps = pd.read_csv('data/processed/fact_bps_ekonomi.csv')
    cursor.execute("DELETE FROM fact_bps_ekonomi")
    insert_bps = """
    INSERT INTO fact_bps_ekonomi 
    (kode_bps, provinsi, pulau, tahun, pengeluaran_makanan_idr, pengeluaran_non_makanan_idr, total_pengeluaran_idr, persentase_makanan, persentase_non_makanan, created_at, updated_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """
    bps_data = []
    for _, r in df_bps.iterrows():
        bps_data.append((
            str(r['kode_bps']),
            r['provinsi'],
            r['pulau'],
            int(r['tahun']),
            float(r['pengeluaran_makanan_idr']) if pd.notna(r['pengeluaran_makanan_idr']) else None,
            float(r['pengeluaran_non_makanan_idr']) if pd.notna(r['pengeluaran_non_makanan_idr']) else None,
            float(r['total_pengeluaran_idr']) if pd.notna(r['total_pengeluaran_idr']) else None,
            float(r['persentase_makanan']) if pd.notna(r['persentase_makanan']) else None,
            float(r['persentase_non_makanan']) if pd.notna(r['persentase_non_makanan']) else None,
            now_str, now_str
        ))
    cursor.executemany(insert_bps, bps_data)
    conn.commit()
    print(f"  Loaded {len(bps_data)} records into fact_bps_ekonomi.")
    
    # 6. Load fact_ecommerce_bulanan
    print("Loading fact_ecommerce_bulanan...")
    df_ecom = pd.read_csv('data/processed/fact_ecommerce_bulanan.csv')
    cursor.execute("DELETE FROM fact_ecommerce_bulanan")
    insert_ecom = """
    INSERT INTO fact_ecommerce_bulanan 
    (kode_bps, provinsi, tahun, bulan, tahun_bulan, platform_ecommerce, kategori_produk,
     total_transaksi, total_kuantitas, total_bruto_idr, total_diskon_voucher_idr,
     total_ongkir_riil_idr, total_subsidi_ongkir_idr, total_netto_idr, avg_nilai_transaksi,
     avg_rating, persentase_repeat_order, persentase_tepat_waktu, avg_durasi_hari,
     avg_sensitivitas_ongkir, avg_skor_loyalitas, persentase_churn_tinggi, created_at, updated_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """
    ecom_data = []
    for _, r in df_ecom.iterrows():
        ecom_data.append((
            str(r['kode_bps']), r['provinsi'], int(r['tahun']), int(r['bulan']), str(r['tahun_bulan']),
            r['platform_ecommerce'], r['kategori_produk'],
            int(r['total_transaksi']), int(r['total_kuantitas']),
            float(r['total_bruto_idr']), float(r['total_diskon_voucher_idr']),
            float(r['total_ongkir_riil_idr']), float(r['total_subsidi_ongkir_idr']),
            float(r['total_netto_idr']), float(r['avg_nilai_transaksi']),
            float(r['avg_rating']), float(r['persentase_repeat_order']),
            float(r['persentase_tepat_waktu']), float(r['avg_durasi_hari']),
            float(r['avg_sensitivitas_ongkir']), float(r['avg_skor_loyalitas']),
            float(r['persentase_churn_tinggi']),
            now_str, now_str
        ))
    cursor.executemany(insert_ecom, ecom_data)
    conn.commit()
    print(f"  Loaded {len(ecom_data)} records into fact_ecommerce_bulanan.")
    
    # 7. Load fact_integrasi_daya_beli
    print("Loading fact_integrasi_daya_beli...")
    df_integ = pd.read_csv('data/processed/fact_integrasi_daya_beli.csv')
    cursor.execute("DELETE FROM fact_integrasi_daya_beli")
    insert_integ = """
    INSERT INTO fact_integrasi_daya_beli
    (kode_bps, provinsi, pulau, tahun, ecom_total_transaksi, ecom_total_kuantitas,
     ecom_total_bruto_idr, ecom_total_diskon_voucher_idr, ecom_total_ongkir_riil_idr,
     ecom_total_subsidi_ongkir_idr, ecom_total_netto_idr, ecom_aov_idr, avg_rating,
     persentase_repeat_order, avg_durasi_hari, avg_sensitivitas_ongkir, avg_skor_loyalitas,
     pengeluaran_makanan_idr, pengeluaran_non_makanan_idr, total_pengeluaran_idr,
     persentase_makanan, persentase_non_makanan, rasio_aov_thd_non_makanan_bps,
     rasio_aov_thd_total_pengeluaran_bps, tipologi_daya_beli_digital, created_at, updated_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """
    integ_data = []
    for _, r in df_integ.iterrows():
        integ_data.append((
            str(r['kode_bps']), r['provinsi'], r['pulau'], int(r['tahun']),
            int(r['ecom_total_transaksi']), int(r['ecom_total_kuantitas']),
            float(r['ecom_total_bruto_idr']), float(r['ecom_total_diskon_voucher_idr']),
            float(r['ecom_total_ongkir_riil_idr']), float(r['ecom_total_subsidi_ongkir_idr']),
            float(r['ecom_total_netto_idr']), float(r['ecom_aov_idr']),
            float(r['avg_rating']) if pd.notna(r.get('avg_rating')) else None,
            float(r['persentase_repeat_order']) if pd.notna(r.get('persentase_repeat_order')) else None,
            float(r['avg_durasi_hari']) if pd.notna(r.get('avg_durasi_hari')) else None,
            float(r['avg_sensitivitas_ongkir']) if pd.notna(r.get('avg_sensitivitas_ongkir')) else None,
            float(r['avg_skor_loyalitas']) if pd.notna(r.get('avg_skor_loyalitas')) else None,
            float(r['pengeluaran_makanan_idr']) if pd.notna(r.get('pengeluaran_makanan_idr')) else None,
            float(r['pengeluaran_non_makanan_idr']) if pd.notna(r.get('pengeluaran_non_makanan_idr')) else None,
            float(r['total_pengeluaran_idr']) if pd.notna(r.get('total_pengeluaran_idr')) else None,
            float(r['persentase_makanan']) if pd.notna(r.get('persentase_makanan')) else None,
            float(r['persentase_non_makanan']) if pd.notna(r.get('persentase_non_makanan')) else None,
            float(r['rasio_aov_thd_non_makanan_bps']) if pd.notna(r.get('rasio_aov_thd_non_makanan_bps')) else None,
            float(r['rasio_aov_thd_total_pengeluaran_bps']) if pd.notna(r.get('rasio_aov_thd_total_pengeluaran_bps')) else None,
            r['tipologi_daya_beli_digital'],
            now_str, now_str
        ))
    cursor.executemany(insert_integ, integ_data)
    conn.commit()
    print(f"  Loaded {len(integ_data)} records into fact_integrasi_daya_beli.")
    
    # 8. Load sample_transaksi_ecommerce (batch of 5000)
    print("Loading sample_transaksi_ecommerce (50,000 real rows)...")
    df_samp = pd.read_parquet('data/processed/sample_transaksi_50k.parquet')
    cursor.execute("DELETE FROM sample_transaksi_ecommerce")
    insert_samp = """
    INSERT INTO sample_transaksi_ecommerce
    (order_id, transaksi_id, kategori_produk, platform_ecommerce, provinsi, kode_bps,
     nilai_transaksi_bruto_idr, diskon_voucher_platform_idr, ongkos_kirim_riil_idr,
     subsidi_gratis_ongkir_idr, nilai_transaksi_netto_idr, metode_pembayaran, layanan_ekspedisi,
     durasi_pengiriman_hari, status_keterlambatan_pengiriman, rating_produk, status_repeat_order,
     usia_pembeli, gender_pembeli, timestamp_transaksi, tahun, bulan,
     indeks_sensitivitas_ongkir, skor_loyalitas_pelanggan, kategori_risiko_churn, created_at, updated_at)
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """
    batch = []
    batch_size = 5000
    total_loaded = 0
    for _, r in df_samp.iterrows():
        ts = str(r['timestamp_transaksi'])
        batch.append((
            str(r['order_id']), str(r['transaksi_id']), str(r['kategori_produk']), str(r['platform_ecommerce']),
            str(r['provinsi']), str(r['kode_bps']),
            float(r['nilai_transaksi_bruto_idr']), float(r['diskon_voucher_platform_idr']),
            float(r['ongkos_kirim_riil_idr']), float(r['subsidi_gratis_ongkir_idr']),
            float(r['nilai_transaksi_netto_idr']), str(r['metode_pembayaran']), str(r['layanan_ekspedisi']),
            int(r['durasi_pengiriman_hari']), str(r['status_keterlambatan_pengiriman']),
            int(r['rating_produk']), str(r['status_repeat_order']),
            int(r['usia_pembeli']), str(r['gender_pembeli']),
            ts, int(r['tahun']), int(r['bulan']),
            float(r['indeks_sensitivitas_ongkir']) if pd.notna(r.get('indeks_sensitivitas_ongkir')) else None,
            float(r['skor_loyalitas_pelanggan']) if pd.notna(r.get('skor_loyalitas_pelanggan')) else None,
            str(r['kategori_risiko_churn']) if pd.notna(r.get('kategori_risiko_churn')) else None,
            now_str, now_str
        ))
        if len(batch) >= batch_size:
            cursor.executemany(insert_samp, batch)
            conn.commit()
            total_loaded += len(batch)
            print(f"  Inserted {total_loaded:,} / {len(df_samp):,} sample transactions...")
            batch = []
            
    if batch:
        cursor.executemany(insert_samp, batch)
        conn.commit()
        total_loaded += len(batch)
        print(f"  Inserted {total_loaded:,} / {len(df_samp):,} sample transactions.")
        
    cursor.close()
    conn.close()
    print("=" * 60)
    print("ALL TABLES POPULATED IN MYSQL SUCCESSFULLY!")
    print("=" * 60)

if __name__ == '__main__':
    load_data_to_mysql()
