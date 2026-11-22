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
        // 1. Dimensi Wilayah
        Schema::create('dim_wilayah', function (Blueprint $table) {
            $table->string('kode_bps', 10)->primary();
            $table->string('nama_provinsi', 100)->index();
            $table->string('pulau', 50)->index();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamps();
        });

        // 2. Dimensi Kategori Produk
        Schema::create('dim_kategori', function (Blueprint $table) {
            $table->unsignedInteger('kategori_id')->primary();
            $table->string('nama_kategori', 100)->unique();
            $table->timestamps();
        });

        // 3. Dimensi Platform E-Commerce
        Schema::create('dim_platform', function (Blueprint $table) {
            $table->unsignedInteger('platform_id')->primary();
            $table->string('nama_platform', 100)->unique();
            $table->timestamps();
        });

        // 4. Dimensi Waktu
        Schema::create('dim_waktu', function (Blueprint $table) {
            $table->unsignedInteger('waktu_id')->primary();
            $table->unsignedSmallInteger('tahun')->index();
            $table->unsignedTinyInteger('bulan')->index();
            $table->string('tahun_bulan', 7)->index();
            $table->string('kuartal', 10);
            $table->timestamps();
        });

        // 5. Fakta Statistik BPS Ekonomi
        Schema::create('fact_bps_ekonomi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bps', 10)->index();
            $table->string('provinsi', 100)->index();
            $table->string('pulau', 50)->index();
            $table->unsignedSmallInteger('tahun')->index();
            $table->decimal('pengeluaran_makanan_idr', 15, 2)->nullable();
            $table->decimal('pengeluaran_non_makanan_idr', 15, 2)->nullable();
            $table->decimal('total_pengeluaran_idr', 15, 2)->nullable();
            $table->decimal('persentase_makanan', 5, 2)->nullable();
            $table->decimal('persentase_non_makanan', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('kode_bps')->references('kode_bps')->on('dim_wilayah')->onDelete('cascade');
        });

        // 6. Fakta E-Commerce Agregat Bulanan
        Schema::create('fact_ecommerce_bulanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bps', 10)->index();
            $table->string('provinsi', 100)->index();
            $table->unsignedSmallInteger('tahun')->index();
            $table->unsignedTinyInteger('bulan')->index();
            $table->string('tahun_bulan', 7)->index();
            $table->string('platform_ecommerce', 100)->index();
            $table->string('kategori_produk', 100)->index();
            $table->unsignedInteger('total_transaksi');
            $table->unsignedInteger('total_kuantitas');
            $table->decimal('total_bruto_idr', 18, 2);
            $table->decimal('total_diskon_voucher_idr', 18, 2);
            $table->decimal('total_ongkir_riil_idr', 18, 2);
            $table->decimal('total_subsidi_ongkir_idr', 18, 2);
            $table->decimal('total_netto_idr', 18, 2);
            $table->decimal('avg_nilai_transaksi', 18, 2);
            $table->decimal('avg_rating', 3, 2);
            $table->decimal('persentase_repeat_order', 5, 2);
            $table->decimal('persentase_tepat_waktu', 5, 2);
            $table->decimal('avg_durasi_hari', 5, 2);
            $table->decimal('avg_sensitivitas_ongkir', 6, 4);
            $table->decimal('avg_skor_loyalitas', 6, 4);
            $table->decimal('persentase_churn_tinggi', 5, 2);
            $table->timestamps();

            $table->foreign('kode_bps')->references('kode_bps')->on('dim_wilayah')->onDelete('cascade');
        });

        // 7. Fakta Terintegrasi Daya Beli Digital & Statistik BPS
        Schema::create('fact_integrasi_daya_beli', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bps', 10)->index();
            $table->string('provinsi', 100)->index();
            $table->string('pulau', 50)->index();
            $table->unsignedSmallInteger('tahun')->index();
            $table->unsignedInteger('ecom_total_transaksi');
            $table->unsignedInteger('ecom_total_kuantitas');
            $table->decimal('ecom_total_bruto_idr', 18, 2);
            $table->decimal('ecom_total_diskon_voucher_idr', 18, 2);
            $table->decimal('ecom_total_ongkir_riil_idr', 18, 2);
            $table->decimal('ecom_total_subsidi_ongkir_idr', 18, 2);
            $table->decimal('ecom_total_netto_idr', 18, 2);
            $table->decimal('ecom_aov_idr', 18, 2);
            $table->decimal('avg_rating', 3, 2)->nullable();
            $table->decimal('persentase_repeat_order', 5, 2)->nullable();
            $table->decimal('avg_durasi_hari', 5, 2)->nullable();
            $table->decimal('avg_sensitivitas_ongkir', 6, 4)->nullable();
            $table->decimal('avg_skor_loyalitas', 6, 4)->nullable();
            $table->decimal('pengeluaran_makanan_idr', 15, 2)->nullable();
            $table->decimal('pengeluaran_non_makanan_idr', 15, 2)->nullable();
            $table->decimal('total_pengeluaran_idr', 15, 2)->nullable();
            $table->decimal('persentase_makanan', 5, 2)->nullable();
            $table->decimal('persentase_non_makanan', 5, 2)->nullable();
            $table->decimal('rasio_aov_thd_non_makanan_bps', 8, 4)->nullable();
            $table->decimal('rasio_aov_thd_total_pengeluaran_bps', 8, 4)->nullable();
            $table->string('tipologi_daya_beli_digital', 150)->index();
            $table->timestamps();

            $table->foreign('kode_bps')->references('kode_bps')->on('dim_wilayah')->onDelete('cascade');
        });

        // 8. Tabel Sampel Transaksi Real untuk Drill-down Detail
        Schema::create('sample_transaksi_ecommerce', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 30)->unique();
            $table->string('transaksi_id', 30)->index();
            $table->string('kategori_produk', 100)->index();
            $table->string('platform_ecommerce', 100)->index();
            $table->string('provinsi', 100)->index();
            $table->string('kode_bps', 10)->index();
            $table->decimal('nilai_transaksi_bruto_idr', 15, 2);
            $table->decimal('diskon_voucher_platform_idr', 15, 2);
            $table->decimal('ongkos_kirim_riil_idr', 15, 2);
            $table->decimal('subsidi_gratis_ongkir_idr', 15, 2);
            $table->decimal('nilai_transaksi_netto_idr', 15, 2);
            $table->string('metode_pembayaran', 100);
            $table->string('layanan_ekspedisi', 100);
            $table->unsignedTinyInteger('durasi_pengiriman_hari');
            $table->string('status_keterlambatan_pengiriman', 50);
            $table->unsignedTinyInteger('rating_produk');
            $table->string('status_repeat_order', 10);
            $table->unsignedTinyInteger('usia_pembeli');
            $table->string('gender_pembeli', 20);
            $table->timestamp('timestamp_transaksi')->index();
            $table->unsignedSmallInteger('tahun')->index();
            $table->unsignedTinyInteger('bulan')->index();
            $table->decimal('indeks_sensitivitas_ongkir', 6, 4)->nullable();
            $table->decimal('skor_loyalitas_pelanggan', 6, 4)->nullable();
            $table->string('kategori_risiko_churn', 30)->nullable();
            $table->timestamps();

            $table->foreign('kode_bps')->references('kode_bps')->on('dim_wilayah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_transaksi_ecommerce');
        Schema::dropIfExists('fact_integrasi_daya_beli');
        Schema::dropIfExists('fact_ecommerce_bulanan');
        Schema::dropIfExists('fact_bps_ekonomi');
        Schema::dropIfExists('dim_waktu');
        Schema::dropIfExists('dim_platform');
        Schema::dropIfExists('dim_kategori');
        Schema::dropIfExists('dim_wilayah');
    }
};
