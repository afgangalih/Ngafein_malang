<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Support\Facades\DB;

class PerhitunganSAWController extends Controller
{
    public function index()
    {
        // Ambil bobot kriteria dari database
        $bobotRows = DB::table('bobot_kriteria')->get()->keyBy('nama_kriteria');

        // Bobot masing-masing kriteria (fallback ke nilai default jika belum ada di DB)
        $bobot = [
            'harga'           => $bobotRows->get('harga')?->bobot           ?? 0.25,
            'rating'          => $bobotRows->get('rating')?->bobot          ?? 0.10,
            'jarak'           => $bobotRows->get('jarak')?->bobot           ?? 0.20,
            'fasilitas'       => $bobotRows->get('fasilitas')?->bobot       ?? 0.20,
            'menu'            => $bobotRows->get('menu')?->bobot            ?? 0.15,
            'jam_operasional' => $bobotRows->get('jam_operasional')?->bobot ?? 0.10,
        ];

        // Ambil semua kafe beserta relasi
        $kafes = KafeModel::with(['fasilitas', 'menus'])->get();

        // Bangun nilai mentah tiap kafe
        $nilaiMentah = $kafes->map(function ($kafe) {
            return [
                'id_kafe'   => $kafe->id_kafe,
                'nama_kafe' => $kafe->nama_kafe,
                'harga'     => $kafe->harga_min,
                'rating'    => (float) $kafe->rating,
                'jarak'     => (float) $kafe->jarak,
                'fasilitas' => $kafe->fasilitas->count(),
                'menu'      => $kafe->menus->count(),
                'durasi'    => $this->hitungDurasi($kafe->jam_buka, $kafe->jam_tutup),
            ];
        });

        // Hitung nilai max/min untuk normalisasi
        $maxMin = [
            'harga'     => ['min' => $nilaiMentah->min('harga'),     'max' => $nilaiMentah->max('harga')],
            'rating'    => ['min' => $nilaiMentah->min('rating'),    'max' => $nilaiMentah->max('rating')],
            'jarak'     => ['min' => $nilaiMentah->min('jarak'),     'max' => $nilaiMentah->max('jarak')],
            'fasilitas' => ['min' => $nilaiMentah->min('fasilitas'), 'max' => $nilaiMentah->max('fasilitas')],
            'menu'      => ['min' => $nilaiMentah->min('menu'),      'max' => $nilaiMentah->max('menu')],
            'durasi'    => ['min' => $nilaiMentah->min('durasi'),    'max' => $nilaiMentah->max('durasi')],
        ];

        // Normalisasi tiap nilai
        $hasil = $nilaiMentah->map(function ($item) use ($maxMin, $bobot) {

            // Normalisasi: Cost = min/xi, Benefit = xi/max
            $r = [
                'harga'     => $this->normCost($item['harga'],     $maxMin['harga']['min']),
                'rating'    => $this->normBenefit($item['rating'],  $maxMin['rating']['max']),
                'jarak'     => $this->normCost($item['jarak'],     $maxMin['jarak']['min']),
                'fasilitas' => $this->normBenefit($item['fasilitas'], $maxMin['fasilitas']['max']),
                'menu'      => $this->normBenefit($item['menu'],   $maxMin['menu']['max']),
                'durasi'    => $this->normBenefit($item['durasi'], $maxMin['durasi']['max']),
            ];

            // Skor SAW = Σ (bobot × nilai_normalisasi)
            $skor =
                ($bobot['harga']           * $r['harga'])     +
                ($bobot['rating']          * $r['rating'])    +
                ($bobot['jarak']           * $r['jarak'])     +
                ($bobot['fasilitas']       * $r['fasilitas']) +
                ($bobot['menu']            * $r['menu'])      +
                ($bobot['jam_operasional'] * $r['durasi']);

            // Bangun string perhitungan untuk ditampilkan di tabel
            $perhitungan = sprintf(
                '(%.2f×%.2f) + (%.2f×%.2f) + (%.2f×%.2f) + (%.2f×%.2f) + (%.2f×%.2f) + (%.2f×%.2f)',
                $bobot['harga'],           $r['harga'],
                $bobot['rating'],          $r['rating'],
                $bobot['jarak'],           $r['jarak'],
                $bobot['fasilitas'],       $r['fasilitas'],
                $bobot['menu'],            $r['menu'],
                $bobot['jam_operasional'], $r['durasi']
            );

            return [
                'id_kafe'      => $item['id_kafe'],
                'nama_kafe'    => $item['nama_kafe'],
                'normalisasi'  => $r,
                'perhitungan'  => $perhitungan,
                'skor'         => round($skor, 2),
            ];
        })->sortByDesc('skor')->values();

        return view('admin.saw.index', compact('hasil', 'bobot'));
    }

    // Normalisasi Benefit: xi / max
    private function normBenefit(float $nilai, float $max): float
    {
        if ($max == 0) return 0;
        return round($nilai / $max, 2);
    }

    // Normalisasi Cost: min / xi
    private function normCost(float $nilai, float $min): float
    {
        if ($nilai == 0) return 0;
        return round($min / $nilai, 2);
    }

    // Hitung durasi operasional dalam jam
    private function hitungDurasi(?string $jamBuka, ?string $jamTutup): float
    {
        if (!$jamBuka || !$jamTutup) return 0;
        try {
            $buka  = \Carbon\Carbon::createFromFormat('H:i', $jamBuka);
            $tutup = \Carbon\Carbon::createFromFormat('H:i', $jamTutup);
            if ($tutup->lte($buka)) $tutup->addDay();
            return round($buka->diffInMinutes($tutup) / 60, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }
}