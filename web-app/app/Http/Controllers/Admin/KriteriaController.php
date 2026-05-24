<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all()->map(fn($k) => [
            'id' => $k->id_kriteria,
            'nama' => $k->nama_kriteria,
            'bobot' => (float)$k->bobot,
            'tipe' => ucfirst($k->tipe)
        ]);
        
        $totalBobot = Kriteria::sum('bobot');
        return view('admin.kriteria.index', compact('kriterias', 'totalBobot'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot'         => 'required|numeric|min:0|max:1',
            'tipe'          => 'required|in:benefit,cost',
        ]);

        
        Kriteria::create($request->only('nama_kriteria', 'bobot', 'tipe'));

        return redirect()->route('admin.kriteria.index')
                         ->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot'         => 'required|numeric|min:0|max:1',
            'tipe'          => 'required|in:benefit,cost',
        ]);

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update($request->only('nama_kriteria', 'bobot', 'tipe'));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kriteria berhasil diupdate!',
                'data' => $kriteria
            ]);
        }

        return redirect()->route('admin.kriteria.index')
                         ->with('success', 'Kriteria berhasil diupdate!');
    }

    public function destroy(Request $request, $id)
    {
        Kriteria::findOrFail($id)->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kriteria berhasil dihapus!'
            ]);
        }

        return redirect()->route('admin.kriteria.index')
                         ->with('success', 'Kriteria berhasil dihapus!');
    }
}