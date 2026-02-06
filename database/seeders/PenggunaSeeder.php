<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengguna')->delete(); // hapus data lama

        DB::table('pengguna')->insert([
            'nomor_induk' => 0,
            'nama' => 'Nusabot User',
            'tag' => 'nusabot',
            'jabatan_status' => 1, // id hak_akses Nusabot
            'cabang_gedung' => 1,
            'password' => Hash::make('password'),
            'aktif' => 1,
        ]);

        DB::table('pengguna')->insert([
            'nomor_induk' => 2,
            'nama' => 'Admin',
            'tag' => 'admin123',
            'jabatan_status' => 2, // id hak_akses full
            'cabang_gedung' => 1,
            'password' => Hash::make('password'),
            'aktif' => 1,
        ]);

        DB::table('pengguna')->insert([
            'nomor_induk' => 3,
            'nama' => 'General User',
            'tag' => 'general',
            'jabatan_status' => 3, // id hak_aksesGeneral
            'cabang_gedung' => 1,
            'password' => Hash::make('password'),
            'aktif' => 1,
        ]);
    }
}
