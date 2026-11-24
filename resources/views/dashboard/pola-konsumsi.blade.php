@extends('layouts.public')

@section('title', 'Pola Konsumsi - BI E-COMMERCE & BPS')

@section('content')
<div class="space-y-4">

    <!-- 1. TOP NAVBAR / HEADER (Persis Sesuai Referensi Gambar) -->
    <header class="bg-white rounded-2xl border border-slate-100/90 shadow-[0_8px_30px_rgb(0,0,0,0.06)] px-6 py-4 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <!-- Left: Brand Logo & Title (Klik kembali ke Dashboard Publik) -->
        <a href="{{ route('public.dashboard') }}" class="flex items-center space-x-3.5 cursor-pointer">
            <div class="w-11 h-11 rounded-2xl bg-blue-50/80 border border-blue-100/70 flex items-center justify-center p-2.5 shrink-0 shadow-2xs">
                <svg class="w-full h-full" viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="11" width="4.5" height="10" rx="2" fill="#60a5fa"/>
                    <rect x="9.75" y="6" width="4.5" height="15" rx="2" fill="#2563eb"/>
                    <rect x="16.5" y="2.5" width="4.5" height="18.5" rx="2" fill="#1e40af"/>
                </svg>
            </div>
            
            <div class="flex flex-col">
                <h1 class="font-extrabold text-slate-900 text-base sm:text-lg tracking-tight leading-tight">
                    BI E-COMMERCE &amp; BPS
                </h1>
                <p class="text-[11px] font-medium text-slate-500 leading-tight mt-0.5">
                    Pemetaan Pola Konsumsi dan Daya Beli Digital di Indonesia
                </p>
                <span class="sr-only">Pola Konsumsi</span>
            </div>
        </a>

        <!-- Center: Navigation Tabs -->
        <nav class="flex items-center space-x-4 sm:space-x-7 text-xs font-semibold overflow-x-auto py-1">
            <a href="{{ route('public.dashboard') }}" 
               class="py-2 text-slate-800 hover:text-blue-600 transition-colors whitespace-nowrap font-medium">
                Dashboard Publik
            </a>
            <a href="{{ route('public.tren') }}" 
               class="py-2 text-slate-800 hover:text-blue-600 transition-colors whitespace-nowrap font-medium">
                Tren E-Commerce
            </a>
            <a href="{{ route('dashboard.pola-konsumsi') }}" 
               class="relative py-2 text-blue-600 font-extrabold transition-colors whitespace-nowrap">
                Pola Konsumsi
                <span class="absolute bottom-0 left-0 w-full h-[3px] bg-blue-600 rounded-full"></span>
            </a>
            <a href="{{ route('dashboard.daya-beli') }}" 
               class="py-2 text-slate-800 hover:text-blue-600 transition-colors whitespace-nowrap font-medium">
                Daya Beli BPS
            </a>
            <a href="{{ route('dashboard.explorer') }}" 
               class="py-2 text-slate-800 hover:text-blue-600 transition-colors whitespace-nowrap font-medium">
                Sumber Data
            </a>
        </nav>

        <!-- Right: Action Buttons -->
        <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
            <!-- CTA: Prediksi Nilai Transaksi -->
            <a href="{{ route('forecast.index') }}" 
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-2xl shadow-sm shadow-blue-500/25 transition-all flex items-center gap-2 cursor-pointer whitespace-nowrap">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span>Prediksi Nilai Transaksi</span>
            </a>

            <!-- Bagikan Button -->
            <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan halaman Pola Konsumsi berhasil disalin!');" 
               class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-800 text-xs font-bold rounded-2xl border border-slate-200/90 shadow-2xs transition-all flex items-center gap-2 cursor-pointer whitespace-nowrap">
                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
                <span>Bagikan</span>
            </button>

            <!-- Data Update Pill -->
            <div class="border border-slate-200/90 rounded-2xl px-3.5 py-2 flex items-center gap-2 bg-white shadow-2xs shrink-0">
                <div class="w-4 h-4 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="leading-none text-left">
                    <div class="text-[9px] text-slate-400 font-medium">Data diperbarui</div>
                    <div class="text-[10px] font-bold text-slate-800 mt-0.5">21 Mei 2025 10:30 WIB</div>
                </div>
            </div>
        </div>
    </header>

    <!-- 2. FILTER BAR & EXPLANATORY TEXT CARD (Persis Sesuai Gambar) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-3 items-stretch">
        
        <!-- Box 1: Periode Analisis -->
        <div class="xl:col-span-3 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center justify-between cursor-pointer">
            <div class="flex items-center space-x-3 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-700 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="text-[10px] font-medium text-slate-500 leading-none">Periode Analisis</div>
                    <div class="text-xs font-bold text-slate-900 leading-tight mt-1 truncate">
                        {{ $selectedPeriod === 'all' ? 'Semua Periode' : ($selectedPeriod === '2024' ? 'Jan 2024 - Des 2024' : 'Tahun ' . $selectedPeriod) }}
                    </div>
                </div>
            </div>
            <svg class="w-3.5 h-3.5 text-slate-600 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            <select name="periode" form="polaMasterFilterForm" onchange="document.getElementById('polaMasterFilterForm').submit()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                @foreach($availablePeriods as $k => $l)
                    <option value="{{ $k }}" {{ $selectedPeriod === $k ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
            </select>
        </div>

        <!-- Box 2: Provinsi -->
        <div class="xl:col-span-3 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center justify-between cursor-pointer">
            <div class="flex items-center space-x-3 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-700 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="text-[10px] font-medium text-slate-500 leading-none">Provinsi</div>
                    <div class="text-xs font-bold text-slate-900 leading-tight mt-1 truncate">
                        {{ $selectedProv === 'all' ? 'Indonesia (Semua Provinsi)' : $selectedProv }}
                    </div>
                </div>
            </div>
            <svg class="w-3.5 h-3.5 text-slate-600 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            <select name="provinsi" form="polaMasterFilterForm" onchange="document.getElementById('polaMasterFilterForm').submit()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <option value="all" {{ $selectedProv === 'all' ? 'selected' : '' }}>Indonesia (Semua Provinsi)</option>
                @foreach($allProvinces as $prov)
                    <option value="{{ $prov }}" {{ $selectedProv === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                @endforeach
            </select>
        </div>

        <!-- Box 3: Indikator Peta -->
        <div class="xl:col-span-2 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center justify-between cursor-pointer">
            <div class="flex items-center space-x-3 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-700 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="text-[10px] font-medium text-slate-500 leading-none">Indikator Peta</div>
                    <div class="text-xs font-bold text-slate-900 leading-tight mt-1 truncate">
                        {{ $selectedIndikator === 'durasi' ? 'Rata-Rata Durasi Pengiriman' : ($selectedIndikator === 'diskon' ? 'Total Diskon Voucher' : ($selectedIndikator === 'trx' ? 'Jumlah Transaksi' : 'Nilai Transaksi Netto')) }}
                    </div>
                </div>
            </div>
            <svg class="w-3.5 h-3.5 text-slate-600 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            <select name="indikator" form="polaMasterFilterForm" onchange="document.getElementById('polaMasterFilterForm').submit()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <option value="netto" {{ $selectedIndikator === 'netto' ? 'selected' : '' }}>Nilai Transaksi Netto</option>
                <option value="trx" {{ $selectedIndikator === 'trx' ? 'selected' : '' }}>Jumlah Transaksi</option>
                <option value="diskon" {{ $selectedIndikator === 'diskon' ? 'selected' : '' }}>Total Diskon Voucher</option>
                <option value="durasi" {{ $selectedIndikator === 'durasi' ? 'selected' : '' }}>Rata-Rata Durasi Pengiriman</option>
            </select>
        </div>

        <!-- Box 4: Explanatory Card -->
        <div class="xl:col-span-4 bg-white rounded-2xl border border-slate-200/90 shadow-2xs px-4 py-3 flex items-center">
            <p class="text-xs text-slate-600 font-medium leading-relaxed">
                Halaman ini menyajikan pola konsumsi e-commerce berdasarkan platform, kategori produk, nilai transaksi, metode pembayaran, durasi pengiriman, dan status pengiriman.
            </p>
        </div>

        <form method="GET" action="{{ route('dashboard.pola-konsumsi') }}" id="polaMasterFilterForm" class="hidden"></form>
    </div>

    <!-- 3. TOP 5 KPI CARDS (Bentuk Squircle Sesuai Referensi Gambar) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
        
        <!-- KPI 1: NILAI TRANSAKSI NETTO -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-600 flex items-center justify-center text-white shrink-0 shadow-md shadow-emerald-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <span class="text-slate-400 hover:text-slate-600 cursor-pointer text-xs" title="Total nilai transaksi netto">&#9432;</span>
                </div>

                <div class="mt-3">
                    <div class="text-[11px] font-semibold text-slate-500">Nilai Transaksi Netto</div>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                        Rp {{ number_format($totalGmvNetto / 1000000000000, 2, ',', '.') }} T
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium">Total periode analisis</div>
                </div>
            </div>

            <div class="text-[10px] font-bold text-emerald-600 mt-3 flex items-center gap-1">
                <span>&uarr; {{ $deltaGmv }}%</span>
                <span class="text-slate-400 font-normal">dibandingkan periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 2: TOTAL TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-2xl bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-md shadow-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <span class="text-slate-400 hover:text-slate-600 cursor-pointer text-xs" title="Jumlah transaksi unik">&#9432;</span>
                </div>

                <div class="mt-3">
                    <div class="text-[11px] font-semibold text-slate-500">Total Transaksi</div>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                        {{ number_format($totalTransaksi, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium">Total periode analisis</div>
                </div>
            </div>

            <div class="text-[10px] font-bold text-emerald-600 mt-3 flex items-center gap-1">
                <span>&uarr; {{ $deltaTrx }}%</span>
                <span class="text-slate-400 font-normal">dibandingkan periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 3: RATA-RATA NILAI TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-2xl bg-purple-600 flex items-center justify-center text-white shrink-0 shadow-md shadow-purple-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span class="text-slate-400 hover:text-slate-600 cursor-pointer text-xs" title="Rata-rata pengeluaran per transaksi">&#9432;</span>
                </div>

                <div class="mt-3">
                    <div class="text-[11px] font-semibold text-slate-500">Rata-rata Nilai Transaksi</div>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                        Rp {{ number_format($avgAov, 0, ',', '.') }}
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium">Per transaksi</div>
                </div>
            </div>

            <div class="text-[10px] font-bold text-emerald-600 mt-3 flex items-center gap-1">
                <span>&uarr; {{ $deltaAov }}%</span>
                <span class="text-slate-400 font-normal">dibandingkan periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 4: RATA-RATA DISKON -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-2xl bg-amber-500 flex items-center justify-center text-white shrink-0 shadow-md shadow-amber-500/20">
                        <span class="font-black text-lg">%</span>
                    </div>
                    <span class="text-slate-400 hover:text-slate-600 cursor-pointer text-xs" title="Rata-rata rasio diskon voucher terhadap nilai bruto">&#9432;</span>
                </div>

                <div class="mt-3">
                    <div class="text-[11px] font-semibold text-slate-500">Rata-rata Diskon</div>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                        {{ number_format($avgDiskonPct, 1, ',', '.') }}%
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium">Dari nilai transaksi bruto</div>
                </div>
            </div>

            <div class="text-[10px] font-medium text-slate-400 mt-3 flex items-center gap-1">
                <span>Rasio diskon platform stabil</span>
            </div>
        </div>

        <!-- KPI 5: RATA-RATA DURASI PENGIRIMAN -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-2xl bg-teal-500 flex items-center justify-center text-white shrink-0 shadow-md shadow-teal-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    </div>
                    <span class="text-slate-400 hover:text-slate-600 cursor-pointer text-xs" title="Rata-rata waktu pengiriman">&#9432;</span>
                </div>

                <div class="mt-3">
                    <div class="text-[11px] font-semibold text-slate-500">Rata-rata Durasi Pengiriman</div>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                        {{ number_format($avgDurasiKirim, 1, ',', '.') }} Hari
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium">Rata-rata durasi pengiriman</div>
                </div>
            </div>

            <div class="text-[10px] font-medium text-slate-400 mt-3 flex items-center gap-1">
                <span>Efisiensi logistik nasional</span>
            </div>
        </div>

    </div>

    <!-- 4. 8 ANALYTICAL CHARTS (GRID 2 ROWS x 4 COLUMNS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3.5">

        <!-- ============================================================== -->
        <!-- ROW 1 (Charts 1 - 4) -->
        <!-- ============================================================== -->

        <!-- CHART 1: Nilai Transaksi per Platform -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2 mb-2">
                    <div class="w-5 h-5 rounded-md bg-blue-600 text-white font-extrabold text-[10px] flex items-center justify-center shrink-0">
                        1
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xs font-extrabold text-slate-900 leading-tight">Nilai Transaksi per Platform</h3>
                        <p class="text-[9px] font-medium text-slate-400 mt-0.5">Donut Chart</p>
                    </div>
                </div>
                <div class="relative h-44 w-full flex items-center">
                    <div class="w-1/2 h-full relative">
                        <canvas id="polaPlatformChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                            <span class="text-[8px] text-slate-400 font-medium">Total</span>
                            <span class="text-[10px] font-black text-slate-900 leading-tight">Rp 4,82 T</span>
                        </div>
                    </div>
                    <div class="w-1/2 pl-2 space-y-1.5 text-[9px]">
                        @foreach($c1_platform as $plt)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1.5 min-w-0">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $plt['color'] }}"></span>
                                <span class="text-slate-600 truncate">{{ $plt['name'] }}</span>
                            </div>
                            <span class="font-bold text-slate-800 ml-1">{{ $plt['pct'] }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART 2: Nilai Transaksi per Kategori Produk -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2 mb-2">
                    <div class="w-5 h-5 rounded-md bg-blue-600 text-white font-extrabold text-[10px] flex items-center justify-center shrink-0">
                        2
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xs font-extrabold text-slate-900 leading-tight">Nilai Transaksi per Kategori Produk</h3>
                        <p class="text-[9px] font-medium text-slate-400 mt-0.5">Donut Chart</p>
                    </div>
                </div>
                <div class="relative h-44 w-full flex items-center">
                    <div class="w-1/2 h-full relative">
                        <canvas id="polaKategoriChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                            <span class="text-[8px] text-slate-400 font-medium">Total</span>
                            <span class="text-[10px] font-black text-slate-900 leading-tight">Rp 4,82 T</span>
                        </div>
                    </div>
                    <div class="w-1/2 pl-2 space-y-1.5 text-[9px]">
                        @foreach($c2_kategori as $kat)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1.5 min-w-0">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $kat['color'] }}"></span>
                                <span class="text-slate-600 truncate">{{ $kat['name'] }}</span>
                            </div>
                            <span class="font-bold text-slate-800 ml-1">{{ $kat['pct'] }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART 3: Top 10 Kategori Produk (Nilai Transaksi) -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2 mb-2">
                    <div class="w-5 h-5 rounded-md bg-blue-600 text-white font-extrabold text-[10px] flex items-center justify-center shrink-0">
                        3
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xs font-extrabold text-slate-900 leading-tight">Top 10 Kategori Produk (Nilai Transaksi)</h3>
                        <p class="text-[9px] font-medium text-slate-400 mt-0.5">Horizontal Bar Chart (Rupiah)</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="polaTopKategoriChart"></canvas>
                </div>
            </div>
        </div>

        <!-- CHART 4: Rata-rata Nilai Transaksi per Platform -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2 mb-2">
                    <div class="w-5 h-5 rounded-md bg-blue-600 text-white font-extrabold text-[10px] flex items-center justify-center shrink-0">
                        4
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xs font-extrabold text-slate-900 leading-tight">Rata-rata Nilai Transaksi per Platform</h3>
                        <p class="text-[9px] font-medium text-slate-400 mt-0.5">Bar Chart (Rupiah)</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="polaPlatformAovChart"></canvas>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- ROW 2 (Charts 5 - 8) -->
        <!-- ============================================================== -->

        <!-- CHART 5: Distribusi Transaksi per Kategori Produk (Treemap) -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2 mb-2">
                    <div class="w-5 h-5 rounded-md bg-blue-600 text-white font-extrabold text-[10px] flex items-center justify-center shrink-0">
                        5
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xs font-extrabold text-slate-900 leading-tight">Distribusi Transaksi per Kategori Produk</h3>
                        <p class="text-[9px] font-medium text-slate-400 mt-0.5">Treemap</p>
                    </div>
                </div>
                <!-- Treemap Grid Layout Matching Reference Image -->
                <div class="h-44 w-full grid grid-cols-10 grid-rows-2 gap-1.5 rounded-xl overflow-hidden p-1 bg-slate-50 border border-slate-100 text-white font-bold">
                    <!-- Fashion & Aksesoris -->
                    <div class="col-span-4 row-span-2 bg-[#0d9488] rounded-lg p-2.5 flex flex-col justify-between shadow-2xs">
                        <span class="text-[10px] leading-tight">Fashion &amp; Aksesoris</span>
                        <span class="text-sm font-black">28,4%</span>
                    </div>
                    <!-- Elektronik -->
                    <div class="col-span-3 row-span-1 bg-[#f97316] rounded-lg p-2 flex flex-col justify-between shadow-2xs">
                        <span class="text-[9px] leading-tight">Elektronik</span>
                        <span class="text-xs font-black">24,7%</span>
                    </div>
                    <!-- Perlengkapan Rumah -->
                    <div class="col-span-3 row-span-1 bg-[#8b5cf6] rounded-lg p-2 flex flex-col justify-between shadow-2xs">
                        <span class="text-[9px] leading-tight">Perlengkapan Rumah</span>
                        <span class="text-xs font-black">10,8%</span>
                    </div>
                    <!-- Makanan & Minuman -->
                    <div class="col-span-2 row-span-1 bg-[#2563eb] rounded-lg p-1.5 flex flex-col justify-between shadow-2xs">
                        <span class="text-[8px] leading-tight">Makanan &amp; Minuman</span>
                        <span class="text-[10px] font-black">10,8%</span>
                    </div>
                    <!-- Makanan & Perawatan -->
                    <div class="col-span-2 row-span-1 bg-[#0284c7] rounded-lg p-1.5 flex flex-col justify-between shadow-2xs">
                        <span class="text-[8px] leading-tight truncate">Makanan &amp; Perawatan</span>
                        <span class="text-[10px] font-black">8,9%</span>
                    </div>
                    <!-- Lainnya -->
                    <div class="col-span-2 row-span-1 bg-[#334155] rounded-lg p-1.5 flex flex-col justify-between shadow-2xs">
                        <span class="text-[8px] leading-tight">Lainnya</span>
                        <span class="text-[10px] font-black">12,6%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART 6: Metode Pembayaran -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2 mb-2">
                    <div class="w-5 h-5 rounded-md bg-blue-600 text-white font-extrabold text-[10px] flex items-center justify-center shrink-0">
                        6
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xs font-extrabold text-slate-900 leading-tight">Metode Pembayaran</h3>
                        <p class="text-[9px] font-medium text-slate-400 mt-0.5">Donut Chart</p>
                    </div>
                </div>
                <div class="relative h-44 w-full flex items-center">
                    <div class="w-1/2 h-full relative">
                        <canvas id="polaPaymentChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                            <span class="text-[7.5px] text-slate-400 font-medium">Total</span>
                            <span class="text-[9px] font-black text-slate-900 leading-tight">3.152.672</span>
                            <span class="text-[7.5px] text-slate-400">Transaksi</span>
                        </div>
                    </div>
                    <div class="w-1/2 pl-2 space-y-1.5 text-[8.5px]">
                        @foreach($c6_payment as $pay)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1 min-w-0">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $pay['color'] }}"></span>
                                <span class="text-slate-600 truncate">{{ $pay['name'] }}</span>
                            </div>
                            <span class="font-bold text-slate-800 ml-1">{{ $pay['pct'] }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- CHART 7: Distribusi Durasi Pengiriman -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2 mb-2">
                    <div class="w-5 h-5 rounded-md bg-blue-600 text-white font-extrabold text-[10px] flex items-center justify-center shrink-0">
                        7
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xs font-extrabold text-slate-900 leading-tight">Distribusi Durasi Pengiriman</h3>
                        <p class="text-[9px] font-medium text-slate-400 mt-0.5">Column Chart (Hari)</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="polaDurasiChart"></canvas>
                </div>
            </div>
        </div>

        <!-- CHART 8: Status Keterlambatan Pengiriman -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-2xs hover:shadow-xs transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2 mb-2">
                    <div class="w-5 h-5 rounded-md bg-blue-600 text-white font-extrabold text-[10px] flex items-center justify-center shrink-0">
                        8
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xs font-extrabold text-slate-900 leading-tight">Status Keterlambatan Pengiriman</h3>
                        <p class="text-[9px] font-medium text-slate-400 mt-0.5">Donut Chart</p>
                    </div>
                </div>
                <div class="relative h-44 w-full flex items-center">
                    <div class="w-1/2 h-full relative">
                        <canvas id="polaOntimeChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                            <span class="text-[7.5px] text-slate-400 font-medium">Total</span>
                            <span class="text-[9px] font-black text-slate-900 leading-tight">3.152.672</span>
                            <span class="text-[7.5px] text-slate-400">Transaksi</span>
                        </div>
                    </div>
                    <div class="w-1/2 pl-2 space-y-2 text-[9px]">
                        @foreach($c8_ontime as $st)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1.5 min-w-0">
                                <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $st['color'] }}"></span>
                                <span class="text-slate-600 truncate">{{ $st['name'] }}</span>
                            </div>
                            <span class="font-bold text-slate-800 ml-1">{{ $st['pct'] }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 5. TABEL DATA TRANSAKSI (10 DATA TERBARU) DARI DATABASE ASLI -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden">
        
        <!-- Header Tabel -->
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="text-sm font-extrabold text-slate-900 tracking-tight">
                Tabel Data Transaksi (10 Data Terbaru)
            </h2>
            <span class="text-xs text-slate-400 font-medium">
                Data real-time dari database MySQL
            </span>
        </div>

        <!-- Tabel Responsive -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-[11px]">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-600 border-b border-slate-200 font-bold whitespace-nowrap">
                        <th class="py-3 px-3">No</th>
                        <th class="py-3 px-3">ID Transaksi</th>
                        <th class="py-3 px-3">Tanggal</th>
                        <th class="py-3 px-3">Platform</th>
                        <th class="py-3 px-3">Kategori Produk</th>
                        <th class="py-3 px-3 text-right">Nilai Transaksi Netto (Rp)</th>
                        <th class="py-3 px-3 text-right">Nilai Transaksi Bruto (Rp)</th>
                        <th class="py-3 px-3 text-right">Diskon (Rp)</th>
                        <th class="py-3 px-3">Metode Pembayaran</th>
                        <th class="py-3 px-3 text-center">Durasi Pengiriman (Hari)</th>
                        <th class="py-3 px-3 text-center">Status Pengiriman</th>
                        <th class="py-3 px-3">Provinsi Pembeli</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($latestTransactions as $trx)
                    <tr class="hover:bg-blue-50/40 transition-colors whitespace-nowrap">
                        <td class="py-2.5 px-3 text-slate-400 font-semibold">
                            {{ $loop->iteration }}
                        </td>
                        <td class="py-2.5 px-3 font-bold text-slate-900 font-mono text-[11px]">
                            {{ $trx->transaksi_id }}
                        </td>
                        <td class="py-2.5 px-3 text-slate-600">
                            {{ \Carbon\Carbon::parse($trx->timestamp_transaksi)->translatedFormat('d M Y H:i:s') }}
                        </td>
                        <td class="py-2.5 px-3 font-semibold text-slate-800">
                            {{ $trx->platform_ecommerce }}
                        </td>
                        <td class="py-2.5 px-3 text-slate-700">
                            {{ $trx->kategori_produk }}
                        </td>
                        <td class="py-2.5 px-3 text-right font-mono font-bold text-blue-700">
                            {{ number_format($trx->nilai_transaksi_netto_idr, 0, ',', '.') }}
                        </td>
                        <td class="py-2.5 px-3 text-right font-mono text-slate-800">
                            {{ number_format($trx->nilai_transaksi_bruto_idr, 0, ',', '.') }}
                        </td>
                        <td class="py-2.5 px-3 text-right font-mono text-slate-800">
                            {{ number_format($trx->diskon_voucher_platform_idr, 0, ',', '.') }}
                        </td>
                        <td class="py-2.5 px-3 text-slate-700">
                            {{ $trx->metode_pembayaran }}
                        </td>
                        <td class="py-2.5 px-3 text-center font-bold text-slate-800">
                            {{ $trx->durasi_pengiriman_hari }}
                        </td>
                        <td class="py-2.5 px-3 text-center">
                            @if($trx->status_keterlambatan_pengiriman === 'Tepat Waktu')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                    Tepat Waktu
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200/80">
                                    Terlambat
                                </span>
                            @endif
                        </td>
                        <td class="py-2.5 px-3 text-slate-800">
                            {{ $trx->provinsi }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center py-6 text-slate-400">
                            Tidak ada data transaksi yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 6. FOOTER NOTE -->
    <div class="pt-3 pb-2 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500 gap-2 border-t border-slate-200/70">
        <div>
            Sumber Data: Dataset E-Commerce (2024-2025) &amp; Statistik Pendapatan BPS
        </div>
        <div class="flex items-center gap-1">
            <span>&copy; 2025 Bank Indonesia &amp; BPS</span>
            <span class="text-slate-400 hover:text-slate-600 cursor-pointer text-xs" title="Informasi Hak Cipta">&#9432;</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultFont = "'Plus Jakarta Sans', sans-serif";
    const defaultColor = '#64748b';
    const gridColor = '#f1f5f9';

    // ==========================================
    // CHART 1: Nilai Transaksi per Platform (Donut)
    // ==========================================
    const c1Platform = @json($c1_platform);
    new Chart(document.getElementById('polaPlatformChart'), {
        type: 'doughnut',
        data: {
            labels: c1Platform.map(d => d.name),
            datasets: [{
                data: c1Platform.map(d => d.pct),
                backgroundColor: c1Platform.map(d => d.color),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: { legend: { display: false } }
        }
    });

    // ==========================================
    // CHART 2: Nilai Transaksi per Kategori Produk (Donut)
    // ==========================================
    const c2Kategori = @json($c2_kategori);
    new Chart(document.getElementById('polaKategoriChart'), {
        type: 'doughnut',
        data: {
            labels: c2Kategori.map(d => d.name),
            datasets: [{
                data: c2Kategori.map(d => d.pct),
                backgroundColor: c2Kategori.map(d => d.color),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: { legend: { display: false } }
        }
    });

    // ==========================================
    // CHART 3: Top 10 Kategori Produk (Horizontal Bar)
    // ==========================================
    const c3Categories = @json($c3_categories);
    new Chart(document.getElementById('polaTopKategoriChart'), {
        type: 'bar',
        data: {
            labels: c3Categories.map(d => d.name),
            datasets: [{
                data: c3Categories.map(d => d.val),
                backgroundColor: '#2563eb',
                borderRadius: 3
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    ticks: {
                        font: { size: 7, family: defaultFont },
                        color: defaultColor,
                        callback: val => val >= 1 ? val + ' T' : (val * 1000).toFixed(0) + ' M'
                    },
                    grid: { color: gridColor },
                    max: 1.5
                },
                y: {
                    ticks: { font: { size: 6.5, family: defaultFont }, color: defaultColor }
                }
            }
        }
    });

    // ==========================================
    // CHART 4: Rata-rata Nilai Transaksi per Platform (Bar)
    // ==========================================
    const c4PlatformAov = @json($c4_platformAov);
    new Chart(document.getElementById('polaPlatformAovChart'), {
        type: 'bar',
        data: {
            labels: c4PlatformAov.map(d => d.name),
            datasets: [{
                data: c4PlatformAov.map(d => d.val),
                backgroundColor: '#0d9488',
                borderRadius: 4,
                barPercentage: 0.55
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    ticks: { font: { size: 7.5, family: defaultFont }, color: defaultColor },
                    grid: { display: false }
                },
                y: {
                    ticks: {
                        font: { size: 7, family: defaultFont },
                        color: defaultColor,
                        callback: val => val.toFixed(1) + ' M'
                    },
                    grid: { color: gridColor },
                    max: 2.4
                }
            }
        }
    });

    // ==========================================
    // CHART 6: Metode Pembayaran (Donut)
    // ==========================================
    const c6Payment = @json($c6_payment);
    new Chart(document.getElementById('polaPaymentChart'), {
        type: 'doughnut',
        data: {
            labels: c6Payment.map(d => d.name),
            datasets: [{
                data: c6Payment.map(d => d.pct),
                backgroundColor: c6Payment.map(d => d.color),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: { legend: { display: false } }
        }
    });

    // ==========================================
    // CHART 7: Distribusi Durasi Pengiriman (Column)
    // ==========================================
    const c7Durasi = @json($c7_durasi);
    new Chart(document.getElementById('polaDurasiChart'), {
        type: 'bar',
        data: {
            labels: c7Durasi.map(d => d.label),
            datasets: [{
                data: c7Durasi.map(d => d.val),
                backgroundColor: '#2563eb',
                borderRadius: 4,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    ticks: { font: { size: 7.5, family: defaultFont }, color: defaultColor },
                    grid: { display: false }
                },
                y: {
                    ticks: {
                        font: { size: 7, family: defaultFont },
                        color: defaultColor,
                        callback: val => val >= 1000 ? (val/1000).toFixed(1) + ' M' : val + ' K'
                    },
                    grid: { color: gridColor },
                    max: 1200
                }
            }
        }
    });

    // ==========================================
    // CHART 8: Status Keterlambatan Pengiriman (Donut)
    // ==========================================
    const c8Ontime = @json($c8_ontime);
    new Chart(document.getElementById('polaOntimeChart'), {
        type: 'doughnut',
        data: {
            labels: c8Ontime.map(d => d.name),
            datasets: [{
                data: c8Ontime.map(d => d.pct),
                backgroundColor: c8Ontime.map(d => d.color),
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: { legend: { display: false } }
        }
    });

});
</script>
@endpush
