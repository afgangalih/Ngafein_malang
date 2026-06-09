import pytest
from app.saw_engine import hitung_saw_proses
from app.schemas import CafeInput, BobotInput

def test_hitung_saw_proses_empty_list():
    # Menguji jika kafe kosong
    bobot = BobotInput(harga=0.2, rating=0.2, jarak=0.2, fasilitas=0.2, menu=0.1, jam_operasional=0.1)
    response = hitung_saw_proses([], bobot)
    
    assert len(response.hasil) == 0
    assert len(response.matriks) == 0
    assert len(response.normalisasi) == 0

def test_hitung_saw_proses_single_cafe():
    # Menguji perhitungan untuk satu kafe
    cafes = [
        CafeInput(
            id_kafe=1,
            nama_kafe="Kafe A",
            alamat="Alamat A",
            rating=4.5,
            jarak=1.5,
            harga_min=15000,
            harga_max=30000,
            jam_buka="08:00",
            jam_tutup="22:00",
            fasilitas_count=5,
            menu_count=10,
            gambar="gambar.jpg"
        )
    ]
    bobot = BobotInput(harga=0.2, rating=0.2, jarak=0.2, fasilitas=0.2, menu=0.1, jam_operasional=0.1)
    
    response = hitung_saw_proses(cafes, bobot)
    
    # Karena hanya ada 1 kafe, normalisasi semua kriteria bernilai 1.0 (karena min/max sama)
    # Skor total = sum(bobot) = 1.0
    assert len(response.hasil) == 1
    assert response.hasil[0].skor == 1.0
    assert response.hasil[0].ranking == 1
    assert response.hasil[0].nama_kafe == "Kafe A"

def test_hitung_saw_harga_nol_dan_negatif():
    # Menguji harga 0 dan negatif
    cafes = [
        CafeInput(
            id_kafe=1, nama_kafe="Kafe Murah", alamat="Alamat", rating=4.5, jarak=1.5,
            harga_min=0, harga_max=0, jam_buka="08:00", jam_tutup="22:00",
            fasilitas_count=5, menu_count=10, gambar=""
        ),
        CafeInput(
            id_kafe=2, nama_kafe="Kafe Negatif", alamat="Alamat", rating=4.5, jarak=1.5,
            harga_min=-5000, harga_max=0, jam_buka="08:00", jam_tutup="22:00",
            fasilitas_count=5, menu_count=10, gambar=""
        )
    ]
    bobot = BobotInput(harga=0.2, rating=0.2, jarak=0.2, fasilitas=0.2, menu=0.1, jam_operasional=0.1)
    response = hitung_saw_proses(cafes, bobot)
    
    # Skala harga untuk <= 25000 adalah 1.
    # Maka min_harga = 1, m.harga = 1, normalisasi harga = 1.0 (aman dari pembagian nol)
    assert len(response.hasil) == 2
    assert response.hasil[0].skor > 0.0

def test_hitung_saw_jarak_sangat_jauh():
    # Menguji jarak sangat jauh (10000 km)
    cafes = [
        CafeInput(
            id_kafe=1, nama_kafe="Kafe Dekat", alamat="Alamat", rating=4.5, jarak=0.5,
            harga_min=15000, harga_max=30000, jam_buka="08:00", jam_tutup="22:00",
            fasilitas_count=5, menu_count=10, gambar=""
        ),
        CafeInput(
            id_kafe=2, nama_kafe="Kafe Antah Berantah", alamat="Alamat", rating=4.5, jarak=10000.0,
            harga_min=15000, harga_max=30000, jam_buka="08:00", jam_tutup="22:00",
            fasilitas_count=5, menu_count=10, gambar=""
        )
    ]
    bobot = BobotInput(harga=0.2, rating=0.2, jarak=0.2, fasilitas=0.2, menu=0.1, jam_operasional=0.1)
    response = hitung_saw_proses(cafes, bobot)
    
    # Kafe Dekat (jarak 0.5km -> skala 1) harus berperingkat lebih tinggi dari Kafe Antah Berantah (jarak 10000km -> skala 5)
    # Karena kriteria Jarak bersifat cost (semakin kecil jarak/skala, semakin besar nilai normalisasi)
    assert response.hasil[0].id_kafe == 1
    assert response.hasil[1].id_kafe == 2

def test_hitung_saw_rating_di_luar_batas():
    # Menguji rating di luar batas standar 0.0 - 5.0
    cafes = [
        CafeInput(
            id_kafe=1, nama_kafe="Kafe Rating Rendah", alamat="Alamat", rating=-1.5, jarak=1.5,
            harga_min=15000, harga_max=30000, jam_buka="08:00", jam_tutup="22:00",
            fasilitas_count=5, menu_count=10, gambar=""
        ),
        CafeInput(
            id_kafe=2, nama_kafe="Kafe Rating Over", alamat="Alamat", rating=5.5, jarak=1.5,
            harga_min=15000, harga_max=30000, jam_buka="08:00", jam_tutup="22:00",
            fasilitas_count=5, menu_count=10, gambar=""
        )
    ]
    bobot = BobotInput(harga=0.2, rating=0.2, jarak=0.2, fasilitas=0.2, menu=0.1, jam_operasional=0.1)
    response = hitung_saw_proses(cafes, bobot)
    
    # Kafe Rating Over (rating 5.5 -> skala 5) harus memiliki skor lebih tinggi dari Kafe Rating Rendah (rating -1.5 -> skala 1)
    assert response.hasil[0].id_kafe == 2
    assert response.hasil[1].id_kafe == 1

def test_hitung_saw_bobot_tidak_sama_dengan_satu():
    # Menguji jika jumlah bobot kriteria tidak sama dengan 1.0 (misal 2.5)
    cafes = [
        CafeInput(
            id_kafe=1, nama_kafe="Kafe A", alamat="Alamat", rating=4.5, jarak=1.5,
            harga_min=15000, harga_max=30000, jam_buka="08:00", jam_tutup="22:00",
            fasilitas_count=5, menu_count=10, gambar=""
        )
    ]
    bobot = BobotInput(harga=0.5, rating=0.5, jarak=0.5, fasilitas=0.5, menu=0.25, jam_operasional=0.25) # Total = 2.5
    response = hitung_saw_proses(cafes, bobot)
    
    # Perhitungan tetap berjalan normal
    # Skor total = sum(bobot) * 1.0 = 2.5
    assert len(response.hasil) == 1
    assert response.hasil[0].skor == 2.5
