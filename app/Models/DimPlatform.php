<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DimPlatform extends Model
{
    protected $table = 'dim_platform';
    protected $primaryKey = 'platform_id';
    public $incrementing = false;

    protected $fillable = [
        'platform_id',
        'nama_platform',
    ];
}
