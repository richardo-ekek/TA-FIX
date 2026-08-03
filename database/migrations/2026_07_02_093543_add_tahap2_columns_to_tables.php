<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah foto profil di tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto_profil')->nullable()->after('password');
        });

        // 2. Tambah view counter di berita
        Schema::table('beritas', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0)->after('status');
        });

        // 3. Tambah admin tracker dan view counter di mou_pks
        Schema::table('mou_pks', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->after('id');
            $table->unsignedBigInteger('views')->default(0)->after('keterangan_tambahan');
            $table->foreign('admin_id')->references('id')->on('users')->nullOnDelete();
        });

        // 4. Tambah admin tracker dan view counter di tik_kemlu
        Schema::table('tik_kemlu', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->after('id');
            $table->unsignedBigInteger('views')->default(0)->after('keterangan_tambahan');
            $table->foreign('admin_id')->references('id')->on('users')->nullOnDelete();
        });

        // 5. Tambah admin tracker dan view counter di tik_non_kemlu
        Schema::table('tik_non_kemlu', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->after('id');
            $table->unsignedBigInteger('views')->default(0)->after('keterangan_tambahan');
            $table->foreign('admin_id')->references('id')->on('users')->nullOnDelete();
        });
        
        // 6. Tambah pencatat admin yang menindaklanjuti appointment
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->after('user_id')->comment('Admin yang menyetujui/menolak');
            $table->foreign('admin_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('foto_profil');
        });
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn('views');
        });
        Schema::table('mou_pks', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['admin_id', 'views']);
        });
        Schema::table('tik_kemlu', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['admin_id', 'views']);
        });
        Schema::table('tik_non_kemlu', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['admin_id', 'views']);
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }
};