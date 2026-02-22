<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItineraryDestinasi extends Model
{
    use HasFactory;

    protected $table = 'itinerary_destinasi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'itinerary_id',
        'destinasi_id',
        'no_hari',
        'order',
        'total_jarak',
        'waktu_tiba',
        'waktu_selesai',
        'durasi',
        'jarak_dari_sebelumnya',
    ];

    protected $casts = [
        'total_jarak' => 'decimal:2',
        'waktu_tiba' => 'string',
        'waktu_selesai' => 'string',
        'durasi' => 'integer',
        'jarak_dari_sebelumnya' => 'decimal:2',
    ];

    /**
     * Relasi belongsTo ke Itinerary
     */
    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class, 'itinerary_id');
    }

    /**
     * Relasi belongsTo ke Destinasi
     */
    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id');
    }
}

