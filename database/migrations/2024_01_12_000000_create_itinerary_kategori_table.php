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
        if (!Schema::hasTable('itinerary_kategori')) {
            Schema::create('itinerary_kategori', function (Blueprint $table) {
                $table->id();
                $table->foreignId('itinerary_id')->constrained('itinerary')->onDelete('cascade');
                $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
                $table->timestamps();
                
                // Unique constraint untuk mencegah duplikasi
                $table->unique(['itinerary_id', 'kategori_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_kategori');
    }
};

