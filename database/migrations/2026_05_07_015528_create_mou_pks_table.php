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
    Schema::create('mou_pks', function (Blueprint $table) {
        $table->id();
        $table->enum('jenis', ['MoU', 'PKS']);
        $table->string('perihal');
        $table->string('satker_kemlu');
        $table->string('instansi_external');
        $table->date('tanggal_disahkan')->nullable();
        $table->date('tanggal_berakhir')->nullable();
        $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'aktif', 'tidak aktif', 'dalam proses'])->default('draft');
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mou_pks');
    }
};
