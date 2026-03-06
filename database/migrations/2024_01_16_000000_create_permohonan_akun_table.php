<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check jika tabel sudah ada, skip pembuatan
        if (!Schema::hasTable('permohonan_akun')) {
            Schema::create('permohonan_akun', function (Blueprint $table) {
                $table->id(); // int, auto increment
                $table->string('nama', 255); // varchar(255)
                $table->string('email', 255); // varchar(255)
                $table->string('no_telp', 20); // varchar(20)
                $table->text('deskripsi'); // text
                $table->timestamps(); // created_at dan updated_at (timestamp)
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_akun');
    }
};

