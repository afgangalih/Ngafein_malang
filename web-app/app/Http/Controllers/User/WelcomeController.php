<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KafeModel;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $totalKafe  = KafeModel::approved()->count();
        $avgRating  = KafeModel::approved()->avg('rating');

        $kafeUnggulan = KafeModel::approved()->with('gambar')
            ->orderByDesc('rating')
            ->limit(3)
            ->get();

        $hour = now()->hour;
        $rekomendasiWaktu = $this->getWaktuLabel($hour);

        $semuaKafe = KafeModel::approved()->with('gambar')
            ->orderByDesc('rating')
            ->get();

        return view('user.landing.index', compact(
            'totalKafe',
            'avgRating',
            'kafeUnggulan',
            'rekomendasiWaktu',
            'semuaKafe'
        ));
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