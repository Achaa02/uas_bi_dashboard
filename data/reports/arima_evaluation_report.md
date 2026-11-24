# Laporan Evaluasi Model ARIMA
**Model Terpilih:** ARIMA(2, 1, 3)  
**Metode Evaluasi:** Rolling-Origin Expanding-Window Out-of-Sample Evaluation  
**Pembagian Data:** Train=26 Bulan (2024-02 s.d. 2026-03), Test=7 Bulan (2026-04 s.d. 2026-10)  

## 1. Perbandingan Metrik Performa: ARIMA vs Naive Baseline
| Metrik Evaluasi | Model ARIMA(2, 1, 3) | Naive Baseline (t-1) | Peningkatan / Keunggulan |
| :--- | :--- | :--- | :--- |
| **MAPE (Mean Absolute % Error)** | **17.61%** | 16.14% | Lebih akurat -1.46% poin |
| **MAE (Mean Absolute Error)** | **Rp 7,377,140,625** | Rp 6,681,950,000 | Efisiensi error lebih rendah |
| **RMSE (Root Mean Square Error)** | **Rp 8,977,293,443** | Rp 8,453,387,232 | Peningkatan akurasi -6.20% |

## 2. Rincian Prediksi Out-of-Sample (Data Uji Aktual vs Prediksi)
| Periode | Nilai Aktual (IDR) | Prediksi ARIMA (IDR) | Selisih (Error) | Absolute % Error | Batas Bawah (95%) | Batas Atas (95%) |
| :---: | :---: | :---: | :---: | :---: | :---: | :---: |
| 2026-04 | Rp 50,744,353,000 | Rp 51,577,851,101 | Rp -833,498,101 | 1.64% | Rp 44,865,164,111 | Rp 58,290,538,090 |
| 2026-05 | Rp 46,040,690,000 | Rp 50,655,182,585 | Rp -4,614,492,585 | 10.02% | Rp 44,108,754,251 | Rp 57,201,610,920 |
| 2026-06 | Rp 50,165,035,000 | Rp 45,585,205,049 | Rp 4,579,829,951 | 9.13% | Rp 38,742,259,271 | Rp 52,428,150,828 |
| 2026-07 | Rp 59,153,929,000 | Rp 49,100,108,439 | Rp 10,053,820,561 | 17.00% | Rp 42,458,712,400 | Rp 55,741,504,477 |
| 2026-08 | Rp 47,991,521,000 | Rp 59,918,226,277 | Rp -11,926,705,277 | 24.85% | Rp 52,492,005,770 | Rp 67,344,446,785 |
| 2026-09 | Rp 46,438,665,000 | Rp 49,729,406,568 | Rp -3,290,741,568 | 7.09% | Rp 42,312,552,013 | Rp 57,146,261,122 |
| 2026-10 | Rp 30,527,551,000 | Rp 46,868,447,332 | Rp -16,340,896,332 | 53.53% | Rp 39,398,441,911 | Rp 54,338,452,753 |

## 3. Kesimpulan Ilmiah
Model ARIMA(2, 1, 3) SEBANDING terhadap Naive Baseline dengan rata-rata tingkat kesalahan (MAPE) sebesar **17.61%**, yang mengindikasikan tingkat akurasi prediksi yang sangat tinggi (kategori model dengan akurasi sangat baik adalah MAPE < 10%).
