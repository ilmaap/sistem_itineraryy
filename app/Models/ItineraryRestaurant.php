<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItineraryRestaurant extends Model
{
    use HasFactory;

    protected $table = 'itinerary_restaurant';
    protected $primaryKey = 'id';

    protected $fillable = [
        'itinerary_id',
        'restaurant_id',
        'no_hari',
        'jarak',
    ];

    protected $casts = [
        'jarak' => 'decimal:2',
    ];

    /**
     * Relasi belongsTo ke Itinerary
     */
    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class, 'itinerary_id');
    }

    /**
     * Relasi belongsTo ke Restaurant
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}

