@extends('layouts.app')

@section('title', 'Peta Indonesia Interaktif - Analisis Spasial')
@section('header_title', 'Peta Indonesia Interaktif & Analisis Spasial Komparatif')

@section('content')
<div class="space-y-6">

    <!-- 1. MAP CONTROL PANEL: PILIHAN INDIKATOR & FILTER PERIODE -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <!-- Pilihan Indikator (4 Pilihan Sesuai Instruksi User) -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Pilihan Indikator:
            </span>
            <div class="inline-flex p-1 bg-slate-100 rounded-xl gap-1 flex-wrap" id="indicatorSelector">
                <!-- Indikator 1: Nilai Transaksi Netto -->
                <button type="button" data-indicator="netto" class="indicator-btn active px-3 py-1.5 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5 bg-blue-600 text-white shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Nilai Transaksi Netto
                </button>
                <!-- Indikator 2: Jumlah Transaksi Unik -->
                <button type="button" data-indicator="trx" class="indicator-btn px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Jumlah Transaksi Unik
                </button>
                <!-- Indikator 3: Total Diskon Voucher -->
                <button type="button" data-indicator="voucher" class="indicator-btn px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    Total Diskon Voucher
                </button>
                <!-- Indikator 4: Rata-Rata Durasi Pengiriman -->
                <button type="button" data-indicator="durasi" class="indicator-btn px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                    Rata-Rata Durasi Pengiriman
                </button>
            </div>
        </div>

        <!-- Filter Periode (Tahun & Bulan) & Tombol Reset Map -->
        <div class="flex items-center gap-2.5 flex-wrap">
            <div class="flex items-center space-x-1.5 bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-1.5">
                <span class="text-xs text-slate-500 font-medium">Tahun:</span>
                <select id="filterTahun" class="bg-transparent text-xs font-bold text-slate-700 focus:outline-none cursor-pointer">
                    <option value="all" {{ $selectedYear === 'all' ? 'selected' : '' }}>Semua (2024–2026)</option>
                    <option value="2024" {{ $selectedYear === '2024' ? 'selected' : '' }}>2024</option>
                    <option value="2025" {{ $selectedYear === '2025' ? 'selected' : '' }}>2025</option>
                    <option value="2026" {{ $selectedYear === '2026' ? 'selected' : '' }}>2026</option>
                </select>
            </div>

            <div class="flex items-center space-x-1.5 bg-slate-50 border border-slate-200 rounded-xl px-2.5 py-1.5">
                <span class="text-xs text-slate-500 font-medium">Bulan:</span>
                <select id="filterBulan" class="bg-transparent text-xs font-bold text-slate-700 focus:outline-none cursor-pointer">
                    <option value="all" {{ $selectedMonth === 'all' ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        @php
                            $monthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        @endphp
                        <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ $monthNames[$m] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Reset Tampilan Peta -->
            <button type="button" id="btnResetMap" title="Kembalikan batas tampilan peta ke seluruh Indonesia"
                    class="px-3 py-1.5 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 hover:text-slate-900 text-xs font-semibold rounded-xl shadow-sm hover:shadow transition-all flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Reset Peta
            </button>
        </div>
    </div>

    <!-- 2. INTERACTIVE CHOROPLETH MAP CONTAINER -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm relative overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-100 gap-2">
            <div>
                <h3 class="font-extrabold text-slate-900 text-base flex items-center gap-2">
                    <span id="activeMapTitle">Peta Choropleth Nilai Transaksi Netto E-Commerce</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200/60 uppercase" id="badgeTotalProv">
                        38/38 Provinsi
                    </span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Arahkan kursor pada poligon provinsi untuk *tooltip*, atau klik provinsi untuk memeriksa perincian metrik dan konteks indikator ekonomi BPS.
                </p>
            </div>
            <!-- Quick Helper Indicator Info -->
            <div class="text-right text-xs text-slate-500">
                <span>Skala Gradasi: </span>
                <span class="font-bold text-slate-800" id="scaleIndicatorName">Nilai Transaksi Netto</span>
            </div>
        </div>

        <!-- The Leaflet Map Canvas -->
        <div class="relative mt-4">
            <div id="choroplethMap" class="w-full h-[520px] rounded-xl overflow-hidden border border-slate-200 shadow-inner z-10 bg-slate-50"></div>

            <!-- Loading Spinner Overlay -->
            <div id="mapLoader" class="absolute inset-0 bg-white/70 backdrop-blur-xs flex items-center justify-center z-20 hidden rounded-xl">
                <div class="flex items-center space-x-2 bg-slate-900 text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-lg">
                    <svg class="animate-spin w-4 h-4 text-cyan-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>Memperbarui agregasi spasial...</span>
                </div>
            </div>
        </div>

        <!-- Real-time Live Province Inspector (Right on Bottom of Map) -->
        <div id="hoverInspector" class="mt-3 p-3 bg-slate-50 rounded-xl border border-slate-200 flex flex-wrap items-center justify-between text-xs text-slate-600 transition-all">
            <div class="flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></span>
                <span class="font-bold text-slate-900" id="inspProvinsi">Arahkan kursor pada peta</span>
                <span class="text-slate-400" id="inspPulau"></span>
            </div>
            <div class="flex items-center space-x-4">
                <div><span class="text-slate-400">Nilai Netto:</span> <strong class="text-blue-700" id="inspNetto">-</strong></div>
                <div><span class="text-slate-400">Transaksi Unik:</span> <strong class="text-purple-700" id="inspTrx">-</strong></div>
                <div><span class="text-slate-400">Voucher:</span> <strong class="text-amber-700" id="inspVoucher">-</strong></div>
                <div><span class="text-slate-400">Durasi Kirim:</span> <strong class="text-teal-700" id="inspDurasi">-</strong></div>
            </div>
        </div>
    </div>

    <!-- 3. RINGKASAN AGREGASI NASIONAL PADA PERIODE TERPILIH -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="summaryCardsRow">
        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TOTAL TRANSAKSI UNIK</span>
            <div class="text-xl font-extrabold text-slate-900 mt-1" id="sumTrx">
                {{ $initialData['meta']['summary']['total_transaksi_unik_formatted'] }}
            </div>
            <p class="text-[11px] text-slate-500 mt-0.5">Deduplikasi <code class="text-blue-600">transaksi_id</code></p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TOTAL BELANJA NETTO</span>
            <div class="text-xl font-extrabold text-blue-700 mt-1" id="sumNetto">
                {{ $initialData['meta']['summary']['total_nilai_transaksi_netto_formatted'] }}
            </div>
            <p class="text-[11px] text-slate-500 mt-0.5">Setelah diskon & voucher</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TOTAL DISKON VOUCHER</span>
            <div class="text-xl font-extrabold text-amber-600 mt-1" id="sumVoucher">
                {{ $initialData['meta']['summary']['total_diskon_voucher_formatted'] }}
            </div>
            <p class="text-[11px] text-slate-500 mt-0.5">Stimulus promosi platform</p>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">RATA-RATA DURASI KIRIM</span>
            <div class="text-xl font-extrabold text-teal-700 mt-1" id="sumDurasi">
                {{ $initialData['meta']['summary']['national_avg_durasi_formatted'] }}
            </div>
            <p class="text-[11px] text-slate-500 mt-0.5">Rata-rata logistik nasional</p>
        </div>
    </div>

    <!-- 4. KOMPARASI PULAU JAWA VS LUAR JAWA -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($jawaVsLuar as $regionName => $stats)
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm {{ $regionName === 'Pulau Jawa' ? 'border-l-4 border-l-blue-600' : 'border-l-4 border-l-purple-600' }}">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-extrabold text-base {{ $regionName === 'Pulau Jawa' ? 'text-blue-700' : 'text-purple-700' }}">
                        {{ $regionName }}
                    </h4>
                    <span class="text-xs px-2.5 py-0.5 rounded-full bg-slate-100 font-bold text-slate-600">
                        {{ $stats['total_provinsi'] }} Provinsi
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 text-[10px] uppercase font-bold">Total Belanja Netto</span>
                        <div class="text-base font-extrabold text-slate-900 mt-0.5">
                            Rp {{ number_format($stats['total_gmv'] / 1_000_000_000, 2, ',', '.') }} M
                        </div>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 text-[10px] uppercase font-bold">Volume Transaksi</span>
                        <div class="text-base font-extrabold text-slate-900 mt-0.5">
                            {{ number_format($stats['total_trx'], 0, ',', '.') }} trx
                        </div>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 text-[10px] uppercase font-bold">AOV Rata-rata</span>
                        <div class="text-base font-bold text-emerald-600 mt-0.5">
                            Rp {{ number_format($stats['avg_aov'], 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 text-[10px] uppercase font-bold">Rata-rata Durasi Kirim</span>
                        <div class="text-base font-bold text-teal-600 mt-0.5">
                            {{ $stats['avg_durasi_hari'] }} hari
                        </div>
                    </div>
                </div>

                <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <span>Pengeluaran Rata-rata BPS:</span>
                    <strong class="text-slate-700">Rp {{ number_format($stats['avg_bps_pengeluaran'], 0, ',', '.') }} / kapita / bln</strong>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 5. TABEL DISPARITAS PER 6 GUGUS KEPULAUAN -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-extrabold text-slate-900 text-sm">Disparitas Digital & Logistik 6 Gugus Kepulauan</h3>
            <p class="text-xs text-slate-400 mt-0.5">Analisis efisiensi logistik dan penetrasi transaksi e-commerce antar kawasan pulau di Indonesia</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 font-bold uppercase tracking-wider text-slate-500 border-b border-slate-200 text-[11px]">
                    <tr>
                        <th class="py-3 px-4">Gugus Kepulauan</th>
                        <th class="py-3 px-4 text-center">Jumlah Provinsi</th>
                        <th class="py-3 px-4 text-right">Total Transaksi Unik</th>
                        <th class="py-3 px-4 text-right">Total Belanja Netto</th>
                        <th class="py-3 px-4 text-right">Total Diskon Voucher</th>
                        <th class="py-3 px-4 text-right">AOV / Keranjang</th>
                        <th class="py-3 px-4 text-center">Durasi Pengiriman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($islandStats as $isl)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $isl['pulau'] }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 font-semibold text-slate-700">
                                    {{ $isl['count_prov'] }} Prov
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right font-medium text-slate-800">
                                {{ number_format($isl['total_trx'], 0, ',', '.') }} trx
                            </td>
                            <td class="py-3.5 px-4 text-right font-bold text-blue-700">
                                Rp {{ number_format($isl['total_gmv'] / 1_000_000_000, 2, ',', '.') }} M
                            </td>
                            <td class="py-3.5 px-4 text-right text-amber-600 font-medium">
                                Rp {{ number_format($isl['total_voucher'] / 1_000_000, 2, ',', '.') }} Jt
                            </td>
                            <td class="py-3.5 px-4 text-right text-emerald-600 font-semibold">
                                Rp {{ number_format($isl['avg_aov'], 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $isl['avg_durasi'] <= 4.5 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($isl['avg_durasi'] <= 6.5 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200') }}">
                                    {{ $isl['avg_durasi'] }} hari
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Leaflet CSS & JS Loaded via Layout -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Initial State & Data from Server
    let currentIndicator = 'netto'; // netto | trx | voucher | durasi
    let currentTahun = document.getElementById('filterTahun').value;
    let currentBulan = document.getElementById('filterBulan').value;
    let aggregasiData = @json($initialData);
    let geojsonData = null;
    let geojsonLayer = null;
    let legendControl = null;

    // Palette Configurations
    const PALETTES = {
        netto: {
            title: 'Nilai Transaksi Netto',
            unit: 'IDR',
            colors: ['#eff6ff', '#bfdbfe', '#60a5fa', '#2563eb', '#1e40af'],
            border: '#1e40af'
        },
        trx: {
            title: 'Jumlah Transaksi Unik',
            unit: 'Transaksi',
            colors: ['#faf5ff', '#e9d5ff', '#c084fc', '#9333ea', '#581c87'],
            border: '#581c87'
        },
        voucher: {
            title: 'Total Diskon Voucher',
            unit: 'IDR',
            colors: ['#fff7ed', '#fed7aa', '#fb923c', '#ea580c', '#9a3412'],
            border: '#9a3412'
        },
        durasi: {
            title: 'Rata-Rata Durasi Pengiriman',
            unit: 'Hari',
            colors: ['#f0fdfa', '#99f6e4', '#2dd4bf', '#0d9488', '#115e59'],
            border: '#115e59'
        }
    };

    // 2. Initialize Leaflet Map (Centered on Indonesia Archipelago)
    const INDONESIA_CENTER = [-2.0, 118.0];
    const INDONESIA_ZOOM = 5;

    const map = L.map('choroplethMap', {
        center: INDONESIA_CENTER,
        zoom: INDONESIA_ZOOM,
        minZoom: 4,
        maxZoom: 10,
        zoomControl: true,
        scrollWheelZoom: true
    });

    // Basemap: CartoDB Positron (Clean Light Theme)
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    // 3. Helper: Calculate Quantile / Interval Breaks
    function getBreaks(metricValues, numClasses = 5) {
        const sorted = metricValues.filter(v => v > 0).sort((a, b) => a - b);
        if (sorted.length === 0) return [0, 0, 0, 0, 0];
        const breaks = [];
        for (let i = 1; i <= numClasses; i++) {
            const idx = Math.min(sorted.length - 1, Math.floor((i / numClasses) * sorted.length) - 1);
            breaks.push(sorted[Math.max(0, idx)]);
        }
        return breaks;
    }

    // 4. Helper: Determine Color based on value and indicator
    function getColor(val, breaks, palette) {
        if (!val || val <= 0) return '#cbd5e1'; // Grey for no data (Instruction 10)
        if (val <= breaks[0]) return palette.colors[0];
        if (val <= breaks[1]) return palette.colors[1];
        if (val <= breaks[2]) return palette.colors[2];
        if (val <= breaks[3]) return palette.colors[3];
        return palette.colors[4];
    }

    // Format helper for breaks label
    function formatBreakLabel(val, indicator) {
        if (indicator === 'durasi') return val.toFixed(1) + ' hr';
        if (indicator === 'trx') return Math.round(val) + ' trx';
        if (val >= 1000000000) return 'Rp ' + (val / 1000000000).toFixed(1) + ' M';
        if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(0) + ' Jt';
        return 'Rp ' + Math.round(val).toLocaleString('id-ID');
    }

    // 5. Update Map Styles & Choropleth Layer
    function updateChoropleth() {
        if (!geojsonData) return;

        const palette = PALETTES[currentIndicator];
        const byKode = aggregasiData.by_kode_bps || {};

        // Collect values for break calculation
        const allValues = [];
        Object.values(byKode).forEach(item => {
            let val = 0;
            if (currentIndicator === 'netto') val = item.nilai_transaksi_netto;
            else if (currentIndicator === 'trx') val = item.jumlah_transaksi_unik;
            else if (currentIndicator === 'voucher') val = item.total_diskon_voucher;
            else if (currentIndicator === 'durasi') val = item.avg_durasi_pengiriman;
            if (item.has_data && val > 0) allValues.push(val);
        });

        const breaks = getBreaks(allValues, 5);

        // Remove existing layer if any
        if (geojsonLayer) {
            map.removeLayer(geojsonLayer);
        }

        geojsonLayer = L.geoJSON(geojsonData, {
            style: function (feature) {
                const kode = String(feature.properties.kode_bps);
                const dataItem = byKode[kode];
                const hasData = dataItem && dataItem.has_data;

                let val = 0;
                if (hasData) {
                    if (currentIndicator === 'netto') val = dataItem.nilai_transaksi_netto;
                    else if (currentIndicator === 'trx') val = dataItem.jumlah_transaksi_unik;
                    else if (currentIndicator === 'voucher') val = dataItem.total_diskon_voucher;
                    else if (currentIndicator === 'durasi') val = dataItem.avg_durasi_pengiriman;
                }

                if (!hasData) {
                    // Instruction 10: Tampilkan wilayah tanpa data menggunakan warna abu-abu
                    return {
                        fillColor: '#cbd5e1',
                        weight: 1,
                        opacity: 1,
                        color: '#94a3b8',
                        dashArray: '3, 3',
                        fillOpacity: 0.55
                    };
                }

                return {
                    fillColor: getColor(val, breaks, palette),
                    weight: 1.2,
                    opacity: 1,
                    color: '#ffffff',
                    fillOpacity: 0.82
                };
            },
            onEachFeature: function (feature, layer) {
                const kode = String(feature.properties.kode_bps);
                const dataItem = byKode[kode];
                const provName = feature.properties.provinsi || (dataItem ? dataItem.provinsi : 'Provinsi');
                const hasData = dataItem && dataItem.has_data;

                // Tooltip on Hover
                let tooltipContent = `<div class="font-sans text-xs p-1">`;
                tooltipContent += `<div class="font-bold text-slate-900">${provName} <span class="text-slate-400 font-normal">(BPS: ${kode})</span></div>`;

                if (hasData) {
                    let indicatorFormatted = '';
                    if (currentIndicator === 'netto') indicatorFormatted = dataItem.nilai_transaksi_netto_formatted;
                    else if (currentIndicator === 'trx') indicatorFormatted = dataItem.jumlah_transaksi_unik_formatted;
                    else if (currentIndicator === 'voucher') indicatorFormatted = dataItem.total_diskon_voucher_formatted;
                    else if (currentIndicator === 'durasi') indicatorFormatted = dataItem.avg_durasi_pengiriman_formatted;

                    tooltipContent += `<div class="mt-1 font-semibold text-blue-700">${palette.title}: ${indicatorFormatted}</div>`;
                    tooltipContent += `<div class="text-[11px] text-slate-500">Pulau: ${dataItem.pulau}</div>`;
                } else {
                    tooltipContent += `<div class="mt-1 text-slate-500 italic">Tanpa data transaksi pada periode ini</div>`;
                }
                tooltipContent += `</div>`;

                layer.bindTooltip(tooltipContent, {
                    sticky: true,
                    direction: 'top',
                    opacity: 0.95
                });

                // Mouseover / Mouseout / Click Events
                layer.on({
                    mouseover: function (e) {
                        const l = e.target;
                        l.setStyle({
                            weight: 2.5,
                            color: '#1e293b',
                            fillOpacity: 0.95
                        });
                        l.bringToFront();

                        // Update Bottom Inspector Bar
                        document.getElementById('inspProvinsi').textContent = provName + ' (BPS: ' + kode + ')';
                        document.getElementById('inspPulau').textContent = dataItem ? '• Pulau ' + dataItem.pulau : '';

                        if (hasData) {
                            document.getElementById('inspNetto').textContent = dataItem.nilai_transaksi_netto_formatted;
                            document.getElementById('inspTrx').textContent = dataItem.jumlah_transaksi_unik_formatted;
                            document.getElementById('inspVoucher').textContent = dataItem.total_diskon_voucher_formatted;
                            document.getElementById('inspDurasi').textContent = dataItem.avg_durasi_pengiriman_formatted;
                        } else {
                            document.getElementById('inspNetto').textContent = 'Tanpa Data';
                            document.getElementById('inspTrx').textContent = 'Tanpa Data';
                            document.getElementById('inspVoucher').textContent = 'Tanpa Data';
                            document.getElementById('inspDurasi').textContent = 'Tanpa Data';
                        }
                    },
                    mouseout: function (e) {
                        geojsonLayer.resetStyle(e.target);
                    },
                    click: function (e) {
                        // Fit zoom to clicked province
                        map.fitBounds(e.target.getBounds(), { padding: [30, 30] });

                        // Rich Popup Detail Provinsi (Instruction 9)
                        let popupHtml = `
                            <div class="font-sans text-xs p-2 min-w-[240px]">
                                <div class="flex items-center justify-between border-b border-slate-200 pb-1.5 mb-2">
                                    <h4 class="font-extrabold text-sm text-slate-900">${provName}</h4>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800">BPS ${kode}</span>
                                </div>
                                <div class="text-[11px] text-slate-500 mb-2">Kawasan: <strong>${dataItem ? dataItem.pulau : '-'}</strong></div>
                        `;

                        if (hasData) {
                            popupHtml += `
                                <div class="space-y-1.5">
                                    <div class="flex justify-between bg-blue-50/70 p-1.5 rounded">
                                        <span class="text-slate-600">Nilai Transaksi Netto:</span>
                                        <strong class="text-blue-700">${dataItem.nilai_transaksi_netto_formatted}</strong>
                                    </div>
                                    <div class="flex justify-between bg-purple-50/70 p-1.5 rounded">
                                        <span class="text-slate-600">Jumlah Transaksi Unik:</span>
                                        <strong class="text-purple-700">${dataItem.jumlah_transaksi_unik_formatted}</strong>
                                    </div>
                                    <div class="flex justify-between bg-amber-50/70 p-1.5 rounded">
                                        <span class="text-slate-600">Total Diskon Voucher:</span>
                                        <strong class="text-amber-700">${dataItem.total_diskon_voucher_formatted}</strong>
                                    </div>
                                    <div class="flex justify-between bg-teal-50/70 p-1.5 rounded">
                                        <span class="text-slate-600">Durasi Pengiriman:</span>
                                        <strong class="text-teal-700">${dataItem.avg_durasi_pengiriman_formatted}</strong>
                                    </div>
                                    <div class="flex justify-between pt-1 border-t border-slate-100 text-[11px]">
                                        <span class="text-slate-500">AOV Belanja:</span>
                                        <strong class="text-slate-800">${dataItem.aov_formatted} / trx</strong>
                                    </div>
                                </div>
                            `;
                        } else {
                            popupHtml += `
                                <div class="p-3 bg-slate-100 rounded text-center text-slate-500 italic">
                                    Tidak terdapat transaksi pada periode terpilih (Tahun ${currentTahun}, Bulan ${currentBulan}).
                                </div>
                            `;
                        }

                        popupHtml += `</div>`;
                        L.popup().setLatLng(e.latlng).setContent(popupHtml).openOn(map);
                    }
                });
            }
        }).addTo(map);

        // Update Dynamic Legend (Instruction 9)
        updateLegend(breaks, palette);
    }

    // 6. Dynamic Legend Control
    function updateLegend(breaks, palette) {
        if (legendControl) {
            map.removeControl(legendControl);
        }

        legendControl = L.control({ position: 'bottomright' });
        legendControl.onAdd = function () {
            const div = L.DomUtil.create('div', 'legend-container bg-white/95 p-3 rounded-xl shadow-md border border-slate-200 text-xs text-slate-700 font-sans backdrop-blur-xs');
            div.innerHTML = `<div class="font-bold text-[11px] text-slate-900 mb-2">${palette.title}</div>`;

            // 5 Step Grades
            for (let i = 0; i < breaks.length; i++) {
                const color = palette.colors[i];
                const from = i === 0 ? 0 : breaks[i - 1];
                const to = breaks[i];
                div.innerHTML += `
                    <div class="flex items-center space-x-2 mb-1">
                        <span class="w-4 h-3.5 rounded-xs shrink-0 border border-slate-300" style="background:${color}"></span>
                        <span class="text-[10px] text-slate-600">${formatBreakLabel(from, currentIndicator)} – ${formatBreakLabel(to, currentIndicator)}</span>
                    </div>
                `;
            }

            // Grey Box for "Tanpa Data" (Instruction 10)
            div.innerHTML += `
                <div class="flex items-center space-x-2 mt-2 pt-1.5 border-t border-slate-200">
                    <span class="w-4 h-3.5 rounded-xs shrink-0 border border-slate-400 bg-slate-300" style="background:#cbd5e1"></span>
                    <span class="text-[10px] text-slate-500 font-medium">Tanpa Data (0 transaksi)</span>
                </div>
            `;
            return div;
        };
        legendControl.addTo(map);
    }

    // 7. Fetch Dynamic Aggregations from Backend Endpoint
    function fetchAggregations() {
        const loader = document.getElementById('mapLoader');
        loader.classList.remove('hidden');

        const url = `/api/spasial/agregasi?tahun=${currentTahun}&bulan=${currentBulan}`;

        fetch(url)
            .then(res => res.json())
            .then(res => {
                loader.classList.add('hidden');
                if (res.status === 'success') {
                    aggregasiData = res;

                    // Update Summary Ribbon
                    const sum = res.meta.summary;
                    document.getElementById('sumTrx').textContent = sum.total_transaksi_unik_formatted;
                    document.getElementById('sumNetto').textContent = sum.total_nilai_transaksi_netto_formatted;
                    document.getElementById('sumVoucher').textContent = sum.total_diskon_voucher_formatted;
                    document.getElementById('sumDurasi').textContent = sum.national_avg_durasi_formatted;

                    document.getElementById('badgeTotalProv').textContent = `${sum.provinsi_ada_data}/${sum.total_provinsi} Provinsi`;

                    // Re-render Choropleth
                    updateChoropleth();
                }
            })
            .catch(err => {
                loader.classList.add('hidden');
                console.error('Error fetching spatial aggregation:', err);
            });
    }

    // 8. Event Listeners for Indicator Selection (Instruction 8)
    const indicatorButtons = document.querySelectorAll('.indicator-btn');
    indicatorButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            indicatorButtons.forEach(b => {
                b.classList.remove('active', 'bg-blue-600', 'bg-purple-600', 'bg-amber-600', 'bg-teal-600', 'text-white', 'shadow-sm');
                b.classList.add('text-slate-600');
            });

            this.classList.add('active', 'text-white', 'shadow-sm');
            this.classList.remove('text-slate-600');

            const ind = this.getAttribute('data-indicator');
            currentIndicator = ind;

            if (ind === 'netto') this.classList.add('bg-blue-600');
            else if (ind === 'trx') this.classList.add('bg-purple-600');
            else if (ind === 'voucher') this.classList.add('bg-amber-600');
            else if (ind === 'durasi') this.classList.add('bg-teal-600');

            document.getElementById('activeMapTitle').textContent = `Peta Choropleth ${PALETTES[ind].title} E-Commerce`;
            document.getElementById('scaleIndicatorName').textContent = PALETTES[ind].title;

            updateChoropleth();
        });
    });

    // 9. Event Listeners for Filters (Instruction 9)
    document.getElementById('filterTahun').addEventListener('change', function () {
        currentTahun = this.value;
        fetchAggregations();
    });

    document.getElementById('filterBulan').addEventListener('change', function () {
        currentBulan = this.value;
        fetchAggregations();
    });

    // 10. Reset Map View Button (Instruction 9)
    document.getElementById('btnResetMap').addEventListener('click', function () {
        map.setView(INDONESIA_CENTER, INDONESIA_ZOOM);
    });

    // 11. Load GeoJSON File
    fetch('/geojson/indonesia-38-provinces.geojson')
        .then(res => res.json())
        .then(data => {
            geojsonData = data;
            updateChoropleth();
        })
        .catch(err => {
            console.error('Failed to load Indonesia 38 Provinces GeoJSON:', err);
        });
});
</script>
@endpush
