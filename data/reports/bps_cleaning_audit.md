# Laporan Audit Pembersihan Data BPS (BPS Cleaning Audit)

- **Total Observasi**: 570 baris panel (Provinsi-Tahun)
- **Cakupan Wilayah**: 38 Provinsi (38 Provinsi BPS)
- **Rentang Periode**: 2011 s.d. 2025

## Ringkasan Agregat Nasional (Rata-rata 2024–2025)

| Tahun | Rata-rata Makanan (Rp) | Rata-rata Non-Makanan (Rp) | Rata-rata Total Pengeluaran (Rp) | % Makanan | % Non-Makanan |
| :--- | :--- | :--- | :--- | :--- | :--- |
| 2024 | Rp 770,195 | Rp 745,241 | Rp 1,515,437 | 51.38% | 48.62% |
| 2025 | Rp 796,648 | Rp 793,014 | Rp 1,589,662 | 50.74% | 49.26% |

## Catatan Transformasi:
1. Spasi ribuan pada data mentah BPS telah dikonversi ke numerik standar.
2. Nama provinsi dengan anotasi catatan kaki (misal `Kalimantan Utara 1)`) telah dinormalisasi.
3. Wilayah diklasifikasikan ke dalam 6 gugus pulau utama di Indonesia.
4. Kode BPS resmi 2-digit disematkan untuk menjamin kompatibilitas relasional.
