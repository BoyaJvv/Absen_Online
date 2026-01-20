<?php

namespace App\Http\Controllers;

use App\Models\LiburKhusus;
use Illuminate\Http\Request;

class LiburKhususController extends Controller
{
    public function index(Request $request)
    {
        $awal = $request->tanggal_awal;
        $akhir = $request->tanggal_akhir;
        $keterangan = $request->keterangan;

        $data = LiburKhusus::when($awal && $akhir, function ($q) use ($awal, $akhir) {
            $q->whereBetween('tanggal', [$awal, $akhir])
                ->orderBy('tanggal', 'asc');
        })
            ->when($awal && !$akhir, function ($q) use ($awal) {
                $q->whereDate('tanggal', '>=', $awal)
                    ->orderBy('tanggal', 'asc');
            })
            ->when($akhir && !$awal, function ($q) use ($akhir) {
                $q->whereDate('tanggal', '<=', $akhir)
                    ->orderBy('tanggal', 'asc');
            })
            ->when($keterangan, function ($q) use ($keterangan) {
                $q->where('keterangan', 'like', "%{$keterangan}%");
            }, function ($q) {
                $q->orderBy('tanggal', 'desc');
            })
            ->get();

        return view('libur_khusus.index', compact('data'));
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
