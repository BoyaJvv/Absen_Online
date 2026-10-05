<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HakAksesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hak_akses')->delete();

        $hakAksesList = [
            1 => 'nusabot',
            2 => 'full',
            3 => 'general',
        ];

        foreach ($hakAksesList as $id => $hak) {
            DB::table('hak_akses')->insert([
                'id' => $id,
                'hak' => $hak,
            ]);
        }

        $this->command->info('Hak Akses berhasil di-seed!');
    }
}
