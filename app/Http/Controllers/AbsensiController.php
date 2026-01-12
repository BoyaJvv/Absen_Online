<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\CabangGedung;
use App\Models\Mesin;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * LIST + FILTER ABSENSI
     */
    public function index(Request $request)
    {
        $cabangGedungs = CabangGedung::where('aktif', 1)->get();

        $query = Absensi::with([
            'mesin',
            'pengguna.cabangGedung'
        ]);

        // 🔹 Filter tanggal
        if ($request->filled('awal') && $request->filled('akhir')) {
            $query->whereBetween('absen', [
                $request->awal,
                $request->akhir
            ]);
        }

        // 🔹 Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // 🔹 Filter cabang lewat pengguna
        if ($request->filled('cabang_gedung')) {
            $query->whereHas('pengguna', function ($q) use ($request) {
                $q->where('cabang_gedung', $request->cabang_gedung);
            });
        }

        $absensis = $query
            ->orderBy('absen', 'asc')
            ->get();

        // 🔥 API MODE
        if ($request->wantsJson()) {
            return response()->json($absensis);
        }

        // 🔥 VIEW MODE
        return view('absensi.index', compact(
            'absensis',
            'cabangGedungs'
        ));
    }

    /**
     * DETAIL ABSENSI
     */
    public function show($id)
    {
        $absensi = Absensi::with([
            'mesin',
            'pengguna.cabangGedung'
        ])->findOrFail($id);

        return response()->json($absensi);
    }

    /**
     * ABSENSI PER MESIN
     */
    public function byMesin()
    {
        $mesin = Mesin::with('absensi')->first();

        return response()->json([
            'mesin' => $mesin,
            'absensi' => $mesin?->absensi ?? []
        ]);
    }

    /**
     * SIMPAN ABSENSI
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_induk' => 'required|exists:pengguna,nomor_induk',
            'absen'       => 'required|date',
            'absen_maks'  => 'nullable|date',
            'kategori'    => 'required|in:1,2,3,4',
            'idmesin'     => 'nullable',
        ]);

        $absensi = Absensi::create($data);

        return response()->json($absensi, 201);
    }
}
