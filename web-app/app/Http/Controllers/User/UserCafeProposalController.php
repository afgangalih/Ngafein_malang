<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FasilitasModel;
use App\Models\KafeModel;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\ImageModerationService;

class UserCafeProposalController extends Controller
{
    /**
     * Display a listing of the user's cafe proposals.
     */
    public function index()
    {
        $proposals = Auth::user()
            ->proposedCafes()
            ->withTrashed()
            ->with(['gambar', 'menus', 'fasilitas'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.kafe.usulan', compact('proposals'));
    }

    /**
     * Show the form for creating a new cafe proposal.
     */
    public function create()
    {
        $fasilitas = FasilitasModel::all();
        $menus = MenuModel::all();

        return view('user.kafe.tambah', compact('fasilitas', 'menus'));
    }

    /**
     * Store a newly created cafe proposal in storage.
     */
    public function store(Request $request, ImageModerationService $imageModeration)
    {
        $request->validate([
            'nama_kafe' => 'required|string|max:255',
            'alamat' => 'required|string',
            'harga_min' => 'required|numeric|min:0',
            'harga_max' => 'required|numeric|min:0',
            'jarak' => 'required|numeric|min:0',
            'jam_buka' => 'required|string',
            'jam_tutup' => 'required|string',
            'deskripsi' => 'nullable|string',
            'link_maps' => 'nullable|url',
            'rating' => 'required|numeric|min:1|max:5',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nama_kafe.required' => 'Nama kafe wajib diisi!',
            'alamat.required' => 'Alamat kafe wajib diisi!',
            'harga_min.required' => 'Harga minimal wajib diisi!',
            'harga_max.required' => 'Harga maksimal wajib diisi!',
            'jarak.required' => 'Jarak dari kampus wajib diisi!',
            'jam_buka.required' => 'Jam buka wajib diisi!',
            'jam_tutup.required' => 'Jam tutup wajib diisi!',
            'link_maps.url' => 'Format link Google Maps tidak valid!',
            'rating.required' => 'Rating kafe wajib diisi!',
            'rating.min' => 'Rating minimal adalah 1.',
            'rating.max' => 'Rating maksimal adalah 5.',
            'gambar.*.image' => 'File yang diupload harus berupa gambar!',
            'gambar.*.mimes' => 'Format gambar harus jpeg, png, atau jpg!',
            'gambar.*.max' => 'Ukuran gambar maksimal adalah 2MB!'
        ]);

        // 1. Strict Input Sanitization to prevent XSS (Cross-Site Scripting)
        $rawInput = $request->only([
            'nama_kafe', 'alamat', 'link_maps', 'harga_min', 'harga_max', 
            'jarak', 'jam_buka', 'jam_tutup', 'deskripsi', 'rating'
        ]);
        
        $data = [];
        foreach ($rawInput as $key => $value) {
            // Trim whitespace and strip any HTML/Script tags to prevent XSS injection
            $data[$key] = $value !== null ? strip_tags(trim($value)) : null;
        }

        // Forced attributes for user proposal (Secure state-control)
        $data['status'] = 'pending';
        $data['user_id'] = Auth::id();

        // 2. Perform Image Content Safety & Structure Verification
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                if (!$imageModeration->isSafe($file)) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['gambar' => 'Salah satu berkas gambar ditolak karena terindikasi tidak aman, rusak, atau memiliki format tidak valid!']);
                }
            }
        }

        // 3. Save Cafe (Eloquent protects against SQL Injection automatically)
        $kafe = KafeModel::create($data);

        // Sync Fasilitas
        if ($request->has('fasilitas')) {
            $kafe->fasilitas()->sync($request->fasilitas);
        }

        // Sync Menu
        if ($request->has('menu')) {
            $kafe->menus()->sync($request->menu);
        }

        // Upload and store images
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('kafe', 'public');
                $kafe->gambar()->create(['path_gambar' => $path]);
            }
        }

        return redirect()->back()->with('success', 'Kafe berhasil diajukan! Harap tunggu persetujuan dari Admin sebelum kafe Anda tampil secara publik.');
    }
}
