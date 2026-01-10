<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    // ====== INDEX ======
    public function index()
    {
       $pengguna = DB::table('pengguna')
            // Biar yg muncul bukan ID
        ->leftJoin('jabatan_status', 'pengguna.jabatan_status', '=', 'jabatan_status.id')
        ->leftJoin('cabang_gedung', 'pengguna.cabang_gedung', '=', 'cabang_gedung.id')
        ->select(
            'pengguna.*', 
            'jabatan_status.jabatan_status',
            'cabang_gedung.lokasi'
        )
        ->get();

        return view('pengguna.index', compact('pengguna'));
    }

    // ====== CREATE ======
    public function create()
    {
        // ambil data untuk dropdown
        $jabatans = DB::table('jabatan_status')->get();
        $lokasis = DB::table('cabang_gedung')->get();

        return view('pengguna.create', compact('jabatans', 'lokasis'));
    }

    // ====== STORE ======
    public function store(Request $request)
    {
        $request->validate([
            'nomor_induk'    => 'required|unique:pengguna,nomor_induk',
            'nama'           => 'required',
            'jabatan_status' => 'required',
            'cabang_gedung'  => 'required',
            'password'       => 'required|min:8|confirmed',
        ]);

        // ===== PASSWORD MD5 -> Harusnya Bcrypt =====
        // $hashedPassword = Hash::make($request->password);
        $pass = md5($request->nomor_induk);

        // 3. Simpan ke Database
        Pengguna::create([
            'nomor_induk'    => $request->nomor_induk,
            'nama'           => $request->nama,
            'tag'            => $request->tag,
            'jabatan_status' => $request->jabatan_status,
            'cabang_gedung'  => $request->cabang_gedung,
            'password'       => $pass, //$hashedPassword (Bcrypt)
            'aktif'          => 1 // default aktif
        ]);

        return redirect()->route('pengguna.index')->with([
            'successAdd' => 1,
            'nama'       => $request->nama
        ]);
    }

    // ====== EDIT: Menampilkan Form Edit ======
    public function edit($id)
    {
        $user = Pengguna::where('nomor_induk', $id)->firstOrFail();
        $jabatans = DB::table('jabatan_status')->get();
        $lokasis = DB::table('cabang_gedung')->get();

        return view('pengguna.edit', compact('user', 'jabatans', 'lokasis'));
    }

    // ====== UPDATE: Memperbarui Data ======
    public function update(Request $request, $id)
    {
        $user = Pengguna::where('nomor_induk', $id)->firstOrFail();

        $user->update([
            'nomor_induk'    => $request->nomor_induk,
            'nama'           => $request->nama,
            'tag'            => $request->tag,
            'jabatan_status' => $request->jabatan_status,
            // 'password'       => $pass, //kalo mau tambahin 
            'cabang_gedung'  => $request->cabang_gedung,
        ]);

        return redirect()->route('pengguna.index')->with([
            'successEdit' => 1,
            'nama'        => $request->nama
        ]);
    }

    // ====== TOGGLE STATUS: Aktif/Non-Aktif ======
    public function toggleStatus($id)
    {
        $user = Pengguna::where('nomor_induk', $id)->firstOrFail();
        $newStatus = ($user->aktif == 1) ? 0 : 1;
        
        $user->update(['aktif' => $newStatus]);

        return redirect()->back()->with([
            'successDelete' => 1,
            'nama'          => $user->nama,
            'aktifText'     => ($newStatus == 1 ? "aktif" : "non-aktif")
        ]);
    }
}