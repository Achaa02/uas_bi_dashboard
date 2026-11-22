<?php

namespace App\Http\Controllers;

use App\Models\DimWilayah;
use App\Models\SampleTransaksiEcommerce;
use Illuminate\Http\Request;

class DataExplorerController extends Controller
{
    public function index(Request $request)
    {
        $query = SampleTransaksiEcommerce::query();

        if ($request->filled('q')) {
            $q = $request->query('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('order_id', 'like', "%{$q}%")
                    ->orWhere('transaksi_id', 'like', "%{$q}%")
                    ->orWhere('provinsi', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori_produk', $request->kategori);
        }

        if ($request->filled('platform') && $request->platform !== 'all') {
            $query->where('platform_ecommerce', $request->platform);
        }

        if ($request->filled('provinsi') && $request->provinsi !== 'all') {
            $query->where('provinsi', $request->provinsi);
        }

        if ($request->filled('metode_bayar') && $request->metode_bayar !== 'all') {
            $query->where('metode_pembayaran', $request->metode_bayar);
        }

        if ($request->filled('status_kirim') && $request->status_kirim !== 'all') {
            $query->where('status_keterlambatan_pengiriman', $request->status_kirim);
        }

        $sortCol = $request->query('sort', 'timestamp_transaksi');
        $sortDir = $request->query('dir', 'desc');
        $allowedSorts = ['order_id', 'timestamp_transaksi', 'nilai_transaksi_netto_idr', 'rating_produk', 'durasi_pengiriman_hari'];

        if (in_array($sortCol, $allowedSorts)) {
            $query->orderBy($sortCol, $sortDir === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderByDesc('timestamp_transaksi');
        }

        $transactions = $query->paginate(25)->withQueryString();

        // Filter dropdown values
        $categories = SampleTransaksiEcommerce::select('kategori_produk')->distinct()->pluck('kategori_produk');
        $platforms = SampleTransaksiEcommerce::select('platform_ecommerce')->distinct()->pluck('platform_ecommerce');
        $provinces = DimWilayah::orderBy('nama_provinsi')->pluck('nama_provinsi');
        $payments = SampleTransaksiEcommerce::select('metode_pembayaran')->distinct()->pluck('metode_pembayaran');
        $statuses = SampleTransaksiEcommerce::select('status_keterlambatan_pengiriman')->distinct()->pluck('status_keterlambatan_pengiriman');

        return view('dashboard.explorer', compact(
            'transactions',
            'categories',
            'platforms',
            'provinces',
            'payments',
            'statuses'
        ));
    }
}
