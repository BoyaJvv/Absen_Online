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

    // 2. HAPUS dulu foreign key yang menghalangi (jadwal_harian)
    // Kita pakai try-catch supaya kalau FK-nya belum ada, migrasi nggak stop
    try {
        Schema::table('jadwal_harian', function (Blueprint $table) {
            $table->dropForeign(['cabang_gedung_id']);
        });
    } catch (\Exception $e) { /* Abaikan jika tidak ada */ }

    // 3. SAMAKAN SEMUA TIPE DATA (PK & FK) pakai Raw SQL agar lebih kuat
    // Tabel Master
    DB::statement("ALTER TABLE cabang_gedung MODIFY id INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE jabatan_status MODIFY id INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE hak_akses MODIFY id INT UNSIGNED NOT NULL");

    // Tabel Transaksi / Referensi
    DB::statement("ALTER TABLE pengguna MODIFY cabang_gedung INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE pengguna MODIFY jabatan_status INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE mesin MODIFY id_cabang_gedung INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE jabatan_status MODIFY hak_akses INT UNSIGNED NOT NULL");
    DB::statement("ALTER TABLE jadwal_harian MODIFY cabang_gedung_id INT UNSIGNED NOT NULL");

    // 4. SAMAKAN COLLATION (Agar tidak error 3780 lagi)
    $tables = ['pengguna', 'cabang_gedung', 'jabatan_status', 'hak_akses', 'jadwal_harian', 'absensi', 'mesin'];
    foreach ($tables as $table) {
        DB::statement("ALTER TABLE $table CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    // 5. PASANG KEMBALI SEMUA RELASI
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

    Schema::table('jadwal_harian', function (Blueprint $table) {
        $table->foreign('cabang_gedung_id')->references('id')->on('cabang_gedung')->onDelete('cascade');
    });

    Schema::enableForeignKeyConstraints();
}
};