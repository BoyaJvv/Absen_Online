<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cabang_gedung', function (Blueprint $table) {
            $table->increments('id'); // INT UNSIGNED
            $table->text('lokasi');
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->time('istirahat_mulai');
            $table->time('istirahat_selesai');
            $table->char('hari_libur', 15);
            $table->char('zona_waktu', 1);
            $table->char('aktif', 1)->default('1');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cabang_gedung');
    }
};
