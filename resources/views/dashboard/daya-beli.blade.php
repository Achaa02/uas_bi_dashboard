@extends('layouts.app')

@section('title', 'Pemetaan Daya Beli BPS')
@section('header_title', 'Integrasi Daya Beli BPS & Pola Konsumsi Digital')

@section('content')
    <!-- Filter Bar -->
    <div class="bg-slate-900/90 p-4 rounded-xl border border-slate-800 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center space-x-2 text-sm text-slate-400">
            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            <span class="font-semibold text-slate-200">Filter Analisis Daya Beli:</span>
        </div>

        <form method="GET" action="{{ route('dashboard.daya-beli') }}" class="flex flex-wrap items-center gap-3 text-sm">
            <div class="flex items-center space-x-2">
                <label for="tahun" class="text-xs text-slate-400">Tahun BPS & E-Commerce:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()" class="bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:border-cyan-500">
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <label for="pulau" class="text-xs text-slate-400">Gugus Wilayah:</label>
                <select name="pulau" id="pulau" onchange="this.form.submit()" class="bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:border-cyan-500">
                    <option value="all" {{ $selectedPulau === 'all' ? 'selected' : '' }}>Seluruh Indonesia (38 Provinsi)</option>
                    @foreach($availableIslands as $isl)
                        <option value="{{ $isl }}" {{ $selectedPulau == $isl ? 'selected' : '' }}>{{ $isl }}</option>
                    @endforeach
                </select>
            </div>

            @if($selectedPulau !== 'all')
                <a href="{{ route('dashboard.daya-beli', ['tahun' => $selectedYear]) }}" class="text-xs text-rose-400 hover:text-rose-300 underline ml-2">Reset Wilayah</a>
            @endif
        </form>
    </div>

    <!-- 4 KPI Cards: Statistik Makro BPS & E-Commerce -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800">
            <span class="text-xs text-slate-400 uppercase font-semibold">Pengeluaran Riil BPS Sebulan</span>
            <div class="text-2xl font-bold text-amber-400 mt-1">
                Rp {{ number_format($avgBpsTotal, 0) }}
            </div>
            <span class="text-xs text-slate-500">Rata-rata per kapita bulanan se-Indonesia</span>
        </div>

        <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800">
            <span class="text-xs text-slate-400 uppercase font-semibold">Alokasi Non-Makanan BPS</span>
            <div class="text-2xl font-bold text-emerald-400 mt-1">
                Rp {{ number_format($avgBpsNonMakanan, 0) }}
            </div>
            <span class="text-xs text-slate-500">Kapasitas belanja non-pangan bulanan</span>
        </div>

        <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800">
            <span class="text-xs text-slate-400 uppercase font-semibold">AOV Belanja Digital</span>
            <div class="text-2xl font-bold text-cyan-400 mt-1">
                Rp {{ number_format($avgAov, 0) }}
            </div>
            <span class="text-xs text-slate-500">Rata-rata keranjang pesanan e-commerce</span>
        </div>

        <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800">
            <span class="text-xs text-slate-400 uppercase font-semibold">Rasio AOV / Non-Makanan BPS</span>
            <div class="text-2xl font-bold text-purple-400 mt-1">
                {{ number_format($avgRasioAovNonMakanan * 100, 2) }}%
            </div>
            <span class="text-xs text-slate-500">Bobot keranjang digital terhadap non-pangan</span>
        </div>
    </div>

    <!-- 1. Interactive Bubble Chart: Korelasi BPS vs E-Commerce (Kuadran) -->
    <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold text-white text-base">Diagram Kuadran Integrasi: Pengeluaran BPS vs Nilai Keranjang Digital (AOV)</h3>
                <p class="text-xs text-slate-400 mt-0.5">Sumbu X: Rata-rata Pengeluaran BPS (Rp/bln) &bull; Sumbu Y: AOV E-Commerce (Rp/trx) &bull; Ukuran Bubble: Volume Transaksi</p>
            </div>
            <span class="text-xs px-3 py-1 rounded-full bg-slate-800 text-cyan-400 border border-slate-700">
                Tahun {{ $selectedYear }}
            </span>
        </div>

        <div class="h-96 w-full">
            <canvas id="quadrantBubbleChart"></canvas>
        </div>

        <div class="mt-4 pt-3 border-t border-slate-800 text-xs text-slate-400 flex flex-wrap items-center justify-between gap-2">
            <div>
                <span class="font-semibold text-slate-200">Keterangan Titik Pusat Kuadran:</span> Garis potong median memisahkan provinsi ke dalam 4 tipologi daya beli dan adopsi digital.
            </div>
            <div class="text-slate-500">
                Disparitas Pengeluaran BPS: <strong class="text-slate-300">{{ $disparitasBps }}x</strong> | Disparitas AOV Digital: <strong class="text-slate-300">{{ $disparitasEcom }}x</strong>
            </div>
        </div>
    </div>

    <!-- 2. Matriks 4 Kuadran Detail Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kuadran I -->
        <div class="bg-slate-900 p-5 rounded-2xl border border-emerald-500/30 bg-emerald-950/10">
            <div class="flex items-center space-x-2 text-emerald-400 font-bold text-sm mb-1">
                <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                <span>Kuadran I: Daya Beli Riil Tinggi & Belanja Digital Tinggi</span>
            </div>
            <p class="text-xs text-slate-400 mb-3">Wilayah dengan pengeluaran per kapita BPS di atas median nasional didukung perputaran transaksi e-commerce yang sangat masif.</p>
            <div class="flex flex-wrap gap-1.5">
                @forelse($kuadran1 as $item)
                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">
                        {{ $item->provinsi }} (Rp {{ number_format($item->total_pengeluaran_idr / 1000, 0) }}k)
                    </span>
                @empty
                    <span class="text-xs text-slate-500 italic">Tidak ada wilayah pada filter ini</span>
                @endforelse
            </div>
        </div>

        <!-- Kuadran II -->
        <div class="bg-slate-900 p-5 rounded-2xl border border-blue-500/30 bg-blue-950/10">
            <div class="flex items-center space-x-2 text-blue-400 font-bold text-sm mb-1">
                <span class="w-3 h-3 rounded-full bg-blue-400"></span>
                <span>Kuadran II: Daya Beli Riil Tinggi & Penetrasi Digital Moderat</span>
            </div>
            <p class="text-xs text-slate-400 mb-3">Wilayah dengan kapasitas ekonomi riil tinggi (didukung sektor tambang/industri), namun volume belanja online belum tergarap maksimal.</p>
            <div class="flex flex-wrap gap-1.5">
                @forelse($kuadran2 as $item)
                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-500/10 text-blue-300 border border-blue-500/20">
                        {{ $item->provinsi }} (Rp {{ number_format($item->total_pengeluaran_idr / 1000, 0) }}k)
                    </span>
                @empty
                    <span class="text-xs text-slate-500 italic">Tidak ada wilayah pada filter ini</span>
                @endforelse
            </div>
        </div>

        <!-- Kuadran III -->
        <div class="bg-slate-900 p-5 rounded-2xl border border-amber-500/30 bg-amber-950/10">
            <div class="flex items-center space-x-2 text-amber-400 font-bold text-sm mb-1">
                <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                <span>Kuadran III: Daya Beli Riil Menengah & Belanja Digital Dinamis</span>
            </div>
            <p class="text-xs text-slate-400 mb-3">Wilayah berpenghasilan moderat dengan literasi digital tinggi dan frekuensi belanja online aktif karena efisiensi logistik.</p>
            <div class="flex flex-wrap gap-1.5">
                @forelse($kuadran3 as $item)
                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-500/10 text-amber-300 border border-amber-500/20">
                        {{ $item->provinsi }} (Rp {{ number_format($item->total_pengeluaran_idr / 1000, 0) }}k)
                    </span>
                @empty
                    <span class="text-xs text-slate-500 italic">Tidak ada wilayah pada filter ini</span>
                @endforelse
            </div>
        </div>

        <!-- Kuadran IV -->
        <div class="bg-slate-900 p-5 rounded-2xl border border-rose-500/30 bg-rose-950/10">
            <div class="flex items-center space-x-2 text-rose-400 font-bold text-sm mb-1">
                <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                <span>Kuadran IV: Daya Beli Riil Berkembang & Penetrasi Digital Awal</span>
            </div>
            <p class="text-xs text-slate-400 mb-3">Wilayah berkembang yang masih menghadapi tantangan disparitas logistik, ongkos kirim tinggi, dan keterbatasan infrastruktur konektivitas.</p>
            <div class="flex flex-wrap gap-1.5">
                @forelse($kuadran4 as $item)
                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-rose-500/10 text-rose-300 border border-rose-500/20">
                        {{ $item->provinsi }} (Rp {{ number_format($item->total_pengeluaran_idr / 1000, 0) }}k)
                    </span>
                @empty
                    <span class="text-xs text-slate-500 italic">Tidak ada wilayah pada filter ini</span>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 3. Tabel Komparasi Panel Lengkap 38 Provinsi -->
    <div class="bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-white text-base">Tabel Terintegrasi Daya Beli BPS & E-Commerce (38 Provinsi)</h3>
                <p class="text-xs text-slate-400 mt-0.5">Data panel resmi BPS disandingkan dengan hasil agregasi 5 juta transaksi e-commerce</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-950/70 text-xs uppercase font-semibold text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4">Provinsi</th>
                        <th class="py-3 px-4">Pulau</th>
                        <th class="py-3 px-4 text-right">Pengeluaran BPS</th>
                        <th class="py-3 px-4 text-right">Non-Makanan BPS</th>
                        <th class="py-3 px-4 text-right">Volume E-Com</th>
                        <th class="py-3 px-4 text-right">AOV Keranjang</th>
                        <th class="py-3 px-4 text-right">Rasio AOV / Non-Makanan</th>
                        <th class="py-3 px-4 text-left">Tipologi Kuadran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @foreach($integratedData as $row)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-3 px-4 font-semibold text-white">{{ $row->provinsi }}</td>
                            <td class="py-3 px-4 text-xs text-slate-400">{{ $row->pulau }}</td>
                            <td class="py-3 px-4 text-right font-medium text-amber-400">
                                Rp {{ number_format($row->total_pengeluaran_idr, 0) }}
                            </td>
                            <td class="py-3 px-4 text-right text-slate-300">
                                Rp {{ number_format($row->pengeluaran_non_makanan_idr, 0) }}
                            </td>
                            <td class="py-3 px-4 text-right text-cyan-400 font-semibold">
                                {{ number_format($row->ecom_total_transaksi) }} trx
                            </td>
                            <td class="py-3 px-4 text-right text-emerald-400 font-medium">
                                Rp {{ number_format($row->ecom_aov_idr, 0) }}
                            </td>
                            <td class="py-3 px-4 text-right font-bold text-purple-400">
                                {{ number_format($row->rasio_aov_thd_non_makanan_bps * 100, 2) }}%
                            </td>
                            <td class="py-3 px-4 text-xs">
                                <span class="px-2 py-0.5 rounded text-[11px] font-semibold {{ str_contains($row->tipologi_daya_beli_digital, 'Kuadran I') ? 'bg-emerald-500/10 text-emerald-400' : (str_contains($row->tipologi_daya_beli_digital, 'Kuadran II') ? 'bg-blue-500/10 text-blue-400' : (str_contains($row->tipologi_daya_beli_digital, 'Kuadran III') ? 'bg-amber-500/10 text-amber-400' : 'bg-rose-500/10 text-rose-400')) }}">
                                    {{ explode(':', $row->tipologi_daya_beli_digital)[0] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scatterPoints = @json($scatterPoints);

        new Chart(document.getElementById('quadrantBubbleChart'), {
            type: 'bubble',
            data: {
                datasets: [{
                    label: 'Provinsi di Indonesia',
                    data: scatterPoints,
                    backgroundColor: function(context) {
                        const tip = context.raw?.tipologi || '';
                        if (tip.includes('Kuadran I')) return 'rgba(16, 185, 129, 0.7)';
                        if (tip.includes('Kuadran II')) return 'rgba(59, 130, 246, 0.7)';
                        if (tip.includes('Kuadran III')) return 'rgba(245, 158, 11, 0.7)';
                        return 'rgba(244, 63, 94, 0.7)';
                    },
                    borderColor: '#0f172a',
                    borderWidth: 1.5
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
                                const p = ctx.raw;
                                return [
                                    `${p.provinsi} (${p.pulau})`,
                                    `Pengeluaran BPS: Rp ${p.x.toLocaleString()}/bln`,
                                    `AOV E-Commerce: Rp ${p.y.toLocaleString()}/trx`,
                                    `Volume Transaksi: ${p.trx}`,
                                    `Rasio thd Non-Pangan: ${p.rasio_non_makanan}`,
                                    `Tipologi: ${p.tipologi}`
                                ];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Rata-rata Pengeluaran BPS per Kapita Sebulan (Rupiah)' },
                        grid: { color: '#1e293b' }
                    },
                    y: {
                        title: { display: true, text: 'Average Order Value (AOV) Belanja Digital (Rupiah)' },
                        grid: { color: '#1e293b' }
                    }
                }
            }
        });
    });
</script>
@endpush
