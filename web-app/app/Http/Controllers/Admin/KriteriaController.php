<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::all();
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

        return redirect()->route('admin.kriteria.index')
                         ->with('success', 'Kriteria berhasil diupdate!');
    }

    public function destroy($id)
    {
        Kriteria::findOrFail($id)->delete();
        return redirect()->route('admin.kriteria.index')
                         ->with('success', 'Kriteria berhasil dihapus!');
    }
}