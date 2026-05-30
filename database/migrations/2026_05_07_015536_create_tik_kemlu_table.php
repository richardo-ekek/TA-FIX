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
    Schema::create('tik_kemlu', function (Blueprint $table) {
        $table->id();
        $table->string('jenis_kebijakan');
        $table->string('nomor_kebijakan');
        $table->year('tahun');
        $table->string('perihal');
        $table->string('tautan')->nullable();
        $table->enum('status', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tik_kemlu');
    }
};
