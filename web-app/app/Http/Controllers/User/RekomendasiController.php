<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KafeModel;
use App\Models\FasilitasModel;
use App\Services\SAWService;

class RekomendasiController extends Controller
{
    private const FASILITAS_ALLOWED = [
        'colokan',      'indoor',   'mushola',
        'outdoor',      'parkir',   'rooftop',
        'semi_outdoor', 'toilet',   'wifi',
    ];

    public function cariRekomendasi(Request $request, SAWService $sawService)
    {
        $semuaFasilitas = FasilitasModel::whereIn(
                DB::raw('LOWER(REPLACE(nama_fasilitas, " ", "_"))'),
                self::FASILITAS_ALLOWED
            )
            ->orderBy('nama_fasilitas')
            ->get();

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

        $sudahDicari = $request->hasAny([
            'harga_max', 'jarak_max', 'rating_min',
            'fasilitas', 'menu_min', 'jam_operasional',
        ]);

        $hasil = collect();
        $engineError = null;

        if ($sudahDicari) {
            $query = KafeModel::with(['fasilitas', 'menus', 'gambar']);

            if ($request->filled('harga_max')) {
                $query->where('harga_min', '<=', (int) $request->harga_max);
            }

            if ($request->filled('jarak_max')) {
                $query->where('jarak', '<=', (float) $request->jarak_max);
            }

            if ($request->filled('rating_min')) {
                $query->where('rating', '>=', (float) $request->rating_min);
            }

            if ($request->filled('fasilitas') && is_array($request->fasilitas)) {
                foreach ($request->fasilitas as $fasId) {
                    $query->whereHas('fasilitas', function ($q) use ($fasId) {
                        $q->where('fasilitas.id_fasilitas', $fasId);
                    });
                }
            }

            if ($request->filled('menu_min')) {
                $query->has('menus', '>=', (int) $request->menu_min);
            }

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

            if ($kafes->isNotEmpty()) {
                $bobot = $this->getBobot();
                try {
                    $sawResult = $sawService->calculate($kafes, $bobot);
                    $hasil = $sawResult['hasil'];
                } catch (\Exception $e) {
                    $engineError = $e->getMessage();
                    $hasil = $kafes->map(function ($cafe, $idx) {
                        return [
                            'id_kafe' => $cafe->id_kafe,
                            'nama_kafe' => $cafe->nama_kafe,
                            'alamat' => $cafe->alamat,
                            'rating' => $cafe->rating,
                            'rating_raw' => $cafe->rating,
                            'jam_buka' => $cafe->jam_buka ? substr($cafe->jam_buka, 0, 5) : null,
                            'jam_tutup' => $cafe->jam_tutup ? substr($cafe->jam_tutup, 0, 5) : null,
                            'jarak' => $cafe->jarak,
                            'jarak_km' => $cafe->jarak,
                            'harga_min' => $cafe->harga_min,
                            'harga_max' => $cafe->harga_max,
                            'gambar' => ($cafe->relationLoaded('gambar') && $cafe->gambar) ? ($cafe->gambar->first()?->link_gambar ?? null) : null,
                            'skor' => 0.0,
                            'ranking' => $idx + 1,
                            'perhitungan' => ''
                        ];
                    });
                }
            }
        }

        return view('user.rekomendasi.index', compact(
            'hasil',
            'semuaFasilitas',
            'sudahDicari',
            'engineError',
        ));
    }

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
}
