<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Http\Request;

class KafeApiController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->query('q');

        if (!$keyword || strlen($keyword) < 2) {
            return response()->json([
                'success' => true,
                'data' => [],
                'meta' => [
                    'total' => 0,
                    'query' => $keyword,
                ],
            ]);
        }

        $cafes = KafeModel::approved()
            ->with(['fasilitas', 'menus', 'gambar'])
            ->where('nama_kafe', 'like', '%' . $keyword . '%')
            ->orderBy('nama_kafe')
            ->get()
            ->map(fn ($cafe) => $this->formatCafe($cafe));

        return response()->json([
            'success' => true,
            'data' => $cafes,
            'meta' => [
                'total' => $cafes->count(),
                'query' => $keyword,
            ],
        ]);
    }

    public function show($id)
    {
        $cafe = KafeModel::approved()
            ->with(['fasilitas', 'menus', 'gambar'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $this->formatCafe($cafe),
        ]);
    }

    private function formatCafe(KafeModel $cafe): array
    {
        return [
            'id_kafe' => $cafe->id_kafe,
            'nama_kafe' => $cafe->nama_kafe,
            'alamat' => $cafe->alamat,
            'link_maps' => $cafe->link_maps,
            'harga_min' => $cafe->harga_min,
            'harga_max' => $cafe->harga_max,
            'rating' => $cafe->rating,
            'jarak' => $cafe->jarak,
            'jam_buka' => $cafe->jam_buka,
            'jam_tutup' => $cafe->jam_tutup,
            'deskripsi' => $cafe->deskripsi,
            'status' => $cafe->status,
            'user_id' => $cafe->user_id,
            'created_at' => $cafe->created_at?->toISOString(),
            'updated_at' => $cafe->updated_at?->toISOString(),
            'fasilitas' => $cafe->fasilitas->map(fn ($item) => [
                'id_fasilitas' => $item->id_fasilitas,
                'nama_fasilitas' => $item->nama_fasilitas,
            ])->values(),
            'menus' => $cafe->menus->map(fn ($item) => [
                'id_menu' => $item->id_menu,
                'nama_menu' => $item->nama_menu,
            ])->values(),
            'gambar' => $cafe->gambar->map(fn ($item) => [
                'id_gambar' => $item->id_gambar,
                'path_gambar' => $item->path_gambar,
                'link_gambar' => $item->link_gambar,
            ])->values(),
        ];
    }
}
