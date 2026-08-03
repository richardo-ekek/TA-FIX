<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah kolom status di semua tabel menjadi tipe String (VARCHAR)
        DB::statement("ALTER TABLE beritas MODIFY status VARCHAR(255) DEFAULT 'pending'");
        DB::statement("ALTER TABLE mou_pks MODIFY status VARCHAR(255) DEFAULT 'pending'");
        DB::statement("ALTER TABLE tik_kemlu MODIFY status VARCHAR(255) DEFAULT 'pending'");
        DB::statement("ALTER TABLE tik_non_kemlu MODIFY status VARCHAR(255) DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Dikosongkan saja agar jika di-rollback, kolom tetap aman sebagai VARCHAR
    }
};