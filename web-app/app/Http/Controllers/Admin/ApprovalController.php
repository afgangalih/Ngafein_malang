<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    /**
     * Display a listing of pending cafe proposals.
     */
    public function index()
    {
        $proposals = KafeModel::withTrashed()
            ->whereNotNull('user_id')
            ->with(['user', 'gambar', 'fasilitas', 'menus'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.approval.index', compact('proposals'));
    }

    /**
     * Approve a cafe proposal.
     */
    public function approve($id)
    {
        $cafe = KafeModel::findOrFail($id);
        $cafe->update(['status' => 'approved']);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usulan kafe "' . $cafe->nama_kafe . '" berhasil disetujui!'
            ]);
        }

        return redirect()->back()->with('success', 'Usulan kafe berhasil disetujui.');
    }

    /**
     * Reject a cafe proposal.
     */
    public function reject($id)
    {
        $cafe = KafeModel::findOrFail($id);
        $cafe->update(['status' => 'rejected']);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Usulan kafe "' . $cafe->nama_kafe . '" berhasil ditolak.'
            ]);
        }

        return redirect()->back()->with('success', 'Usulan kafe berhasil ditolak.');
    }

    /**
     * Get the count of pending cafe proposals.
     */
    public function getPendingCount()
    {
        $count = KafeModel::where('status', 'pending')->count();
        $latestPending = KafeModel::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $list = $latestPending->map(function($item) {
            return [
                'id' => $item->id_kafe,
                'nama' => $item->nama_kafe,
                'time' => $item->created_at ? $item->created_at->diffForHumans() : 'Baru saja'
            ];
        });

        return response()->json([
            'count' => $count,
            'list' => $list
        ]);
    }
}
