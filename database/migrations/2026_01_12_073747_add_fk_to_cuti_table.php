<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_induk', 30);
            $table->date('tanggal');
            $table->timestamps();
            
            // Foreign key ke tabel pengguna
            $table->foreign('nomor_induk')
                  ->references('nomor_induk')
                  ->on('pengguna')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};