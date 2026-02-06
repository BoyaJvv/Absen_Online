<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->increments('id'); // INT UNSIGNED 

            $table->char('nomor_induk', 30);
            $table->date('tanggal');
    
            // Foreign key string
            $table->foreign('nomor_induk')
                  ->references('nomor_induk')
                  ->on('pengguna')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
