<?php

namespace App\Http\Controllers;

use App\Models\CabangGedung;
use Illuminate\Http\Request;

class CabangGedungController extends Controller
{
    public function index()
    {
        $data = CabangGedung::orderBy('lokasi')->get();
        return view('cabang_gedung.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'istirahat_mulai' => 'required',
            'istirahat_selesai' => 'required',
            'hari_libur' => 'nullable|array',
            'zona_waktu' => 'required',
        ]);

        CabangGedung::create([
            'lokasi' => $request->lokasi,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'istirahat_mulai' => $request->istirahat_mulai,
            'istirahat_selesai' => $request->istirahat_selesai,
            'hari_libur' => $request->hari_libur
                ? implode(',', $request->hari_libur)
                : null,
            'zona_waktu' => $request->zona_waktu,
            'aktif' => 1,
        ]);

        return back()->with('success', 'Cabang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $cabang = CabangGedung::findOrFail($id);
        return view('cabang_gedung.edit', compact('cabang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'istirahat_mulai' => 'required',
            'istirahat_selesai' => 'required',
            'hari_libur' => 'nullable|array',
            'zona_waktu' => 'required',
        ]);

        $cabang = CabangGedung::findOrFail($id);

        $cabang->update([
            'lokasi' => $request->lokasi,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'istirahat_mulai' => $request->istirahat_mulai,
            'istirahat_selesai' => $request->istirahat_selesai,
            'hari_libur' => $request->hari_libur
                ? implode(',', $request->hari_libur)
                : null,
            'zona_waktu' => $request->zona_waktu,
        ]);

        return redirect()->route('cabang-gedung.index')
            ->with('success', 'Cabang berhasil diupdate');
    }

    public function destroy($id)
    {
        $cabang = CabangGedung::findOrFail($id);

        // toggle aktif / nonaktif
        $cabang->aktif = $cabang->aktif == 1 ? 0 : 1;
        $cabang->save();

        return back()->with('success', 'Status cabang diperbarui');
    }
}
