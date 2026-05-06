<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FasilitasModel;
use App\Models\KafeModel;
use App\Models\KafeGambarModel;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $query = KafeModel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kafe', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $cafes = $query->orderBy('id_kafe', 'asc')->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            return view('admin.cafe._table', compact('cafes'))->render();
        }

        return view('admin.cafe.index', compact('cafes'));
    }

    public function create(Request $request)
    {
        $fasilitas = FasilitasModel::all();
        $menus = MenuModel::all();
        
        if ($request->ajax()) {
            return view('admin.cafe.partials.form', compact('fasilitas', 'menus'))->render();
        }

        return view('admin.cafe.create', compact('fasilitas', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kafe' => 'required|string|max:255',
            'harga_min' => 'required|numeric',
            'harga_max' => 'required|numeric',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        
        $data = $request->only([
            'nama_kafe', 'alamat', 'link_maps', 'harga_min', 'harga_max', 
            'rating', 'jarak', 'jam_buka', 'jam_tutup', 'deskripsi'
        ]);

        $kafe = KafeModel::create($data);

        
        if ($request->has('fasilitas')) {
            $kafe->fasilitas()->sync($request->fasilitas);
        }

      
        if ($request->has('menu')) {
            $kafe->menus()->sync($request->menu);
        }
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('kafe', 'public');
                $kafe->gambar()->create(['path_gambar' => $path]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data kafe berhasil ditambahkan']);
    }

    public function show($id, Request $request)
    {
        $kafe = KafeModel::with(['fasilitas', 'menus', 'gambar'])->findOrFail($id);

        if ($request->ajax()) {
            return view('admin.cafe.partials.detail', compact('kafe'))->render();
        }

        return view('admin.cafe.show', compact('kafe'));
    }

    public function edit($id, Request $request)
    {
        $kafe = KafeModel::with(['fasilitas', 'menus'])->findOrFail($id);
        $fasilitas = FasilitasModel::all();
        $menus = MenuModel::all();

        if ($request->ajax()) {
            return view('admin.cafe.partials.form', compact('kafe', 'fasilitas', 'menus'))->render();
        }

        return view('admin.cafe.edit', compact('kafe', 'fasilitas', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $kafe = KafeModel::findOrFail($id);
        
        $request->validate([
            'nama_kafe' => 'required|string|max:255',
            'harga_min' => 'required|numeric',
            'harga_max' => 'required|numeric',
        ]);

        $data = $request->only([
            'nama_kafe', 'alamat', 'link_maps', 'harga_min', 'harga_max', 
            'rating', 'jarak', 'jam_buka', 'jam_tutup', 'deskripsi'
        ]);

        $kafe->update($data);

       
        $kafe->fasilitas()->sync($request->fasilitas ?? []);
        
      
        $kafe->menus()->sync($request->menu ?? []);

        
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('kafe', 'public');
                $kafe->gambar()->create(['path_gambar' => $path]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Data kafe berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $kafe = KafeModel::findOrFail($id);
        
       
        foreach($kafe->gambar as $g) {
            Storage::disk('public')->delete($g->path_gambar);
        }
        
        $kafe->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function deleteImage($id)
    {
        $gambar = KafeGambarModel::findOrFail($id);
        Storage::disk('public')->delete($gambar->path_gambar);
        $gambar->delete();

        return response()->json(['success' => true]);
    }
}