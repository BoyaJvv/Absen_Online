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

        // Ambil data absensi
        $query = Absensi::with(['mesin', 'pengguna.cabangGedung'])
            ->where('nomor_induk', $nomor_induk)
            ->whereBetween('absen_at', [$firstDay . ' 00:00:00', $lastDay . ' 23:59:59']);

        if ($request->filled('kategori') && $request->kategori != '0') {
            $query->where('kategori', $request->kategori);
        }

        $absensis = $query->get();

        // Proses tiap record
        foreach ($absensis as $absensi) {
            $absensi->status = null;
            $absensi->status_label = null;
            $absensi->warna = 'text-gray-700';
            $absensi->display_absen = null;
            $absensi->display_batas = null;
            $absensi->selisih_menit = null;
            $absensi->kategori_label = '-';

            if (empty($absensi->absen_at)) continue;

            $waktuAbsen = Carbon::parse($absensi->absen_at);

            // Tentukan kategori label
            switch ((string)$absensi->kategori) {
                case '1': $absensi->kategori_label = 'Masuk'; break;
                case '2': $absensi->kategori_label = 'Mulai Istirahat'; break;
                case '3': $absensi->kategori_label = 'Selesai Istirahat'; break;
                case '4': $absensi->kategori_label = 'Pulang'; break;
            }

            // Tentukan target jam ±15 menit
            $tgl = $waktuAbsen->toDateString();
            $jam = $this->defaultJam[(string)$absensi->kategori] ?? null;
            $isTepat = false;

            if ($jam) {
                $target = Carbon::parse($tgl . ' ' . $jam);

                switch ((string)$absensi->kategori) {
                    case '1': // Masuk
                        $isTepat = $waktuAbsen->between($target->copy()->subMinutes(15), $target->copy()->addMinutes(15));
                        break;
                    case '2': // Mulai Istirahat
                    case '3': // Selesai Istirahat
                        $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                        break;
                    case '4': // Pulang
                        $isTepat = $waktuAbsen->greaterThanOrEqualTo($target);
                        break;
                }
            }

            $absensi->status = $isTepat ? 'tepat' : 'telat';
            $absensi->status_label = $isTepat ? 'Tepat Waktu' : 'Terlambat';
            $absensi->warna = $isTepat ? 'text-green-600' : 'text-red-600';

            // Ambil timezone cabang
            $cabangModel = $pengguna->cabangGedung ?? CabangGedung::find($pengguna->cabang_gedung);
            $zona = $cabangModel->zona_waktu ?? '1';
            $zonaWaktu = $zona == '1' ? 'WIB' : ($zona == '2' ? 'WITA' : 'WIT');
            $seconds = $zona == '1' ? 25200 : ($zona == '2' ? 28800 : 32400);

            $displayWaktu = $waktuAbsen->copy()->addSeconds($seconds);
            $displayTarget = isset($target) ? $target->copy()->addSeconds($seconds) : null;
            $absensi->display_absen = $displayWaktu->format('Y-m-d H:i:s') . ' ' . $zonaWaktu;
            $absensi->display_batas = $displayTarget ? $displayTarget->format('Y-m-d H:i:s') : null;
            $absensi->selisih_menit = isset($target) ? round(abs($waktuAbsen->diffInSeconds($target)) / 60) : null;
        }

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
            if (empty($absensi->absen_at)) continue;

            $waktuAbsen = Carbon::parse($absensi->absen_at);
            $tgl = $waktuAbsen->toDateString();
            $kategori = (string)$absensi->kategori;
            $jam = $this->defaultJam[$kategori] ?? null;

            if (!$jam) continue;

            $target = Carbon::parse($tgl . ' ' . $jam);
            $isTepat = false;

            switch ($kategori) {
                case '1':
                    $isTepat = $waktuAbsen->between($target->copy()->subMinutes(15), $target->copy()->addMinutes(15));
                    $isTepat ? $stats['tepatMasuk']++ : $stats['terlambatMasuk']++;
                    break;
                case '2':
                    $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                    $isTepat ? $stats['tepatIstirahatMulai']++ : $stats['cepatIstirahatMulai']++;
                    break;
                case '3':
                    $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                    $isTepat ? $stats['tepatIstirahatSelesai']++ : $stats['cepatIstirahatSelesai']++;
                    break;
                case '4':
                    $isTepat = $waktuAbsen->greaterThanOrEqualTo($target);
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
            if ($abs->absen_at) $absensiByKategori[$abs->kategori][] = Carbon::parse($abs->absen_at)->format('Y-m-d');
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
