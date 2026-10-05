<?php

namespace App\Http\Controllers;

use App\Models\JabatanStatus;
use App\Models\User;
use Illuminate\Http\Request;

class JabatanStatusController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $data = JabatanStatus::where('id', '!=', 1)
            ->when($search, function ($query, $search) {
                $query->where('jabatan_status', 'like', "%{$search}%");
            })
            ->get();

        $hakAksesList = \App\Models\HakAkses::all();

        return view('jabatan.index', compact('data', 'search', 'hakAksesList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan_status' => 'required',
            'hak_akses' => 'required'
        ]);

        JabatanStatus::create([
            'jabatan_status' => $request->jabatan_status,
            'hak_akses' => $request->hak_akses,
            'aktif' => 1
        ]);

        return back()->with('successAdd', "Jabatan '{$request->jabatan_status}' berhasil ditambahkan.");
    }

    public function destroy($id)
{
    $jabatan = JabatanStatus::findOrFail($id);

    // Keamanan: Cek apakah jabatan masih digunakan oleh data pengguna
    // Menggunakan nama kolom 'jabatan_status' sesuai struktur tabel pengguna
    $penggunaTerkait = User::where('jabatan_status', $id)->count();

    if ($penggunaTerkait > 0) {
        return back()->with('error', "Jabatan '{$jabatan->jabatan_status}' tidak dapat dihapus karena masih digunakan oleh {$penggunaTerkait} pengguna.");
    }

    $namaJabatan = $jabatan->jabatan_status;
    $jabatan->delete();

    return back()->with('successDelete', "Jabatan '{$namaJabatan}' berhasil dihapus secara permanen.");
}

    public function edit($id)
    {
        $jabatan = JabatanStatus::findOrFail($id);
        $hakAksesList = \App\Models\HakAkses::all();
        return view('jabatan.edit', compact('jabatan', 'hakAksesList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jabatan_status' => 'required',
            'hak_akses' => 'required'
        ]);

        $jabatan = JabatanStatus::findOrFail($id);
        $jabatan->update([
            'jabatan_status' => $request->jabatan_status,
            'hak_akses' => $request->hak_akses
        ]);

        return redirect()
            ->route('jabatan.index')
            ->with('successEdit', "Jabatan '{$jabatan->jabatan_status}' berhasil diperbarui.");
    }
}