@extends($layoutMode === 'app' ? 'layouts.app' : 'layouts.public')

@section('title', 'Prediksi Nilai Transaksi E-Commerce (ARIMA) - BI Dashboard')
@section('header_title', 'Prediksi Nilai Transaksi E-Commerce (ARIMA)')

@section('content')
<div class="space-y-6 w-full">

    <!-- 1. TOP HEADER & METADATA BAR -->
    <header class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2.5">
                <div class="w-10 h-10 rounded-xl bg-teal-600 flex items-center justify-center text-white shadow-md shadow-teal-600/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <h1 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight leading-tight">
                        Prediksi Nilai Transaksi E-Commerce (ARIMA)
                    </h1>
                    <p class="text-xs text-slate-500 font-medium">
                        Pemodelan Time Series Autoregressive Integrated Moving Average berbasis Data Historis Transaksi
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold border border-slate-200 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Model: <strong>{{ $run ? $run->model_order : 'ARIMA(2,1,0)' }}</strong></span>
            </span>

            @if($layoutMode === 'public')
                <a href="{{ route('public.dashboard') }}" 
                   class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl shadow-sm transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Dashboard Publik</span>
                </a>
            @else
                <button type="button" onclick="document.getElementById('retrainModal').classList.remove('hidden')" 
                        class="px-3.5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-teal-600/30 transition-all flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Latih Ulang Model</span>
                </button>
            @endif
        </div>
    </header>

    <!-- 2. MAIN PREDICTION COMPONENT (Matching Reference Mockup Layout) -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-sm space-y-6">
        
        <!-- Header of Panel -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <h2 class="text-sm sm:text-base font-extrabold text-slate-900 tracking-tight">
                    Prediksi Nilai Transaksi E-Commerce (ARIMA)
                </h2>
                <div class="flex items-center gap-2 mt-0.5 text-xs text-slate-500">
                    <span class="font-semibold text-slate-700">Prediksi Nilai Transaksi Netto (Bulanan)</span>
                    <span>&bull;</span>
                    <span>Periode Prediksi: <strong>{{ $run ? $run->forecast_start : '2025-01' }} - {{ $run ? $run->forecast_end : '2025-12' }}</strong> ({{ $run ? $run->horizon_months : 12 }} Bulan ke Depan)</span>
                </div>
            </div>

            <!-- Custom Legend (Matching Reference Image) -->
            <div class="flex items-center gap-3 flex-wrap text-[11px] font-medium text-slate-600">
                <div class="flex items-center gap-1.5">
                    <span class="w-3.5 h-1.5 bg-blue-600 rounded-full inline-block"></span>
                    <span>Aktual (s.d {{ $run ? $run->training_end : 'Des 2024' }})</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3.5 h-1.5 bg-purple-600 rounded-full inline-block border-dashed"></span>
                    <span class="text-purple-700 font-semibold">Prediksi</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3.5 h-0.5 bg-teal-500 inline-block border-dashed"></span>
                    <span>Ratas Akts</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3.5 h-0.5 bg-emerald-500 inline-block border-dashed"></span>
                    <span class="text-emerald-600 font-semibold">Batas Atas (95%)</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3.5 h-0.5 bg-rose-400 inline-block border-dashed"></span>
                    <span class="text-rose-500 font-semibold">Batas Bawah (95%)</span>
                </div>
            </div>
        </div>

        <!-- 4 Columns Grid Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            <!-- Col 1: Forecast Chart (6 Cols) -->
            <div class="lg:col-span-6 bg-slate-50/50 rounded-2xl p-4 border border-slate-100 flex flex-col justify-between">
                <div class="h-64 sm:h-72 w-full">
                    <canvas id="arimaForecastChart"></canvas>
                </div>
                <div class="text-[10px] text-slate-400 text-center mt-2">
                    Garis ungu putus-putus menunjukkan proyeksi model ARIMA dengan shaded area interval kepercayaan 95%.
                </div>
            </div>

            <!-- Col 2: Ringkasan Prediksi & Akurasi MAPE (2 Cols) -->
            <div class="lg:col-span-2 flex flex-col justify-between gap-3.5">
                <!-- Box 1: Ringkasan Prediksi -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="text-[11px] font-bold text-slate-800 leading-tight">
                            Ringkasan Prediksi (12 Bulan ke Depan)
                        </h4>
                        
                        <div class="mt-3 space-y-2">
                            <div>
                                <span class="text-[10px] text-slate-400 block">Total Prediksi ({{ $run ? $run->forecast_start : 'Jan' }} - {{ $run ? $run->forecast_end : 'Des' }})</span>
                                <span class="text-xs font-extrabold text-slate-900">
                                    @php
                                        $totPred = $run ? (float)$run->total_predicted_idr : 575359419145;
                                    @endphp
                                    @if($totPred >= 1000000000000)
                                        Rp {{ number_format($totPred / 1000000000000, 2, ',', '.') }} T
                                    @else
                                        Rp {{ number_format($totPred / 1000000000, 2, ',', '.') }} M
                                    @endif
                                </span>
                            </div>

                            <div>
                                <span class="text-[10px] text-slate-400 block">Rata-rata per Bulan</span>
                                <span class="text-xs font-extrabold text-slate-900">
                                    @php
                                        $avgPred = $run ? (float)$run->avg_monthly_predicted_idr : 47946618262;
                                    @endphp
                                    @if($avgPred >= 1000000000000)
                                        Rp {{ number_format($avgPred / 1000000000000, 2, ',', '.') }} T
                                    @else
                                        Rp {{ number_format($avgPred / 1000000000, 2, ',', '.') }} M
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 pt-2 border-t border-slate-200/80 flex items-center justify-between text-[11px]">
                        <span class="text-slate-500 text-[10px]">Perubahan vs 12 Bulan Terakhir</span>
                        <span class="font-bold text-emerald-600 flex items-center">
                            ▲ {{ $run ? $run->growth_rate_pct : '18,35' }}%
                        </span>
                    </div>
                </div>

                <!-- Box 2: Akurasi Model (MAPE) -->
                <div class="p-4 rounded-xl bg-emerald-50/70 border border-emerald-100 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="text-[11px] font-bold text-emerald-900 leading-tight">
                            Akurasi Model (MAPE)
                        </h4>
                        <div class="text-2xl font-black text-emerald-600 mt-2">
                            {{ $run ? number_format($run->mape, 2, ',', '.') : '8,72' }}%
                        </div>
                    </div>
                    <p class="text-[10px] text-emerald-700 leading-tight mt-1.5">
                        Semakin kecil nilai MAPE, semakin baik akurasi model.
                    </p>
                </div>
            </div>

            <!-- Col 3: Faktor yang Diprediksi Mempengaruhi (2 Cols) -->
            <div class="lg:col-span-2 p-4 rounded-xl bg-slate-50 border border-slate-100 flex flex-col justify-between">
                <div>
                    <h4 class="text-[11px] font-bold text-slate-800 leading-tight mb-3">
                        Faktor yang Diprediksi Mempengaruhi Nilai Transaksi
                    </h4>

                    <div class="space-y-3">
                        @foreach($factors as $factor)
                            <div class="flex items-start space-x-2">
                                <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-[11px] font-bold text-slate-900 leading-tight">{{ $factor['title'] }}</div>
                                    <div class="text-[10px] text-slate-500 leading-snug mt-0.5">{{ $factor['desc'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Col 4: Insight Utama (2 Cols) -->
            <div class="lg:col-span-2 p-4 rounded-xl bg-slate-50 border border-slate-100 flex flex-col justify-between">
                <div>
                    <h4 class="text-[11px] font-bold text-slate-800 leading-tight mb-3">
                        Insight Utama
                    </h4>

                    <div class="space-y-2.5">
                        @foreach($insights as $idx => $insight)
                            <div class="flex items-start space-x-2 text-[10px] text-slate-600 leading-relaxed">
                                <span class="w-4 h-4 rounded-full bg-blue-500/10 text-blue-600 font-bold flex items-center justify-center shrink-0 text-[9px] mt-0.5">
                                    {{ $idx + 1 }}
                                </span>
                                <span>{{ $insight }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <!-- Table of Detailed Monthly Predictions -->
        @if($run && $run->forecasts->isNotEmpty())
            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">
                    Rincian Proyeksi Nilai Transaksi Bulanan
                </h3>
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-[10px] text-slate-500 uppercase tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-2.5">Periode</th>
                                <th class="px-4 py-2.5">Nilai Prediksi (IDR)</th>
                                <th class="px-4 py-2.5">Batas Bawah (95%)</th>
                                <th class="px-4 py-2.5">Batas Atas (95%)</th>
                                <th class="px-4 py-2.5">Nilai Aktual Historis</th>
                                <th class="px-4 py-2.5">Pertumbuhan YoY</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($run->forecasts as $f)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-4 py-2 font-bold text-slate-900">{{ $f->period }}</td>
                                    <td class="px-4 py-2 font-extrabold text-purple-700">Rp {{ number_format($f->predicted_value, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-rose-600">Rp {{ number_format($f->lower_bound, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-emerald-600">Rp {{ number_format($f->upper_bound, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-slate-600">
                                        @if($f->actual_value !== null)
                                            Rp {{ number_format($f->actual_value, 0, ',', '.') }}
                                        @else
                                            <span class="text-slate-400 italic">Masa Datang</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if($f->growth_vs_prior_year_pct !== null)
                                            <span class="font-bold {{ $f->growth_vs_prior_year_pct >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                                                {{ $f->growth_vs_prior_year_pct >= 0 ? '▲ +' : '▼ ' }}{{ number_format($f->growth_vs_prior_year_pct, 2, ',', '.') }}%
                                            </span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>

</div>

<!-- Admin Retrain Modal -->
<div id="retrainModal" class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-extrabold text-slate-900 text-sm">Latih Ulang Model ARIMA</h3>
            <button type="button" onclick="document.getElementById('retrainModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">&times;</button>
        </div>
        <p class="text-xs text-slate-500 leading-relaxed">
            Proses ini akan menjalankan script Python Statsmodels untuk melakukan optimasi parameter AIC/BIC dan menyimpan hasil prediksi terbaru ke MySQL.
        </p>
        <form id="retrainForm" onsubmit="handleRetrain(event)" class="space-y-3 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Horizon Prediksi (Bulan)</label>
                <select name="horizon" id="retrainHorizon" class="w-full border border-slate-200 rounded-xl p-2.5">
                    <option value="6">6 Bulan ke Depan</option>
                    <option value="12" selected>12 Bulan ke Depan</option>
                    <option value="18">18 Bulan ke Depan</option>
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">Batas Data Training (Cutoff)</label>
                <input type="text" name="train_cutoff" id="retrainCutoff" value="2024-12" class="w-full border border-slate-200 rounded-xl p-2.5" placeholder="Contoh: 2024-12 atau kosongkan untuk semua">
            </div>
            <div id="retrainStatus" class="hidden p-3 rounded-xl text-xs"></div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('retrainModal').classList.add('hidden')" class="px-4 py-2 border rounded-xl text-slate-600">Batal</button>
                <button type="submit" id="retrainSubmitBtn" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl shadow-sm">Mulai Training</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const friendlyLabels = @json($friendlyLabels);
    const histSeries = @json($histSeries);
    const predSeries = @json($predSeries);
    const lowSeries = @json($lowSeries);
    const upSeries = @json($upSeries);
    const avgSeries = @json($avgSeries);

    const ctx = document.getElementById('arimaForecastChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: friendlyLabels,
            datasets: [
                // 1. Batas Atas 95% (Green dashed)
                {
                    label: 'Batas Atas (95%)',
                    data: upSeries,
                    borderColor: '#10b981',
                    borderWidth: 1.5,
                    borderDash: [4, 4],
                    pointRadius: 0,
                    fill: '+1', // Fill down to Batas Bawah
                    backgroundColor: 'rgba(168, 85, 247, 0.08)', // Shaded purple confidence band
                    tension: 0.3
                },
                // 2. Batas Bawah 95% (Red dashed)
                {
                    label: 'Batas Bawah (95%)',
                    data: lowSeries,
                    borderColor: '#f43f5e',
                    borderWidth: 1.5,
                    borderDash: [4, 4],
                    pointRadius: 0,
                    fill: false,
                    tension: 0.3
                },
                // 3. Prediksi (Purple Dashed)
                {
                    label: 'Prediksi',
                    data: predSeries,
                    borderColor: '#9333ea',
                    borderWidth: 2.2,
                    borderDash: [5, 5],
                    pointRadius: 3,
                    pointBackgroundColor: '#9333ea',
                    fill: false,
                    tension: 0.3
                },
                // 4. Aktual (Solid Blue)
                {
                    label: 'Aktual',
                    data: histSeries,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.12)',
                    borderWidth: 2.2,
                    pointRadius: 3.5,
                    pointBackgroundColor: '#2563eb',
                    fill: false,
                    tension: 0.25
                },
                // 5. Rata-rata Aktual (Teal dashed)
                {
                    label: 'Rata-rata Aktual',
                    data: avgSeries,
                    borderColor: '#14b8a6',
                    borderWidth: 1.2,
                    borderDash: [3, 3],
                    pointRadius: 0,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            if (ctx.raw === null || ctx.raw === undefined) return null;
                            const val = ctx.raw;
                            let formatted = 'Rp ' + (val / 1000000000).toFixed(2) + ' Miliar';
                            if (val >= 1000000000000) {
                                formatted = 'Rp ' + (val / 1000000000000).toFixed(2) + ' Triliun';
                            }
                            return ctx.dataset.label + ': ' + formatted;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { maxTicksLimit: 12, font: { size: 9, family: "'Plus Jakarta Sans'" } },
                    grid: { display: false }
                },
                y: {
                    ticks: {
                        font: { size: 9, family: "'Plus Jakarta Sans'" },
                        callback: function (val) {
                            if (val >= 1000000000000) return (val / 1000000000000).toFixed(1) + ' T';
                            return (val / 1000000000).toFixed(0) + ' M';
                        }
                    },
                    grid: { color: '#f1f5f9' }
                }
            }
        }
    });
});

function handleRetrain(e) {
    e.preventDefault();
    const btn = document.getElementById('retrainSubmitBtn');
    const statusBox = document.getElementById('retrainStatus');
    const horizon = document.getElementById('retrainHorizon').value;
    const cutoff = document.getElementById('retrainCutoff').value;

    btn.disabled = true;
    btn.innerText = 'Melatih Model...';
    statusBox.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-700', 'bg-rose-50', 'text-rose-700');
    statusBox.classList.add('bg-blue-50', 'text-blue-700');
    statusBox.innerText = 'Sedang menjalankan ARIMA Python di server. Harap tunggu beberapa detik...';

    fetch('{{ route("admin.forecast.retrain") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ horizon: horizon, train_cutoff: cutoff })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerText = 'Mulai Training';
        if (data.status === 'success') {
            statusBox.className = 'p-3 rounded-xl text-xs bg-emerald-50 text-emerald-700 border border-emerald-200';
            statusBox.innerText = 'Sukses: ' + data.message + ' (Order: ' + data.model_order + ', MAPE: ' + data.mape + '%). Memuat ulang halaman...';
            setTimeout(() => window.location.reload(), 1500);
        } else {
            statusBox.className = 'p-3 rounded-xl text-xs bg-rose-50 text-rose-700 border border-rose-200';
            statusBox.innerText = 'Error: ' + data.message;
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerText = 'Mulai Training';
        statusBox.className = 'p-3 rounded-xl text-xs bg-rose-50 text-rose-700 border border-rose-200';
        statusBox.innerText = 'Koneksi gagal: ' + err.message;
    });
}
</script>
@endpush
