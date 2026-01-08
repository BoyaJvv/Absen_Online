<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jam_pembelajaran', function (Blueprint $table) {
            $table->time('jam_mulai')->after('jam_masuk');
            $table->time('jam_selesai')->after('jam_mulai');
        });
    }

    public function down(): void
    {
        Schema::table('jam_pembelajaran', function (Blueprint $table) {
            $table->dropColumn(['jam_mulai', 'jam_selesai']);
        });
    }
};
