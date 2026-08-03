<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk menambah kolom ke tabel.
     */
    public function up(): void
    {
        $tables = ['mou_pks', 'tik_kemlu', 'tik_non_kemlu', 'beritas'];
        
        foreach ($tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->integer('revisi_ke')->default(0)->after('status');
                $table->text('riwayat_revisi')->nullable()->after('revisi_ke');
            });
        }
    }

    /**
     * Batalkan migration jika diperlukan (rollback).
     */
    public function down(): void
    {
        $tables = ['mou_pks', 'tik_kemlu', 'tik_non_kemlu', 'beritas'];
        
        foreach ($tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->dropColumn(['revisi_ke', 'riwayat_revisi']);
            });
        }
    }
};