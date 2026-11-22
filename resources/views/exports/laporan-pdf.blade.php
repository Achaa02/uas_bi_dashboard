<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan BI {{ $wilayah->nama_provinsi }} - {{ $selectedYear }}</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9.5pt;
            color: #1e293b;
            line-height: 1.4;
        }
        .header {
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 14px;
        }
        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header h2 {
            font-size: 9.5pt;
            font-weight: normal;
            color: #475569;
            margin: 2px 0 0 0;
        }
        .meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 14px;
        }
        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-table td {
            font-size: 8.5pt;
            padding: 2px 4px;
        }
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1.5px solid #cbd5e1;
            padding-bottom: 3px;
            margin-top: 14px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .kpi-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .kpi-table td {
            width: 25%;
            padding: 6px 8px;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
            vertical-align: top;
        }
        .kpi-label {
            font-size: 7.5pt;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
        }
        .kpi-value {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            margin-top: 2px;
        }
        .kpi-sub {
            font-size: 7pt;
            color: #64748b;
            margin-top: 1px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 8pt;
        }
        table.data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 6px;
            text-align: left;
            border: 1px solid #0f172a;
        }
        table.data-table td {
            padding: 4px 6px;
            border: 1px solid #e2e8f0;
        }
        table.data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 1px 5px;
            font-size: 7pt;
            font-weight: bold;
            border-radius: 3px;
            background-color: #e2e8f0;
            color: #334155;
        }
        .interpretation-box {
            background-color: #f0fdf4;
            border-left: 3px solid #16a34a;
            padding: 8px 10px;
            margin-bottom: 12px;
            font-size: 8.5pt;
            color: #166534;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            border-top: 1px solid #cbd5e1;
            padding-top: 4px;
            font-size: 7.5pt;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header / Kop Dokumen -->
    <div class="header">
        <h1>Laporan Eksekutif Business Intelligence</h1>
        <h2>Pemetaan Pola Konsumsi & Daya Beli Digital (Integrasi E-Commerce & Statistik BPS)</h2>
    </div>

    <!-- Identitas Laporan -->
    <div class="meta-box">
        <table class="meta-table">
            <tr>
                <td width="15%"><strong>Provinsi</strong></td>
                <td width="35%">: {{ $wilayah->nama_provinsi }}</td>
                <td width="20%"><strong>Tahun Analisis</strong></td>
                <td width="30%">: {{ $selectedYear }}</td>
            </tr>
            <tr>
                <td><strong>Kode BPS</strong></td>
                <td>: {{ $wilayah->kode_bps }}</td>
                <td><strong>Gugus Wilayah</strong></td>
                <td>: {{ $wilayah->pulau }}</td>
            </tr>
            <tr>
                <td><strong>Waktu Cetak</strong></td>
                <td>: {{ $printedAt }} WIB</td>
                <td><strong>Klasifikasi Kuadran</strong></td>
                <td>: <strong>{{ $integ ? $integ->tipologi_daya_beli_digital : 'N/A' }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- Ringkasan KPI Makro -->
    <div class="section-title">1. Ringkasan Indikator Makro Terintegrasi</div>
    <table class="kpi-table">
        <tr>
            <td>
                <div class="kpi-label">Total Belanja Netto</div>
                <div class="kpi-value">Rp {{ $integ ? number_format($integ->ecom_total_netto_idr / 1000000000, 2) : '0' }} M</div>
                <div class="kpi-sub">{{ $integ ? number_format($integ->ecom_total_transaksi) : '0' }} Transaksi</div>
            </td>
            <td>
                <div class="kpi-label">AOV Keranjang Digital</div>
                <div class="kpi-value">Rp {{ $integ ? number_format($integ->ecom_aov_idr, 0) : '0' }}</div>
                <div class="kpi-sub">Rata-rata per pesanan</div>
            </td>
            <td>
                <div class="kpi-label">Pengeluaran BPS / Kapita</div>
                <div class="kpi-value">Rp {{ $integ ? number_format($integ->total_pengeluaran_idr, 0) : '0' }}</div>
                <div class="kpi-sub">Non-Pangan: Rp {{ $integ ? number_format($integ->pengeluaran_non_makanan_idr, 0) : '0' }}</div>
            </td>
            <td>
                <div class="kpi-label">Rasio AOV / Non-Makanan</div>
                <div class="kpi-value">{{ $integ ? number_format($integ->rasio_aov_thd_non_makanan_bps * 100, 2) : '0' }}%</div>
                <div class="kpi-sub">Bobot digital vs alokasi BPS</div>
            </td>
        </tr>
    </table>

    <!-- Interpretasi Hasil Analisis -->
    <div class="interpretation-box">
        <strong>Interpretasi Analisis Wilayah:</strong><br>
        Berdasarkan integrasi data transaksi aktual e-commerce dengan data pengeluaran Susenas BPS, 
        Provinsi <strong>{{ $wilayah->nama_provinsi }}</strong> menempati posisi 
        <strong>{{ $integ ? $integ->tipologi_daya_beli_digital : '-' }}</strong>.
        Nilai rata-rata satu keranjang belanja digital (AOV) sebesar <strong>Rp {{ $integ ? number_format($integ->ecom_aov_idr, 0) : '0' }}</strong> 
        menyerap sekitar <strong>{{ $integ ? number_format($integ->rasio_aov_thd_non_makanan_bps * 100, 2) : '0' }}%</strong> 
        dari kapasitas rata-rata pengeluaran bulanan non-makanan masyarakat setempat (Rp {{ $integ ? number_format($integ->pengeluaran_non_makanan_idr, 0) : '0' }}).
    </div>

    <!-- Tabel 1: Kinerja 7 Komoditas UMKM -->
    <div class="section-title">2. Kinerja Komoditas Produk UMKM di {{ $wilayah->nama_provinsi }}</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="32%">Kategori Produk</th>
                <th width="14%" class="text-right">Transaksi</th>
                <th width="18%" class="text-right">Total GMV (Rp)</th>
                <th width="14%" class="text-right">AOV (Rp)</th>
                <th width="10%" class="text-center">Rating</th>
                <th width="12%" class="text-center">Sensitivitas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoriStats as $k)
                <tr>
                    <td><strong>{{ $k->kategori_produk }}</strong></td>
                    <td class="text-right">{{ number_format($k->trx) }}</td>
                    <td class="text-right">Rp {{ number_format($k->gmv, 0) }}</td>
                    <td class="text-right">Rp {{ number_format($k->aov, 0) }}</td>
                    <td class="text-center">&#9733; {{ $k->rating }}</td>
                    <td class="text-center">{{ $k->ongkir_sens }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabel 2: Pangsa Pasar Platform E-Commerce -->
    <div class="section-title">3. Pangsa Pasar Platform E-Commerce di {{ $wilayah->nama_provinsi }}</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="40%">Kanal / Platform</th>
                <th width="20%" class="text-right">Total Transaksi</th>
                <th width="25%" class="text-right">Total Nilai Netto (Rp)</th>
                <th width="15%" class="text-right">Pangsa (%)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalProvGmv = $platformStats->sum('gmv'); @endphp
            @foreach($platformStats as $p)
                <tr>
                    <td><strong>{{ $p->platform_ecommerce }}</strong></td>
                    <td class="text-right">{{ number_format($p->trx) }}</td>
                    <td class="text-right">Rp {{ number_format($p->gmv, 0) }}</td>
                    <td class="text-right">{{ number_format(($p->gmv / max(1, $totalProvGmv)) * 100, 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tabel 3: Panel Historis Statistik Pengeluaran BPS -->
    <div class="section-title">4. Tren Pengeluaran per Kapita Sebulan BPS (5 Tahun Terakhir)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="15%" class="text-center">Tahun</th>
                <th width="22%" class="text-right">Makanan (Rp)</th>
                <th width="22%" class="text-right">Bukan Makanan (Rp)</th>
                <th width="23%" class="text-right">Total Pengeluaran (Rp)</th>
                <th width="18%" class="text-right">% Non-Makanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bpsHistory as $b)
                <tr>
                    <td class="text-center"><strong>{{ $b->tahun }}</strong></td>
                    <td class="text-right">Rp {{ number_format($b->pengeluaran_makanan_idr, 0) }}</td>
                    <td class="text-right">Rp {{ number_format($b->pengeluaran_non_makanan_idr, 0) }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($b->total_pengeluaran_idr, 0) }}</strong></td>
                    <td class="text-right">{{ number_format($b->persentase_non_makanan, 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Catatan & Sumber Data -->
    <div style="font-size: 7.5pt; color: #64748b; margin-top: 10px; line-height: 1.3;">
        <strong>Catatan Metodologi & Sumber Data:</strong><br>
        1. Data transaksi diolah dari Big Data E-Commerce Kaggle (5 Juta Baris Observasi Asli).<br>
        2. Data pengeluaran makroekonomi bersumber dari Badan Pusat Statistik (BPS) - Survei Sosial Ekonomi Nasional (Susenas).<br>
        3. Nilai transaksi e-commerce merepresentasikan belanja aktual barang digital dan tidak disamakan langsung dengan pendapatan total rumah tangga.
    </div>

    <!-- Footer -->
    <div class="footer">
        Laporan Analitik Business Intelligence &bull; {{ $wilayah->nama_provinsi }} &bull; Periode {{ $selectedYear }} &bull; Dicetak Otomatis pada {{ $printedAt }}
    </div>

</body>
</html>
