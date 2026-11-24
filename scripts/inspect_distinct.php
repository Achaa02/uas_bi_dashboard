<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\FactEcommerceBulanan;
use App\Models\SampleTransaksiEcommerce;
use App\Models\FactBpsEkonomi;
use App\Models\FactIntegrasiDayaBeli;

echo "=== PLATFORMS in fact_ecommerce_bulanan ===" . PHP_EOL;
echo json_encode(FactEcommerceBulanan::distinct()->pluck('platform_ecommerce')) . PHP_EOL;

echo "=== CATEGORIES in fact_ecommerce_bulanan ===" . PHP_EOL;
echo json_encode(FactEcommerceBulanan::distinct()->pluck('kategori_produk')) . PHP_EOL;

echo "=== YEARS in fact_ecommerce_bulanan ===" . PHP_EOL;
echo json_encode(FactEcommerceBulanan::distinct()->pluck('tahun')) . PHP_EOL;

echo "=== PAYMENT METHODS in sample_transaksi_ecommerce ===" . PHP_EOL;
echo json_encode(SampleTransaksiEcommerce::distinct()->pluck('metode_pembayaran')) . PHP_EOL;

echo "=== EXPEDITIONS in sample_transaksi_ecommerce ===" . PHP_EOL;
echo json_encode(SampleTransaksiEcommerce::distinct()->pluck('layanan_ekspedisi')) . PHP_EOL;

echo "=== STATUS PENGIRIMAN in sample_transaksi_ecommerce ===" . PHP_EOL;
echo json_encode(SampleTransaksiEcommerce::distinct()->pluck('status_keterlambatan_pengiriman')) . PHP_EOL;

echo "=== YEARS in fact_bps_ekonomi ===" . PHP_EOL;
echo json_encode(FactBpsEkonomi::distinct()->pluck('tahun')) . PHP_EOL;

echo "=== YEARS in fact_integrasi_daya_beli ===" . PHP_EOL;
echo json_encode(FactIntegrasiDayaBeli::distinct()->pluck('tahun')) . PHP_EOL;
