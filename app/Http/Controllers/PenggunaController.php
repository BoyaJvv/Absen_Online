<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        // Mengambil semua data untuk tabel dan dropdown
        $pengguna = DB::table('pengguna')->get();
        $jabatans = DB::table('jabatan_status')->get();
        $lokasis = DB::table('cabang_gedung')->get();

        return view('pengguna.index', compact('pengguna', 'jabatans', 'lokasis'));
    }

    public function store(Request $request)
    {
        // Logika tambah data (MD5 digunakan sesuai kodingan lama Anda)
        $pass = md5($request->nomor_induk);

        DB::table('pengguna')->insert([
            'nomor_induk' => $request->nomor_induk,
            'nama' => $request->nama,
            'tag' => $request->tag,
            'jabatan_status' => $request->jabatan_status,
            'cabang_gedung' => $request->cabang_gedung,
            'password' => $pass,
            'aktif' => 1 // Default aktif
        ]);

        return redirect()->back()->with([
            'successAdd' => 1,
            'nama' => $request->nama
        ]);
    }

    public function toggleStatus($id)
    {
        // Logika ganti status aktif/non-aktif
        $user = DB::table('pengguna')->where('nomor_induk', $id)->first();
        
        $newStatus = ($user->aktif == 1) ? 0 : 1;
        $statusText = ($newStatus == 1) ? "aktif" : "non-aktif";

        DB::table('pengguna')->where('nomor_induk', $id)->update(['aktif' => $newStatus]);

        return redirect()->back()->with([
            'successDelete' => 1,
            'nama' => $user->nama,
            'aktifText' => $statusText
        ]);
    }
}