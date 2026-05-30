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
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('nama');
        $table->string('instansi');
        $table->text('alamat');
        $table->string('tujuan');
        $table->text('detail_tujuan');
        $table->enum('mode', ['daring', 'luring']);
        $table->dateTime('preferensi_waktu')->nullable();
        $table->enum('status', ['submitted', 'processing', 'approved', 'rejected'])->default('submitted');
        $table->string('link_meeting')->nullable();
        $table->text('alamat_pertemuan')->nullable();
        $table->dateTime('tanggal_waktu_pertemuan')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
