<?php

namespace App\Http\Controllers;

use App\Models\DimWilayah;
use App\Models\FactBpsEkonomi;
use App\Models\FactIntegrasiDayaBeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DayaBeliDigitalController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->query('tahun', '2025');
        $selectedPulau = $request->query('pulau', 'all');

        $query = FactIntegrasiDayaBeli::where('tahun', $selectedYear);

        if ($selectedPulau !== 'all') {
            $query->where('pulau', $selectedPulau);
        }

        $integratedData = $query->orderByDesc('total_pengeluaran_idr')->get();

        // 1. Matriks 4 Kuadran Tipologi Wilayah
        $kuadran1 = $integratedData->filter(fn($r) => str_contains($r->tipologi_daya_beli_digital, 'Kuadran I'));
        $kuadran2 = $integratedData->filter(fn($r) => str_contains($r->tipologi_daya_beli_digital, 'Kuadran II'));
        $kuadran3 = $integratedData->filter(fn($r) => str_contains($r->tipologi_daya_beli_digital, 'Kuadran III'));
        $kuadran4 = $integratedData->filter(fn($r) => str_contains($r->tipologi_daya_beli_digital, 'Kuadran IV'));

        // 2. Korelasi BPS vs E-Commerce (Scatter Data)
        $scatterPoints = $integratedData->map(function ($r) {
            return [
                'x' => (float) $r->total_pengeluaran_idr,
                'y' => (float) $r->ecom_aov_idr,
                'r' => max(4, min(20, round($r->ecom_total_transaksi / 8000, 1))),
                'provinsi' => $r->provinsi,
                'pulau' => $r->pulau,
                'trx' => number_format($r->ecom_total_transaksi),
                'rasio_non_makanan' => number_format($r->rasio_aov_thd_non_makanan_bps * 100, 2) . '%',
                'tipologi' => $r->tipologi_daya_beli_digital,
            ];
        });

        // 3. Rata-rata Nasional & Disparitas
        $avgBpsTotal = $integratedData->avg('total_pengeluaran_idr') ?? 0;
        $avgBpsNonMakanan = $integratedData->avg('pengeluaran_non_makanan_idr') ?? 0;
        $avgAov = $integratedData->avg('ecom_aov_idr') ?? 0;
        $avgRasioAovNonMakanan = $integratedData->avg('rasio_aov_thd_non_makanan_bps') ?? 0;

        // Disparitas (Rasio Provinsi Tertinggi vs Terendah)
        $maxBps = $integratedData->max('total_pengeluaran_idr') ?? 1;
        $minBps = $integratedData->min('total_pengeluaran_idr') ?? 1;
        $disparitasBps = $minBps > 0 ? round($maxBps / $minBps, 2) : 1;

        $maxEcom = $integratedData->max('ecom_aov_idr') ?? 1;
        $minEcom = $integratedData->min('ecom_aov_idr') ?? 1;
        $disparitasEcom = $minEcom > 0 ? round($maxEcom / $minEcom, 2) : 1;

        // 4. Panel Tren BPS 2011-2025 untuk Provinsi Utama
        $top5Prov = ['DKI Jakarta', 'Jawa Barat', 'Jawa Timur', 'Sumatera Utara', 'Bali'];
        $bpsTrends = FactBpsEkonomi::whereIn('provinsi', $top5Prov)
            ->orderBy('tahun')
            ->get()
            ->groupBy('provinsi');

        $availableYears = FactIntegrasiDayaBeli::select('tahun')->distinct()->orderBy('tahun')->pluck('tahun');
        $availableIslands = DimWilayah::select('pulau')->distinct()->orderBy('pulau')->pluck('pulau');

        return view('dashboard.daya-beli', compact(
            'selectedYear',
            'selectedPulau',
            'integratedData',
            'kuadran1',
            'kuadran2',
            'kuadran3',
            'kuadran4',
            'scatterPoints',
            'avgBpsTotal',
            'avgBpsNonMakanan',
            'avgAov',
            'avgRasioAovNonMakanan',
            'disparitasBps',
            'disparitasEcom',
            'bpsTrends',
            'availableYears',
            'availableIslands'
        ));
    }
}
