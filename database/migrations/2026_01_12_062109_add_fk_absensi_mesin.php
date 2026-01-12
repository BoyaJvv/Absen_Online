<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {

            // pastikan nullable
            $table->string('idmesin')->nullable()->change();

            $table->foreign('idmesin')
                ->references('idmesin')
                ->on('mesin')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['idmesin']);
        });
    }
};
