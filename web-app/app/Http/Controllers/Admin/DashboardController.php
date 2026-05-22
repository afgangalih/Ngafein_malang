<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use App\Models\Kriteria;
use App\Services\SAWService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(SAWService $sawService)
    {
        $totalKafe     = Schema::hasTable('kafe')           ? DB::table('kafe')->count()          : 0;
        $totalKriteria = Schema::hasTable('bobot_kriteria') ? DB::table('bobot_kriteria')->count() : 6;

        $kriterias  = Kriteria::all();
        $totalBobot = $kriterias->sum('bobot');

        $topCafes  = collect();
        $chartData = collect();
        $totalSAW  = 0;

        if ($totalKafe > 0) {
            $bobotRows = Schema::hasTable('bobot_kriteria')
                ? DB::table('bobot_kriteria')->get()->keyBy('nama_kriteria')
                : collect();

            $bobot = [
                'harga'           => $bobotRows->get('harga')?->bobot           ?? 0.20,
                'rating'          => $bobotRows->get('rating')?->bobot          ?? 0.10,
                'jarak'           => $bobotRows->get('jarak')?->bobot           ?? 0.20,
                'fasilitas'       => $bobotRows->get('fasilitas')?->bobot       ?? 0.20,
                'menu'            => $bobotRows->get('menu')?->bobot            ?? 0.15,
                'jam_operasional' => $bobotRows->get('jam_operasional')?->bobot ?? 0.15,
            ];

            $kafes = KafeModel::with(['fasilitas', 'menus'])->get();

            try {
                $sawResult = $sawService->calculate($kafes, $bobot);
                $hasilRanked = $sawResult['hasil'];
            } catch (\Exception $e) {
                $hasilRanked = collect();
            }

            $totalSAW = $hasilRanked->count();

            $topCafes = $hasilRanked->take(4)->map(function ($item) {
                return (object) [
                    'nama_kafe' => $item['nama_kafe'],
                    'skor'      => $item['skor'],
                    'ranking'   => $item['ranking'],
                ];
            });

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
}