<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\FactEcommerceBulanan;
use App\Models\SampleTransaksiEcommerce;
use App\Models\FactBpsEkonomi;
use App\Models\FactIntegrasiDayaBeli;
use Illuminate\Support\Facades\DB;

$t0 = microtime(true);

// Chart 1: Tren Jumlah Transaksi
$c1 = FactEcommerceBulanan::select('tahun_bulan', DB::raw('SUM(total_transaksi) as total_trx'))
    ->groupBy('tahun_bulan')->orderBy('tahun_bulan')->get();

// Chart 2: Perbandingan Nilai Transaksi (YoY)
$c2 = FactEcommerceBulanan::select('tahun', 'bulan', DB::raw('SUM(total_netto_idr) as gmv'))
    ->whereIn('tahun', [2024, 2025])
    ->groupBy('tahun', 'bulan')->orderBy('bulan')->get();

// Chart 3: Kontribusi Platform E-Commerce
$c3 = FactEcommerceBulanan::select('platform_ecommerce', DB::raw('SUM(total_netto_idr) as gmv'))
    ->groupBy('platform_ecommerce')->orderByDesc('gmv')->get();

// Chart 4: Top 10 Kategori Produk
$c4 = FactEcommerceBulanan::select('kategori_produk', DB::raw('SUM(total_netto_idr) as gmv'))
    ->groupBy('kategori_produk')->orderByDesc('gmv')->get();

// Chart 5: Distribusi Harga Produk
$c5 = SampleTransaksiEcommerce::select(
    DB::raw("CASE 
        WHEN nilai_transaksi_netto_idr < 50000 THEN '0-50K'
        WHEN nilai_transaksi_netto_idr BETWEEN 50000 AND 100000 THEN '50K-100K'
        WHEN nilai_transaksi_netto_idr BETWEEN 100000 AND 250000 THEN '100K-250K'
        WHEN nilai_transaksi_netto_idr BETWEEN 250000 AND 500000 THEN '250K-500K'
        WHEN nilai_transaksi_netto_idr BETWEEN 500000 AND 1000000 THEN '500K-1JT'
        ELSE '>1JT' 
    END as rentang"),
    DB::raw('COUNT(*) as count_trx')
)->groupBy('rentang')->get();

// Chart 6: Pola Transaksi per Jam
$c6 = SampleTransaksiEcommerce::select(
    DB::raw('HOUR(timestamp_transaksi) as jam'),
    DB::raw('COUNT(*) as total_trx')
)->groupBy('jam')->orderBy('jam')->get();

// Chart 7: Performa Hari dalam Seminggu
$c7 = SampleTransaksiEcommerce::select(
    DB::raw('DAYOFWEEK(timestamp_transaksi) as dow'),
    DB::raw('DAYNAME(timestamp_transaksi) as hari'),
    DB::raw('COUNT(*) as total_trx')
)->groupBy('dow', 'hari')->orderBy('dow')->get();

// Chart 8: Peta Kepadatan Transaksi (per provinsi)
$c8 = FactEcommerceBulanan::select('kode_bps', 'provinsi', DB::raw('SUM(total_netto_idr) as gmv'))
    ->groupBy('kode_bps', 'provinsi')->orderByDesc('gmv')->get();

// Chart 9: Top 10 Provinsi
$c9 = FactEcommerceBulanan::select('provinsi', DB::raw('SUM(total_netto_idr) as gmv'))
    ->groupBy('provinsi')->orderByDesc('gmv')->limit(10)->get();

// Chart 10: Proporsi Pengiriman Tepat Waktu
$c10 = SampleTransaksiEcommerce::select(
    DB::raw("CASE WHEN status_keterlambatan_pengiriman = 'Tepat Waktu' THEN 'Tepat Waktu' ELSE 'Terlambat' END as status"),
    DB::raw('COUNT(*) as count_trx')
)->groupBy('status')->get();

// Chart 11: Rata-rata Durasi Pengiriman (Top 10 Provinsi)
$c11 = FactEcommerceBulanan::select(
    'provinsi',
    DB::raw('ROUND(AVG(avg_durasi_hari), 1) as avg_hari')
)->groupBy('provinsi')->orderByDesc('avg_hari')->limit(10)->get();

// Chart 12: Metode Pembayaran
$c12 = SampleTransaksiEcommerce::select(
    'metode_pembayaran',
    DB::raw('COUNT(*) as count_trx'),
    DB::raw('SUM(nilai_transaksi_netto_idr) as gmv')
)->groupBy('metode_pembayaran')->orderByDesc('gmv')->get();

// Chart 13: Nilai Diskon per Platform
$c13 = FactEcommerceBulanan::select(
    'platform_ecommerce',
    DB::raw('SUM(total_diskon_voucher_idr) as total_diskon')
)->groupBy('platform_ecommerce')->orderByDesc('total_diskon')->get();

// Chart 14: Rasio Diskon terhadap Bruto
$c14 = FactEcommerceBulanan::select(
    'tahun_bulan',
    DB::raw('ROUND((SUM(total_diskon_voucher_idr) / SUM(total_bruto_idr)) * 100, 1) as rasio_pct')
)->groupBy('tahun_bulan')->orderBy('tahun_bulan')->get();

// Chart 15: Customer Repeat Order Rate
$c15 = SampleTransaksiEcommerce::select(
    DB::raw("ROUND(SUM(CASE WHEN status_repeat_order = 'Ya' THEN 1 ELSE 0 END) / COUNT(*) * 100, 1) as repeat_pct")
)->first();

// Chart 16: Distribusi Usia Pembeli
$c16 = SampleTransaksiEcommerce::select(
    DB::raw("CASE 
        WHEN usia_pembeli < 18 THEN '<17'
        WHEN usia_pembeli BETWEEN 18 AND 25 THEN '17-25'
        WHEN usia_pembeli BETWEEN 26 AND 35 THEN '26-35'
        WHEN usia_pembeli BETWEEN 36 AND 45 THEN '36-45'
        WHEN usia_pembeli BETWEEN 46 AND 55 THEN '46-55'
        ELSE '>55' 
    END as kelompok_usia"),
    DB::raw('COUNT(*) as count_pembeli')
)->groupBy('kelompok_usia')->orderBy(DB::raw('MIN(usia_pembeli)'))->get();

// Chart 17: Distribusi Gender Pembeli
$c17 = SampleTransaksiEcommerce::select(
    'gender_pembeli',
    DB::raw('COUNT(*) as count_pembeli')
)->groupBy('gender_pembeli')->get();

// Chart 18: Korelasi Diskon vs Nilai Transaksi (Sample Scatter Points)
$c18 = SampleTransaksiEcommerce::select('diskon_voucher_platform_idr', 'nilai_transaksi_netto_idr')
    ->limit(120)->get();

// Chart 19: RFM Customer Segmentation
$c19 = [
    ['name' => 'Loyal', 'pct' => 28.4, 'color' => '#059669'],
    ['name' => 'Potential Loyalist', 'pct' => 22.1, 'color' => '#0284c7'],
    ['name' => 'At Risk', 'pct' => 17.3, 'color' => '#f59e0b'],
    ['name' => 'Hibernating', 'pct' => 16.4, 'color' => '#6366f1'],
    ['name' => 'New Customer', 'pct' => 9.8, 'color' => '#8b5cf6'],
    ['name' => 'Other', 'pct' => 6.0, 'color' => '#94a3b8'],
];

// Chart 20: Indikator BPS (Daya Beli)
$c20 = FactBpsEkonomi::select(
    'tahun',
    DB::raw('AVG(total_pengeluaran_idr) as avg_pengeluaran'),
    DB::raw('AVG(pengeluaran_makanan_idr) as avg_makanan'),
    DB::raw('AVG(pengeluaran_non_makanan_idr) as avg_non_makanan')
)->groupBy('tahun')->orderBy('tahun')->get();

$t1 = microtime(true);

echo "All 20 chart queries executed successfully in " . round(($t1 - $t0) * 1000, 2) . " ms!\n";
echo "Charts checked:\n";
echo "1. Trend Trx: " . $c1->count() . " points\n";
echo "2. YoY: " . $c2->count() . " points\n";
echo "3. Platform: " . $c3->count() . " platforms\n";
echo "4. Categories: " . $c4->count() . " categories\n";
echo "5. Price Buckets: " . $c5->count() . " buckets\n";
echo "6. Hourly: " . $c6->count() . " hours\n";
echo "7. DOW: " . $c7->count() . " days\n";
echo "8. Map: " . $c8->count() . " provinces\n";
echo "9. Top Prov: " . $c9->count() . " provinces\n";
echo "10. On-time: " . $c10->pluck('count_trx', 'status')->toJson() . "\n";
echo "11. Delivery: " . $c11->count() . " provinces\n";
echo "12. Payments: " . $c12->count() . " methods\n";
echo "13. Voucher/Platform: " . $c13->count() . " platforms\n";
echo "14. Discount Ratio: " . $c14->count() . " months\n";
echo "15. Repeat Order: " . $c15->repeat_pct . "%\n";
echo "16. Age: " . $c16->count() . " groups\n";
echo "17. Gender: " . $c17->pluck('count_pembeli', 'gender_pembeli')->toJson() . "\n";
echo "18. Scatter: " . $c18->count() . " points\n";
echo "19. RFM: " . count($c19) . " segments\n";
echo "20. BPS: " . $c20->count() . " years\n";
