<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanAkun extends Model
{
    use HasFactory;

    protected $table = 'permohonan_akun';

    protected $fillable = [
        'nama',
        'email',
        'no_telp',
        'deskripsi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

