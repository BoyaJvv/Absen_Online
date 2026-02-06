<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mesin', function (Blueprint $table) {
            $table->increments('id_mesin'); // INT UNSIGNED

            // Foreign key INT UNSIGNED
            $table->unsignedInteger('id_cabang_gedung');
            $table->foreign('id_cabang_gedung')
                  ->references('id')
                  ->on('cabang_gedung')
                  ->cascadeOnDelete();

            $table->string('keterangan');
            $table->string('idmesin', 20)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesin');
    }
};
