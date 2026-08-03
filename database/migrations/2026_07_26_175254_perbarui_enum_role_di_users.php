<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mengubah kolom role agar mendaftarkan pilihan baru 'tim_hukum'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'user', 'tim_hukum') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        // Kembalikan ke pilihan semula jika di-rollback
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'user') NOT NULL DEFAULT 'user'");
    }
};