<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;

    protected $table = 'itinerary';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'nama',
        'start_location_lat',
        'start_location_lng',
        'tgl_keberangkatan',
        'waktu_mulai',
        'jenis_jalur',
        'total_hari',
        'lokasi',
        'min_rating',
        'kategori'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'start_location_lat' => 'decimal:8',
        'start_location_lng' => 'decimal:8',
        'tgl_keberangkatan' => 'date',
        'waktu_mulai' => 'string',
        'min_rating' => 'decimal:2',
    ];

    /**
     * Relasi belongsTo ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi many-to-many ke Kategori melalui pivot table itinerary_kategori
     */
    public function kategori()
    {
        return $this->belongsToMany(Kategori::class, 'itinerary_kategori', 'itinerary_id', 'kategori_id')
                    ->withTimestamps();
    }

    /**
     * Relasi hasMany ke ItineraryDestinasi
     */
    public function itineraryDestinasi()
    {
        return $this->hasMany(ItineraryDestinasi::class, 'itinerary_id')
                    ->orderBy('no_hari')
                    ->orderBy('order');
    }

    /**
     * Relasi many-to-many ke Destinasi melalui pivot table itinerary_destinasi
     */
    public function destinasi()
    {
        return $this->belongsToMany(Destinasi::class, 'itinerary_destinasi', 'itinerary_id', 'destinasi_id')
                    ->withPivot('no_hari', 'order', 'total_jarak', 'waktu_tiba', 'waktu_selesai', 'durasi', 'jarak_dari_sebelumnya')
                    ->withTimestamps()
                    ->orderBy('no_hari')
                    ->orderBy('order');
    }

    /**
     * Relasi hasMany ke ItineraryRestaurant
     */
    public function itineraryRestaurant()
    {
        return $this->hasMany(ItineraryRestaurant::class, 'itinerary_id')
                    ->orderBy('no_hari');
    }

    /**
     * Relasi many-to-many ke Restaurant melalui pivot table itinerary_restaurant
     */
    public function restaurant()
    {
        return $this->belongsToMany(Restaurant::class, 'itinerary_restaurant', 'itinerary_id', 'restaurant_id')
                    ->withPivot('no_hari', 'jarak')
                    ->withTimestamps()
                    ->orderBy('no_hari');
    }

    /**
     * Relasi hasMany ke ItineraryAkomodasi
     */
    public function itineraryAkomodasi()
    {
        return $this->hasMany(ItineraryAkomodasi::class, 'itinerary_id')
                    ->orderBy('no_hari');
    }

    /**
     * Relasi many-to-many ke Akomodasi melalui pivot table itinerary_akomodasi
     */
    public function akomodasi()
    {
        return $this->belongsToMany(Akomodasi::class, 'itinerary_akomodasi', 'itinerary_id', 'akomodasi_id')
                    ->withPivot('no_hari', 'jarak')
                    ->withTimestamps()
                    ->orderBy('no_hari');
    }
}

