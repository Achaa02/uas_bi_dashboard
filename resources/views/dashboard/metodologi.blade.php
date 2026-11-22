@extends('layouts.app')

@section('title', 'Kamus Data & Metodologi')
@section('header_title', 'Metodologi Penelitian, Kamus Data & Tata Kelola ETL')

@section('content')
    <!-- Research Overview Card -->
    <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 space-y-4">
        <h3 class="text-lg font-bold text-white">Ringkasan Metodologi Proyek Penelitian</h3>
        <p class="text-sm text-slate-300 leading-relaxed">
            Penelitian ini berjudul <strong>"Perancangan Dashboard Business Intelligence untuk Pemetaan Pola Konsumsi dan Daya Beli Digital Berbasis Analisis Big Data (Integrasi Data E-Commerce dan Statistik Pendapatan BPS)"</strong>. 
            Sistem dirancang untuk memberikan transparansi makroekonomi wilayah dan perilaku konsumsi digital melalui integrasi multi-sumber big data.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
            <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-2">
                <span class="text-xs font-bold text-cyan-400 uppercase tracking-wider">Sumber Data 1: E-Commerce Kaggle (Big Data)</span>
                <ul class="text-xs text-slate-400 space-y-1 list-disc list-inside">
                    <li>Total baris: <strong>5.000.000 transaksi observasi asli</strong></li>
                    <li>Format asli: Apache Parquet & CSV</li>
                    <li>Cakupan periode: Februari 2024 s.d. Oktober 2026</li>
                    <li>Cakupan spasial: 38 Provinsi seluruh Indonesia</li>
                    <li>Dimensi: 7 kategori komoditas UMKM & 5 platform e-commerce</li>
                </ul>
            </div>

            <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 space-y-2">
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Sumber Data 2: BPS (Badan Pusat Statistik)</span>
                <ul class="text-xs text-slate-400 space-y-1 list-disc list-inside">
                    <li>Survei Sosial Ekonomi Nasional (Susenas)</li>
                    <li>Rata-rata Pengeluaran per Kapita Sebulan (Makanan & Non-Makanan)</li>
                    <li>Rentang waktu panel: <strong>2011 – 2025 (15 Tahun Observasi)</strong></li>
                    <li>Persentase Pengeluaran Makanan vs Bukan Makanan resmi BPS 2024–2025</li>
                    <li>Standarisasi 38 Provinsi dengan kode wilayah resmi BPS</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Peringatan Akademis (Research Caveats) -->
    <div class="bg-gradient-to-r from-amber-950/40 via-slate-900 to-slate-900 p-6 rounded-2xl border border-amber-800/40 space-y-3">
        <div class="flex items-center space-x-2 text-amber-400 font-bold text-sm">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span>Batasan Metodologis & Pertanggungjawaban Akademis</span>
        </div>
        <div class="text-xs text-slate-300 space-y-2 leading-relaxed">
            <p>
                <strong>1. Pemisahan Data Observasi vs Kolom Model Turunan:</strong>
                Dalam dataset e-commerce, terdapat kolom turunan berbasis AI dan pemodelan statistik (seperti <code>indeks_sensitivitas_ongkir</code>, <code>skor_loyalitas_pelanggan</code>, <code>kategori_risiko_churn</code>, dan <code>penalaran_konsumen_cot</code>). Kolom-kolom ini didokumentasikan secara ketat sebagai <em>metrik turunan/estimasi model</em> dan tidak diperlakukan sebagai variabel observasi mentah.
            </p>
            <p>
                <strong>2. Larangan Menyamakan Belanja Digital dengan Pendapatan:</strong>
                Nilai transaksi e-commerce (GMV/AOV) adalah <em>pengeluaran keranjang belanja untuk komoditas tertentu</em>. Angka ini <strong>TIDAK DAPAT</strong> disamakan langsung dengan pendapatan rumah tangga atau daya beli total masyarakat.
            </p>
            <p>
                <strong>3. Fungsi Integrasi Statistik BPS:</strong>
                Data statistik pengeluaran BPS digunakan sebagai tolok ukur makroekonomi wilayah guna menganalisis rasio penetrasi dan kapasitas keranjang belanja digital terhadap alokasi pengeluaran non-makanan bulanan masyarakat di masing-masing provinsi.
            </p>
        </div>
    </div>

    <!-- Data Dictionary Table -->
    <div class="bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden">
        <div class="p-6 border-b border-slate-800">
            <h3 class="font-bold text-white text-base">Kamus Data Akademis (Data Dictionary)</h3>
            <p class="text-xs text-slate-400 mt-0.5">Klasifikasi variabel, tipe data, dan definisi operasional dalam sistem Business Intelligence</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/80 uppercase font-semibold text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4">Nama Kolom</th>
                        <th class="py-3 px-4">Tipe Data</th>
                        <th class="py-3 px-4">Kategori Variabel</th>
                        <th class="py-3 px-4">Klasifikasi Akademis</th>
                        <th class="py-3 px-4">Definisi Operasional</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-sans">
                    <tr>
                        <td class="py-3 px-4 font-mono text-cyan-400 font-semibold">order_id</td>
                        <td class="py-3 px-4 font-mono text-slate-400">string</td>
                        <td class="py-3 px-4">Identifikasi</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[11px] bg-blue-500/10 text-blue-400 font-semibold">Observasi Asli</span></td>
                        <td class="py-3 px-4">Identifier unik untuk masing-masing 5 juta transaksi.</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-mono text-cyan-400 font-semibold">kategori_produk</td>
                        <td class="py-3 px-4 font-mono text-slate-400">string</td>
                        <td class="py-3 px-4">Katalog Komoditas</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[11px] bg-blue-500/10 text-blue-400 font-semibold">Observasi Asli</span></td>
                        <td class="py-3 px-4">7 kategori produk UMKM lokal Indonesia.</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-mono text-cyan-400 font-semibold">platform_ecommerce</td>
                        <td class="py-3 px-4 font-mono text-slate-400">string</td>
                        <td class="py-3 px-4">Kanal Belanja</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[11px] bg-blue-500/10 text-blue-400 font-semibold">Observasi Asli</span></td>
                        <td class="py-3 px-4">5 kanal marketplace / social commerce digital.</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-mono text-cyan-400 font-semibold">provinsi_pembeli</td>
                        <td class="py-3 px-4 font-mono text-slate-400">string</td>
                        <td class="py-3 px-4">Spasial Wilayah</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[11px] bg-blue-500/10 text-blue-400 font-semibold">Observasi Asli</span></td>
                        <td class="py-3 px-4">38 Provinsi domisili konsumen destinasi pesanan.</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-mono text-cyan-400 font-semibold">nilai_transaksi_netto_idr</td>
                        <td class="py-3 px-4 font-mono text-slate-400">int64 / decimal</td>
                        <td class="py-3 px-4">Keuangan Transaksi</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[11px] bg-blue-500/10 text-blue-400 font-semibold">Observasi Asli</span></td>
                        <td class="py-3 px-4">Total akhir pembayaran riil yang ditransfer oleh konsumen.</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-mono text-cyan-400 font-semibold">indeks_sensitivitas_ongkir</td>
                        <td class="py-3 px-4 font-mono text-slate-400">float64</td>
                        <td class="py-3 px-4">Model Perilaku</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[11px] bg-purple-500/10 text-purple-400 font-semibold">Model / Kolom Turunan</span></td>
                        <td class="py-3 px-4">Indeks elastisitas keputusan pembelian terhadap tarif ongkos kirim logistik (0.0 – 1.0).</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-mono text-cyan-400 font-semibold">skor_loyalitas_pelanggan</td>
                        <td class="py-3 px-4 font-mono text-slate-400">float64</td>
                        <td class="py-3 px-4">Model Retensi</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[11px] bg-purple-500/10 text-purple-400 font-semibold">Model / Kolom Turunan</span></td>
                        <td class="py-3 px-4">Estimasi skor retensi loyalitas pembeli (0.0 – 1.0).</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-mono text-cyan-400 font-semibold">kategori_risiko_churn</td>
                        <td class="py-3 px-4 font-mono text-slate-400">string</td>
                        <td class="py-3 px-4">Model Prediktif</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[11px] bg-purple-500/10 text-purple-400 font-semibold">Model / Kolom Turunan</span></td>
                        <td class="py-3 px-4">Klasifikasi risiko perpindahan pembeli (Rendah, Sedang, Tinggi).</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-4 font-mono text-cyan-400 font-semibold">rasio_aov_thd_non_makanan_bps</td>
                        <td class="py-3 px-4 font-mono text-slate-400">float64 / decimal</td>
                        <td class="py-3 px-4">Metrik Terintegrasi</td>
                        <td class="py-3 px-4"><span class="px-2 py-0.5 rounded text-[11px] bg-emerald-500/10 text-emerald-400 font-semibold">Formula Integrasi</span></td>
                        <td class="py-3 px-4">Rasio nilai satu keranjang belanja online terhadap rata-rata pengeluaran bulanan non-makanan BPS.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pipeline Eksekusi ETL -->
    <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800 space-y-4">
        <h3 class="font-bold text-white text-base">Alur Eksekusi Pipeline ETL Python (Reproducibility)</h3>
        <p class="text-xs text-slate-400">Pipeline Python dirancang modular dan dapat dijalankan ulang secara deterministik:</p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
            <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
                <span class="font-mono text-cyan-400 font-bold">01_profile_raw.py</span>
                <p class="text-slate-400">Audit kualitas, validasi duplikasi, missing values, dan deteksi anomali pada 5M baris parquet.</p>
            </div>
            <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
                <span class="font-mono text-cyan-400 font-bold">02_clean_bps.py</span>
                <p class="text-slate-400">Normalisasi string spasi angka ribuan, pembersihan catatan kaki, dan pembentukan panel 38 provinsi.</p>
            </div>
            <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
                <span class="font-mono text-cyan-400 font-bold">03_aggregate_and_integrate.py</span>
                <p class="text-slate-400">Streaming agregasi 5 juta baris, perumusan kuadran tipologi, dan pembuatan data mart terintegrasi.</p>
            </div>
            <div class="p-3.5 rounded-xl bg-slate-950 border border-slate-800 space-y-1">
                <span class="font-mono text-cyan-400 font-bold">04_load_mysql.py</span>
                <p class="text-slate-400">Pemuatan terstruktur ke MySQL database bi_dashboard melalui skema bintang relasional.</p>
            </div>
        </div>
    </div>
@endsection
