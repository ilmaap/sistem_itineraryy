<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItineraryAkomodasi extends Model
{
    use HasFactory;

    protected $table = 'itinerary_akomodasi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'itinerary_id',
        'akomodasi_id',
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
     * Relasi belongsTo ke Akomodasi
     */
    public function akomodasi()
    {
        return $this->belongsTo(Akomodasi::class, 'akomodasi_id');
    }
}

