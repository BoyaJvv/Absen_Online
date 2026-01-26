<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Buat Tabel Pivot dengan cara yang lebih robust
        if (!Schema::hasTable('absensi_jadwal_harian')) {
            Schema::create('absensi_jadwal_harian', function (Blueprint $table) {
                // Menggunakan foreignId jauh lebih aman karena otomatis unsignedBigInteger
                $table->foreignId('absensi_id')->constrained('absensi')->onDelete('cascade');
                $table->foreignId('jadwal_harian_id')->constrained('jadwal_harian')->onDelete('cascade');
                
                // Membuat Primary Key gabungan
                $table->primary(['absensi_id', 'jadwal_harian_id']);
            });
        }

        // 2. Pindahkan Data (Data Migration)
        // Kita cek apakah kolom lama 'jadwal_harian_id' masih ada di tabel 'absensi'
        if (Schema::hasColumn('absensi', 'jadwal_harian_id')) {
            $rows = DB::table('absensi')
                ->whereNotNull('jadwal_harian_id')
                ->select('id as absensi_id', 'jadwal_harian_id')
                ->get();

            if ($rows->isNotEmpty()) {
                $insert = $rows->map(function ($r) {
                    return [
                        'absensi_id' => $r->absensi_id,
                        'jadwal_harian_id' => $r->jadwal_harian_id,
                    ];
                })->toArray();

                foreach (array_chunk($insert, 1000) as $chunk) {
                    DB::table('absensi_jadwal_harian')->insertOrIgnore($chunk);
                }
            }
            
            // OPSIONAL: Hapus kolom lama di tabel absensi setelah migrasi data berhasil
            // Schema::table('absensi', function (Blueprint $table) {
            //     $table->dropColumn('jadwal_harian_id');
            // });
        }
    }

    public function down()
    {
        Schema::dropIfExists('absensi_jadwal_harian');
    }
};