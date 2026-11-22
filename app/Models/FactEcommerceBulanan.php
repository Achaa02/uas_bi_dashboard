<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactEcommerceBulanan extends Model
{
    protected $table = 'fact_ecommerce_bulanan';

    protected $fillable = [
        'kode_bps',
        'provinsi',
        'tahun',
        'bulan',
        'tahun_bulan',
        'platform_ecommerce',
        'kategori_produk',
        'total_transaksi',
        'total_kuantitas',
        'total_bruto_idr',
        'total_diskon_voucher_idr',
        'total_ongkir_riil_idr',
        'total_subsidi_ongkir_idr',
        'total_netto_idr',
        'avg_nilai_transaksi',
        'avg_rating',
        'persentase_repeat_order',
        'persentase_tepat_waktu',
        'avg_durasi_hari',
        'avg_sensitivitas_ongkir',
        'avg_skor_loyalitas',
        'persentase_churn_tinggi',
    ];

    protected $casts = [
        'total_bruto_idr' => 'decimal:2',
        'total_diskon_voucher_idr' => 'decimal:2',
        'total_ongkir_riil_idr' => 'decimal:2',
        'total_subsidi_ongkir_idr' => 'decimal:2',
        'total_netto_idr' => 'decimal:2',
        'avg_nilai_transaksi' => 'decimal:2',
        'avg_rating' => 'decimal:2',
        'persentase_repeat_order' => 'decimal:2',
        'persentase_tepat_waktu' => 'decimal:2',
        'avg_durasi_hari' => 'decimal:2',
        'avg_sensitivitas_ongkir' => 'decimal:4',
        'avg_skor_loyalitas' => 'decimal:4',
        'persentase_churn_tinggi' => 'decimal:2',
    ];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(DimWilayah::class, 'kode_bps', 'kode_bps');
    }
}
