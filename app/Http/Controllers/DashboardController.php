<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $month = $request->get('month', Carbon::now()->month);
        $year  = $request->get('year', Carbon::now()->year);

        // ambil hak akses dari tabel jabatan_status
        $hakAkses = DB::table('jabatan_status')
            ->where('id', $user->jabatan_status)
            ->value('hak_akses');

        /**
         * ===============================
         * ADMIN / PIMPINAN
         * hak_akses: 0, 1
         * ===============================
         */
        if (in_array($hakAkses, [0, 1])) {

            $cabangGedungId = $request->get('cabangGedung');

            $cabangGedungList = DB::table('cabang_gedung')->get();

            $lokasiCabang = $cabangGedungId
                ? DB::table('cabang_gedung')
                    ->where('id', $cabangGedungId)
                    ->value('lokasi')
                : 'Semua Cabang';

            $stats = $this->getMonthlyStats(
                $month,
                $year,
                $cabangGedungId,
                null // ❗ tidak filter user
            );
        }
        /**
         * ===============================
         * USER BIASA / GENERAL
         * hak_akses: 2
         * ===============================
         */
        else {

            $cabangGedungId = $user->cabang_gedung;
            $cabangGedungList = []; // dropdown hilang

            $lokasiCabang = DB::table('cabang_gedung')
                ->where('id', $cabangGedungId)
                ->value('lokasi');

            $stats = $this->getMonthlyStats(
                $month,
                $year,
                null, // ❗ cabang tidak dipakai
                $user->nomor_induk // ✅ FILTER USER LOGIN
            );
        }

        return view('dashboard.index', [
            'cabangGedungList' => $cabangGedungList,
            'labels'          => $stats['labels'],
            'tepatWaktu'      => $stats['tepat'],
            'terlambat'       => $stats['telat'],
            'lokasiCabang'    => $lokasiCabang,
            'cabangGedungId'  => $cabangGedungId ?? null,
            'hakAkses'        => $hakAkses
        ]);
    }

    /**
     * =====================================
     * GRAFIK ABSEN MASUK BULANAN
     * kategori = 1
     * =====================================
     */
    private function getMonthlyStats(
        $month,
        $year,
        $cabangGedungId = null,
        $userNomorInduk = null
    ) {
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;

        $labels    = range(1, $daysInMonth);
        $dataTepat = array_fill(0, $daysInMonth, 0);
        $dataTelat = array_fill(0, $daysInMonth, 0);

        $query = Absensi::query()
            ->where('kategori', 1)
            ->whereMonth('absen_at', $month)
            ->whereYear('absen_at', $year)
            ->whereNotNull('absen_at');

        // ✅ FILTER USER LOGIN (PALING PENTING)
        if ($userNomorInduk) {
            $query->where('nomor_induk', $userNomorInduk);
        }

        // ✅ FILTER CABANG (ADMIN)
        if ($cabangGedungId) {
            $query->whereHas('pengguna', function ($q) use ($cabangGedungId) {
                $q->where('cabang_gedung', $cabangGedungId);
            });
        }

        foreach ($query->get() as $row) {

            $waktuAbsen = Carbon::parse($row->absen_at);
            $hariIndex  = (int)$waktuAbsen->format('d') - 1;

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
