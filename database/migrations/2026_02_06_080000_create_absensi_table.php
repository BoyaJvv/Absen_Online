<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            // INT UNSIGNED
            $table->increments('id');

            
            $table->char('nomor_induk', 30);

            $table->dateTime('absen')->nullable();
            $table->dateTime('absen_maks')->nullable();
            $table->char('kategori', 1)->nullable();
            
            $table->char('idmesin', 20)->nullable();

            // Foreign key string
            $table->foreign('nomor_induk')
                  ->references('nomor_induk')
                  ->on('pengguna')
                  ->cascadeOnDelete();

            $table->foreign('idmesin')
                  ->references('idmesin')
                  ->on('mesin')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
