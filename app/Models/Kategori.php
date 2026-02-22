<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_kategori'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi many-to-many ke Itinerary melalui pivot table itinerary_kategori
     */
    public function itinerary()
    {
        return $this->belongsToMany(Itinerary::class, 'itinerary_kategori', 'kategori_id', 'itinerary_id')
                    ->withTimestamps();
    }
}

