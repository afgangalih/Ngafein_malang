<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\SAWService;

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

        return \SimpleXLSXGen::fromArray($excelData)
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

        if ($kafes->isEmpty()) {
            return ['hasil' => collect([]), 'bobot' => $bobot];
        }

        try {
            $sawService = new SAWService();
            $sawResult = $sawService->calculate($kafes, $bobot);
            $hasil = $sawResult['hasil'];
        } catch (\Exception $e) {
            $hasil = collect([]);
        }

        return ['hasil' => $hasil, 'bobot' => $bobot];
    }
}
