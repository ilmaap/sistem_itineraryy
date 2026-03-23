<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('permohonan_akun')) {
            return;
        }

        if (Schema::hasColumn('permohonan_akun', 'status')) {
            return;
        }

        Schema::table('permohonan_akun', function (Blueprint $table) {
            // Keep workflow state consistent.
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu')
                ->index();
        });

        // Backfill untuk data lama (jika ada) supaya tidak null.
        DB::table('permohonan_akun')
            ->whereNull('status')
            ->update(['status' => 'menunggu']);
    }

    public function down(): void
    {
        if (!Schema::hasTable('permohonan_akun')) {
            return;
        }

        if (!Schema::hasColumn('permohonan_akun', 'status')) {
            return;
        }

        Schema::table('permohonan_akun', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};


