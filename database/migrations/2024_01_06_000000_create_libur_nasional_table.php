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
        if (!Schema::hasTable('libur_nasional')) {
            Schema::create('libur_nasional', function (Blueprint $table) {
                $table->id();
                $table->date('tanggal');
                $table->string('nama', 255);
                $table->integer('tahun');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libur_nasional');
    }
};

