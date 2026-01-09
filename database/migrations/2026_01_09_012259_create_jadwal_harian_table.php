<?php
// database/migrations/xxxx_xx_xx_create_jadwal_harian_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
     Schema::create('jadwal_harian', function (Blueprint $table) {
    $table->id(); // ini int unsigned auto_increment

    $table->integer('cabang_gedung_id'); // ⬅️ JANGAN unsigned
    $table->string('hari');
    $table->time('jam_masuk')->nullable();
    $table->time('jam_pulang')->nullable();
    $table->time('istirahat1_mulai')->nullable();
    $table->time('istirahat1_selesai')->nullable();
    $table->time('istirahat2_mulai')->nullable();
    $table->time('istirahat2_selesai')->nullable();
    $table->enum('keterangan', ['libur', 'berangkat'])->default('berangkat');

    $table->foreign('cabang_gedung_id')
          ->references('id')
          ->on('cabang_gedung')
          ->onDelete('cascade');
});


    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_harian');
    }
};
