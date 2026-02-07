<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketDestinasi extends Model
{
    use HasFactory;

    protected $table = 'paket_destinasi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'paket_id',
        'destinasi_id',
        'order'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'paket_id' => 'integer',
        'destinasi_id' => 'integer',
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Paket
     */
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    /**
     * Relasi ke Destinasi
     */
    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'destinasi_id');
    }
}

