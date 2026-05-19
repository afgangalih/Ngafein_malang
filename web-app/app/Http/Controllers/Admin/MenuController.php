<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $menus = MenuModel::query()
            ->when($search, fn ($query) => $query->where('nama_menu', 'like', "%{$search}%"))
            ->orderBy('id_menu')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.menu.index', compact('menus', 'search'));
    }

    public function create()
    {
        return redirect()->route('admin.menu.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => ['required', 'string', 'max:255', 'unique:menu,nama_menu'],
        ]);

        $menu = MenuModel::create([
            'id_menu' => ((int) MenuModel::max('id_menu')) + 1,
            'nama_menu' => $validated['nama_menu'],
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori menu berhasil ditambahkan.',
                'data' => $menu,
            ]);
        }

        return redirect()->route('admin.menu.index')->with('success', 'Kategori menu berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('admin.menu.index');
    }

    public function edit(string $id)
    {
        return redirect()->route('admin.menu.index');
    }

    public function update(Request $request, string $id)
    {
        $menu = MenuModel::findOrFail($id);

        $validated = $request->validate([
            'nama_menu' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menu', 'nama_menu')->ignore($menu->id_menu, 'id_menu'),
            ],
        ]);

        $menu->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori menu berhasil diperbarui.',
                'data' => $menu,
            ]);
        }

        return redirect()->route('admin.menu.index')->with('success', 'Kategori menu berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id)
    {
        $menu = MenuModel::findOrFail($id);
        $menu->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori menu berhasil dihapus.',
            ]);
        }

        return redirect()->route('admin.menu.index')->with('success', 'Kategori menu berhasil dihapus.');
    }
}
