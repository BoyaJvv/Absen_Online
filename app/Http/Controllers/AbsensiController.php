<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\CabangGedung;
use App\Models\Pengguna;
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

    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL (TERLAMA → TERBARU)
    |--------------------------------------------------------------------------
    */
    if ($request->filled('awal') && $request->filled('akhir')) {
        $query->whereBetween('absen', [
            $request->awal . ' 00:00:00',
            $request->akhir . ' 23:59:59'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER KATEGORI
    |--------------------------------------------------------------------------
    */
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER CABANG (LEWAT RELASI PENGGUNA)
    |--------------------------------------------------------------------------
    */
    if ($request->filled('cabang_gedung')) {
        $query->whereHas('pengguna', function ($q) use ($request) {
            $q->where('cabang_gedung', $request->cabang_gedung);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | URUTKAN DARI DATA TERLAMA → TERBARU
    |--------------------------------------------------------------------------
    */
    $absensis = $query
        ->orderBy('absen', 'asc')
        ->get();

    // API MODE
    if ($request->wantsJson()) {
        return response()->json($absensis);
    }

    // VIEW MODE
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
    public function byMesin($idMesin = null)
    {
        if ($idMesin) {
            $mesin = Mesin::with('absensi')->where('id_mesin', $idMesin)->first();
        } else {
            $mesin = Mesin::with('absensi')->first();
        }

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
        // Validasi data
        $data = $request->validate([
            'nomor_induk' => 'required|exists:pengguna,nomor_induk',
            'absen'       => 'required|date',
            'absen_maks'  => 'nullable|date',
            'kategori'    => 'required|in:1,2,3,4',
            'idmesin'     => 'nullable',
        ]);

        // Jika absen_maks kosong, set ke tanggal default
        if (empty($data['absen_maks'])) {
            // Cari jadwal pengguna berdasarkan cabang
            $pengguna = Pengguna::where('nomor_induk', $data['nomor_induk'])->first();
            
            if ($pengguna) {
                // Logika untuk menentukan absen_maks berdasarkan kategori
                // Ini bisa disesuaikan dengan kebutuhan bisnis
                $data['absen_maks'] = $data['absen'];
            }
        }

        $absensi = Absensi::create($data);

        return response()->json($absensi, 201);
    }

    /**
     * DATA UNTUK DASHBOARD/STATISTIK
     */
    public function dashboard(Request $request)
    {
        $today = now()->format('Y-m-d');
        
        // Statistik hari ini
        $todayStats = Absensi::whereDate('absen', $today)
            ->selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->get()
            ->pluck('total', 'kategori');

        // Total absensi bulan ini
        $monthStart = now()->startOfMonth()->format('Y-m-d');
        $monthEnd = now()->endOfMonth()->format('Y-m-d');
        
        $monthlyStats = Absensi::whereBetween('absen', [$monthStart, $monthEnd])
            ->selectRaw('DATE(absen) as tanggal, count(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return response()->json([
            'today' => [
                'masuk' => $todayStats[1] ?? 0,
                'istirahat_mulai' => $todayStats[2] ?? 0,
                'istirahat_selesai' => $todayStats[3] ?? 0,
                'pulang' => $todayStats[4] ?? 0,
                'total' => array_sum($todayStats->toArray())
            ],
            'monthly' => $monthlyStats
        ]);
    }
}