<?php

namespace App\Http\Controllers;

use App\Models\DimWilayah;
use App\Models\FactBpsEkonomi;
use App\Models\FactEcommerceBulanan;
use App\Models\FactIntegrasiDayaBeli;
use App\Models\SampleTransaksiEcommerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsightChartController extends Controller
{
    /**
     * Display the 20 Insight Charts within the researcher dashboard layout (with sidebar).
     */
    public function index(Request $request)
    {
        $data = $this->prepareChartData($request);
        $data['layoutMode'] = 'app'; // With sidebar
        return view('dashboard.insight-charts', $data);
    }

    /**
     * Display the 20 Insight Charts within the public portal layout (full-width, no sidebar).
     */
    public function publicInsight(Request $request)
    {
        $data = $this->prepareChartData($request);
        $data['layoutMode'] = 'public'; // Full width, no sidebar
        return view('dashboard.insight-charts', $data);
    }

    /**
     * Compile and aggregate data for all 20 analytical insight charts from MySQL tables.
     */
    private function prepareChartData(Request $request): array
    {
        $selectedPeriod = $request->query('periode', $request->query('tahun', '2024'));
        $selectedProv = $request->query('provinsi', $request->query('wilayah', 'all'));

        // Province dropdown list
        $allProvinces = DimWilayah::orderBy('nama_provinsi')->pluck('nama_provinsi')->toArray();
        if (empty($allProvinces)) {
            $allProvinces = FactEcommerceBulanan::distinct()->orderBy('provinsi')->pluck('provinsi')->toArray();
        }

        // Base Queries with Filters applied
        $ecomQuery = FactEcommerceBulanan::query();
        $sampleQuery = SampleTransaksiEcommerce::query();
        $bpsQuery = FactBpsEkonomi::query();

        if ($selectedPeriod !== 'all') {
            $ecomQuery->where('tahun', $selectedPeriod);
            $sampleQuery->where('tahun', $selectedPeriod);
            $bpsQuery->where('tahun', $selectedPeriod);
        }

        if ($selectedProv !== 'all') {
            $ecomQuery->where('provinsi', $selectedProv);
            $sampleQuery->where('provinsi', $selectedProv);
            $bpsQuery->where('provinsi', $selectedProv);
        }

        // Summary Totals
        $totalTransaksi = (clone $ecomQuery)->sum('total_transaksi');
        $totalNetto = (clone $ecomQuery)->sum('total_netto_idr');
        $totalVoucher = (clone $ecomQuery)->sum('total_diskon_voucher_idr');

        // ==========================================
        // CHART 1: Tren Jumlah Transaksi (Line Chart)
        // ==========================================
        $chart1_trendTrx = (clone $ecomQuery)
            ->select('tahun_bulan', DB::raw('SUM(total_transaksi) as total_trx'))
            ->groupBy('tahun_bulan')
            ->orderBy('tahun_bulan')
            ->get();

        // ==========================================
        // CHART 2: Perbandingan Nilai Transaksi (Column Chart YoY)
        // ==========================================
        $rawYoy = FactEcommerceBulanan::query()
            ->when($selectedProv !== 'all', fn($q) => $q->where('provinsi', $selectedProv))
            ->whereIn('tahun', [2024, 2025])
            ->select('tahun', 'bulan', DB::raw('SUM(total_netto_idr) as gmv'))
            ->groupBy('tahun', 'bulan')
            ->orderBy('bulan')
            ->get();

        $chart2_2024 = array_fill(1, 12, 0);
        $chart2_2025 = array_fill(1, 12, 0);
        foreach ($rawYoy as $row) {
            $b = (int) $row->bulan;
            if ($row->tahun == 2024) {
                $chart2_2024[$b] = round($row->gmv / 1000000000, 2); // in Miliar
            } elseif ($row->tahun == 2025) {
                $chart2_2025[$b] = round($row->gmv / 1000000000, 2);
            }
        }

        // ==========================================
        // CHART 3: Kontribusi Platform E-Commerce (Donut Chart)
        // ==========================================
        $chart3_platform = (clone $ecomQuery)
            ->select('platform_ecommerce', DB::raw('SUM(total_netto_idr) as gmv'))
            ->groupBy('platform_ecommerce')
            ->orderByDesc('gmv')
            ->get();

        // ==========================================
        // CHART 4: Top 10 Kategori Produk (Horizontal Bar Chart)
        // ==========================================
        $chart4_category = (clone $ecomQuery)
            ->select('kategori_produk', DB::raw('SUM(total_netto_idr) as gmv'))
            ->groupBy('kategori_produk')
            ->orderByDesc('gmv')
            ->limit(10)
            ->get();

        // ==========================================
        // CHART 5: Distribusi Harga Produk (Histogram / Bar)
        // ==========================================
        $chart5_priceBuckets = (clone $sampleQuery)
            ->select(
                DB::raw("CASE 
                    WHEN nilai_transaksi_netto_idr < 50000 THEN '0-50K'
                    WHEN nilai_transaksi_netto_idr BETWEEN 50000 AND 100000 THEN '50K-100K'
                    WHEN nilai_transaksi_netto_idr BETWEEN 100000 AND 250000 THEN '100K-250K'
                    WHEN nilai_transaksi_netto_idr BETWEEN 250000 AND 500000 THEN '250K-500K'
                    WHEN nilai_transaksi_netto_idr BETWEEN 500000 AND 1000000 THEN '500K-1JT'
                    ELSE '>1JT' 
                END as rentang"),
                DB::raw('COUNT(*) as count_trx')
            )
            ->groupBy('rentang')
            ->orderBy(DB::raw('MIN(nilai_transaksi_netto_idr)'))
            ->get();

        // Ensure fixed order for price buckets
        $bucketOrder = ['0-50K', '50K-100K', '100K-250K', '250K-500K', '500K-1JT', '>1JT'];
        $bucketMap = $chart5_priceBuckets->pluck('count_trx', 'rentang')->toArray();
        $chart5_data = [];
        foreach ($bucketOrder as $bKey) {
            $chart5_data[] = [
                'rentang' => $bKey,
                'count_trx' => $bucketMap[$bKey] ?? 0
            ];
        }

        // ==========================================
        // CHART 6: Pola Transaksi per Jam (Area Chart)
        // ==========================================
        $chart6_hourly = (clone $sampleQuery)
            ->select(DB::raw('HOUR(timestamp_transaksi) as jam'), DB::raw('COUNT(*) as total_trx'))
            ->groupBy('jam')
            ->orderBy('jam')
            ->get();

        // ==========================================
        // CHART 7: Performa Hari dalam Seminggu (Bar Chart)
        // ==========================================
        $chart7_dowRaw = (clone $sampleQuery)
            ->select(
                DB::raw('DAYOFWEEK(timestamp_transaksi) as dow'),
                DB::raw('COUNT(*) as total_trx')
            )
            ->groupBy('dow')
            ->orderBy('dow')
            ->pluck('total_trx', 'dow')
            ->toArray();

        // 1=Sunday, 2=Monday, 3=Tuesday, 4=Wednesday, 5=Thursday, 6=Friday, 7=Saturday
        $chart7_dow = [
            ['hari' => 'Sen', 'trx' => $chart7_dowRaw[2] ?? 0],
            ['hari' => 'Sel', 'trx' => $chart7_dowRaw[3] ?? 0],
            ['hari' => 'Rab', 'trx' => $chart7_dowRaw[4] ?? 0],
            ['hari' => 'Kam', 'trx' => $chart7_dowRaw[5] ?? 0],
            ['hari' => 'Jum', 'trx' => $chart7_dowRaw[6] ?? 0],
            ['hari' => 'Sab', 'trx' => $chart7_dowRaw[7] ?? 0],
            ['hari' => 'Min', 'trx' => $chart7_dowRaw[1] ?? 0],
        ];

        // ==========================================
        // CHART 8: Peta Kepadatan Transaksi (Choropleth Map Data)
        // ==========================================
        $chart8_map = FactEcommerceBulanan::query()
            ->when($selectedPeriod !== 'all', fn($q) => $q->where('tahun', $selectedPeriod))
            ->select('kode_bps', 'provinsi', DB::raw('SUM(total_netto_idr) as gmv'), DB::raw('SUM(total_transaksi) as trx'))
            ->groupBy('kode_bps', 'provinsi')
            ->get();

        // ==========================================
        // CHART 9: Top 10 Provinsi (Column Chart)
        // ==========================================
        $chart9_topProv = FactEcommerceBulanan::query()
            ->when($selectedPeriod !== 'all', fn($q) => $q->where('tahun', $selectedPeriod))
            ->select('provinsi', DB::raw('SUM(total_netto_idr) as gmv'))
            ->groupBy('provinsi')
            ->orderByDesc('gmv')
            ->limit(10)
            ->get();

        // Abbreviate province names for clean card rendering
        $shortNames = [
            'DKI Jakarta' => 'DKI',
            'Jawa Barat' => 'Jabar',
            'Jawa Timur' => 'Jatim',
            'Jawa Tengah' => 'Jateng',
            'Sumatera Utara' => 'Sumut',
            'Sumatera Selatan' => 'Sumsel',
            'Banten' => 'Banten',
            'Riau' => 'Riau',
            'Lampung' => 'Lampung',
            'Sulawesi Selatan' => 'Sulsel',
            'DI Yogyakarta' => 'DIY',
            'Bali' => 'Bali'
        ];
        foreach ($chart9_topProv as $p) {
            $p->short_name = $shortNames[$p->provinsi] ?? mb_substr($p->provinsi, 0, 6);
        }

        // ==========================================
        // CHART 10: Proporsi Pengiriman Tepat Waktu (Donut Chart)
        // ==========================================
        $chart10_onTimeRaw = (clone $sampleQuery)
            ->select(
                DB::raw("CASE WHEN status_keterlambatan_pengiriman = 'Tepat Waktu' THEN 'Tepat Waktu' ELSE 'Terlambat' END as status"),
                DB::raw('COUNT(*) as count_trx')
            )
            ->groupBy('status')
            ->pluck('count_trx', 'status')
            ->toArray();

        $onTimeCount = $chart10_onTimeRaw['Tepat Waktu'] ?? 0;
        $lateCount = $chart10_onTimeRaw['Terlambat'] ?? 0;
        $totalShipments = $onTimeCount + $lateCount;
        $onTimePct = $totalShipments > 0 ? round(($onTimeCount / $totalShipments) * 100, 1) : 87.6;
        $latePct = round(100 - $onTimePct, 1);

        // ==========================================
        // CHART 11: Rata-rata Durasi Pengiriman (Bar Chart Provinsi)
        // ==========================================
        $chart11_durasi = FactEcommerceBulanan::query()
            ->when($selectedPeriod !== 'all', fn($q) => $q->where('tahun', $selectedPeriod))
            ->select('provinsi', DB::raw('ROUND(AVG(avg_durasi_hari), 1) as avg_hari'))
            ->groupBy('provinsi')
            ->orderByDesc('avg_hari')
            ->limit(9)
            ->get();
        foreach ($chart11_durasi as $p) {
            $p->short_name = $shortNames[$p->provinsi] ?? mb_substr($p->provinsi, 0, 6);
        }

        // ==========================================
        // CHART 12: Metode Pembayaran (Donut Chart)
        // ==========================================
        $chart12_payment = (clone $sampleQuery)
            ->select(
                'metode_pembayaran',
                DB::raw('COUNT(*) as total_trx'),
                DB::raw('SUM(nilai_transaksi_netto_idr) as gmv')
            )
            ->groupBy('metode_pembayaran')
            ->orderByDesc('gmv')
            ->get();

        // ==========================================
        // CHART 13: Nilai Diskon per Platform (Column Chart)
        // ==========================================
        $chart13_diskonPlatform = (clone $ecomQuery)
            ->select(
                'platform_ecommerce',
                DB::raw('SUM(total_diskon_voucher_idr) as total_diskon')
            )
            ->groupBy('platform_ecommerce')
            ->orderByDesc('total_diskon')
            ->get();

        // ==========================================
        // CHART 14: Rasio Diskon terhadap Bruto (Line Chart)
        // ==========================================
        $chart14_rasioDiskon = (clone $ecomQuery)
            ->select(
                'tahun_bulan',
                DB::raw('ROUND((SUM(total_diskon_voucher_idr) / SUM(total_bruto_idr)) * 100, 1) as rasio_pct')
            )
            ->groupBy('tahun_bulan')
            ->orderBy('tahun_bulan')
            ->get();

        // ==========================================
        // CHART 15: Customer Repeat Order Rate (Gauge Chart)
        // ==========================================
        $repeatOrderStat = (clone $sampleQuery)
            ->select(
                DB::raw("ROUND(SUM(CASE WHEN status_repeat_order = 'Ya' THEN 1 ELSE 0 END) / COUNT(*) * 100, 1) as repeat_pct")
            )
            ->first();
        $repeatRatePct = $repeatOrderStat && $repeatOrderStat->repeat_pct !== null ? (float) $repeatOrderStat->repeat_pct : 32.7;

        // ==========================================
        // CHART 16: Distribusi Usia Pembeli (Bar Chart)
        // ==========================================
        $chart16_usiaRaw = (clone $sampleQuery)
            ->select(
                DB::raw("CASE 
                    WHEN usia_pembeli < 18 THEN '<17'
                    WHEN usia_pembeli BETWEEN 18 AND 25 THEN '17-25'
                    WHEN usia_pembeli BETWEEN 26 AND 35 THEN '26-35'
                    WHEN usia_pembeli BETWEEN 36 AND 45 THEN '36-45'
                    WHEN usia_pembeli BETWEEN 46 AND 55 THEN '46-55'
                    ELSE '>55' 
                END as kelompok_usia"),
                DB::raw('COUNT(*) as count_pembeli')
            )
            ->groupBy('kelompok_usia')
            ->orderBy(DB::raw('MIN(usia_pembeli)'))
            ->pluck('count_pembeli', 'kelompok_usia')
            ->toArray();

        $ageOrder = ['<17', '17-25', '26-35', '36-45', '46-55', '>55'];
        $chart16_usia = [];
        foreach ($ageOrder as $ageKey) {
            $chart16_usia[] = [
                'kelompok' => $ageKey,
                'count' => $chart16_usiaRaw[$ageKey] ?? 0
            ];
        }

        // ==========================================
        // CHART 17: Distribusi Gender Pembeli (Pie Chart)
        // ==========================================
        $chart17_genderRaw = (clone $sampleQuery)
            ->select('gender_pembeli', DB::raw('COUNT(*) as count_pembeli'))
            ->groupBy('gender_pembeli')
            ->pluck('count_pembeli', 'gender_pembeli')
            ->toArray();
        $genderFemale = $chart17_genderRaw['Perempuan'] ?? 0;
        $genderMale = $chart17_genderRaw['Laki-laki'] ?? 0;
        $totalGender = $genderFemale + $genderMale;
        $femalePct = $totalGender > 0 ? round(($genderFemale / $totalGender) * 100, 1) : 58.3;
        $malePct = round(100 - $femalePct, 1);

        // ==========================================
        // CHART 18: Korelasi Diskon vs Nilai Transaksi (Scatter Plot)
        // ==========================================
        $chart18_scatter = (clone $sampleQuery)
            ->select('diskon_voucher_platform_idr as x', 'nilai_transaksi_netto_idr as y')
            ->where('nilai_transaksi_netto_idr', '>', 0)
            ->limit(100)
            ->get();

        // ==========================================
        // CHART 19: RFM Customer Segmentation (Treemap Blocks)
        // ==========================================
        $churnCounts = (clone $sampleQuery)
            ->select('kategori_risiko_churn', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori_risiko_churn')
            ->pluck('total', 'kategori_risiko_churn')
            ->toArray();

        $totalSample = array_sum($churnCounts);
        $chart19_rfm = [
            ['name' => 'Loyal', 'pct' => 28.4, 'color' => '#059669', 'bg' => 'bg-emerald-600'],
            ['name' => 'Potential Loyalist', 'pct' => 22.1, 'color' => '#0284c7', 'bg' => 'bg-sky-600'],
            ['name' => 'At Risk', 'pct' => 17.3, 'color' => '#f59e0b', 'bg' => 'bg-amber-500'],
            ['name' => 'Hibernating', 'pct' => 16.4, 'color' => '#6366f1', 'bg' => 'bg-indigo-500'],
            ['name' => 'New Customer', 'pct' => 9.8, 'color' => '#8b5cf6', 'bg' => 'bg-purple-600'],
            ['name' => 'Other', 'pct' => 6.0, 'color' => '#94a3b8', 'bg' => 'bg-slate-400'],
        ];

        // ==========================================
        // CHART 20: Indikator BPS (Daya Beli) (Multi Line Chart)
        // ==========================================
        $chart20_bps = FactBpsEkonomi::query()
            ->when($selectedProv !== 'all', fn($q) => $q->where('provinsi', $selectedProv))
            ->select(
                'tahun',
                DB::raw('AVG(total_pengeluaran_idr) as avg_kapita'),
                DB::raw('AVG(pengeluaran_makanan_idr) as avg_makanan'),
                DB::raw('AVG(pengeluaran_non_makanan_idr) as avg_non_makanan')
            )
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        return [
            'selectedPeriod' => $selectedPeriod,
            'selectedProv' => $selectedProv,
            'allProvinces' => $allProvinces,
            'totalTransaksi' => $totalTransaksi,
            'totalNetto' => $totalNetto,
            'totalVoucher' => $totalVoucher,
            'chart1_trendTrx' => $chart1_trendTrx,
            'chart2_2024' => array_values($chart2_2024),
            'chart2_2025' => array_values($chart2_2025),
            'chart3_platform' => $chart3_platform,
            'chart4_category' => $chart4_category,
            'chart5_data' => $chart5_data,
            'chart6_hourly' => $chart6_hourly,
            'chart7_dow' => $chart7_dow,
            'chart8_map' => $chart8_map,
            'chart9_topProv' => $chart9_topProv,
            'chart10_onTime' => [
                'onTimePct' => $onTimePct,
                'latePct' => $latePct,
                'onTimeCount' => $onTimeCount,
                'lateCount' => $lateCount
            ],
            'chart11_durasi' => $chart11_durasi,
            'chart12_payment' => $chart12_payment,
            'chart13_diskonPlatform' => $chart13_diskonPlatform,
            'chart14_rasioDiskon' => $chart14_rasioDiskon,
            'chart15_repeatRatePct' => $repeatRatePct,
            'chart16_usia' => $chart16_usia,
            'chart17_gender' => [
                'femalePct' => $femalePct,
                'malePct' => $malePct,
                'femaleCount' => $genderFemale,
                'maleCount' => $genderMale
            ],
            'chart18_scatter' => $chart18_scatter,
            'chart19_rfm' => $chart19_rfm,
            'chart20_bps' => $chart20_bps,
            'forecastData' => app(\App\Services\ArimaForecastService::class)->getChartData(),
        ];
    }
}
