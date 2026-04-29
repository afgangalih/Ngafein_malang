import pandas as pd
import re
import os

# ===== CONFIG =====
INPUT_FILE = "../raw/List Cafe.xlsx"
OUTPUT_FOLDER = "../output/"

os.makedirs(OUTPUT_FOLDER, exist_ok=True)

# =========================
# CLEANING UTILITY
# =========================

def clean_sql_text(text):
    return (
        str(text)
        .strip()
        .replace("\n", " ")
        .replace("\r", "")
        .replace("'", "''")
    )

def clean_text(text):
    return str(text).strip().lower()

def split_fasilitas(text):
    if pd.isna(text):
        return []
    items = re.split(r'\n|-|,|;|\||/', str(text))
    return [i.strip() for i in items if i.strip()]

def split_menu(text):
    if pd.isna(text):
        return []
    items = re.split(r'\n|,|;|\||/', str(text))
    cleaned = []
    for i in items:
        i = i.strip()
        if i.startswith('-'):
            i = i[1:].strip()
        if i:
            cleaned.append(i)
    return cleaned

# =========================
# NORMALIZE FASILITAS (ASLI DIPERTAHANKAN)
# =========================

def normalize_fasilitas(text):
    text = clean_text(text)

    mapping = {
        "wi": "wifi",
        "fi": "wifi",
        "wifi.": "wifi",
        "wi-fi": "wifi",

        "stopkontak": "colokan",
        "colokan.": "colokan",
        "colokan (tanpa mushola": "colokan",

        "area parkir": "parkir",
        "tempat parkir": "parkir",
        "parkir.": "parkir",
        "parkir luas": "parkir",
        "parkir (valet)": "parkir",

        "musholla": "mushola",
        "musola": "mushola",

        "kamar mandi": "toilet",

        "ac (indoor)": "indoor",
        "ac(indoor)": "indoor",
        "indoor (ac)": "indoor",
        "indoor ac": "indoor",
        "indoor (kipas)": "indoor",
        "ac": "indoor",

        "outdoor (luas)": "outdoor",
        "outdoor khusus).": "outdoor",
        "outdoor & semi": "outdoor",

        "semi": "semi_outdoor",
        "semi outdoor": "semi_outdoor",
        "semioutdoor": "semi_outdoor",

        "smooking area": "smoking_area",
        "smoking area": "smoking_area",
        "smooking area indoor": "smoking_indoor",
        "indoor smoking": "smoking_indoor",

        "working space": "workspace",
        "social space": "workspace",

        "live music": "live_music",
        "stage live music&event": "live_music",

        "meeting room": "meeting_room",
        "private room": "private_room",
        "vip room": "vip_room",

        "rooftop 360°": "rooftop",
        "shisha area": "shisha",
        "playground anak": "playground",
    }

    result = mapping.get(text, text)

    blacklist = [
        "area setting",
        "beberapa kursi sofa",
        "merchandise"
    ]

    if result in blacklist:
        return None

    return result

# =========================
# PARSE HARGA
# =========================

def parse_price_range(price_str):
    if pd.isna(price_str):
        return 0, 0

    text = str(price_str).lower()
    text = text.replace("rp", "").replace(".", "")

    numbers = re.findall(r'\d+', text)

    if not numbers:
        return 0, 0

    numbers = [int(n) for n in numbers]

    def normalize(n):
        return n * 1000 if n < 1000 else n

    if len(numbers) == 1:
        val = normalize(numbers[0])
        return val, val

    if len(numbers) >= 2:
        return normalize(numbers[0]), normalize(numbers[1])

    return 0, 0

# =========================
# PARSE JAM
# =========================

def parse_jam(text):
    if pd.isna(text):
        return "00:00", "00:00"

    t = str(text).lower()

    if "24" in t:
        return "00:00", "23:59"

    t = t.replace(".", ":")

    parts = t.split("-")

    if len(parts) == 2:
        return parts[0].strip(), parts[1].strip()

    return "00:00", "00:00"

# =========================
# PARSE JARAK (BARU)
# =========================

def parse_distance(text):
    if pd.isna(text):
        return 0.0

    t = str(text).lower()
    numbers = re.findall(r'[\d.]+', t)

    if not numbers:
        return 0.0

    val = float(numbers[0])

    if "km" in t:
        return val
    if "m" in t:
        return val / 1000

    return val

# =========================
# NORMALIZE MENU (BARU - CLEAN)
# =========================

def normalize_menu(text):
    text = clean_text(text)
    
    if any(x in text for x in ["non coffee", "non-coffee", "nonkopi", "non kopi"]):
        return "non_coffee"

    if any(x in text for x in ["coffee", "kopi", "espresso", "latte", "cappuccino"]):
        return "coffee"

    if any(x in text for x in ["tea", "teh"]):
        return "tea"

    if any(x in text for x in ["rice", "bowl", "mie", "ramen", "burger", "steak", "main", "food", "makanan", "dining", "nasi", "spaghetti", "pasta", "indonesia", "western", "bakso"]):
        return "food"

    if any(x in text for x in ["dessert", "cake", "gelato", "ice cream", "es krim", "manis", "waffle"]):
        return "dessert"

    if any(x in text for x in ["snack", "pastry", "croissant", "roti", "kentang", "french fries", "camilan", "gorengan", "platter"]):
        return "snack"

    if any(x in text for x in ["juice", "jus", "minuman", "drink", "beverage", "squash", "smoothies"]):
        return "non_coffee"

    return "other"

# =========================
# LOAD DATA
# =========================

df = pd.read_excel(INPUT_FILE)
print("Total data:", len(df))

# =========================
# FASILITAS
# =========================

all_fasilitas = set()

for f in df["Fasilitas"]:
    for item in split_fasilitas(f):
        norm = normalize_fasilitas(item)
        if norm:
            all_fasilitas.add(norm)

fasilitas_list = sorted(all_fasilitas)
fasilitas_map = {f: i+1 for i, f in enumerate(fasilitas_list)}

print("Total fasilitas:", len(fasilitas_list))

# =========================
# MENU (BARU)
# =========================

all_menu = set()

for m in df["Variasi Menu"]:
    for item in split_menu(m):
        norm = normalize_menu(item)
        if norm:
            all_menu.add(norm)

menu_list = sorted(all_menu)
menu_map = {m: i+1 for i, m in enumerate(menu_list)}

print("Total menu kategori:", len(menu_list))

# =========================
# SQL FASILITAS
# =========================

with open(OUTPUT_FOLDER + "fasilitas.sql", "w", encoding="utf-8") as f:
    f.write("INSERT INTO fasilitas (id_fasilitas, nama_fasilitas) VALUES\n")
    values = [f"({idx}, '{name}')" for name, idx in fasilitas_map.items()]
    f.write(",\n".join(values) + ";")

# =========================
# SQL MENU
# =========================

with open(OUTPUT_FOLDER + "menu.sql", "w", encoding="utf-8") as f:
    f.write("INSERT INTO menu (id_menu, nama_menu) VALUES\n")
    values = [f"({idx}, '{name}')" for name, idx in menu_map.items()]
    f.write(",\n".join(values) + ";")

# =========================
# SQL KAFE (UPDATED)
# =========================

with open(OUTPUT_FOLDER + "kafe.sql", "w", encoding="utf-8") as f:
    f.write("""INSERT INTO kafe 
(id_kafe, nama_kafe, alamat, link_maps, harga_min, harga_max, rating, jarak, jam_buka, jam_tutup, deskripsi) 
VALUES\n""")

    values = []
    seen = set()
    id_counter = 1

    for _, row in df.iterrows():

        nama = clean_sql_text(row["Nama"])
        key = nama.lower()

        if key in seen:
            continue
        seen.add(key)

        alamat = clean_sql_text(row["Alamat"])
        link = clean_sql_text(row["Lokasi"])

        harga_min, harga_max = parse_price_range(row["Harga Menu"])
        rating = str(row["Rating"]).replace(",", ".")

        jarak = parse_distance(row["Jarak"])

        jam_buka, jam_tutup = parse_jam(row["Jam Operasional"])

        values.append(
            f"({id_counter}, '{nama}', '{alamat}', '{link}', {harga_min}, {harga_max}, {rating}, {jarak}, '{jam_buka}', '{jam_tutup}', '-')"
        )

        id_counter += 1

    f.write(",\n".join(values) + ";")

# =========================
# RELASI KAFE - FASILITAS
# =========================

with open(OUTPUT_FOLDER + "kafe_fasilitas.sql", "w", encoding="utf-8") as f:
    f.write("INSERT INTO kafe_fasilitas (id_kafe, id_fasilitas) VALUES\n")

    values = set()
    seen = {}
    id_counter = 1

    for _, row in df.iterrows():
        nama = clean_sql_text(row["Nama"])
        key = nama.lower()

        if key not in seen:
            seen[key] = id_counter
            id_counter += 1

    for _, row in df.iterrows():
        nama = clean_sql_text(row["Nama"])
        key = nama.lower()

        id_kafe = seen.get(key)

        for item in split_fasilitas(row["Fasilitas"]):
            norm = normalize_fasilitas(item)

            if norm and norm in fasilitas_map:
                values.add((id_kafe, fasilitas_map[norm]))

    values = [f"({k},{f})" for k, f in sorted(values)]
    f.write(",\n".join(values) + ";")

# =========================
# RELASI KAFE - MENU
# =========================

with open(OUTPUT_FOLDER + "kafe_menu.sql", "w", encoding="utf-8") as f:
    f.write("INSERT INTO kafe_menu (id_kafe, id_menu) VALUES\n")

    values = set()
    seen = {}
    id_counter = 1

    for _, row in df.iterrows():
        nama = clean_sql_text(row["Nama"])
        key = nama.lower()

        if key not in seen:
            seen[key] = id_counter
            id_counter += 1

    for _, row in df.iterrows():
        nama = clean_sql_text(row["Nama"])
        key = nama.lower()

        id_kafe = seen.get(key)

        for item in split_menu(row["Variasi Menu"]):
            norm = normalize_menu(item)
            if norm in menu_map:
                values.add((id_kafe, menu_map[norm]))

    values = [f"({k},{m})" for k, m in sorted(values)]
    f.write(",\n".join(values) + ";")

print("\n✅ SQL FINAL BERHASIL DIBUAT (AMAN & CONSISTENT)")