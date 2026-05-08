<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Support\Facades\DB;

class PerhitunganSAWController extends Controller
{
    public function index()
    {
        // ========================
        // AMBIL BOBOT
        // ========================
        $bobotRows = DB::table('bobot_kriteria')->get()->keyBy('nama_kriteria');

        $bobot = [
            'harga'           => $bobotRows->get('harga')?->bobot ?? 0.25,
            'rating'          => $bobotRows->get('rating')?->bobot ?? 0.10,
            'jarak'           => $bobotRows->get('jarak')?->bobot ?? 0.20,
            'fasilitas'       => $bobotRows->get('fasilitas')?->bobot ?? 0.20,
            'menu'            => $bobotRows->get('menu')?->bobot ?? 0.15,
            'jam_operasional' => $bobotRows->get('jam_operasional')?->bobot ?? 0.10,
        ];

        // ========================
        // AMBIL DATA KAFE
        // ========================
        $kafes = KafeModel::with(['fasilitas', 'menus'])->get();

        // ========================
        // MATRKS (DATA MENTAH)
        // ========================
        $matriks = $kafes->map(function ($kafe) {
            return [
                'nama_kafe' => $kafe->nama_kafe,
                'harga'     => $kafe->harga_min,
                'rating'    => (float) $kafe->rating,
                'jarak'     => (float) $kafe->jarak,
                'fasilitas' => $kafe->fasilitas->count(),
                'menu'      => $kafe->menus->count(),
                'durasi'    => $this->hitungDurasi($kafe->jam_buka, $kafe->jam_tutup),
            ];
        });

        // ========================
        // MAX MIN
        // ========================
        $maxMin = [
            'harga'     => ['min' => $matriks->min('harga'),     'max' => $matriks->max('harga')],
            'rating'    => ['max' => $matriks->max('rating')],
            'jarak'     => ['min' => $matriks->min('jarak')],
            'fasilitas' => ['max' => $matriks->max('fasilitas')],
            'menu'      => ['max' => $matriks->max('menu')],
            'durasi'    => ['max' => $matriks->max('durasi')],
        ];

        // ========================
        // NORMALISASI
        // ========================
        $normalisasi = $matriks->map(function ($item) use ($maxMin) {

            return [
                'nama'      => $item['nama_kafe'],
                'harga'     => $this->normCost($item['harga'], $maxMin['harga']['min']),
                'rating'    => $this->normBenefit($item['rating'], $maxMin['rating']['max']),
                'jarak'     => $this->normCost($item['jarak'], $maxMin['jarak']['min']),
                'fasilitas' => $this->normBenefit($item['fasilitas'], $maxMin['fasilitas']['max']),
                'menu'      => $this->normBenefit($item['menu'], $maxMin['menu']['max']),
                'durasi'    => $this->normBenefit($item['durasi'], $maxMin['durasi']['max']),
            ];
        });

        // ========================
        // HASIL SAW
        // ========================
        $hasil = $normalisasi->map(function ($item) use ($bobot) {

            $skor =
                ($bobot['harga']           * $item['harga']) +
                ($bobot['rating']          * $item['rating']) +
                ($bobot['jarak']           * $item['jarak']) +
                ($bobot['fasilitas']       * $item['fasilitas']) +
                ($bobot['menu']            * $item['menu']) +
                ($bobot['jam_operasional'] * $item['durasi']);

            $perhitungan = sprintf(
                '(%.2f×%.2f)+(%.2f×%.2f)+(%.2f×%.2f)+(%.2f×%.2f)+(%.2f×%.2f)+(%.2f×%.2f)',
                $bobot['harga'], $item['harga'],
                $bobot['rating'], $item['rating'],
                $bobot['jarak'], $item['jarak'],
                $bobot['fasilitas'], $item['fasilitas'],
                $bobot['menu'], $item['menu'],
                $bobot['jam_operasional'], $item['durasi']
            );

            return [
                'nama_kafe'   => $item['nama'],
                'perhitungan' => $perhitungan,
                'skor'        => round($skor, 2),
            ];
        })->sortByDesc('skor')->values();

        // ========================
        // RETURN VIEW
        // ========================
        return view('admin.saw.index', compact(
            'matriks',
            'normalisasi',
            'hasil'
        ));
    }

    private function normBenefit($nilai, $max)
    {
        return $max == 0 ? 0 : round($nilai / $max, 2);
    }

    private function normCost($nilai, $min)
    {
        return $nilai == 0 ? 0 : round($min / $nilai, 2);
    }

    private function hitungDurasi($buka, $tutup)
    {
        if (!$buka || !$tutup) return 0;

        try {
            $buka  = \Carbon\Carbon::createFromFormat('H:i', $buka);
            $tutup = \Carbon\Carbon::createFromFormat('H:i', $tutup);

            if ($tutup <= $buka) $tutup->addDay();

            return round($buka->diffInMinutes($tutup) / 60, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }
}