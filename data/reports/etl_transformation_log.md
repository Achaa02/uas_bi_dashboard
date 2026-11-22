# Log Transformasi ETL & Metodologi Integrasi Data

Proyek Penelitian: **Perancangan Dashboard Business Intelligence untuk Pemetaan Pola Konsumsi dan Daya Beli Digital Berbasis Analisis Big Data**

## 1. Ringkasan Pipeline Ekstraksi dan Transformasi

- **Dataset Mentah E-Commerce**: `big_data_ecommerce_5juta.parquet` (5,000,000 baris, 34 kolom).
- **Dataset Mentah BPS**: `bps_pengeluaran_2011_2025.csv` & persentase 2024–2025.
- **Metode Pemrosesan**: Streaming Row-Group Processing (5 chunks x 1,000,000 baris) dengan teknik agregasi in-memory untuk efisiensi RAM.
- **Tabel Agregat Bulanan**: `fact_ecommerce_bulanan` (7,028 baris dimensi waktu-wilayah-platform-kategori).
- **Tabel Panel Integrasi**: `fact_integrasi_daya_beli` (114 baris panel tahunan provinsi).
- **Tabel Granular Sampel**: `sample_transaksi_50k` (50,000 baris transaksi observasi asli untuk audit/drilldown).

## 2. Harmonisasi Spasial dan Waktu

1. **Harmonisasi Nama Wilayah**: Varian string e-commerce (misal `'Kep. Bangka Belitung'`) dinormalisasi secara otomatis menjadi `'Kepulauan Bangka Belitung'` mengacu pada referensi resmi 38 Provinsi BPS.
2. **Harmonisasi Periode Waktu**: Timestamp transaksi diekstraksi ke level tahun, bulan, dan tahun-bulan (`YYYY-MM`). Periode irisan komparatif dengan BPS difokuskan pada tahun 2024, 2025, dan proyeksi tren 2026.

## 3. Formulasi Metrik Penelitian Terintegrasi

1. **Rasio AOV terhadap Pengeluaran Non-Makanan BPS**:
   $$\text{Rasio AOV} = \frac{\text{Average Order Value E-Commerce (Rp)}}{\text{Rata-rata Pengeluaran Non-Makanan per Kapita Sebulan BPS (Rp)}}$$
   *Justifikasi Akademis*: Belanja online komoditas UMKM (fashion, kriya, kecantikan, gawai/aksesoris) merupakan komponen pengeluaran sekunder/tersier (non-makanan). Metrik ini mengukur seberapa signifikan pengeluaran per satu keranjang digital relatif terhadap kapasitas alokasi pengeluaran non-pangan bulanan masyarakat setempat.

2. **Tipologi Kuadran Daya Beli Digital**:
   - Memadukan daya beli riil wilayah (pengeluaran per kapita total BPS) dengan intensitas konsumsi digital (volume transaksi e-commerce).
   - Menghasilkan 4 kuadran klasifikasi wilayah yang bebas bias penyamaan langsung antara GMV digital dengan pendapatan masyarakat.
