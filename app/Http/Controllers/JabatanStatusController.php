<?php

namespace App\Http\Controllers;

use App\Models\JabatanStatus;
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

        return view('jabatan.index', compact('data', 'search'));
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

        return back()->with('successAdd', $request->jabatan_status);
    }

    public function toggle($id)
    {
        $jabatan = JabatanStatus::findOrFail($id);
        $jabatan->aktif = !$jabatan->aktif;
        $jabatan->save();

        return back()
            ->with('successToggle', $jabatan->jabatan_status)
            ->with('aktifText', $jabatan->aktif ? 'aktif' : 'non-aktif');
    }


    public function edit($id)
    {
        $jabatan = JabatanStatus::findOrFail($id);
        return view('jabatan.edit', compact('jabatan'));
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
            ->with('successEdit', $jabatan->jabatan_status);
    }
}
