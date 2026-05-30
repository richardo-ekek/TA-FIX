<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan penambahan kolom ke 3 tabel.
     */
    public function up(): void
    {
        $tables = ['mou_pks', 'tik_kemlu', 'tik_non_kemlu'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                // Menambahkan 2 kolom baru, nullable artinya boleh kosong saat draf baru dibuat
                $table->text('alasan_penolakan')->nullable();
                $table->text('keterangan_tambahan')->nullable();
            });
        }
    }

    /**
     * Membatalkan penambahan kolom (jika terjadi error/rollback).
     */
    public function down(): void
    {
        $tables = ['mou_pks', 'tik_kemlu', 'tik_non_kemlu'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn(['alasan_penolakan', 'keterangan_tambahan']);
            });
        }
    }
};