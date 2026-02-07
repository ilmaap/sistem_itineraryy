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
        if (!Schema::hasTable('paket')) {
            Schema::create('paket', function (Blueprint $table) {
                $table->id(); // int, auto increment
                $table->string('nama', 255); // varchar(255)
                $table->string('image', 255); // varchar(255)
                $table->integer('durasi'); // int (berapa hari)
                $table->decimal('harga', 10, 2); // decimal(10,2)
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
        Schema::dropIfExists('paket');
    }
};

