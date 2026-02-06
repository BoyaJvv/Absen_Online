<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('denda_master', function (Blueprint $table) {
            $table->unsignedInteger('id', true);  // INT UNSIGNED
            $table->integer('prioritas')->unique();
            $table->string('jenis', 100)->nullable();
            $table->integer('per_menit')->nullable();
            $table->integer('rupiah_pertama')->nullable();
            $table->integer('rupiah_selanjutnya')->nullable();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denda_master');
    }
};
