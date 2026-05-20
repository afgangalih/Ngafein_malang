<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use App\Models\KafeGambarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KafeGambarBatchController extends Controller
{
    /**
     * Tampilkan halaman form upload batch gambar.
     */
    public function index()
    {
        $cafes = KafeModel::orderBy('nama_kafe')->get();
        return view('admin.galeri.batch', compact('cafes'));
    }

    /**
     * Proses upload batch gambar untuk satu kafe (AJAX).
     */
    public function upload(Request $request)
    {
        $request->validate([
            'id_kafe' => 'required|exists:kafe,id_kafe',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072'
        ], [
            'id_kafe.required' => 'Kafe harus dipilih.',
            'id_kafe.exists' => 'Kafe tidak valid.',
            'images.required' => 'Gambar harus diunggah.',
            'images.array' => 'Format gambar tidak valid.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'images.*.max' => 'Ukuran gambar maksimal adalah 3MB.'
        ]);

        $kafe = KafeModel::findOrFail($request->id_kafe);

        // Validasi batas maksimal gambar agar tidak spamming (misal 10 gambar per kafe)
        $currentImagesCount = $kafe->gambar()->count();
        if ($currentImagesCount + count($request->file('images')) > 10) {
            return response()->json([
                'success' => false,
                'message' => 'Total gambar untuk kafe ini melebihi batas (maksimal 10 gambar per kafe).'
            ], 422);
        }

        $uploaded = [];
        foreach ($request->file('images') as $file) {
            $path = $file->store('kafe', 'public');
            $img = $kafe->gambar()->create([
                'path_gambar' => $path
            ]);
            $uploaded[] = $img;
        }

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil diunggah untuk ' . $kafe->nama_kafe,
            'data' => $uploaded
        ]);
    }
}
