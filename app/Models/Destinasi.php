<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destinasi extends Model
{
    use HasFactory;

    protected $table = 'destinasi';
    protected $primaryKey = 'id'; // Jika tidak pakai auto increment id, sesuaikan

    protected $fillable = [
        'nama',
        'kategori',
        'alamat',
        'lokasi',
        'latitude',
        'longitude',
        'rating',
        'biaya',
        'deskripsi'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:2',
        'biaya' => 'decimal:2',
    ];
}

