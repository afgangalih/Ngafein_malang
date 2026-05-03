<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search');
        $perPage = $request->input('per_page', 10); // default 10

        $query = DB::table('kafe');

        // 🔍 SEARCH (nama + alamat)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kafe', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // 📊 PAGINATION (10 / 25 / 50 / 100)
        $cafes = $query
            ->orderBy('id_kafe', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        // ⚡ AJAX RESPONSE (buat realtime search & table reload)
        if ($request->ajax()) {
            return view('admin.cafe._table', compact('cafes'))->render();
        }

        return view('admin.cafe.index', compact('cafes'));
    }

    public function create()
    {
        return view('admin.cafe.create');
    }

    public function edit($id)
    {
        $cafe = DB::table('kafe')->where('id_kafe', $id)->first();

        return view('admin.cafe.edit', compact('cafe'));
    }

    public function destroy($id)
    {
        DB::table('kafe')->where('id_kafe', $id)->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}