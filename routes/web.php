<?php

use App\Http\Controllers\AnalisisSpasialController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataExplorerController;
use App\Http\Controllers\DayaBeliDigitalController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\GeoJsonController;
use App\Http\Controllers\InsightChartController;
use App\Http\Controllers\LaporanExportController;
use App\Http\Controllers\MetodologiController;
use App\Http\Controllers\PolaKonsumsiController;
use App\Http\Controllers\PublicDashboardController;
use App\Http\Controllers\TrenEcommerceController;
use Illuminate\Support\Facades\Route;

// Public Dashboard Route (Tampilan Publik tanpa sidebar sesuai desain referensi)
Route::get('/publik', [PublicDashboardController::class, 'index'])->name('public.dashboard');
Route::get('/public', [PublicDashboardController::class, 'index']);

// Halaman Tren E-Commerce Publik (Sesuai Desain CTA Navbar)
Route::get('/tren', [TrenEcommerceController::class, 'index'])->name('public.tren');
Route::get('/tren-ecommerce', [TrenEcommerceController::class, 'index']);

// Fitur Prediksi Nilai Transaksi E-Commerce (ARIMA)
Route::get('/prediksi', [ForecastController::class, 'index'])->name('forecast.index');
Route::post('/admin/forecast/retrain', [ForecastController::class, 'retrain'])->name('admin.forecast.retrain');

// 20 Insight Charts Module Routes (Koleksi 20 Chart Analitik & Insight Bisnis)
Route::get('/analisis-tren', [InsightChartController::class, 'index'])->name('dashboard.tren');
Route::get('/insight', [InsightChartController::class, 'publicInsight'])->name('public.insight');
Route::get('/koleksi-chart', [InsightChartController::class, 'publicInsight'])->name('public.koleksi-chart');

// Redirect Root URL ke Dashboard Publik
Route::redirect('/', '/publik')->name('dashboard.index');
Route::get('/peneliti', [DashboardController::class, 'index'])->name('dashboard.peneliti');
Route::get('/pola-konsumsi', [PolaKonsumsiController::class, 'index'])->name('dashboard.pola-konsumsi');
Route::get('/daya-beli-digital', [DayaBeliDigitalController::class, 'index'])->name('dashboard.daya-beli');
Route::get('/analisis-spasial', [AnalisisSpasialController::class, 'index'])->name('dashboard.spasial');
Route::get('/data-explorer', [DataExplorerController::class, 'index'])->name('dashboard.explorer');
Route::get('/sumber-data', [DataExplorerController::class, 'index'])->name('dashboard.sumber-data');
Route::get('/metodologi', [MetodologiController::class, 'index'])->name('dashboard.metodologi');

// Export & Reporting Module Routes (PDF & Excel)
Route::get('/laporan-ekspor', [LaporanExportController::class, 'index'])->name('laporan.index');
Route::get('/laporan-ekspor/pdf', [LaporanExportController::class, 'exportPdf'])->name('laporan.pdf');
Route::get('/laporan-ekspor/excel', [LaporanExportController::class, 'exportExcel'])->name('laporan.excel');

// API Routes for Dynamic Interactive Charts & Modals
Route::prefix('api')->group(function () {
    Route::get('/province/{kodeBps}', [ApiController::class, 'getProvinceDetails'])->name('api.province');
    Route::get('/spasial/geojson', [GeoJsonController::class, 'getIndonesiaGeoJson'])->name('api.spasial.geojson');
    Route::get('/spasial/agregasi', [GeoJsonController::class, 'getProvinsiAgregasi'])->name('api.spasial.agregasi');
});
