from typing import List, Dict, Any
from .schemas import CafeInput, BobotInput, CafeHasil, MatriksItem, NormalisasiItem, SAWResponse
from .preprocessing import (
    hitung_durasi,
    skala_harga,
    skala_rating,
    skala_jarak,
    skala_fasilitas,
    skala_menu,
    skala_durasi
)

def hitung_saw_proses(cafes: List[CafeInput], bobot: BobotInput) -> SAWResponse:
    if not cafes:
        return SAWResponse(hasil=[], matriks=[], normalisasi=[])

    matriks_list = []
    durasi_dict = {}

    for cafe in cafes:
        dur = hitung_durasi(cafe.jam_buka, cafe.jam_tutup)
        durasi_dict[cafe.id_kafe] = dur
        
        m_item = MatriksItem(
            nama_kafe=cafe.nama_kafe,
            harga=skala_harga(cafe.harga_min),
            rating=skala_rating(cafe.rating),
            jarak=skala_jarak(cafe.jarak),
            fasilitas=skala_fasilitas(cafe.fasilitas_count),
            menu=skala_menu(cafe.menu_count),
            durasi=skala_durasi(dur)
        )
        matriks_list.append(m_item)

    min_harga = min(m.harga for m in matriks_list)
    max_rating = max(m.rating for m in matriks_list)
    min_jarak = min(m.jarak for m in matriks_list)
    max_fasilitas = max(m.fasilitas for m in matriks_list)
    max_menu = max(m.menu for m in matriks_list)
    max_durasi = max(m.durasi for m in matriks_list)

    normalisasi_list = []
    for m in matriks_list:
        n_harga = round(min_harga / m.harga, 4) if m.harga > 0 else 0.0
        n_rating = round(m.rating / max_rating, 4) if max_rating > 0 else 0.0
        n_jarak = round(min_jarak / m.jarak, 4) if m.jarak > 0 else 0.0
        n_fasilitas = round(m.fasilitas / max_fasilitas, 4) if max_fasilitas > 0 else 0.0
        n_menu = round(m.menu / max_menu, 4) if max_menu > 0 else 0.0
        n_durasi = round(m.durasi / max_durasi, 4) if max_durasi > 0 else 0.0

        n_item = NormalisasiItem(
            nama=m.nama_kafe,
            harga=n_harga,
            rating=n_rating,
            jarak=n_jarak,
            fasilitas=n_fasilitas,
            menu=n_menu,
            durasi=n_durasi
        )
        normalisasi_list.append(n_item)

    hasil_temp = []
    for i, cafe in enumerate(cafes):
        n = normalisasi_list[i]
        
        skor = (
            (bobot.harga * n.harga) +
            (bobot.rating * n.rating) +
            (bobot.jarak * n.jarak) +
            (bobot.fasilitas * n.fasilitas) +
            (bobot.menu * n.menu) +
            (bobot.jam_operasional * n.durasi)
        )
        skor_rounded = round(skor, 4)

        perhitungan = f"({bobot.harga:.2f}×{n.harga:.2f})+({bobot.rating:.2f}×{n.rating:.2f})+({bobot.jarak:.2f}×{n.jarak:.2f})+({bobot.fasilitas:.2f}×{n.fasilitas:.2f})+({bobot.menu:.2f}×{n.menu:.2f})+({bobot.jam_operasional:.2f}×{n.durasi:.2f})"

        hasil_temp.append({
            "cafe": cafe,
            "skor": skor_rounded,
            "perhitungan": perhitungan,
            "normalisasi": n
        })

    hasil_temp.sort(key=lambda x: x["skor"], reverse=True)

    hasil_list = []
    for idx, item in enumerate(hasil_temp):
        cafe = item["cafe"]
        
        hasil_list.append(CafeHasil(
            id_kafe=cafe.id_kafe,
            nama_kafe=cafe.nama_kafe,
            alamat=cafe.alamat,
            rating=cafe.rating,
            jarak=cafe.jarak,
            harga_min=cafe.harga_min,
            harga_max=cafe.harga_max,
            jam_buka=cafe.jam_buka,
            jam_tutup=cafe.jam_tutup,
            gambar=cafe.gambar,
            skor=item["skor"],
            ranking=idx + 1,
            perhitungan=item["perhitungan"]
        ))

    return SAWResponse(
        hasil=hasil_list,
        matriks=matriks_list,
        normalisasi=normalisasi_list
    )
