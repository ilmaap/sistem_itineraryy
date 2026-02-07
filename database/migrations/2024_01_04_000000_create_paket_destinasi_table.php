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
        if (!Schema::hasTable('paket_destinasi')) {
            Schema::create('paket_destinasi', function (Blueprint $table) {
                $table->id(); // int, auto increment
                $table->unsignedBigInteger('paket_id'); // foreign key ke paket
                $table->unsignedBigInteger('destinasi_id'); // foreign key ke destinasi
                $table->integer('order')->default(0); // urutan destinasi dalam paket
                $table->timestamps(); // created_at dan updated_at (timestamp)

                // Foreign keys
                $table->foreign('paket_id')->references('id')->on('paket')->onDelete('cascade');
                $table->foreign('destinasi_id')->references('id')->on('destinasi')->onDelete('cascade');

                // Unique constraint: satu paket tidak boleh memiliki destinasi yang sama dua kali
                $table->unique(['paket_id', 'destinasi_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_destinasi');
    }
};

