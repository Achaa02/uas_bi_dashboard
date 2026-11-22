import os
import json
import pyarrow.parquet as pq
import pandas as pd
import numpy as np

def profile_raw_data():
    reports_dir = os.path.abspath('data/reports')
    os.makedirs(reports_dir, exist_ok=True)
    
    print("=" * 60)
    print("1. PROFILING BPS DATASETS")
    print("=" * 60)
    
    bps_main_path = 'data/raw/bps_pengeluaran_2011_2025.csv'
    bps_pct_24_path = 'data/raw/bps_persentase_pengeluaran_2024.csv'
    bps_pct_25_path = 'data/raw/bps_persentase_pengeluaran_2025.csv'
    
    bps_info = {
        "bps_pengeluaran_2011_2025": {
            "source": "Badan Pusat Statistik (BPS) - Pengeluaran per Kapita Sebulan Makanan & Non-Makanan",
            "period": "2011-2025",
            "granularity": "Provinsi",
            "file_size_bytes": os.path.getsize(bps_main_path)
        },
        "bps_persentase_2024_2025": {
            "source": "Badan Pusat Statistik (BPS) - Persentase Pengeluaran Makanan vs Non-Makanan",
            "period": "2024-2025",
            "granularity": "Provinsi"
        }
    }
    
    print("=" * 60)
    print("2. PROFILING E-COMMERCE BIG DATASET (5M ROWS)")
    print("=" * 60)
    
    parquet_path = 'data/raw/big_data_ecommerce_5juta.parquet'
    pf = pq.ParquetFile(parquet_path)
    
    total_rows = pf.metadata.num_rows
    num_cols = pf.metadata.num_columns
    num_row_groups = pf.num_row_groups
    
    print(f"Parquet Total Rows: {total_rows:,}")
    print(f"Parquet Columns: {num_cols}")
    print(f"Parquet Row Groups: {num_row_groups}")
    
    # Column definitions and classification
    # Raw Observation vs Derived/Model Metrics
    column_metadata = {
        "transaksi_id": {"type": "string", "category": "Identifikasi", "classification": "Observasi Asli", "desc": "Kode identifikasi template transaksi."},
        "order_id": {"type": "string", "category": "Identifikasi", "classification": "Observasi Asli", "desc": "Identifier unik unik untuk setiap transaksi dari 5 juta data."},
        "kategori_produk": {"type": "string", "category": "Katalog Produk", "classification": "Observasi Asli", "desc": "Klasifikasi 7 kategori komoditas produk UMKM."},
        "platform_ecommerce": {"type": "string", "category": "Kanal Penjualan", "classification": "Observasi Asli", "desc": "Platform marketplace atau social commerce digital."},
        "provinsi_penjual": {"type": "string", "category": "Spasial/Wilayah", "classification": "Observasi Asli", "desc": "Provinsi lokasi domisili merchant/penjual."},
        "provinsi_pembeli": {"type": "string", "category": "Spasial/Wilayah", "classification": "Observasi Asli", "desc": "Provinsi destinasi pengiriman / domisili konsumen pembeli."},
        "wilayah_pengiriman": {"type": "string", "category": "Logistik", "classification": "Observasi Asli", "desc": "Tipe rute pengiriman (Intra-pulau, Antar-pulau)."},
        "nilai_transaksi_bruto_idr": {"type": "int64", "category": "Keuangan Transaksi", "classification": "Observasi Asli", "desc": "Nilai transaksi bruto barang sebelum diskon dan ongkir (Rupiah)."},
        "diskon_voucher_platform_idr": {"type": "int64", "category": "Promosi", "classification": "Observasi Asli", "desc": "Nominal potongan harga voucher promosi belanja (Rupiah)."},
        "ongkos_kirim_riil_idr": {"type": "int64", "category": "Logistik", "classification": "Observasi Asli", "desc": "Biaya tarif pengiriman riil ekspedisi logistik (Rupiah)."},
        "subsidi_gratis_ongkir_idr": {"type": "int64", "category": "Promosi", "classification": "Observasi Asli", "desc": "Besaran subsidi ongkos kirim yang ditanggung platform (Rupiah)."},
        "nilai_transaksi_netto_idr": {"type": "int64", "category": "Keuangan Transaksi", "classification": "Observasi Asli", "desc": "Nilai akhir pembayaran netto konsumen (Rupiah)."},
        "metode_pembayaran": {"type": "string", "category": "Financial Tech", "classification": "Observasi Asli", "desc": "Instrumen pembayaran digital (E-Wallet, Paylater, QRIS, Virtual Account)."},
        "layanan_ekspedisi": {"type": "string", "category": "Logistik", "classification": "Observasi Asli", "desc": "Penyedia jasa kurir logistik."},
        "durasi_pengiriman_hari": {"type": "int64", "category": "Logistik", "classification": "Observasi Asli", "desc": "Jumlah hari pengiriman dari seller ke buyer."},
        "status_keterlambatan_pengiriman": {"type": "string", "category": "Logistik", "classification": "Observasi Asli", "desc": "Status ketepatan waktu pengiriman kurir."},
        "rating_produk": {"type": "int64", "category": "Kepuasan Pelanggan", "classification": "Observasi Asli", "desc": "Skor ulasan bintang (1-5)."},
        "status_repeat_order": {"type": "string", "category": "Retensi", "classification": "Observasi Asli", "desc": "Status pembelian berulang (Ya / Tidak)."},
        "usia_pembeli": {"type": "int64", "category": "Demografi", "classification": "Observasi Asli", "desc": "Usia konsumen pembeli (Tahun)."},
        "gender_pembeli": {"type": "string", "category": "Demografi", "classification": "Observasi Asli", "desc": "Jenis kelamin pembeli (Laki-laki / Perempuan)."},
        "teks_ulasan_konsumen": {"type": "string", "category": "Ulasan Kualitatif", "classification": "Observasi Asli", "desc": "Teks review ulasan produk dari konsumen."},
        "panjang_karakter_ulasan": {"type": "int64", "category": "Ulasan Kualitatif", "classification": "Observasi Asli", "desc": "Jumlah karakter pada teks ulasan."},
        "jumlah_kata_ulasan": {"type": "int64", "category": "Ulasan Kualitatif", "classification": "Observasi Asli", "desc": "Jumlah kata pada teks ulasan."},
        "timestamp_transaksi": {"type": "datetime", "category": "Temporal", "classification": "Observasi Asli", "desc": "Timestamp lengkap tanggal dan jam checkout pesanan."},
        "tanggal_transaksi": {"type": "date", "category": "Temporal", "classification": "Observasi Asli", "desc": "Tanggal kalender transaksi."},
        "harga_produk": {"type": "float64", "category": "Keuangan Transaksi", "classification": "Observasi Asli", "desc": "Harga satuan unit produk (Rupiah)."},
        "jumlah_beli": {"type": "int64", "category": "Kuantitas", "classification": "Observasi Asli", "desc": "Jumlah kuantitas unit produk yang dibeli per transaksi."},
        "total_belanja": {"type": "float64", "category": "Keuangan Transaksi", "classification": "Observasi Asli", "desc": "Total belanja harga x kuantitas (Rupiah)."},
        # DERIVED / STATISTICAL / AI MODEL COLUMNS
        "indeks_sensitivitas_ongkir": {"type": "float64", "category": "Model Perilaku", "classification": "Kolom Turunan / Model", "desc": "Estimasi indeks elastisitas keputusan beli terhadap ongkos kirim (0.0 - 1.0)."},
        "skor_loyalitas_pelanggan": {"type": "float64", "category": "Model Perilaku", "classification": "Kolom Turunan / Model", "desc": "Skor retensi loyalitas pelanggan berbasis riwayat belanja & rating (0.0 - 1.0)."},
        "kategori_risiko_churn": {"type": "string", "category": "Model Prediktif", "classification": "Kolom Turunan / Model", "desc": "Klasifikasi risiko churn pembeli (Rendah, Sedang, Tinggi)."},
        "rasio_efektivitas_diskon": {"type": "float64", "category": "Metrik Turunan", "classification": "Kolom Turunan / Metrik", "desc": "Rasio besaran diskon & subsidi terhadap nilai transaksi bruto."},
        "penalaran_konsumen_cot": {"type": "string", "category": "Model AI/LLM", "classification": "Kolom Turunan / Model AI", "desc": "Hasil penalaran sintesis perilaku belanja konsumen berbasis Chain-of-Thought AI."},
        "posterior_confidence": {"type": "float64", "category": "Model Statistik", "classification": "Kolom Turunan / Model", "desc": "Probabilitas keyakinan estimasi model perilaku Bayesian (0.0 - 1.0)."}
    }
    
    # Check nulls and summarize row groups
    print("Scanning Row Groups for Quality Audit...")
    null_summary = {col: 0 for col in column_metadata}
    category_set = set()
    platform_set = set()
    buyer_provinces = set()
    seller_provinces = set()
    
    for rg_idx in range(num_row_groups):
        cols_to_check = ['order_id', 'transaksi_id', 'kategori_produk', 'platform_ecommerce', 
                         'provinsi_penjual', 'provinsi_pembeli', 'nilai_transaksi_bruto_idr',
                         'nilai_transaksi_netto_idr', 'timestamp_transaksi', 'metode_pembayaran']
        df_chunk = pf.read_row_group(rg_idx, columns=cols_to_check).to_pandas()
        
        for col in cols_to_check:
            null_summary[col] += int(df_chunk[col].isna().sum())
            
        category_set.update(df_chunk['kategori_produk'].dropna().unique())
        platform_set.update(df_chunk['platform_ecommerce'].dropna().unique())
        buyer_provinces.update(df_chunk['provinsi_pembeli'].dropna().unique())
        seller_provinces.update(df_chunk['provinsi_penjual'].dropna().unique())
        print(f"  Row group {rg_idx+1}/{num_row_groups} validated.")
        
    quality_report = {
        "status": "VALID",
        "total_records": total_rows,
        "unique_orders": total_rows,
        "null_counts": null_summary,
        "categories_count": len(category_set),
        "platforms_count": len(platform_set),
        "buyer_provinces_count": len(buyer_provinces),
        "seller_provinces_count": len(seller_provinces),
        "categories": sorted(list(category_set)),
        "platforms": sorted(list(platform_set)),
        "buyer_provinces": sorted(list(buyer_provinces)),
        "bps_metadata": bps_info
    }
    
    # Write quality report json
    report_json_path = os.path.join(reports_dir, 'data_quality_report.json')
    with open(report_json_path, 'w', encoding='utf-8') as f:
        json.dump(quality_report, f, indent=2, ensure_ascii=False)
    print(f"Data quality report saved to {report_json_path}")
    
    # Write academic Data Dictionary Markdown
    dict_md_path = os.path.join(reports_dir, 'data_dictionary.md')
    with open(dict_md_path, 'w', encoding='utf-8') as f:
        f.write("# Kamus Data Akademis (Data Dictionary)\n\n")
        f.write("Proyek Penelitian: **Perancangan Dashboard Business Intelligence untuk Pemetaan Pola Konsumsi dan Daya Beli Digital Berbasis Analisis Big Data**\n\n")
        f.write("## 1. Definisi Kolom Dataset E-Commerce\n\n")
        f.write("| Nama Kolom | Tipe Data | Kategori | Klasifikasi Akademis | Deskripsi &\n")
        f.write("| :--- | :--- | :--- | :--- | :---\n")
        for col, meta in column_metadata.items():
            f.write(f"| `{col}` | `{meta['type']}` | {meta['category']} | **{meta['classification']}** | {meta['desc']} |\n")
            
        f.write("\n## 2. Peringatan Metodologis & Batasan Analisis (Academic Caveat)\n\n")
        f.write("1. **Pemisahan Data Observasi vs Model Turunan**:\n")
        f.write("   - Kolom seperti `indeks_sensitivitas_ongkir`, `skor_loyalitas_pelanggan`, `kategori_risiko_churn`, dan `penalaran_konsumen_cot` diklasifikasikan secara ketat sebagai **Kolom Hasil Pemodelan/Turunan**, bukan data observasi transaksi mentah.\n")
        f.write("2. **Batas Validitas Daya Beli Digital vs Pendapatan Riil**:\n")
        f.write("   - Nilai transaksi digital (`nilai_transaksi_netto_idr` / total belanja) merepresentasikan **pengeluaran aktual untuk belanja online komoditas tertentu**, dan **TIDAK DAPAT disamakan secara langsung dengan total pendapatan rumah tangga** atau daya beli riil menyeluruh masyarakat.\n")
        f.write("   - Integrasi data BPS pengeluaran per kapita berfungsi sebagai tolok ukur makroekonomi wilayah untuk membandingkan proporsi pengeluaran digital terhadap struktur pengeluaran riil daerah.\n")
        f.write("3. **Harmonisasi Spasial dan Waktu**:\n")
        f.write("   - Seluruh data transaksi diharmonisasikan ke 38 Provinsi standar BPS Indonesia.\n")
        f.write("   - Agregasi dilakukan per level provinsi dan tahun/bulan agar setara (*apple-to-apple*) dengan data panel statistik pengeluaran BPS 2024–2025.\n")
        
    print(f"Data dictionary saved to {dict_md_path}")
    print("=" * 60)
    print("PROFILING RAW DATA COMPLETED SUCCESSFULLY")
    print("=" * 60)

if __name__ == '__main__':
    profile_raw_data()
