<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\KafeModel;
use App\Models\FasilitasModel;

class WelcomeController extends Controller
{
    // Fasilitas yang ditampilkan di filter (slug → label)
    private const FASILITAS_ALLOWED = [
        'colokan',      'indoor',   'mushola',
        'outdoor',      'parkir',   'rooftop',
        'semi_outdoor', 'toilet',   'wifi',
    ];

    public function index(Request $request)
    {
        $totalKafe  = KafeModel::count();
        $avgRating  = KafeModel::avg('rating');

        $kafeUnggulan = KafeModel::with('gambar')
            ->orderByDesc('rating')
            ->limit(3)
            ->get();

        $hour = now()->hour;
        $rekomendasiWaktu = $this->getWaktuLabel($hour);

        $semuaKafe = KafeModel::with('gambar')
            ->orderByDesc('rating')
            ->get();

        return view('user.landing.index', compact(
            'totalKafe',
            'avgRating',
            'kafeUnggulan',
            'rekomendasiWaktu',
            'semuaKafe'
        ));
    }

    // =========================================================
    //  CARI REKOMENDASI – filter + SAW ranking
    // =========================================================

    public function cariRekomendasi(Request $request)
    {
        // Hanya ambil fasilitas yang diizinkan (9 item)
        $semuaFasilitas = FasilitasModel::whereIn(
                DB::raw('LOWER(REPLACE(nama_fasilitas, " ", "_"))'),
                self::FASILITAS_ALLOWED
            )
            ->orderBy('nama_fasilitas')
            ->get();

        // Fallback jika DB tidak mendukung ekspresi di atas —
        // filter setelah ambil semua, lalu batasi ke 9
        if ($semuaFasilitas->isEmpty()) {
            $semuaFasilitas = FasilitasModel::orderBy('nama_fasilitas')
                ->get()
                ->filter(fn($f) =>
                    in_array(
                        strtolower(str_replace(' ', '_', $f->nama_fasilitas)),
                        self::FASILITAS_ALLOWED
                    )
                )
                ->values();
        }

        // Apakah user sudah submit filter?
        $sudahDicari = $request->hasAny([
            'harga_max', 'jarak_max', 'rating_min',
            'fasilitas', 'menu_min', 'jam_operasional',
        ]);

        $hasil = collect();

        if ($sudahDicari) {

            // ── 1. Query + filter preferensi user ──────────────────
            $query = KafeModel::with(['fasilitas', 'menus', 'gambar']);

            // Harga — sesuai skala baru (Murah ≤25k, Sedang ≤50k, Mahal >50k)
            if ($request->filled('harga_max')) {
                $query->where('harga_min', '<=', (int) $request->harga_max);
            }

            // Jarak — sesuai skala (<1, ≤2, ≤4, ≤6, >6)
            if ($request->filled('jarak_max')) {
                $query->where('jarak', '<=', (float) $request->jarak_max);
            }

            // Rating
            if ($request->filled('rating_min')) {
                $query->where('rating', '>=', (float) $request->rating_min);
            }

            // Fasilitas — user memilih fasilitas apa saja yang WAJIB ada
            if ($request->filled('fasilitas') && is_array($request->fasilitas)) {
                foreach ($request->fasilitas as $fasId) {
                    $query->whereHas('fasilitas', function ($q) use ($fasId) {
                        $q->where('fasilitas.id_fasilitas', $fasId);
                    });
                }
            }

            // Variasi Menu — minimal sekian kategori
            if ($request->filled('menu_min')) {
                $query->has('menus', '>=', (int) $request->menu_min);
            }

            // Jam Operasional — durasi minimal (jam)
            if ($request->filled('jam_operasional')) {
                $durMin = (int) $request->jam_operasional;
                $query->whereRaw("
                    CASE
                        WHEN jam_tutup > jam_buka
                            THEN TIME_TO_SEC(TIMEDIFF(jam_tutup, jam_buka)) / 3600
                        ELSE
                            (86400 - TIME_TO_SEC(jam_buka) + TIME_TO_SEC(jam_tutup)) / 3600
                    END >= ?
                ", [$durMin]);
            }

            $kafes = $query->get();

            // ── 2. Jalankan SAW ────────────────────────────────────
            if ($kafes->isNotEmpty()) {
                $hasil = $this->hitungSAW($kafes);
            }
        }

        return view('user.rekomendasi.index', compact(
            'hasil',
            'semuaFasilitas',
            'sudahDicari',
        ));
    }

    // =========================================================
    //  SAW ENGINE
    // =========================================================

    private function hitungSAW($kafes): \Illuminate\Support\Collection
    {
        $bobot = $this->getBobot();

        // Matriks keputusan
        $matriks = $kafes->map(function ($kafe) {
            $durasi = $this->hitungDurasi($kafe->jam_buka, $kafe->jam_tutup);

            return [
                'id_kafe'    => $kafe->id_kafe,
                'nama_kafe'  => $kafe->nama_kafe,
                'alamat'     => $kafe->alamat,
                'rating_raw' => $kafe->rating,
                'jarak_km'   => $kafe->jarak,
                'harga_min'  => $kafe->harga_min,
                'harga_max'  => $kafe->harga_max,
                'jam_buka'   => $kafe->jam_buka,
                'jam_tutup'  => $kafe->jam_tutup,
                'gambar'     => $kafe->gambar->first()?->link_gambar ?? null,

                // nilai skala — DISESUAIKAN dengan tabel
                's_harga'    => $this->skalaHarga($kafe->harga_min),
                's_rating'   => $this->skalaRating($kafe->rating),
                's_jarak'    => $this->skalaJarak($kafe->jarak),
                's_fasilitas'=> $this->skalaFasilitas($kafe->fasilitas->count()),
                's_menu'     => $this->skalaMenu($kafe->menus->count()),
                's_durasi'   => $this->skalaDurasi($durasi),
            ];
        });

        // Referensi max / min per kriteria
        $ref = [
            's_harga'    => ['min' => $matriks->min('s_harga')],
            's_rating'   => ['max' => $matriks->max('s_rating')],
            's_jarak'    => ['min' => $matriks->min('s_jarak')],
            's_fasilitas'=> ['max' => $matriks->max('s_fasilitas')],
            's_menu'     => ['max' => $matriks->max('s_menu')],
            's_durasi'   => ['max' => $matriks->max('s_durasi')],
        ];

        // Normalisasi
        $norm = $matriks->map(fn($item) => array_merge($item, [
            'n_harga'    => $this->normCost($item['s_harga'],     $ref['s_harga']['min']),
            'n_rating'   => $this->normBenefit($item['s_rating'],    $ref['s_rating']['max']),
            'n_jarak'    => $this->normCost($item['s_jarak'],     $ref['s_jarak']['min']),
            'n_fasilitas'=> $this->normBenefit($item['s_fasilitas'], $ref['s_fasilitas']['max']),
            'n_menu'     => $this->normBenefit($item['s_menu'],      $ref['s_menu']['max']),
            'n_durasi'   => $this->normBenefit($item['s_durasi'],    $ref['s_durasi']['max']),
        ]));

        // Skor SAW + ranking
        return $norm->map(function ($item) use ($bobot) {
            $item['skor'] = round(
                ($bobot['harga']           * $item['n_harga'])     +
                ($bobot['rating']          * $item['n_rating'])    +
                ($bobot['jarak']           * $item['n_jarak'])     +
                ($bobot['fasilitas']       * $item['n_fasilitas']) +
                ($bobot['menu']            * $item['n_menu'])      +
                ($bobot['jam_operasional'] * $item['n_durasi']),
                4
            );
            return $item;
        })
        ->sortByDesc('skor')
        ->values()
        ->map(function ($item, $i) {
            $item['ranking'] = $i + 1;
            return $item;
        });
    }

    // ── Bobot dari tabel (fallback ke default) ──────────────────────

    private function getBobot(): array
    {
        $rows = DB::table('bobot_kriteria')->get()->keyBy('nama_kriteria');

        return [
            'harga'           => $rows->get('harga')?->bobot           ?? 0.20,
            'rating'          => $rows->get('rating')?->bobot          ?? 0.10,
            'jarak'           => $rows->get('jarak')?->bobot           ?? 0.20,
            'fasilitas'       => $rows->get('fasilitas')?->bobot       ?? 0.20,
            'menu'            => $rows->get('menu')?->bobot            ?? 0.15,
            'jam_operasional' => $rows->get('jam_operasional')?->bobot ?? 0.15,
        ];
    }

    // ── Normalisasi ─────────────────────────────────────────────────

    private function normBenefit($nilai, $max): float
    {
        return $max > 0 ? round($nilai / $max, 4) : 0;
    }

    private function normCost($nilai, $min): float
    {
        return $nilai > 0 ? round($min / $nilai, 4) : 0;
    }

    // ── Skala kriteria (DISESUAIKAN dengan tabel) ────────────────────

    /**
     * Harga — Cost (makin murah makin baik)
     * Murah  (1 – 25.000)      → 1
     * Sedang (25.000 – 50.000) → 2
     * Mahal  (> 50.000)        → 3
     */
    private function skalaHarga($harga): int
    {
        if ($harga <= 25000) return 1;
        if ($harga <= 50000) return 2;
        return 3;
    }

    /**
     * Rating — Benefit
     * Sangat Buruk (< 4.2) → 1
     * Buruk  (4.2–4.3)     → 2
     * Cukup  (4.4–4.5)     → 3
     * Baik   (4.6–4.7)     → 4
     * Sangat Baik (≥ 4.8)  → 5
     */
    private function skalaRating($rating): int
    {
        if ($rating >= 4.8) return 5;
        if ($rating >= 4.6) return 4;
        if ($rating >= 4.4) return 3;
        if ($rating >= 4.2) return 2;
        return 1;
    }

    /**
     * Jarak — Cost (makin dekat makin baik)
     * Sangat Dekat (< 1 km)  → 1
     * Dekat        (1–2 km)  → 2
     * Cukup Jauh   (2–4 km)  → 3
     * Jauh         (4–6 km)  → 4
     * Sangat Jauh  (> 6 km)  → 5
     */
    private function skalaJarak($jarak): int
    {
        if ($jarak < 1)  return 1;
        if ($jarak <= 2) return 2;
        if ($jarak <= 4) return 3;
        if ($jarak <= 6) return 4;
        return 5;
    }

    /**
     * Fasilitas — Benefit (dari 9 fasilitas yang tersedia)
     * Tidak Lengkap  (1–2)   → 1
     * Kurang Lengkap (3–4)   → 2
     * Cukup Lengkap  (5–6)   → 3
     * Lengkap        (7–8)   → 4
     * Sangat Lengkap (9–10)  → 5
     */
    private function skalaFasilitas($jumlah): int
    {
        if ($jumlah <= 2) return 1;
        if ($jumlah <= 4) return 2;
        if ($jumlah <= 6) return 3;
        if ($jumlah <= 8) return 4;
        return 5;
    }

    /**
     * Variasi Menu — Benefit
     * Sangat Sedikit (1–2) → 1
     * Sedikit        (3–4) → 2
     * Cukup Banyak   (5)   → 3
     * Banyak         (6)   → 4
     * Sangat Banyak  (≥7)  → 5
     */
    private function skalaMenu($jumlah): int
    {
        if ($jumlah <= 2) return 1;
        if ($jumlah <= 4) return 2;
        if ($jumlah == 5) return 3;
        if ($jumlah == 6) return 4;
        return 5;
    }

    /**
     * Jam Operasional — Benefit (durasi dalam jam)
     * Sangat Singkat (1–5 jam)   → 1
     * Singkat        (6–10 jam)  → 2
     * Cukup Lama     (11–15 jam) → 3
     * Lama           (16–20 jam) → 4
     * Sangat Lama    (21–24 jam) → 5
     */
    private function skalaDurasi($durasi): int
    {
        if ($durasi <= 5)  return 1;
        if ($durasi <= 10) return 2;
        if ($durasi <= 15) return 3;
        if ($durasi <= 20) return 4;
        return 5;
    }

    private function hitungDurasi($buka, $tutup): float
    {
        if (!$buka || !$tutup) return 0;
        try {
            $b = Carbon::createFromFormat('H:i', $buka);
            $t = Carbon::createFromFormat('H:i', $tutup);
            if ($t <= $b) $t->addDay();
            return round($b->diffInMinutes($t) / 60, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getWaktuLabel(int $hour): string
    {
        return match(true) {
            $hour >= 6  && $hour < 10  => 'Pagi Sunyi',
            $hour >= 10 && $hour < 14  => 'Morning Rush',
            $hour >= 14 && $hour < 18  => 'Golden Hour',
            default                    => 'Night Mode',
        };
    }
}