<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
      
    }

    public function down()
    {
        // Hapus foreign keys
        Schema::table('mesin', function (Blueprint $table) {
            $table->dropForeign(['id_cabang_gedung']);
        });

        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['nomor_induk']);
        });

        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropForeign(['cabang_gedung']);
            $table->dropForeign(['jabatan_status']);
        });

        // Kembalikan tipe data (perlu konversi manual)
        // Note: Rollback untuk tipe data lebih kompleks
    }
};