<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BI Dashboard - Pemetaan Pola Konsumsi & Daya Beli Digital')</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        .leaflet-container {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50/80 text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <!-- Main Container -->
    <div class="max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-5">
        @yield('content')

        <!-- Footer -->
        <footer class="pt-6 pb-4 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-3">
            <div class="flex items-center space-x-2">
                <span>&copy; {{ date('Y') }} BI Dashboard E-Commerce & BPS Analytics</span>
                <span>&bull;</span>
                <span>Sumber Data: E-Commerce (diolah), BPS</span>
            </div>
            <div class="flex items-center space-x-4 text-xs font-medium text-slate-600">
                <a href="{{ route('dashboard.metodologi') }}" class="hover:text-blue-600 transition-colors">Tentang Proyek</a>
                <span class="text-slate-300">&bull;</span>
                <a href="{{ route('dashboard.metodologi') }}" class="hover:text-blue-600 transition-colors">Metodologi</a>
                <span class="text-slate-300">&bull;</span>
                <a href="{{ route('dashboard.explorer') }}" class="hover:text-blue-600 transition-colors">Sumber Data</a>
                <span class="text-slate-300">&bull;</span>
                <a href="{{ route('dashboard.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    Dashboard Peneliti
                </a>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
