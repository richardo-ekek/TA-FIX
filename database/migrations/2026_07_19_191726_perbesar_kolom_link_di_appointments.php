<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah kolom link_maps dan link_meeting menjadi tipe TEXT (Kapasitas ~65.000 karakter)
        DB::statement("ALTER TABLE appointments MODIFY link_maps TEXT");
        DB::statement("ALTER TABLE appointments MODIFY link_meeting TEXT");
    }

    public function down(): void
    {
        // Kembalikan ke VARCHAR(255) jika di-rollback
        DB::statement("ALTER TABLE appointments MODIFY link_maps VARCHAR(255)");
        DB::statement("ALTER TABLE appointments MODIFY link_meeting VARCHAR(255)");
    }
};