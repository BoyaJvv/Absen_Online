<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CabangGedungSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cabang_gedung')->insert([
            [
                'id' => 1,
                'lokasi' => 'Cirebon',
                'jam_masuk' => '07:30:00',
                'jam_pulang' => '16:30:00',
                'istirahat_mulai' => '11:30:00',
                'istirahat_selesai' => '12:30:00',
                'hari_libur' => '0,6',
                'zona_waktu' => '1',
                'aktif' => '1'
            ]
        ]);
    }
}
