<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use App\Services\SAWService;
use Illuminate\Support\Facades\DB;

class PerhitunganSAWController extends Controller
{
    public function index(SAWService $sawService)
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

        $kafes = KafeModel::with([
            'fasilitas',
            'menus'
        ])->get();

        if ($kafes->isEmpty()) {
            $matriks = collect();
            $normalisasi = collect();
            $hasil = collect();
        } else {
            try {
                $sawResult = $sawService->calculate($kafes, $bobot);
                $matriks = $sawResult['matriks'];
                $normalisasi = $sawResult['normalisasi'];
                $hasil = $sawResult['hasil'];
            } catch (\Exception $e) {
                $matriks = collect();
                $normalisasi = collect();
                $hasil = collect();
            }
        }

        return view('admin.saw.index', compact(
            'matriks',
            'normalisasi',
            'hasil'
        ));
    }

    public function exportPdf()
    {
        return redirect()->route('admin.laporan.print');
    }
}