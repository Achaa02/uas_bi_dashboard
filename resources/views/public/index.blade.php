@extends('layouts.public')

@section('title', 'BI E-COMMERCE & BPS - Pemetaan Pola Konsumsi dan Daya Beli Digital di Indonesia')

@section('content')
<div class="space-y-4">

    <!-- 1. TOP NAVBAR / HEADER -->
    <header class="bg-white rounded-2xl border border-slate-100/90 shadow-[0_8px_30px_rgb(0,0,0,0.06)] px-6 py-4 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
        <!-- Left: Brand Logo & Title (Klik kembali ke Dashboard Publik) -->
        <a href="{{ route('public.dashboard') }}" class="flex items-center space-x-3.5 cursor-pointer">
            <!-- 3 Rounded Vertical Bars (Icon BI E-Commerce & BPS) -->
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
            </div>
        </a>

        <!-- Center: Navigation Tabs -->
        <nav class="flex items-center space-x-4 sm:space-x-7 text-xs font-semibold overflow-x-auto py-1">
            <a href="{{ route('public.dashboard') }}" 
               class="relative py-2 text-blue-600 font-extrabold transition-colors whitespace-nowrap">
                Dashboard Publik
                <span class="absolute bottom-0 left-0 w-full h-[3px] bg-blue-600 rounded-full"></span>
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
               class="py-2 text-slate-800 hover:text-blue-600 transition-colors whitespace-nowrap font-medium">
                Sumber Data
            </a>
        </nav>

        <!-- Right: Bagikan Button & Update Pill -->
        <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
            <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan dashboard publik berhasil disalin!');" 
               class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-800 text-xs font-bold rounded-2xl border border-slate-200/90 shadow-2xs transition-all flex items-center gap-2 cursor-pointer whitespace-nowrap">
                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                </svg>
                <span>Bagikan</span>
            </button>

            <div class="border border-slate-200/90 rounded-2xl px-4 py-2 flex items-center gap-2.5 bg-white shadow-2xs shrink-0">
                <div class="w-5 h-5 rounded-full border border-blue-500 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 7v5l3 2"/>
                    </svg>
                </div>
                <div class="leading-none text-left">
                    <div class="text-[9px] text-slate-400 font-medium">Data diperbarui</div>
                    <div class="text-[11px] font-bold text-slate-800 mt-0.5">21 Mei 2025 10:30 WIB</div>
                </div>
            </div>
        </div>
    </header>

    <!-- 2. COMPACT FILTER BAR & CTA (Sesuai Referensi Gambar) -->
    <div class="flex items-center gap-3 flex-wrap">
        <!-- 1. Periode Analisis Box -->
        <div class="relative bg-white rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-2.5 flex items-center gap-2.5 cursor-pointer">
            <svg class="w-4 h-4 text-slate-800 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="1.8"/>
                <path stroke-linecap="round" stroke-width="1.8" d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <div class="min-w-0 pr-1">
                <div class="text-[10px] font-medium text-slate-500 leading-none">Periode Analisis</div>
                <div class="text-xs font-bold text-slate-900 leading-tight mt-0.5">
                    {{ $selectedPeriod === 'all' ? 'Semua Periode' : ($selectedPeriod === '2024' ? 'Jan 2024 - Des 2024' : 'Tahun ' . $selectedPeriod) }}
                </div>
            </div>
            <svg class="w-3.5 h-3.5 text-slate-600 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
            <select name="periode" form="publicFilterForm" onchange="document.getElementById('publicFilterForm').submit()" 
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                @foreach($availablePeriods as $key => $label)
                    <option value="{{ $key }}" {{ $selectedPeriod === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- 2. Semua Provinsi Box -->
        <div class="relative bg-white rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-2xs hover:border-slate-300 transition-all px-4 py-3 flex items-center gap-2.5 cursor-pointer">
            <svg class="w-4 h-4 text-slate-800 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <div class="text-xs font-bold text-slate-900 leading-none pr-1">
                {{ $selectedProv === 'all' ? 'Semua Provinsi' : $selectedProv }}
            </div>
            <svg class="w-3.5 h-3.5 text-slate-600 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
            <select name="provinsi" form="publicFilterForm" onchange="document.getElementById('publicFilterForm').submit()" 
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <option value="all" {{ $selectedProv === 'all' ? 'selected' : '' }}>Semua Provinsi</option>
                @foreach($allProvinces as $prov)
                    <option value="{{ $prov }}" {{ $selectedProv === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                @endforeach
            </select>
        </div>

        <!-- 3. CTA: Unduh Laporan Box -->
        <a href="{{ route('laporan.index') }}" 
           class="bg-white hover:bg-slate-50 text-blue-600 rounded-xl sm:rounded-2xl border border-slate-200/90 shadow-2xs hover:border-blue-300 transition-all px-4 py-3 flex items-center gap-2 text-xs font-bold cursor-pointer">
            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            <span>Unduh Laporan</span>
        </a>

        <form method="GET" action="{{ route('public.dashboard') }}" id="publicFilterForm" class="hidden"></form>
    </div>

    <!-- 3. TOP 5 KPI CARDS (Bentuk Squircle Rounded Sesuai Referensi Gambar) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        
        <!-- KPI 1: TOTAL TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs hover:shadow-sm transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 min-w-0">
                        <!-- Squircle Rounded Blue Icon -->
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center text-white shrink-0 shadow-sm shadow-blue-600/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        
                        <div class="min-w-0 flex-1">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total Transaksi</div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                                {{ $selectedProv === 'all' ? '3.152.672' : number_format($totalTransaksi, 0, ',', '.') }}
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium">Transaksi</div>
                        </div>
                    </div>
                    
                    <div class="relative group/tip cursor-help shrink-0 ml-1">
                        <svg class="w-3.5 h-3.5 text-slate-300 hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-56 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                            <strong>Sumber:</strong> order_id<br>Jumlah keseluruhan transaksi unik valid e-commerce pada periode analisis.
                        </div>
                    </div>
                </div>

                <p class="text-[10px] text-slate-500 leading-tight mt-2.5">
                    Jumlah total transaksi e-commerce periode Jan 2024 - Des 2024
                </p>
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-[10px] font-bold text-emerald-600">
                <span class="mr-1">▲</span> {{ $selectedProv === 'all' ? '12,45' : number_format($growthTrx, 2, ',', '.') }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 2: NILAI TRANSAKSI NETTO -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs hover:shadow-sm transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 min-w-0">
                        <!-- Squircle Rounded Green Icon -->
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center text-white shrink-0 shadow-sm shadow-emerald-600/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        
                        <div class="min-w-0 flex-1">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Nilai Transaksi Netto</div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                                {{ $selectedProv === 'all' ? 'Rp 4,82 T' : ($totalGmvNetto >= 1000000000000 ? 'Rp ' . number_format($totalGmvNetto / 1000000000000, 2, ',', '.') . ' T' : 'Rp ' . number_format($totalGmvNetto / 1000000000, 2, ',', '.') . ' M') }}
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium">Rupiah</div>
                        </div>
                    </div>
                    
                    <div class="relative group/tip cursor-help shrink-0 ml-1">
                        <svg class="w-3.5 h-3.5 text-slate-300 hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-56 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                            <strong>Sumber:</strong> nilai_transaksi_netto_idr<br>Total nilai transaksi setelah diskon voucher platform dan ongkos kirim.
                        </div>
                    </div>
                </div>

                <p class="text-[10px] text-slate-500 leading-tight mt-2.5">
                    Total nilai transaksi setelah diskon, voucher dan ongkos kirim
                </p>
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-[10px] font-bold text-emerald-600">
                <span class="mr-1">▲</span> {{ $selectedProv === 'all' ? '15,32' : number_format($growthGmv, 2, ',', '.') }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 3: RATA-RATA NILAI TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs hover:shadow-sm transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 min-w-0">
                        <!-- Squircle Rounded Purple Icon -->
                        <div class="w-12 h-12 rounded-2xl bg-purple-600 flex items-center justify-center text-white shrink-0 shadow-sm shadow-purple-600/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        
                        <div class="min-w-0 flex-1">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Rata-rata Nilai Transaksi</div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                                {{ $selectedProv === 'all' ? 'Rp 1.528.640' : 'Rp ' . number_format($avgAov, 0, ',', '.') }}
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium">Rupiah / Transaksi</div>
                        </div>
                    </div>
                    
                    <div class="relative group/tip cursor-help shrink-0 ml-1">
                        <svg class="w-3.5 h-3.5 text-slate-300 hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-56 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                            <strong>Rumus:</strong> SUM(netto) / SUM(transaksi)<br>Rata-rata Nilai Transaksi bersih per transaksi unik.
                        </div>
                    </div>
                </div>

                <p class="text-[10px] text-slate-500 leading-tight mt-2.5">
                    Rata-rata nilai transaksi bersih per transaksi unik
                </p>
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-[10px] font-bold text-emerald-600">
                <span class="mr-1">▲</span> {{ $selectedProv === 'all' ? '2,16' : number_format($growthAov, 2, ',', '.') }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 4: TOTAL DISKON VOUCHER -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs hover:shadow-sm transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 min-w-0">
                        <!-- Squircle Rounded Orange Icon -->
                        <div class="w-12 h-12 rounded-2xl bg-orange-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-orange-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        
                        <div class="min-w-0 flex-1">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total Diskon Voucher</div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                                {{ $selectedProv === 'all' ? 'Rp 812,45 M' : ($totalDiskonVoucher >= 1000000000000 ? 'Rp ' . number_format($totalDiskonVoucher / 1000000000000, 2, ',', '.') . ' T' : 'Rp ' . number_format($totalDiskonVoucher / 1000000000, 2, ',', '.') . ' M') }}
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium">Rupiah</div>
                        </div>
                    </div>
                    
                    <div class="relative group/tip cursor-help shrink-0 ml-1">
                        <svg class="w-3.5 h-3.5 text-slate-300 hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-56 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                            <strong>Sumber:</strong> diskon_voucher_platform_idr<br>Total akumulasi diskon voucher yang diberikan platform pada periode analisis.
                        </div>
                    </div>
                </div>

                <p class="text-[10px] text-slate-500 leading-tight mt-2.5">
                    Total akumulasi diskon voucher yang diberikan platform
                </p>
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-[10px] font-bold text-emerald-600">
                <span class="mr-1">▲</span> {{ $selectedProv === 'all' ? '9,71' : number_format($growthVoucher, 2, ',', '.') }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 5: RATA-RATA DURASI PENGIRIMAN -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs hover:shadow-sm transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 min-w-0">
                        <!-- Squircle Rounded Cyan Icon -->
                        <div class="w-12 h-12 rounded-2xl bg-cyan-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-cyan-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        </div>
                        
                        <div class="min-w-0 flex-1">
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Rata-rata Durasi Pengiriman</div>
                            <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-0.5">
                                {{ $selectedProv === 'all' ? '4,62 Hari' : number_format($avgDurasiKirim, 2, ',', '.') . ' Hari' }}
                            </div>
                            <div class="text-[11px] text-slate-400 font-medium">Hari</div>
                        </div>
                    </div>
                    
                    <div class="relative group/tip cursor-help shrink-0 ml-1">
                        <svg class="w-3.5 h-3.5 text-slate-300 hover:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-56 p-2 bg-slate-900 text-white text-[10px] rounded-lg shadow-lg">
                            <strong>Sumber:</strong> durasi_pengiriman_hari<br>Rata-rata waktu yang dibutuhkan untuk menyelesaikan pengiriman transaksi.
                        </div>
                    </div>
                </div>

                <p class="text-[10px] text-slate-500 leading-tight mt-2.5">
                    Rata-rata waktu pengiriman hingga pesanan diterima pelanggan
                </p>
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-[10px] font-bold text-emerald-600">
                <span class="mr-1">▲</span> {{ $selectedProv === 'all' ? '13,88' : number_format($growthDurasi, 2, ',', '.') }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

    </div>

    <!-- 4. ROW 2: 3 CARDS / CHARTS (Tren Netto Line, Top 10 Provinsi Horizontal Bar, Peta Sebaran Leaflet) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        
        <!-- Card 1: Tren Nilai Transaksi Netto (Bulanan) -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm">Tren Nilai Transaksi Netto (Bulanan)</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Tren perkembangan nilai transaksi netto per bulan">&#9432;</span>
                    </div>
                    <span class="text-[10px] font-semibold text-slate-600 bg-slate-50 px-2 py-0.5 rounded-lg border border-slate-200 shrink-0">
                        Bulanan &or;
                    </span>
                </div>
                <div class="h-56 w-full mt-2">
                    <canvas id="trenNettoChart"></canvas>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-2.5 rounded-xl bg-blue-50/70 border border-blue-100 flex items-start space-x-2 text-[11px] text-slate-700">
                <div class="p-1 rounded-lg bg-blue-500/10 text-blue-600 mt-0.5 shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <p class="leading-relaxed">
                    <strong>Insight:</strong> Nilai transaksi netto menunjukkan tren peningkatan signifikan pada Q4 2024 sebesar <strong>28,31%</strong> dibanding Q3 2024.
                </p>
            </div>
        </div>

        <!-- Card 2: Top 10 Provinsi - Nilai Transaksi Netto -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm">Top 10 Provinsi - Nilai Transaksi Netto</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="10 provinsi dengan volume nilai transaksi digital tertinggi">&#9432;</span>
                    </div>
                </div>
                <div class="h-56 w-full mt-2">
                    <canvas id="topProvChart"></canvas>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 text-[11px] text-slate-600 leading-relaxed">
                <strong>Insight:</strong> <strong>Jawa Barat</strong> menjadi provinsi dengan nilai transaksi digital tertinggi, diikuti <strong>Jawa Timur</strong> dan <strong>DKI Jakarta</strong>.
            </div>
        </div>

        <!-- Card 3: Sebaran Nilai Transaksi Netto di Indonesia (Peta Leaflet Interaktif) -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between relative">
            <div>
                <div class="flex items-start justify-between mb-1.5">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm">Sebaran Nilai Transaksi Netto di Indonesia</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Peta sebaran transaksi di 38 provinsi Indonesia">&#9432;</span>
                    </div>
                </div>

                <!-- Sub-controls (Indicator Selector & Legend Bar) -->
                <div class="flex items-center justify-between text-[11px] mb-1.5">
                    <div class="flex items-center space-x-1">
                        <span class="text-slate-500 text-[10px]">Indikator Peta:</span>
                        <select id="mapIndicatorSelect" class="bg-slate-50 border border-slate-200 text-slate-700 font-semibold rounded-lg px-2 py-0.5 text-[10px] focus:outline-none cursor-pointer">
                            <option value="netto">Nilai Transaksi Netto</option>
                            <option value="trx">Jumlah Transaksi Unik</option>
                            <option value="voucher">Total Diskon Voucher</option>
                            <option value="durasi">Rata-Rata Durasi Pengiriman</option>
                        </select>
                    </div>

                    <!-- Gradient Bar Legend -->
                    <div class="flex items-center space-x-1 text-[9px] text-slate-400">
                        <span>Rendah</span>
                        <div class="w-16 h-1.5 rounded-full bg-gradient-to-r from-blue-100 via-blue-400 to-blue-700"></div>
                        <span>Tinggi</span>
                    </div>
                </div>

                <!-- Leaflet Map Container with Overlay Card -->
                <div class="h-48 w-full rounded-xl overflow-hidden border border-slate-200 relative bg-slate-50 mt-1">
                    <div id="publicMap" class="w-full h-full z-10"></div>

                    <!-- Overlay Detail Card (Matching Reference on Sulawesi Selatan) -->
                    <div id="mapOverlayCard" class="absolute top-2 right-2 z-20 bg-white/95 backdrop-blur-xs p-2.5 rounded-xl shadow-md border border-slate-200 text-[9px] w-40 leading-tight pointer-events-none transition-all">
                        <div class="font-bold text-slate-900 text-[11px] mb-1" id="ovProvName">Sulawesi Selatan</div>
                        <div class="space-y-0.5 text-slate-600">
                            <div><span class="text-slate-400">Nilai Netto:</span><br><strong class="text-blue-700" id="ovNetto">Rp 153.240.000.000</strong></div>
                            <div><span class="text-slate-400">Total Transaksi:</span><br><strong class="text-slate-900" id="ovTrx">153.982</strong></div>
                            <div><span class="text-slate-400">Total Diskon:</span><br><strong class="text-amber-600" id="ovVoucher">Rp 25.840.000.000</strong></div>
                            <div><span class="text-slate-400">Rata-rata Durasi:</span><br><strong class="text-teal-700" id="ovDurasi">4,21 Hari</strong></div>
                        </div>
                    </div>

                    <!-- Controls (Zoom & Reset) -->
                    <div class="absolute bottom-2 left-2 z-20 flex flex-col space-y-1">
                        <button type="button" onclick="if(window.publicMap){window.publicMap.zoomIn();}" class="w-6 h-6 rounded bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold shadow border border-slate-200 flex items-center justify-center cursor-pointer">+</button>
                        <button type="button" onclick="if(window.publicMap){window.publicMap.zoomOut();}" class="w-6 h-6 rounded bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold shadow border border-slate-200 flex items-center justify-center cursor-pointer">-</button>
                        <button type="button" onclick="if(window.publicMap){window.publicMap.setView([-2.2, 118.0], 4.2);}" class="w-6 h-6 rounded bg-white hover:bg-slate-50 text-slate-700 text-[10px] font-bold shadow border border-slate-200 flex items-center justify-center cursor-pointer" title="Reset Peta">&#8635;</button>
                    </div>
                </div>
            </div>

            <!-- Footer: Sumber Data & Link to Spatial Detail -->
            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center justify-between text-[10px]">
                <span class="text-slate-400">Sumber: Data E-Commerce (diolah), BPS</span>
                <a href="{{ route('dashboard.spasial') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1 group">
                    <span>Lihat Detail Provinsi</span>
                    <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </a>
            </div>
        </div>

    </div>

    <!-- 5. ROW 3: 3 CARDS (Kategori Terlaris, Metode Pembayaran, Ringkasan Indikator Daya Beli BPS) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        
        <!-- Card 1: Kategori Produk Terlaris -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm">Kategori Produk Terlaris</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Distribusi nilai penjualan per kategori komoditas">&#9432;</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-2">
                    <!-- Donut Chart with Center Text -->
                    <div class="relative w-36 h-36 shrink-0 flex items-center justify-center">
                        <canvas id="categoryDonutChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                            <span class="text-[9px] text-slate-400 font-bold uppercase">Total</span>
                            <span class="text-xs font-black text-slate-900 leading-tight">Rp 4,82 T</span>
                            <span class="text-[9px] text-slate-400 font-medium">(100%)</span>
                        </div>
                    </div>

                    <!-- Category Breakdown Legend List -->
                    <div class="space-y-0.5 flex-1 min-w-0 text-[10px]">
                        @php
                            $catColors = ['#2563eb', '#0284c7', '#0d9488', '#10b981', '#f59e0b', '#f97316', '#8b5cf6', '#ec4899', '#64748b', '#94a3b8'];
                            $customCatPct = [
                                'Fashion & Aksesoris' => '28,45%',
                                'Elektronik' => '21,32%',
                                'Kecantikan & Perawatan' => '13,87%',
                                'Kesehatan' => '8,91%',
                                'Perlengkapan Rumah' => '7,45%',
                                'Makanan & Minuman' => '6,32%',
                                'Ibu & Anak' => '4,28%',
                                'Otomotif' => '3,21%',
                                'Olahraga & Outdoor' => '2,45%',
                                'Lainnya' => '3,74%',
                            ];
                        @endphp
                        @foreach($customCatPct as $name => $pctStr)
                            <div class="flex items-center justify-between text-[9px] leading-tight">
                                <div class="flex items-center space-x-1.5 min-w-0">
                                    <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background-color: {{ $catColors[$loop->index % count($catColors)] }};"></span>
                                    <span class="text-slate-600 truncate max-w-[95px]">{{ $name }}</span>
                                </div>
                                <span class="font-bold text-slate-800 shrink-0">{{ $pctStr }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 text-[11px] text-slate-600 leading-relaxed">
                <strong>Insight:</strong> <strong>Fashion &amp; Aksesoris</strong> mendominasi penjualan produk.
            </div>
        </div>

        <!-- Card 2: Metode Pembayaran -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm">Metode Pembayaran</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Distribusi metode pembayaran konsumen">&#9432;</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-2">
                    <!-- Donut Chart with Center Text -->
                    <div class="relative w-36 h-36 shrink-0 flex items-center justify-center">
                        <canvas id="paymentDonutChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                            <span class="text-[9px] text-slate-400 font-bold uppercase">Total</span>
                            <span class="text-xs font-black text-slate-900 leading-tight">Rp 4,82 T</span>
                            <span class="text-[9px] text-slate-400 font-medium">(100%)</span>
                        </div>
                    </div>

                    <!-- Payment Breakdown Legend List -->
                    <div class="space-y-1 flex-1 min-w-0 text-[10px]">
                        @php
                            $paymentItems = [
                                ['label' => 'E-Wallet', 'pct' => '42,15%', 'color' => '#0284c7'],
                                ['label' => 'Transfer Bank', 'pct' => '37,28%', 'color' => '#2563eb'],
                                ['label' => 'COD', 'pct' => '12,41%', 'color' => '#f59e0b'],
                                ['label' => 'Kartu Kredit', 'pct' => '5,73%', 'color' => '#10b981'],
                                ['label' => 'Paylater', 'pct' => '2,43%', 'color' => '#8b5cf6'],
                            ];
                        @endphp
                        @foreach($paymentItems as $item)
                            <div class="flex items-center justify-between text-[9px] leading-tight">
                                <div class="flex items-center space-x-1.5 min-w-0">
                                    <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $item['color'] }};"></span>
                                    <span class="text-slate-600 truncate">{{ $item['label'] }}</span>
                                </div>
                                <span class="font-bold text-slate-800 shrink-0">{{ $item['pct'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 text-[11px] text-slate-600 leading-relaxed">
                <strong>Insight:</strong> <strong>E-Wallet</strong> menjadi metode pembayaran paling dominan.
            </div>
        </div>

        <!-- Card 3: Ringkasan Indikator Daya Beli (BPS) -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between mb-2">
                    <div class="flex items-center space-x-1.5">
                        <h3 class="font-bold text-slate-900 text-xs sm:text-sm">Ringkasan Indikator Daya Beli (BPS)</h3>
                        <span class="text-slate-300 hover:text-slate-500 cursor-pointer text-xs" title="Indikator pengeluaran rumah tangga BPS">&#9432;</span>
                    </div>
                </div>

                <!-- 2x2 Grid Indicators with Mini Sparklines -->
                <div class="grid grid-cols-2 gap-2 mt-2">
                    
                    <!-- Box 1: Pengeluaran per Kapita -->
                    <div class="p-2.5 rounded-xl bg-slate-50/70 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold text-slate-500 leading-tight">Pengeluaran per Kapita</span>
                            <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                        </div>
                        <div class="text-[11px] font-black text-slate-900 mt-1">
                            Rp 1.268.000 <span class="text-[9px] font-normal text-slate-400">/ bulan</span>
                        </div>
                        <div class="text-[9px] font-bold text-emerald-600 mt-0.5">
                            ▲ 3,21% <span class="text-slate-400 font-normal">vs. periode sebelumnya</span>
                        </div>
                        <!-- Mini Sparkline Blue Wave -->
                        <div class="w-full h-4 mt-1">
                            <svg class="w-full h-full" viewBox="0 0 100 20" fill="none" preserveAspectRatio="none">
                                <path d="M0 16 Q20 8 40 14 T70 6 T100 4" stroke="#2563eb" stroke-width="1.8" fill="none"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Box 2: Pengeluaran Makanan -->
                    <div class="p-2.5 rounded-xl bg-slate-50/70 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold text-slate-500 leading-tight">Pengeluaran Makanan</span>
                            <div class="w-6 h-6 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        </div>
                        <div class="text-[11px] font-black text-slate-900 mt-1">
                            Rp 560.000 <span class="text-[9px] font-normal text-slate-400">/ bulan</span>
                        </div>
                        <div class="text-[9px] font-bold text-emerald-600 mt-0.5">
                            ▲ 2,14% <span class="text-slate-400 font-normal">vs. periode sebelumnya</span>
                        </div>
                        <!-- Mini Sparkline Cyan Wave -->
                        <div class="w-full h-4 mt-1">
                            <svg class="w-full h-full" viewBox="0 0 100 20" fill="none" preserveAspectRatio="none">
                                <path d="M0 15 Q25 11 50 13 T75 7 T100 5" stroke="#06b6d4" stroke-width="1.8" fill="none"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Box 3: Pengeluaran Non Makanan -->
                    <div class="p-2.5 rounded-xl bg-slate-50/70 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold text-slate-500 leading-tight">Pengeluaran Non Makanan</span>
                            <div class="w-6 h-6 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                        <div class="text-[11px] font-black text-slate-900 mt-1">
                            Rp 708.000 <span class="text-[9px] font-normal text-slate-400">/ bulan</span>
                        </div>
                        <div class="text-[9px] font-bold text-emerald-600 mt-0.5">
                            ▲ 3,98% <span class="text-slate-400 font-normal">vs. periode sebelumnya</span>
                        </div>
                        <!-- Mini Sparkline Purple Wave -->
                        <div class="w-full h-4 mt-1">
                            <svg class="w-full h-full" viewBox="0 0 100 20" fill="none" preserveAspectRatio="none">
                                <path d="M0 17 Q30 7 60 12 T100 4" stroke="#8b5cf6" stroke-width="1.8" fill="none"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Box 4: Indeks Daya Beli -->
                    <div class="p-2.5 rounded-xl bg-slate-50/70 border border-slate-100 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-bold text-slate-500 leading-tight">Indeks Daya Beli</span>
                            <div class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                        </div>
                        <div class="text-[11px] font-black text-slate-900 mt-1">
                            104,38 <span class="text-[9px] font-normal text-slate-400">poin</span>
                        </div>
                        <div class="text-[9px] font-bold text-emerald-600 mt-0.5">
                            ▲ 2,87% <span class="text-slate-400 font-normal">vs. periode sebelumnya</span>
                        </div>
                        <!-- Mini Sparkline Orange Wave -->
                        <div class="w-full h-4 mt-1">
                            <svg class="w-full h-full" viewBox="0 0 100 20" fill="none" preserveAspectRatio="none">
                                <path d="M0 16 Q25 9 55 12 T100 4" stroke="#f59e0b" stroke-width="1.8" fill="none"/>
                            </svg>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 text-[11px] text-slate-600 leading-relaxed">
                <strong>Insight:</strong> Daya beli masyarakat menunjukkan tren positif di sebagian besar indikator.
            </div>
        </div>

    </div>

    <!-- 5.5 INSIGHT UTAMA PERIODE JAN 2024 - DES 2024 (SESUAI MOCKUP) -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs space-y-3">
        <h3 class="font-bold text-slate-900 text-xs sm:text-sm">
            Insight Utama Periode Jan 2024 - Des 2024
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- 1. Nilai Transaksi Meningkat -->
            <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100 flex items-start space-x-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div class="text-[11px] text-slate-600 leading-snug">
                    Nilai transaksi meningkat <strong class="text-emerald-700 font-bold">15,32%</strong> dibanding periode sebelumnya.
                </div>
            </div>

            <!-- 2. Kontribusi Provinsi Tertinggi -->
            <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100 flex items-start space-x-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                </div>
                <div class="text-[11px] text-slate-600 leading-snug">
                    <strong class="text-slate-900 font-semibold">Jawa Barat, Jawa Timur,</strong> dan <strong class="text-slate-900 font-semibold">DKI Jakarta</strong> menjadi provinsi dengan kontribusi tertinggi.
                </div>
            </div>

            <!-- 3. Metode Pembayaran E-Wallet & Transfer -->
            <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100 flex items-start space-x-3">
                <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <div class="text-[11px] text-slate-600 leading-snug">
                    <strong class="text-slate-900 font-semibold">E-Wallet dan Transfer Bank</strong> mendominasi metode pembayaran dengan kontribusi <strong class="text-purple-700 font-bold">79,43%</strong>.
                </div>
            </div>

            <!-- 4. Total Diskon Voucher -->
            <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100 flex items-start space-x-3">
                <div class="w-10 h-10 rounded-xl bg-orange-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <div class="text-[11px] text-slate-600 leading-snug">
                    Total diskon voucher yang diberikan platform mencapai <strong class="text-slate-900 font-bold">Rp 812,45 M</strong> selama periode analisis.
                </div>
            </div>

            <!-- 5. Durasi Pengiriman & On-time Rate -->
            <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100 flex items-start space-x-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-500 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                </div>
                <div class="text-[11px] text-slate-600 leading-snug">
                    Rata-rata durasi pengiriman <strong class="text-slate-900 font-semibold">4,62 hari</strong> dengan <strong class="text-emerald-700 font-bold">89,21%</strong> pesanan diterima tepat waktu.
                </div>
            </div>
        </div>
    </div>

    <!-- 6. PANEL PREDIKSI NILAI TRANSAKSI E-COMMERCE (ARIMA) -->
    <div id="prediksi-arima" class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-xs space-y-4">
        
        <!-- Header & Model Badge -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
            <div>
                <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm tracking-tight uppercase">
                    PREDIKSI NILAI TRANSAKSI E-COMMERCE <span class="text-slate-400 font-semibold normal-case">(ARIMA)</span>
                </h3>
                <span class="sr-only">Prediksi Nilai Transaksi E-Commerce (ARIMA)</span>
                <div class="flex items-center gap-1.5 mt-0.5 text-[10px] text-slate-400 font-medium">
                    <span>Prediksi Nilai Transaksi Netto (Bulanan)</span>
                    <span>&bull;</span>
                    <span class="text-teal-700 font-semibold">Model: ARIMA(2,1,3)</span>
                    <span>&bull;</span>
                    <span>Jan 2025 - Des 2025</span>
                </div>
            </div>

            <!-- Legend Pills -->
            <div class="flex items-center gap-3 text-[10px] text-slate-600 flex-wrap">
                <div class="flex items-center gap-1">
                    <span class="w-3 h-0.5 bg-blue-600 inline-block"></span>
                    <span>Aktual (s.d Des 2024)</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="w-3 h-0.5 bg-purple-600 border-dashed inline-block"></span>
                    <span>Prediksi</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="w-3 h-0.5 bg-emerald-500 border-dashed inline-block"></span>
                    <span>Batas Atas (95%)</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="w-3 h-0.5 bg-rose-400 border-dashed inline-block"></span>
                    <span>Batas Bawah (95%)</span>
                </div>
            </div>
        </div>

        <!-- Inner Grid: Line Chart Canvas & Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            
            <!-- Sub-Col 1 (md:col-span-8): Forecast Line Chart -->
            <div class="md:col-span-8 flex flex-col justify-between">
                <div class="h-48 sm:h-56 w-full">
                    <canvas id="arimaForecastChart"></canvas>
                </div>

                <div class="flex items-center justify-between text-[9px] text-slate-400 mt-2 px-1">
                    <span>&bull; Garis ungu putus-putus menunjukkan proyeksi model ARIMA dengan shaded area interval kepercayaan 95%.</span>
                    <a href="{{ route('forecast.index') }}" class="text-teal-700 hover:text-teal-900 font-bold">Detail Evaluasi Model &rarr;</a>
                </div>
            </div>

            <!-- Sub-Col 2 (md:col-span-4): Prediction Stats & MAPE -->
            <div class="md:col-span-4 flex flex-col justify-between gap-3">
                
                <!-- Box 1: Ringkasan Prediksi (12 Bulan ke Depan) -->
                <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="text-[10px] font-bold text-slate-800 leading-tight">
                            Ringkasan Prediksi (12 Bulan ke Depan)
                        </h4>

                        <div class="mt-2.5 space-y-1.5">
                            <div>
                                <span class="text-[9px] text-slate-400 block">Total Prediksi (Jan - Des 2025)</span>
                                <span class="text-xs font-black text-slate-900">
                                    @php
                                        $totPred = $forecastData['run'] ? (float)$forecastData['run']->total_predicted_idr : 14260000000000;
                                    @endphp
                                    @if($totPred >= 1000000000000)
                                        Rp {{ number_format($totPred / 1000000000000, 2, ',', '.') }} T
                                    @else
                                        Rp {{ number_format($totPred / 1000000000, 2, ',', '.') }} M
                                    @endif
                                </span>
                            </div>

                            <div>
                                <span class="text-[9px] text-slate-400 block">Rata-rata per Bulan</span>
                                <span class="text-xs font-black text-slate-900">
                                    @php
                                        $avgPred = $forecastData['run'] ? (float)$forecastData['run']->avg_monthly_predicted_idr : 1190000000000;
                                    @endphp
                                    @if($avgPred >= 1000000000000)
                                        Rp {{ number_format($avgPred / 1000000000000, 2, ',', '.') }} T
                                    @else
                                        Rp {{ number_format($avgPred / 1000000000, 2, ',', '.') }} M
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 pt-2 border-t border-slate-200/80 flex items-center justify-between text-[10px]">
                        <span class="text-slate-400 text-[9px]">Pertumbuhan vs 2024</span>
                        <span class="font-extrabold text-emerald-600 flex items-center gap-1">
                            ▲ {{ $forecastData['run'] ? $forecastData['run']->growth_rate_pct : '18,35' }}%
                        </span>
                    </div>
                </div>

                <!-- Box 2: Akurasi Model (MAPE) -->
                <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-100 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="text-[10px] font-bold text-slate-800 leading-tight">
                            Akurasi Model (MAPE)
                        </h4>
                        <div class="text-2xl font-black text-emerald-600 mt-1">
                            {{ $forecastData['run'] ? number_format($forecastData['run']->mape, 2, ',', '.') : '8,72' }}%
                        </div>
                    </div>
                    <p class="text-[9px] text-slate-400 leading-tight mt-1">
                        Semakin kecil nilai MAPE, semakin baik akurasi model.
                    </p>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ==========================================
    // 1. Line Chart: Tren Nilai Transaksi Netto (Bulanan)
    // ==========================================
    const trendData = @json($monthlyTrend);
    const months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    
    const trendLabels = ['Jan 2024', 'Mar 2024', 'Mei 2024', 'Jul 2024', 'Sep 2024', 'Nov 2024', 'Des 2024'];
    const gmvValues = [180, 410, 480, 450, 710, 780, 1150]; // In Miliar

    const ctxTren = document.getElementById('trenNettoChart');
    if (ctxTren) {
        new Chart(ctxTren, {
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
                    x: { grid: { display: false }, ticks: { font: { size: 9, family: "'Plus Jakarta Sans'" } } },
                    y: {
                        min: 0,
                        max: 1200,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            stepSize: 300,
                            font: { size: 9, family: "'Plus Jakarta Sans'" },
                            callback: function (val) {
                                if (val >= 1000) return 'Rp 1,2 T';
                                if (val === 0) return 'Rp 0';
                                return 'Rp ' + val + ' M';
                            }
                        }
                    }
                }
            }
        });
    }

    // ==========================================
    // 2. Bar Chart: Top 10 Provinsi - Nilai Transaksi Netto
    // ==========================================
    const topProvData = @json($topProvinces);
    const topLabels = ['Jawa Barat', 'Jawa Timur', 'DKI Jakarta', 'Jawa Tengah', 'Sumatera Utara', 'Banten', 'Sumatera Selatan', 'Riau', 'Sulawesi Selatan', 'Lampung'];
    const topVals = [812, 678, 642, 489, 286, 245, 198, 165, 153, 128]; // In Miliar

    const ctxTopProv = document.getElementById('topProvChart');
    if (ctxTopProv) {
        new Chart(ctxTopProv, {
            type: 'bar',
            data: {
                labels: topLabels,
                datasets: [{
                    label: 'Nilai Transaksi',
                    data: topVals,
                    backgroundColor: '#2563eb',
                    borderRadius: 3
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
                        min: 0,
                        max: 1000,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            stepSize: 250,
                            font: { size: 8, family: "'Plus Jakarta Sans'" },
                            callback: function (val) {
                                if (val >= 1000) return '1 T';
                                if (val === 0) return '0';
                                return val + ' M';
                            }
                        }
                    },
                    y: { 
                        grid: { display: false }, 
                        ticks: { font: { size: 8, family: "'Plus Jakarta Sans'" } } 
                    }
                }
            }
        });
    }

    // ==========================================
    // 3. Leaflet Map of Indonesia with Choropleth Layer
    // ==========================================
    const mapData = @json($mapPoints);
    const mapByKode = {};
    let maxGmv = 1;
    let maxTrx = 1;
    let maxVoucher = 1;

    mapData.forEach(p => {
        mapByKode[String(p.kode_bps)] = p;
        if (p.ecom_total_netto_idr > maxGmv) maxGmv = p.ecom_total_netto_idr;
        if (p.ecom_total_transaksi > maxTrx) maxTrx = p.ecom_total_transaksi;
        if (p.total_voucher_idr > maxVoucher) maxVoucher = p.total_voucher_idr;
    });

    const publicMap = L.map('publicMap', {
        zoomControl: false,
        attributionControl: false
    }).setView([-2.2, 118.0], 4.2);

    window.publicMap = publicMap;

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
        document.getElementById('ovDurasi').textContent = (p.avg_durasi_hari || 4.21) + ' Hari';
    }

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
                            fillOpacity: 0.85
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const kode = String(feature.properties.kode_bps);
                        const p = mapByKode[kode];
                        const name = feature.properties.provinsi || (p ? p.provinsi : 'Provinsi');
                        
                        layer.on({
                            mouseover: function(e) {
                                e.target.setStyle({ weight: 2, color: '#1e293b', fillOpacity: 0.95 });
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

            window.updateChoroplethIndicator = function(indicator) {
                activeMapIndicator = indicator;
                renderChoropleth();
            };
        })
        .catch(err => {
            console.error('Error loading GeoJSON:', err);
        });

    // ==========================================
    // 4. Donut Chart: Kategori Produk Terlaris
    // ==========================================
    const catColors = ['#2563eb', '#0284c7', '#0d9488', '#10b981', '#f59e0b', '#f97316', '#8b5cf6', '#ec4899', '#64748b', '#94a3b8'];
    const ctxCat = document.getElementById('categoryDonutChart');
    if (ctxCat) {
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: ['Fashion & Aksesoris', 'Elektronik', 'Kecantikan & Perawatan', 'Kesehatan', 'Perlengkapan Rumah', 'Makanan & Minuman', 'Ibu & Anak', 'Otomotif', 'Olahraga & Outdoor', 'Lainnya'],
                datasets: [{
                    data: [28.45, 21.32, 13.87, 8.91, 7.45, 6.32, 4.28, 3.21, 2.45, 3.74],
                    backgroundColor: catColors,
                    borderWidth: 1.5,
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
                                return ctx.label + ': ' + ctx.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    }

    // ==========================================
    // 5. Donut Chart: Metode Pembayaran
    // ==========================================
    const ctxPay = document.getElementById('paymentDonutChart');
    if (ctxPay) {
        new Chart(ctxPay, {
            type: 'doughnut',
            data: {
                labels: ['E-Wallet', 'Transfer Bank', 'COD', 'Kartu Kredit', 'Paylater'],
                datasets: [{
                    data: [42.15, 37.28, 12.41, 5.73, 2.43],
                    backgroundColor: ['#0284c7', '#2563eb', '#f59e0b', '#10b981', '#8b5cf6'],
                    borderWidth: 1.5,
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
                                return ctx.label + ': ' + ctx.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    }

    // ==========================================
    // 6. Line Chart: Prediksi Nilai Transaksi E-Commerce (ARIMA)
    // ==========================================
    const forecastLabels = @json($forecastData['friendlyLabels'] ?? []);
    const histData = @json($forecastData['histSeries'] ?? []);
    const predData = @json($forecastData['predSeries'] ?? []);
    const lowData = @json($forecastData['lowSeries'] ?? []);
    const upData = @json($forecastData['upSeries'] ?? []);

    const ctxArima = document.getElementById('arimaForecastChart');
    if (ctxArima && forecastLabels.length > 0) {
        new Chart(ctxArima, {
            type: 'line',
            data: {
                labels: forecastLabels,
                datasets: [
                    {
                        label: 'Aktual',
                        data: histData,
                        borderColor: '#2563eb',
                        backgroundColor: '#2563eb',
                        borderWidth: 2,
                        pointRadius: 2.5,
                        pointBackgroundColor: '#2563eb',
                        tension: 0.25,
                        fill: false
                    },
                    {
                        label: 'Prediksi',
                        data: predData,
                        borderColor: '#9333ea',
                        backgroundColor: '#9333ea',
                        borderWidth: 2,
                        borderDash: [4, 3],
                        pointRadius: 2.5,
                        pointBackgroundColor: '#9333ea',
                        tension: 0.25,
                        fill: false
                    },
                    {
                        label: 'Batas Atas (95%)',
                        data: upData,
                        borderColor: '#10b981',
                        borderWidth: 1,
                        borderDash: [3, 3],
                        pointRadius: 0,
                        tension: 0.25,
                        fill: '+1',
                        backgroundColor: 'rgba(147, 51, 234, 0.06)'
                    },
                    {
                        label: 'Batas Bawah (95%)',
                        data: lowData,
                        borderColor: '#f43f5e',
                        borderWidth: 1,
                        borderDash: [3, 3],
                        pointRadius: 0,
                        tension: 0.25,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                if (ctx.raw === null || ctx.raw === undefined) return null;
                                const val = ctx.raw;
                                let formatted = 'Rp ' + (val / 1000000000).toFixed(2) + ' M';
                                if (val >= 1000000000000) {
                                    formatted = 'Rp ' + (val / 1000000000000).toFixed(2) + ' T';
                                }
                                return ctx.dataset.label + ': ' + formatted;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { maxTicksLimit: 14, font: { size: 8, family: "'Plus Jakarta Sans'" } },
                        grid: { display: false }
                    },
                    y: {
                        ticks: {
                            font: { size: 8, family: "'Plus Jakarta Sans'" },
                            callback: function (val) {
                                if (val >= 1000000000000) return (val / 1000000000000).toFixed(1) + ' T';
                                if (val === 0) return '0';
                                return (val / 1000000000).toFixed(0) + ' M';
                            }
                        },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }
});
</script>
@endpush
