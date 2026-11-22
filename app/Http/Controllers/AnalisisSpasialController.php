<?php

namespace App\Http\Controllers;

use App\Models\FactBpsEkonomi;
use App\Models\FactIntegrasiDayaBeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisisSpasialController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->query('tahun', '2025');
        $selectedMonth = $request->query('bulan', 'all');

        // 1. Get primary deduplicated transaction aggregations from GeoJsonController
        // Fulfills instructions 3, 6, 11, 12, 13
        $initialData = GeoJsonController::getAggregatedData($selectedYear, $selectedMonth);

        // 2. Fetch BPS Benchmark Data for economic context
        $bpsYear = in_array($selectedYear, ['2024', '2025']) ? (int) $selectedYear : 2025;
        $bpsData = FactBpsEkonomi::where('tahun', $bpsYear)
            ->pluck('total_pengeluaran_idr', 'kode_bps');

        // Enrich items with BPS context
        $enrichedList = collect($initialData['list'])->map(function ($item) use ($bpsData) {
            $bpsExp = (float) ($bpsData[$item['kode_bps']] ?? 0);
            $item['bps_pengeluaran_idr'] = $bpsExp;
            $item['bps_pengeluaran_formatted'] = $bpsExp > 0
                ? 'Rp ' . number_format($bpsExp, 0, ',', '.') . ' / bln'
                : 'Data BPS belum rilis';
            return $item;
        });

        // 3. Jawa vs Luar Jawa Aggregation
        $jawaVsLuar = $enrichedList->groupBy(function ($item) {
            return $item['pulau'] === 'Jawa' ? 'Pulau Jawa' : 'Luar Pulau Jawa';
        })->map(function ($group, $key) {
            $totalGmv = $group->sum('nilai_transaksi_netto');
            $totalTrx = $group->sum('jumlah_transaksi_unik');
            $totalVoucher = $group->sum('total_diskon_voucher');
            $avgAov = $totalTrx > 0 ? $totalGmv / $totalTrx : 0;
            
            $validDurasiItems = $group->filter(fn($i) => $i['jumlah_transaksi_unik'] > 0);
            $weightedDurasiSum = $validDurasiItems->sum(fn($i) => $i['avg_durasi_pengiriman'] * $i['jumlah_transaksi_unik']);
            $avgDurasi = $totalTrx > 0 ? ($weightedDurasiSum / $totalTrx) : 0;

            $avgBpsExp = $group->avg('bps_pengeluaran_idr');

            return [
                'region' => $key,
                'total_provinsi' => $group->count(),
                'provinsi_ada_data' => $group->where('has_data', true)->count(),
                'total_gmv' => $totalGmv,
                'total_trx' => $totalTrx,
                'total_voucher' => $totalVoucher,
                'avg_aov' => round($avgAov, 0),
                'avg_bps_pengeluaran' => round($avgBpsExp, 0),
                'avg_durasi_hari' => round($avgDurasi, 1)
            ];
        });

        // 4. Island Breakdown Stats (Sumatera, Jawa, Bali & Nusa Tenggara, Kalimantan, Sulawesi, Maluku & Papua)
        $islandStats = $enrichedList->groupBy('pulau')->map(function ($group, $pulau) {
            $totalGmv = $group->sum('nilai_transaksi_netto');
            $totalTrx = $group->sum('jumlah_transaksi_unik');
            $totalVoucher = $group->sum('total_diskon_voucher');
            $avgAov = $totalTrx > 0 ? $totalGmv / $totalTrx : 0;

            $validItems = $group->filter(fn($i) => $i['jumlah_transaksi_unik'] > 0);
            $weightedDurasiSum = $validItems->sum(fn($i) => $i['avg_durasi_pengiriman'] * $i['jumlah_transaksi_unik']);
            $avgDurasi = $totalTrx > 0 ? ($weightedDurasiSum / $totalTrx) : 0;
            $avgBps = $group->avg('bps_pengeluaran_idr');

            return [
                'pulau' => $pulau,
                'count_prov' => $group->count(),
                'count_prov_data' => $group->where('has_data', true)->count(),
                'total_gmv' => $totalGmv,
                'total_trx' => $totalTrx,
                'total_voucher' => $totalVoucher,
                'avg_aov' => round($avgAov, 0),
                'avg_bps' => round($avgBps, 0),
                'avg_durasi' => round($avgDurasi, 1)
            ];
        })->sortByDesc('total_gmv');

        $availableYears = ['all', '2024', '2025', '2026'];

        return view('dashboard.spasial', compact(
            'selectedYear',
            'selectedMonth',
            'initialData',
            'jawaVsLuar',
            'islandStats',
            'availableYears'
        ));
    }
}
