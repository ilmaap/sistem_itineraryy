<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Catatan: Kolom role menggunakan ENUM dengan nilai: 'wisatawan', 'admin', 'super_admin'
     */
    public function up(): void
    {
        // Check jika tabel sudah ada, skip pembuatan
        if (!Schema::hasTable('user')) {
            Schema::create('user', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('email')->unique();
                $table->string('no_telp')->nullable();
                $table->string('password');
                // Kolom role menggunakan ENUM dengan 3 nilai: wisatawan, admin, super_admin
                $table->enum('role', ['wisatawan', 'admin', 'super_admin'])->default('wisatawan');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
