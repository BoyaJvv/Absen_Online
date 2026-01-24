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
  public function up()
{
    Schema::table('jadwal_harian', function (Blueprint $table) {
        // boolean lebih cepet
        $table->boolean('libur')->default(false)->after('hari');
            });

            // libur = 1, berangkat = 0
            // keterangan dipake untuk keterangan hari *libur | blm nullable, editin
            DB::table('jadwal_harian')->where('keterangan', 'libur')->update(['libur' => 1]);
        }

        public function down()
        {
            Schema::table('jadwal_harian', function (Blueprint $table) {
                $table->dropColumn('libur');
            });
        }
};
