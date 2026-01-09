<?php

namespace App\Http\Controllers;

use App\Models\LiburKhusus;
use Illuminate\Http\Request;

class LiburKhususController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $data = LiburKhusus::when($search, function ($q) use ($search) {
            $q->where('tanggal', 'like', "%$search%")
                ->orWhere('keterangan', 'like', "%$search%");
        })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('libur_khusus.index', compact('data', 'search'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        LiburKhusus::create($request->all());

        return redirect()
            ->route('libur_khusus.index')
            ->with('successAdd', $request->keterangan);
    }

    public function edit($id)
    {
        $liburKhusus = LiburKhusus::findOrFail($id);

        return view('libur_khusus.edit', compact('liburKhusus'));
    }

    public function update(Request $request, $id)
    {
        LiburKhusus::where('id', $id)->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('libur_khusus.index')
            ->with('success', 'Data berhasil diubah');
    }


    public function destroy($id)
    {
        LiburKhusus::where('id', $id)->delete();

        return redirect()
            ->route('libur_khusus.index')
            ->with('successDelete', true);
    }
}
