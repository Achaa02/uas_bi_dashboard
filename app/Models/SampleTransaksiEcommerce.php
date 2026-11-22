<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleTransaksiEcommerce extends Model
{
    protected $table = 'sample_transaksi_ecommerce';

    protected $fillable = [
        'order_id',
        'transaksi_id',
        'kategori_produk',
        'platform_ecommerce',
        'provinsi',
        'kode_bps',
        'nilai_transaksi_bruto_idr',
        'diskon_voucher_platform_idr',
        'ongkos_kirim_riil_idr',
        'subsidi_gratis_ongkir_idr',
        'nilai_transaksi_netto_idr',
        'metode_pembayaran',
        'layanan_ekspedisi',
        'durasi_pengiriman_hari',
        'status_keterlambatan_pengiriman',
        'rating_produk',
        'status_repeat_order',
        'usia_pembeli',
        'gender_pembeli',
        'timestamp_transaksi',
        'tahun',
        'bulan',
        'indeks_sensitivitas_ongkir',
        'skor_loyalitas_pelanggan',
        'kategori_risiko_churn',
    ];

    protected $casts = [
        'nilai_transaksi_bruto_idr' => 'decimal:2',
        'diskon_voucher_platform_idr' => 'decimal:2',
        'ongkos_kirim_riil_idr' => 'decimal:2',
        'subsidi_gratis_ongkir_idr' => 'decimal:2',
        'nilai_transaksi_netto_idr' => 'decimal:2',
        'timestamp_transaksi' => 'datetime',
        'indeks_sensitivitas_ongkir' => 'decimal:4',
        'skor_loyalitas_pelanggan' => 'decimal:4',
    ];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(DimWilayah::class, 'kode_bps', 'kode_bps');
    }
}
