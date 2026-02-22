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
        if (!Schema::hasTable('itinerary')) {
            Schema::create('itinerary', function (Blueprint $table) {
                $table->id(); // int, auto increment
                $table->unsignedBigInteger('user_id'); // int
                $table->string('nama', 255); // varchar(255)
                $table->decimal('start_location_lat', 10, 8); // decimal(10,8)
                $table->decimal('start_location_lng', 11, 8); // decimal(11,8)
                $table->date('tgl_keberangkatan'); // date
                $table->time('waktu_mulai'); // time
                $table->enum('jenis_jalur', ['tol', 'non_tol']); // enum(tol, non_tol)
                $table->integer('total_hari'); // int
                $table->enum('lokasi', ['solo', 'yogyakarta']); // enum(solo, yogyakarta)
                $table->decimal('min_rating', 3, 2)->nullable(); // decimal, nullable
                $table->longText('kategori')->nullable(); // longtext, nullable
                $table->timestamps(); // created_at dan updated_at (timestamp)
                
                // Foreign key constraint
                $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary');
    }
};

