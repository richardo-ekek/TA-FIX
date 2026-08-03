<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE mou_pks ADD COLUMN file_berita_acara VARCHAR(255) NULL AFTER status");
        DB::statement("ALTER TABLE tik_kemlu ADD COLUMN file_berita_acara VARCHAR(255) NULL AFTER status");
        DB::statement("ALTER TABLE tik_non_kemlu ADD COLUMN file_berita_acara VARCHAR(255) NULL AFTER status");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE mou_pks DROP COLUMN file_berita_acara");
        DB::statement("ALTER TABLE tik_kemlu DROP COLUMN file_berita_acara");
        DB::statement("ALTER TABLE tik_non_kemlu DROP COLUMN file_berita_acara");
    }
};