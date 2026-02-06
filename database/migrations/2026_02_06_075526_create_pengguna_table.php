<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {

            // PRIMARY KEY string
            $table->char('nomor_induk', 30)->primary();

            $table->string('nama', 100);
            $table->string('tag', 50);

            // Foreign key INT UNSIGNED
            $table->unsignedInteger('jabatan_status');
            $table->foreign('jabatan_status')
                  ->references('id')
                  ->on('jabatan_status')
                  ->cascadeOnDelete();

            // Foreign key INT UNSIGNED
            $table->unsignedInteger('cabang_gedung');
            $table->foreign('cabang_gedung')
                  ->references('id')
                  ->on('cabang_gedung')
                  ->cascadeOnDelete();

            $table->string('password', 255);
            $table->char('aktif', 1)->default('1');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
