<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year', Carbon::now()->year);
        $cabangGedungId = $request->get('cabangGedung');

        // 🔹 List cabang (dari pengguna)
        $cabangGedungList = DB::table('pengguna')
            ->join('cabang_gedung', 'pengguna.cabang_gedung', '=', 'cabang_gedung.id')
            ->select('cabang_gedung.id', 'cabang_gedung.lokasi')
            ->distinct()
            ->get();

        $lokasiCabang = 'Semua Cabang';
        if ($cabangGedungId) {
            $lokasiCabang = DB::table('cabang_gedung')
                ->where('id', $cabangGedungId)
                ->value('lokasi') ?? 'Semua Cabang';
        }

        $stats = self::getMonthlyStats($month, $year, $cabangGedungId);

        return view('dashboard.index', [
            'cabangGedungList' => $cabangGedungList,
            'labels'          => $stats['labels'],
            'tepatWaktu'      => $stats['tepat'],
            'terlambat'       => $stats['telat'],
            'lokasiCabang'    => $lokasiCabang,
            'cabangGedungId'  => $cabangGedungId,
        ]);
    }

    // 🔹 HANYA ABSEN MASUK (kategori = 1)
   public static function getMonthlyStats($month, $year, $cabangGedungId = null)
{
    $daysInMonth = Carbon::create($year, $month)->daysInMonth;

    $labels = range(1, $daysInMonth);
    $dataTepat = array_fill(0, $daysInMonth, 0);
    $dataTelat = array_fill(0, $daysInMonth, 0);

    $query = Absensi::with('pengguna')
        ->where('kategori', '1') // absen masuk
        ->whereMonth('absen_at', $month)
        ->whereYear('absen_at', $year)
        ->whereNotNull('absen_at');

    if ($cabangGedungId) {
        $query->whereHas('pengguna', function ($q) use ($cabangGedungId) {
            $q->where('cabang_gedung', $cabangGedungId);
        });
    }

    foreach ($query->get() as $row) {
        $waktuAbsen = Carbon::parse($row->absen_at);
        $hariIndex  = (int)$waktuAbsen->format('d') - 1;

        // 🔥 JAM MASUK DEFAULT (Sementara)
        $jamMasuk = Carbon::parse(
            $waktuAbsen->toDateString() . ' 08:00:00'
        );

        if ($waktuAbsen->lte($jamMasuk)) {
            $dataTepat[$hariIndex]++;
        } else {
            $dataTelat[$hariIndex]++;
        }
    }

    return [
        'labels' => $labels,
        'tepat'  => $dataTepat,
        'telat'  => $dataTelat,
    ];
}

    }

