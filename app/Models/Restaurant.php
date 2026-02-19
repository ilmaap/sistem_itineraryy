<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = 'restaurant';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'alamat',
        'lokasi',
        'latitude',
        'longitude',
        'rating',
        'deskripsi'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:2',
    ];
}

