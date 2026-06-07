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
