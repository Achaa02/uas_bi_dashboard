<?php

namespace App\Console\Commands;

use App\Services\ArimaForecastService;
use Illuminate\Console\Command;

class RunArimaForecastCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arima:forecast 
                            {--horizon=12 : Horizon forecast in months (default: 12)} 
                            {--train-cutoff=2024-12 : Optional training cutoff period (default: 2024-12)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute Python ARIMA model to train and forecast monthly e-commerce transaction net values into MySQL';

    /**
     * Execute the console command.
     */
    public function handle(ArimaForecastService $service): int
    {
        $horizon = (int) $this->option('horizon');
        $cutoff = $this->option('train-cutoff') ?: null;

        $this->info("=== Starting ARIMA Transaction Value Forecasting ===");
        $this->info("Forecast Horizon : {$horizon} months");
        $this->info("Training Cutoff  : " . ($cutoff ?: 'Full available series'));

        try {
            $result = $service->runForecastProcess($horizon, $cutoff);

            $this->line($result['output']);
            $run = $result['run'];

            if ($run) {
                $this->info("✓ Forecast process completed successfully!");
                $this->table(
                    ['Run ID', 'Model', 'Order', 'Training Range', 'Forecast Range', 'MAPE', 'Total Predicted IDR'],
                    [[
                        $run->id,
                        $run->model_name,
                        $run->model_order,
                        "{$run->training_start} s.d {$run->training_end}",
                        "{$run->forecast_start} s.d {$run->forecast_end}",
                        "{$run->mape}%",
                        "Rp " . number_format($run->total_predicted_idr, 2, ',', '.')
                    ]]
                );
            }

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("ARIMA Forecast process failed: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
