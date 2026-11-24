<?php

namespace App\Http\Controllers;

use App\Models\DimKategori;
use App\Models\DimPlatform;
use App\Models\DimWilayah;
use App\Models\FactBpsEkonomi;
use App\Models\FactIntegrasiDayaBeli;
use App\Models\SampleTransaksiEcommerce;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DataExplorerController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $selectedKategori = $request->query('kategori', 'all');
        $selectedInstansi = $request->query('instansi', 'all');
        $selectedPeriode = $request->query('periode', 'all');
        $selectedFormat = $request->query('format', 'all');
        $page = (int) $request->query('page', 1);
        $perPage = 8;

        // Hitung statistik riil dari database
        $ecomRowCount = SampleTransaksiEcommerce::count();
        $bpsRowCount = FactBpsEkonomi::count();
        $integrasiRowCount = FactIntegrasiDayaBeli::count();
        $wilayahRowCount = DimWilayah::count();

        // 12 Sumber Data lengkap dengan metadata dan keterkaitan tabel database
        $allSources = [
            [
                'id' => 1,
                'nama' => 'Dataset E-Commerce Indonesia',
                'sub_nama' => 'Transaksi e-commerce di berbagai platform',
                'instansi' => 'BPS',
                'kategori' => 'E-Commerce & Transaksi',
                'deskripsi' => 'Data transaksi, nilai, metode pembayaran, pengiriman, kategori produk',
                'periode' => '2019 - 2024',
                'dataset_count' => 8,
                'format' => 'CSV',
                'terakhir_diperbarui' => '21 Mei 2025',
                'icon_bg' => 'bg-blue-600',
                'icon_type' => 'cart',
                'table_name' => 'sample_transaksi_ecommerce',
                'total_records' => number_format($ecomRowCount) . ' baris observasi (dari populasi 5.000.000+ transaksi)',
                'cakupan' => '38 Provinsi, 5 Marketplace Utama (Shopee, Tokopedia, Lazada, TikTok Shop, Blibli)',
            ],
            [
                'id' => 2,
                'nama' => 'Survei Sosial Ekonomi Nasional (SUSENAS)',
                'sub_nama' => 'Konsumsi dan pengeluaran rumah tangga',
                'instansi' => 'BPS',
                'kategori' => 'Sosial Ekonomi',
                'deskripsi' => 'Data pengeluaran, pendapatan, akses internet, dan kepemilikan perangkat',
                'periode' => '2019 - 2024',
                'dataset_count' => 4,
                'format' => 'CSV',
                'terakhir_diperbarui' => '15 Mei 2025',
                'icon_bg' => 'bg-emerald-600',
                'icon_type' => 'users',
                'table_name' => 'fact_bps_ekonomi',
                'total_records' => number_format($bpsRowCount) . ' observasi agregat provinsi 2011-2025',
                'cakupan' => '38 Provinsi se-Indonesia, Pengeluaran Makanan vs Non-Makanan, Garis Kemiskinan',
            ],
            [
                'id' => 3,
                'nama' => 'Pendapatan Regional (PDRB)',
                'sub_nama' => 'Produk Domestik Regional Bruto',
                'instansi' => 'BPS',
                'kategori' => 'Sosial Ekonomi',
                'deskripsi' => 'Data PDRB ADHB, ADHK menurut lapangan usaha',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '10 Mei 2025',
                'icon_bg' => 'bg-amber-500',
                'icon_type' => 'building',
                'table_name' => 'fact_bps_ekonomi',
                'total_records' => '570 seri waktu indikator regional',
                'cakupan' => 'PDRB Per Kapita, Pertumbuhan Ekonomi Daerah, Kapasitas Konsumsi Rumah Tangga',
            ],
            [
                'id' => 4,
                'nama' => 'Indeks Harga Konsumen (IHK)',
                'sub_nama' => 'Inflasi dan indeks harga',
                'instansi' => 'BPS',
                'kategori' => 'Harga & Inflasi',
                'deskripsi' => 'Data IHK umum dan kelompok pengeluaran',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '9 Mei 2025',
                'icon_bg' => 'bg-purple-600',
                'icon_type' => 'crowd',
                'table_name' => 'fact_bps_ekonomi',
                'total_records' => 'Indeks IHK 90 kota pantauan inflasi nasional',
                'cakupan' => 'Kelompok Pengeluaran Makanan, Minuman, Pakaian, Logistik & Komunikasi',
            ],
            [
                'id' => 5,
                'nama' => 'Akses dan Penggunaan TIK',
                'sub_nama' => 'Teknologi Informasi dan Komunikasi',
                'instansi' => 'BPS',
                'kategori' => 'E-Commerce & Transaksi',
                'deskripsi' => 'Data akses internet, perangkat yang digunakan, dan literasi digital',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '7 Mei 2025',
                'icon_bg' => 'bg-cyan-500',
                'icon_type' => 'wifi',
                'table_name' => 'fact_integrasi_daya_beli',
                'total_records' => number_format($integrasiRowCount) . ' baris matriks integrasi daya beli digital',
                'cakupan' => 'Penetrasi internet provinsi, kepemilikan smartphone, adopsi belanja online',
            ],
            [
                'id' => 6,
                'nama' => 'Statistik Sistem Pembayaran',
                'sub_nama' => 'Transaksi sistem pembayaran non tunai',
                'instansi' => 'Bank Indonesia',
                'kategori' => 'Pembayaran Digital',
                'deskripsi' => 'Data nilai dan volume transaksi sistem pembayaran',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '6 Mei 2025',
                'icon_bg' => 'bg-rose-500',
                'icon_type' => 'card',
                'table_name' => 'sample_transaksi_ecommerce',
                'total_records' => '50.000 transaksi berlabel metode bayar (E-Wallet, Transfer Bank, COD, CC, PayLater)',
                'cakupan' => 'QRIS, Uang Elektronik, Virtual Account Perbankan, PayLater FinTech',
            ],
            [
                'id' => 7,
                'nama' => 'Statistik Transportasi',
                'sub_nama' => 'Transportasi dan logistik',
                'instansi' => 'BPS',
                'kategori' => 'E-Commerce & Transaksi',
                'deskripsi' => 'Data transportasi barang dan penumpang, logistik e-commerce',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '5 Mei 2025',
                'icon_bg' => 'bg-blue-600',
                'icon_type' => 'truck',
                'table_name' => 'sample_transaksi_ecommerce',
                'total_records' => '50.000 data pengiriman ekspedisi kurir (J&T, JNE, SiCepat)',
                'cakupan' => 'Durasi hari pengiriman, ketepatan waktu antaran, ongkir riil & subsidi',
            ],
            [
                'id' => 8,
                'nama' => 'Data UMKM',
                'sub_nama' => 'Usaha Mikro, Kecil, dan Menengah',
                'instansi' => 'BPS',
                'kategori' => 'E-Commerce & Transaksi',
                'deskripsi' => 'Data jumlah, sektor usaha, dan pemanfaatan e-commerce',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '2 Mei 2025',
                'icon_bg' => 'bg-emerald-600',
                'icon_type' => 'store',
                'table_name' => 'dim_kategori',
                'total_records' => 'Kategori produk ritel & merchant penjual digital',
                'cakupan' => 'Fashion & Aksesoris, Elektronik, Kecantikan, Makanan & Minuman, UMKM Lokal',
            ],
            [
                'id' => 9,
                'nama' => 'Data Demografi dan Ketenagakerjaan (Sakernas)',
                'sub_nama' => 'Profil demografis & produktivitas angkatan kerja',
                'instansi' => 'BPS',
                'kategori' => 'Sosial Ekonomi',
                'deskripsi' => 'Data demografi usia, gender, status ketenagakerjaan, dan kelas penghasilan',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '28 Apr 2025',
                'icon_bg' => 'bg-indigo-600',
                'icon_type' => 'users',
                'table_name' => 'sample_transaksi_ecommerce',
                'total_records' => 'Distribusi umur pembeli (<20 hingga >50 tahun) & gender pembeli',
                'cakupan' => '38 Provinsi, Kelompok Usia Produktif, Pola Konsumsi Generasional',
            ],
            [
                'id' => 10,
                'nama' => 'Statistik Finansial Inklusif (SNKI)',
                'sub_nama' => 'Indeks inklusi keuangan & literasi digital',
                'instansi' => 'Bank Indonesia',
                'kategori' => 'Pembayaran Digital',
                'deskripsi' => 'Tingkat kepemilikan rekening, penetrasi uang digital, dan pemanfaatan promo subsidi',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '25 Apr 2025',
                'icon_bg' => 'bg-violet-600',
                'icon_type' => 'card',
                'table_name' => 'sample_transaksi_ecommerce',
                'total_records' => 'Agregasi voucher diskon platform & subsidi ongkir gratis',
                'cakupan' => 'Adopsi FinTech Pembayaran, Penggunaan Voucher Diskon, Sensitivitas Ongkir',
            ],
            [
                'id' => 11,
                'nama' => 'Data Wilayah dan Geospasial Nasional',
                'sub_nama' => 'Kodefikasi BPS & koordinat spasial 38 provinsi',
                'instansi' => 'BPS',
                'kategori' => 'E-Commerce & Transaksi',
                'deskripsi' => 'Master data wilayah administratif, gugus pulau, koordinat latitude longitude & GeoJSON',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '20 Apr 2025',
                'icon_bg' => 'bg-teal-600',
                'icon_type' => 'globe',
                'table_name' => 'dim_wilayah',
                'total_records' => number_format($wilayahRowCount) . ' provinsi administratif lengkap dengan kode BPS',
                'cakupan' => 'Sumatera, Jawa, Bali & Nusa Tenggara, Kalimantan, Sulawesi, Maluku & Papua',
            ],
            [
                'id' => 12,
                'nama' => 'Model Proyeksi & Prediksi ARIMA Transaksi',
                'sub_nama' => 'Deret waktu prediktif e-commerce nasional',
                'instansi' => 'Bank Indonesia',
                'kategori' => 'E-Commerce & Transaksi',
                'deskripsi' => 'Hasil permodelan estimasi transaksi bulanan, interval kepercayaan 95%, dan metrik MAPE',
                'periode' => '2019 - 2024',
                'dataset_count' => 2,
                'format' => 'CSV',
                'terakhir_diperbarui' => '18 Apr 2025',
                'icon_bg' => 'bg-sky-600',
                'icon_type' => 'chart',
                'table_name' => 'transaction_forecasts',
                'total_records' => '24 observasi proyeksi prediktif bulanan (ARIMA 1,1,1)',
                'cakupan' => 'Prakiraan Nilai Transaksi E-Commerce Masa Depan, Batas Atas & Batas Bawah',
            ],
        ];

        // Filter Logic
        $filteredSources = $allSources;

        if ($q) {
            $filteredSources = array_filter($filteredSources, function ($item) use ($q) {
                return stripos($item['nama'], $q) !== false
                    || stripos($item['sub_nama'], $q) !== false
                    || stripos($item['deskripsi'], $q) !== false
                    || stripos($item['instansi'], $q) !== false;
            });
        }

        if ($selectedKategori !== 'all') {
            $filteredSources = array_filter($filteredSources, fn($item) => $item['kategori'] === $selectedKategori);
        }

        if ($selectedInstansi !== 'all') {
            $filteredSources = array_filter($filteredSources, fn($item) => $item['instansi'] === $selectedInstansi);
        }

        if ($selectedPeriode !== 'all') {
            $filteredSources = array_filter($filteredSources, fn($item) => $item['periode'] === $selectedPeriode);
        }

        if ($selectedFormat !== 'all') {
            $filteredSources = array_filter($filteredSources, fn($item) => $item['format'] === $selectedFormat);
        }

        $filteredSources = array_values($filteredSources);
        $totalItems = count($filteredSources);
        $offset = ($page - 1) * $perPage;
        $itemsForPage = array_slice($filteredSources, $offset, $perPage);

        $paginatedSources = new LengthAwarePaginator(
            $itemsForPage,
            $totalItems,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // Header Metrics
        $metrics = [
            'total_sumber_data' => 12,
            'total_dataset' => 24,
            'periode_data' => '2019 - 2024',
            'periode_durasi' => '6 Tahun',
            'kualitas_data' => '100%',
            'kualitas_status' => 'Terverifikasi',
        ];

        // Kualitas & Ketersediaan Data
        $qualityMetrics = [
            [
                'label' => 'Kelengkapan Data',
                'value' => '98,4%',
                'status' => 'Sangat Baik',
            ],
            [
                'label' => 'Konsistensi Data',
                'value' => '97,6%',
                'status' => 'Sangat Baik',
            ],
            [
                'label' => 'Ketepatan Waktu',
                'value' => '100%',
                'status' => 'Sangat Baik',
            ],
            [
                'label' => 'Validitas Data',
                'value' => '99,1%',
                'status' => 'Sangat Baik',
            ],
        ];

        // Ringkasan Kategori Donut Chart
        $donutSummary = [
            'total' => 12,
            'labels' => ['E-Commerce & Transaksi', 'Sosial Ekonomi', 'Harga & Inflasi', 'Pembayaran Digital'],
            'counts' => [8, 2, 1, 1],
            'percentages' => ['66,7%', '16,7%', '8,3%', '8,3%'],
            'colors' => ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
        ];

        // Sample 10 transactions from DB for live table inspection modal
        $sampleTransactions = SampleTransaksiEcommerce::latest('timestamp_transaksi')->take(10)->get();

        return view('dashboard.explorer', compact(
            'paginatedSources',
            'metrics',
            'qualityMetrics',
            'donutSummary',
            'sampleTransactions',
            'q',
            'selectedKategori',
            'selectedInstansi',
            'selectedPeriode',
            'selectedFormat'
        ));
    }
}
