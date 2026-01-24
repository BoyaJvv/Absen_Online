<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // 🔥 INI YANG KURANG

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

}
