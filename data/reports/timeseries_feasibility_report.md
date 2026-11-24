# Laporan Kelayakan Deret Waktu (Time Series Feasibility Report)
**Tanggal Audit:** 2026-11-22 13:40:45  
**Target Prediksi:** `nilai_transaksi_netto_idr` (Total Nilai Transaksi Netto Bulanan IDR)  

## 1. Ringkasan Observasi
- **Total Observasi:** 33 periode bulanan
- **Rentang Periode:** 2024-02 s.d. 2026-10
- **Kelayakan Model:** **LAYAK (FEASIBLE)**

## 2. Pemeriksaan Kualitas & Kontinuitas
| Item Pemeriksaan | Hasil | Status |
| :--- | :--- | :--- |
| Missing Values | 0 | PASS: Tidak ada nilai null atau negatif. |
| Nilai Negatif / Tidak Valid | 0 | PASS: Tidak ada nilai null atau negatif. |
| Kontinuitas Periode | 33/33 bulan | PASS: Seluruh periode berurutan secara kontinu tanpa gap. |
| Kecukupan Sampel | 33 bulan | PASS: Jumlah observasi (33 bulan) mencukupi untuk pemodelan deret waktu bulanan. |
| Deteksi Outlier (IQR) | 1 observasi | 2026-10 |

## 3. Uji Stasioneritas (Augmented Dickey-Fuller)
- **Deret Asli (Level, d=0):**
  - ADF Statistic: -3.4846
  - p-value: 0.0084
  - Kesimpulan: Stasioner (p < 0.05)
- **First Difference (d=1):**
  - ADF Statistic: -6.6841
  - p-value: 0.0000
  - Kesimpulan: Stasioner pada first difference (d=1)

## 4. Kesimpulan & Rekomendasi
Data deret waktu layak untuk ARIMA. Differencing yang direkomendasikan adalah d=0.
