<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DimWaktu extends Model
{
    protected $table = 'dim_waktu';
    protected $primaryKey = 'waktu_id';
    public $incrementing = false;

    protected $fillable = [
        'waktu_id',
        'tahun',
        'bulan',
        'tahun_bulan',
        'kuartal',
    ];
}
