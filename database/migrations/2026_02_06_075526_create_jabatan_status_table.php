<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jabatan_status', function (Blueprint $table) {
            $table->increments('id'); // INT UNSIGNED

            $table->string('jabatan_status', 255);

            // Foreign key INT UNSIGNED
            $table->unsignedInteger('hak_akses')->nullable();
            $table->foreign('hak_akses')
                  ->references('id')
                  ->on('hak_akses')
                  ->cascadeOnDelete();

            $table->char('aktif', 1)->default('1');           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan_status');
    }
};
