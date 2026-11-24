<?php

namespace App\Http\Controllers;

use App\Models\FactBpsEkonomi;
use App\Models\ForecastRun;
use App\Services\ArimaForecastService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForecastController extends Controller
{
    protected ArimaForecastService $forecastService;

    public function __construct(ArimaForecastService $forecastService)
    {
        $this->forecastService = $forecastService;
    }

    /**
     * Display the dedicated ARIMA Transaction Value Forecast Page.
     */
    public function index(Request $request): View
    {
        $chartData = $this->forecastService->getChartData();
        $run = $chartData['run'];

        // Factors influencing transaction values
        $factors = [
            [
                'title' => 'Diskon & Promo',
                'desc' => 'Dampak subsidi ongkir dan voucher terhadap peningkatan volume keranjang belanja.',
                'icon' => 'tag'
            ],
            [
                'title' => 'Pertumbuhan Pengguna Aktif',
                'desc' => 'Penetrasi digital shopper di berbagai wilayah kepulauan Indonesia.',
                'icon' => 'users'
            ],
            [
                'title' => 'Daya Beli Masyarakat',
                'desc' => 'Tren pertumbuhan pengeluaran per kapita berdasarkan statistik resmi BPS.',
                'icon' => 'currency'
            ],
            [
                'title' => 'Musiman (Seasonality)',
                'desc' => 'Lonjakan volume transaksi pada momentum festive Ramadan/Lebaran dan Harbolnas Q4.',
                'icon' => 'calendar'
            ],
        ];

        // Academic & Business Insights
        $insights = [
            'Nilai transaksi netto diprediksi tumbuh positif dengan stabilitas volume perputaran digital bulanan.',
            'Jawa Barat, Jawa Timur, dan DKI Jakarta diproyeksikan tetap menjadi kontributor utama nilai transaksi nasional.',
            'Instrumen E-Wallet dan QRIS diprediksi mempertahankan dominasi metode pembayaran di atas 50%.',
            'Tingkat ketepatan waktu pengiriman SLA logistik nasional terjaga pada ambang batas optimal (>87%).',
            'Sinergi daya beli masyarakat BPS menunjukkan korelasi positif terhadap adopsi transaksi belanja digital.'
        ];

        return view('dashboard.prediksi', array_merge($chartData, [
            'run' => $run,
            'factors' => $factors,
            'insights' => $insights,
            'layoutMode' => $request->query('layout', 'public'), // default public full-width
        ]));
    }

    /**
     * Admin-only endpoint to re-run or update ARIMA model training safely.
     */
    public function retrain(Request $request): JsonResponse
    {
        $horizon = (int) $request->input('horizon', 12);
        if ($horizon < 1 || $horizon > 24) {
            return response()->json([
                'status' => 'error',
                'message' => 'Horizon harus berada dalam rentang 1 hingga 24 bulan.'
            ], 422);
        }

        $cutoff = $request->input('train_cutoff', '2024-12');

        try {
            $result = $this->forecastService->runForecastProcess($horizon, $cutoff);

            return response()->json([
                'status' => 'success',
                'message' => 'Model ARIMA berhasil diperbarui dan disimpan ke database.',
                'run_id' => $result['run']?->id,
                'model_order' => $result['run']?->model_order,
                'mape' => $result['run']?->mape,
                'total_predicted_idr' => $result['run']?->total_predicted_idr,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui model: ' . $e->getMessage()
            ], 500);
        }
    }
}
