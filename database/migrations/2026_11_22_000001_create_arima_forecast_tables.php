<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forecast_runs', function (Blueprint $table) {
            $table->id();
            $table->string('model_name', 50)->default('ARIMA');
            $table->string('model_order', 30)->default('(2,1,0)');
            $table->string('training_start', 10);
            $table->string('training_end', 10);
            $table->string('forecast_start', 10)->nullable();
            $table->string('forecast_end', 10)->nullable();
            $table->unsignedSmallInteger('horizon_months')->default(12);
            $table->decimal('total_predicted_idr', 18, 2)->nullable();
            $table->decimal('avg_monthly_predicted_idr', 18, 2)->nullable();
            $table->decimal('growth_rate_pct', 6, 2)->nullable();
            $table->decimal('mae', 18, 2)->nullable();
            $table->decimal('rmse', 18, 2)->nullable();
            $table->decimal('mape', 6, 2)->nullable();
            $table->decimal('aic', 10, 2)->nullable();
            $table->decimal('bic', 10, 2)->nullable();
            $table->string('training_status', 30)->default('completed');
            $table->json('parameters_json')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['model_name', 'is_active']);
            $table->index('created_at');
        });

        Schema::create('transaction_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forecast_run_id')->constrained('forecast_runs')->onDelete('cascade');
            $table->string('period', 7)->index(); // YYYY-MM
            $table->date('period_date')->index();
            $table->decimal('actual_value', 18, 2)->nullable();
            $table->decimal('predicted_value', 18, 2);
            $table->decimal('lower_bound', 18, 2);
            $table->decimal('upper_bound', 18, 2);
            $table->decimal('growth_vs_prior_year_pct', 6, 2)->nullable();
            $table->timestamps();

            $table->index(['forecast_run_id', 'period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_forecasts');
        Schema::dropIfExists('forecast_runs');
    }
};
