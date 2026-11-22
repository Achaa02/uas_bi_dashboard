<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DimKategori extends Model
{
    protected $table = 'dim_kategori';
    protected $primaryKey = 'kategori_id';
    public $incrementing = false;

    protected $fillable = [
        'kategori_id',
        'nama_kategori',
    ];
}
