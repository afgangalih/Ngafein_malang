<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Total kafe & rating rata-rata
        $totalKafe  = DB::table('kafe')->count();
        $avgRating  = DB::table('kafe')->avg('rating');

        // 3 kafe unggulan (rating tertinggi)
        $kafeUnggulan = DB::table('kafe')
            ->orderByDesc('rating')
            ->limit(3)
            ->get();

        // Filter rekomendasi berdasarkan waktu saat ini
        $hour = now()->hour;
        $rekomendasiWaktu = $this->getWaktuLabel($hour);

        // Semua kafe (untuk halaman lihat semua)
        $semuaKafe = DB::table('kafe')
            ->orderByDesc('rating')
            ->get();

        return view('welcome', compact(
            'totalKafe',
            'avgRating',
            'kafeUnggulan',
            'rekomendasiWaktu',
            'semuaKafe'
        ));
    }

    public function cariRekomendasi(Request $request)
    {
        $query = DB::table('kafe');

        // Filter harga
        if ($request->filled('harga_min')) {
            $query->where('harga_min', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_max', '<=', $request->harga_max);
        }

        // Filter rating
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Filter jarak
        if ($request->filled('jarak')) {
            $query->where('jarak', '<=', $request->jarak);
        }

        // Filter jam buka sekarang
        if ($request->boolean('buka_sekarang')) {
            $jamSekarang = now()->format('H:i');
            $query->where('jam_buka', '<=', $jamSekarang)
                  ->where('jam_tutup', '>=', $jamSekarang);
        }

        $kafeFilter = $query->orderByDesc('rating')->get();

        return response()->json($kafeFilter);
    }

    /**
     * Tentukan label waktu berdasarkan jam
     */
    private function getWaktuLabel(int $hour): string
    {
        return match(true) {
            $hour >= 6  && $hour < 10  => 'Pagi Sunyi',
            $hour >= 10 && $hour < 14  => 'Morning Rush',
            $hour >= 14 && $hour < 18  => 'Golden Hour',
            default                    => 'Night Mode',
        };
    }
}