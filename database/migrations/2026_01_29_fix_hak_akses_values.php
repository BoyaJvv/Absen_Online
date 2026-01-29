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
        // Pastikan tabel hak_akses memiliki data yang benar
        // Cek apakah data sudah ada dengan nama yang benar
        
        // Update yang sudah ada jika id 1 dan 2 sudah ada
        $existing1 = DB::table('hak_akses')->where('id', 1)->first();
        $existing2 = DB::table('hak_akses')->where('id', 2)->first();
        
        if ($existing1) {
            DB::table('hak_akses')->where('id', 1)->update(['hak' => 'nusabot']);
        } else {
            DB::table('hak_akses')->insert(['id' => 1, 'hak' => 'nusabot']);
        }
        
        if ($existing2) {
            DB::table('hak_akses')->where('id', 2)->update(['hak' => 'full']);
        } else {
            DB::table('hak_akses')->insert(['id' => 2, 'hak' => 'full']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert jika diperlukan
    }
};
