<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HakAksesSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama tanpa truncate
        DB::table('hak_akses')->delete();

        $hakAksesList = ['nusabot', 'full', 'general'];

        foreach ($hakAksesList as $hak) {
            DB::table('hak_akses')->insert([
                'hak' => trim($hak),
            ]);
        }

        $this->command->info('Hak Akses berhasil di-seed!');
    }
}
