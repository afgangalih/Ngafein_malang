<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Shuchkin\SimpleXLSXGen;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->calculateRankingData();
        $fullHasil = $data['hasil'];
        $bobot     = $data['bobot'];
        $totalKafe = count($fullHasil);

        if ($request->has('limit')) {
            session(['laporan_limit' => $request->get('limit')]);
        }
        $limit = session('laporan_limit', 'all');

        $topCafe      = $fullHasil->first();
        $rataRataSkor = $totalKafe > 0 ? round($fullHasil->avg('skor'), 3) : 0;

        $hasil = ($limit !== 'all' && is_numeric($limit))
            ? $fullHasil->take((int)$limit)
            : $fullHasil;

        return view('admin.laporan.index', compact(
            'hasil',
            'bobot',
            'totalKafe',
            'topCafe',
            'rataRataSkor',
            'limit'
        ));
    }

    public function printPdf(Request $request)
    {
        $data = $this->calculateRankingData();
        $fullHasil = $data['hasil'];
        $bobot     = $data['bobot'];
        $totalKafe = count($fullHasil);

        $limit = session('laporan_limit', 'all');

        $topCafe      = $fullHasil->first();
        $rataRataSkor = $totalKafe > 0 ? round($fullHasil->avg('skor'), 3) : 0;

        $hasil = ($limit !== 'all' && is_numeric($limit))
            ? $fullHasil->take((int)$limit)
            : $fullHasil;

        return view('admin.laporan.print', compact(
            'hasil', 'bobot', 'totalKafe', 'topCafe', 'rataRataSkor', 'limit'
        ));
    }

    public function exportExcel(Request $request)
    {
        require_once base_path('vendor/shuchkin/simplexlsxgen/src/SimpleXLSXGen.php');

        $data = $this->calculateRankingData();
        $hasil = $data['hasil'];

        $limit = $request->get('limit', 'all');
        if ($limit !== 'all' && is_numeric($limit)) {
            $hasil = $hasil->take((int)$limit);
        }

        $excelData = [
            ['<b>Peringkat</b>', '<b>Nama Kafe</b>', '<b>Alamat</b>', '<b>Rating</b>', '<b>Skor SAW (V)</b>', '<b>Kategori Rekomendasi</b>']
        ];

        foreach ($hasil as $index => $item) {
            $skor = $item['skor'];
            $kategori = 'Cukup';
            if ($skor >= 0.85) {
                $kategori = 'Sangat Direkomendasikan';
            } elseif ($skor >= 0.70) {
                $kategori = 'Direkomendasikan';
            }

            $excelData[] = [
                $index + 1,
                $item['nama_kafe'],
                $item['alamat'],
                $item['rating'],
                $skor,
                $kategori
            ];
        }

        $waktu = Carbon::now()->format('Ymd_His');
        $filename = "Laporan_Rekomendasi_Kafe_Ngafein_{$waktu}.xlsx";

        return SimpleXLSXGen::fromArray($excelData)
            ->setDefaultFont('Calibri')
            ->downloadAs($filename);
    }

    private function calculateRankingData()
    {
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

        $kafes = KafeModel::with(['fasilitas', 'menus'])->get();

        $matriks = $kafes->map(function ($kafe) {
            $durasi = $this->hitungDurasi($kafe->jam_buka, $kafe->jam_tutup);
            return [
                'nama_kafe' => $kafe->nama_kafe,
                'alamat'    => $kafe->alamat ?? '-',
                'rating_raw'=> $kafe->rating ?? 0,
                'harga'     => $this->skalaHarga($kafe->harga_min),
                'rating'    => $this->skalaRating($kafe->rating),
                'jarak'     => $this->skalaJarak($kafe->jarak),
                'fasilitas' => $this->skalaFasilitas($kafe->fasilitas->count()),
                'menu'      => $this->skalaMenu($kafe->menus->count()),
                'durasi'    => $this->skalaDurasi($durasi),
            ];
        });

        if ($matriks->isEmpty()) {
            return ['hasil' => collect([]), 'bobot' => $bobot];
        }

        $maxMin = [
            'harga'     => ['min' => $matriks->min('harga') ?: 1],
            'rating'    => ['max' => $matriks->max('rating') ?: 1],
            'jarak'     => ['min' => $matriks->min('jarak') ?: 1],
            'fasilitas' => ['max' => $matriks->max('fasilitas') ?: 1],
            'menu'      => ['max' => $matriks->max('menu') ?: 1],
            'durasi'    => ['max' => $matriks->max('durasi') ?: 1],
        ];

        $normalisasi = $matriks->map(function ($item) use ($maxMin) {
            return [
                'nama'      => $item['nama_kafe'],
                'alamat'    => $item['alamat'],
                'rating'    => $item['rating_raw'],
                'harga'     => $this->normCost($item['harga'], $maxMin['harga']['min']),
                'rating_norm'=> $this->normBenefit($item['rating'], $maxMin['rating']['max']),
                'jarak'     => $this->normCost($item['jarak'], $maxMin['jarak']['min']),
                'fasilitas' => $this->normBenefit($item['fasilitas'], $maxMin['fasilitas']['max']),
                'menu'      => $this->normBenefit($item['menu'], $maxMin['menu']['max']),
                'durasi'    => $this->normBenefit($item['durasi'], $maxMin['durasi']['max']),
            ];
        });

        $hasil = $normalisasi->map(function ($item) use ($bobot) {
            $skor =
                ($bobot['harga'] * $item['harga']) +
                ($bobot['rating'] * $item['rating_norm']) +
                ($bobot['jarak'] * $item['jarak']) +
                ($bobot['fasilitas'] * $item['fasilitas']) +
                ($bobot['menu'] * $item['menu']) +
                ($bobot['jam_operasional'] * $item['durasi']);

            return [
                'nama_kafe' => $item['nama'],
                'alamat'    => $item['alamat'],
                'rating'    => $item['rating'],
                'skor'      => round($skor, 3),
            ];
        })->sortByDesc('skor')->values();

        $hasil = $hasil->map(function ($item, $index) {
            $item['ranking'] = $index + 1;
            return $item;
        });

        return ['hasil' => $hasil, 'bobot' => $bobot];
    }

    private function normBenefit($nilai, $max)
    {
        return $max == 0 ? 0 : round($nilai / $max, 3);
    }

    private function normCost($nilai, $min)
    {
        return $nilai == 0 ? 0 : round($min / $nilai, 3);
    }

    private function skalaHarga($harga)
    {
        if ($harga <= 25000) return 1;
        if ($harga <= 50000) return 2;
        return 3;
    }

    private function skalaRating($rating)
    {
        if ($rating < 2) return 1;
        if ($rating < 3) return 2;
        if ($rating < 4) return 3;
        if ($rating < 5) return 4;
        return 5;
    }

    private function skalaJarak($jarak)
    {
        if ($jarak < 1) return 1;
        if ($jarak <= 2) return 2;
        if ($jarak <= 4) return 3;
        if ($jarak <= 6) return 4;
        return 5;
    }

    private function skalaFasilitas($jumlah)
    {
        if ($jumlah <= 2) return 1;
        if ($jumlah <= 4) return 2;
        if ($jumlah <= 6) return 3;
        if ($jumlah <= 8) return 4;
        return 5;
    }

    private function skalaMenu($jumlah)
    {
        if ($jumlah <= 2) return 1;
        if ($jumlah <= 4) return 2;
        if ($jumlah == 5) return 3;
        if ($jumlah == 6) return 4;
        return 5;
    }

    private function skalaDurasi($durasi)
    {
        if ($durasi <= 5) return 1;
        if ($durasi <= 10) return 2;
        if ($durasi <= 15) return 3;
        if ($durasi <= 20) return 4;
        return 5;
    }

    private function hitungDurasi($buka, $tutup)
    {
        if (!$buka || !$tutup) return 0;
        try {
            $jamBuka = Carbon::createFromFormat('H:i', $buka);
            $jamTutup = Carbon::createFromFormat('H:i', $tutup);
            if ($jamTutup <= $jamBuka) $jamTutup->addDay();
            return round($jamBuka->diffInMinutes($jamTutup) / 60, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
