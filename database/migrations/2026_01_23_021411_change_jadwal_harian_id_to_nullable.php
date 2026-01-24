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
        Schema::table('absensi', function (Blueprint $table) {
            // ubah ke nullable
            $table->unsignedBigInteger('jadwal_harian_id')->nullable()->after('nomor_induk');

            // tambah absen_at 
            $table->timestamp('absen_at')->nullable()->after('jadwal_harian_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
