<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE appointments ADD COLUMN tipe_pemohon VARCHAR(50) DEFAULT 'institusi' AFTER user_id");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE appointments DROP COLUMN tipe_pemohon");
    }
};