<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use App\Models\ReviewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|min:5',
        ], [
            'rating.required' => 'Rating bintang wajib dipilih!',
            'rating.min' => 'Rating minimal adalah 1 bintang!',
            'rating.max' => 'Rating maksimal adalah 5 bintang!',
            'ulasan.required' => 'Isi ulasan wajib ditulis!',
            'ulasan.min' => 'Isi ulasan minimal 5 karakter!',
        ]);

        $cafe = KafeModel::findOrFail($id);

        ReviewModel::create([
            'user_id' => Auth::id(),
            'kafe_id' => $id,
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
        ]);

        // Recalculate average rating and update Kafe table
        $avgRating = ReviewModel::where('kafe_id', $id)->avg('rating');
        $cafe->update(['rating' => round($avgRating, 1)]);

        return redirect()->back()->with('success_review', 'Terima kasih atas ulasan Anda! Ulasan Anda sangat berharga bagi komunitas.');
    }
}
