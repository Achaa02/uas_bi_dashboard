<?php

use App\Http\Controllers\AnalisisSpasialController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataExplorerController;
use App\Http\Controllers\DayaBeliDigitalController;
use App\Http\Controllers\GeoJsonController;
use App\Http\Controllers\LaporanExportController;
use App\Http\Controllers\MetodologiController;
use App\Http\Controllers\PolaKonsumsiController;
use App\Http\Controllers\PublicDashboardController;
use Illuminate\Support\Facades\Route;

// Public Dashboard Route (Tampilan Publik tanpa sidebar sesuai desain referensi)
Route::get('/publik', [PublicDashboardController::class, 'index'])->name('public.dashboard');
Route::get('/public', [PublicDashboardController::class, 'index']);

// Business Intelligence Dashboard Navigation Routes (Dashboard Peneliti)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/pola-konsumsi', [PolaKonsumsiController::class, 'index'])->name('dashboard.pola-konsumsi');
Route::get('/daya-beli-digital', [DayaBeliDigitalController::class, 'index'])->name('dashboard.daya-beli');
Route::get('/analisis-spasial', [AnalisisSpasialController::class, 'index'])->name('dashboard.spasial');
Route::get('/data-explorer', [DataExplorerController::class, 'index'])->name('dashboard.explorer');
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
