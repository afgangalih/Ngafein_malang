<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
       
        $totalKafe  = DB::table('kafe')->count();
        $avgRating  = DB::table('kafe')->avg('rating');

        
        $kafeUnggulan = DB::table('kafe')
            ->orderByDesc('rating')
            ->limit(3)
            ->get();

       
        $hour = now()->hour;
        $rekomendasiWaktu = $this->getWaktuLabel($hour);

        
        $semuaKafe = DB::table('kafe')
            ->orderByDesc('rating')
            ->get();

        return view('user.welcome', compact(
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

        
        if ($request->filled('harga_min')) {
            $query->where('harga_min', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_max', '<=', $request->harga_max);
        }

        
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

       
        if ($request->filled('jarak')) {
            $query->where('jarak', '<=', $request->jarak);
        }

        
        if ($request->boolean('buka_sekarang')) {
            $jamSekarang = now()->format('H:i');
            $query->where('jam_buka', '<=', $jamSekarang)
                  ->where('jam_tutup', '>=', $jamSekarang);
        }

        $kafeFilter = $query->orderByDesc('rating')->get();

        return response()->json($kafeFilter);
    }

   
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