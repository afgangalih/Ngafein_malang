<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $favorites = $user->favorites()
            ->with(['gambar', 'menus', 'fasilitas'])
            ->get();

        $blacklisted = $user->blacklistedCafes()
            ->with(['gambar', 'menus', 'fasilitas'])
            ->get();

        $mergedCafes = collect();

        foreach($favorites as $fav) {
            $mergedCafes->push($this->formatCafeData($fav, true, false));
        }

        foreach($blacklisted as $bl) {
            if ($mergedCafes->contains('id', $bl->id_kafe)) {
                continue;
            }
            $mergedCafes->push($this->formatCafeData($bl, false, true));
        }

        return view('user.favorit.index', [
            'cafes' => $mergedCafes
        ]);
    }

    private function formatCafeData($cafe, $bookmarked, $blacklisted)
    {
        $firstImage = $cafe->gambar->first();
        $imageUrl = 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=800';

        if ($firstImage) {
            if ($firstImage->link_gambar) {
                $imageUrl = $firstImage->link_gambar;
            } elseif ($firstImage->path_gambar) {
                $imageUrl = asset('storage/' . $firstImage->path_gambar);
            }
        }

        $rating = (float)$cafe->rating;
        $ratingLabel = 'Good Vibes';
        if ($rating >= 4.5) {
            $ratingLabel = 'Excellent';
        } elseif ($rating >= 4.0) {
            $ratingLabel = 'Really Good';
        }

        $hasWifi = $cafe->fasilitas->contains(function ($f) {
            return str_contains(strtolower($f->nama_fasilitas), 'wifi');
        });

        $hasOutlets = $cafe->fasilitas->contains(function ($f) {
            return str_contains(strtolower($f->nama_fasilitas), 'colokan');
        });

        $hasAc = $cafe->fasilitas->contains(function ($f) {
            return str_contains(strtolower($f->nama_fasilitas), 'ac');
        });

        return [
            'id' => $cafe->id_kafe,
            'name' => $cafe->nama_kafe,
            'image' => $imageUrl,
            'location' => $cafe->alamat,
            'category' => 'Cafe',
            'rating' => $rating,
            'price' => (int)$cafe->harga_min,
            'priceLabel' => 'Rp ' . number_format($cafe->harga_min, 0, ',', '.'),
            'ratingLabel' => $ratingLabel,
            'bookmarked' => $bookmarked,
            'blacklisted' => $blacklisted,
            'reviewCount' => $cafe->reviews->count(),
            'description' => $cafe->deskripsi ?? 'Tidak ada deskripsi.',
            'amenities' => [
                'internet' => $hasWifi ? 'Super Fast' : 'Standar',
                'outlets' => $hasOutlets ? 'Melimpah' : 'Terbatas',
                'comfort' => $hasAc ? 'Sangat Nyaman' : 'Nyaman'
            ]
        ];
    }

    public function toggle(Request $request, $id)
    {
        $cafe = KafeModel::findOrFail($id);
        $user = Auth::user();

        $hasBookmark = $user->favorites()->where('favorit_kafe.kafe_id', $id)->exists();

        if ($hasBookmark) {
            $user->favorites()->detach($id);
            $bookmarked = false;
            $message = 'Kafe berhasil dihapus dari favorit Anda.';
        } else {
            if ($user->blacklistedCafes()->where('blacklist_kafe.kafe_id', $id)->exists()) {
                $user->blacklistedCafes()->detach($id);
            }
            $user->favorites()->attach($id);
            $bookmarked = true;
            $message = 'Kafe berhasil ditambahkan ke favorit Anda.';
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
            'message' => $message,
        ]);
    }

    public function toggleBlacklist(Request $request, $id)
    {
        $cafe = KafeModel::findOrFail($id);
        $user = Auth::user();

        $hasBlacklist = $user->blacklistedCafes()->where('blacklist_kafe.kafe_id', $id)->exists();

        if ($hasBlacklist) {
            $user->blacklistedCafes()->detach($id);
            $blacklisted = false;
            $message = 'Kafe berhasil dipulihkan dari daftar pengecualian.';
        } else {
            if ($user->favorites()->where('favorit_kafe.kafe_id', $id)->exists()) {
                $user->favorites()->detach($id);
            }
            $user->blacklistedCafes()->attach($id);
            $blacklisted = true;
            $message = 'Kafe berhasil dikecualikan dari sistem rekomendasi.';
        }

        return response()->json([
            'success' => true,
            'blacklisted' => $blacklisted,
            'message' => $message,
        ]);
    }
}
