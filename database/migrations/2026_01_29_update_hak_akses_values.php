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
        // Update existing hak_akses records to use proper names
        DB::table('hak_akses')->where('id', 1)->update(['hak' => 'nusabot']);
        DB::table('hak_akses')->where('id', 2)->update(['hak' => 'full']);
        
        // Ensure hak_akses table has data if empty
        if (DB::table('hak_akses')->count() == 0) {
            DB::table('hak_akses')->insert([
                ['id' => 1, 'hak' => 'nusabot'],
                ['id' => 2, 'hak' => 'full']
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert hak_akses values if needed
        DB::table('hak_akses')->where('id', 1)->update(['hak' => '0']);
        DB::table('hak_akses')->where('id', 2)->update(['hak' => '1']);
    }
};
