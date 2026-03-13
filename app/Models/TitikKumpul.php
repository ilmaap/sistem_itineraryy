<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitikKumpul extends Model
{
    protected $table = 'titik_kumpul';

    protected $fillable = [
        'nama',
        'kategori',
        'latitude',
        'longitude',
        'alamat',
    ];
}


