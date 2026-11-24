<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Utama') | BI DASHBOARD - E-Commerce & BPS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        code, pre {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="h-full antialiased text-slate-800 flex flex-col">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation (Dark Navy Blue) -->
        <aside class="w-64 bg-[#0a1128] text-slate-300 flex flex-col justify-between shrink-0 z-20 border-r border-slate-900 overflow-y-auto">
            <div>
                <!-- Brand / Logo Area (Klik mengarah ke Dashboard Publik) -->
                <a href="{{ route('public.dashboard') }}" class="px-6 py-5 border-b border-slate-800/80 flex items-center space-x-3 cursor-pointer hover:bg-slate-900/40 transition-colors">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-md shadow-blue-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <h1 class="font-extrabold text-white tracking-tight text-sm leading-none">BI DASHBOARD</h1>
                        <p class="text-[11px] text-slate-400 font-medium mt-1">E-Commerce & BPS</p>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="px-3.5 py-4 space-y-1">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 py-1.5">MENU UTAMA</div>

                    <a href="{{ route('public.dashboard') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('public.dashboard') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard Utama</span>
                    </a>

                    <a href="{{ route('dashboard.pola-konsumsi') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('dashboard.pola-konsumsi') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span>Analisis E-Commerce</span>
                    </a>

                    <a href="{{ route('dashboard.daya-beli') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('dashboard.daya-beli') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        <span>Daya Beli & BPS</span>
                    </a>

                    <a href="{{ route('dashboard.spasial') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('dashboard.spasial') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Analisis Geografis</span>
                    </a>

                    <a href="{{ route('dashboard.explorer') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('dashboard.explorer') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Perilaku Konsumen</span>
                    </a>

                    <a href="{{ route('dashboard.tren') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('dashboard.tren*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        <span>Analisis Tren & 20 Insight</span>
                    </a>

                    <a href="{{ route('laporan.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('laporan.*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>Laporan Analitik</span>
                    </a>

                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 px-3 pt-3.5 pb-1.5">DATA & SISTEM</div>

                    <a href="{{ route('dashboard.metodologi') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium transition-all {{ request()->routeIs('dashboard.metodologi') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7c-2 0-3 1-3 3zm0 4h16M8 4v4m8-4v4"></path></svg>
                        <span>Sumber Data</span>
                    </a>

                    <a href="{{ route('dashboard.explorer') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition-all">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                        <span>Manajemen Data</span>
                    </a>

                    <a href="{{ route('dashboard.metodologi') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition-all">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        <span>ETL & Proses</span>
                    </a>

                    <a href="{{ route('dashboard.metodologi') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-medium text-slate-400 hover:text-white hover:bg-slate-800/60 transition-all">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Pengaturan</span>
                    </a>
                </nav>
            </div>

            <!-- Integrated Data Sources Box at Sidebar Bottom (Matching Reference Image) -->
            <div class="p-3.5 space-y-2.5">
                <div class="p-3 rounded-2xl bg-[#070d1e] border border-slate-800/80 space-y-2.5">
                    <div class="text-[9.5pt] font-bold text-slate-400 uppercase tracking-wider">SUMBER DATA TERINTEGRASI</div>

                    <!-- Kaggle Item -->
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[11px] font-bold text-white truncate">E-Commerce Kaggle</div>
                            <div class="text-[10px] text-slate-400 leading-tight">5.000.000 Transaksi</div>
                            <div class="text-[9px] text-slate-400">Terakhir: 21 Nov 2026</div>
                        </div>
                    </div>

                    <!-- BPS Item -->
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-[11px] font-bold text-white truncate">BPS Statistik</div>
                            <div class="text-[10px] text-slate-400 leading-tight">38 Provinsi (15 Tahun)</div>
                            <div class="text-[9px] text-slate-400">Terakhir: 21 Nov 2026</div>
                        </div>
                    </div>
                </div>

                <div class="text-[10px] text-slate-400 px-1 flex items-center justify-between">
                    <span>BI Dashboard v1.0</span>
                    <span>&copy; 2026 Research</span>
                </div>
            </div>
        </aside>

        <!-- Main Workspace Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-[#f8fafc]">
            <!-- Top Navbar (Matching Reference Image) -->
            <header class="bg-white border-b border-slate-200/90 sticky top-0 z-30 px-6 py-3.5 flex items-center justify-between">
                <!-- Left: Hamburger + Title + Subtitle -->
                <div class="flex items-center space-x-3.5">
                    <button type="button" class="text-slate-500 hover:text-slate-800 focus:outline-none p-1 rounded-lg hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900 tracking-tight leading-tight">
                            @yield('header_title', 'Dashboard Utama')
                        </h2>
                        <p class="text-[11px] text-slate-400 font-medium">
                            Pemetaan Pola Konsumsi dan Daya Beli Digital di Indonesia
                        </p>
                    </div>
                </div>

                <!-- Right: Filters + Notification + User Avatar -->
                <div class="flex items-center space-x-3">
                    @yield('navbar_filters')

                    <!-- Notification Bell -->
                    <button type="button" class="relative p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500"></span>
                    </button>

                    <!-- User Profile Avatar Pill -->
                    <div class="flex items-center space-x-2.5 pl-2 border-l border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                            AB
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-xs font-bold text-slate-800 leading-none">Admin BI</div>
                            <div class="text-[10px] text-slate-400 font-medium mt-0.5">Peneliti</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Page View Content -->
            <main class="flex-1 p-6 space-y-6 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
