<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'bobot_kriteria';
    protected $primaryKey = 'id_kriteria';

    protected $fillable = [
        'nama_kriteria',
        'bobot',
        'tipe',
    ];
}
