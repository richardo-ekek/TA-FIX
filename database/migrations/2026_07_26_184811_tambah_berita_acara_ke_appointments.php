<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk menambah kolom baru.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Menambahkan kolom file_berita_acara (untuk menyimpan path file PDF) setelah kolom 'status'
            $table->string('file_berita_acara')->nullable()->after('status');
            
            // Menambahkan kolom catatan_pertemuan (untuk menyimpan kesimpulan/hasil rapat)
            $table->text('catatan_pertemuan')->nullable()->after('file_berita_acara');
        });
    }

    /**
     * Batalkan migration (hapus kolom jika di-rollback).
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Menghapus kembali kedua kolom jika menjalankan perintah php artisan migrate:rollback
            $table->dropColumn(['file_berita_acara', 'catatan_pertemuan']);
        });
    }
};