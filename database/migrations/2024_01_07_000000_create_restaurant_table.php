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
        if (!Schema::hasTable('restaurant')) {
            Schema::create('restaurant', function (Blueprint $table) {
                $table->id();
                $table->string('nama', 255);
                $table->text('alamat');
                $table->enum('lokasi', ['solo', 'yogyakarta']);
                $table->decimal('latitude', 10, 8);
                $table->decimal('longitude', 11, 8);
                $table->decimal('rating', 3, 2)->nullable();
                $table->text('deskripsi')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant');
    }
};

