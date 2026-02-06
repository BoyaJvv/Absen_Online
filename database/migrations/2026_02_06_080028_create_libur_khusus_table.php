<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('libur_khusus', function (Blueprint $table) {
            $table->increments('id'); // INT UNSIGNED

            $table->date('tanggal');
            $table->string('keterangan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libur_khusus');
    }
};
