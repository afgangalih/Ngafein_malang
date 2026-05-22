# Arsitektur: Migrasi Engine Perhitungan SAW ke Python

**Status:** Deployed & Stable  
**Komponen yang Terdampak:** Sistem Rekomendasi Kafe (SAW)

---

## 1. Latar Belakang Keputusan (Why Python?)
Sebelumnya, seluruh logika komputasi matriks *Simple Additive Weighting* (SAW) berada di dalam layer `Controller` atau `Service` Laravel (PHP). 

Meskipun PHP mampu melakukan perhitungan dasar, kita telah memutuskan untuk memisahkan logika matematika (algoritma) ke **Python FastAPI** karena beberapa alasan strategis:
1. **Performa & Skalabilitas Matematis:** Python memiliki ekosistem yang jauh lebih optimal untuk menangani manipulasi matriks, perhitungan bobot, dan struktur data yang rumit.
2. **Pemisahan Tanggung Jawab (Separation of Concerns):** Laravel sekarang fokus murni pada hal yang ia kuasai: *Routing, Authentication, Query Database*, dan rendering UI (Blade). Hal ini mencegah *Controller* PHP menjadi kotor (bloated).
3. **Future-Proof untuk AI (Kecerdasan Buatan):** Mengamankan fondasi proyek. Jika ke depan kita ingin mengembangkan sistem ini menjadi *Machine Learning* murni atau menambahkan fitur *Natural Language Processing* (NLP) untuk analisis sentimen, environment Python sudah siap sejak hari ini.

## 2. Arsitektur Komunikasi Baru (Microservice)

Proyek ini sekarang menganut arsitektur terdistribusi ringan (Lightweight Microservice) yang berada di dalam satu monorepo.

*   **Front-facing (Port 8000):** Laravel (`web-app/`). Bertindak sebagai pelayan yang berinteraksi langsung dengan pengguna.
*   **Back-facing (Port 8001):** FastAPI Python (`engine/`). Bertindak sebagai otak di balik layar yang hanya bisa diakses oleh Laravel.

**Data Flow (Alur Kerja):**
1. User memasukkan filter (misal: "Buka 24 jam") di halaman rekomendasi web.
2. Laravel memfilter data kafe dari database MySQL (menggunakan `WHERE` clause).
3. Daripada menghitung skor sendiri, Laravel membungkus daftar kafe yang lolos filter beserta **Bobot Preferensi** ke dalam format JSON.
4. Laravel menembak API ke Python secara internal melalui HTTP POST `http://127.0.0.1:8001/api/saw/calculate`.
5. Python menerima JSON, membuat matriks keputusan, menormalisasi data sesuai aturan Cost/Benefit, mengalikan dengan bobot, melakukan sorting, lalu mengembalikan data ranking ke Laravel dalam bentuk JSON.
6. Laravel merender tampilan. Seluruh proses ini terjadi dalam hitungan milidetik.

## 3. Fitur Keamanan: Graceful Degradation (Anti-Crash)

Satu masalah terbesar dari arsitektur terpisah adalah: *"Bagaimana jika server Python mati atau error?"*

Kita telah menerapkan prinsip *Best Practice* bernama **Graceful Degradation**. Jika API Python gagal dihubungi (karena mati, timeout >10 detik, atau error internal), sistem Laravel **TIDAK AKAN CRASH** (menampilkan halaman error 500/Ignition). 

Sebaliknya, Laravel akan menangkap (*catch*) error tersebut dan:
1. Menampilkan sebuah *Banner Peringatan* berwarna oranye di UI bahwa server rekomendasi sedang offline.
2. Menyembunyikan elemen visual *Ranking SAW* dan *Progress Bar Skor*.
3. Tetap merender daftar kafe hasil filter apa adanya secara normal, sehingga web tetap bisa diakses dan digunakan oleh pengguna.

## 4. Struktur Folder Engine (Python)

Seluruh logika matematika berada di direktori `engine/`.

*   `main.py`: Entry point server FastAPI.
*   `schemas.py`: Kontrak Data (Pydantic Models). Memastikan tipe data yang masuk dari Laravel valid dan tidak berantakan.
*   `saw_engine.py`: Algoritma utama perakitan matriks dan perangkingan.
*   `preprocessing.py`: Berisi logika spesifik mengubah data mentah (misal: jam operasional "08:00 - 22:00") menjadi angka rasional (durasi jam), serta pengskalaan (1-5) untuk harga dan jarak.

## 5. Cara Menjalankan Proyek (Developer Setup)

Karena sekarang kita memiliki dua server, setiap anggota tim harus menyalakan keduanya saat *development*. Buka dua terminal terpisah:

**Terminal 1 (Menjalankan Web/Laravel):**
```bash
cd web-app
php artisan serve
# Jangan lupa jalankan npm run dev di terminal lain jika mengedit frontend
```

**Terminal 2 (Menjalankan Engine/Python):**
```bash
cd engine
pip install -r requirements.txt
python api.py
```
*(Catatan: Pastikan menggunakan Python versi 3.9 atau lebih baru).*

## 6. Catatan Deployment (Production)

Saat aplikasi ini dikumpulkan atau dipublikasikan (online), kita tidak perlu menyewa dua VPS terpisah yang mahal. Sesuai keputusan tim (merujuk pada dokumen Cloudflare), kita akan menjalankan proyek ini murni di laptop/komputer lokal dan mengekspos port 8000 Laravel menggunakan **Cloudflare Tunnel**.

Laravel akan tetap bisa "berbicara" dengan Python di `127.0.0.1:8001` secara lokal di dalam laptop yang menjalankan *tunnel* tersebut, menjamin keamanan API Python agar tidak terpapar langsung ke publik internet.
