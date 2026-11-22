<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactIntegrasiDayaBeli extends Model
{
    protected $table = 'fact_integrasi_daya_beli';

    protected $fillable = [
        'kode_bps',
        'provinsi',
        'pulau',
        'tahun',
        'ecom_total_transaksi',
        'ecom_total_kuantitas',
        'ecom_total_bruto_idr',
        'ecom_total_diskon_voucher_idr',
        'ecom_total_ongkir_riil_idr',
        'ecom_total_subsidi_ongkir_idr',
        'ecom_total_netto_idr',
        'ecom_aov_idr',
        'avg_rating',
        'persentase_repeat_order',
        'avg_durasi_hari',
        'avg_sensitivitas_ongkir',
        'avg_skor_loyalitas',
        'pengeluaran_makanan_idr',
        'pengeluaran_non_makanan_idr',
        'total_pengeluaran_idr',
        'persentase_makanan',
        'persentase_non_makanan',
        'rasio_aov_thd_non_makanan_bps',
        'rasio_aov_thd_total_pengeluaran_bps',
        'tipologi_daya_beli_digital',
    ];

    protected $casts = [
        'ecom_total_bruto_idr' => 'decimal:2',
        'ecom_total_diskon_voucher_idr' => 'decimal:2',
        'ecom_total_ongkir_riil_idr' => 'decimal:2',
        'ecom_total_subsidi_ongkir_idr' => 'decimal:2',
        'ecom_total_netto_idr' => 'decimal:2',
        'ecom_aov_idr' => 'decimal:2',
        'avg_rating' => 'decimal:2',
        'persentase_repeat_order' => 'decimal:2',
        'avg_durasi_hari' => 'decimal:2',
        'avg_sensitivitas_ongkir' => 'decimal:4',
        'avg_skor_loyalitas' => 'decimal:4',
        'pengeluaran_makanan_idr' => 'decimal:2',
        'pengeluaran_non_makanan_idr' => 'decimal:2',
        'total_pengeluaran_idr' => 'decimal:2',
        'persentase_makanan' => 'decimal:2',
        'persentase_non_makanan' => 'decimal:2',
        'rasio_aov_thd_non_makanan_bps' => 'decimal:4',
        'rasio_aov_thd_total_pengeluaran_bps' => 'decimal:4',
    ];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(DimWilayah::class, 'kode_bps', 'kode_bps');
    }
}
