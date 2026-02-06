<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanStatusSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama tanpa truncate (agar aman dengan foreign key)
        DB::table('jabatan_status')->delete();

        // Data jabatan status
        $jabatanStatuses = [
            [
                'id' => 1,
                'jabatan_status' => 'Nusabot',
                'hak_akses' => 1, // id hak_akses "nusabot"
                'aktif' => 1,
            ],
            [
                'id' => 2,
                'jabatan_status' => 'Full',
                'hak_akses' => 2, // id hak_akses "full"
                'aktif' => 1,
            ],
            [
                'id' => 3,
                'jabatan_status' => 'General',
                'hak_akses' => 3, // id hak_akses "general"
                'aktif' => 1,
            ],
        ];

        foreach ($jabatanStatuses as $status) {
            DB::table('jabatan_status')->insert($status);
        }

        $this->command->info('Jabatan Status berhasil di-seed!');
    }
}
