<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw statements to safely modify types and add FKs when possible
        $statements = [
            // Standardize PK/FK integer unsigned
            "ALTER TABLE cabang_gedung MODIFY id INT UNSIGNED NOT NULL",
            "ALTER TABLE jadwal_harian MODIFY cabang_gedung_id INT UNSIGNED NOT NULL",
            "ALTER TABLE pengguna MODIFY cabang_gedung INT UNSIGNED",
            "ALTER TABLE pengguna MODIFY jabatan_status INT UNSIGNED",
            "ALTER TABLE mesin MODIFY id_cabang_gedung INT UNSIGNED",
            "ALTER TABLE jabatan_status MODIFY hak_akses INT UNSIGNED",
            // Ensure absensi.jadwal_harian_id is unsigned bigint to match jadwal_harian.id
            "ALTER TABLE absensi MODIFY jadwal_harian_id BIGINT UNSIGNED NULL",
        ];

        foreach ($statements as $sql) {
            try {
                DB::statement($sql);
            } catch (\Exception $e) {
                // ignore failures (column missing or already correct)
            }
        }

        // Add foreign keys if missing. Wrap each in try/catch to avoid breaking if exists.
        try {
            Schema::table('absensi', function (Blueprint $table) {
                $table->foreign('nomor_induk')
                      ->references('nomor_induk')
                      ->on('pengguna')
                      ->onUpdate('cascade')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) { /* ignore */ }

        try {
            Schema::table('absensi', function (Blueprint $table) {
                $table->foreign('jadwal_harian_id')
                      ->references('id')
                      ->on('jadwal_harian')
                      ->onDelete('set null');
            });
        } catch (\Exception $e) { /* ignore */ }

        try {
            Schema::table('jabatan_status', function (Blueprint $table) {
                $table->foreign('hak_akses')
                      ->references('id')
                      ->on('hak_akses')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) { /* ignore */ }

        try {
            Schema::table('pengguna', function (Blueprint $table) {
                $table->foreign('jabatan_status')
                      ->references('id')
                      ->on('jabatan_status')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) { /* ignore */ }

        try {
            Schema::table('mesin', function (Blueprint $table) {
                $table->foreign('id_cabang_gedung')
                      ->references('id')
                      ->on('cabang_gedung')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) { /* ignore */ }
    }

    public function down(): void
    {
        // Attempt to drop the FKs added above
        try {
            Schema::table('absensi', function (Blueprint $table) {
                $table->dropForeign(['nomor_induk']);
            });
        } catch (\Exception $e) { }

        try {
            Schema::table('absensi', function (Blueprint $table) {
                $table->dropForeign(['jadwal_harian_id']);
            });
        } catch (\Exception $e) { }

        try {
            Schema::table('jabatan_status', function (Blueprint $table) {
                $table->dropForeign(['hak_akses']);
            });
        } catch (\Exception $e) { }

        try {
            Schema::table('pengguna', function (Blueprint $table) {
                $table->dropForeign(['jabatan_status']);
            });
        } catch (\Exception $e) { }

        try {
            Schema::table('mesin', function (Blueprint $table) {
                $table->dropForeign(['id_cabang_gedung']);
            });
        } catch (\Exception $e) { }
    }
};
