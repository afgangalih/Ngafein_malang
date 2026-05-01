<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeGambarModel extends Model
{
    protected $table = 'kafe_gambar';
    protected $primaryKey = 'id_gambar';
    protected $guarded = [];

    public function getLinkGambarAttribute()
    {
        return asset('storage/' . $this->path_gambar);
    }
}
