<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');


        if ($category) {
            $query = KafeModel::with(['menus', 'gambar', 'fasilitas'])
                ->withCount(['fasilitas', 'menus']);

            switch ($category) {
                case 'terdekat':
                    $query->where('jarak', '<=', 1.5)
                          ->orderBy('jarak', 'asc');
                    $title = "Dekat dari Kampus (< 1.5km)";
                    break;
                case 'fasilitas':
                    $query->having('fasilitas_count', '>=', 9)
                          ->orderBy('fasilitas_count', 'desc');
                    $title = "Fasilitas Paling Sultan (9+ Fasilitas)";
                    break;
                case 'menu':
                    $query->having('menus_count', '>=', 6)
                          ->orderBy('menus_count', 'desc');
                    $title = "Variasi Menu Terbanyak (6+ Jenis)";
                    break;
                case '24jam':
                    $query->where('jam_buka', '00:00')
                          ->where('jam_tutup', '23:59');
                    $title = "Buka 24 Jam";
                    break;
                default:
                    $query->orderBy('nama_kafe', 'asc');
                    $title = "Semua Kafe";
            }

            $cafes = $query->paginate(12)->appends($request->query());
            $allFasilitas = \App\Models\FasilitasModel::all();
            $allMenus = \App\Models\MenuModel::all();
            return view('user.list-cafe', compact('cafes', 'title', 'allFasilitas', 'allMenus'));
        }

        
        $terdekat = KafeModel::with(['menus', 'gambar', 'fasilitas'])
            ->where('jarak', '<=', 1.5)
            ->orderBy('jarak', 'asc')
            ->take(4)->get();
        $sultan = KafeModel::with(['menus', 'gambar', 'fasilitas'])
            ->withCount('fasilitas')
            ->having('fasilitas_count', '>=', 9)
            ->orderBy('fasilitas_count', 'desc')
            ->take(4)->get();
        $menuLengkap = KafeModel::with(['menus', 'gambar', 'fasilitas'])
            ->withCount('menus')
            ->having('menus_count', '>=', 6)
            ->orderBy('menus_count', 'desc')
            ->take(4)->get();
        $buka24jam = KafeModel::with(['menus', 'gambar', 'fasilitas'])
            ->where('jam_buka', '00:00')
            ->where('jam_tutup', '23:59')
            ->take(4)
            ->get();

        return view('user.index-cafe', compact('terdekat', 'sultan', 'menuLengkap', 'buka24jam'));
    }

    public function show($id)
    {
        $cafe = KafeModel::with(['fasilitas', 'menus', 'gambar'])->findOrFail($id);

        $rekomendasi = KafeModel::with(['menus', 'gambar', 'fasilitas'])
            ->where('id_kafe', '!=', $id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('user.cafe-detail', compact('cafe', 'rekomendasi'));
    }

    public function searchApi(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $cafes = KafeModel::where('nama_kafe', 'like', '%' . $query . '%')
            ->take(5)
            ->get(['id_kafe', 'nama_kafe', 'jarak']);

        return response()->json($cafes);
    }
}
