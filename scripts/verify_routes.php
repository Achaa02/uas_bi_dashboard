<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$urls = [
    '/' => '/publik',
    '/publik' => 'Pemetaan Pola Konsumsi dan Daya Beli Digital di Indonesia',
    '/tren' => 'Tren E-Commerce Indonesia',
    '/tren-ecommerce' => 'Tren E-Commerce Indonesia',
    '/pola-konsumsi' => 'Pola Konsumsi',
    '/daya-beli-digital' => 'Daya Beli BPS',
    '/analisis-spasial' => 'Peta Indonesia Interaktif',
    '/data-explorer' => 'Data Explorer',
    '/metodologi' => 'Metodologi',
    '/analisis-tren' => '20 Chart Analitik & Pemetaan Insight Bisnis',
    '/insight' => '20 Chart Analitik & Pemetaan Insight Bisnis',
    '/prediksi' => 'Prediksi Nilai Transaksi E-Commerce (ARIMA)',
    '/laporan-ekspor' => 'Ekspor Laporan',
    '/api/province/31' => '"provinsi":"DKI Jakarta"',
    '/api/spasial/geojson' => '"FeatureCollection"',
    '/api/spasial/agregasi' => '"status":"success"'
];

$allOk = true;

echo "============================================================\n";
echo "TESTING BI DASHBOARD ROUTES VIA LARAVEL HTTP KERNEL\n";
echo "============================================================\n";

foreach ($urls as $url => $expectedContent) {
    $request = Illuminate\Http\Request::create($url, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    $content = $response->getContent();
    
    if ($url === '/') {
        $target = $response->headers->get('Location') ?? '';
        $pass = ($status === 302 && str_contains($target, 'publik'));
        printf("%-25s | Status: %d | Redirects to: %s | Result: %s\n", 
            $url, 
            $status, 
            $target ?: 'NONE', 
            $pass ? 'PASS' : 'FAIL'
        );
    } else {
        $contains = str_contains($content, $expectedContent);
        $pass = ($status === 200 && $contains);
        
        printf("%-25s | Status: %d | Contains Expected: %s | Result: %s\n", 
            $url, 
            $status, 
            $contains ? 'YES' : 'NO', 
            $pass ? 'PASS' : 'FAIL'
        );
    }
    
    if (!$pass) {
        $allOk = false;
        echo "Error preview:\n" . substr(strip_tags($content), 0, 400) . "\n";
    }
}

echo "============================================================\n";
if ($allOk) {
    echo "ALL ROUTES VERIFIED AND PASSING SUCCESSFULLY (HTTP 200)!\n";
} else {
    echo "SOME ROUTES FAILED VERIFICATION.\n";
}
echo "============================================================\n";
