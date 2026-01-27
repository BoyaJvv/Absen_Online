<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        /**
         * Samakan tipe data kolom
         * jabatan_status.id  = unsignedBigInteger
         * pengguna.jabatan_status = unsignedBigInteger
         */
        Schema::table('jabatan_status', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
        });

        Schema::table('pengguna', function (Blueprint $table) {
            $table->unsignedBigInteger('jabatan_status')->change();
        });

        /**
         *  Tambah FOREIGN KEY
         */
        Schema::table('pengguna', function (Blueprint $table) {
            $table->foreign('jabatan_status', 'fk_pengguna_jabatan_status')
                  ->references('id')
                  ->on('jabatan_status')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        /**
         * Rollback FK & index
         */
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropForeign('fk_pengguna_jabatan_status');
            $table->dropIndex('idx_pengguna_jabatan_status');
        });
    }
};
