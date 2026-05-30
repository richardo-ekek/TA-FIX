<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            // Identitas Pembuat
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            
            // Kategori Berita
            $table->enum('kategori', ['Dalam Negeri', 'Mancanegara', 'Kerjasama']);
            
            // Konten Berita
            $table->string('foto')->nullable(); // Untuk menyimpan path gambar
            $table->string('judul');
            $table->date('tanggal');
            $table->string('lokasi');
            $table->text('lead'); // Paragraf pembuka/ringkasan
            $table->longText('body'); // Isi utama berita
            $table->text('closing')->nullable(); // Paragraf penutup
            
            // Sistem Approval
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('alasan_penolakan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};