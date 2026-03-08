<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 



class DendaController extends Controller
{
    public function index()
    {
        $denda = DB::table('denda_master')
            ->orderBy('prioritas', 'asc')
            ->get();

        return view('denda.index', compact('denda'));
    }

    public function edit($id)
    {
        $denda = DB::table('denda_master')
            ->where('id', $id)
            ->first();

        return view('denda.edit', compact('denda'));
    }

    public function update(Request $request, $id)
{
    DB::table('denda_master')->where('id', $id)->update([
        'jenis'              => $request->jenis,
        'per_menit'          => $request->per_menit,
        'rupiah_pertama'     => $request->rupiah_pertama,
        'rupiah_selanjutnya' => $request->rupiah_selanjutnya,
        'prioritas'          => $request->prioritas,
    ]);

    return redirect()
        ->route('denda.index')
        ->with('success', 'Denda berhasil diupdate');
}

public function create()
{
    return view('denda.create');
}

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'prioritas'          => 'required|numeric|unique:denda_master,prioritas',
        'jenis'              => 'required|string|max:100',
        'per_menit'          => 'nullable|numeric',
        'rupiah_pertama'     => 'required|numeric',
        'rupiah_selanjutnya' => 'nullable|numeric',
    ]);

    DB::table('denda_master')->insert([
        'prioritas'          => $request->prioritas,
        'jenis'              => $request->jenis,
        'per_menit'          => $request->per_menit,
        'rupiah_pertama'     => $request->rupiah_pertama,
        'rupiah_selanjutnya' => $request->rupiah_selanjutnya,
    ]);

    

    

    return redirect()
        ->route('denda.index')
        ->with('success', 'Aturan denda baru berhasil ditambahkan');
}

public function destroy($id)
{
    // Menghapus data denda berdasarkan id
    DB::table('denda_master')->where('id', $id)->delete();

    return redirect()
        ->route('denda.index')
        ->with('success', 'Aturan denda berhasil dihapus');
}

}

// controllerDenda