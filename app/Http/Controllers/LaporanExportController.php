<?php

namespace App\Http\Controllers;

use App\Models\DimWilayah;
use App\Models\FactBpsEkonomi;
use App\Models\FactEcommerceBulanan;
use App\Models\FactIntegrasiDayaBeli;
use App\Models\SampleTransaksiEcommerce;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanExportController extends Controller
{
    public function index(Request $request)
    {
        $selectedProv = $request->query('provinsi', 'DKI Jakarta');
        $selectedYear = $request->query('tahun', '2025');

        $provinces = DimWilayah::orderBy('nama_provinsi')->get();
        $wilayah = DimWilayah::where('nama_provinsi', $selectedProv)->first() ?? $provinces->first();
        $selectedProv = $wilayah->nama_provinsi;

        $availableYears = FactIntegrasiDayaBeli::select('tahun')->distinct()->orderBy('tahun')->pluck('tahun');

        // 1. Data Integrasi Provinsi
        $integ = FactIntegrasiDayaBeli::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->first();

        // 2. Kinerja per Kategori Produk di Provinsi ini
        $kategoriStats = FactEcommerceBulanan::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->select(
                'kategori_produk',
                DB::raw('SUM(total_netto_idr) as gmv'),
                DB::raw('SUM(total_transaksi) as trx'),
                DB::raw('SUM(total_kuantitas) as qty'),
                DB::raw('ROUND(SUM(total_netto_idr)/SUM(total_transaksi), 0) as aov'),
                DB::raw('ROUND(AVG(avg_rating), 2) as rating'),
                DB::raw('ROUND(AVG(persentase_repeat_order), 2) as repeat_rate'),
                DB::raw('ROUND(AVG(avg_sensitivitas_ongkir), 4) as ongkir_sens')
            )
            ->groupBy('kategori_produk')
            ->orderByDesc('gmv')
            ->get();

        // 3. Pangsa Platform di Provinsi ini
        $platformStats = FactEcommerceBulanan::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->select('platform_ecommerce', DB::raw('SUM(total_netto_idr) as gmv'), DB::raw('SUM(total_transaksi) as trx'))
            ->groupBy('platform_ecommerce')
            ->orderByDesc('gmv')
            ->get();

        // 4. Panel BPS Historis Provinsi ini (2011–2025)
        $bpsHistory = FactBpsEkonomi::where('provinsi', $selectedProv)
            ->orderBy('tahun')
            ->get();

        // 5. Sampel Transaksi Riil Provinsi ini (limit 20 untuk preview)
        $sampleTrx = SampleTransaksiEcommerce::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->limit(20)
            ->get();

        return view('dashboard.laporan', compact(
            'selectedProv',
            'selectedYear',
            'provinces',
            'wilayah',
            'availableYears',
            'integ',
            'kategoriStats',
            'platformStats',
            'bpsHistory',
            'sampleTrx'
        ));
    }

    public function exportPdf(Request $request)
    {
        $selectedProv = $request->query('provinsi', 'DKI Jakarta');
        $selectedYear = $request->query('tahun', '2025');

        $wilayah = DimWilayah::where('nama_provinsi', $selectedProv)->firstOrFail();

        $integ = FactIntegrasiDayaBeli::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->first();

        $kategoriStats = FactEcommerceBulanan::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->select(
                'kategori_produk',
                DB::raw('SUM(total_netto_idr) as gmv'),
                DB::raw('SUM(total_transaksi) as trx'),
                DB::raw('ROUND(SUM(total_netto_idr)/SUM(total_transaksi), 0) as aov'),
                DB::raw('ROUND(AVG(avg_rating), 2) as rating'),
                DB::raw('ROUND(AVG(persentase_repeat_order), 2) as repeat_rate'),
                DB::raw('ROUND(AVG(avg_sensitivitas_ongkir), 4) as ongkir_sens')
            )
            ->groupBy('kategori_produk')
            ->orderByDesc('gmv')
            ->get();

        $platformStats = FactEcommerceBulanan::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->select('platform_ecommerce', DB::raw('SUM(total_netto_idr) as gmv'), DB::raw('SUM(total_transaksi) as trx'))
            ->groupBy('platform_ecommerce')
            ->orderByDesc('gmv')
            ->get();

        $bpsHistory = FactBpsEkonomi::where('provinsi', $selectedProv)
            ->whereIn('tahun', [2021, 2022, 2023, 2024, 2025])
            ->orderBy('tahun')
            ->get();

        $printedAt = now()->translatedFormat('d F Y H:i:s');

        $pdf = Pdf::loadView('exports.laporan-pdf', compact(
            'wilayah',
            'integ',
            'kategoriStats',
            'platformStats',
            'bpsHistory',
            'selectedYear',
            'printedAt'
        ))->setPaper('a4', 'portrait');

        $fileName = 'Laporan_BI_Konsumsi_Daya_Beli_' . str_replace(' ', '_', $wilayah->nama_provinsi) . '_' . $selectedYear . '.pdf';

        return $pdf->download($fileName);
    }

    public function exportExcel(Request $request)
    {
        $selectedProv = $request->query('provinsi', 'DKI Jakarta');
        $selectedYear = $request->query('tahun', '2025');

        $wilayah = DimWilayah::where('nama_provinsi', $selectedProv)->firstOrFail();

        $integ = FactIntegrasiDayaBeli::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->first();

        $kategoriStats = FactEcommerceBulanan::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->select(
                'kategori_produk',
                DB::raw('SUM(total_netto_idr) as gmv'),
                DB::raw('SUM(total_transaksi) as trx'),
                DB::raw('SUM(total_kuantitas) as qty'),
                DB::raw('ROUND(SUM(total_netto_idr)/SUM(total_transaksi), 0) as aov'),
                DB::raw('ROUND(AVG(avg_rating), 2) as rating'),
                DB::raw('ROUND(AVG(persentase_repeat_order), 2) as repeat_rate'),
                DB::raw('ROUND(AVG(avg_durasi_hari), 1) as avg_durasi'),
                DB::raw('ROUND(AVG(avg_sensitivitas_ongkir), 4) as ongkir_sens')
            )
            ->groupBy('kategori_produk')
            ->orderByDesc('gmv')
            ->get();

        $platformStats = FactEcommerceBulanan::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->select('platform_ecommerce', DB::raw('SUM(total_netto_idr) as gmv'), DB::raw('SUM(total_transaksi) as trx'))
            ->groupBy('platform_ecommerce')
            ->orderByDesc('gmv')
            ->get();

        $bpsHistory = FactBpsEkonomi::where('provinsi', $selectedProv)
            ->orderBy('tahun')
            ->get();

        $sampleRows = SampleTransaksiEcommerce::where('provinsi', $selectedProv)
            ->where('tahun', $selectedYear)
            ->limit(200)
            ->get();

        // Create Spreadsheet
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('BI Dashboard Penelitian')
            ->setTitle("Laporan Analitik {$selectedProv} {$selectedYear}")
            ->setSubject('Integrasi E-Commerce dan Statistik Pendapatan BPS');

        // Style Helpers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F172A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '334155']]],
        ];
        $subHeaderStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => '0F172A'], 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2E8F0']],
        ];

        // SHEET 1: RINGKASAN EKSEKUTIF
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Ringkasan Eksekutif');
        $sheet1->setShowGridLines(true);

        $sheet1->setCellValue('A1', 'LAPORAN BUSINESS INTELLIGENCE POLA KONSUMSI & DAYA BELI DIGITAL');
        $sheet1->mergeCells('A1:D1');
        $sheet1->getStyle('A1')->getFont()->setBold(true)->setSize(14)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('0F172A'));

        $sheet1->setCellValue('A2', "Provinsi: {$wilayah->nama_provinsi} | Kode BPS: {$wilayah->kode_bps} | Gugus: {$wilayah->pulau} | Tahun Analisis: {$selectedYear}");
        $sheet1->mergeCells('A2:D2');
        $sheet1->getStyle('A2')->getFont()->setItalic(true)->setSize(10);

        // Metadata Table
        $sheet1->setCellValue('A4', 'INDIKATOR MAKRO TERINTEGRASI');
        $sheet1->setCellValue('B4', 'NILAI OBSERVASI');
        $sheet1->setCellValue('C4', 'SATUAN');
        $sheet1->setCellValue('D4', 'SUMBER DATA & CATATAN METODOLOGI');
        $sheet1->getStyle('A4:D4')->applyFromArray($headerStyle);

        $rowsSheet1 = [
            ['Total Belanja Netto E-Commerce', $integ ? (float) $integ->ecom_total_netto_idr : 0, 'Rupiah', 'Big Data 5 Juta Transaksi E-Commerce'],
            ['Total Transaksi E-Commerce', $integ ? (int) $integ->ecom_total_transaksi : 0, 'Pesanan', 'Log Transaksi Belanja Konsumen'],
            ['Average Order Value (AOV)', $integ ? (float) $integ->ecom_aov_idr : 0, 'Rupiah/Trx', 'Rata-rata Pengeluaran Belanja per Keranjang'],
            ['Pengeluaran per Kapita Sebulan BPS', $integ ? (float) $integ->total_pengeluaran_idr : 0, 'Rupiah/Kapita/Bln', 'BPS Survei Sosial Ekonomi Nasional (Susenas)'],
            ['Pengeluaran Makanan BPS', $integ ? (float) $integ->pengeluaran_makanan_idr : 0, 'Rupiah/Kapita/Bln', 'Porsi Kebutuhan Pangan Pokok Masyarakat'],
            ['Pengeluaran Non-Makanan BPS', $integ ? (float) $integ->pengeluaran_non_makanan_idr : 0, 'Rupiah/Kapita/Bln', 'Kapasitas Belanja Sekunder/Tersier'],
            ['Rasio AOV thd Pengeluaran Non-Makanan', $integ ? ((float) $integ->rasio_aov_thd_non_makanan_bps * 100) : 0, 'Persen (%)', 'Proporsi Nilai Belanja Digital thd Alokasi Non-Pangan'],
            ['Klasifikasi Tipologi Wilayah', $integ ? $integ->tipologi_daya_beli_digital : 'N/A', 'Kategori', 'Analisis Kuadran Daya Beli Riil vs Konsumsi Digital'],
        ];

        $rIdx = 5;
        foreach ($rowsSheet1 as $row) {
            $sheet1->setCellValue("A{$rIdx}", $row[0]);
            $sheet1->setCellValue("B{$rIdx}", $row[1]);
            $sheet1->setCellValue("C{$rIdx}", $row[2]);
            $sheet1->setCellValue("D{$rIdx}", $row[3]);

            if (is_numeric($row[1])) {
                if ($row[2] === 'Rupiah' || $row[2] === 'Rupiah/Kapita/Bln' || $row[2] === 'Rupiah/Trx') {
                    $sheet1->getStyle("B{$rIdx}")->getNumberFormat()->setFormatCode('#,##0');
                } elseif ($row[2] === 'Persen (%)') {
                    $sheet1->getStyle("B{$rIdx}")->getNumberFormat()->setFormatCode('0.00"%"');
                } else {
                    $sheet1->getStyle("B{$rIdx}")->getNumberFormat()->setFormatCode('#,##0');
                }
            }
            $rIdx++;
        }
        foreach (range('A', 'D') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // SHEET 2: KINERJA KOMODITAS & PLATFORM
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Komoditas & Platform');
        $sheet2->setShowGridLines(true);

        $sheet2->setCellValue('A1', "RINCIAN KINERJA 7 KOMODITAS UMKM - {$selectedProv} ({$selectedYear})");
        $sheet2->getStyle('A1')->getFont()->setBold(true)->setSize(12);

        $catHeaders = ['Kategori Produk', 'Total Transaksi', 'Kuantitas Item', 'Total GMV Netto (Rp)', 'AOV (Rp)', 'Rating', 'Repeat Order (%)', 'Durasi Kirim (Hari)', 'Sensitivitas Ongkir'];
        $colLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
        foreach ($catHeaders as $i => $h) {
            $sheet2->setCellValue("{$colLetters[$i]}3", $h);
        }
        $sheet2->getStyle('A3:I3')->applyFromArray($headerStyle);

        $rIdx = 4;
        foreach ($kategoriStats as $k) {
            $sheet2->setCellValue("A{$rIdx}", $k->kategori_produk);
            $sheet2->setCellValue("B{$rIdx}", (int) $k->trx);
            $sheet2->setCellValue("C{$rIdx}", (int) $k->qty);
            $sheet2->setCellValue("D{$rIdx}", (float) $k->gmv);
            $sheet2->setCellValue("E{$rIdx}", (float) $k->aov);
            $sheet2->setCellValue("F{$rIdx}", (float) $k->rating);
            $sheet2->setCellValue("G{$rIdx}", (float) $k->repeat_rate);
            $sheet2->setCellValue("H{$rIdx}", (float) $k->avg_durasi);
            $sheet2->setCellValue("I{$rIdx}", (float) $k->ongkir_sens);

            $sheet2->getStyle("B{$rIdx}:C{$rIdx}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet2->getStyle("D{$rIdx}:E{$rIdx}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet2->getStyle("G{$rIdx}")->getNumberFormat()->setFormatCode('0.00"%"');
            $rIdx++;
        }

        // Platform Table Below
        $rIdx += 2;
        $sheet2->setCellValue("A{$rIdx}", "PANGSA PASAR PLATFORM E-COMMERCE - {$selectedProv} ({$selectedYear})");
        $sheet2->getStyle("A{$rIdx}")->getFont()->setBold(true)->setSize(12);
        $rIdx++;

        $sheet2->setCellValue("A{$rIdx}", 'Platform E-Commerce');
        $sheet2->setCellValue("B{$rIdx}", 'Total Transaksi');
        $sheet2->setCellValue("C{$rIdx}", 'Total GMV Netto (Rp)');
        $sheet2->setCellValue("D{$rIdx}", 'Pangsa Pasar (%)');
        $sheet2->getStyle("A{$rIdx}:D{$rIdx}")->applyFromArray($headerStyle);
        $rIdx++;

        $totalProvGmv = $platformStats->sum('gmv');
        foreach ($platformStats as $p) {
            $pct = $totalProvGmv > 0 ? ($p->gmv / $totalProvGmv * 100) : 0;
            $sheet2->setCellValue("A{$rIdx}", $p->platform_ecommerce);
            $sheet2->setCellValue("B{$rIdx}", (int) $p->trx);
            $sheet2->setCellValue("C{$rIdx}", (float) $p->gmv);
            $sheet2->setCellValue("D{$rIdx}", (float) $pct);

            $sheet2->getStyle("B{$rIdx}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet2->getStyle("C{$rIdx}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet2->getStyle("D{$rIdx}")->getNumberFormat()->setFormatCode('0.00"%"');
            $rIdx++;
        }
        foreach (range('A', 'I') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        // SHEET 3: PANEL HISTORIS BPS (2011-2025)
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Historis BPS 2011-2025');
        $sheet3->setShowGridLines(true);

        $sheet3->setCellValue('A1', "PANEL PENGELUARAN PER KAPITA SEBULAN BPS (2011-2025) - {$selectedProv}");
        $sheet3->getStyle('A1')->getFont()->setBold(true)->setSize(12);

        $bpsHeaders = ['Tahun', 'Pengeluaran Makanan (Rp)', 'Pengeluaran Bukan Makanan (Rp)', 'Total Pengeluaran (Rp)', '% Makanan', '% Bukan Makanan'];
        $colsBps = ['A', 'B', 'C', 'D', 'E', 'F'];
        foreach ($bpsHeaders as $i => $h) {
            $sheet3->setCellValue("{$colsBps[$i]}3", $h);
        }
        $sheet3->getStyle('A3:F3')->applyFromArray($headerStyle);

        $rIdx = 4;
        foreach ($bpsHistory as $b) {
            $sheet3->setCellValue("A{$rIdx}", (int) $b->tahun);
            $sheet3->setCellValue("B{$rIdx}", (float) $b->pengeluaran_makanan_idr);
            $sheet3->setCellValue("C{$rIdx}", (float) $b->pengeluaran_non_makanan_idr);
            $sheet3->setCellValue("D{$rIdx}", (float) $b->total_pengeluaran_idr);
            $sheet3->setCellValue("E{$rIdx}", (float) $b->persentase_makanan);
            $sheet3->setCellValue("F{$rIdx}", (float) $b->persentase_non_makanan);

            $sheet3->getStyle("B{$rIdx}:D{$rIdx}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet3->getStyle("E{$rIdx}:F{$rIdx}")->getNumberFormat()->setFormatCode('0.00"%"');
            $rIdx++;
        }
        foreach (range('A', 'F') as $col) {
            $sheet3->getColumnDimension($col)->setAutoSize(true);
        }

        // SHEET 4: SAMPEL TRANSAKSI MIKRO
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Sampel Transaksi Riil');
        $sheet4->setShowGridLines(true);

        $sheet4->setCellValue('A1', "SAMPEL OBSERVASI TRANSAKSI MIKRO - {$selectedProv} ({$selectedYear})");
        $sheet4->getStyle('A1')->getFont()->setBold(true)->setSize(12);

        $sampHeaders = ['Order ID', 'Timestamp', 'Kategori Produk', 'Platform', 'Bruto (Rp)', 'Diskon (Rp)', 'Ongkir (Rp)', 'Subsidi (Rp)', 'Netto (Rp)', 'Metode Bayar', 'Kurir', 'Durasi (Hari)', 'Rating', 'Repeat Order'];
        $colLettersSamp = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'];
        foreach ($sampHeaders as $i => $h) {
            $sheet4->setCellValue("{$colLettersSamp[$i]}3", $h);
        }
        $sheet4->getStyle('A3:N3')->applyFromArray($headerStyle);

        $rIdx = 4;
        foreach ($sampleRows as $s) {
            $sheet4->setCellValue("A{$rIdx}", $s->order_id);
            $sheet4->setCellValue("B{$rIdx}", $s->timestamp_transaksi?->format('Y-m-d H:i'));
            $sheet4->setCellValue("C{$rIdx}", $s->kategori_produk);
            $sheet4->setCellValue("D{$rIdx}", $s->platform_ecommerce);
            $sheet4->setCellValue("E{$rIdx}", (float) $s->nilai_transaksi_bruto_idr);
            $sheet4->setCellValue("F{$rIdx}", (float) $s->diskon_voucher_platform_idr);
            $sheet4->setCellValue("G{$rIdx}", (float) $s->ongkos_kirim_riil_idr);
            $sheet4->setCellValue("H{$rIdx}", (float) $s->subsidi_gratis_ongkir_idr);
            $sheet4->setCellValue("I{$rIdx}", (float) $s->nilai_transaksi_netto_idr);
            $sheet4->setCellValue("J{$rIdx}", $s->metode_pembayaran);
            $sheet4->setCellValue("K{$rIdx}", $s->layanan_ekspedisi);
            $sheet4->setCellValue("L{$rIdx}", (int) $s->durasi_pengiriman_hari);
            $sheet4->setCellValue("M{$rIdx}", (int) $s->rating_produk);
            $sheet4->setCellValue("N{$rIdx}", $s->status_repeat_order);

            $sheet4->getStyle("E{$rIdx}:I{$rIdx}")->getNumberFormat()->setFormatCode('#,##0');
            $rIdx++;
        }
        foreach (range('A', 'N') as $col) {
            $sheet4->getColumnDimension($col)->setAutoSize(true);
        }

        // Return Streamed Response for Download
        $fileName = 'Laporan_BI_Konsumsi_Daya_Beli_' . str_replace(' ', '_', $wilayah->nama_provinsi) . '_' . $selectedYear . '.xlsx';

        return new StreamedResponse(
            function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
}
