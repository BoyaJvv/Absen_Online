<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pengguna;
use App\Models\CabangGedung;
use App\Models\Cuti;
use App\Models\LiburKhusus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiPenggunaController extends Controller
{
    // Default jam kerja (bisa sesuaikan)
    private $defaultJam = [
        '1' => '08:00:00', // Masuk
        '2' => '12:00:00', // Mulai Istirahat
        '3' => '13:00:00', // Selesai Istirahat
        '4' => '17:00:00', // Pulang
    ];

    public function show($nomor_induk, Request $request)
    {
        // Ambil data pengguna
        $pengguna = Pengguna::where('nomor_induk', $nomor_induk)->firstOrFail();

        // Rentang tanggal default: bulan ini
        $firstDay = $request->get('awal', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $lastDay  = $request->get('akhir', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Ambil data absensi dengan query yang konsisten
        $query = Absensi::with(['mesin', 'pengguna.cabangGedung'])
            ->where('nomor_induk', $nomor_induk)
            ->whereBetween('absen', [$firstDay . ' 00:00:00', $lastDay . ' 23:59:59'])
            ->orderBy('absen', 'asc');

        if ($request->filled('kategori') && $request->kategori != '0') {
            $query->where('kategori', $request->kategori);
        }

        $absensis = $query->get();

        // Proses tiap record dengan metode yang sama
        $absensis = $this->processAbsensiData($absensis, $pengguna);

        // Ambil cabang
        $cabang = CabangGedung::find($pengguna->cabang_gedung);

        // Ambil hari libur
        $hariLibur = $this->getHariLibur($cabang);

        // Ambil cuti
        $cuti = Cuti::where('nomor_induk', $nomor_induk)
            ->whereBetween('tanggal', [$firstDay, $lastDay])
            ->pluck('tanggal')
            ->toArray();

        // Ambil libur khusus
        $liburKhusus = LiburKhusus::whereBetween('tanggal', [$firstDay, $lastDay])
            ->pluck('tanggal')
            ->toArray();

        // Statistik absensi
        $statistics = $this->calculateStatistics($absensis);

        // Tanggal tanpa absen
        $tanpaAbsen = $this->calculateTanpaAbsen(
            $firstDay,
            $lastDay,
            $absensis,
            $hariLibur,
            $cuti,
            $liburKhusus
        );

        return view('absensi.pengguna', compact(
            'pengguna',
            'absensis',
            'firstDay',
            'lastDay',
            'cabang',
            'statistics',
            'tanpaAbsen',
            'cuti',
            'liburKhusus'
        ));
    }

    /**
     * Proses data absensi (metode yang sama dengan AbsensiController)
     */
    private function processAbsensiData($absensis, $pengguna = null)
    {
        foreach ($absensis as $absensi) {
            // Set default values
            $absensi->status = null;
            $absensi->status_label = null;
            $absensi->warna = 'text-gray-700';
            $absensi->display_absen = null;
            $absensi->display_batas = null;
            $absensi->selisih_menit = null;
            $absensi->kategori_label = '-';

            if (empty($absensi->absen)) continue;

            $waktuAbsen = Carbon::parse($absensi->absen);

            // Tentukan kategori label
            $absensi->kategori_label = $this->getKategoriLabel($absensi->kategori);

            // Tentukan target jam
            $tgl = $waktuAbsen->toDateString();
            $jam = $this->defaultJam[(string)$absensi->kategori] ?? null;
            $isTepat = false;
            $target = null;

            if ($jam) {
                $target = Carbon::parse($tgl . ' ' . $jam);
                $isTepat = $this->checkIsTepat($waktuAbsen, $target, $absensi->kategori);
            }

            // Set status
            $absensi->status = $isTepat ? 'tepat_waktu' : 'telat';
            $absensi->status_label = $isTepat ? 'Tepat Waktu' : 'Terlambat';
            $absensi->warna = $isTepat ? 'text-green-600' : 'text-red-600';

            // Ambil timezone cabang
            if ($pengguna) {
                $cabangModel = $pengguna->cabangGedung ?? CabangGedung::find($pengguna->cabang_gedung);
            } else {
                $cabangModel = $absensi->pengguna->cabangGedung ?? CabangGedung::find($absensi->pengguna->cabang_gedung);
            }
            
            $zona = $cabangModel->zona_waktu ?? '1';
            $zonaWaktu = $zona == '1' ? 'WIB' : ($zona == '2' ? 'WITA' : 'WIT');
            $seconds = $zona == '1' ? 25200 : ($zona == '2' ? 28800 : 32400);

            // Format display dengan timezone
            $displayWaktu = $waktuAbsen->copy()->addSeconds($seconds);
            $displayTarget = $target ? $target->copy()->addSeconds($seconds) : null;
            
            $absensi->display_absen = $displayWaktu->format('Y-m-d H:i:s') . ' ' . $zonaWaktu;
            $absensi->display_batas = $displayTarget ? $displayTarget->format('Y-m-d H:i:s') . ' ' . $zonaWaktu : null;
            $absensi->selisih_menit = $target ? round(abs($waktuAbsen->diffInSeconds($target)) / 60) : null;
        }

        return $absensis;
    }

    /**
     * Get kategori label
     */
    private function getKategoriLabel($kategori)
    {
        switch ((string)$kategori) {
            case '1': return 'Masuk';
            case '2': return 'Mulai Istirahat';
            case '3': return 'Selesai Istirahat';
            case '4': return 'Pulang';
            default: return '-';
        }
    }

    /**
     * Check apakah absensi tepat waktu
     */
    private function checkIsTepat($waktuAbsen, $target, $kategori)
    {
        switch ((string)$kategori) {
            case '1': // Masuk
                return $waktuAbsen->between(
                    $target->copy()->subMinutes(15),
                    $target->copy()->addMinutes(15)
                );
            case '2': // Mulai Istirahat
            case '3': // Selesai Istirahat
                return $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
            case '4': // Pulang
                return $waktuAbsen->greaterThanOrEqualTo($target);
            default:
                return false;
        }
    }

    private function getHariLibur($cabang)
    {
        if (!$cabang || empty($cabang->hari_libur)) return [];
        return explode(',', $cabang->hari_libur);
    }

    private function calculateStatistics($absensis)
    {
        $stats = [
            'terlambatMasuk' => 0, 'tepatMasuk' => 0,
            'cepatIstirahatMulai' => 0, 'tepatIstirahatMulai' => 0,
            'cepatIstirahatSelesai' => 0, 'tepatIstirahatSelesai' => 0,
            'cepatPulang' => 0, 'tepatPulang' => 0,
        ];

        foreach ($absensis as $absensi) {
            if (empty($absensi->absen)) continue;

            $waktuAbsen = Carbon::parse($absensi->absen);
            $tgl = $waktuAbsen->toDateString();
            $kategori = (string)$absensi->kategori;
            $jam = $this->defaultJam[$kategori] ?? null;

            if (!$jam) continue;

            $target = Carbon::parse($tgl . ' ' . $jam);

            // Gunakan method checkIsTepat yang sama
            $isTepat = $this->checkIsTepat($waktuAbsen, $target, $kategori);

            switch ($kategori) {
                case '1':
                    $isTepat ? $stats['tepatMasuk']++ : $stats['terlambatMasuk']++;
                    break;
                case '2':
                    $isTepat ? $stats['tepatIstirahatMulai']++ : $stats['cepatIstirahatMulai']++;
                    break;
                case '3':
                    $isTepat ? $stats['tepatIstirahatSelesai']++ : $stats['cepatIstirahatSelesai']++;
                    break;
                case '4':
                    $isTepat ? $stats['tepatPulang']++ : $stats['cepatPulang']++;
                    break;
            }
        }

        return $stats;
    }

    private function calculateTanpaAbsen($firstDay, $lastDay, $absensis, $hariLibur, $cuti, $liburKhusus)
    {
        $start = Carbon::parse($firstDay);
        $end = Carbon::parse($lastDay);

        $tanpaAbsen = ['masuk'=>[], 'mulai'=>[], 'selesai'=>[], 'pulang'=>[]];

        // Tanggal absen per kategori
        $absensiByKategori = ['1'=>[], '2'=>[], '3'=>[], '4'=>[]];
        foreach ($absensis as $abs) {
            if ($abs->absen) $absensiByKategori[$abs->kategori][] = Carbon::parse($abs->absen)->format('Y-m-d');
        }

        $hariLiburInt = array_map('intval', $hariLibur);

        while ($start <= $end) {
            $currentDate = $start->format('Y-m-d');
            $dayOfWeek = $start->dayOfWeek;

            if (!in_array($dayOfWeek, $hariLiburInt)) {
                $isCuti = in_array($currentDate, $cuti);
                $isLiburKhusus = in_array($currentDate, $liburKhusus);

                $keterangan = $isCuti ? 'Cuti' : ($isLiburKhusus ? 'Libur' : 'Tidak Absen');
                $warna = ($isCuti || $isLiburKhusus) ? 'text-green-600' : 'text-red-600';

                foreach (['1'=>'masuk','2'=>'mulai','3'=>'selesai','4'=>'pulang'] as $k=>$label) {
                    if ($keterangan === 'Tidak Absen' && in_array($currentDate, $absensiByKategori[$k])) continue;
                    $tanpaAbsen[$label][] = ['tanggal'=>$currentDate,'keterangan'=>$keterangan,'warna'=>$warna];
                }
            } else {
                // Hari libur
                foreach (['masuk','mulai','selesai','pulang'] as $label) {
                    $tanpaAbsen[$label][] = ['tanggal'=>$currentDate,'keterangan'=>'Libur','warna'=>'text-green-600'];
                }
            }

            $start->addDay();
        }

        return $tanpaAbsen;
    }

    public function rekapSaya(Request $request)
    {
        $user = $request->user();
        return $this->show($user->nomor_induk, $request);
    }
}