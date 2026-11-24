@extends('layouts.public')

@section('title', 'Sumber Data - BI E-COMMERCE & BPS')

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
                <span class="sr-only">Data Explorer</span>
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
               class="py-2 text-slate-800 hover:text-blue-600 transition-colors whitespace-nowrap font-medium">
                Daya Beli BPS
            </a>
            <a href="{{ route('dashboard.explorer') }}" 
               class="relative py-2 text-blue-600 font-extrabold transition-colors whitespace-nowrap">
                Sumber Data
                <span class="absolute bottom-0 left-0 w-full h-[3px] bg-blue-600 rounded-full"></span>
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
            <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan halaman Sumber Data berhasil disalin!');" 
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

    <!-- 2. HEADER BANNER & 4 KPI METRIC CARDS (Persis Sesuai Gambar) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-3 items-stretch">
        
        <!-- Left: Sumber Data Explanation Card -->
        <div class="xl:col-span-5 bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/25">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 leading-tight">Sumber Data</h2>
                <p class="text-xs text-slate-600 leading-relaxed mt-1">
                    Halaman ini menyajikan informasi sumber data yang digunakan dalam analisis pola konsumsi dan daya beli digital di Indonesia. Semua data bersumber dari publikasi resmi BPS dan dataset e-commerce yang telah diolah.
                </p>
            </div>
        </div>

        <!-- Right: 4 KPI Metrics -->
        <div class="xl:col-span-7 grid grid-cols-2 sm:grid-cols-4 gap-3">
            
            <!-- Metric 1: Total Sumber Data -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] font-medium text-slate-500 leading-none">Total Sumber Data</div>
                    <div class="text-lg font-extrabold text-slate-900 leading-tight mt-0.5">{{ $metrics['total_sumber_data'] }}</div>
                    <div class="text-[10px] text-slate-400">Sumber data</div>
                </div>
            </div>

            <!-- Metric 2: Total Dataset -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] font-medium text-slate-500 leading-none">Total Dataset</div>
                    <div class="text-lg font-extrabold text-slate-900 leading-tight mt-0.5">{{ $metrics['total_dataset'] }}</div>
                    <div class="text-[10px] text-slate-400">Dataset</div>
                </div>
            </div>

            <!-- Metric 3: Periode Data -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] font-medium text-slate-500 leading-none">Periode Data</div>
                    <div class="text-sm sm:text-base font-extrabold text-slate-900 leading-tight mt-0.5 whitespace-nowrap">{{ $metrics['periode_data'] }}</div>
                    <div class="text-[10px] text-slate-400">{{ $metrics['periode_durasi'] }}</div>
                </div>
            </div>

            <!-- Metric 4: Kualitas Data -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-[10px] font-medium text-slate-500 leading-none">Kualitas Data</div>
                    <div class="text-lg font-extrabold text-slate-900 leading-tight mt-0.5">{{ $metrics['kualitas_data'] }}</div>
                    <div class="text-[10px] text-slate-400">{{ $metrics['kualitas_status'] }}</div>
                </div>
            </div>

        </div>

    </div>

    <!-- 3. FILTER & SEARCH CONTROLS (Persis Sesuai Gambar) -->
    <form method="GET" action="{{ route('dashboard.explorer') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
        
        <!-- Filter 1: Kategori Data -->
        <div class="lg:col-span-2 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center justify-between cursor-pointer">
            <div class="min-w-0">
                <div class="text-[10px] font-medium text-slate-500 leading-none">Kategori Data</div>
                <div class="text-xs font-bold text-slate-900 leading-tight mt-1 truncate">
                    {{ $selectedKategori === 'all' ? 'Semua Kategori' : $selectedKategori }}
                </div>
            </div>
            <select name="kategori" onchange="this.form.submit()" class="absolute inset-0 opacity-0 cursor-pointer">
                <option value="all" {{ $selectedKategori == 'all' ? 'selected' : '' }}>Semua Kategori</option>
                <option value="E-Commerce & Transaksi" {{ $selectedKategori == 'E-Commerce & Transaksi' ? 'selected' : '' }}>E-Commerce &amp; Transaksi</option>
                <option value="Sosial Ekonomi" {{ $selectedKategori == 'Sosial Ekonomi' ? 'selected' : '' }}>Sosial Ekonomi</option>
                <option value="Harga & Inflasi" {{ $selectedKategori == 'Harga & Inflasi' ? 'selected' : '' }}>Harga &amp; Inflasi</option>
                <option value="Pembayaran Digital" {{ $selectedKategori == 'Pembayaran Digital' ? 'selected' : '' }}>Pembayaran Digital</option>
            </select>
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <!-- Filter 2: Instansi Penyedia -->
        <div class="lg:col-span-2 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center justify-between cursor-pointer">
            <div class="min-w-0">
                <div class="text-[10px] font-medium text-slate-500 leading-none">Instansi Penyedia</div>
                <div class="text-xs font-bold text-slate-900 leading-tight mt-1 truncate">
                    {{ $selectedInstansi === 'all' ? 'Semua Instansi' : $selectedInstansi }}
                </div>
            </div>
            <select name="instansi" onchange="this.form.submit()" class="absolute inset-0 opacity-0 cursor-pointer">
                <option value="all" {{ $selectedInstansi == 'all' ? 'selected' : '' }}>Semua Instansi</option>
                <option value="BPS" {{ $selectedInstansi == 'BPS' ? 'selected' : '' }}>BPS</option>
                <option value="Bank Indonesia" {{ $selectedInstansi == 'Bank Indonesia' ? 'selected' : '' }}>Bank Indonesia</option>
            </select>
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <!-- Filter 3: Periode Data -->
        <div class="lg:col-span-2 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center justify-between cursor-pointer">
            <div class="min-w-0">
                <div class="text-[10px] font-medium text-slate-500 leading-none">Periode Data</div>
                <div class="text-xs font-bold text-slate-900 leading-tight mt-1 truncate">
                    {{ $selectedPeriode === 'all' ? 'Semua Periode' : $selectedPeriode }}
                </div>
            </div>
            <select name="periode" onchange="this.form.submit()" class="absolute inset-0 opacity-0 cursor-pointer">
                <option value="all" {{ $selectedPeriode == 'all' ? 'selected' : '' }}>Semua Periode</option>
                <option value="2019 - 2024" {{ $selectedPeriode == '2019 - 2024' ? 'selected' : '' }}>2019 - 2024</option>
                <option value="2024 - 2025" {{ $selectedPeriode == '2024 - 2025' ? 'selected' : '' }}>2024 - 2025</option>
            </select>
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <!-- Filter 4: Format Data -->
        <div class="lg:col-span-2 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center justify-between cursor-pointer">
            <div class="min-w-0">
                <div class="text-[10px] font-medium text-slate-500 leading-none">Format Data</div>
                <div class="text-xs font-bold text-slate-900 leading-tight mt-1 truncate">
                    {{ $selectedFormat === 'all' ? 'Semua Format' : $selectedFormat }}
                </div>
            </div>
            <select name="format" onchange="this.form.submit()" class="absolute inset-0 opacity-0 cursor-pointer">
                <option value="all" {{ $selectedFormat == 'all' ? 'selected' : '' }}>Semua Format</option>
                <option value="CSV" {{ $selectedFormat == 'CSV' ? 'selected' : '' }}>CSV</option>
                <option value="JSON" {{ $selectedFormat == 'JSON' ? 'selected' : '' }}>JSON</option>
                <option value="XLSX" {{ $selectedFormat == 'XLSX' ? 'selected' : '' }}>XLSX</option>
            </select>
            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        <!-- Search Bar -->
        <div class="lg:col-span-4 relative bg-white rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari sumber data atau dataset..." class="w-full bg-transparent text-xs text-slate-900 focus:outline-none placeholder:text-slate-400">
            <button type="submit" class="text-slate-400 hover:text-blue-600 transition-colors shrink-0 ml-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </div>

    </form>

    <!-- 4. MAIN CONTENT (Tabel Daftar Sumber Data di Kiri & Sidebar Ringkasan di Kanan) -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-3.5 items-start">
        
        <!-- KOLOM KIRI: Daftar Sumber Data Table (approx. 72% width) -->
        <div class="xl:col-span-8 bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-5 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Daftar Sumber Data</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50/80 text-[11px] font-bold text-slate-600 border-y border-slate-200/80">
                        <tr>
                            <th class="py-3 px-3 w-10">No</th>
                            <th class="py-3 px-3">Sumber Data</th>
                            <th class="py-3 px-3">Instansi Penyedia</th>
                            <th class="py-3 px-3">Deskripsi</th>
                            <th class="py-3 px-3">Periode</th>
                            <th class="py-3 px-3 text-center">Dataset</th>
                            <th class="py-3 px-3 text-center">Format</th>
                            <th class="py-3 px-3">Terakhir Diperbarui</th>
                            <th class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($paginatedSources as $index => $source)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3.5 px-3 font-medium text-slate-500">
                                    {{ ($paginatedSources->currentPage() - 1) * $paginatedSources->perPage() + $loop->iteration }}
                                </td>
                                <td class="py-3.5 px-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-xl {{ $source['icon_bg'] }} text-white flex items-center justify-center shrink-0 shadow-2xs">
                                            @if($source['icon_type'] === 'cart')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            @elseif($source['icon_type'] === 'users' || $source['icon_type'] === 'crowd')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                            @elseif($source['icon_type'] === 'building')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            @elseif($source['icon_type'] === 'wifi')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                                            @elseif($source['icon_type'] === 'card')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                            @elseif($source['icon_type'] === 'truck')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                            @elseif($source['icon_type'] === 'store')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-900 leading-snug">{{ $source['nama'] }}</div>
                                            <div class="text-[10px] text-slate-500 leading-tight mt-0.5 truncate">{{ $source['sub_nama'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-3 font-medium text-slate-800 whitespace-nowrap">
                                    {{ $source['instansi'] }}
                                </td>
                                <td class="py-3.5 px-3 text-slate-600 max-w-xs leading-relaxed text-[11px]">
                                    {{ $source['deskripsi'] }}
                                </td>
                                <td class="py-3.5 px-3 font-medium text-slate-800 whitespace-nowrap">
                                    {{ $source['periode'] }}
                                </td>
                                <td class="py-3.5 px-3 text-center font-bold text-slate-900">
                                    {{ $source['dataset_count'] }}
                                </td>
                                <td class="py-3.5 px-3 text-center">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                        {{ $source['format'] }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 font-medium text-slate-600 whitespace-nowrap">
                                    {{ $source['terakhir_diperbarui'] }}
                                </td>
                                <td class="py-3.5 px-3 text-center whitespace-nowrap">
                                    <button type="button" 
                                            onclick="openDetailModal({{ json_encode($source) }})" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg border border-slate-200 hover:border-blue-400 bg-white hover:bg-blue-50 text-blue-600 text-[11px] font-semibold transition-colors cursor-pointer shadow-2xs">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Detail</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-slate-400">
                                    Tidak ada sumber data yang sesuai dengan pencarian atau filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Pagination Controls -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-slate-100 text-xs">
                <div class="text-slate-500 font-medium">
                    Menampilkan {{ $paginatedSources->firstItem() ?? 1 }} - {{ $paginatedSources->lastItem() ?? count($paginatedSources) }} dari {{ $paginatedSources->total() }} sumber data
                </div>

                <div class="flex items-center space-x-1.5">
                    @if ($paginatedSources->onFirstPage())
                        <span class="w-8 h-8 rounded-lg border border-slate-200 text-slate-300 flex items-center justify-center cursor-not-allowed">&lt;</span>
                    @else
                        <a href="{{ $paginatedSources->previousPageUrl() }}" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-600 flex items-center justify-center transition-colors">&lt;</a>
                    @endif

                    @foreach ($paginatedSources->getUrlRange(1, $paginatedSources->lastPage()) as $pNumber => $pUrl)
                        @if ($pNumber == $paginatedSources->currentPage())
                            <span class="w-8 h-8 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center shadow-xs">{{ $pNumber }}</span>
                        @else
                            <a href="{{ $pUrl }}" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium flex items-center justify-center transition-colors">{{ $pNumber }}</a>
                        @endif
                    @endforeach

                    @if ($paginatedSources->hasMorePages())
                        <a href="{{ $paginatedSources->nextPageUrl() }}" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-600 flex items-center justify-center transition-colors">&gt;</a>
                    @else
                        <span class="w-8 h-8 rounded-lg border border-slate-200 text-slate-300 flex items-center justify-center cursor-not-allowed">&gt;</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Sidebar Cards (Ringkasan, Kualitas, Metadata) (approx. 28% width) -->
        <div class="xl:col-span-4 space-y-3.5">
            
            <!-- Card 1: Ringkasan Sumber Data (Donut Chart) -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 space-y-3">
                <h3 class="text-xs font-bold text-slate-900 tracking-tight">Ringkasan Sumber Data</h3>
                
                <div class="flex items-center gap-2">
                    <div class="w-36 h-36 relative shrink-0 flex items-center justify-center">
                        <canvas id="donutSummaryCanvas"></canvas>
                    </div>
                    <div class="space-y-1.5 text-[10px] flex-1">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-1.5 text-slate-600">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-500 shrink-0"></span>
                                E-Commerce &amp; Transaksi
                            </span>
                            <span class="font-bold text-slate-900">8 (66,7%)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-1.5 text-slate-600">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                                Sosial Ekonomi
                            </span>
                            <span class="font-bold text-slate-900">2 (16,7%)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-1.5 text-slate-600">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shrink-0"></span>
                                Harga &amp; Inflasi
                            </span>
                            <span class="font-bold text-slate-900">1 (8,3%)</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-1.5 text-slate-600">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shrink-0"></span>
                                Pembayaran Digital
                            </span>
                            <span class="font-bold text-slate-900">1 (8,3%)</span>
                        </div>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 text-center">
                    <a href="{{ route('dashboard.metodologi') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors inline-flex items-center gap-1">
                        <span>Lihat Detail Ringkasan</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- Card 2: Kualitas & Ketersediaan Data (2x2 Grid) -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 space-y-3">
                <h3 class="text-xs font-bold text-slate-900 tracking-tight">Kualitas &amp; Ketersediaan Data</h3>
                
                <div class="grid grid-cols-2 gap-2.5">
                    <!-- Metric 1 -->
                    <div class="bg-slate-50/70 border border-slate-100 rounded-xl p-3 flex flex-col justify-between">
                        <div class="flex items-center space-x-2 mb-1.5">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            <span class="text-[10px] text-slate-600 leading-tight">Kelengkapan Data</span>
                        </div>
                        <div class="text-base font-extrabold text-slate-900">98,4%</div>
                        <div class="text-[10px] font-semibold text-emerald-600 mt-0.5">Sangat Baik</div>
                    </div>

                    <!-- Metric 2 -->
                    <div class="bg-slate-50/70 border border-slate-100 rounded-xl p-3 flex flex-col justify-between">
                        <div class="flex items-center space-x-2 mb-1.5">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <span class="text-[10px] text-slate-600 leading-tight">Konsistensi Data</span>
                        </div>
                        <div class="text-base font-extrabold text-slate-900">97,6%</div>
                        <div class="text-[10px] font-semibold text-emerald-600 mt-0.5">Sangat Baik</div>
                    </div>

                    <!-- Metric 3 -->
                    <div class="bg-slate-50/70 border border-slate-100 rounded-xl p-3 flex flex-col justify-between">
                        <div class="flex items-center space-x-2 mb-1.5">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="text-[10px] text-slate-600 leading-tight">Ketepatan Waktu</span>
                        </div>
                        <div class="text-base font-extrabold text-slate-900">100%</div>
                        <div class="text-[10px] font-semibold text-emerald-600 mt-0.5">Sangat Baik</div>
                    </div>

                    <!-- Metric 4 -->
                    <div class="bg-slate-50/70 border border-slate-100 rounded-xl p-3 flex flex-col justify-between">
                        <div class="flex items-center space-x-2 mb-1.5">
                            <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <span class="text-[10px] text-slate-600 leading-tight">Validitas Data</span>
                        </div>
                        <div class="text-base font-extrabold text-slate-900">99,1%</div>
                        <div class="text-[10px] font-semibold text-emerald-600 mt-0.5">Sangat Baik</div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Dokumentasi & Metadata -->
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs p-4 space-y-2.5">
                <h3 class="text-xs font-bold text-slate-900 tracking-tight">Dokumentasi &amp; Metadata</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Unduh dokumentasi lengkap sumber data dan metadata untuk kebutuhan analisis.
                </p>
                <a href="{{ route('laporan.index') }}" class="w-full py-2 px-3 rounded-xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-xs font-bold text-slate-800 flex items-center justify-center gap-2 transition-colors shadow-2xs cursor-pointer">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Dokumentasi</span>
                </a>
            </div>

        </div>

    </div>

    <!-- 5. DETAIL MODAL (Interaktif saat klik tombol Detail di tabel) -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full border border-slate-100 shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/70">
                <div class="flex items-center space-x-3">
                    <div id="modalIcon" class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold">
                        D
                    </div>
                    <div>
                        <h4 id="modalTitle" class="text-base font-extrabold text-slate-900 leading-tight">Detail Sumber Data</h4>
                        <p id="modalProvider" class="text-xs text-slate-500 font-medium"></p>
                    </div>
                </div>
                <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-full bg-white hover:bg-slate-100 border border-slate-200 text-slate-500 flex items-center justify-center text-sm font-bold transition-colors">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto text-xs text-slate-700">
                <div>
                    <h5 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi Lengkap</h5>
                    <p id="modalDesc" class="leading-relaxed text-slate-800 font-medium"></p>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-[10px] text-slate-500">Tabel Basis Data Asli:</span>
                        <div id="modalTable" class="font-mono font-bold text-blue-600 mt-0.5"></div>
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="text-[10px] text-slate-500">Volume &amp; Ukuran Riil:</span>
                        <div id="modalRecords" class="font-bold text-slate-900 mt-0.5"></div>
                    </div>
                </div>

                <div>
                    <span class="text-[10px] text-slate-500">Cakupan Wilayah &amp; Subjek:</span>
                    <div id="modalCoverage" class="font-medium text-slate-800 mt-0.5"></div>
                </div>

                <!-- Preview 5 Real DB Records -->
                <div class="pt-2 border-t border-slate-100">
                    <h5 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Sampel Data Riil Terkini dari Database</h5>
                    <div class="overflow-x-auto rounded-xl border border-slate-200 max-h-40">
                        <table class="w-full text-left text-[11px]">
                            <thead class="bg-slate-100 text-slate-600 font-bold">
                                <tr>
                                    <th class="py-1.5 px-2.5">Order ID</th>
                                    <th class="py-1.5 px-2.5">Kategori</th>
                                    <th class="py-1.5 px-2.5">Provinsi</th>
                                    <th class="py-1.5 px-2.5 text-right">Netto (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 font-mono text-[10px]">
                                @foreach($sampleTransactions->take(5) as $sample)
                                    <tr>
                                        <td class="py-1.5 px-2.5 font-bold text-blue-600">{{ $sample->order_id }}</td>
                                        <td class="py-1.5 px-2.5 font-sans">{{ $sample->kategori_produk }}</td>
                                        <td class="py-1.5 px-2.5 font-sans">{{ $sample->provinsi }}</td>
                                        <td class="py-1.5 px-2.5 text-right font-bold text-slate-900">{{ number_format($sample->nilai_transaksi_netto_idr, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                <span class="text-[11px] text-slate-500">Format ketersediaan: <strong>CSV, JSON, SQL Warehouse</strong></span>
                <button type="button" onclick="closeDetailModal()" class="px-4 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- 6. FOOTER NOTES (Persis Sesuai Mockup) -->
    <div class="pt-2 pb-6 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500 gap-2">
        <div>
            Sumber Data: BPS, Bank Indonesia, dan Dataset E-Commerce (2019-2024)
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

    // Donut Summary Chart with Center Text
    const ctx = document.getElementById('donutSummaryCanvas');
    if (ctx) {
        const centerPlugin = {
            id: 'donutCenterSourcesText',
            beforeDraw: function(chart) {
                const width = chart.width;
                const height = chart.height;
                const ctx = chart.ctx;
                ctx.restore();
                
                ctx.font = "bold 16px 'Plus Jakarta Sans'";
                ctx.textBaseline = "middle";
                ctx.textAlign = "center";
                ctx.fillStyle = "#0f172a";
                ctx.fillText("12", width / 2, height / 2 - 7);

                ctx.font = "600 9px 'Plus Jakarta Sans'";
                ctx.fillStyle = "#64748b";
                ctx.fillText("Sumber Data", width / 2, height / 2 + 9);
                ctx.save();
            }
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($donutSummary['labels']),
                datasets: [{
                    data: @json($donutSummary['counts']),
                    backgroundColor: @json($donutSummary['colors']),
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
                            label: function(ctx) { 
                                const label = ctx.label || '';
                                const val = ctx.raw || 0;
                                return label + ': ' + val + ' sumber data'; 
                            }
                        }
                    }
                }
            },
            plugins: [centerPlugin]
        });
    }
});

// Interactive Detail Modal Functions
function openDetailModal(source) {
    document.getElementById('modalTitle').textContent = source.nama;
    document.getElementById('modalProvider').textContent = source.instansi + ' • ' + source.periode;
    document.getElementById('modalDesc').textContent = source.deskripsi;
    document.getElementById('modalTable').textContent = source.table_name;
    document.getElementById('modalRecords').textContent = source.total_records;
    document.getElementById('modalCoverage').textContent = source.cakupan;
    document.getElementById('detailModal').classList.remove('hidden');
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
}
</script>
@endpush
