<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KafeModel;
use Illuminate\Http\Request;

class BlacklistApiController extends Controller
{
    public function toggle(Request $request, $id)
    {
        KafeModel::findOrFail($id);

        $user = $request->user();
        $hasBlacklist = $user->blacklistedCafes()
            ->where('blacklist_kafe.kafe_id', $id)
            ->exists();

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
