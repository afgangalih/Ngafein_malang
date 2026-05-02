<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // mengecek apakah tabel ada sebelum melakukan count agar tidak error
        $totalKafe = Schema::hasTable('kafe') ? DB::table('kafe')->count() : 0;
        
        $stats = [
            'total_kafe' => $totalKafe,
            'total_kriteria' => 0,      // tabel kriteria belum ada
            'total_perhitungan' => 0,   // tabel perhitungan belum ada
            'total_rekomendasi' => 0,    // tabel ranking belum ada
        ];

        $topCafes = []; 
        
        return view('admin.dashboard', compact('stats', 'topCafes'));
    }
}
