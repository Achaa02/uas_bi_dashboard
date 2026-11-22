<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DimWilayah extends Model
{
    protected $table = 'dim_wilayah';
    protected $primaryKey = 'kode_bps';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_bps',
        'nama_provinsi',
        'pulau',
        'latitude',
        'longitude',
    ];

    public function bpsEkonomi(): HasMany
    {
        return $this->hasMany(FactBpsEkonomi::class, 'kode_bps', 'kode_bps');
    }

    public function ecomBulanan(): HasMany
    {
        return $this->hasMany(FactEcommerceBulanan::class, 'kode_bps', 'kode_bps');
    }

    public function integrasiDayaBeli(): HasMany
    {
        return $this->hasMany(FactIntegrasiDayaBeli::class, 'kode_bps', 'kode_bps');
    }

    public function sampleTransaksi(): HasMany
    {
        return $this->hasMany(SampleTransaksiEcommerce::class, 'kode_bps', 'kode_bps');
    }
}
