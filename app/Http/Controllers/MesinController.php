<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use App\Models\CabangGedung;
use Illuminate\Http\Request;

class MesinController extends Controller
{
    public function index()
    {
        $mesin = Mesin::with('cabangGedung')->get();
        $cabang = CabangGedung::all();
        $editData = null;

        return view('mesin.index', compact('mesin', 'cabang', 'editData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idmesin' => 'required|string|max:255|unique:mesin,idmesin',
            'id_cabang_gedung' => 'required|exists:cabang_gedung,id',
            'keterangan' => 'required|string|max:255',
        ]);

        Mesin::create($request->only('idmesin','id_cabang_gedung','keterangan'));

        return redirect()->route('mesin.index')->with('success', 'Data mesin berhasil ditambahkan.');
    }

    public function edit($idmesin)
    {
        $mesin = Mesin::with('cabangGedung')->get();
        $cabang = CabangGedung::all();
        $editData = Mesin::findOrFail($idmesin);

        return view('mesin.index', compact('mesin', 'cabang', 'editData'));
    }

    public function update(Request $request, $idmesin)
    {
        $request->validate([
            'idmesin' => 'required|string|max:255|unique:mesin,idmesin,'.$idmesin.',idmesin',
            'id_cabang_gedung' => 'required|exists:cabang_gedung,id',
            'keterangan' => 'required|string|max:255',
        ]);

        $mesin = Mesin::findOrFail($idmesin);
        $mesin->update($request->only('idmesin','id_cabang_gedung','keterangan'));

        return redirect()->route('mesin.index')->with('success', 'Data mesin berhasil diperbarui.');
    }
}