<?php

namespace App\Http\Controllers;

use App\Models\JamPembelajaran;
use Illuminate\Http\Request;

class JamPembelajaranController extends Controller
{
    public function index()
    {
        $data = JamPembelajaran::all();
        return view('jam_pembelajaran.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jam_masuk'   => 'required',
            'jam_pulang'  => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
        ]);

        JamPembelajaran::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        JamPembelajaran::where('id', $id)->update($request->all());
        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        JamPembelajaran::destroy($id);
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
