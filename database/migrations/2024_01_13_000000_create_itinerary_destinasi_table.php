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
        if (!Schema::hasTable('itinerary_destinasi')) {
            Schema::create('itinerary_destinasi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('itinerary_id')->constrained('itinerary')->onDelete('cascade');
                $table->foreignId('destinasi_id')->constrained('destinasi')->onDelete('cascade');
                $table->integer('no_hari');
                $table->integer('order');
                $table->decimal('total_jarak', 10, 2)->default(0);
                $table->time('waktu_tiba')->nullable();
                $table->time('waktu_selesai')->nullable();
                $table->integer('durasi')->default(120); // dalam menit
                $table->decimal('jarak_dari_sebelumnya', 10, 2)->default(0);
                $table->timestamps();
                
                // Index untuk performa query
                $table->index(['itinerary_id', 'no_hari', 'order']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_destinasi');
    }
};

