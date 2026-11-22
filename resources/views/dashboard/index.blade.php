@extends('layouts.app')

@section('title', 'Dashboard Utama')
@section('header_title', 'Dashboard Utama')

@section('navbar_filters')
    <form method="GET" action="{{ route('dashboard.index') }}" id="filterForm" class="flex items-center space-x-2.5">
        <!-- Filter 1: Periode Analisis -->
        <div class="relative flex items-center">
            <div class="absolute left-3 text-slate-400 pointer-events-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <select name="periode" onchange="document.getElementById('filterForm').submit()" 
                    class="bg-white border border-slate-200/90 hover:border-slate-300 text-slate-700 text-xs font-semibold rounded-xl pl-9 pr-8 py-2 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow-sm transition-all cursor-pointer">
                <option value="all" {{ $selectedPeriod === 'all' ? 'selected' : '' }}>Periode: Semua (2024–2026)</option>
                <option value="2024" {{ $selectedPeriod === '2024' ? 'selected' : '' }}>Periode: Jan 2024 - Des 2024</option>
                <option value="2025" {{ $selectedPeriod === '2025' ? 'selected' : '' }}>Periode: Jan 2025 - Des 2025</option>
                <option value="2026" {{ $selectedPeriod === '2026' ? 'selected' : '' }}>Periode: Jan 2026 - Okt 2026</option>
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
            <select name="provinsi" onchange="document.getElementById('filterForm').submit()" 
                    class="bg-white border border-slate-200/90 hover:border-slate-300 text-slate-700 text-xs font-semibold rounded-xl pl-9 pr-8 py-2 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow-sm transition-all cursor-pointer max-w-[210px] truncate">
                <option value="all" {{ $selectedProv === 'all' ? 'selected' : '' }}>Wilayah: Indonesia (Semua Provinsi)</option>
                @foreach($allProvinces as $prov)
                    <option value="{{ $prov }}" {{ $selectedProv === $prov ? 'selected' : '' }}>Wilayah: {{ $prov }}</option>
                @endforeach
            </select>
            <div class="absolute right-2.5 text-slate-400 pointer-events-none">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>

        @if($selectedPeriod !== 'all' || $selectedProv !== 'all')
            <a href="{{ route('dashboard.index') }}" title="Reset Filter" class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
        @endif
    </form>
@endsection

@section('content')
    <!-- 5 TOP KPI CARDS (Matching Reference Image) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- KPI 1: TOTAL TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between"
             title="Sumber Kolom: order_id | Rumus: COUNT(order_id)">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-full bg-blue-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-blue-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">TOTAL TRANSAKSI</div>
                        <div class="text-xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            {{ number_format($totalTransaksi, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium">Transaksi</div>
                    </div>
                </div>
                <!-- Tooltip Info -->
                <div class="relative flex items-center group/tip cursor-help shrink-0 ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-64 p-2.5 bg-slate-900/95 backdrop-blur-sm text-white text-[11px] rounded-xl shadow-xl border border-slate-700/50 leading-relaxed">
                        <div class="font-bold text-blue-400 mb-1 flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 mr-1.5"></span>TOTAL TRANSAKSI
                        </div>
                        <p class="text-slate-300 mb-1.5">Jumlah keseluruhan transaksi valid yang terjadi pada periode analisis.</p>
                        <div class="pt-1.5 border-t border-slate-700/60 text-[10px] font-mono text-slate-400">
                            <div><strong class="text-slate-300">Sumber:</strong> order_id</div>
                            <div><strong class="text-slate-300">Rumus:</strong> COUNT(order_id)</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box "Apa artinya?" -->
            <div class="mt-3.5 p-2 rounded-xl bg-blue-50/60 border border-blue-100/70 text-[11px] text-slate-600 leading-tight">
                <span class="font-bold text-blue-600">Apa artinya?</span><br>
                Jumlah keseluruhan transaksi yang terjadi pada periode analisis.
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-xs font-semibold text-emerald-600">
                <span class="mr-1 text-[11px]">&#9650;</span> {{ $growthTrx }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 2: NILAI TRANSAKSI (NETTO) -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between"
             title="Sumber Kolom: nilai_transaksi_bersih_idr | Rumus: SUM(nilai_transaksi_bersih_idr)">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-full bg-emerald-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-emerald-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">NILAI TRANSAKSI (NETTO)</div>
                        <div class="text-xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            @if($totalGmvNetto >= 1000000000000)
                                Rp {{ number_format($totalGmvNetto / 1000000000000, 2, ',', '.') }} T
                            @else
                                Rp {{ number_format($totalGmvNetto / 1000000000, 2, ',', '.') }} M
                            @endif
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium">Nilai Transaksi Bersih</div>
                    </div>
                </div>
                <!-- Tooltip Info -->
                <div class="relative flex items-center group/tip cursor-help shrink-0 ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-64 p-2.5 bg-slate-900/95 backdrop-blur-sm text-white text-[11px] rounded-xl shadow-xl border border-slate-700/50 leading-relaxed">
                        <div class="font-bold text-emerald-400 mb-1 flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5"></span>NILAI TRANSAKSI (NETTO)
                        </div>
                        <p class="text-slate-300 mb-1.5">Total nilai transaksi setelah dikurangi diskon, voucher, dan retur.</p>
                        <div class="pt-1.5 border-t border-slate-700/60 text-[10px] font-mono text-slate-400">
                            <div><strong class="text-slate-300">Sumber:</strong> nilai_transaksi_bersih_idr</div>
                            <div><strong class="text-slate-300">Rumus:</strong> SUM(nilai_transaksi_bersih_idr)</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box "Apa artinya?" -->
            <div class="mt-3.5 p-2 rounded-xl bg-emerald-50/60 border border-emerald-100/70 text-[11px] text-slate-600 leading-tight">
                <span class="font-bold text-emerald-600">Apa artinya?</span><br>
                Total nilai transaksi setelah dikurangi diskon, voucher, dan retur.
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-xs font-semibold text-emerald-600">
                <span class="mr-1 text-[11px]">&#9650;</span> {{ $growthGmv }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 3: RATA-RATA NILAI TRANSAKSI -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between"
             title="Sumber: nilai_transaksi_bersih_idr / order_id | Rumus: SUM(total_netto_idr) / SUM(total_transaksi)">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-full bg-purple-600 flex items-center justify-center text-white shrink-0 shadow-sm shadow-purple-600/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">RATA-RATA NILAI TRANSAKSI</div>
                        <div class="text-xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            Rp {{ number_format($avgAov, 0, ',', '.') }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium">Per Transaksi</div>
                    </div>
                </div>
                <!-- Tooltip Info -->
                <div class="relative flex items-center group/tip cursor-help shrink-0 ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-64 p-2.5 bg-slate-900/95 backdrop-blur-sm text-white text-[11px] rounded-xl shadow-xl border border-slate-700/50 leading-relaxed">
                        <div class="font-bold text-purple-400 mb-1 flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-400 mr-1.5"></span>RATA-RATA NILAI TRANSAKSI
                        </div>
                        <p class="text-slate-300 mb-1.5">Rata-rata nilai yang dibelanjakan oleh konsumen per transaksi belanja online (Average Order Value).</p>
                        <div class="pt-1.5 border-t border-slate-700/60 text-[10px] font-mono text-slate-400">
                            <div><strong class="text-slate-300">Sumber:</strong> total_netto_idr, total_transaksi</div>
                            <div><strong class="text-slate-300">Rumus:</strong> SUM(total_netto) / SUM(total_trx)</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box "Apa artinya?" -->
            <div class="mt-3.5 p-2 rounded-xl bg-purple-50/60 border border-purple-100/70 text-[11px] text-slate-600 leading-tight">
                <span class="font-bold text-purple-600">Apa artinya?</span><br>
                Rata-rata nilai yang dibelanjakan oleh konsumen per transaksi.
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-xs font-semibold text-emerald-600">
                <span class="mr-1 text-[11px]">&#9650;</span> {{ $growthAov }}% <span class="text-slate-400 font-normal ml-1">dibanding periode sebelumnya</span>
            </div>
        </div>

        <!-- KPI 4: TOTAL DISKON VOUCHER [PERMINTAAN REVISI USER] -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between"
             title="Sumber Kolom: diskon_voucher_platform_idr | Rumus: SUM(diskon_voucher_platform_idr)">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-full bg-amber-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-amber-500/30">
                        <!-- Ticket Percent Icon -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">TOTAL DISKON VOUCHER</div>
                        <div class="text-xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            @if($totalDiskonVoucher >= 1000000000)
                                Rp {{ number_format($totalDiskonVoucher / 1000000000, 2, ',', '.') }} M
                            @else
                                Rp {{ number_format($totalDiskonVoucher, 0, ',', '.') }}
                            @endif
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium">Akumulasi Diskon</div>
                    </div>
                </div>
                <!-- Tooltip Info -->
                <div class="relative flex items-center group/tip cursor-help shrink-0 ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-64 p-2.5 bg-slate-900/95 backdrop-blur-sm text-white text-[11px] rounded-xl shadow-xl border border-slate-700/50 leading-relaxed">
                        <div class="font-bold text-amber-400 mb-1 flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 mr-1.5"></span>TOTAL DISKON VOUCHER
                        </div>
                        <p class="text-slate-300 mb-1.5">Total akumulasi diskon voucher yang diberikan platform pada periode analisis.</p>
                        <div class="pt-1.5 border-t border-slate-700/60 text-[10px] font-mono text-slate-400">
                            <div><strong class="text-slate-300">Sumber:</strong> diskon_voucher_platform_idr</div>
                            <div><strong class="text-slate-300">Rumus:</strong> SUM(diskon_voucher_platform_idr)</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box "Apa artinya?" -->
            <div class="mt-3.5 p-2 rounded-xl bg-amber-50/70 border border-amber-100/80 text-[11px] text-slate-600 leading-tight">
                <span class="font-bold text-amber-600">Apa artinya?</span><br>
                Total akumulasi diskon voucher yang diberikan platform pada periode analisis.
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-xs font-semibold text-amber-600">
                <span class="mr-1 text-[11px]">&#9650;</span> {{ $diskonRatio }}% <span class="text-slate-400 font-normal ml-1">rasio stimulus promosi</span>
            </div>
        </div>

        <!-- KPI 5: RATA-RATA DURASI PENGIRIMAN [PERMINTAAN REVISI USER] -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between"
             title="Sumber Kolom: durasi_pengiriman_hari | Rumus: AVG(durasi_pengiriman_hari)">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-3 min-w-0">
                    <div class="w-11 h-11 rounded-full bg-cyan-500 flex items-center justify-center text-white shrink-0 shadow-sm shadow-cyan-500/30">
                        <!-- Truck Icon -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">RATA-RATA DURASI PENGIRIMAN</div>
                        <div class="text-xl font-extrabold text-slate-900 leading-tight mt-0.5">
                            {{ number_format($avgDurasiKirim, 1, ',', '.') }} Hari
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium">Hari Pengiriman</div>
                    </div>
                </div>
                <!-- Tooltip Info -->
                <div class="relative flex items-center group/tip cursor-help shrink-0 ml-1">
                    <svg class="w-3.5 h-3.5 text-slate-300 hover:text-cyan-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div class="pointer-events-none opacity-0 group-hover/tip:opacity-100 transition-opacity absolute right-0 top-5 z-30 w-64 p-2.5 bg-slate-900/95 backdrop-blur-sm text-white text-[11px] rounded-xl shadow-xl border border-slate-700/50 leading-relaxed">
                        <div class="font-bold text-cyan-400 mb-1 flex items-center">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 mr-1.5"></span>RATA-RATA DURASI PENGIRIMAN
                        </div>
                        <p class="text-slate-300 mb-1.5">Rata-rata waktu yang dibutuhkan untuk menyelesaikan pengiriman transaksi.</p>
                        <div class="pt-1.5 border-t border-slate-700/60 text-[10px] font-mono text-slate-400">
                            <div><strong class="text-slate-300">Sumber:</strong> durasi_pengiriman_hari</div>
                            <div><strong class="text-slate-300">Rumus:</strong> AVG(durasi_pengiriman_hari)</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box "Apa artinya?" -->
            <div class="mt-3.5 p-2 rounded-xl bg-cyan-50/70 border border-cyan-100/80 text-[11px] text-slate-600 leading-tight">
                <span class="font-bold text-cyan-600">Apa artinya?</span><br>
                Rata-rata waktu yang dibutuhkan untuk menyelesaikan pengiriman transaksi.
            </div>

            <div class="mt-3 pt-2 border-t border-slate-100 flex items-center text-xs font-semibold text-teal-600">
                <span class="mr-1 text-[11px]">&#10004;</span> {{ $onTimePct }}% <span class="text-slate-400 font-normal ml-1">terkirim tepat waktu</span>
            </div>
        </div>
    </div>

    <!-- ROW 2: 3 CHARTS (Matching Reference Image) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Chart 1: Tren Nilai Transaksi (Netto) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm">Tren Nilai Transaksi (Netto)</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Periode Jan 2024 - Des 2024</p>
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
            <div class="mt-4 p-3 rounded-xl bg-blue-50/60 border border-blue-100/80 flex items-start space-x-2.5 text-xs text-slate-700">
                <div class="p-1 rounded-lg bg-blue-500/10 text-blue-600 mt-0.5 shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <p class="leading-relaxed">
                    <strong>Insight:</strong> Nilai transaksi menunjukkan tren meningkat dengan pertumbuhan tertinggi di periode akhir tahun.
                </p>
            </div>
        </div>

        <!-- Chart 2: Nilai Transaksi per Provinsi (Top 10) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="mb-3">
                    <h3 class="font-bold text-slate-900 text-sm">Nilai Transaksi per Provinsi</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Top 10 Provinsi</p>
                </div>
                <div class="h-56 w-full">
                    <canvas id="provinsiBarChart"></canvas>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-4 p-3 rounded-xl bg-blue-50/60 border border-blue-100/80 flex items-start space-x-2.5 text-xs text-slate-700">
                <p class="leading-relaxed">
                    <strong>Insight:</strong> Jawa Barat menjadi provinsi dengan nilai transaksi digital tertinggi.
                </p>
            </div>
        </div>

        <!-- Chart 3: Sebaran Nilai Transaksi di Indonesia (Map) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="mb-3">
                    <h3 class="font-bold text-slate-900 text-sm">Sebaran Nilai Transaksi di Indonesia</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Berdasarkan Provinsi</p>
                </div>
                <!-- Interactive Leaflet Map with Light Theme -->
                <div id="sebaranMap" class="h-48 w-full rounded-xl overflow-hidden border border-slate-200 z-10"></div>
                <!-- Legend Gradient Bar -->
                <div class="mt-2.5 flex items-center justify-between text-[10px] text-slate-500">
                    <span>Rendah</span>
                    <div class="h-2 w-36 rounded-full bg-gradient-to-r from-blue-100 via-blue-400 to-blue-700 mx-2"></div>
                    <span>Tinggi</span>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-3 p-3 rounded-xl bg-blue-50/60 border border-blue-100/80 flex items-start space-x-2.5 text-xs text-slate-700">
                <p class="leading-relaxed">
                    <strong>Insight:</strong> Transaksi digital terkonsentrasi di Pulau Jawa dan kota-kota besar.
                </p>
            </div>
        </div>
    </div>

    <!-- ROW 3: 3 CARDS (Matching Reference Image) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Card 1: Kategori Produk Terlaris -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="mb-3">
                    <h3 class="font-bold text-slate-900 text-sm">Kategori Produk Terlaris</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">7 Kategori Produk UMKM</p>
                </div>
                <div class="grid grid-cols-12 gap-2 items-center my-2">
                    <div class="col-span-5 h-44 relative flex items-center justify-center">
                        <canvas id="kategoriDonutChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-[9px] text-slate-400 uppercase font-semibold">Total Item</span>
                            <span class="text-xs font-bold text-slate-800">{{ number_format($totalCategoryQty / 1000, 0) }}k</span>
                        </div>
                    </div>
                    <div class="col-span-7 space-y-1 text-[11px] pl-2 max-h-48 overflow-y-auto">
                        @php
                            $catColors = ['#2563eb', '#0284c7', '#0d9488', '#10b981', '#f59e0b', '#f97316', '#64748b'];
                        @endphp
                        @foreach($categoryBreakdown as $idx => $cat)
                            <div class="flex items-center justify-between text-slate-600">
                                <div class="flex items-center space-x-1.5 truncate">
                                    <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $catColors[$idx % count($catColors)] }}"></span>
                                    <span class="truncate">{{ $cat->kategori_produk }}</span>
                                </div>
                                <span class="font-semibold text-slate-800 ml-1">
                                    {{ number_format(($cat->qty / max(1, $totalCategoryQty)) * 100, 1) }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-3 p-3 rounded-xl bg-blue-50/60 border border-blue-100/80 text-xs text-slate-700">
                <strong>Insight:</strong> Kategori Fashion, Kuliner, dan Kerajinan mendominasi penjualan produk UMKM.
            </div>
        </div>

        <!-- Card 2: Metode Pembayaran -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="mb-3">
                    <h3 class="font-bold text-slate-900 text-sm">Metode Pembayaran</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Distribusi Penggunaan</p>
                </div>
                <div class="grid grid-cols-12 gap-2 items-center my-2">
                    <div class="col-span-5 h-44 relative flex items-center justify-center">
                        <canvas id="paymentDonutChart"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-[9px] text-slate-400 uppercase font-semibold">Total Order</span>
                            <span class="text-xs font-bold text-slate-800">{{ number_format($totalPaymentTrx / 1000, 0) }}k</span>
                        </div>
                    </div>
                    <div class="col-span-7 space-y-1.5 text-[11px] pl-2">
                        @php
                            $payColors = ['#3b82f6', '#06b6d4', '#f59e0b', '#8b5cf6', '#64748b'];
                        @endphp
                        @foreach($paymentBreakdown as $idx => $pay)
                            <div class="flex items-center justify-between text-slate-600">
                                <div class="flex items-center space-x-1.5 truncate">
                                    <span class="w-2 h-2 rounded-full shrink-0" style="background-color: {{ $payColors[$idx % count($payColors)] }}"></span>
                                    <span class="truncate">{{ $pay->metode_pembayaran }}</span>
                                </div>
                                <span class="font-semibold text-slate-800 ml-1">
                                    {{ number_format(($pay->total_trx / max(1, $totalPaymentTrx)) * 100, 1) }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-3 p-3 rounded-xl bg-blue-50/60 border border-blue-100/80 text-xs text-slate-700">
                <strong>Insight:</strong> E-Wallet dan QRIS mendominasi 57,7% kanal pembayaran utama konsumen.
            </div>
        </div>

        <!-- Card 3: Ringkasan Indikator Daya Beli (BPS) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col justify-between">
            <div>
                <div class="mb-3">
                    <h3 class="font-bold text-slate-900 text-sm">Ringkasan Indikator Daya Beli (BPS)</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Rata-rata Nasional Susenas</p>
                </div>
                <div class="space-y-2.5 my-2">
                    <!-- Row 1: Pengeluaran per Kapita -->
                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                        <div class="flex items-center space-x-2">
                            <span class="p-1 rounded-lg bg-blue-100 text-blue-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </span>
                            <div>
                                <div class="text-[11px] text-slate-500 font-medium">Pengeluaran per Kapita</div>
                                <div class="font-bold text-slate-900">Rp {{ number_format($bpsLatest->avg_total ?? 1589662, 0, ',', '.') }} / bulan</div>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-600 flex items-center">&#9650; 3,21%</span>
                    </div>

                    <!-- Row 2: Pengeluaran Makanan -->
                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                        <div class="flex items-center space-x-2">
                            <span class="p-1 rounded-lg bg-emerald-100 text-emerald-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z"></path></svg>
                            </span>
                            <div>
                                <div class="text-[11px] text-slate-500 font-medium">Pengeluaran Makanan</div>
                                <div class="font-bold text-slate-900">Rp {{ number_format($bpsLatest->avg_makanan ?? 796648, 0, ',', '.') }} / bulan</div>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-600 flex items-center">&#9650; 2,14%</span>
                    </div>

                    <!-- Row 3: Pengeluaran Non Makanan -->
                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                        <div class="flex items-center space-x-2">
                            <span class="p-1 rounded-lg bg-purple-100 text-purple-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </span>
                            <div>
                                <div class="text-[11px] text-slate-500 font-medium">Pengeluaran Non Makanan</div>
                                <div class="font-bold text-slate-900">Rp {{ number_format($bpsLatest->avg_non_makanan ?? 793014, 0, ',', '.') }} / bulan</div>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-600 flex items-center">&#9650; 3,98%</span>
                    </div>

                    <!-- Row 4: Indeks Daya Beli BPS -->
                    <div class="flex items-center justify-between p-2 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                        <div class="flex items-center space-x-2">
                            <span class="p-1 rounded-lg bg-amber-100 text-amber-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </span>
                            <div>
                                <div class="text-[11px] text-slate-500 font-medium">Indeks Daya Beli BPS</div>
                                <div class="font-bold text-slate-900">104,38 poin</div>
                            </div>
                        </div>
                        <span class="text-[11px] font-bold text-emerald-600 flex items-center">&#9650; 2,87%</span>
                    </div>
                </div>
            </div>

            <!-- Insight Box -->
            <div class="mt-3 p-3 rounded-xl bg-blue-50/60 border border-blue-100/80 text-xs text-slate-700">
                <strong>Insight:</strong> Daya beli masyarakat menunjukkan tren positif di sebagian besar indikator ekonomi riil BPS.
            </div>
        </div>
    </div>

    <!-- ROW 4: INSIGHT UTAMA PERIODE (Bottom Summary Bar Matching Reference Image) -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Main Green Badge -->
        <div class="flex items-center space-x-3 shrink-0">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-md shadow-emerald-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-slate-900">Insight Utama Periode</h4>
                <p class="text-[10px] text-slate-400">Jan 2024 - Des 2024</p>
            </div>
        </div>

        <!-- 5 Blocks -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 w-full text-[11px] text-slate-600">
            <div class="flex items-start space-x-2">
                <span class="text-emerald-600 font-bold mt-0.5">&#10003;</span>
                <p class="leading-tight">Nilai transaksi meningkat <strong>15,32%</strong> dibanding periode sebelumnya.</p>
            </div>

            <div class="flex items-start space-x-2">
                <span class="text-blue-500 mt-0.5">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                </span>
                <p class="leading-tight">Provinsi <strong>Jawa Barat</strong> menjadi penyumbang nilai transaksi tertinggi.</p>
            </div>

            <div class="flex items-start space-x-2">
                <span class="text-purple-500 mt-0.5">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
                </span>
                <p class="leading-tight">Metode pembayaran digital <strong>(E-Wallet & QRIS)</strong> mendominasi transaksi.</p>
            </div>

            <div class="flex items-start space-x-2">
                <span class="text-amber-500 mt-0.5">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                </span>
                <p class="leading-tight">Kategori <strong>Fashion & Kuliner</strong> menjadi kontributor produk terlaris.</p>
            </div>

            <div class="flex items-start space-x-2">
                <span class="text-teal-500 mt-0.5">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                </span>
                <p class="leading-tight">Indeks daya beli nasional menunjukkan <strong>tren positif</strong> sebesar 2,87%.</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#64748b';
        Chart.defaults.borderColor = '#f1f5f9';

        // 1. Line Chart: Tren Nilai Transaksi (Netto)
        const trendData = @json($monthlyTrend);
        const labels = trendData.map(d => {
            const parts = d.tahun_bulan.split('-');
            const months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            return months[parseInt(parts[1])] + ' ' + parts[0];
        });
        const gmvValues = trendData.map(d => (d.total_netto / 1000000000).toFixed(0)); // in Miliar

        new Chart(document.getElementById('trenNettoChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nilai Transaksi (Miliar Rp)',
                    data: gmvValues,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.08)',
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ` Rp ${parseInt(ctx.raw).toLocaleString('id-ID')} Miliar`
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                    y: { 
                        ticks: { 
                            callback: (v) => v >= 1000 ? (v/1000).toFixed(1) + ' T' : v + ' M',
                            font: { size: 10 }
                        } 
                    }
                }
            }
        });

        // 2. Horizontal Bar Chart: Nilai Transaksi per Provinsi
        const topProvData = @json($topProvinces);
        new Chart(document.getElementById('provinsiBarChart'), {
            type: 'bar',
            data: {
                labels: topProvData.map(d => d.provinsi),
                datasets: [{
                    label: 'Nilai Transaksi',
                    data: topProvData.map(d => (d.gmv / 1000000000).toFixed(0)),
                    backgroundColor: '#3b82f6',
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
                            label: (ctx) => ` Rp ${parseInt(ctx.raw).toLocaleString('id-ID')} Miliar`
                        }
                    }
                },
                scales: {
                    x: { 
                        grid: { color: '#f1f5f9' },
                        ticks: { 
                            callback: (v) => v >= 1000 ? (v/1000).toFixed(1) + ' T' : v + ' M',
                            font: { size: 10 }
                        } 
                    },
                    y: { grid: { display: false }, ticks: { font: { size: 10 } } }
                }
            }
        });

        // 3. Leaflet Map of Indonesia with Choropleth Polygons
        const mapData = @json($mapPoints);
        const mapByKode = {};
        let maxGmv = 1;
        mapData.forEach(p => {
            mapByKode[String(p.kode_bps)] = p;
            if (p.ecom_total_netto_idr > maxGmv) maxGmv = p.ecom_total_netto_idr;
        });

        const map = L.map('sebaranMap', {
            zoomControl: false,
            attributionControl: false
        }).setView([-2.2, 118.0], 4.5);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 18
        }).addTo(map);

        function getChoroplethColor(gmv) {
            if (!gmv || gmv <= 0) return '#cbd5e1';
            const ratio = gmv / maxGmv;
            if (ratio > 0.6) return '#1e40af';
            if (ratio > 0.3) return '#2563eb';
            if (ratio > 0.1) return '#60a5fa';
            if (ratio > 0.03) return '#93c5fd';
            return '#dbeafe';
        }

        fetch('/geojson/indonesia-38-provinces.geojson')
            .then(res => res.json())
            .then(geo => {
                L.geoJSON(geo, {
                    style: function(feature) {
                        const kode = String(feature.properties.kode_bps);
                        const p = mapByKode[kode];
                        return {
                            fillColor: getChoroplethColor(p ? p.ecom_total_netto_idr : 0),
                            weight: 1,
                            opacity: 1,
                            color: '#ffffff',
                            fillOpacity: 0.8
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const kode = String(feature.properties.kode_bps);
                        const p = mapByKode[kode];
                        const name = feature.properties.provinsi || (p ? p.provinsi : 'Provinsi');
                        if (p) {
                            layer.bindTooltip(`<strong>${name}</strong><br>GMV: Rp ${(p.ecom_total_netto_idr / 1000000000).toFixed(1)} Miliar`, { sticky: true });
                        }
                    }
                }).addTo(map);
            })
            .catch(() => {
                mapData.forEach(p => {
                    const radius = Math.max(5, Math.min(18, Math.sqrt(p.ecom_total_transaksi) / 12));
                    L.circleMarker([p.latitude, p.longitude], {
                        radius: radius,
                        fillColor: '#2563eb',
                        color: '#ffffff',
                        weight: 1.5,
                        opacity: 1,
                        fillOpacity: 0.65
                    }).addTo(map);
                });
            });

        // 4. Donut Chart: Kategori Produk
        const catData = @json($categoryBreakdown);
        new Chart(document.getElementById('kategoriDonutChart'), {
            type: 'doughnut',
            data: {
                labels: catData.map(d => d.kategori_produk),
                datasets: [{
                    data: catData.map(d => d.qty),
                    backgroundColor: ['#2563eb', '#0284c7', '#0d9488', '#10b981', '#f59e0b', '#f97316', '#64748b'],
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

        // 5. Donut Chart: Metode Pembayaran
        const payData = @json($paymentBreakdown);
        new Chart(document.getElementById('paymentDonutChart'), {
            type: 'doughnut',
            data: {
                labels: payData.map(d => d.metode_pembayaran),
                datasets: [{
                    data: payData.map(d => d.total_trx),
                    backgroundColor: ['#3b82f6', '#06b6d4', '#f59e0b', '#8b5cf6', '#64748b'],
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
