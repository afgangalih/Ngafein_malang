<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FasilitasModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FasilitasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $fasilitas = FasilitasModel::query()
            ->when($search, fn ($query) => $query->where('nama_fasilitas', 'like', "%{$search}%"))
            ->orderBy('id_fasilitas')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.fasilitas.index', compact('fasilitas', 'search'));
    }

    public function create()
    {
        return redirect()->route('admin.fasilitas.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_fasilitas' => ['required', 'string', 'max:255', 'unique:fasilitas,nama_fasilitas'],
        ]);

        $fasilitas = FasilitasModel::create([
            'id_fasilitas' => ((int) FasilitasModel::max('id_fasilitas')) + 1,
            'nama_fasilitas' => $validated['nama_fasilitas'],
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Fasilitas berhasil ditambahkan.',
                'data' => $fasilitas,
            ]);
        }

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.fasilitas.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('admin.fasilitas.index');
    }

    public function update(Request $request, string $id)
    {
        $fasilitas = FasilitasModel::findOrFail($id);

        $validated = $request->validate([
            'nama_fasilitas' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fasilitas', 'nama_fasilitas')->ignore($fasilitas->id_fasilitas, 'id_fasilitas'),
            ],
        ]);

        $fasilitas->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Fasilitas berhasil diperbarui.',
                'data' => $fasilitas,
            ]);
        }

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id)
    {
        $fasilitas = FasilitasModel::findOrFail($id);
        $fasilitas->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Fasilitas berhasil dihapus.',
            ]);
        }

        return redirect()->route('admin.fasilitas.index')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
