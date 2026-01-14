<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesin;
use App\Models\CabangGedung;

class MesinController extends Controller
{
    public function index()
    {
        $mesin = Mesin::with('cabangGedung')->get();
        $cabang = CabangGedung::all();
        $editData = null;

        return view('mesin.index', compact('mesin', 'cabang', 'editData'));
    }

    // 🔥 STORE (INI YANG KURANG)
    public function store(Request $request)
    {
        $request->validate([
            'idmesin' => 'required|numeric',
            'id_cabang_gedung' => 'required|exists:cabang_gedung,id',
            'keterangan' => 'required|string',
        ]);

        Mesin::create([
            'idmesin' => $request->idmesin,
            'id_cabang_gedung' => $request->id_cabang_gedung,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('mesin.index')
            ->with('success', 'Mesin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mesin = Mesin::with('cabangGedung')->get();
        $cabang = CabangGedung::all();
        $editData = Mesin::findOrFail($id);

        return view('mesin.index', compact('mesin', 'cabang', 'editData'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'idmesin' => 'required|numeric',
            'id_cabang_gedung' => 'required|exists:cabang_gedung,id',
            'keterangan' => 'required|string',
        ]);

        $mesin = Mesin::findOrFail($id);
        $mesin->update($request->all());

        return redirect()
            ->route('mesin.index')
            ->with('success', 'Mesin berhasil diupdate');
    }
}
