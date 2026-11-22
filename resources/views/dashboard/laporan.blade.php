@extends('layouts.app')

@section('title', 'Laporan & Ekspor')
@section('header_title', 'Pusat Ekspor Laporan Analitik Wilayah (PDF & Excel)')

@section('content')
    <!-- Filter & Action Bar -->
    <div class="bg-slate-900/90 p-5 rounded-2xl border border-slate-800 flex flex-wrap items-center justify-between gap-4">
        <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap items-center gap-3 text-sm">
            <!-- Filter Provinsi -->
            <div class="flex items-center space-x-2">
                <label for="provinsi" class="text-xs text-slate-400 font-semibold">Pilih Provinsi:</label>
                <select name="provinsi" id="provinsi" onchange="this.form.submit()" class="bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:border-cyan-500 font-medium">
                    @foreach($provinces as $p)
                        <option value="{{ $p->nama_provinsi }}" {{ $selectedProv === $p->nama_provinsi ? 'selected' : '' }}>
                            {{ $p->kode_bps }} - {{ $p->nama_provinsi }} ({{ $p->pulau }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Tahun -->
            <div class="flex items-center space-x-2">
                <label for="tahun" class="text-xs text-slate-400 font-semibold">Periode Tahun:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()" class="bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:border-cyan-500 font-medium">
                    @foreach($availableYears as $yr)
                        <option value="{{ $yr }}" {{ $selectedYear == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Download Buttons -->
        <div class="flex items-center space-x-3">
            <a href="{{ route('laporan.pdf', ['provinsi' => $selectedProv, 'tahun' => $selectedYear]) }}" 
               class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-bold bg-rose-600 hover:bg-rose-500 text-white shadow-lg shadow-rose-600/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                <span>Unduh Laporan PDF (A4)</span>
            </a>

            <a href="{{ route('laporan.excel', ['provinsi' => $selectedProv, 'tahun' => $selectedYear]) }}" 
               class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg shadow-emerald-600/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Unduh Excel (.XLSX Multi-Sheet)</span>
            </a>
        </div>
    </div>

    <!-- Live Document Preview Container -->
    <div class="bg-slate-900 rounded-2xl border border-slate-800 p-8 space-y-8">
        <!-- Preview Header / Metadata -->
        <div class="border-b border-slate-800 pb-6 flex flex-wrap items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-0.5 rounded text-xs font-mono font-bold bg-cyan-500/10 text-cyan-400 border border-cyan-500/20">
                        BPS {{ $wilayah->kode_bps }}
                    </span>
                    <h3 class="text-xl font-extrabold text-white">{{ $wilayah->nama_provinsi }}</h3>
                    <span class="text-xs text-slate-400">({{ $wilayah->pulau }})</span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Laporan Profil Belanja Digital & Integrasi Makroekonomi Susenas BPS &bull; Periode {{ $selectedYear }}</p>
            </div>

            <!-- Tipologi Badge -->
            <div class="px-3.5 py-1.5 rounded-xl border text-xs font-semibold {{ str_contains($integ?->tipologi_daya_beli_digital ?? '', 'Kuadran I') ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300' : (str_contains($integ?->tipologi_daya_beli_digital ?? '', 'Kuadran II') ? 'border-blue-500/30 bg-blue-500/10 text-blue-300' : (str_contains($integ?->tipologi_daya_beli_digital ?? '', 'Kuadran III') ? 'border-amber-500/30 bg-amber-500/10 text-amber-300' : 'border-rose-500/30 bg-rose-500/10 text-rose-300')) }}">
                {{ $integ ? $integ->tipologi_daya_beli_digital : 'Belum Terklasifikasi' }}
            </div>
        </div>

        <!-- 4 KPI Cards Preview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
                <span class="text-xs font-semibold text-slate-400 uppercase">Belanja Netto E-Commerce</span>
                <div class="text-xl font-bold text-cyan-400 mt-1">
                    Rp {{ $integ ? number_format($integ->ecom_total_netto_idr / 1000000000, 2) : '0' }} M
                </div>
                <span class="text-[11px] text-slate-500">{{ $integ ? number_format($integ->ecom_total_transaksi) : '0' }} Transaksi</span>
            </div>

            <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
                <span class="text-xs font-semibold text-slate-400 uppercase">AOV Keranjang Digital</span>
                <div class="text-xl font-bold text-emerald-400 mt-1">
                    Rp {{ $integ ? number_format($integ->ecom_aov_idr, 0) : '0' }}
                </div>
                <span class="text-[11px] text-slate-500">Rata-rata per transaksi belanja</span>
            </div>

            <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
                <span class="text-xs font-semibold text-slate-400 uppercase">Pengeluaran BPS / Kapita</span>
                <div class="text-xl font-bold text-amber-400 mt-1">
                    Rp {{ $integ ? number_format($integ->total_pengeluaran_idr, 0) : '0' }}
                </div>
                <span class="text-[11px] text-slate-500">Non-Makanan: Rp {{ $integ ? number_format($integ->pengeluaran_non_makanan_idr, 0) : '0' }}</span>
            </div>

            <div class="p-4 rounded-xl bg-slate-950 border border-slate-800">
                <span class="text-xs font-semibold text-slate-400 uppercase">Rasio AOV / Non-Makanan</span>
                <div class="text-xl font-bold text-purple-400 mt-1">
                    {{ $integ ? number_format($integ->rasio_aov_thd_non_makanan_bps * 100, 2) : '0' }}%
                </div>
                <span class="text-[11px] text-slate-500">Porsi keranjang thd non-pangan BPS</span>
            </div>
        </div>

        <!-- Academic Interpretation Preview -->
        <div class="p-4 rounded-xl bg-emerald-950/20 border border-emerald-500/30 text-xs text-emerald-300 leading-relaxed">
            <span class="font-bold text-emerald-400">Interpretasi Analitik Wilayah:</span>
            Provinsi <strong>{{ $wilayah->nama_provinsi }}</strong> menempati klasifikasi <strong>{{ $integ ? $integ->tipologi_daya_beli_digital : '-' }}</strong>.
            Satu pesanan belanja online rata-rata bernilai <strong>Rp {{ $integ ? number_format($integ->ecom_aov_idr, 0) : '0' }}</strong>, 
            yang ekuivalen dengan <strong>{{ $integ ? number_format($integ->rasio_aov_thd_non_makanan_bps * 100, 2) : '0' }}%</strong> 
            dari kapasitas pengeluaran non-makanan per kapita sebulan masyarakat (Rp {{ $integ ? number_format($integ->pengeluaran_non_makanan_idr, 0) : '0' }}).
        </div>

        <!-- Preview Table: Kategori Produk -->
        <div class="space-y-3">
            <h4 class="font-bold text-sm text-slate-200">Kinerja 7 Kategori Produk UMKM di {{ $wilayah->nama_provinsi }}</h4>
            <div class="overflow-x-auto rounded-xl border border-slate-800">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-950 uppercase font-semibold text-slate-400 border-b border-slate-800">
                        <tr>
                            <th class="py-2.5 px-3">Kategori Produk</th>
                            <th class="py-2.5 px-3 text-right">Total Transaksi</th>
                            <th class="py-2.5 px-3 text-right">Kuantitas</th>
                            <th class="py-2.5 px-3 text-right">Total GMV (Rp)</th>
                            <th class="py-2.5 px-3 text-right">AOV (Rp)</th>
                            <th class="py-2.5 px-3 text-center">Rating</th>
                            <th class="py-2.5 px-3 text-center">Repeat Order</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @foreach($kategoriStats as $k)
                            <tr class="hover:bg-slate-800/30">
                                <td class="py-2 px-3 font-medium text-white">{{ $k->kategori_produk }}</td>
                                <td class="py-2 px-3 text-right">{{ number_format($k->trx) }}</td>
                                <td class="py-2 px-3 text-right text-slate-400">{{ number_format($k->qty) }}</td>
                                <td class="py-2 px-3 text-right text-cyan-400 font-bold">Rp {{ number_format($k->gmv, 0) }}</td>
                                <td class="py-2 px-3 text-right text-emerald-400">Rp {{ number_format($k->aov, 0) }}</td>
                                <td class="py-2 px-3 text-center text-amber-400">★ {{ $k->rating }}</td>
                                <td class="py-2 px-3 text-center text-purple-400">{{ $k->repeat_rate }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Preview Table: Pangsa Platform -->
        <div class="space-y-3">
            <h4 class="font-bold text-sm text-slate-200">Pangsa Pasar Platform E-Commerce di {{ $wilayah->nama_provinsi }}</h4>
            <div class="overflow-x-auto rounded-xl border border-slate-800">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-950 uppercase font-semibold text-slate-400 border-b border-slate-800">
                        <tr>
                            <th class="py-2.5 px-3">Platform E-Commerce</th>
                            <th class="py-2.5 px-3 text-right">Total Transaksi</th>
                            <th class="py-2.5 px-3 text-right">Total GMV (Rp)</th>
                            <th class="py-2.5 px-3 text-right">Pangsa Pasar (%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @php $totalProvGmv = $platformStats->sum('gmv'); @endphp
                        @foreach($platformStats as $p)
                            <tr class="hover:bg-slate-800/30">
                                <td class="py-2 px-3 font-medium text-white">{{ $p->platform_ecommerce }}</td>
                                <td class="py-2 px-3 text-right">{{ number_format($p->trx) }}</td>
                                <td class="py-2 px-3 text-right text-cyan-400 font-bold">Rp {{ number_format($p->gmv, 0) }}</td>
                                <td class="py-2 px-3 text-right text-emerald-400 font-bold">
                                    {{ number_format(($p->gmv / max(1, $totalProvGmv)) * 100, 2) }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Call to Action Footer -->
        <div class="pt-4 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
            <span>Seluruh data pada laporan diambil langsung dari database MySQL hasil integrasi data riil BPS dan E-Commerce.</span>
            <div class="flex items-center space-x-2">
                <a href="{{ route('laporan.pdf', ['provinsi' => $selectedProv, 'tahun' => $selectedYear]) }}" class="text-rose-400 hover:text-rose-300 underline font-medium">Download Versi PDF</a>
                <span>&bull;</span>
                <a href="{{ route('laporan.excel', ['provinsi' => $selectedProv, 'tahun' => $selectedYear]) }}" class="text-emerald-400 hover:text-emerald-300 underline font-medium">Download Versi Excel</a>
            </div>
        </div>
    </div>
@endsection
