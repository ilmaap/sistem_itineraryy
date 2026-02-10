<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiburNasional extends Model
{
    use HasFactory;

    protected $table = 'libur_nasional';
    protected $primaryKey = 'id';

    protected $fillable = [
        'tanggal',
        'nama',
        'tahun',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'tahun' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

