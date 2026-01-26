<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('absensi')) {
            return;
        }

        // Add column if missing
        if (!Schema::hasColumn('absensi', 'jadwal_harian_id')) {
            Schema::table('absensi', function (Blueprint $table) {
                $table->unsignedBigInteger('jadwal_harian_id')->nullable()->after('nomor_induk');
            });
        }

        // Add index and foreign key if not exists
        try {
            Schema::table('absensi', function (Blueprint $table) {
                if (!Schema::hasColumn('absensi', 'jadwal_harian_id')) return;

                // add index if not exists
                $table->index('jadwal_harian_id');

                // add FK
                $table->foreign('jadwal_harian_id')
                      ->references('id')
                      ->on('jadwal_harian')
                      ->onDelete('set null');
            });
        } catch (\Exception $e) {
            // ignore if already exists or if DB doesn't support
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('absensi')) {
            return;
        }

        try {
            Schema::table('absensi', function (Blueprint $table) {
                $table->dropForeign(['jadwal_harian_id']);
                $table->dropIndex(['jadwal_harian_id']);
            });
        } catch (\Exception $e) {
            // ignore
        }

        // Do not drop column to avoid data loss
    }
};
