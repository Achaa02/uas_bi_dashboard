@extends($layoutMode === 'public' ? 'layouts.public' : 'layouts.app')

@section('title', '20 Chart Analitik & Insight Bisnis - BI Dashboard')
@section('header_title', '20 Chart Analitik & Insight Bisnis')

@section('content')
<div class="space-y-6 w-full">

    <!-- 1. HEADER & FILTER BAR -->
    <header class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/90 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Title & Subtitle -->
        <div>
            <div class="flex items-center space-x-2.5">
                <span class="w-2.5 h-6 rounded-full bg-blue-600"></span>
                <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    20 Chart Analitik & Pemetaan Insight Bisnis
                </h1>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/80">
                    Koleksi Lengkap
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-5">
                Integrasi Komprehensif Dataset Big Data E-Commerce & Statistik Pendapatan BPS
            </p>
        </div>

        <!-- Filter Controls Form -->
        <div class="flex flex-wrap items-center gap-2.5">
            <form id="chartFilterForm" method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-center gap-2">
                <!-- Period Filter Dropdown -->
                <div class="relative flex items-center">
                    <div class="absolute left-3 text-slate-400 pointer-events-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <select name="periode" onchange="document.getElementById('chartFilterForm').submit()" 
                            class="bg-white border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-semibold rounded-xl pl-8 pr-7 py-2 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow-sm transition-all cursor-pointer">
                        <option value="2024" {{ $selectedPeriod === '2024' ? 'selected' : '' }}>Periode: 2024</option>
                        <option value="2025" {{ $selectedPeriod === '2025' ? 'selected' : '' }}>Periode: 2025</option>
                        <option value="2026" {{ $selectedPeriod === '2026' ? 'selected' : '' }}>Periode: 2026</option>
                        <option value="all" {{ $selectedPeriod === 'all' ? 'selected' : '' }}>Semua Periode (2024-2026)</option>
                    </select>
                    <div class="absolute right-2.5 text-slate-400 pointer-events-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Province Filter Dropdown -->
                <div class="relative flex items-center">
                    <div class="absolute left-3 text-slate-400 pointer-events-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    </div>
                    <select name="provinsi" onchange="document.getElementById('chartFilterForm').submit()" 
                            class="bg-white border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-semibold rounded-xl pl-8 pr-7 py-2 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow-sm transition-all cursor-pointer max-w-[190px] truncate">
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

            <!-- Quick Link / Return Button -->
            @if($layoutMode === 'public')
                <a href="{{ route('public.dashboard') }}" 
                   class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Dashboard Publik</span>
                </a>
            @else
                <a href="{{ route('public.dashboard') }}" 
                   target="_blank"
                   class="px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>Buka Tampilan Publik</span>
                </a>
            @endif
        </div>
    </header>

    <!-- 2. THE 20 CHARTS GRID (5 COLUMNS x 4 ROWS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">

        <!-- ============================================================== -->
        <!-- ROW 1 (1 - 5) -->
        <!-- ============================================================== -->

        <!-- 1. TREN JUMLAH TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        1
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Tren Jumlah Transaksi</h2>
                        <p class="text-[10px] text-slate-400">Line Chart (Harian/Bulanan)</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart1_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Memantau pertumbuhan jumlah transaksi dari waktu ke waktu.
            </div>
        </div>

        <!-- 2. PERBANDINGAN NILAI TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        2
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Perbandingan Nilai Transaksi</h2>
                        <p class="text-[10px] text-slate-400">Column Chart (YoY)</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart2_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Membandingkan kinerja nilai transaksi antar tahun.
            </div>
        </div>

        <!-- 3. KONTRIBUSI PLATFORM E-COMMERCE -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        3
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Kontribusi Platform E-Commerce</h2>
                        <p class="text-[10px] text-slate-400">Donut Chart</p>
                    </div>
                </div>
                <div class="relative h-44 w-full flex items-center justify-center">
                    <canvas id="chart3_canvas"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                        <span class="text-[9px] text-slate-400 font-bold uppercase">Total</span>
                        <span class="text-[11px] font-extrabold text-slate-900 leading-tight">
                            Rp {{ number_format($totalNetto / 1000000000000, 2, ',', '.') }} T
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengetahui platform yang paling dominan digunakan.
            </div>
        </div>

        <!-- 4. TOP 10 KATEGORI PRODUK -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        4
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Top 10 Kategori Produk</h2>
                        <p class="text-[10px] text-slate-400">Horizontal Bar Chart</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart4_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengidentifikasi kategori produk dengan nilai transaksi terbesar.
            </div>
        </div>

        <!-- 5. DISTRIBUSI HARGA PRODUK -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        5
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Distribusi Harga Produk</h2>
                        <p class="text-[10px] text-slate-400">Histogram</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart5_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengetahui rentang harga produk yang paling banyak dibeli.
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- ROW 2 (6 - 10) -->
        <!-- ============================================================== -->

        <!-- 6. POLA TRANSAKSI PER JAM -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        6
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Pola Transaksi per Jam</h2>
                        <p class="text-[10px] text-slate-400">Area Chart</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart6_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Menemukan jam-jam puncak aktivitas transaksi.
            </div>
        </div>

        <!-- 7. PERFORMA HARI DALAM SEMINGGU -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        7
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Performa Hari dalam Seminggu</h2>
                        <p class="text-[10px] text-slate-400">Bar Chart</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart7_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengetahui hari dengan transaksi tertinggi atau terendah.
            </div>
        </div>

        <!-- 8. PETA KEPADATAN TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        8
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Peta Kepadatan Transaksi</h2>
                        <p class="text-[10px] text-slate-400">Choropleth Map (Provinsi)</p>
                    </div>
                </div>
                <div class="relative h-44 w-full rounded-xl overflow-hidden border border-slate-100">
                    <div id="chart8_map" class="h-full w-full"></div>
                    <div class="absolute bottom-1 right-1 z-[400] bg-white/90 backdrop-blur-xs px-1.5 py-0.5 rounded text-[8px] text-slate-500 border border-slate-200">
                        Rendah <span class="inline-block w-8 h-1.5 bg-gradient-to-r from-blue-100 to-blue-700 mx-1 rounded"></span> Tinggi
                    </div>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Melihat persebaran nilai transaksi secara geografis.
            </div>
        </div>

        <!-- 9. TOP 10 PROVINSI -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        9
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Top 10 Provinsi</h2>
                        <p class="text-[10px] text-slate-400">Column Chart</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart9_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Membandingkan nilai transaksi antar provinsi.
            </div>
        </div>

        <!-- 10. PROPORSI PENGIRIMAN TEPAT WAKTU -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        10
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Proporsi Pengiriman Tepat Waktu</h2>
                        <p class="text-[10px] text-slate-400">Donut Chart</p>
                    </div>
                </div>
                <div class="relative h-44 w-full flex items-center justify-center">
                    <canvas id="chart10_canvas"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                        <span class="text-[9px] text-slate-400 font-bold uppercase">Tepat Waktu</span>
                        <span class="text-xs font-extrabold text-blue-600 leading-tight">
                            {{ $chart10_onTime['onTimePct'] }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengukur kinerja ketepatan waktu pengiriman.
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- ROW 3 (11 - 15) -->
        <!-- ============================================================== -->

        <!-- 11. RATA-RATA DURASI PENGIRIMAN -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        11
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Rata-rata Durasi Pengiriman</h2>
                        <p class="text-[10px] text-slate-400">Bar Chart (Provinsi)</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart11_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengidentifikasi provinsi dengan pengiriman terlama.
            </div>
        </div>

        <!-- 12. METODE PEMBAYARAN -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        12
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Metode Pembayaran</h2>
                        <p class="text-[10px] text-slate-400">Donut Chart</p>
                    </div>
                </div>
                <div class="relative h-44 w-full flex items-center justify-center">
                    <canvas id="chart12_canvas"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                        <span class="text-[9px] text-slate-400 font-bold uppercase">Total</span>
                        <span class="text-[11px] font-extrabold text-slate-900 leading-tight">
                            Rp {{ number_format($totalNetto / 1000000000000, 2, ',', '.') }} T
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengetahui preferensi metode pembayaran konsumen.
            </div>
        </div>

        <!-- 13. NILAI DISKON PER PLATFORM -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        13
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Nilai Diskon per Platform</h2>
                        <p class="text-[10px] text-slate-400">Column Chart</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart13_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Melihat total diskon voucher berdasarkan platform.
            </div>
        </div>

        <!-- 14. RASIO DISKON TERHADAP BRUTO -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        14
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Rasio Diskon terhadap Bruto</h2>
                        <p class="text-[10px] text-slate-400">Line Chart</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart14_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengukur seberapa besar diskon memengaruhi nilai transaksi.
            </div>
        </div>

        <!-- 15. CUSTOMER REPEAT ORDER RATE -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        15
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Customer Repeat Order Rate</h2>
                        <p class="text-[10px] text-slate-400">Gauge Chart</p>
                    </div>
                </div>
                <div class="relative h-44 w-full flex items-center justify-center">
                    <canvas id="chart15_canvas"></canvas>
                    <div class="absolute bottom-5 flex flex-col items-center justify-center pointer-events-none text-center">
                        <span class="text-lg font-black text-slate-900 leading-none">{{ $chart15_repeatRatePct }}%</span>
                        <span class="text-[9px] text-slate-400 mt-0.5">Repeat Customers</span>
                    </div>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengukur tingkat loyalitas pelanggan.
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- ROW 4 (16 - 20) -->
        <!-- ============================================================== -->

        <!-- 16. DISTRIBUSI USIA PEMBELI -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        16
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Distribusi Usia Pembeli</h2>
                        <p class="text-[10px] text-slate-400">Bar Chart</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart16_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengetahui kelompok usia yang paling aktif.
            </div>
        </div>

        <!-- 17. DISTRIBUSI GENDER PEMBELI -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        17
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Distribusi Gender Pembeli</h2>
                        <p class="text-[10px] text-slate-400">Pie Chart</p>
                    </div>
                </div>
                <div class="h-44 w-full flex items-center justify-center">
                    <canvas id="chart17_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Mengetahui komposisi gender pembeli.
            </div>
        </div>

        <!-- 18. KORELASI DISKON VS NILAI TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        18
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Korelasi Diskon vs Nilai Transaksi</h2>
                        <p class="text-[10px] text-slate-400">Scatter Plot</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart18_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Melihat hubungan antara diskon dan nilai transaksi.
            </div>
        </div>

        <!-- 19. RFM CUSTOMER SEGMENTATION -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        19
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">RFM Customer Segmentation</h2>
                        <p class="text-[10px] text-slate-400">Treemap</p>
                    </div>
                </div>
                <!-- Treemap Grid Box matching image style -->
                <div class="h-44 w-full rounded-xl overflow-hidden p-1.5 bg-slate-50 border border-slate-100 grid grid-cols-12 grid-rows-6 gap-1 text-white text-[10px] font-semibold">
                    <div class="col-span-6 row-span-6 bg-emerald-600 rounded-lg p-2 flex flex-col justify-between shadow-xs">
                        <span>Loyal</span>
                        <span class="text-xs font-extrabold">28.4%</span>
                    </div>
                    <div class="col-span-6 row-span-3 bg-sky-600 rounded-lg p-1.5 flex flex-col justify-between shadow-xs">
                        <span class="truncate">Potential Loyalist</span>
                        <span class="text-xs font-bold">22.1%</span>
                    </div>
                    <div class="col-span-3 row-span-3 bg-amber-500 rounded-lg p-1 flex flex-col justify-between shadow-xs">
                        <span class="truncate text-[9px]">At Risk</span>
                        <span class="text-[10px] font-bold">17.3%</span>
                    </div>
                    <div class="col-span-3 row-span-3 bg-indigo-500 rounded-lg p-1 flex flex-col justify-between shadow-xs">
                        <span class="truncate text-[9px]">Hibernating</span>
                        <span class="text-[10px] font-bold">16.4%</span>
                    </div>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Segmentasi pelanggan untuk strategi pemasaran.
            </div>
        </div>

        <!-- 20. INDIKATOR BPS (DAYA BELI) -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="flex items-start space-x-2.5 mb-2.5">
                    <div class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-sm shadow-blue-500/30">
                        20
                    </div>
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xs font-bold text-slate-900 leading-tight">Indikator BPS (Daya Beli)</h2>
                        <p class="text-[10px] text-slate-400">Multi Line Chart</p>
                    </div>
                </div>
                <div class="h-44 w-full">
                    <canvas id="chart20_canvas"></canvas>
                </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-slate-100 text-[10px] text-blue-600 leading-snug">
                <span class="font-bold">Manfaat:</span> Melihat perkembangan indikator daya beli masyarakat.
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Shared chart formatting defaults
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#64748b';
    Chart.defaults.scale.grid.color = '#f1f5f9';

    // 1. TREN JUMLAH TRANSAKSI (Line Chart)
    const c1Data = @json($chart1_trendTrx);
    new Chart(document.getElementById('chart1_canvas'), {
        type: 'line',
        data: {
            labels: c1Data.map(d => d.tahun_bulan),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: c1Data.map(d => d.total_trx),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.08)',
                borderWidth: 2,
                fill: true,
                tension: 0.35,
                pointRadius: 2,
                pointHoverRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { maxTicksLimit: 6, font: { size: 9 } } },
                y: { ticks: { font: { size: 9 }, callback: val => (val / 1000).toFixed(0) + 'K' } }
            }
        }
    });

    // 2. PERBANDINGAN NILAI TRANSAKSI (YoY Grouped Column)
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
    const c2_2024 = @json($chart2_2024);
    const c2_2025 = @json($chart2_2025);
    new Chart(document.getElementById('chart2_canvas'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: '2024',
                    data: c2_2024,
                    backgroundColor: '#38bdf8',
                    borderRadius: 3
                },
                {
                    label: '2025',
                    data: c2_2025,
                    backgroundColor: '#10b981',
                    borderRadius: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 8, font: { size: 9 } } }
            },
            scales: {
                x: { ticks: { font: { size: 8 } } },
                y: { ticks: { font: { size: 8 }, callback: val => val >= 1000 ? (val/1000).toFixed(1) + 'T' : val + 'M' } }
            }
        }
    });

    // 3. KONTRIBUSI PLATFORM E-COMMERCE (Donut Chart)
    const c3Data = @json($chart3_platform);
    new Chart(document.getElementById('chart3_canvas'), {
        type: 'doughnut',
        data: {
            labels: c3Data.map(d => d.platform_ecommerce),
            datasets: [{
                data: c3Data.map(d => d.gmv),
                backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6', '#06b6d4'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 7, font: { size: 8 } } }
            }
        }
    });

    // 4. TOP 10 KATEGORI PRODUK (Horizontal Bar)
    const c4Data = @json($chart4_category);
    new Chart(document.getElementById('chart4_canvas'), {
        type: 'bar',
        data: {
            labels: c4Data.map(d => d.kategori_produk),
            datasets: [{
                data: c4Data.map(d => d.gmv / 1000000000), // in Miliar
                backgroundColor: '#8b5cf6',
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { font: { size: 8 }, callback: val => val >= 1000 ? (val/1000).toFixed(1) + 'T' : val + 'M' } },
                y: { ticks: { font: { size: 8 } } }
            }
        }
    });

    // 5. DISTRIBUSI HARGA PRODUK (Histogram / Bar)
    const c5Data = @json($chart5_data);
    new Chart(document.getElementById('chart5_canvas'), {
        type: 'bar',
        data: {
            labels: c5Data.map(d => d.rentang),
            datasets: [{
                data: c5Data.map(d => d.count_trx),
                backgroundColor: '#2563eb',
                borderRadius: 3,
                barPercentage: 0.95,
                categoryPercentage: 0.95
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { font: { size: 8 } } },
                y: { ticks: { font: { size: 8 }, callback: val => (val / 1000).toFixed(0) + 'K' } }
            }
        }
    });

    // 6. POLA TRANSAKSI PER JAM (Area Chart)
    const c6Data = @json($chart6_hourly);
    new Chart(document.getElementById('chart6_canvas'), {
        type: 'line',
        data: {
            labels: c6Data.map(d => String(d.jam).padStart(2, '0')),
            datasets: [{
                label: 'Transaksi',
                data: c6Data.map(d => d.total_trx),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.18)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { maxTicksLimit: 8, font: { size: 8 } } },
                y: { ticks: { font: { size: 8 }, callback: val => (val / 1000).toFixed(0) + 'K' } }
            }
        }
    });

    // 7. PERFORMA HARI DALAM SEMINGGU (Bar Chart)
    const c7Data = @json($chart7_dow);
    new Chart(document.getElementById('chart7_canvas'), {
        type: 'bar',
        data: {
            labels: c7Data.map(d => d.hari),
            datasets: [{
                data: c7Data.map(d => d.trx),
                backgroundColor: '#10b981',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { font: { size: 8 } } },
                y: { ticks: { font: { size: 8 }, callback: val => (val / 1000).toFixed(0) + 'K' } }
            }
        }
    });

    // 8. PETA KEPADATAN TRANSAKSI (Leaflet Mini Choropleth)
    const c8MapData = @json($chart8_map);
    const mapByKode = {};
    c8MapData.forEach(p => {
        mapByKode[String(p.kode_bps)] = p;
    });

    const map8 = L.map('chart8_map', {
        zoomControl: false,
        attributionControl: false,
        dragging: false,
        scrollWheelZoom: false,
        doubleClickZoom: false
    }).setView([-2.5, 118], 4);

    fetch('/api/spasial/geojson')
        .then(res => res.json())
        .then(geojson => {
            L.geoJSON(geojson, {
                style: function (feature) {
                    const kode = String(feature.properties.kode_bps);
                    const item = mapByKode[kode];
                    const gmv = item ? item.gmv : 0;
                    let fill = '#cbd5e1';
                    if (gmv > 500000000000) fill = '#1e3a8a';
                    else if (gmv > 200000000000) fill = '#2563eb';
                    else if (gmv > 100000000000) fill = '#60a5fa';
                    else if (gmv > 0) fill = '#93c5fd';
                    return {
                        fillColor: fill,
                        weight: 0.7,
                        color: '#ffffff',
                        fillOpacity: 0.85
                    };
                }
            }).addTo(map8);
        })
        .catch(e => console.log('Map 8 geojson error:', e));

    // 9. TOP 10 PROVINSI (Column Chart)
    const c9Data = @json($chart9_topProv);
    new Chart(document.getElementById('chart9_canvas'), {
        type: 'bar',
        data: {
            labels: c9Data.map(d => d.short_name || d.provinsi),
            datasets: [{
                data: c9Data.map(d => d.gmv / 1000000000), // in Miliar
                backgroundColor: '#2563eb',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { font: { size: 8 } } },
                y: { ticks: { font: { size: 8 }, callback: val => val >= 1000 ? (val/1000).toFixed(1) + 'T' : val + 'M' } }
            }
        }
    });

    // 10. PROPORSI PENGIRIMAN TEPAT WAKTU (Donut Chart)
    const c10Data = @json($chart10_onTime);
    new Chart(document.getElementById('chart10_canvas'), {
        type: 'doughnut',
        data: {
            labels: ['Tepat Waktu', 'Terlambat'],
            datasets: [{
                data: [c10Data.onTimePct, c10Data.latePct],
                backgroundColor: ['#0284c7', '#e2e8f0'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '76%',
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 7, font: { size: 8 } } }
            }
        }
    });

    // 11. RATA-RATA DURASI PENGIRIMAN (Bar Chart)
    const c11Data = @json($chart11_durasi);
    new Chart(document.getElementById('chart11_canvas'), {
        type: 'bar',
        data: {
            labels: c11Data.map(d => d.short_name || d.provinsi),
            datasets: [{
                data: c11Data.map(d => d.avg_hari),
                backgroundColor: '#f97316',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { font: { size: 8 } } },
                y: { ticks: { font: { size: 8 }, callback: val => val + ' Hari' } }
            }
        }
    });

    // 12. METODE PEMBAYARAN (Donut Chart)
    const c12Data = @json($chart12_payment);
    new Chart(document.getElementById('chart12_canvas'), {
        type: 'doughnut',
        data: {
            labels: c12Data.map(d => d.metode_pembayaran),
            datasets: [{
                data: c12Data.map(d => d.total_trx),
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
                legend: { position: 'bottom', labels: { boxWidth: 7, font: { size: 8 } } }
            }
        }
    });

    // 13. NILAI DISKON PER PLATFORM (Column Chart)
    const c13Data = @json($chart13_diskonPlatform);
    new Chart(document.getElementById('chart13_canvas'), {
        type: 'bar',
        data: {
            labels: c13Data.map(d => d.platform_ecommerce),
            datasets: [{
                data: c13Data.map(d => d.total_diskon / 1000000000), // in Miliar
                backgroundColor: '#6366f1',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { font: { size: 7.5 } } },
                y: { ticks: { font: { size: 8 }, callback: val => val + ' M' } }
            }
        }
    });

    // 14. RASIO DISKON TERHADAP BRUTO (Line Chart)
    const c14Data = @json($chart14_rasioDiskon);
    new Chart(document.getElementById('chart14_canvas'), {
        type: 'line',
        data: {
            labels: c14Data.map(d => d.tahun_bulan),
            datasets: [{
                data: c14Data.map(d => d.rasio_pct),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 2.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { maxTicksLimit: 6, font: { size: 8 } } },
                y: { ticks: { font: { size: 8 }, callback: val => val + '%' } }
            }
        }
    });

    // 15. CUSTOMER REPEAT ORDER RATE (Gauge Half-Donut)
    const repeatRate = {{ $chart15_repeatRatePct }};
    new Chart(document.getElementById('chart15_canvas'), {
        type: 'doughnut',
        data: {
            labels: ['Repeat', 'First-time'],
            datasets: [{
                data: [repeatRate, 100 - repeatRate],
                backgroundColor: ['#10b981', '#f1f5f9'],
                borderWidth: 0,
                circumference: 180,
                rotation: -90
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '78%',
            plugins: { legend: { display: false } }
        }
    });

    // 16. DISTRIBUSI USIA PEMBELI (Bar Chart)
    const c16Data = @json($chart16_usia);
    new Chart(document.getElementById('chart16_canvas'), {
        type: 'bar',
        data: {
            labels: c16Data.map(d => d.kelompok),
            datasets: [{
                data: c16Data.map(d => d.count),
                backgroundColor: '#3b82f6',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { font: { size: 8 } } },
                y: { ticks: { font: { size: 8 }, callback: val => (val / 1000).toFixed(0) + 'K' } }
            }
        }
    });

    // 17. DISTRIBUSI GENDER PEMBELI (Pie Chart)
    const c17Data = @json($chart17_gender);
    new Chart(document.getElementById('chart17_canvas'), {
        type: 'pie',
        data: {
            labels: ['Perempuan', 'Laki-laki'],
            datasets: [{
                data: [c17Data.femalePct, c17Data.malePct],
                backgroundColor: ['#2563eb', '#38bdf8'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 8, font: { size: 8 } } }
            }
        }
    });

    // 18. KORELASI DISKON VS NILAI TRANSAKSI (Scatter Plot)
    const c18Data = @json($chart18_scatter);
    new Chart(document.getElementById('chart18_canvas'), {
        type: 'scatter',
        data: {
            datasets: [{
                label: 'Transaksi',
                data: c18Data.map(d => ({ x: Number(d.x), y: Number(d.y) })),
                backgroundColor: 'rgba(37, 99, 235, 0.65)',
                pointRadius: 2.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { font: { size: 8 }, callback: val => (val / 1000).toFixed(0) + 'K' } },
                y: { ticks: { font: { size: 8 }, callback: val => (val / 1000000).toFixed(1) + 'JT' } }
            }
        }
    });

    // 20. INDIKATOR BPS (DAYA BELI) (Multi Line Chart)
    const c20Data = @json($chart20_bps);
    new Chart(document.getElementById('chart20_canvas'), {
        type: 'line',
        data: {
            labels: c20Data.map(d => d.tahun),
            datasets: [
                {
                    label: 'Pengeluaran Kapita',
                    data: c20Data.map(d => d.avg_kapita),
                    borderColor: '#0284c7',
                    borderWidth: 1.8,
                    pointRadius: 2,
                    tension: 0.3
                },
                {
                    label: 'Pengeluaran Makanan',
                    data: c20Data.map(d => d.avg_makanan),
                    borderColor: '#f97316',
                    borderWidth: 1.8,
                    pointRadius: 2,
                    tension: 0.3
                },
                {
                    label: 'Non Makanan',
                    data: c20Data.map(d => d.avg_non_makanan),
                    borderColor: '#8b5cf6',
                    borderWidth: 1.8,
                    pointRadius: 2,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 7, font: { size: 7.5 } } }
            },
            scales: {
                x: { ticks: { font: { size: 8 } } },
                y: { ticks: { font: { size: 8 }, callback: val => (val / 1000000).toFixed(1) + 'JT' } }
            }
        }
    });
});
</script>
@endpush
