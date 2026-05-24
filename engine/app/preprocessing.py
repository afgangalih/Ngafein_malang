from datetime import datetime

def hitung_durasi(buka: str, tutup: str) -> float:
    if not buka or not tutup:
        return 0.0
    try:
        b = datetime.strptime(buka[:5], "%H:%M")
        t = datetime.strptime(tutup[:5], "%H:%M")
        if t <= b:
            durasi = (24.0 - (b.hour + b.minute / 60.0)) + (t.hour + t.minute / 60.0)
        else:
            durasi = (t - b).total_seconds() / 3600.0
        return round(durasi, 1)
    except Exception:
        return 0.0

def skala_harga(harga: int) -> int:
    if harga <= 25000:
        return 1
    if harga <= 50000:
        return 2
    return 3

def skala_rating(rating: float) -> int:
    if rating >= 4.8:
        return 5
    if rating >= 4.6:
        return 4
    if rating >= 4.4:
        return 3
    if rating >= 4.2:
        return 2
    return 1

def skala_jarak(jarak: float) -> int:
    if jarak < 1.0:
        return 1
    if jarak <= 2.0:
        return 2
    if jarak <= 4.0:
        return 3
    if jarak <= 6.0:
        return 4
    return 5

def skala_fasilitas(jumlah: int) -> int:
    if jumlah <= 2:
        return 1
    if jumlah <= 4:
        return 2
    if jumlah <= 6:
        return 3
    if jumlah <= 8:
        return 4
    return 5

def skala_menu(jumlah: int) -> int:
    if jumlah <= 2:
        return 1
    if jumlah <= 4:
        return 2
    if jumlah == 5:
        return 3
    if jumlah == 6:
        return 4
    return 5

def skala_durasi(durasi: float) -> int:
    if durasi <= 5.0:
        return 1
    if durasi <= 10.0:
        return 2
    if durasi <= 15.0:
        return 3
    if durasi <= 20.0:
        return 4
    return 5
