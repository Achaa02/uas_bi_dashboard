<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_dashboard_root_redirects_to_publik(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/publik');
    }

    public function test_dashboard_index_renders_successfully(): void
    {
        $response = $this->get('/peneliti');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Utama');
        $response->assertSee('TOTAL TRANSAKSI');
        $response->assertSee('NILAI TRANSAKSI (NETTO)');
        $response->assertSee('RATA-RATA NILAI TRANSAKSI');
        $response->assertSee('TOTAL DISKON VOUCHER');
        $response->assertSee('RATA-RATA DURASI PENGIRIMAN');
    }

    public function test_public_dashboard_renders_successfully(): void
    {
        $response = $this->get('/publik');
        $response->assertStatus(200);
        $response->assertSee('Pemetaan Pola Konsumsi dan Daya Beli Digital di Indonesia');
        $response->assertSee('Total Transaksi');
        $response->assertSee('Nilai Transaksi Netto');
        $response->assertSee('Rata-rata Nilai Transaksi');
        $response->assertSee('Total Diskon Voucher');
        $response->assertSee('Rata-rata Durasi Pengiriman');
        $response->assertSee('publicMap');
        $response->assertSee('Prediksi Nilai Transaksi E-Commerce (ARIMA)');
        $response->assertSee('arimaForecastChart');
        $response->assertSee('Akurasi Model (MAPE)');
        $response->assertSee('Batas Atas (95%)');
    }

    public function test_prediksi_page_renders_successfully(): void
    {
        $response = $this->get('/prediksi');
        $response->assertStatus(200);
        $response->assertSee('Prediksi Nilai Transaksi E-Commerce (ARIMA)');
        $response->assertSee('Batas Atas (95%)');
        $response->assertSee('Batas Bawah (95%)');
        $response->assertSee('Akurasi Model (MAPE)');
        $response->assertSee('Faktor yang Diprediksi Mempengaruhi Nilai Transaksi');
        $response->assertSee('arimaForecastChart');
    }

    public function test_pola_konsumsi_renders_successfully(): void
    {
        $response = $this->get('/pola-konsumsi');
        $response->assertStatus(200);
        $response->assertSee('Pola Konsumsi');
    }

    public function test_daya_beli_digital_renders_successfully(): void
    {
        $response = $this->get('/daya-beli-digital');
        $response->assertStatus(200);
        $response->assertSee('Daya Beli BPS');
    }

    public function test_analisis_spasial_renders_successfully(): void
    {
        $response = $this->get('/analisis-spasial');
        $response->assertStatus(200);
        $response->assertSee('Peta Indonesia Interaktif');
        $response->assertSee('Nilai Transaksi Netto');
        $response->assertSee('Jumlah Transaksi Unik');
        $response->assertSee('Total Diskon Voucher');
        $response->assertSee('Rata-Rata Durasi Pengiriman');
        $response->assertSee('choroplethMap');
    }

    public function test_analisis_tren_renders_all_20_charts_successfully(): void
    {
        $response = $this->get('/analisis-tren');
        $response->assertStatus(200);
        $response->assertSee('20 Chart Analitik');
        $response->assertSee('Tren Jumlah Transaksi');
        $response->assertSee('Perbandingan Nilai Transaksi');
        $response->assertSee('Kontribusi Platform E-Commerce');
        $response->assertSee('Top 10 Kategori Produk');
        $response->assertSee('Distribusi Harga Produk');
        $response->assertSee('Pola Transaksi per Jam');
        $response->assertSee('Performa Hari dalam Seminggu');
        $response->assertSee('Peta Kepadatan Transaksi');
        $response->assertSee('Top 10 Provinsi');
        $response->assertSee('Proporsi Pengiriman Tepat Waktu');
        $response->assertSee('Rata-rata Durasi Pengiriman');
        $response->assertSee('Metode Pembayaran');
        $response->assertSee('Nilai Diskon per Platform');
        $response->assertSee('Rasio Diskon terhadap Bruto');
        $response->assertSee('Customer Repeat Order Rate');
        $response->assertSee('Distribusi Usia Pembeli');
        $response->assertSee('Distribusi Gender Pembeli');
        $response->assertSee('Korelasi Diskon vs Nilai Transaksi');
        $response->assertSee('RFM Customer Segmentation');
        $response->assertSee('Indikator BPS (Daya Beli)');
    }

    public function test_public_insight_renders_successfully(): void
    {
        $response = $this->get('/insight');
        $response->assertStatus(200);
        $response->assertSee('20 Chart Analitik');
        $response->assertSee('Customer Repeat Order Rate');
        $response->assertSee('RFM Customer Segmentation');
    }

    public function test_public_tren_ecommerce_renders_successfully(): void
    {
        $response = $this->get('/tren');
        $response->assertStatus(200);
        $response->assertSee('Tren E-Commerce Indonesia');
        $response->assertSee('Total Nilai Transaksi');
        $response->assertSee('Total Transaksi');
        $response->assertSee('Total Diskon Voucher');
        $response->assertSee('Rata-rata Durasi Pengiriman');
        $response->assertSee('Rata-rata Nilai Transaksi');
        $response->assertSee('trenGmvLineChart');
        $response->assertSee('topProvHorizontalChart');
        $response->assertSee('platformDonutChart');
        $response->assertSee('categoryBarChart');
        $response->assertSee('aovLineChart');
        $response->assertSee('Prediksi Nilai Transaksi');
        $response->assertSee('prediksiModal');
    }

    public function test_api_spasial_geojson_returns_valid_geojson_feature_collection(): void
    {
        $response = $this->get('/api/spasial/geojson');
        $response->assertStatus(200);
        $json = $response->json();
        $this->assertEquals('FeatureCollection', $json['type'] ?? null);
        $this->assertCount(38, $json['features'] ?? []);
        $this->assertEquals('31', $json['features'][10]['properties']['kode_bps'] ?? null); // DKI Jakarta
    }

    public function test_api_spasial_agregasi_returns_deduplicated_province_metrics(): void
    {
        $response = $this->get('/api/spasial/agregasi?tahun=2025');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'meta' => [
                'filter' => ['tahun', 'bulan'],
                'summary' => [
                    'total_provinsi',
                    'provinsi_ada_data',
                    'total_nilai_transaksi_netto',
                    'total_transaksi_unik',
                    'total_diskon_voucher',
                    'national_avg_durasi'
                ],
                'indicators' => ['netto', 'trx', 'voucher', 'durasi']
            ],
            'by_kode_bps',
            'list'
        ]);

        $json = $response->json();
        $this->assertEquals('success', $json['status']);
        $this->assertEquals(38, $json['meta']['summary']['total_provinsi']);
        $this->assertArrayHasKey('31', $json['by_kode_bps']);
        $this->assertEquals('DKI Jakarta', $json['by_kode_bps']['31']['provinsi']);
        $this->assertGreaterThan(0, $json['by_kode_bps']['31']['nilai_transaksi_netto']);
        $this->assertGreaterThan(0, $json['by_kode_bps']['31']['jumlah_transaksi_unik']);
    }

    public function test_data_explorer_renders_successfully(): void
    {
        $response = $this->get('/data-explorer');
        $response->assertStatus(200);
        $response->assertSee('Data Explorer');
    }

    public function test_metodologi_renders_successfully(): void
    {
        $response = $this->get('/metodologi');
        $response->assertStatus(200);
        $response->assertSee('Metodologi');
    }

    public function test_laporan_ekspor_index_renders_successfully(): void
    {
        $response = $this->get('/laporan-ekspor?provinsi=DKI+Jakarta&tahun=2025');
        $response->assertStatus(200);
        $response->assertSee('Ekspor Laporan');
        $response->assertSee('DKI Jakarta');
    }

    public function test_export_pdf_generates_valid_pdf_stream(): void
    {
        $response = $this->get('/laporan-ekspor/pdf?provinsi=DKI+Jakarta&tahun=2025');
        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('DKI_Jakarta_2025.pdf', $response->headers->get('Content-Disposition') ?? '');
    }

    public function test_export_excel_generates_valid_xlsx_stream(): void
    {
        $response = $this->get('/laporan-ekspor/excel?provinsi=DKI+Jakarta&tahun=2025');
        $response->assertStatus(200);
        $this->assertStringContainsString('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $response->headers->get('Content-Type') ?? '');
        $this->assertStringContainsString('DKI_Jakarta_2025.xlsx', $response->headers->get('Content-Disposition') ?? '');
    }

    public function test_api_province_details_returns_json(): void
    {
        $response = $this->get('/api/province/31');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'provinsi',
            'pulau',
            'tahun',
            'ecom_netto',
            'ecom_trx',
            'ecom_aov',
            'bps_total_pengeluaran',
            'tipologi',
        ]);
    }
}
