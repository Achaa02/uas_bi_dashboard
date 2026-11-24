@extends('layouts.public')

@section('title', 'Daya Beli Digital - BI E-COMMERCE & BPS')

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
                <span class="sr-only">Daya Beli BPS</span>
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
               class="py-2 text-slate-800 hover:text-blue-600 transition-colors whitespace-nowrap font-medium">
                Pola Konsumsi
            </a>
            <a href="{{ route('dashboard.daya-beli') }}" 
               class="relative py-2 text-blue-600 font-extrabold transition-colors whitespace-nowrap">
                Daya Beli Digital
                <span class="absolute bottom-0 left-0 w-full h-[3px] bg-blue-600 rounded-full"></span>
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
            <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan halaman Daya Beli Digital berhasil disalin!');" 
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
                        {{ $selectedPeriode }}
                    </div>
                </div>
            </div>
            <form id="filterFormPeriode" method="GET" action="{{ route('dashboard.daya-beli') }}" class="absolute inset-0 opacity-0 cursor-pointer">
                <input type="hidden" name="provinsi" value="{{ $selectedProvinsi }}">
                <input type="hidden" name="indikator" value="{{ $selectedIndikator }}">
                <select name="periode" onchange="this.form.submit()" class="w-full h-full cursor-pointer">
                    <option value="Jan 2024 - Des 2024" {{ $selectedPeriode == 'Jan 2024 - Des 2024' ? 'selected' : '' }}>Jan 2024 - Des 2024</option>
                    <option value="Jan 2025 - Des 2025" {{ $selectedPeriode == 'Jan 2025 - Des 2025' ? 'selected' : '' }}>Jan 2025 - Des 2025</option>
                    <option value="Jan 2023 - Des 2023" {{ $selectedPeriode == 'Jan 2023 - Des 2023' ? 'selected' : '' }}>Jan 2023 - Des 2023</option>
                </select>
            </form>
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <!-- Box 2: Provinsi -->
        <div class="xl:col-span-3 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center justify-between cursor-pointer">
            <div class="flex items-center space-x-3 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 border border-emerald-100/70 flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="text-[10px] font-medium text-slate-500 leading-none">Provinsi</div>
                    <div class="text-xs font-bold text-slate-900 leading-tight mt-1 truncate">
                        {{ $selectedProvinsi === 'all' ? 'Indonesia (Semua Provinsi)' : $selectedProvinsi }}
                    </div>
                </div>
            </div>
            <form id="filterFormProv" method="GET" action="{{ route('dashboard.daya-beli') }}" class="absolute inset-0 opacity-0 cursor-pointer">
                <input type="hidden" name="periode" value="{{ $selectedPeriode }}">
                <input type="hidden" name="indikator" value="{{ $selectedIndikator }}">
                <select name="provinsi" onchange="this.form.submit()" class="w-full h-full cursor-pointer">
                    <option value="all" {{ $selectedProvinsi === 'all' ? 'selected' : '' }}>Indonesia (Semua Provinsi)</option>
                    @foreach($availableProvinces as $p)
                        <option value="{{ $p }}" {{ $selectedProvinsi == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </form>
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <!-- Box 3: Indikator Peta -->
        <div class="xl:col-span-3 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center justify-between cursor-pointer">
            <div class="flex items-center space-x-3 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-purple-50 border border-purple-100/70 flex items-center justify-center text-purple-600 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <div class="min-w-0">
                    <div class="text-[10px] font-medium text-slate-500 leading-none">Indikator Peta</div>
                    <div class="text-xs font-bold text-slate-900 leading-tight mt-1 truncate">
                        {{ $selectedIndikator === 'netto' ? 'Nilai Transaksi Netto' : ($selectedIndikator === 'idbd' ? 'Indeks Daya Beli Digital (IDBD)' : 'Rata-rata Pengeluaran') }}
                    </div>
                </div>
            </div>
            <form id="filterFormIndikator" method="GET" action="{{ route('dashboard.daya-beli') }}" class="absolute inset-0 opacity-0 cursor-pointer">
                <input type="hidden" name="periode" value="{{ $selectedPeriode }}">
                <input type="hidden" name="provinsi" value="{{ $selectedProvinsi }}">
                <select name="indikator" onchange="this.form.submit()" class="w-full h-full cursor-pointer">
                    <option value="netto" {{ $selectedIndikator == 'netto' ? 'selected' : '' }}>Nilai Transaksi Netto</option>
                    <option value="idbd" {{ $selectedIndikator == 'idbd' ? 'selected' : '' }}>Indeks Daya Beli Digital (IDBD)</option>
                    <option value="pengeluaran" {{ $selectedIndikator == 'pengeluaran' ? 'selected' : '' }}>Rata-rata Pengeluaran</option>
                </select>
            </form>
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <!-- Box 4: Explanatory Card (Persis Sesuai Gambar) -->
        <div class="xl:col-span-3 bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-3.5 flex items-center justify-between">
            <p class="text-[11px] leading-relaxed text-slate-600 font-medium">
                Halaman ini menyajikan indikator dan analisis daya beli digital masyarakat berdasarkan transaksi e-commerce di Indonesia.
            </p>
        </div>
    </div>

    <!-- 3. 5 KPI CARDS SQUIRCLE (Persis Sesuai Desain & Gambar) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        
        <!-- KPI 1: Indeks Daya Beli Digital (IDBD) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-2xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-emerald-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-[11px] font-semibold text-slate-700 leading-tight">
                        Indeks Daya Beli Digital (IDBD)
                    </h2>
                    <div class="flex items-baseline space-x-1 mt-0.5">
                        <span class="text-xl font-extrabold text-slate-900 leading-none">{{ $kpis['idbd'] }}</span>
                        <span class="text-[10px] text-slate-600 font-medium ml-1">{{ $kpis['idbd_base'] }}</span>
                    </div>
                </div>
            </div>
            <div class="text-[10px] font-semibold text-emerald-600 flex items-center gap-1 mt-1">
                <span>&uarr; {{ $kpis['idbd_growth'] }}</span>
                <span class="text-slate-500 font-normal">dibandingkan periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 2: Rata-rata Pengeluaran per Kapita -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-2xl bg-blue-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-[11px] font-semibold text-slate-700 leading-tight">
                        Rata-rata Pengeluaran per Kapita
                    </h2>
                    <div class="flex items-baseline space-x-1 mt-0.5">
                        <span class="text-xl font-extrabold text-slate-900 leading-none">{{ $kpis['pengeluaran'] }}</span>
                        <span class="text-[10px] text-slate-600 font-medium ml-1">{{ $kpis['pengeluaran_period'] }}</span>
                    </div>
                </div>
            </div>
            <div class="text-[10px] font-semibold text-emerald-600 flex items-center gap-1 mt-1">
                <span>&uarr; {{ $kpis['pengeluaran_growth'] }}</span>
                <span class="text-slate-500 font-normal">dibandingkan periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 3: Frekuensi Belanja per Kapita -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-2xl bg-purple-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-purple-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-[11px] font-semibold text-slate-700 leading-tight">
                        Frekuensi Belanja per Kapita
                    </h2>
                    <div class="flex items-baseline space-x-1 mt-0.5">
                        <span class="text-xl font-extrabold text-slate-900 leading-none">{{ $kpis['frekuensi'] }}</span>
                        <span class="text-[10px] text-slate-600 font-medium ml-1">{{ $kpis['frekuensi_unit'] }}</span>
                    </div>
                </div>
            </div>
            <div class="text-[10px] font-semibold text-emerald-600 flex items-center gap-1 mt-1">
                <span>&uarr; {{ $kpis['frekuensi_growth'] }}</span>
                <span class="text-slate-500 font-normal">dibandingkan periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 4: Porsi E-Commerce terhadap Total Pengeluaran RT -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-2xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-amber-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-[10px] font-semibold text-slate-700 leading-tight">
                        Porsi E-Commerce terhadap Total Pengeluaran Rumah Tangga
                    </h2>
                    <div class="flex items-baseline space-x-1 mt-0.5">
                        <span class="text-xl font-extrabold text-slate-900 leading-none">{{ $kpis['porsi_ecom'] }}</span>
                    </div>
                </div>
            </div>
            <div class="text-[10px] font-semibold text-emerald-600 flex items-center gap-1 mt-1">
                <span>&uarr; {{ $kpis['porsi_ecom_growth'] }}</span>
                <span class="text-slate-500 font-normal">dibandingkan periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 5: Pertumbuhan Daya Beli Digital (YoY) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs flex flex-col justify-between">
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-10 h-10 rounded-2xl bg-teal-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-teal-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-[11px] font-semibold text-slate-700 leading-tight">
                        Pertumbuhan Daya Beli Digital (YoY)
                    </h2>
                    <div class="flex items-baseline space-x-1 mt-0.5">
                        <span class="text-xl font-extrabold text-slate-900 leading-none">{{ $kpis['pertumbuhan_yoy'] }}</span>
                    </div>
                </div>
            </div>
            <div class="text-[10px] font-semibold text-slate-500 flex items-center gap-1 mt-1">
                <span>dibandingkan periode tahun lalu</span>
            </div>
        </div>

    </div>

    <!-- 4. 8 ANALYTICAL CHARTS (2 Rows x 4 Columns Grid) -->
    
    <!-- BARIS 1 (Charts 1, 2, 3, 4) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3.5">
        
        <!-- Chart 1: Indeks Daya Beli Digital (IDBD) Line Chart Bulanan -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-md bg-blue-600 text-white text-[11px] font-extrabold flex items-center justify-center shrink-0">1</span>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 leading-tight">Indeks Daya Beli Digital (IDBD)</h3>
                        <p class="text-[10px] text-slate-600">Line Chart (Bulanan)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1.5">
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-100 rounded-lg px-2 py-0.5">
                        {{ $chartIdbdMonthly['current'] }}
                    </span>
                </div>
            </div>
            <div class="h-44 w-full">
                <canvas id="chartIdbdMonthlyCanvas"></canvas>
            </div>
        </div>

        <!-- Chart 2: Rata-rata Pengeluaran per Kapita Line Chart Bulanan -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-md bg-blue-600 text-white text-[11px] font-extrabold flex items-center justify-center shrink-0">2</span>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 leading-tight">Rata-rata Pengeluaran per Kapita</h3>
                        <p class="text-[10px] text-slate-600">Line Chart (Bulanan)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1.5">
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-100 rounded-lg px-2 py-0.5">
                        {{ $chartPengeluaranMonthly['current'] }}
                    </span>
                </div>
            </div>
            <div class="h-44 w-full">
                <canvas id="chartPengeluaranMonthlyCanvas"></canvas>
            </div>
        </div>

        <!-- Chart 3: Frekuensi Belanja per Kapita Line Chart Bulanan -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-md bg-blue-600 text-white text-[11px] font-extrabold flex items-center justify-center shrink-0">3</span>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 leading-tight">Frekuensi Belanja per Kapita</h3>
                        <p class="text-[10px] text-slate-600">Line Chart (Bulanan)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1.5">
                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-100 rounded-lg px-2 py-0.5">
                        {{ $chartFrekuensiMonthly['current'] }}
                    </span>
                </div>
            </div>
            <div class="h-44 w-full">
                <canvas id="chartFrekuensiMonthlyCanvas"></canvas>
            </div>
        </div>

        <!-- Chart 4: Perbandingan IDBD Antar Provinsi (Top 10) Horizontal Bar -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-md bg-blue-600 text-white text-[11px] font-extrabold flex items-center justify-center shrink-0">4</span>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 leading-tight">Perbandingan IDBD Antar Provinsi (Top 10)</h3>
                        <p class="text-[10px] text-slate-600">Horizontal Bar Chart (IDBD)</p>
                    </div>
                </div>
            </div>
            <div class="h-44 w-full">
                <canvas id="chartTop10IdbdCanvas"></canvas>
            </div>
        </div>

    </div>

    <!-- BARIS 2 (Charts 5, 6, 7, 8) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3.5">

        <!-- Chart 5: Rata-rata Pengeluaran per Kapita berdasarkan Kelompok Usia -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-md bg-blue-600 text-white text-[11px] font-extrabold flex items-center justify-center shrink-0">5</span>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 leading-tight">Rata-rata Pengeluaran per Kapita berdasarkan Kelompok Usia</h3>
                        <p class="text-[10px] text-slate-600">Column Chart (Rp)</p>
                    </div>
                </div>
            </div>
            <div class="h-44 w-full">
                <canvas id="chartPengeluaranUsiaCanvas"></canvas>
            </div>
        </div>

        <!-- Chart 6: Kontribusi Nilai Transaksi berdasarkan Kelompok Pendapatan (Donut) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-md bg-blue-600 text-white text-[11px] font-extrabold flex items-center justify-center shrink-0">6</span>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 leading-tight">Kontribusi Nilai Transaksi berdasarkan Kelompok Pendapatan</h3>
                        <p class="text-[10px] text-slate-600">Donut Chart</p>
                    </div>
                </div>
            </div>
            <div class="h-44 w-full flex items-center">
                <div class="w-1/2 h-full relative flex items-center justify-center">
                    <canvas id="chartPendapatanDonutCanvas"></canvas>
                </div>
                <div class="w-1/2 pl-3 space-y-1.5 text-[10px]">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500 shrink-0"></span>
                            &lt; Rp 2 Juta
                        </span>
                        <span class="font-bold text-slate-900">18,7%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                            Rp 2 - 5 Juta
                        </span>
                        <span class="font-bold text-slate-900">32,6%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span>
                            Rp 5 - 10 Juta
                        </span>
                        <span class="font-bold text-slate-900">28,4%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500 shrink-0"></span>
                            Rp 10 - 20 Juta
                        </span>
                        <span class="font-bold text-slate-900">14,1%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-slate-600">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-400 shrink-0"></span>
                            &gt; Rp 20 Juta
                        </span>
                        <span class="font-bold text-slate-900">6,2%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 7: IDBD berdasarkan Metode Pembayaran -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-md bg-blue-600 text-white text-[11px] font-extrabold flex items-center justify-center shrink-0">7</span>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 leading-tight">IDBD berdasarkan Metode Pembayaran</h3>
                        <p class="text-[10px] text-slate-600">Bar Chart (IDBD)</p>
                    </div>
                </div>
            </div>
            <div class="h-44 w-full">
                <canvas id="chartMetodeIdbdCanvas"></canvas>
            </div>
        </div>

        <!-- Chart 8: Pertumbuhan IDBD (YoY) per Provinsi (Top 10) -->
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <span class="w-5 h-5 rounded-md bg-blue-600 text-white text-[11px] font-extrabold flex items-center justify-center shrink-0">8</span>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900 leading-tight">Pertumbuhan IDBD (YoY) per Provinsi (Top 10)</h3>
                        <p class="text-[10px] text-slate-600">Horizontal Bar Chart (%)</p>
                    </div>
                </div>
            </div>
            <div class="h-44 w-full">
                <canvas id="chartPertumbuhanYoYCanvas"></canvas>
            </div>
        </div>

    </div>

    <!-- 5. TABEL INDIKATOR DAYA BELI DIGITAL PER PROVINSI (Persis Sesuai Mockup & Database) -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-5 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Tabel Indikator Daya Beli Digital per Provinsi</h3>
                <p class="text-xs text-slate-500 mt-0.5">Integrasi data riil transaksi e-commerce dan survei sosial ekonomi BPS per provinsi</p>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50/80 text-[11px] font-bold text-slate-600 border-y border-slate-200/80">
                    <tr>
                        <th class="py-3 px-3">No</th>
                        <th class="py-3 px-3">Provinsi</th>
                        <th class="py-3 px-3 text-right">Indeks Daya Beli Digital (Base 100)</th>
                        <th class="py-3 px-3 text-right">Rata-rata Pengeluaran per Kapita (Rp)</th>
                        <th class="py-3 px-3 text-right">Frekuensi Belanja per Kapita (Kali/Bulan)</th>
                        <th class="py-3 px-3 text-right">Pertumbuhan IDBD (YoY)</th>
                        <th class="py-3 px-3 text-right">Porsi E-Commerce terhadap Pengeluaran RT (%)</th>
                        <th class="py-3 px-3 text-right">Nilai Transaksi Netto (Rp)</th>
                        <th class="py-3 px-3 text-right">Jumlah Transaksi</th>
                        <th class="py-3 px-3 text-right">Pertumbuhan Nilai Transaksi (YoY)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($paginatedProvinces as $index => $row)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-3 font-medium text-slate-500">
                                {{ ($paginatedProvinces->currentPage() - 1) * $paginatedProvinces->perPage() + $loop->iteration }}
                            </td>
                            <td class="py-3 px-3 font-bold text-slate-900 whitespace-nowrap">
                                {{ $row->provinsi }}
                            </td>
                            <td class="py-3 px-3 text-right font-bold text-blue-600">
                                {{ number_format($row->idbd, 1, ',', '.') }}
                            </td>
                            <td class="py-3 px-3 text-right font-medium text-slate-800">
                                {{ number_format($row->pengeluaran_per_kapita, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3 text-right font-medium text-slate-800">
                                {{ number_format($row->frekuensi_belanja, 1, ',', '.') }}
                            </td>
                            <td class="py-3 px-3 text-right font-bold {{ $row->pertumbuhan_idbd >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ number_format($row->pertumbuhan_idbd, 1, ',', '.') }}%
                            </td>
                            <td class="py-3 px-3 text-right font-medium text-slate-800">
                                {{ number_format($row->porsi_ecom, 1, ',', '.') }}%
                            </td>
                            <td class="py-3 px-3 text-right font-bold text-slate-900">
                                {{ number_format($row->netto, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3 text-right font-medium text-slate-800">
                                {{ number_format($row->transaksi, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-3 text-right font-bold text-emerald-600">
                                {{ number_format($row->pertumbuhan_trx, 1, ',', '.') }}%
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-8 text-center text-slate-400">
                                Tidak ada data yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Controls (Persis Sesuai Mockup) -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-slate-100 text-xs">
            <!-- Left Info -->
            <div class="text-slate-500 font-medium">
                Menampilkan {{ $paginatedProvinces->firstItem() ?? 1 }} - {{ $paginatedProvinces->lastItem() ?? count($paginatedProvinces) }} dari {{ $paginatedProvinces->total() }} provinsi
            </div>

            <!-- Center Pagination Buttons -->
            <div class="flex items-center space-x-1.5">
                {{-- Previous Page --}}
                @if ($paginatedProvinces->onFirstPage())
                    <span class="w-8 h-8 rounded-lg border border-slate-200 text-slate-300 flex items-center justify-center cursor-not-allowed">
                        &lt;
                    </span>
                @else
                    <a href="{{ $paginatedProvinces->previousPageUrl() }}" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-600 flex items-center justify-center transition-colors">
                        &lt;
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach ($paginatedProvinces->getUrlRange(1, $paginatedProvinces->lastPage()) as $pNumber => $pUrl)
                    @if ($pNumber <= 5 || $pNumber == $paginatedProvinces->lastPage() || abs($pNumber - $paginatedProvinces->currentPage()) <= 1)
                        @if ($pNumber == $paginatedProvinces->currentPage())
                            <span class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center shadow-xs">
                                {{ $pNumber }}
                            </span>
                        @else
                            <a href="{{ $pUrl }}" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium flex items-center justify-center transition-colors">
                                {{ $pNumber }}
                            </a>
                        @endif
                    @elseif ($pNumber == 6 && $paginatedProvinces->lastPage() > 6)
                        <span class="w-8 h-8 flex items-center justify-center text-slate-400">&hellip;</span>
                    @endif
                @endforeach

                {{-- Next Page --}}
                @if ($paginatedProvinces->hasMorePages())
                    <a href="{{ $paginatedProvinces->nextPageUrl() }}" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-600 flex items-center justify-center transition-colors">
                        &gt;
                    </a>
                @else
                    <span class="w-8 h-8 rounded-lg border border-slate-200 text-slate-300 flex items-center justify-center cursor-not-allowed">
                        &gt;
                    </span>
                @endif
            </div>

            <!-- Right: Per Page Selector -->
            <div class="flex items-center space-x-2 text-slate-600">
                <span>Tampilkan</span>
                <form method="GET" action="{{ route('dashboard.daya-beli') }}" class="inline">
                    <input type="hidden" name="periode" value="{{ $selectedPeriode }}">
                    <input type="hidden" name="provinsi" value="{{ $selectedProvinsi }}">
                    <input type="hidden" name="indikator" value="{{ $selectedIndikator }}">
                    <select name="per_page" onchange="this.form.submit()" class="border border-slate-200 rounded-lg px-2 py-1 bg-white text-slate-800 font-bold focus:outline-none focus:border-blue-500 text-xs cursor-pointer">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="38" {{ $perPage == 38 ? 'selected' : '' }}>38</option>
                    </select>
                </form>
                <span>per halaman</span>
            </div>
        </div>
    </div>

    <!-- 6. FOOTER NOTES (Persis Sesuai Mockup) -->
    <div class="pt-2 pb-6 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500 gap-2">
        <div>
            Sumber Data: Dataset E-Commerce (2024-2025) &amp; Statistik Pendapatan BPS
        </div>
        <div class="flex items-center gap-1.5">
            <span>&copy; 2025 Bank Indonesia &amp; BPS</span>
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Global Chart.js defaults
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';

    // 1. Chart 1: Indeks Daya Beli Digital (IDBD) Line Chart Bulanan
    const ctx1 = document.getElementById('chartIdbdMonthlyCanvas');
    if (ctx1) {
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: @json($chartIdbdMonthly['labels']),
                datasets: [{
                    label: 'IDBD',
                    data: @json($chartIdbdMonthly['data']),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.08)',
                    borderWidth: 2,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 1.5,
                    pointRadius: 3.5,
                    pointHoverRadius: 5,
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 8,
                            boxHeight: 8,
                            usePointStyle: true,
                            font: { size: 9, weight: 600 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) { return 'IDBD: ' + ctx.raw; }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9 } }
                    },
                    y: {
                        min: 80,
                        max: 160,
                        ticks: {
                            stepSize: 20,
                            font: { size: 9 }
                        },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }

    // 2. Chart 2: Rata-rata Pengeluaran per Kapita Line Chart Bulanan
    const ctx2 = document.getElementById('chartPengeluaranMonthlyCanvas');
    if (ctx2) {
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: @json($chartPengeluaranMonthly['labels']),
                datasets: [{
                    data: @json($chartPengeluaranMonthly['data']),
                    borderColor: '#2563eb',
                    borderWidth: 2,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 1.5,
                    pointRadius: 3.5,
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) { return 'Pengeluaran: ' + ctx.raw + ' Jt'; }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9 } }
                    },
                    y: {
                        min: 0,
                        max: 2.5,
                        ticks: {
                            stepSize: 0.5,
                            font: { size: 9 },
                            callback: function(val) {
                                if (val === 0) return '0';
                                if (val === 0.5) return '500K';
                                if (val === 1) return '1M';
                                if (val === 1.5) return '1,5M';
                                if (val === 2) return '2M';
                                if (val === 2.5) return '2,5M';
                                return val;
                            }
                        },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }

    // 3. Chart 3: Frekuensi Belanja per Kapita Line Chart Bulanan
    const ctx3 = document.getElementById('chartFrekuensiMonthlyCanvas');
    if (ctx3) {
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: @json($chartFrekuensiMonthly['labels']),
                datasets: [{
                    data: @json($chartFrekuensiMonthly['data']),
                    borderColor: '#2563eb',
                    borderWidth: 2,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 1.5,
                    pointRadius: 3.5,
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) { return 'Frekuensi: ' + ctx.raw + ' kali'; }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9 } }
                    },
                    y: {
                        min: 0,
                        max: 10,
                        ticks: {
                            stepSize: 2,
                            font: { size: 9 }
                        },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }

    // 4. Chart 4: Top 10 IDBD Antar Provinsi Horizontal Bar
    const ctx4 = document.getElementById('chartTop10IdbdCanvas');
    if (ctx4) {
        new Chart(ctx4, {
            type: 'bar',
            data: {
                labels: @json($chartTop10Idbd['labels']),
                datasets: [{
                    data: @json($chartTop10Idbd['data']),
                    backgroundColor: '#2563eb',
                    borderRadius: 4,
                    barThickness: 8
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
                            label: function(ctx) { return 'IDBD: ' + ctx.raw; }
                        }
                    }
                },
                scales: {
                    x: {
                        min: 0,
                        max: 200,
                        ticks: { stepSize: 50, font: { size: 8 } },
                        grid: { color: '#f1f5f9' },
                        title: {
                            display: true,
                            text: 'IDBD (Base 100)',
                            font: { size: 9, weight: 600 }
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 8, weight: 600 } }
                    }
                }
            }
        });
    }

    // 5. Chart 5: Rata-rata Pengeluaran berdasarkan Usia (Teal Column Bar)
    const ctx5 = document.getElementById('chartPengeluaranUsiaCanvas');
    if (ctx5) {
        new Chart(ctx5, {
            type: 'bar',
            data: {
                labels: @json($chartPengeluaranUsia['labels']),
                datasets: [{
                    data: @json($chartPengeluaranUsia['data']),
                    backgroundColor: '#0d9488',
                    borderRadius: 4,
                    barThickness: 22
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) { return 'Pengeluaran: ' + ctx.raw + ' M'; }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9, weight: 600 } }
                    },
                    y: {
                        min: 0,
                        max: 2.5,
                        ticks: {
                            stepSize: 0.5,
                            font: { size: 8 },
                            callback: function(val) {
                                if (val === 0) return '0';
                                if (val === 0.5) return '500 K';
                                if (val === 1) return '1 M';
                                if (val === 1.5) return '1,5 M';
                                if (val === 2) return '2 M';
                                if (val === 2.5) return '2,5 M';
                                return val;
                            }
                        },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }

    // 6. Chart 6: Kontribusi berdasarkan Pendapatan (Donut with Center Total)
    const ctx6 = document.getElementById('chartPendapatanDonutCanvas');
    if (ctx6) {
        const centerPlugin = {
            id: 'donutCenterText',
            beforeDraw: function(chart) {
                const width = chart.width;
                const height = chart.height;
                const ctx = chart.ctx;
                ctx.restore();
                
                ctx.font = "600 10px 'Plus Jakarta Sans'";
                ctx.textBaseline = "middle";
                ctx.textAlign = "center";
                ctx.fillStyle = "#64748b";
                ctx.fillText("Total", width / 2, height / 2 - 8);

                ctx.font = "bold 11px 'Plus Jakarta Sans'";
                ctx.fillStyle = "#0f172a";
                ctx.fillText("Rp 298,45 T", width / 2, height / 2 + 8);
                ctx.save();
            }
        };

        new Chart(ctx6, {
            type: 'doughnut',
            data: {
                labels: @json($chartPendapatanDonut['labels']),
                datasets: [{
                    data: @json($chartPendapatanDonut['data']),
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#94a3b8'],
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
                            label: function(ctx) { return ctx.label + ': ' + ctx.raw + '%'; }
                        }
                    }
                }
            },
            plugins: [centerPlugin]
        });
    }

    // 7. Chart 7: IDBD berdasarkan Metode Pembayaran (Purple Column Bar)
    const ctx7 = document.getElementById('chartMetodeIdbdCanvas');
    if (ctx7) {
        new Chart(ctx7, {
            type: 'bar',
            data: {
                labels: @json($chartMetodeIdbd['labels']),
                datasets: [{
                    data: @json($chartMetodeIdbd['data']),
                    backgroundColor: '#8b5cf6',
                    borderRadius: 4,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) { return 'IDBD: ' + ctx.raw; }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 9, weight: 600 } }
                    },
                    y: {
                        min: 0,
                        max: 160,
                        ticks: {
                            stepSize: 40,
                            font: { size: 8 }
                        },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }

    // 8. Chart 8: Pertumbuhan IDBD (YoY) Top 10 Horizontal Bar
    const ctx8 = document.getElementById('chartPertumbuhanYoYCanvas');
    if (ctx8) {
        const rawGrowthData = @json($chartPertumbuhanYoY['data']);
        const barColors = rawGrowthData.map(v => v >= 0 ? '#10b981' : '#ef4444');

        new Chart(ctx8, {
            type: 'bar',
            data: {
                labels: @json($chartPertumbuhanYoY['labels']),
                datasets: [{
                    data: rawGrowthData,
                    backgroundColor: barColors,
                    borderRadius: 4,
                    barThickness: 8
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
                            label: function(ctx) { return 'Pertumbuhan: ' + ctx.raw + '%'; }
                        }
                    }
                },
                scales: {
                    x: {
                        min: -10,
                        max: 25,
                        ticks: {
                            stepSize: 5,
                            font: { size: 8 },
                            callback: function(val) { return val + '%'; }
                        },
                        grid: { color: '#f1f5f9' }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 8, weight: 600 } }
                    }
                }
            }
        });
    }
});
</script>
@endpush
