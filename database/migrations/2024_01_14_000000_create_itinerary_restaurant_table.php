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
        if (!Schema::hasTable('itinerary_restaurant')) {
            Schema::create('itinerary_restaurant', function (Blueprint $table) {
                $table->id();
                $table->foreignId('itinerary_id')->constrained('itinerary')->onDelete('cascade');
                $table->foreignId('restaurant_id')->constrained('restaurant')->onDelete('cascade');
                $table->integer('no_hari');
                $table->decimal('jarak', 10, 2)->default(0);
                $table->timestamps();
                
                // Index untuk performa query
                $table->index(['itinerary_id', 'no_hari']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_restaurant');
    }
};

