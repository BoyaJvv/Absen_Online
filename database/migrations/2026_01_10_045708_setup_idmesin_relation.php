<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * 1. Tambah kolom idmesin di tabel mesin (kalau belum ada)
         */
        Schema::table('mesin', function (Blueprint $table) {
            if (!Schema::hasColumn('mesin', 'idmesin')) {
                $table->string('idmesin', 20)
                      ->nullable()
                      ->collation('utf8mb4_general_ci')
                      ->after('id_mesin');
            }
        });

        /**
         * 2. Samakan struktur idmesin di absensi
         */
        DB::statement("
            ALTER TABLE absensi
            MODIFY idmesin VARCHAR(20)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_general_ci
            NULL
        ");

        /**
         * 3. Karena MESIN CUMA 1:
         * paksa semua data mesin = 1
         * db::statement dipakai supaya compatible di semua versi mysql/postgres    
         */
        DB::statement("
            UPDATE mesin
            SET idmesin = '1'
        ");

        /**
         * 4. Hapus duplikat mesin, sisakan 1 baris
         */
        DB::statement("
            DELETE FROM mesin
            WHERE id_mesin NOT IN (
                SELECT MIN(id_mesin) FROM mesin
            )
        ");
    }

    public function down(): void
    {
        // sengaja dikosongkan (legacy database safety)
    }
};
