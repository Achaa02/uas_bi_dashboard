# Dokumentasi Sumber Data GeoJSON Peta Indonesia 38 Provinsi

Proyek Penelitian: **Perancangan Dashboard Business Intelligence untuk Pemetaan Pola Konsumsi dan Daya Beli Digital Berbasis Analisis Big Data**

## 1. Identitas Berkas Spasial
- **Nama Berkas**: `public/geojson/indonesia-38-provinces.geojson`
- **Format**: GeoJSON (RFC 7946)
- **Sistem Referensi Koordinat (CRS)**: WGS 84 / EPSG:4326 (Latitude, Longitude)
- **Ukuran Berkas**: ~80.8 KB (Dioptimasi untuk performa web dan visualisasi Leaflet.js)
- **Jumlah Fitur Poligon**: 38 Provinsi lengkap (100% wilayah Indonesia)

## 2. Sumber Data & Lisensi
- **Sumber Data Peta Dasar**: Badan Informasi Geospasial (BIG) dan Badan Pusat Statistik (BPS) Republik Indonesia.
- **Penyedia Repositori / Distribusi Digital**: Repository publik `denyherianto/indonesia-geojson-topojson-maps-with-38-provinces` (Lisensi Open Data / ODbL & MIT).
- **Pembaruan Wilayah Otonomi Baru (DOB)**:
  Telah mencakup 4 provinsi pemekaran baru di Tanah Papua sesuai Undang-Undang Republik Indonesia tahun 2022:
  1. **Papua Barat Daya** (`kode_bps`: 92)
  2. **Papua Selatan** (`kode_bps`: 93)
  3. **Papua Tengah** (`kode_bps`: 95)
  4. **Papua Pegunungan** (`kode_bps`: 96)
  Serta provinsi induk:
  5. **Papua Barat** (`kode_bps`: 91)
  6. **Papua** (`kode_bps`: 94)

## 3. Skema Properti Fitur (Feature Properties)
Setiap poligon provinsi dalam GeoJSON memiliki properti terstandarisasi sebagai berikut:

```json
{
  "type": "Feature",
  "id": "31",
  "properties": {
    "kode_bps": "31",
    "provinsi": "DKI Jakarta",
    "sumber": "Badan Informasi Geospasial (BIG) & BPS RI 38 Provinsi (2024)",
    "id_asli": "31"
  },
  "geometry": {
    "type": "MultiPolygon",
    "coordinates": [...]
  }
}
```

## 4. Mekanisme Relasi Relasional Database (Primary Join Key)
- Kolom penghubung utama (*join key*) adalah **`kode_bps`** bertipe string (2 digit: `'11'` s.d. `'96'`).
- Terhubung secara langsung dengan kolom `kode_bps` pada:
  - Tabel `sample_transaksi_ecommerce`
  - Tabel `dim_wilayah`
  - Tabel `fact_ecommerce_bulanan`
  - Tabel `fact_integrasi_daya_beli`
- Menjamin integritas spasial tanpa ketergantungan pada perbedaan ejaan nama daerah (*spelling variations*).
