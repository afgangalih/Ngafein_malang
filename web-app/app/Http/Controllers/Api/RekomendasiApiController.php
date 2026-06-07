<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use App\Services\SAWService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekomendasiApiController extends Controller
{
    public function index(Request $request, SAWService $sawService)
    {
        $query = KafeModel::approved()->with(['fasilitas', 'menus', 'gambar']);
        $user = $request->user();

        if ($user) {
            $blacklistedIds = $user->blacklistedCafes()->pluck('kafe_id')->toArray();

            if (!empty($blacklistedIds)) {
                $query->whereNotIn('id_kafe', $blacklistedIds);
            }
        }

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

        $kafes = $query->get();
        $engineError = null;
        $hasil = collect();

        if ($kafes->isNotEmpty()) {
            try {
                $hasil = $sawService->calculate($kafes, $this->getBobot())['hasil'];
            } catch (\Exception $e) {
                $engineError = $e->getMessage();
                $hasil = $this->fallbackResult($kafes);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $hasil->values(),
            'meta' => [
                'total' => $hasil->count(),
                'engine_error' => $engineError,
            ],
        ]);
    }

    private function getBobot(): array
    {
        $rows = DB::table('bobot_kriteria')->get()->keyBy('nama_kriteria');

        return [
            'harga' => $rows->get('harga')?->bobot ?? 0.20,
            'rating' => $rows->get('rating')?->bobot ?? 0.10,
            'jarak' => $rows->get('jarak')?->bobot ?? 0.20,
            'fasilitas' => $rows->get('fasilitas')?->bobot ?? 0.20,
            'menu' => $rows->get('menu')?->bobot ?? 0.15,
            'jam_operasional' => $rows->get('jam_operasional')?->bobot ?? 0.15,
        ];
    }

    private function fallbackResult($kafes)
    {
        return $kafes->values()->map(function ($cafe, $idx) {
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
                'gambar' => ($cafe->relationLoaded('gambar') && $cafe->gambar)
                    ? ($cafe->gambar->first()?->link_gambar ?? null)
                    : null,
                'skor' => 0.0,
                'ranking' => $idx + 1,
                'perhitungan' => '',
            ];
        });
    }
}
