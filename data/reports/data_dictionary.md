# Kamus Data Akademis (Data Dictionary)

Proyek Penelitian: **Perancangan Dashboard Business Intelligence untuk Pemetaan Pola Konsumsi dan Daya Beli Digital Berbasis Analisis Big Data**

## 1. Definisi Kolom Dataset E-Commerce

| Nama Kolom | Tipe Data | Kategori | Klasifikasi Akademis | Deskripsi &
| :--- | :--- | :--- | :--- | :---
| `transaksi_id` | `string` | Identifikasi | **Observasi Asli** | Kode identifikasi template transaksi. |
| `order_id` | `string` | Identifikasi | **Observasi Asli** | Identifier unik unik untuk setiap transaksi dari 5 juta data. |
| `kategori_produk` | `string` | Katalog Produk | **Observasi Asli** | Klasifikasi 7 kategori komoditas produk UMKM. |
| `platform_ecommerce` | `string` | Kanal Penjualan | **Observasi Asli** | Platform marketplace atau social commerce digital. |
| `provinsi_penjual` | `string` | Spasial/Wilayah | **Observasi Asli** | Provinsi lokasi domisili merchant/penjual. |
| `provinsi_pembeli` | `string` | Spasial/Wilayah | **Observasi Asli** | Provinsi destinasi pengiriman / domisili konsumen pembeli. |
| `wilayah_pengiriman` | `string` | Logistik | **Observasi Asli** | Tipe rute pengiriman (Intra-pulau, Antar-pulau). |
| `nilai_transaksi_bruto_idr` | `int64` | Keuangan Transaksi | **Observasi Asli** | Nilai transaksi bruto barang sebelum diskon dan ongkir (Rupiah). |
| `diskon_voucher_platform_idr` | `int64` | Promosi | **Observasi Asli** | Nominal potongan harga voucher promosi belanja (Rupiah). |
| `ongkos_kirim_riil_idr` | `int64` | Logistik | **Observasi Asli** | Biaya tarif pengiriman riil ekspedisi logistik (Rupiah). |
| `subsidi_gratis_ongkir_idr` | `int64` | Promosi | **Observasi Asli** | Besaran subsidi ongkos kirim yang ditanggung platform (Rupiah). |
| `nilai_transaksi_netto_idr` | `int64` | Keuangan Transaksi | **Observasi Asli** | Nilai akhir pembayaran netto konsumen (Rupiah). |
| `metode_pembayaran` | `string` | Financial Tech | **Observasi Asli** | Instrumen pembayaran digital (E-Wallet, Paylater, QRIS, Virtual Account). |
| `layanan_ekspedisi` | `string` | Logistik | **Observasi Asli** | Penyedia jasa kurir logistik. |
| `durasi_pengiriman_hari` | `int64` | Logistik | **Observasi Asli** | Jumlah hari pengiriman dari seller ke buyer. |
| `status_keterlambatan_pengiriman` | `string` | Logistik | **Observasi Asli** | Status ketepatan waktu pengiriman kurir. |
| `rating_produk` | `int64` | Kepuasan Pelanggan | **Observasi Asli** | Skor ulasan bintang (1-5). |
| `status_repeat_order` | `string` | Retensi | **Observasi Asli** | Status pembelian berulang (Ya / Tidak). |
| `usia_pembeli` | `int64` | Demografi | **Observasi Asli** | Usia konsumen pembeli (Tahun). |
| `gender_pembeli` | `string` | Demografi | **Observasi Asli** | Jenis kelamin pembeli (Laki-laki / Perempuan). |
| `teks_ulasan_konsumen` | `string` | Ulasan Kualitatif | **Observasi Asli** | Teks review ulasan produk dari konsumen. |
| `panjang_karakter_ulasan` | `int64` | Ulasan Kualitatif | **Observasi Asli** | Jumlah karakter pada teks ulasan. |
| `jumlah_kata_ulasan` | `int64` | Ulasan Kualitatif | **Observasi Asli** | Jumlah kata pada teks ulasan. |
| `timestamp_transaksi` | `datetime` | Temporal | **Observasi Asli** | Timestamp lengkap tanggal dan jam checkout pesanan. |
| `tanggal_transaksi` | `date` | Temporal | **Observasi Asli** | Tanggal kalender transaksi. |
| `harga_produk` | `float64` | Keuangan Transaksi | **Observasi Asli** | Harga satuan unit produk (Rupiah). |
| `jumlah_beli` | `int64` | Kuantitas | **Observasi Asli** | Jumlah kuantitas unit produk yang dibeli per transaksi. |
| `total_belanja` | `float64` | Keuangan Transaksi | **Observasi Asli** | Total belanja harga x kuantitas (Rupiah). |
| `indeks_sensitivitas_ongkir` | `float64` | Model Perilaku | **Kolom Turunan / Model** | Estimasi indeks elastisitas keputusan beli terhadap ongkos kirim (0.0 - 1.0). |
| `skor_loyalitas_pelanggan` | `float64` | Model Perilaku | **Kolom Turunan / Model** | Skor retensi loyalitas pelanggan berbasis riwayat belanja & rating (0.0 - 1.0). |
| `kategori_risiko_churn` | `string` | Model Prediktif | **Kolom Turunan / Model** | Klasifikasi risiko churn pembeli (Rendah, Sedang, Tinggi). |
| `rasio_efektivitas_diskon` | `float64` | Metrik Turunan | **Kolom Turunan / Metrik** | Rasio besaran diskon & subsidi terhadap nilai transaksi bruto. |
| `penalaran_konsumen_cot` | `string` | Model AI/LLM | **Kolom Turunan / Model AI** | Hasil penalaran sintesis perilaku belanja konsumen berbasis Chain-of-Thought AI. |
| `posterior_confidence` | `float64` | Model Statistik | **Kolom Turunan / Model** | Probabilitas keyakinan estimasi model perilaku Bayesian (0.0 - 1.0). |

## 2. Peringatan Metodologis & Batasan Analisis (Academic Caveat)

1. **Pemisahan Data Observasi vs Model Turunan**:
   - Kolom seperti `indeks_sensitivitas_ongkir`, `skor_loyalitas_pelanggan`, `kategori_risiko_churn`, dan `penalaran_konsumen_cot` diklasifikasikan secara ketat sebagai **Kolom Hasil Pemodelan/Turunan**, bukan data observasi transaksi mentah.
2. **Batas Validitas Daya Beli Digital vs Pendapatan Riil**:
   - Nilai transaksi digital (`nilai_transaksi_netto_idr` / total belanja) merepresentasikan **pengeluaran aktual untuk belanja online komoditas tertentu**, dan **TIDAK DAPAT disamakan secara langsung dengan total pendapatan rumah tangga** atau daya beli riil menyeluruh masyarakat.
   - Integrasi data BPS pengeluaran per kapita berfungsi sebagai tolok ukur makroekonomi wilayah untuk membandingkan proporsi pengeluaran digital terhadap struktur pengeluaran riil daerah.
3. **Harmonisasi Spasial dan Waktu**:
   - Seluruh data transaksi diharmonisasikan ke 38 Provinsi standar BPS Indonesia.
   - Agregasi dilakukan per level provinsi dan tahun/bulan agar setara (*apple-to-apple*) dengan data panel statistik pengeluaran BPS 2024–2025.
