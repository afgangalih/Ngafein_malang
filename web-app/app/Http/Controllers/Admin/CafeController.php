<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = DB::table('kafe');

        if ($search) {
            // Mengelompokkan where agar tidak mengacaukan query lain nantinya
            $query->where(function($q) use ($search) {
                $q->where('nama_kafe', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $cafes = $query->paginate(7)->withQueryString();

        if ($request->ajax()) {
            return view('admin.cafe._table', compact('cafes'))->render();
        }

        return view('admin.cafe.index', compact('cafes'));
    }

    public function create() { return view('admin.cafe.create'); }
    public function edit($id) { return view('admin.cafe.edit'); }
}
