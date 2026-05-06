<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeModel extends Model
{
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
}
