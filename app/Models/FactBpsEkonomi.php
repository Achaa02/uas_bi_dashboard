<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactBpsEkonomi extends Model
{
    protected $table = 'fact_bps_ekonomi';

    protected $fillable = [
        'kode_bps',
        'provinsi',
        'pulau',
        'tahun',
        'pengeluaran_makanan_idr',
        'pengeluaran_non_makanan_idr',
        'total_pengeluaran_idr',
        'persentase_makanan',
        'persentase_non_makanan',
    ];

    protected $casts = [
        'pengeluaran_makanan_idr' => 'decimal:2',
        'pengeluaran_non_makanan_idr' => 'decimal:2',
        'total_pengeluaran_idr' => 'decimal:2',
        'persentase_makanan' => 'decimal:2',
        'persentase_non_makanan' => 'decimal:2',
    ];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(DimWilayah::class, 'kode_bps', 'kode_bps');
    }
}
