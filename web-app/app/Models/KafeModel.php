<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KafeModel extends Model
{
    use SoftDeletes;

    protected $table = 'kafe';
    protected $primaryKey = 'id_kafe';
    protected $guarded = [];

    public function fasilitas()
    {
        return $this->belongsToMany(FasilitasModel::class, 'kafe_fasilitas', 'id_kafe', 'id_fasilitas');
    }

    public function menus()
    {
        return $this->belongsToMany(MenuModel::class, 'kafe_menu', 'id_kafe', 'id_menu');
    }

    public function gambar()
    {
        return $this->hasMany(KafeGambarModel::class, 'id_kafe');
    }

    public function reviews()
    {
        return $this->hasMany(ReviewModel::class, 'kafe_id', 'id_kafe');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorit_kafe', 'kafe_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function getHargaRataRataAttribute()
    {
        return ($this->harga_min + $this->harga_max) / 2;
    }
}
