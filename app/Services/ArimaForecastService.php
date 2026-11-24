<?php

namespace App\Services;

use App\Models\FactEcommerceBulanan;
use App\Models\ForecastRun;
use App\Models\TransactionForecast;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ArimaForecastService
{
    /**
     * Retrieve the active or most recent ARIMA forecast run.
     */
    public function getActiveForecastRun(): ?ForecastRun
    {
        return ForecastRun::where('is_active', true)
            ->with(['forecasts' => fn($q) => $q->orderBy('period_date', 'asc')])
            ->latest('id')
            ->first();
    }

    /**
     * Compile chart datasets: historical actual series + predicted series with 95% CI.
     */
    public function getChartData(?ForecastRun $run = null): array
    {
        if (!$run) {
            $run = $this->getActiveForecastRun();
        }

        // Fetch historical monthly actuals (e.g. 2024 or full historical series)
        $historicalRecords = FactEcommerceBulanan::select(
            'tahun_bulan',
            DB::raw('SUM(total_netto_idr) as total_netto')
        )
            ->groupBy('tahun_bulan')
            ->orderBy('tahun_bulan', 'asc')
            ->get();

        $historicalLabels = [];
        $historicalValues = [];
        $cutoff = $run ? $run->training_end : '2024-12';

        foreach ($historicalRecords as $row) {
            if ($row->tahun_bulan <= $cutoff) {
                $historicalLabels[] = $row->tahun_bulan;
                $historicalValues[] = (float) $row->total_netto;
            }
        }

        $avgHistorical = count($historicalValues) > 0 ? (array_sum($historicalValues) / count($historicalValues)) : 0;

        $forecastLabels = [];
        $predictedValues = [];
        $lowerBounds = [];
        $upperBounds = [];
        $actualInForecast = [];

        if ($run && $run->forecasts->isNotEmpty()) {
            foreach ($run->forecasts as $f) {
                $forecastLabels[] = $f->period;
                $predictedValues[] = (float) $f->predicted_value;
                $lowerBounds[] = (float) $f->lower_bound;
                $upperBounds[] = (float) $f->upper_bound;
                $actualInForecast[] = $f->actual_value !== null ? (float) $f->actual_value : null;
            }
        }

        // Combine all labels chronologically
        $allLabels = array_unique(array_merge($historicalLabels, $forecastLabels));
        sort($allLabels);

        // Map values into full continuous timeline
        $histSeries = [];
        $predSeries = [];
        $lowSeries = [];
        $upSeries = [];
        $avgSeries = [];

        $histMap = array_combine($historicalLabels, $historicalValues);
        $predMap = $run ? $run->forecasts->pluck('predicted_value', 'period')->toArray() : [];
        $lowMap = $run ? $run->forecasts->pluck('lower_bound', 'period')->toArray() : [];
        $upMap = $run ? $run->forecasts->pluck('upper_bound', 'period')->toArray() : [];

        // Connect last historical point to first predicted point for continuous line visual
        $lastHistPeriod = end($historicalLabels);
        $lastHistVal = end($historicalValues);

        foreach ($allLabels as $p) {
            $avgSeries[] = round($avgHistorical, 2);

            if (isset($histMap[$p])) {
                $histSeries[] = (float) $histMap[$p];
            } else {
                $histSeries[] = null;
            }

            if (isset($predMap[$p])) {
                $predSeries[] = (float) $predMap[$p];
                $lowSeries[] = (float) ($lowMap[$p] ?? 0);
                $upSeries[] = (float) ($upMap[$p] ?? 0);
            } elseif ($p === $lastHistPeriod) {
                // Bridge point
                $predSeries[] = (float) $lastHistVal;
                $lowSeries[] = (float) $lastHistVal;
                $upSeries[] = (float) $lastHistVal;
            } else {
                $predSeries[] = null;
                $lowSeries[] = null;
                $upSeries[] = null;
            }
        }

        // Format friendly month-year labels (e.g. Jan '24)
        $monthsId = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
            '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
            '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'
        ];

        $friendlyLabels = array_map(function ($period) use ($monthsId) {
            $parts = explode('-', $period);
            $m = $parts[1] ?? '01';
            $y = substr($parts[0] ?? '2024', -2);
            return ($monthsId[$m] ?? $m) . " '" . $y;
        }, $allLabels);

        return [
            'run' => $run,
            'allLabels' => $allLabels,
            'friendlyLabels' => $friendlyLabels,
            'histSeries' => $histSeries,
            'predSeries' => $predSeries,
            'lowSeries' => $lowSeries,
            'upSeries' => $upSeries,
            'avgSeries' => $avgSeries,
            'avgHistorical' => $avgHistorical,
        ];
    }

    /**
     * Execute Python ARIMA forecasting script safely via Symfony Process.
     */
    public function runForecastProcess(int $horizon = 12, ?string $trainCutoff = '2024-12'): array
    {
        $pythonScript = base_path('python/forecast_arima.py');
        $pythonPath = 'python'; // or configured python binary

        $cmd = [$pythonPath, $pythonScript, '--horizon', (string) $horizon];
        if ($trainCutoff) {
            $cmd[] = '--train-cutoff';
            $cmd[] = $trainCutoff;
        }

        $process = new Process($cmd, base_path(), [
            'PYTHONPATH' => base_path('python')
        ]);
        $process->setTimeout(300); // 5 minutes max

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return [
            'success' => true,
            'output' => $process->getOutput(),
            'run' => $this->getActiveForecastRun()
        ];
    }
}
