<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
    protected $table = 'review_kafe';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kafe()
    {
        return $this->belongsTo(KafeModel::class, 'kafe_id', 'id_kafe');
    }
}
