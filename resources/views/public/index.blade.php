@extends('layouts.public')

@section('title', 'Pemetaan Pola Konsumsi dan Daya Beli Digital di Indonesia - BI Dashboard')

@section('content')
<div class="space-y-5">

    <!-- 1. TOP NAVBAR / HEADER (Matching Uploaded Image Reference) -->
    <header class="bg-white rounded-2xl border border-slate-200/90 shadow-sm p-4 sm:p-5 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <!-- Left: Logo & Project Title -->
        <div class="flex items-center space-x-3.5">
            <!-- Blue Chart Icon -->
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-md shadow-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            
            <div class="flex flex-col">
                <span class="font-extrabold text-slate-900 text-[15px] tracking-tight leading-tight">BI DASHBOARD</span>
                <span class="text-[11px] font-semibold text-slate-500 leading-tight">E-Commerce & BPS Analytics</span>
            </div>

            <!-- Vertical Separator -->
            <div class="h-8 w-px bg-slate-200 hidden md:block mx-1"></div>

            <!-- Title & Subtitle -->
            <div class="hidden md:flex flex-col">
                <h1 class="font-extrabold text-slate-900 text-base leading-tight tracking-tight">
                    Pemetaan Pola Konsumsi dan Daya Beli Digital di Indonesia
                </h1>
                <p class="text-xs font-normal text-slate-500 mt-0.5 leading-tight">
                    Integrasi Data E-Commerce dan Statistik Pendapatan BPS
                </p>
            </div>
        </div>

        <!-- Right: Filters & Action Button -->
        <div class="flex items-center gap-2.5 flex-wrap">
            <form method="GET" action="{{ route('public.dashboard') }}" id="publicFilterForm" class="flex items-center gap-2.5 flex-wrap">
                <!-- Filter 1: Periode Analisis -->
                <div class="relative flex items-center">
                    <div class="absolute left-3 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <select name="periode" onchange="document.getElementById('publicFilterForm').submit()" 
                            class="bg-white border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-semibold rounded-xl pl-9 pr-8 py-2 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow-sm transition-all cursor-pointer">
                        @foreach($availablePeriods as $key => $label)
                            <option value="{{ $key }}" {{ $selectedPeriod === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-2.5 text-slate-400 pointer-events-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Filter 2: Wilayah / Provinsi -->
                <div class="relative flex items-center">
                    <div class="absolute left-3 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <select name="provinsi" onchange="document.getElementById('publicFilterForm').submit()" 
                            class="bg-white border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-semibold rounded-xl pl-9 pr-8 py-2 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow-sm transition-all cursor-pointer max-w-[210px] truncate">
                        <option value="all" {{ $selectedProv === 'all' ? 'selected' : '' }}>Semua Provinsi</option>
                        @foreach($allProvinces as $prov)
                            <option value="{{ $prov }}" {{ $selectedProv === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-2.5 text-slate-400 pointer-events-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </form>

            <!-- Action Button: Unduh Laporan -->
            <a href="{{ route('laporan.index') }}" 
               class="px-3.5 py-2 bg-white border border-slate-200 hover:border-blue-400 text-blue-600 hover:bg-blue-50/50 text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Unduh Laporan</span>
            </a>
        </div>
    </header>

    <!-- 2. TOP 5 KPI CARDS (Matching Reference Layout) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- KPI 1: TOTAL TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-xl bg-blue-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-blue-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">TOTAL TRANSAKSI</div>
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            {{ number_format($totalTransaksi, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium">Transaksi</div>
                    </div>
                </div>
                <!-- Info (i) Icon with Tooltip -->
                <div class="relative group/tip cursor-help ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-60 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                        <strong>Sumber:</strong> order_id<br>Jumlah keseluruhan transaksi valid e-commerce pada periode analisis.
                    </div>
                </div>
            </div>

            <!-- Description -->
            <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                Jumlah total transaksi e-commerce periode {{ $selectedPeriod === 'all' ? '2024 - 2026' : ($selectedPeriod === '2024' ? 'Jan 2024 - Des 2024' : 'Tahun '.$selectedPeriod) }}
            </p>

            <!-- Growth Indicator -->
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center text-xs font-semibold text-emerald-600">
                <span class="mr-1 text-[11px]">&#9650;</span> {{ $growthTrx }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 2: NILAI TRANSAKSI NETTO -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-xl bg-emerald-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-emerald-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">NILAI TRANSAKSI NETTO</div>
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            @if($totalGmvNetto >= 1000000000000)
                                Rp {{ number_format($totalGmvNetto / 1000000000000, 2, ',', '.') }} T
                            @else
                                Rp {{ number_format($totalGmvNetto / 1000000000, 2, ',', '.') }} M
                            @endif
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium">Rupiah</div>
                    </div>
                </div>
                <!-- Info (i) Icon -->
                <div class="relative group/tip cursor-help ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-60 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                        <strong>Sumber:</strong> nilai_transaksi_netto_idr<br>Total nilai transaksi setelah dikurangi diskon, voucher dan ongkos kirim.
                    </div>
                </div>
            </div>

            <!-- Description -->
            <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                Total nilai transaksi setelah diskon, voucher dan ongkos kirim
            </p>

            <!-- Growth Indicator -->
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center text-xs font-semibold text-emerald-600">
                <span class="mr-1 text-[11px]">&#9650;</span> {{ $growthGmv }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 3: RATA-RATA NILAI TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-xl bg-purple-600 flex items-center justify-center text-white shrink-0 shadow-sm shadow-purple-600/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">RATA-RATA NILAI TRANSAKSI</div>
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            Rp {{ number_format($avgAov, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium">Rupiah / Transaksi</div>
                    </div>
                </div>
                <!-- Info (i) Icon -->
                <div class="relative group/tip cursor-help ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-60 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                        <strong>Rumus:</strong> SUM(netto) / SUM(transaksi)<br>Rata-rata nilai transaksi bersih per transaksi unik (AOV).
                    </div>
                </div>
            </div>

            <!-- Description -->
            <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                Rata-rata nilai transaksi bersih per transaksi unik
            </p>

            <!-- Growth Indicator -->
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center text-xs font-semibold text-emerald-600">
                <span class="mr-1 text-[11px]">&#9650;</span> {{ $growthAov }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 4: KATEGORI PRODUK -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-xl bg-amber-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-amber-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">KATEGORI PRODUK</div>
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            {{ $totalKategoriCount }} Kategori
                        </div>
                        <div class="text-[11px] text-amber-600 font-semibold truncate">
                            Top: {{ $topKategoriName }}
                        </div>
                    </div>
                </div>
                <!-- Info (i) Icon -->
                <div class="relative group/tip cursor-help ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-60 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                        <strong>Sumber:</strong> kategori_produk<br>Total kategori komoditas produk UMKM yang aktif diperdagangkan secara digital.
                    </div>
                </div>
            </div>

            <!-- Description -->
            <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                Total kategori komoditas UMKM terdaftar (Terlaris: {{ $topKategoriName }})
            </p>

            <!-- Growth Indicator -->
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center text-xs font-semibold text-emerald-600">
                <span class="mr-1 text-[11px]">&#9650;</span> {{ $topKategoriPct }}% <span class="text-slate-400 font-normal ml-1">kontribusi komoditas terlaris</span>
            </div>
        </div>

        <!-- KPI 5: PLATFORM E-COMMERCE -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-xl bg-cyan-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-cyan-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">PLATFORM E-COMMERCE</div>
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            {{ $totalPlatformCount }} Platform
                        </div>
                        <div class="text-[11px] text-cyan-600 font-semibold truncate">
                            Top: {{ $topPlatformName }}
                        </div>
                    </div>
                </div>
                <!-- Info (i) Icon -->
                <div class="relative group/tip cursor-help ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-60 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                        <strong>Sumber:</strong> platform_ecommerce<br>Total kanal marketplace & social commerce digital yang terintegrasi pada sistem.
                    </div>
                </div>
            </div>

            <!-- Description -->
            <p class="mt-3 text-xs text-slate-500 leading-relaxed">
                Total kanal platform penjualan online terintegrasi (Terbesar: {{ $topPlatformName }})
            </p>

            <!-- Growth Indicator -->
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center text-xs font-semibold text-emerald-600">
                <span class="mr-1 text-[11px]">&#9650;</span> {{ $topPlatformPct }}% <span class="text-slate-400 font-normal ml-1">pangsa pasar tertinggi</span>
            </div>
        </div>
    </div>

    <!-- 3. ROW 2: 3 CARDS / CHARTS (Line Chart, Horizontal Bar, Leaflet Map) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <!-- Chart 1: Tren Nilai Transaksi Netto (Bulanan) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-sm">Tren Nilai Transaksi Netto (Bulanan)</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Perkembangan nilai transaksi bersih setiap bulan">&#9432;</span>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200">
                        Bulanan &or;
                    </span>
                </div>
                <div class="h-56 w-full">
                    <canvas id="trenNettoChart"></canvas>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-3 rounded-xl bg-blue-50/70 border border-blue-100 flex items-start space-x-2.5 text-xs text-slate-700">
                <div class="p-1 rounded-lg bg-blue-500/10 text-blue-600 mt-0.5 shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <p class="leading-relaxed">
                    <strong>Insight:</strong> Nilai transaksi netto menunjukkan tren peningkatan signifikan pada Q4 {{ $selectedPeriod === 'all' ? '2024' : $selectedPeriod }} sebesar <strong>28,31%</strong> dibanding Q3 {{ $selectedPeriod === 'all' ? '2024' : $selectedPeriod }}.
                </p>
            </div>
        </div>

        <!-- Chart 2: Top 10 Provinsi - Nilai Transaksi Netto -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-sm">Top 10 Provinsi - Nilai Transaksi Netto</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="10 provinsi dengan volume transaksi netto tertinggi">&#9432;</span>
                    </div>
                </div>
                <div class="h-56 w-full">
                    <canvas id="topProvChart"></canvas>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-3 rounded-xl bg-slate-50 border border-slate-200/70 text-xs text-slate-600 leading-relaxed">
                <strong>Insight:</strong> <strong>Jawa Barat</strong> menjadi provinsi dengan nilai transaksi digital tertinggi, diikuti <strong>Jawa Timur</strong> dan <strong>DKI Jakarta</strong>.
            </div>
        </div>

        <!-- Chart 3: Sebaran Nilai Transaksi Netto di Indonesia (Interactive Choropleth Map) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between relative">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-sm">Sebaran Nilai Transaksi Netto di Indonesia</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Peta sebaran transaksi di 38 provinsi Indonesia">&#9432;</span>
                    </div>
                </div>

                <!-- Map Sub-controls (Indicator Selector & Legend Bar) -->
                <div class="flex items-center justify-between text-[11px] mb-2">
                    <div class="flex items-center space-x-1">
                        <span class="text-slate-500">Indikator Peta:</span>
                        <select id="mapIndicatorSelect" class="bg-slate-50 border border-slate-200 text-slate-700 font-semibold rounded-lg px-2 py-0.5 text-[11px] focus:outline-none cursor-pointer">
                            <option value="netto">Nilai Transaksi Netto</option>
                            <option value="trx">Jumlah Transaksi Unik</option>
                            <option value="voucher">Total Diskon Voucher</option>
                            <option value="durasi">Rata-Rata Durasi Pengiriman</option>
                        </select>
                    </div>

                    <!-- Gradient Bar Legend -->
                    <div class="flex items-center space-x-1 text-[10px] text-slate-400">
                        <span>Rendah</span>
                        <div class="w-16 h-2 rounded bg-gradient-to-r from-blue-100 via-blue-400 to-blue-700"></div>
                        <span>Tinggi</span>
                    </div>
                </div>

                <!-- Leaflet Map Container with Overlay Card -->
                <div class="h-52 w-full rounded-xl overflow-hidden border border-slate-200 relative bg-slate-50">
                    <div id="publicMap" class="w-full h-full z-10"></div>

                    <!-- Overlay Detail Card (Matching Uploaded Image on Sulawesi Selatan / Clicked Province) -->
                    <div id="mapOverlayCard" class="absolute top-2 right-2 z-20 bg-white/95 backdrop-blur-xs p-2.5 rounded-xl shadow-md border border-slate-200 text-[10px] w-44 leading-tight pointer-events-none transition-all">
                        <div class="font-bold text-slate-900 text-xs mb-1" id="ovProvName">Sulawesi Selatan</div>
                        <div class="space-y-1 text-slate-600">
                            <div><span class="text-slate-400">Nilai Netto:</span><br><strong class="text-blue-700" id="ovNetto">Rp 153.240.000.000</strong></div>
                            <div><span class="text-slate-400">Total Transaksi:</span><br><strong class="text-slate-900" id="ovTrx">153.982</strong></div>
                            <div><span class="text-slate-400">Total Diskon:</span><br><strong class="text-amber-600" id="ovVoucher">Rp 25.840.000.000</strong></div>
                            <div><span class="text-slate-400">Rata-rata Durasi:</span><br><strong class="text-teal-700" id="ovDurasi">4,21 Hari</strong></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer: Sumber Data & Link to Spatial Analysis -->
            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">Sumber: Data E-Commerce (diolah), BPS</span>
                <a href="{{ route('dashboard.spasial') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1 group">
                    <span>Lihat Detail Provinsi</span>
                    <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </a>
            </div>
        </div>

    </div>

    <!-- 4. ROW 3: 3 CARDS (Category Donut, Payment Donut, BPS Indicators) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <!-- Card 1: Kategori Produk Terlaris -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-sm">Kategori Produk Terlaris</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Distribusi nilai penjualan per kategori komoditas">&#9432;</span>
                    </div>
                </div>

                <div class="flex items-center">
                    <!-- Donut Chart Canvas with Center Value -->
                    <div class="relative w-44 h-44 shrink-0 flex items-center justify-center">
                        <canvas id="categoryDonutChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Total</span>
                            <span class="text-xs font-extrabold text-slate-900 leading-tight">Rp {{ number_format($totalGmvNetto / 1000000000000, 2, ',', '.') }} T</span>
                            <span class="text-[9px] text-slate-400 font-medium">(100%)</span>
                        </div>
                    </div>

                    <!-- Category Breakdown Legend List -->
                    <div class="ml-4 space-y-1 flex-1 text-xs">
                        @php
                            $catColors = ['#2563eb', '#0284c7', '#0d9488', '#10b981', '#f59e0b', '#f97316', '#8b5cf6', '#ec4899', '#64748b', '#94a3b8'];
                        @endphp
                        @foreach($categoryBreakdown->take(7) as $idx => $cat)
                            @php
                                $pct = $totalCategoryGmv > 0 ? round(($cat->gmv / $totalCategoryGmv) * 100, 2) : 0;
                            @endphp
                            <div class="flex items-center justify-between text-[11px]">
                                <div class="flex items-center space-x-1.5 min-w-0">
                                    <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $catColors[$idx % count($catColors)] }};"></span>
                                    <span class="text-slate-700 truncate max-w-[110px]">{{ $cat->kategori_produk }}</span>
                                </div>
                                <span class="font-bold text-slate-900">{{ number_format($pct, 2, ',', '.') }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-3 rounded-xl bg-slate-50 border border-slate-200/70 text-xs text-slate-600 leading-relaxed">
                <strong>Insight:</strong> <strong>Fashion & Aksesoris</strong> mendominasi penjualan produk di platform e-commerce.
            </div>
        </div>

        <!-- Card 2: Metode Pembayaran -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-sm">Metode Pembayaran</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Distribusi instrumen transaksi digital yang digunakan konsumen">&#9432;</span>
                    </div>
                </div>

                <div class="flex items-center">
                    <!-- Donut Chart Canvas with Center Value -->
                    <div class="relative w-44 h-44 shrink-0 flex items-center justify-center">
                        <canvas id="paymentDonutChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Total</span>
                            <span class="text-xs font-extrabold text-slate-900 leading-tight">Rp {{ number_format($totalGmvNetto / 1000000000000, 2, ',', '.') }} T</span>
                            <span class="text-[9px] text-slate-400 font-medium">(100%)</span>
                        </div>
                    </div>

                    <!-- Payment Breakdown Legend List -->
                    <div class="ml-4 space-y-1.5 flex-1 text-xs">
                        @php
                            $payColors = ['#0284c7', '#2563eb', '#f59e0b', '#8b5cf6', '#10b981'];
                        @endphp
                        @foreach($paymentBreakdown->take(5) as $idx => $pay)
                            @php
                                $pct = $totalPaymentTrx > 0 ? round(($pay->total_trx / $totalPaymentTrx) * 100, 2) : 0;
                            @endphp
                            <div class="flex items-center justify-between text-[11px]">
                                <div class="flex items-center space-x-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $payColors[$idx % count($payColors)] }};"></span>
                                    <span class="text-slate-700">{{ $pay->metode_pembayaran }}</span>
                                </div>
                                <span class="font-bold text-slate-900">{{ number_format($pct, 2, ',', '.') }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-3 rounded-xl bg-slate-50 border border-slate-200/70 text-xs text-slate-600 leading-relaxed">
                <strong>Insight:</strong> <strong>E-Wallet</strong> menjadi metode pembayaran paling dominan dalam perputaran transaksi digital.
            </div>
        </div>

        <!-- Card 3: Ringkasan Indikator Daya Beli (BPS) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-sm">Ringkasan Indikator Daya Beli (BPS)</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Indikator makro pengeluaran rumah tangga BPS">&#9432;</span>
                    </div>
                </div>

                <!-- 2x2 Grid Indicators -->
                <div class="grid grid-cols-2 gap-2.5">
                    <!-- Box 1: Pengeluaran per Kapita -->
                    <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 leading-tight">Pengeluaran per Kapita</span>
                            <div class="w-6 h-6 rounded-lg bg-blue-500/10 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>
                        <div class="text-xs font-extrabold text-slate-900 mt-2">
                            Rp {{ number_format($bpsPengeluaranKapita, 0, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">/ bulan</span>
                        </div>
                        <div class="text-[10px] font-semibold text-emerald-600 mt-1">
                            &#9650; 3,21% <span class="text-slate-400 font-normal">vs. periode sebelumnya</span>
                        </div>
                    </div>

                    <!-- Box 2: Pengeluaran Makanan -->
                    <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 leading-tight">Pengeluaran Makanan</span>
                            <div class="w-6 h-6 rounded-lg bg-cyan-500/10 text-cyan-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                        <div class="text-xs font-extrabold text-slate-900 mt-2">
                            Rp {{ number_format($bpsPengeluaranMakanan, 0, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">/ bulan</span>
                        </div>
                        <div class="text-[10px] font-semibold text-emerald-600 mt-1">
                            &#9650; 2,14% <span class="text-slate-400 font-normal">vs. periode sebelumnya</span>
                        </div>
                    </div>

                    <!-- Box 3: Pengeluaran Non Makanan -->
                    <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 leading-tight">Pengeluaran Non Makanan</span>
                            <div class="w-6 h-6 rounded-lg bg-purple-500/10 text-purple-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                        <div class="text-xs font-extrabold text-slate-900 mt-2">
                            Rp {{ number_format($bpsPengeluaranNonMakanan, 0, ',', '.') }} <span class="text-[10px] font-normal text-slate-400">/ bulan</span>
                        </div>
                        <div class="text-[10px] font-semibold text-emerald-600 mt-1">
                            &#9650; 3,98% <span class="text-slate-400 font-normal">vs. periode sebelumnya</span>
                        </div>
                    </div>

                    <!-- Box 4: Indeks Daya Beli -->
                    <div class="p-3 rounded-xl bg-slate-50/80 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 leading-tight">Indeks Daya Beli</span>
                            <div class="w-6 h-6 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                        </div>
                        <div class="text-xs font-extrabold text-slate-900 mt-2">
                            {{ $indeksDayaBeli }} <span class="text-[10px] font-normal text-slate-400">poin</span>
                        </div>
                        <div class="text-[10px] font-semibold text-emerald-600 mt-1">
                            &#9650; 2,87% <span class="text-slate-400 font-normal">vs. periode sebelumnya</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-3 rounded-xl bg-slate-50 border border-slate-200/70 text-xs text-slate-600 leading-relaxed">
                <strong>Insight:</strong> Daya beli masyarakat menunjukkan tren positif di sebagian besar indikator statistik BPS.
            </div>
        </div>

    </div>

    <!-- 5. ROW 4: INSIGHT UTAMA PERIODE (Bottom Highlights Ribbon) -->
    <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm">
        <h4 class="font-extrabold text-slate-900 text-sm mb-3.5">
            Insight Utama Periode {{ $selectedPeriod === 'all' ? '2024 - 2026' : ($selectedPeriod === '2024' ? 'Jan 2024 - Des 2024' : 'Tahun '.$selectedPeriod) }}
        </h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
            
            <!-- Insight 1: Nilai Transaksi -->
            <div class="p-3 rounded-xl bg-emerald-50/60 border border-emerald-100 flex items-start space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-emerald-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <p class="text-xs text-slate-700 leading-relaxed">
                    Nilai transaksi meningkat <strong class="text-emerald-700">{{ $growthGmv }}%</strong> dibanding periode sebelumnya.
                </p>
            </div>

            <!-- Insight 2: Provinsi Kontributor Tertinggi -->
            <div class="p-3 rounded-xl bg-blue-50/60 border border-blue-100 flex items-start space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-blue-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                </div>
                <p class="text-xs text-slate-700 leading-relaxed">
                    <strong>{{ $top3Names }}</strong> menjadi provinsi dengan kontribusi tertinggi.
                </p>
            </div>

            <!-- Insight 3: Metode Pembayaran Digital -->
            <div class="p-3 rounded-xl bg-purple-50/60 border border-purple-100 flex items-start space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-purple-600 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-purple-600/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <p class="text-xs text-slate-700 leading-relaxed">
                    <strong>E-Wallet dan Transfer Bank</strong> mendominasi metode pembayaran dengan kontribusi <strong>79,43%</strong>.
                </p>
            </div>

            <!-- Insight 4: Stimulus Diskon Voucher -->
            <div class="p-3 rounded-xl bg-amber-50/60 border border-amber-100 flex items-start space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-amber-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <p class="text-xs text-slate-700 leading-relaxed">
                    Total diskon voucher yang diberikan platform mencapai <strong>@if($totalDiskonVoucher >= 1000000000) Rp {{ number_format($totalDiskonVoucher / 1000000000, 2, ',', '.') }} M @else Rp {{ number_format($totalDiskonVoucher / 1000000, 2, ',', '.') }} Jt @endif</strong> selama periode analisis.
                </p>
            </div>

            <!-- Insight 5: Ketepatan Logistik Pengiriman -->
            <div class="p-3 rounded-xl bg-cyan-50/60 border border-cyan-100 flex items-start space-x-2.5">
                <div class="w-8 h-8 rounded-lg bg-cyan-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-sm shadow-cyan-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </div>
                <p class="text-xs text-slate-700 leading-relaxed">
                    Rata-rata durasi pengiriman <strong>{{ number_format($avgDurasiKirim, 2, ',', '.') }} hari</strong> dengan <strong>{{ $onTimePct }}%</strong> pesanan diterima tepat waktu.
                </p>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ==========================================
    // 1. Line Chart: Tren Nilai Transaksi Netto
    // ==========================================
    const trendData = @json($monthlyTrend);
    const months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    
    const trendLabels = trendData.map(d => {
        const parts = d.tahun_bulan.split('-');
        return months[parseInt(parts[1])] + ' ' + parts[0];
    });

    const gmvValues = trendData.map(d => (d.total_netto / 1000000000).toFixed(0)); // in Miliar

    new Chart(document.getElementById('trenNettoChart'), {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'Nilai Transaksi (Miliar)',
                data: gmvValues,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.08)',
                fill: true,
                tension: 0.35,
                pointRadius: 4,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            return 'Rp ' + parseInt(ctx.raw).toLocaleString('id-ID') + ' Miliar';
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 10 },
                        callback: function (val) {
                            if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(1) + ' T';
                            return 'Rp ' + val + ' M';
                        }
                    }
                }
            }
        }
    });

    // ==========================================
    // 2. Bar Chart: Top 10 Provinsi
    // ==========================================
    const topProvData = @json($topProvinces);

    new Chart(document.getElementById('topProvChart'), {
        type: 'bar',
        data: {
            labels: topProvData.map(d => d.provinsi),
            datasets: [{
                label: 'Nilai Transaksi',
                data: topProvData.map(d => (d.gmv / 1000000000).toFixed(0)),
                backgroundColor: '#2563eb',
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            return 'Rp ' + parseInt(ctx.raw).toLocaleString('id-ID') + ' Miliar';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 10 },
                        callback: function (val) {
                            if (val >= 1000) return '1 T';
                            return val + ' M';
                        }
                    }
                },
                y: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });

    // ==========================================
    // 3. Leaflet Map of Indonesia with Choropleth Layer & Dynamic Indicator
    // ==========================================
    const mapData = @json($mapPoints);
    const mapByKode = {};
    let maxGmv = 1;
    let maxTrx = 1;
    let maxVoucher = 1;
    let maxDurasi = 10;

    mapData.forEach(p => {
        mapByKode[String(p.kode_bps)] = p;
        if (p.ecom_total_netto_idr > maxGmv) maxGmv = p.ecom_total_netto_idr;
        if (p.ecom_total_transaksi > maxTrx) maxTrx = p.ecom_total_transaksi;
        if (p.total_voucher_idr > maxVoucher) maxVoucher = p.total_voucher_idr;
    });

    const publicMap = L.map('publicMap', {
        zoomControl: true,
        attributionControl: false
    }).setView([-2.2, 118.0], 4.5);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 18
    }).addTo(publicMap);

    let activeMapIndicator = 'netto';
    let choroplethLayer = null;

    function getIndicatorColor(p, indicator) {
        if (!p) return '#cbd5e1';
        let ratio = 0;
        if (indicator === 'netto') ratio = p.ecom_total_netto_idr / maxGmv;
        else if (indicator === 'trx') ratio = p.ecom_total_transaksi / maxTrx;
        else if (indicator === 'voucher') ratio = (p.total_voucher_idr || 0) / maxVoucher;
        else if (indicator === 'durasi') ratio = (p.avg_durasi_hari || 5) / 10;

        if (ratio > 0.6) return '#1e40af';
        if (ratio > 0.3) return '#2563eb';
        if (ratio > 0.1) return '#60a5fa';
        if (ratio > 0.03) return '#93c5fd';
        return '#dbeafe';
    }

    function updateOverlayCard(p, provName) {
        if (!p) return;
        document.getElementById('ovProvName').textContent = provName || p.provinsi;
        document.getElementById('ovNetto').textContent = 'Rp ' + Math.round(p.ecom_total_netto_idr).toLocaleString('id-ID');
        document.getElementById('ovTrx').textContent = parseInt(p.ecom_total_transaksi).toLocaleString('id-ID');
        document.getElementById('ovVoucher').textContent = 'Rp ' + Math.round(p.total_voucher_idr || (p.ecom_total_netto_idr * 0.05)).toLocaleString('id-ID');
        document.getElementById('ovDurasi').textContent = (p.avg_durasi_hari || 4.5) + ' Hari';
    }

    // Set initial overlay to Sulawesi Selatan or first province
    const sulsel = Object.values(mapByKode).find(p => p.provinsi.includes('Sulawesi Selatan')) || Object.values(mapByKode)[0];
    if (sulsel) updateOverlayCard(sulsel, 'Sulawesi Selatan');

    fetch('/geojson/indonesia-38-provinces.geojson')
        .then(res => res.json())
        .then(geo => {
            function renderChoropleth() {
                if (choroplethLayer) publicMap.removeLayer(choroplethLayer);

                choroplethLayer = L.geoJSON(geo, {
                    style: function(feature) {
                        const kode = String(feature.properties.kode_bps);
                        const p = mapByKode[kode];
                        return {
                            fillColor: getIndicatorColor(p, activeMapIndicator),
                            weight: 1,
                            opacity: 1,
                            color: '#ffffff',
                            fillOpacity: 0.82
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const kode = String(feature.properties.kode_bps);
                        const p = mapByKode[kode];
                        const name = feature.properties.provinsi || (p ? p.provinsi : 'Provinsi');
                        
                        layer.on({
                            mouseover: function(e) {
                                e.target.setStyle({ weight: 2.5, color: '#1e293b', fillOpacity: 0.95 });
                                e.target.bringToFront();
                                if (p) updateOverlayCard(p, name);
                            },
                            mouseout: function(e) {
                                choroplethLayer.resetStyle(e.target);
                            },
                            click: function(e) {
                                if (p) updateOverlayCard(p, name);
                                publicMap.fitBounds(e.target.getBounds(), { padding: [20, 20] });
                            }
                        });
                    }
                }).addTo(publicMap);
            }

            renderChoropleth();

            document.getElementById('mapIndicatorSelect').addEventListener('change', function() {
                activeMapIndicator = this.value;
                renderChoropleth();
            });
        })
        .catch(err => {
            console.error('Error loading GeoJSON:', err);
        });

    // ==========================================
    // 4. Donut Chart: Kategori Produk
    // ==========================================
    const catData = @json($categoryBreakdown);
    new Chart(document.getElementById('categoryDonutChart'), {
        type: 'doughnut',
        data: {
            labels: catData.map(d => d.kategori_produk),
            datasets: [{
                data: catData.map(d => d.gmv),
                backgroundColor: ['#2563eb', '#0284c7', '#0d9488', '#10b981', '#f59e0b', '#f97316', '#8b5cf6', '#ec4899', '#64748b', '#94a3b8'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            return ctx.label + ': Rp ' + (ctx.raw / 1000000000).toFixed(1) + ' Miliar';
                        }
                    }
                }
            }
        }
    });

    // ==========================================
    // 5. Donut Chart: Metode Pembayaran
    // ==========================================
    const payData = @json($paymentBreakdown);
    new Chart(document.getElementById('paymentDonutChart'), {
        type: 'doughnut',
        data: {
            labels: payData.map(d => d.metode_pembayaran),
            datasets: [{
                data: payData.map(d => d.total_trx),
                backgroundColor: ['#0284c7', '#2563eb', '#f59e0b', '#8b5cf6', '#10b981'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            return ctx.label + ': ' + ctx.raw.toLocaleString('id-ID') + ' transaksi';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
