<?php

namespace App\Http\Controllers;

use App\Models\DimWilayah;
use App\Models\FactEcommerceBulanan;
use App\Models\SampleTransaksiEcommerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolaKonsumsiController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->query('tahun', 'all');
        $selectedKategori = $request->query('kategori', 'all');
        $selectedPlatform = $request->query('platform', 'all');

        $query = FactEcommerceBulanan::query();
        $sampleQuery = SampleTransaksiEcommerce::query();

        if ($selectedYear !== 'all') {
            $query->where('tahun', $selectedYear);
            $sampleQuery->where('tahun', $selectedYear);
        }
        if ($selectedKategori !== 'all') {
            $query->where('kategori_produk', $selectedKategori);
            $sampleQuery->where('kategori_produk', $selectedKategori);
        }
        if ($selectedPlatform !== 'all') {
            $query->where('platform_ecommerce', $selectedPlatform);
            $sampleQuery->where('platform_ecommerce', $selectedPlatform);
        }

        // 1. Kategori Produk Performance Matrix
        $kategoriStats = (clone $query)
            ->select(
                'kategori_produk',
                DB::raw('SUM(total_netto_idr) as gmv'),
                DB::raw('SUM(total_transaksi) as total_trx'),
                DB::raw('SUM(total_kuantitas) as total_qty'),
                DB::raw('ROUND(SUM(total_netto_idr)/SUM(total_transaksi), 0) as aov'),
                DB::raw('ROUND(AVG(avg_rating), 2) as rating'),
                DB::raw('ROUND(AVG(persentase_repeat_order), 2) as repeat_rate'),
                DB::raw('ROUND(AVG(avg_sensitivitas_ongkir), 4) as ongkir_sens')
            )
            ->groupBy('kategori_produk')
            ->orderByDesc('gmv')
            ->get();

        // 2. Metode Pembayaran FinTech (dari 50k real sample)
        $paymentStats = (clone $sampleQuery)
            ->select('metode_pembayaran', DB::raw('COUNT(*) as total_trx'), DB::raw('SUM(nilai_transaksi_netto_idr) as total_belanja'))
            ->groupBy('metode_pembayaran')
            ->orderByDesc('total_trx')
            ->get();

        // 3. Efisiensi Promosi & Diskon
        $promoStats = (clone $query)
            ->select(
                DB::raw('SUM(total_bruto_idr) as bruto'),
                DB::raw('SUM(total_diskon_voucher_idr) as voucher'),
                DB::raw('SUM(total_ongkir_riil_idr) as ongkir_riil'),
                DB::raw('SUM(total_subsidi_ongkir_idr) as subsidi_ongkir'),
                DB::raw('SUM(total_netto_idr) as netto')
            )
            ->first();

        // 4. Performa Kurir & Logistik
        $logisticsStats = (clone $sampleQuery)
            ->select(
                'layanan_ekspedisi',
                DB::raw('COUNT(*) as total_trx'),
                DB::raw('ROUND(AVG(durasi_pengiriman_hari), 1) as avg_durasi'),
                DB::raw("ROUND(SUM(CASE WHEN status_keterlambatan_pengiriman = 'Tepat Waktu' THEN 1 ELSE 0 END) / COUNT(*) * 100, 2) as on_time_rate")
            )
            ->groupBy('layanan_ekspedisi')
            ->orderByDesc('total_trx')
            ->get();

        // Filter options
        $availableCategories = FactEcommerceBulanan::select('kategori_produk')->distinct()->pluck('kategori_produk');
        $availablePlatforms = FactEcommerceBulanan::select('platform_ecommerce')->distinct()->pluck('platform_ecommerce');
        $availableYears = FactEcommerceBulanan::select('tahun')->distinct()->orderBy('tahun')->pluck('tahun');

        return view('dashboard.pola-konsumsi', compact(
            'selectedYear',
            'selectedKategori',
            'selectedPlatform',
            'kategoriStats',
            'paymentStats',
            'promoStats',
            'logisticsStats',
            'availableCategories',
            'availablePlatforms',
            'availableYears'
        ));
    }
}
