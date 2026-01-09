<?php

namespace App\Http\Controllers;

use App\Models\CabangGedung;
use Illuminate\Http\Request;

class CabangGedungController extends Controller
{
    public function index()
    {
        $data = CabangGedung::all();
        return view('cabang_gedung.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi'             => 'required',
            'jam_masuk'          => 'required',
            'jam_pulang'         => 'required',
            'istirahat_mulai'    => 'required',
            'istirahat_selesai'  => 'required',
            'hari_libur'         => 'required',
        ]);

        CabangGedung::create([
            'lokasi'            => $request->lokasi,
            'jam_masuk'         => $request->jam_masuk,
            'jam_pulang'        => $request->jam_pulang,
            'istirahat_mulai'   => $request->istirahat_mulai,
            'istirahat_selesai' => $request->istirahat_selesai,
            'hari_libur'        => $request->hari_libur,
            'zona_waktu'        => 1,
            'aktif'             => 1,
        ]);

        return back()->with('success', 'Data berhasil disimpan');
    }

    public function destroy($id)
    {
        CabangGedung::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
}
