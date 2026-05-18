<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |----------------------------------------------------------------------
        | STATS CARDS
        |----------------------------------------------------------------------
        */
        $totalKafe     = Schema::hasTable('kafe')           ? DB::table('kafe')->count()          : 0;
        $totalKriteria = Schema::hasTable('bobot_kriteria') ? DB::table('bobot_kriteria')->count() : 6;

        /*
        |----------------------------------------------------------------------
        | DISTRIBUSI BOBOT KRITERIA
        |----------------------------------------------------------------------
        */
        $kriterias  = Kriteria::all();
        $totalBobot = $kriterias->sum('bobot');

        /*
        |----------------------------------------------------------------------
        | PERHITUNGAN SAW
        |----------------------------------------------------------------------
        */
        $topCafes  = collect();
        $chartData = collect();
        $totalSAW  = 0;

        if ($totalKafe > 0) {

            /* 1. Bobot kriteria */
            $bobotRows = Schema::hasTable('bobot_kriteria')
                ? DB::table('bobot_kriteria')->get()->keyBy('nama_kriteria')
                : collect();

            $bobot = [
                'harga'           => $bobotRows->get('harga')?->bobot           ?? 0.20,
                'rating'          => $bobotRows->get('rating')?->bobot          ?? 0.10,
                'jarak'           => $bobotRows->get('jarak')?->bobot           ?? 0.25,
                'fasilitas'       => $bobotRows->get('fasilitas')?->bobot       ?? 0.15,
                'menu'            => $bobotRows->get('menu')?->bobot            ?? 0.10,
                'jam_operasional' => $bobotRows->get('jam_operasional')?->bobot ?? 0.20,
            ];

            /* 2. Data kafe */
            $kafes = KafeModel::with(['fasilitas', 'menus'])->get();

            /* 3. Matriks keputusan (nilai skala) */
            $matriks = $kafes->map(function ($kafe) {
                $durasi = $this->hitungDurasi($kafe->jam_buka, $kafe->jam_tutup);
                return [
                    'nama_kafe' => $kafe->nama_kafe,
                    'harga'     => $this->skalaHarga($kafe->harga_min),
                    'rating'    => $this->skalaRating($kafe->rating),
                    'jarak'     => $this->skalaJarak($kafe->jarak),
                    'fasilitas' => $this->skalaFasilitas($kafe->fasilitas->count()),
                    'menu'      => $this->skalaMenu($kafe->menus->count()),
                    'durasi'    => $this->skalaDurasi($durasi),
                ];
            });

            /* 4. Max / min tiap kriteria */
            $maxMin = [
                'harga'     => ['min' => $matriks->min('harga')],
                'rating'    => ['max' => $matriks->max('rating')],
                'jarak'     => ['min' => $matriks->min('jarak')],
                'fasilitas' => ['max' => $matriks->max('fasilitas')],
                'menu'      => ['max' => $matriks->max('menu')],
                'durasi'    => ['max' => $matriks->max('durasi')],
            ];

            /* 5. Normalisasi (R) */
            $normalisasi = $matriks->map(function ($item) use ($maxMin) {
                return [
                    'nama'      => $item['nama_kafe'],
                    'harga'     => $this->normCost(    $item['harga'],     $maxMin['harga']['min']),
                    'rating'    => $this->normBenefit( $item['rating'],    $maxMin['rating']['max']),
                    'jarak'     => $this->normCost(    $item['jarak'],     $maxMin['jarak']['min']),
                    'fasilitas' => $this->normBenefit( $item['fasilitas'], $maxMin['fasilitas']['max']),
                    'menu'      => $this->normBenefit( $item['menu'],      $maxMin['menu']['max']),
                    'durasi'    => $this->normBenefit( $item['durasi'],    $maxMin['durasi']['max']),
                ];
            });

            /* 6. Nilai preferensi (V) */
            $hasil = $normalisasi->map(function ($item) use ($bobot) {
                $skor =
                    ($bobot['harga']           * $item['harga'])     +
                    ($bobot['rating']          * $item['rating'])    +
                    ($bobot['jarak']           * $item['jarak'])     +
                    ($bobot['fasilitas']       * $item['fasilitas']) +
                    ($bobot['menu']            * $item['menu'])      +
                    ($bobot['jam_operasional'] * $item['durasi']);

                return [
                    'nama_kafe' => $item['nama'],
                    'skor'      => round($skor, 4),
                ];
            });

            /* 7. Ranking */
            $sorted = $hasil->sortByDesc('skor')->values();

            $hasilRanked = $sorted->map(function ($item, $index) {
                $item['ranking'] = $index + 1;
                return $item;
            });

            $totalSAW = $hasilRanked->count();

            /* Top 4 untuk panel ranking kanan */
            $topCafes = $hasilRanked->take(4)->map(function ($item) {
                return (object) [
                    'nama_kafe' => $item['nama_kafe'],
                    'skor'      => $item['skor'],
                    'ranking'   => $item['ranking'],
                ];
            });

            /* Top 10 untuk chart perbandingan */
            $chartData = $hasilRanked->take(10)->map(function ($item) {
                return (object) [
                    'nama_kafe' => $item['nama_kafe'],
                    'skor'      => $item['skor'],
                    'ranking'   => $item['ranking'],
                ];
            });
        }

        $stats = [
            'total_kafe'        => $totalKafe,
            'total_kriteria'    => $totalKriteria,
            'total_perhitungan' => $totalSAW,
            'total_rekomendasi' => $topCafes->count(),
        ];

        return view('admin.dashboard.index', compact(
            'stats',
            'topCafes',
            'chartData',
            'kriterias',
            'totalBobot'
        ));
    }

    /*
    |----------------------------------------------------------------------
    | NORMALISASI
    |----------------------------------------------------------------------
    */
    private function normBenefit($nilai, $max): float
    {
        if ($max == 0) return 0;
        return round($nilai / $max, 4);
    }

    private function normCost($nilai, $min): float
    {
        if ($nilai == 0) return 0;
        return round($min / $nilai, 4);
    }

    /*
    |----------------------------------------------------------------------
    | SKALA HARGA  (≤25rb=1, ≤50rb=2, >50rb=3)
    |----------------------------------------------------------------------
    */
    private function skalaHarga($harga): int
    {
        if ($harga <= 25000) return 1;
        if ($harga <= 50000) return 2;
        return 3;
    }

    /*
    |----------------------------------------------------------------------
    | SKALA RATING  (< 2 = 1 … 5 = 5)
    |----------------------------------------------------------------------
    */
    private function skalaRating($rating): int
    {
        if ($rating < 2) return 1;
        if ($rating < 3) return 2;
        if ($rating < 4) return 3;
        if ($rating < 5) return 4;
        return 5;
    }

    /*
    |----------------------------------------------------------------------
    | SKALA JARAK  km  (<1=1, ≤2=2, ≤4=3, ≤6=4, >6=5)
    |----------------------------------------------------------------------
    */
    private function skalaJarak($jarak): int
    {
        if ($jarak < 1)  return 1;
        if ($jarak <= 2) return 2;
        if ($jarak <= 4) return 3;
        if ($jarak <= 6) return 4;
        return 5;
    }

    /*
    |----------------------------------------------------------------------
    | SKALA FASILITAS  (jumlah item)
    |----------------------------------------------------------------------
    */
    private function skalaFasilitas($jumlah): int
    {
        if ($jumlah <= 2) return 1;
        if ($jumlah <= 4) return 2;
        if ($jumlah <= 6) return 3;
        if ($jumlah <= 8) return 4;
        return 5;
    }

    /*
    |----------------------------------------------------------------------
    | SKALA MENU  (jumlah kategori)
    |----------------------------------------------------------------------
    */
    private function skalaMenu($jumlah): int
    {
        if ($jumlah <= 2) return 1;
        if ($jumlah <= 4) return 2;
        if ($jumlah == 5) return 3;
        if ($jumlah == 6) return 4;
        return 5;
    }

    /*
    |----------------------------------------------------------------------
    | SKALA DURASI JAM OPERASIONAL  (jam)
    |----------------------------------------------------------------------
    */
    private function skalaDurasi($durasi): int
    {
        if ($durasi <= 5)  return 1;
        if ($durasi <= 10) return 2;
        if ($durasi <= 15) return 3;
        if ($durasi <= 20) return 4;
        return 5;
    }

    /*
    |----------------------------------------------------------------------
    | HITUNG DURASI BUKA (jam)
    |----------------------------------------------------------------------
    */
    private function hitungDurasi($buka, $tutup): float
    {
        if (!$buka || !$tutup) return 0;
        try {
            $jamBuka  = Carbon::createFromFormat('H:i', $buka);
            $jamTutup = Carbon::createFromFormat('H:i', $tutup);
            if ($jamTutup <= $jamBuka) {
                $jamTutup->addDay();
            }
            return round($jamBuka->diffInMinutes($jamTutup) / 60, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }
}