<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Memaksa tambah remember_token di tabel users jika belum ada
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'remember_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->rememberToken();
            });
        }

        // 2. Memaksa tambah kolom-kolom log di tabel activity_logs jika belum ada
        if (Schema::hasTable('activity_logs')) {
            Schema::table('activity_logs', function (Blueprint $table) {
                if (!Schema::hasColumn('activity_logs', 'admin_name')) {
                    $table->string('admin_name')->nullable();
                }
                if (!Schema::hasColumn('activity_logs', 'kategori_dokumen')) {
                    $table->string('kategori_dokumen')->nullable();
                }
                if (!Schema::hasColumn('activity_logs', 'perihal_dokumen')) {
                    $table->string('perihal_dokumen')->nullable();
                }
                if (!Schema::hasColumn('activity_logs', 'aksi')) {
                    $table->string('aksi')->nullable();
                }
                if (!Schema::hasColumn('activity_logs', 'catatan')) {
                    $table->text('catatan')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // Dikosongkan agar aman
    }
};