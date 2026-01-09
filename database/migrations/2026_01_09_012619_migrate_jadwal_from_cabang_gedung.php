<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ambil semua cabang gedung
        $cabangs = DB::table('cabang_gedung')->get();

        // hari kerja default
        $hariKerja = ['Senin','Selasa','Rabu','Kamis','Jumat'];

        foreach ($cabangs as $cabang) {

            // hari libur dari cabang (misal: "Sabtu,Minggu")
            $hariLibur = array_map('trim', explode(',', $cabang->hari_libur));

            foreach ($hariKerja as $hari) {

                $isLibur = in_array($hari, $hariLibur);

                DB::table('jadwal_harian')->insert([
                    'cabang_gedung_id'   => $cabang->id,
                    'hari'               => $hari,
                    'jam_masuk'          => $isLibur ? null : $cabang->jam_masuk,
                    'jam_pulang'         => $isLibur ? null : $cabang->jam_pulang,
                    'istirahat1_mulai'   => $isLibur ? null : $cabang->istirahat_mulai,
                    'istirahat1_selesai' => $isLibur ? null : $cabang->istirahat_selesai,
                    'keterangan'         => $isLibur ? 'libur' : 'berangkat',
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('jadwal_harian')->truncate();
    }
};
