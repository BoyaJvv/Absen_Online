<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use App\Models\Absensi;
use Carbon\Carbon;

class ScanController extends Controller
{
    public function index(Request $request)
    {
        // Inisialisasi variabel default (mirip bagian atas kode PHP asli)
        $nama = "";
        $pesan_absen = "";
        $nama_zona = "WIB"; // Sesuaikan zona waktu default
        
        // Cek apakah ada request POST dengan data 'tag'
        if ($request->isMethod('post') && $request->filled('tag')) {
            $tag = $request->input('tag');
            
            // Cari pengguna berdasarkan tag
            $user = Pengguna::where('tag', $tag)->first();

            if ($user) {
                // Set data user
                $nomor_induk = $user->nomor_induk;
                $nama = $user->nama . " (" . $nomor_induk . ")";

                // Waktu sekarang
                $now = Carbon::now();
                $absen = $now->toDateTimeString();
                $absen_maks = $now->copy()->addHours(8)->toDateTimeString();
                $idmesin = 1;

                // Logika kategori jam < 9
                // (Mengambil jam saja)
                $jam_absen = $now->format('H'); 
                if ($jam_absen < 9) {
                    $kategori = 1;
                } else {
                    $kategori = 2;
                }

                // Insert ke database (Pengganti INSERT INTO)
                // Pastikan nama kolom sebelah kiri ('absen_at', dll) sesuai dengan Database Anda
                Absensi::create([
                    'nomor_induk' => $nomor_induk,
                    'absen_at'    => $absen,      // Sesuaikan jika nama kolom di DB adalah 'absen'
                    'jadwal_harian_id' => 1,      // Di SQL dump kolom ini NOT NULL/Foreign, perlu default value jika tidak ada di logika lama
                    'kategori'    => $kategori,
                    'idmesin'     => $idmesin,
                    // 'absen_maks' => $absen_maks // Uncomment jika kolom ini benar-benar ada di tabel database
                ]);

                $pesan_absen = "ABSEN BERHASIL";
            } else {
                $nama = "Tag tidak ditemukan.";
            }
        }

        // Return ke view dengan membawa variabel
        return view('pengguna.scan', compact('nama', 'pesan_absen', 'nama_zona'));
    }
}