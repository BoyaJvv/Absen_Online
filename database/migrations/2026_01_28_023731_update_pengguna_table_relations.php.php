<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
   public function up()
{
    // 1. Matikan pengecekan foreign key
    Schema::disableForeignKeyConstraints();

   Schema::dropIfExists('absensi_jadwal_harian');
    Schema::dropIfExists('jadwal_harian');

    // 3. HAPUS KOLOM jadwal_harian_id DI TABEL absensi
    // Kita langsung hapus kolomnya saja, MySQL akan otomatis melepas constraint jika ada
    if (Schema::hasColumn('absensi', 'jadwal_harian_id')) {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn('jadwal_harian_id');
        });
    }

    // 2. HAPUS semua foreign key yang mungkin sudah ada agar tidak duplikat
    $tablesToClean = [
        'pengguna' => ['cabang_gedung', 'jabatan_status'],
        'absensi' => ['nomor_induk'],
        'mesin' => ['id_cabang_gedung'],
        'jabatan_status' => ['hak_akses'],
   
        'cuti' => ['nomor_induk'],
    ];

    foreach ($tablesToClean as $tableName => $foreignKeys) {
        foreach ($foreignKeys as $key) {
            try {
                Schema::table($tableName, function (Blueprint $table) use ($key) {
                    $table->dropForeign([$key]);
                });
            } catch (\Exception $e) {
                // Abaikan jika foreign key memang tidak ada
            }
        }
    }

    // 3. SAMAKAN SEMUA TIPE DATA (PK & FK)
    DB::statement("ALTER TABLE cabang_gedung MODIFY id INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE jabatan_status MODIFY id INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE hak_akses MODIFY id INT UNSIGNED NOT NULL");

    DB::statement("ALTER TABLE pengguna MODIFY cabang_gedung INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE pengguna MODIFY jabatan_status INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE mesin MODIFY id_cabang_gedung INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE jabatan_status MODIFY hak_akses INT UNSIGNED NOT NULL");


    DB::statement("ALTER TABLE cuti CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");


// Menghapus data cuti yang nomor_induknya tidak ada di tabel pengguna
DB::statement("DELETE FROM cuti WHERE nomor_induk NOT IN (SELECT nomor_induk FROM pengguna)");
    // 4. SAMAKAN COLLATION
    $tables = ['pengguna', 'cabang_gedung', 'jabatan_status', 'hak_akses',  'absensi', 'mesin', 'cuti'];
    foreach ($tables as $table) {
        DB::statement("ALTER TABLE $table CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    // 5. PASANG KEMBALI SEMUA RELASI (Sekarang aman dari error duplicate)
    Schema::table('pengguna', function (Blueprint $table) {
        $table->foreign('cabang_gedung')->references('id')->on('cabang_gedung')->onDelete('cascade');
        $table->foreign('jabatan_status')->references('id')->on('jabatan_status')->onDelete('cascade');
    });

    Schema::table('absensi', function (Blueprint $table) {
        $table->foreign('nomor_induk')->references('nomor_induk')->on('pengguna')->onUpdate('cascade')->onDelete('cascade');
    });

    Schema::table('mesin', function (Blueprint $table) {
        $table->foreign('id_cabang_gedung')->references('id')->on('cabang_gedung')->onDelete('cascade');
    });

    Schema::table('jabatan_status', function (Blueprint $table) {
        $table->foreign('hak_akses')->references('id')->on('hak_akses')->onDelete('cascade');
    });


   Schema::table('cuti', function (Blueprint $table) {
    try {
        $table->foreign('nomor_induk')
              ->references('nomor_induk')
              ->on('pengguna')
              ->onUpdate('cascade')
              ->onDelete('cascade');
    } catch (\Exception $e) {
        // Jika gagal, log errornya agar bisa kita cek
        Log::error("Gagal buat FK Cuti: " . $e->getMessage());
    }
});
    Schema::enableForeignKeyConstraints();
}
};