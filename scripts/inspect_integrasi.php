<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\FactIntegrasiDayaBeli;
use Illuminate\Support\Facades\DB;

echo "=== COLUMNS in fact_integrasi_daya_beli ===" . PHP_EOL;
$cols = DB::select("SHOW COLUMNS FROM fact_integrasi_daya_beli");
foreach ($cols as $c) {
    echo $c->Field . ' (' . $c->Type . ')' . PHP_EOL;
}

echo PHP_EOL . "=== TOP 5 ROWS in fact_integrasi_daya_beli (2024) ===" . PHP_EOL;
$rows = FactIntegrasiDayaBeli::where('tahun', 2024)->orderByDesc('ecom_total_netto_idr')->limit(5)->get();
foreach ($rows as $r) {
    echo "Provinsi: {$r->provinsi}, Netto: " . number_format($r->ecom_total_netto_idr) . ", Trx: " . number_format($r->ecom_total_transaksi) . ", AOV: " . number_format($r->ecom_aov_idr) . ", Pengeluaran BPS: " . number_format($r->total_pengeluaran_idr) . ", Tipologi: {$r->tipologi_daya_beli_digital}" . PHP_EOL;
}
