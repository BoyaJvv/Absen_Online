<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\CabangGedung;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        $nomorInduk = $request->get('nomor_induk', null);
        $cabangGedungId = $request->get('cabangGedung', null);

        $cabangGedungList = DB::table('pengguna')
            ->join('cabang_gedung', 'pengguna.cabang_gedung', '=', 'cabang_gedung.id')
            ->select('cabang_gedung.id', 'cabang_gedung.lokasi')
            ->distinct()
            ->get();

        $lokasiCabang = 'Semua Cabang';
        if ($cabangGedungId) {
            $lokasiCabang = DB::table('cabang_gedung')->where('id', $cabangGedungId)->value('lokasi') ?? 'Semua Cabang';
        }

        $stats = self::getMonthlyStats($month, $year, $nomorInduk, $cabangGedungId);
        $labels = $stats['labels'];
        $tepatWaktu = $stats['tepat'];
        $terlambat = $stats['telat'];

        return view('dashboard.index', compact(
            'cabangGedungList',
            'labels',
            'tepatWaktu',
            'terlambat',
            'lokasiCabang',
            'cabangGedungId'
        ));
    }

    public static function getMonthlyStats($month, $year, $nomorInduk = null, $cabangGedungId = null)
    {
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $labels = range(1, $daysInMonth);
        $dataTepat = array_fill(1, $daysInMonth, 0);
        $dataTelat = array_fill(1, $daysInMonth, 0);

        $query = Absensi::with('jadwalHarian')
            ->whereMonth('absen_at', $month)
            ->whereYear('absen_at', $year)
            ->where('kategori', 1);

        if ($cabangGedungId) {
            $query->whereHas('pengguna', function ($q) use ($cabangGedungId) {
                $q->where('cabang_gedung', $cabangGedungId);
            });
        }

        if ($nomorInduk) {
            $query->where('nomor_induk', $nomorInduk);
        }

        foreach ($query->get() as $row) {
            if (!$row->jadwalHarian) continue;

            $waktuAbsen = Carbon::parse($row->absen_at);
            $hari = (int)$waktuAbsen->format('d');
            $jadwal = $row->jadwalHarian;
            $tgl = $waktuAbsen->toDateString();

            $target = Carbon::parse($tgl . ' ' . $jadwal->jam_masuk);
            $isTepat = $waktuAbsen->between($target->copy()->subMinutes(15), $target->copy()->addMinutes(15));

            if ($isTepat) {
                $dataTepat[$hari]++;
            } else {
                $dataTelat[$hari]++;
            }
        }

        return [
            'labels' => $labels,
            'tepat'  => array_values($dataTepat),
            'telat'  => array_values($dataTelat)
        ];
    }

}
