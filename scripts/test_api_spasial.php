<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "Testing /api/spasial/geojson ...\n";
$req1 = Illuminate\Http\Request::create('/api/spasial/geojson', 'GET');
$res1 = $kernel->handle($req1);
echo "Status: " . $res1->getStatusCode() . " | Length: " . strlen($res1->getContent()) . " bytes\n";
$geo = json_decode($res1->getContent(), true);
echo "GeoJSON type: " . ($geo['type'] ?? 'none') . " | Features: " . count($geo['features'] ?? []) . "\n";

echo "\nTesting /api/spasial/agregasi?tahun=2025 ...\n";
$req2 = Illuminate\Http\Request::create('/api/spasial/agregasi?tahun=2025', 'GET');
$res2 = $kernel->handle($req2);
echo "Status: " . $res2->getStatusCode() . "\n";
$data = json_decode($res2->getContent(), true);
echo "Summary: " . json_encode($data['meta']['summary'], JSON_PRETTY_PRINT) . "\n";
echo "Sample Prov 31 (DKI Jakarta): " . json_encode($data['by_kode_bps']['31'], JSON_PRETTY_PRINT) . "\n";
echo "Sample Prov 96 (Papua Pegunungan): " . json_encode($data['by_kode_bps']['96'], JSON_PRETTY_PRINT) . "\n";
