<?php

namespace App\Http\Controllers;

use App\Models\DimWilayah;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GeoJsonController extends Controller
{
    /**
     * Serve the standardized 38-province GeoJSON file.
     *
     * @return \Illuminate\Http\Response|JsonResponse
     */
    public function getIndonesiaGeoJson()
    {
        $filePath = public_path('geojson/indonesia-38-provinces.geojson');

        if (!File::exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berkas GeoJSON tidak ditemukan pada ' . $filePath
            ], 404);
        }

        return response(File::get($filePath), 200, [
            'Content-Type' => 'application/json',
            'Cache-Control' => 'public, max-age=86400'
        ]);
    }

    /**
     * Internal static engine to aggregate transactions per province with strict transaksi_id deduplication.
     *
     * @param string $tahun
     * @param string $bulan
     * @return array
     */
    public static function getAggregatedData($tahun = 'all', $bulan = 'all'): array
    {
        // 1. Subquery: Deduplicate transactions by transaksi_id first
        // Fulfills instruction: "Pastikan agregasi tidak menggandakan nilai transaksi jika terdapat beberapa baris dengan transaksi_id yang sama"
        $subquery = DB::table('sample_transaksi_ecommerce')
            ->select(
                'kode_bps',
                'provinsi',
                'transaksi_id',
                DB::raw('MIN(nilai_transaksi_netto_idr) as nilai_transaksi_netto_idr'),
                DB::raw('MIN(diskon_voucher_platform_idr) as diskon_voucher_platform_idr'),
                DB::raw('MIN(durasi_pengiriman_hari) as durasi_pengiriman_hari')
            );

        if ($tahun !== 'all' && !empty($tahun)) {
            $subquery->where('tahun', (int) $tahun);
        }

        if ($bulan !== 'all' && !empty($bulan)) {
            $subquery->where('bulan', (int) $bulan);
        }

        $subquery->groupBy('kode_bps', 'provinsi', 'transaksi_id');

        // 2. Main Query: Left Join dim_wilayah with deduplicated transactions
        // Ensures all 38 provinces are represented and provinces without data are highlighted (has_data = 0)
        $rawResults = DB::table('dim_wilayah as w')
            ->leftJoinSub($subquery, 't', function ($join) {
                $join->on('w.kode_bps', '=', 't.kode_bps');
            })
            ->select(
                'w.kode_bps',
                'w.nama_provinsi as provinsi',
                'w.pulau',
                'w.latitude',
                'w.longitude',
                DB::raw('COUNT(t.transaksi_id) as jumlah_transaksi_unik'),
                DB::raw('COALESCE(SUM(t.nilai_transaksi_netto_idr), 0) as total_nilai_transaksi_netto'),
                DB::raw('COALESCE(SUM(t.diskon_voucher_platform_idr), 0) as total_diskon_voucher'),
                DB::raw('COALESCE(ROUND(AVG(t.durasi_pengiriman_hari), 2), 0) as avg_durasi_pengiriman'),
                DB::raw('CASE WHEN COUNT(t.transaksi_id) > 0 THEN 1 ELSE 0 END as has_data')
            )
            ->groupBy('w.kode_bps', 'w.nama_provinsi', 'w.pulau', 'w.latitude', 'w.longitude')
            ->orderByRaw('CAST(w.kode_bps AS UNSIGNED)')
            ->get();

        $dataByKode = [];
        $dataList = [];

        $totalNettoAll = 0;
        $totalTrxAll = 0;
        $totalVoucherAll = 0;
        $weightedDurasiSum = 0;
        $provincesWithData = 0;

        foreach ($rawResults as $row) {
            $hasData = (bool) $row->has_data;
            $netto = (float) $row->total_nilai_transaksi_netto;
            $trx = (int) $row->jumlah_transaksi_unik;
            $voucher = (float) $row->total_diskon_voucher;
            $durasi = (float) $row->avg_durasi_pengiriman;

            if ($hasData) {
                $totalNettoAll += $netto;
                $totalTrxAll += $trx;
                $totalVoucherAll += $voucher;
                $weightedDurasiSum += ($durasi * $trx);
                $provincesWithData++;
            }

            // Formatting values for UI presentation
            $formattedNetto = $netto >= 1_000_000_000
                ? 'Rp ' . number_format($netto / 1_000_000_000, 2, ',', '.') . ' M'
                : ($netto >= 1_000_000 ? 'Rp ' . number_format($netto / 1_000_000, 2, ',', '.') . ' Jt' : 'Rp ' . number_format($netto, 0, ',', '.'));

            $formattedVoucher = $voucher >= 1_000_000_000
                ? 'Rp ' . number_format($voucher / 1_000_000_000, 2, ',', '.') . ' M'
                : ($voucher >= 1_000_000 ? 'Rp ' . number_format($voucher / 1_000_000, 2, ',', '.') . ' Jt' : 'Rp ' . number_format($voucher, 0, ',', '.'));

            $item = [
                'kode_bps' => (string) $row->kode_bps,
                'provinsi' => $row->provinsi,
                'pulau' => $row->pulau,
                'latitude' => (float) $row->latitude,
                'longitude' => (float) $row->longitude,
                'has_data' => $hasData,
                'nilai_transaksi_netto' => $netto,
                'nilai_transaksi_netto_formatted' => $formattedNetto,
                'jumlah_transaksi_unik' => $trx,
                'jumlah_transaksi_unik_formatted' => number_format($trx, 0, ',', '.') . ' transaksi',
                'total_diskon_voucher' => $voucher,
                'total_diskon_voucher_formatted' => $formattedVoucher,
                'avg_durasi_pengiriman' => $durasi,
                'avg_durasi_pengiriman_formatted' => number_format($durasi, 1, ',', '.') . ' hari',
                // AOV helper
                'aov_idr' => $trx > 0 ? round($netto / $trx, 0) : 0,
                'aov_formatted' => $trx > 0 ? 'Rp ' . number_format(round($netto / $trx, 0), 0, ',', '.') : 'Rp 0'
            ];

            $dataByKode[(string) $row->kode_bps] = $item;
            $dataList[] = $item;
        }

        $nationalAvgDurasi = $totalTrxAll > 0 ? round($weightedDurasiSum / $totalTrxAll, 2) : 0;

        return [
            'meta' => [
                'filter' => [
                    'tahun' => $tahun,
                    'bulan' => $bulan
                ],
                'summary' => [
                    'total_provinsi' => count($rawResults),
                    'provinsi_ada_data' => $provincesWithData,
                    'provinsi_tanpa_data' => count($rawResults) - $provincesWithData,
                    'total_nilai_transaksi_netto' => $totalNettoAll,
                    'total_nilai_transaksi_netto_formatted' => 'Rp ' . number_format($totalNettoAll / 1_000_000_000, 2, ',', '.') . ' M',
                    'total_transaksi_unik' => $totalTrxAll,
                    'total_transaksi_unik_formatted' => number_format($totalTrxAll, 0, ',', '.') . ' transaksi',
                    'total_diskon_voucher' => $totalVoucherAll,
                    'total_diskon_voucher_formatted' => 'Rp ' . number_format($totalVoucherAll / 1_000_000_000, 2, ',', '.') . ' M',
                    'national_avg_durasi' => $nationalAvgDurasi,
                    'national_avg_durasi_formatted' => number_format($nationalAvgDurasi, 1, ',', '.') . ' hari'
                ],
                'indicators' => [
                    'netto' => [
                        'label' => 'Nilai Transaksi Netto',
                        'unit' => 'IDR',
                        'field' => 'nilai_transaksi_netto',
                        'format_field' => 'nilai_transaksi_netto_formatted',
                        'color_palette' => 'Blues'
                    ],
                    'trx' => [
                        'label' => 'Jumlah Transaksi Unik',
                        'unit' => 'Transaksi',
                        'field' => 'jumlah_transaksi_unik',
                        'format_field' => 'jumlah_transaksi_unik_formatted',
                        'color_palette' => 'Purples'
                    ],
                    'voucher' => [
                        'label' => 'Total Diskon Voucher',
                        'unit' => 'IDR',
                        'field' => 'total_diskon_voucher',
                        'format_field' => 'total_diskon_voucher_formatted',
                        'color_palette' => 'Oranges'
                    ],
                    'durasi' => [
                        'label' => 'Rata-Rata Durasi Pengiriman',
                        'unit' => 'Hari',
                        'field' => 'avg_durasi_pengiriman',
                        'format_field' => 'avg_durasi_pengiriman_formatted',
                        'color_palette' => 'Teals'
                    ]
                ]
            ],
            'by_kode_bps' => $dataByKode,
            'list' => $dataList
        ];
    }

    /**
     * Aggregate transactions per province endpoint.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProvinsiAgregasi(Request $request): JsonResponse
    {
        $tahun = $request->query('tahun', 'all');
        $bulan = $request->query('bulan', 'all');

        $result = self::getAggregatedData($tahun, $bulan);

        return response()->json(array_merge(['status' => 'success'], $result));
    }
}
