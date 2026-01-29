<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah hak_akses id=3 untuk general
        $exists = DB::table('hak_akses')->where('id', 3)->first();
        
        if (!$exists) {
            DB::table('hak_akses')->insert([
                'id' => 3,
                'hak' => 'general'
            ]);
        } else {
            DB::table('hak_akses')->where('id', 3)->update(['hak' => 'general']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('hak_akses')->where('id', 3)->delete();
    }
};
