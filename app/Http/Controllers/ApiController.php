<?php

namespace App\Http\Controllers;

use App\Models\FactEcommerceBulanan;
use App\Models\FactIntegrasiDayaBeli;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getProvinceDetails(Request $request, string $kodeBps): JsonResponse
    {
        $year = $request->query('tahun', '2025');

        $integ = FactIntegrasiDayaBeli::where('kode_bps', $kodeBps)
            ->where('tahun', $year)
            ->first();

        if (!$integ) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $categoryStats = FactEcommerceBulanan::where('kode_bps', $kodeBps)
            ->where('tahun', $year)
            ->select('kategori_produk', DB::raw('SUM(total_netto_idr) as gmv'), DB::raw('SUM(total_transaksi) as trx'))
            ->groupBy('kategori_produk')
            ->orderByDesc('gmv')
            ->get();

        $platformStats = FactEcommerceBulanan::where('kode_bps', $kodeBps)
            ->where('tahun', $year)
            ->select('platform_ecommerce', DB::raw('SUM(total_netto_idr) as gmv'))
            ->groupBy('platform_ecommerce')
            ->orderByDesc('gmv')
            ->get();

        return response()->json([
            'provinsi' => $integ->provinsi,
            'pulau' => $integ->pulau,
            'tahun' => $integ->tahun,
            'ecom_netto' => (float) $integ->ecom_total_netto_idr,
            'ecom_trx' => (int) $integ->ecom_total_transaksi,
            'ecom_aov' => (float) $integ->ecom_aov_idr,
            'bps_total_pengeluaran' => (float) $integ->total_pengeluaran_idr,
            'bps_non_makanan' => (float) $integ->pengeluaran_non_makanan_idr,
            'rasio_non_makanan' => (float) $integ->rasio_aov_thd_non_makanan_bps,
            'tipologi' => $integ->tipologi_daya_beli_digital,
            'categories' => $categoryStats,
            'platforms' => $platformStats,
        ]);
    }
}
