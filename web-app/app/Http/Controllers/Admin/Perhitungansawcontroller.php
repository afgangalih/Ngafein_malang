<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerhitunganSAWController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | BOBOT KRITERIA
        |--------------------------------------------------------------------------
        */

        $bobotRows = DB::table('bobot_kriteria')
            ->get()
            ->keyBy('nama_kriteria');

        $bobot = [
            'harga'           => $bobotRows->get('harga')?->bobot ?? 0.20,
            'rating'          => $bobotRows->get('rating')?->bobot ?? 0.10,
            'jarak'           => $bobotRows->get('jarak')?->bobot ?? 0.20,
            'fasilitas'       => $bobotRows->get('fasilitas')?->bobot ?? 0.20,
            'menu'            => $bobotRows->get('menu')?->bobot ?? 0.15,
            'jam_operasional' => $bobotRows->get('jam_operasional')?->bobot ?? 0.15,
        ];

        /*
        |--------------------------------------------------------------------------
        | DATA KAFE
        |--------------------------------------------------------------------------
        */

        $kafes = KafeModel::with([
            'fasilitas',
            'menus'
        ])->get();

        /*
        |--------------------------------------------------------------------------
        | MATRIKS KEPUTUSAN
        |--------------------------------------------------------------------------
        */

        $matriks = $kafes->map(function ($kafe) {

            $durasi = $this->hitungDurasi(
                $kafe->jam_buka,
                $kafe->jam_tutup
            );

            return [

                'nama_kafe' => $kafe->nama_kafe,

                'harga' => $this->skalaHarga(
                    $kafe->harga_min
                ),

                'rating' => $this->skalaRating(
                    $kafe->rating
                ),

                'jarak' => $this->skalaJarak(
                    $kafe->jarak
                ),

                'fasilitas' => $this->skalaFasilitas(
                    $kafe->fasilitas->count()
                ),

                'menu' => $this->skalaMenu(
                    $kafe->menus->count()
                ),

                'durasi' => $this->skalaDurasi(
                    $durasi
                ),
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | MAX MIN NORMALISASI
        |--------------------------------------------------------------------------
        */

        $maxMin = [

            'harga' => [
                'min' => $matriks->min('harga')
            ],

            'rating' => [
                'max' => $matriks->max('rating')
            ],

            'jarak' => [
                'min' => $matriks->min('jarak')
            ],

            'fasilitas' => [
                'max' => $matriks->max('fasilitas')
            ],

            'menu' => [
                'max' => $matriks->max('menu')
            ],

            'durasi' => [
                'max' => $matriks->max('durasi')
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI
        |--------------------------------------------------------------------------
        */

        $normalisasi = $matriks->map(function ($item) use ($maxMin) {

            return [

                'nama' => $item['nama_kafe'],

                'harga' => $this->normCost(
                    $item['harga'],
                    $maxMin['harga']['min']
                ),

                'rating' => $this->normBenefit(
                    $item['rating'],
                    $maxMin['rating']['max']
                ),

                'jarak' => $this->normCost(
                    $item['jarak'],
                    $maxMin['jarak']['min']
                ),

                'fasilitas' => $this->normBenefit(
                    $item['fasilitas'],
                    $maxMin['fasilitas']['max']
                ),

                'menu' => $this->normBenefit(
                    $item['menu'],
                    $maxMin['menu']['max']
                ),

                'durasi' => $this->normBenefit(
                    $item['durasi'],
                    $maxMin['durasi']['max']
                ),
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | PERHITUNGAN SAW
        |--------------------------------------------------------------------------
        */

        $hasil = $normalisasi->map(function ($item) use ($bobot) {

            $skor =
                ($bobot['harga'] * $item['harga']) +
                ($bobot['rating'] * $item['rating']) +
                ($bobot['jarak'] * $item['jarak']) +
                ($bobot['fasilitas'] * $item['fasilitas']) +
                ($bobot['menu'] * $item['menu']) +
                ($bobot['jam_operasional'] * $item['durasi']);

            $perhitungan = sprintf(
                '(%.2f×%.2f)+(%.2f×%.2f)+(%.2f×%.2f)+(%.2f×%.2f)+(%.2f×%.2f)+(%.2f×%.2f)',
                $bobot['harga'],
                $item['harga'],

                $bobot['rating'],
                $item['rating'],

                $bobot['jarak'],
                $item['jarak'],

                $bobot['fasilitas'],
                $item['fasilitas'],

                $bobot['menu'],
                $item['menu'],

                $bobot['jam_operasional'],
                $item['durasi']
            );

            return [

                'nama_kafe'   => $item['nama'],
                'perhitungan' => $perhitungan,
                'skor'        => round($skor, 3),
            ];

        })->values();

        /*
        |--------------------------------------------------------------------------
        | RANKING
        |--------------------------------------------------------------------------
        */

        $sorted = $hasil
            ->sortByDesc('skor')
            ->values();

        $hasil = $hasil->map(function ($item) use ($sorted) {

            $item['ranking'] =
                $sorted->search(function ($data) use ($item) {

                    return $data['nama_kafe']
                        == $item['nama_kafe'];

                }) + 1;

            return $item;
        });

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.saw.index', compact(
            'matriks',
            'normalisasi',
            'hasil'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALISASI
    |--------------------------------------------------------------------------
    */

    private function normBenefit($nilai, $max)
    {
        return round($nilai / $max, 3);
    }

    private function normCost($nilai, $min)
    {
        return round($min / $nilai, 3);
    }

    /*
    |--------------------------------------------------------------------------
    | SKALA HARGA
    |--------------------------------------------------------------------------
    | Murah (1 - 25.000)         = 1
    | Sedang (25.000 - 50.000)  = 2
    | Mahal (>50.000)           = 3
    |--------------------------------------------------------------------------
    */

    private function skalaHarga($harga)
    {
        if ($harga <= 25000) {
            return 1;
        }

        if ($harga <= 50000) {
            return 2;
        }

        return 3;
    }

    /*
    |--------------------------------------------------------------------------
    | SKALA RATING
    |--------------------------------------------------------------------------
    | Sangat Buruk = 1
    | Buruk        = 2
    | Cukup        = 3
    | Baik         = 4
    | Sangat Baik  = 5
    |--------------------------------------------------------------------------
    */

    private function skalaRating($rating)
    {
        if ($rating < 2) {
            return 1;
        }

        if ($rating < 3) {
            return 2;
        }

        if ($rating < 4) {
            return 3;
        }

        if ($rating < 5) {
            return 4;
        }

        return 5;
    }

    /*
    |--------------------------------------------------------------------------
    | SKALA JARAK
    |--------------------------------------------------------------------------
    | Sangat Dekat (<1 km) = 1
    | Dekat (1-2 km)       = 2
    | Cukup Jauh (2-4 km)  = 3
    | Jauh (4-6 km)        = 4
    | Sangat Jauh (>6 km)  = 5
    |--------------------------------------------------------------------------
    */

    private function skalaJarak($jarak)
    {
        if ($jarak < 1) {
            return 1;
        }

        if ($jarak <= 2) {
            return 2;
        }

        if ($jarak <= 4) {
            return 3;
        }

        if ($jarak <= 6) {
            return 4;
        }

        return 5;
    }

    /*
    |--------------------------------------------------------------------------
    | SKALA FASILITAS
    |--------------------------------------------------------------------------
    | Tidak Lengkap (1-2)   = 1
    | Kurang Lengkap (3-4)  = 2
    | Cukup Lengkap (5-6)   = 3
    | Lengkap (7-8)         = 4
    | Sangat Lengkap (9-10) = 5
    |--------------------------------------------------------------------------
    */

    private function skalaFasilitas($jumlah)
    {
        if ($jumlah <= 2) {
            return 1;
        }

        if ($jumlah <= 4) {
            return 2;
        }

        if ($jumlah <= 6) {
            return 3;
        }

        if ($jumlah <= 8) {
            return 4;
        }

        return 5;
    }

    /*
    |--------------------------------------------------------------------------
    | SKALA MENU
    |--------------------------------------------------------------------------
    | Sangat Sedikit (1-2) = 1
    | Sedikit (3-4)        = 2
    | Cukup Banyak (5)     = 3
    | Banyak (6)           = 4
    | Sangat Banyak (7+)   = 5
    |--------------------------------------------------------------------------
    */

    private function skalaMenu($jumlah)
    {
        if ($jumlah <= 2) {
            return 1;
        }

        if ($jumlah <= 4) {
            return 2;
        }

        if ($jumlah == 5) {
            return 3;
        }

        if ($jumlah == 6) {
            return 4;
        }

        return 5;
    }

    /*
    |--------------------------------------------------------------------------
    | SKALA DURASI / JAM OPERASIONAL
    |--------------------------------------------------------------------------
    | Sangat Singkat (1-5 jam) = 1
    | Singkat (6-10 jam)       = 2
    | Cukup Lama (11-15 jam)   = 3
    | Lama (16-20 jam)         = 4
    | Sangat Lama (21-24 jam)  = 5
    |--------------------------------------------------------------------------
    */

    private function skalaDurasi($durasi)
    {
        if ($durasi <= 5) {
            return 1;
        }

        if ($durasi <= 10) {
            return 2;
        }

        if ($durasi <= 15) {
            return 3;
        }

        if ($durasi <= 20) {
            return 4;
        }

        return 5;
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG DURASI JAM OPERASIONAL
    |--------------------------------------------------------------------------
    */

    private function hitungDurasi($buka, $tutup)
    {
        if (!$buka || !$tutup) {
            return 0;
        }

        try {

            $jamBuka = Carbon::createFromFormat(
                'H:i',
                $buka
            );

            $jamTutup = Carbon::createFromFormat(
                'H:i',
                $tutup
            );

            if ($jamTutup <= $jamBuka) {
                $jamTutup->addDay();
            }

            return round(
                $jamBuka->diffInMinutes($jamTutup) / 60,
                1
            );

        } catch (\Exception $e) {

            return 0;
        }
    }
}