<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasilitasModel extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';
    public $incrementing = false;
    protected $guarded = [];
}
