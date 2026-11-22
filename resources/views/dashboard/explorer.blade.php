@extends('layouts.app')

@section('title', 'Data Explorer 50k')
@section('header_title', 'Data Explorer: Audit & Eksplorasi Transaksi Riil')

@section('content')
    <!-- Academic Caveat on Granular Data -->
    <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 text-xs text-slate-400 flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            <span>Menampilkan sampel terstratifikasi <strong>50.000 transaksi observasi asli</strong> yang diekstraksi langsung dari dataset 5 juta baris untuk verifikasi detail akademis.</span>
        </div>
        <span class="text-slate-500 font-mono">Total Transaksi Sampel: {{ number_format($transactions->total()) }}</span>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-slate-900 p-5 rounded-2xl border border-slate-800 space-y-4">
        <form method="GET" action="{{ route('dashboard.explorer') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3 text-xs">
            <!-- Search Keyword -->
            <div class="lg:col-span-2">
                <label for="q" class="font-semibold text-slate-300 block mb-1">Cari Order / ID / Wilayah:</label>
                <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Contoh: TRX-00000001 / Jawa Timur..." class="w-full bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:border-cyan-500">
            </div>

            <!-- Kategori -->
            <div>
                <label for="kategori" class="font-semibold text-slate-300 block mb-1">Kategori Produk:</label>
                <select name="kategori" id="kategori" class="w-full bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-2.5 py-2 focus:outline-none focus:border-cyan-500">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Platform -->
            <div>
                <label for="platform" class="font-semibold text-slate-300 block mb-1">Platform:</label>
                <select name="platform" id="platform" class="w-full bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-2.5 py-2 focus:outline-none focus:border-cyan-500">
                    <option value="all">Semua Platform</option>
                    @foreach($platforms as $plat)
                        <option value="{{ $plat }}" {{ request('platform') == $plat ? 'selected' : '' }}>{{ $plat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Provinsi -->
            <div>
                <label for="provinsi" class="font-semibold text-slate-300 block mb-1">Provinsi Destinasi:</label>
                <select name="provinsi" id="provinsi" class="w-full bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-2.5 py-2 focus:outline-none focus:border-cyan-500">
                    <option value="all">Semua Provinsi</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov }}" {{ request('provinsi') == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Submit -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-semibold py-2 px-3 rounded-lg transition-colors">
                    Terapkan
                </button>
                <a href="{{ route('dashboard.explorer') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 py-2 px-3 rounded-lg transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/80 uppercase font-semibold text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-3">Order ID</th>
                        <th class="py-3 px-3">Waktu Transaksi</th>
                        <th class="py-3 px-3">Kategori Produk</th>
                        <th class="py-3 px-3">Platform</th>
                        <th class="py-3 px-3">Destinasi</th>
                        <th class="py-3 px-3 text-right">Nilai Bruto</th>
                        <th class="py-3 px-3 text-right">Diskon</th>
                        <th class="py-3 px-3 text-right">Netto Akhir</th>
                        <th class="py-3 px-3">Pembayaran</th>
                        <th class="py-3 px-3">Ekspedisi</th>
                        <th class="py-3 px-3 text-center">Durasi</th>
                        <th class="py-3 px-3 text-center">Rating</th>
                        <th class="py-3 px-3 text-center">Repeat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-mono text-[11px]">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-2.5 px-3 font-semibold text-cyan-400">{{ $t->order_id }}</td>
                            <td class="py-2.5 px-3 text-slate-400 whitespace-nowrap">{{ $t->timestamp_transaksi?->format('d/m/Y H:i') }}</td>
                            <td class="py-2.5 px-3 font-sans text-slate-200">{{ $t->kategori_produk }}</td>
                            <td class="py-2.5 px-3 font-sans text-slate-300">{{ $t->platform_ecommerce }}</td>
                            <td class="py-2.5 px-3 font-sans text-slate-200">{{ $t->provinsi }}</td>
                            <td class="py-2.5 px-3 text-right text-slate-400">Rp {{ number_format($t->nilai_transaksi_bruto_idr, 0) }}</td>
                            <td class="py-2.5 px-3 text-right text-rose-400">-Rp {{ number_format($t->diskon_voucher_platform_idr, 0) }}</td>
                            <td class="py-2.5 px-3 text-right font-bold text-emerald-400">Rp {{ number_format($t->nilai_transaksi_netto_idr, 0) }}</td>
                            <td class="py-2.5 px-3 font-sans text-slate-300">{{ $t->metode_pembayaran }}</td>
                            <td class="py-2.5 px-3 font-sans text-slate-300">{{ $t->layanan_ekspedisi }}</td>
                            <td class="py-2.5 px-3 text-center">
                                <span class="px-1.5 py-0.5 rounded text-[10px] {{ $t->durasi_pengiriman_hari <= 3 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-amber-500/10 text-amber-400' }}">
                                    {{ $t->durasi_pengiriman_hari }}h
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-center text-amber-400 font-bold">★ {{ $t->rating_produk }}</td>
                            <td class="py-2.5 px-3 text-center">
                                <span class="px-1.5 py-0.5 rounded text-[10px] {{ $t->status_repeat_order === 'Ya' ? 'bg-purple-500/10 text-purple-400' : 'bg-slate-800 text-slate-500' }}">
                                    {{ $t->status_repeat_order }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="py-8 text-center text-slate-500 italic font-sans">
                                Tidak ada transaksi yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/40">
            {{ $transactions->links() }}
        </div>
    </div>
@endsection
