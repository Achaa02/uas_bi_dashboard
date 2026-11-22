@extends('layouts.app')

@section('title', 'Pola Konsumsi Digital')
@section('header_title', 'Analisis Pola Konsumsi & Perilaku Belanja Digital')

@section('content')
    <!-- Filter Bar -->
    <div class="bg-slate-900/90 p-4 rounded-xl border border-slate-800 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center space-x-2 text-sm text-slate-400">
            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            <span class="font-semibold text-slate-200">Filter Analisis Konsumsi:</span>
        </div>

        <form method="GET" action="{{ route('dashboard.pola-konsumsi') }}" class="flex flex-wrap items-center gap-3 text-sm">
            <div class="flex items-center space-x-2">
                <label for="tahun" class="text-xs text-slate-400">Tahun:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()" class="bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:border-cyan-500">
                    <option value="all" {{ $selectedYear === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <label for="kategori" class="text-xs text-slate-400">Kategori:</label>
                <select name="kategori" id="kategori" onchange="this.form.submit()" class="bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:border-cyan-500">
                    <option value="all" {{ $selectedKategori === 'all' ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach($availableCategories as $cat)
                        <option value="{{ $cat }}" {{ $selectedKategori == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <label for="platform" class="text-xs text-slate-400">Platform:</label>
                <select name="platform" id="platform" onchange="this.form.submit()" class="bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:border-cyan-500">
                    <option value="all" {{ $selectedPlatform === 'all' ? 'selected' : '' }}>Semua Platform</option>
                    @foreach($availablePlatforms as $plat)
                        <option value="{{ $plat }}" {{ $selectedPlatform == $plat ? 'selected' : '' }}>{{ $plat }}</option>
                    @endforeach
                </select>
            </div>

            @if($selectedYear !== 'all' || $selectedKategori !== 'all' || $selectedPlatform !== 'all')
                <a href="{{ route('dashboard.pola-konsumsi') }}" class="text-xs text-rose-400 hover:text-rose-300 underline ml-2">Reset</a>
            @endif
        </form>
    </div>

    <!-- 1. Kinerja 7 Komoditas UMKM Matrix Table -->
    <div class="bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-white text-base">Matriks Kinerja 7 Komoditas Produk UMKM</h3>
                <p class="text-xs text-slate-400 mt-0.5">Analisis omset belanja netto, nilai keranjang, kepuasan pembeli, dan sensitivitas ongkos kirim</p>
            </div>
            <span class="text-xs text-cyan-400 font-medium px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20">
                Data Panel Agregat
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-950/60 text-xs uppercase font-semibold text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4">Kategori Produk</th>
                        <th class="py-3 px-4 text-right">Total GMV Netto</th>
                        <th class="py-3 px-4 text-right">Total Transaksi</th>
                        <th class="py-3 px-4 text-right">AOV (Keranjang)</th>
                        <th class="py-3 px-4 text-center">Rating</th>
                        <th class="py-3 px-4 text-center">Repeat Order</th>
                        <th class="py-3 px-4 text-center">Sensitivitas Ongkir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @foreach($kategoriStats as $k)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-3.5 px-4 font-semibold text-white flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                <span>{{ $k->kategori_produk }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-right font-bold text-cyan-400">
                                Rp {{ number_format($k->gmv, 0) }}
                            </td>
                            <td class="py-3.5 px-4 text-right text-slate-200">
                                {{ number_format($k->total_trx) }} trx
                            </td>
                            <td class="py-3.5 px-4 text-right font-medium text-emerald-400">
                                Rp {{ number_format($k->aov, 0) }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                    ★ {{ $k->rating }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="text-xs font-medium text-purple-400">{{ $k->repeat_rate }}%</span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="text-xs font-mono text-slate-400">{{ $k->ongkir_sens }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Charts Row: Metode Pembayaran FinTech & Logistik Kurir -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Metode Pembayaran Digital FinTech -->
        <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
            <h3 class="font-bold text-white text-base">Adopsi Instrumen Pembayaran Digital (FinTech)</h3>
            <p class="text-xs text-slate-400 mt-0.5 mb-4">Pangsa penggunaan QRIS, E-Wallet, Paylater/Cicilan, dan Virtual Account</p>
            <div class="h-64 flex items-center justify-center">
                <canvas id="paymentChart"></canvas>
            </div>
            <div class="mt-4 space-y-2 pt-3 border-t border-slate-800">
                @foreach($paymentStats as $pay)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-300">{{ $pay->metode_pembayaran }}</span>
                        <span class="font-semibold text-cyan-400">{{ number_format($pay->total_trx) }} transaksi</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Performa Jasa Logistik & Ekspedisi -->
        <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
            <h3 class="font-bold text-white text-base">Efisiensi Ekspedisi & Ketepatan Pengiriman</h3>
            <p class="text-xs text-slate-400 mt-0.5 mb-4">Rata-rata lama durasi pengiriman (hari) dan rasio ketepatan waktu kurir</p>
            <div class="h-64">
                <canvas id="logisticsChart"></canvas>
            </div>
            <div class="mt-4 space-y-2 pt-3 border-t border-slate-800">
                @foreach($logisticsStats as $log)
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-300 font-medium">{{ $log->layanan_ekspedisi }}</span>
                        <div class="space-x-3 text-right">
                            <span class="text-slate-400">{{ $log->avg_durasi }} hari</span>
                            <span class="font-semibold text-emerald-400">{{ $log->on_time_rate }}% On-Time</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 3. Dekomposisi Keuangan Transaksi: Diskon & Subsidi Ongkir -->
    <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
        <h3 class="font-bold text-white text-base">Dekomposisi Struktur Nilai Transaksi & Stimulus Promosi</h3>
        <p class="text-xs text-slate-400 mt-0.5 mb-6">Peranan voucher diskon platform dan subsidi gratis ongkir dalam membentuk nilai belanja akhir konsumen</p>

        @if($promoStats)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
                    <span class="text-xs text-slate-400 uppercase font-semibold">Total Nilai Bruto</span>
                    <div class="text-xl font-bold text-slate-200 mt-1">
                        Rp {{ number_format($promoStats->bruto / 1000000000, 2) }} M
                    </div>
                    <span class="text-[11px] text-slate-500">Harga murni barang sebelum potongan</span>
                </div>

                <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
                    <span class="text-xs text-slate-400 uppercase font-semibold">Voucher Diskon Platform</span>
                    <div class="text-xl font-bold text-rose-400 mt-1">
                        - Rp {{ number_format($promoStats->voucher / 1000000000, 2) }} M
                    </div>
                    <span class="text-[11px] text-rose-400/80">
                        {{ number_format(($promoStats->voucher / max(1, $promoStats->bruto)) * 100, 2) }}% dari Bruto
                    </span>
                </div>

                <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
                    <span class="text-xs text-slate-400 uppercase font-semibold">Subsidi Gratis Ongkir</span>
                    <div class="text-xl font-bold text-amber-400 mt-1">
                        - Rp {{ number_format($promoStats->subsidi_ongkir / 1000000000, 2) }} M
                    </div>
                    <span class="text-[11px] text-amber-400/80">
                        Ongkir Riil: Rp {{ number_format($promoStats->ongkir_riil / 1000000000, 2) }} M
                    </span>
                </div>

                <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
                    <span class="text-xs text-slate-400 uppercase font-semibold">Total Nilai Netto</span>
                    <div class="text-xl font-bold text-emerald-400 mt-1">
                        Rp {{ number_format($promoStats->netto / 1000000000, 2) }} M
                    </div>
                    <span class="text-[11px] text-emerald-400/80">Kas riil dibayar konsumen</span>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Payment FinTech Chart
        const paymentData = @json($paymentStats);
        new Chart(document.getElementById('paymentChart'), {
            type: 'doughnut',
            data: {
                labels: paymentData.map(d => d.metode_pembayaran),
                datasets: [{
                    data: paymentData.map(d => d.total_trx),
                    backgroundColor: ['#06b6d4', '#3b82f6', '#8b5cf6', '#ec4899', '#f59e0b'],
                    borderWidth: 2,
                    borderColor: '#0f172a'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
                }
            }
        });

        // Logistics Chart
        const logData = @json($logisticsStats);
        new Chart(document.getElementById('logisticsChart'), {
            type: 'bar',
            data: {
                labels: logData.map(d => d.layanan_ekspedisi),
                datasets: [
                    {
                        label: 'Rata-rata Durasi (Hari)',
                        data: logData.map(d => d.avg_durasi),
                        backgroundColor: '#38bdf8',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { title: { display: true, text: 'Hari Pengiriman' } }
                }
            }
        });
    });
</script>
@endpush
