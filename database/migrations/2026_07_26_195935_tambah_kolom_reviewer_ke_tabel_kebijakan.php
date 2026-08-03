<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['mou_pks', 'tik_kemlu', 'tik_non_kemlu'];
        foreach ($tables as $t) {
            DB::statement("ALTER TABLE {$t} ADD COLUMN tim_hukum_id BIGINT UNSIGNED NULL AFTER admin_id");
            DB::statement("ALTER TABLE {$t} ADD COLUMN super_admin_id BIGINT UNSIGNED NULL AFTER tim_hukum_id");
        }
    }

    public function down(): void
    {
        $tables = ['mou_pks', 'tik_kemlu', 'tik_non_kemlu'];
        foreach ($tables as $t) {
            DB::statement("ALTER TABLE {$t} DROP COLUMN tim_hukum_id");
            DB::statement("ALTER TABLE {$t} DROP COLUMN super_admin_id");
        }
    }
};