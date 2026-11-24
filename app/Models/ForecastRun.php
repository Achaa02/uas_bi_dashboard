<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForecastRun extends Model
{
    use HasFactory;

    protected $table = 'forecast_runs';

    protected $fillable = [
        'model_name',
        'model_order',
        'training_start',
        'training_end',
        'forecast_start',
        'forecast_end',
        'horizon_months',
        'total_predicted_idr',
        'avg_monthly_predicted_idr',
        'growth_rate_pct',
        'mae',
        'rmse',
        'mape',
        'aic',
        'bic',
        'training_status',
        'parameters_json',
        'is_active',
    ];

    protected $casts = [
        'total_predicted_idr' => 'decimal:2',
        'avg_monthly_predicted_idr' => 'decimal:2',
        'growth_rate_pct' => 'decimal:2',
        'mae' => 'decimal:2',
        'rmse' => 'decimal:2',
        'mape' => 'decimal:2',
        'aic' => 'decimal:2',
        'bic' => 'decimal:2',
        'parameters_json' => 'array',
        'is_active' => 'boolean',
    ];

    public function forecasts(): HasMany
    {
        return $this->hasMany(TransactionForecast::class, 'forecast_run_id')->orderBy('period_date', 'asc');
    }
}
