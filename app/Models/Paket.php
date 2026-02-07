<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'image',
        'durasi',
        'harga',
        'deskripsi'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'durasi' => 'integer',
        'harga' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi many-to-many ke Destinasi melalui pivot table paket_destinasi
     */
    public function destinasi()
    {
        // Kolom 'order' digunakan untuk menyimpan hari (tanpa menambah kolom baru)
        // Urutan sebenarnya mengikuti urutan input (index array)
        return $this->belongsToMany(Destinasi::class, 'paket_destinasi', 'paket_id', 'destinasi_id')
                    ->withPivot('order')
                    ->withTimestamps()
                    ->orderByPivot('order'); // Sort by hari (yang tersimpan di kolom order)
    }

    /**
     * Relasi ke PaketDestinasi (pivot model)
     */
    public function paketDestinasi()
    {
        return $this->hasMany(PaketDestinasi::class, 'paket_id');
    }
}

