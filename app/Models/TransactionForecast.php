<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionForecast extends Model
{
    use HasFactory;

    protected $table = 'transaction_forecasts';

    protected $fillable = [
        'forecast_run_id',
        'period',
        'period_date',
        'actual_value',
        'predicted_value',
        'lower_bound',
        'upper_bound',
        'growth_vs_prior_year_pct',
    ];

    protected $casts = [
        'period_date' => 'date',
        'actual_value' => 'decimal:2',
        'predicted_value' => 'decimal:2',
        'lower_bound' => 'decimal:2',
        'upper_bound' => 'decimal:2',
        'growth_vs_prior_year_pct' => 'decimal:2',
    ];

    public function run(): BelongsTo
    {
        return $this->belongsTo(ForecastRun::class, 'forecast_run_id');
    }
}
