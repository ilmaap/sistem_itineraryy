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
        if (!Schema::hasTable('destinasi')) {
            Schema::create('destinasi', function (Blueprint $table) {
                $table->id(); // int, auto increment
                $table->string('nama', 255); // varchar(255)
                $table->enum('kategori', ['Wisata Alam', 'Wisata Buatan', 'Wisata Budaya', 'Wisata Minat Khusus']); // enum
                $table->text('alamat'); // text
                $table->enum('lokasi', ['solo', 'yogyakarta']); // enum
                $table->decimal('latitude', 10, 8); // decimal(10,8)
                $table->decimal('longitude', 11, 8); // decimal(11,8)
                $table->decimal('rating', 3, 2)->nullable(); // decimal(3,2), nullable
                $table->decimal('biaya', 10, 2)->nullable(); // decimal(10,2), nullable
                $table->text('deskripsi')->nullable(); // text, nullable
                $table->timestamps(); // created_at dan updated_at (timestamp)
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasi');
    }
};

