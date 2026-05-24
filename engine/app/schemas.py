from pydantic import BaseModel
from typing import List, Optional

class CafeInput(BaseModel):
    id_kafe: int
    nama_kafe: str
    alamat: Optional[str] = None
    rating: float
    jarak: float
    harga_min: int
    harga_max: Optional[int] = None
    jam_buka: Optional[str] = None
    jam_tutup: Optional[str] = None
    gambar: Optional[str] = None
    fasilitas_count: int
    menu_count: int

class BobotInput(BaseModel):
    harga: float
    rating: float
    jarak: float
    fasilitas: float
    menu: float
    jam_operasional: float

class SAWRequest(BaseModel):
    cafes: List[CafeInput]
    bobot: BobotInput

class CafeHasil(BaseModel):
    id_kafe: int
    nama_kafe: str
    alamat: Optional[str] = None
    rating: float
    jarak: float
    harga_min: int
    harga_max: Optional[int] = None
    jam_buka: Optional[str] = None
    jam_tutup: Optional[str] = None
    gambar: Optional[str] = None
    skor: float
    ranking: int
    perhitungan: str

class MatriksItem(BaseModel):
    nama_kafe: str
    harga: int
    rating: int
    jarak: int
    fasilitas: int
    menu: int
    durasi: int

class NormalisasiItem(BaseModel):
    nama: str
    harga: float
    rating: float
    jarak: float
    fasilitas: float
    menu: float
    durasi: float

class SAWResponse(BaseModel):
    hasil: List[CafeHasil]
    matriks: List[MatriksItem]
    normalisasi: List[NormalisasiItem]
