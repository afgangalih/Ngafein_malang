import pytest
from app.preprocessing import (
    hitung_durasi,
    skala_harga,
    skala_rating,
    skala_jarak,
    skala_fasilitas,
    skala_menu,
    skala_durasi
)

def test_hitung_durasi_normal():
    # Skenario 1: Jam tutup setelah jam buka (tidak melewati tengah malam)
    assert hitung_durasi("08:00", "22:00") == 14.0
    
    # Skenario 2: Jam tutup sebelum jam buka (melewati tengah malam)
    # 22:00 -> 07:00 = 9.0 jam
    assert hitung_durasi("22:00", "07:00") == 9.0

def test_hitung_durasi_invalid():
    # Skenario 3: Input kosong atau invalid format
    assert hitung_durasi("", "22:00") == 0.0
    assert hitung_durasi("08:00", "") == 0.0
    assert hitung_durasi("invalid", "invalid") == 0.0

def test_skala_harga():
    # Harga murah
    assert skala_harga(15000) == 1
    assert skala_harga(25000) == 1
    # Harga sedang
    assert skala_harga(35000) == 2
    assert skala_harga(50000) == 2
    # Harga mahal
    assert skala_harga(75000) == 3
    # Harga ekstrem (nol/negatif)
    assert skala_harga(0) == 1
    assert skala_harga(-1000) == 1

def test_skala_rating():
    # Rating batas atas
    assert skala_rating(5.0) == 5
    assert skala_rating(5.5) == 5
    # Rating normal
    assert skala_rating(4.7) == 4
    assert skala_rating(4.5) == 3
    assert skala_rating(4.3) == 2
    # Rating batas bawah
    assert skala_rating(3.5) == 1
    # Rating ekstrem (negatif)
    assert skala_rating(-1.0) == 1

def test_skala_jarak():
    # Sangat dekat
    assert skala_jarak(0.5) == 1
    # Dekat
    assert skala_jarak(1.5) == 2
    # Jauh
    assert skala_jarak(5.0) == 4
    # Sangat jauh / ekstrem
    assert skala_jarak(10000.0) == 5

def test_skala_fasilitas():
    # Fasilitas sedikit
    assert skala_fasilitas(1) == 1
    assert skala_fasilitas(2) == 1
    # Fasilitas sedang
    assert skala_fasilitas(5) == 3
    # Fasilitas banyak
    assert skala_fasilitas(10) == 5
    # Jumlah ekstrem
    assert skala_fasilitas(-2) == 1
    assert skala_fasilitas(100) == 5

def test_skala_menu():
    # Menu sedikit
    assert skala_menu(1) == 1
    # Menu sedang
    assert skala_menu(5) == 3
    # Menu banyak
    assert skala_menu(20) == 5

def test_skala_durasi():
    # Singkat
    assert skala_durasi(4.0) == 1
    # Sedang
    assert skala_durasi(12.0) == 3
    # Sangat lama / 24 jam
    assert skala_durasi(24.0) == 5
