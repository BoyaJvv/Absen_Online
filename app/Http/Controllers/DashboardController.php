<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // dropdown cabang
        $cabangGedungList = DB::table('pengguna')
            ->join('cabang_gedung', 'pengguna.cabang_gedung', '=', 'cabang_gedung.id')
            ->select('cabang_gedung.id', 'cabang_gedung.lokasi')
            ->distinct()
            ->get();

        $tepatWaktu = array_fill(0, 12, 0);
        $terlambat  = array_fill(0, 12, 0);

        $lokasiCabang = 'Semua Cabang';
        $cabangGedungId = $request->cabangGedung;

        if ($cabangGedungId) {

            $data = DB::table('absensi')
                ->join('pengguna', 'absensi.nomor_induk', '=', 'pengguna.nomor_induk')
                ->selectRaw("
                    MONTH(absensi.absen) as bulan,
                    SUM(CASE WHEN absensi.kategori = 1 THEN 1 ELSE 0 END) as tepat_waktu,
                    SUM(CASE WHEN absensi.kategori = 2 THEN 1 ELSE 0 END) as terlambat
                ")
                ->where('pengguna.cabang_gedung', $cabangGedungId)
                ->groupByRaw('MONTH(absensi.absen)')
                ->get();

            foreach ($data as $row) {
                $index = $row->bulan - 1;
                $tepatWaktu[$index] = $row->tepat_waktu;
                $terlambat[$index]  = $row->terlambat;
            }

            $lokasiCabang = DB::table('cabang_gedung')
                ->where('id', $cabangGedungId)
                ->value('lokasi');
        }

        return view('dashboard.index', compact(
            'cabangGedungList',
            'tepatWaktu',
            'terlambat',
            'lokasiCabang',
            'cabangGedungId'
        ));
    }
}
