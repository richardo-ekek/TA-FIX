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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // Kolom dari struktur pertama
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('action'); // create, update, delete, approve, reject
            $table->morphs('model'); // Otomatis membuat model_type dan model_id
            $table->json('snapshot');
            
            // Kolom dari struktur kedua
            $table->string('admin_name')->nullable();
            $table->string('kategori_dokumen')->nullable();
            $table->string('perihal_dokumen')->nullable();
            $table->string('aksi')->nullable();
            $table->text('catatan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};