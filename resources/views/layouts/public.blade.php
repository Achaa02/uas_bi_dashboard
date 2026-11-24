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
            position: relative;
            min-height: 100vh;
        }
        .public-top-banner {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 480px;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .leaflet-container {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50/70 text-slate-800 antialiased selection:bg-blue-600 selection:text-white relative">

    <!-- Atmospheric Flowing Aurora & Dotted Background Banner (Sesuai Desain Publik) -->
    <div class="public-top-banner">
        <svg class="w-full h-full object-cover min-w-[1280px]" viewBox="0 0 1920 480" fill="none" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <!-- Aurora Sky Linear Gradients -->
                <linearGradient id="auroraSky" x1="0%" y1="0%" x2="100%" y2="60%">
                    <stop offset="0%" stop-color="#06b6d4" stop-opacity="0.95"/>
                    <stop offset="20%" stop-color="#0ea5e9" stop-opacity="0.9"/>
                    <stop offset="55%" stop-color="#2563eb" stop-opacity="0.92"/>
                    <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.98"/>
                </linearGradient>

                <linearGradient id="mintWaveGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#2dd4bf" stop-opacity="0.95"/>
                    <stop offset="45%" stop-color="#06b6d4" stop-opacity="0.85"/>
                    <stop offset="100%" stop-color="#38bdf8" stop-opacity="0.1"/>
                </linearGradient>

                <linearGradient id="limeCyanWaveGrad" x1="0%" y1="100%" x2="60%" y2="0%">
                    <stop offset="0%" stop-color="#4ade80" stop-opacity="0.9"/>
                    <stop offset="40%" stop-color="#14b8a6" stop-opacity="0.85"/>
                    <stop offset="100%" stop-color="#38bdf8" stop-opacity="0"/>
                </linearGradient>

                <linearGradient id="royalArcGrad1" x1="100%" y1="100%" x2="10%" y2="0%">
                    <stop offset="0%" stop-color="#1e40af" stop-opacity="0.85"/>
                    <stop offset="55%" stop-color="#2563eb" stop-opacity="0.6"/>
                    <stop offset="100%" stop-color="#60a5fa" stop-opacity="0"/>
                </linearGradient>

                <linearGradient id="royalArcGrad2" x1="100%" y1="80%" x2="20%" y2="10%">
                    <stop offset="0%" stop-color="#1d4ed8" stop-opacity="0.75"/>
                    <stop offset="60%" stop-color="#3b82f6" stop-opacity="0.4"/>
                    <stop offset="100%" stop-color="#93c5fd" stop-opacity="0"/>
                </linearGradient>

                <linearGradient id="bannerBottomFade" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="65%" stop-color="#ffffff" stop-opacity="0"/>
                    <stop offset="100%" stop-color="#f8fafc" stop-opacity="1"/>
                </linearGradient>

                <!-- White Dots Grid Pattern -->
                <pattern id="whiteDotsMatrix" x="0" y="0" width="18" height="18" patternUnits="userSpaceOnUse">
                    <circle cx="3" cy="3" r="1.3" fill="#ffffff" fill-opacity="0.55"/>
                </pattern>
            </defs>

            <!-- Base Flowing Gradient Sky -->
            <rect width="1920" height="480" fill="url(#auroraSky)"/>

            <!-- Soft Glowing Center/Bottom Ambient Light -->
            <ellipse cx="940" cy="360" rx="780" ry="240" fill="#ffffff" fill-opacity="0.32"/>
            <ellipse cx="680" cy="400" rx="580" ry="220" fill="#ccfbf1" fill-opacity="0.45"/>

            <!-- Left Flowing Organic Curves (Mint, Turquoise, Lime) -->
            <path d="M-100,480 C180,420 380,280 440,110 C480,-20 360,-100 160,-100 L-100,-100 Z" fill="url(#mintWaveGrad)"/>
            <path d="M-80,500 C140,460 300,380 340,230 C380,90 260,0 90,-20 L-80,-20 Z" fill="url(#limeCyanWaveGrad)"/>
            <circle cx="80" cy="480" r="280" fill="#22c55e" fill-opacity="0.4"/>
            <circle cx="30" cy="490" r="190" fill="#4ade80" fill-opacity="0.5"/>
            <circle cx="160" cy="410" r="130" fill="#2dd4bf" fill-opacity="0.38"/>

            <!-- Top-Left Dot Matrix Grid -->
            <rect x="0" y="0" width="360" height="250" fill="url(#whiteDotsMatrix)" opacity="0.85"/>

            <!-- Right Flowing Circular Arcs & Waves (Royal Blue & Indigo) -->
            <circle cx="1700" cy="460" r="540" fill="url(#royalArcGrad1)"/>
            <circle cx="1600" cy="370" r="420" fill="url(#royalArcGrad2)"/>
            <path d="M1360,480 C1500,320 1680,200 1960,180 L1960,480 Z" fill="#1e3a8a" fill-opacity="0.3"/>
            <path d="M1180,480 C1380,340 1560,170 1960,90 L1960,480 Z" fill="#3b82f6" fill-opacity="0.25"/>

            <!-- Lower-Right Dot Matrix Grid -->
            <rect x="1600" y="240" width="340" height="220" fill="url(#whiteDotsMatrix)" opacity="0.85"/>

            <!-- Seamless Vertical Fade into Page Surface -->
            <rect width="1920" height="480" fill="url(#bannerBottomFade)"/>
        </svg>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 max-w-[1680px] mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-5">
        @yield('content')

        <!-- Footer (Matching Reference Mockup) -->
        <footer class="pt-6 pb-6 border-t border-slate-200/80 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-3">
            <div class="flex items-center space-x-2">
                <span>&copy; 2025 BI Dashboard E-Commerce &amp; BPS Analytics &bull; Sumber Data: E-Commerce (diolah), BPS</span>
            </div>
            <div class="flex items-center space-x-5 text-xs font-semibold text-slate-600">
                <a href="{{ route('dashboard.metodologi') }}" class="hover:text-blue-600 transition-colors">Tentang Proyek</a>
                <a href="{{ route('dashboard.metodologi') }}" class="hover:text-blue-600 transition-colors">Metodologi</a>
                <a href="{{ route('dashboard.explorer') }}" class="hover:text-blue-600 transition-colors">Sumber Data</a>
                <a href="mailto:info@bi-ecommerce-bps.go.id" class="hover:text-blue-600 transition-colors">Kontak</a>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
