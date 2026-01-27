<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pengguna;
use App\Models\CabangGedung;
use App\Models\Cuti;
use App\Models\LiburKhusus;
use App\Models\JadwalHarian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiPenggunaController extends Controller
{
    public function show($nomor_induk, Request $request)
    {
        // Validasi pengguna
        $pengguna = Pengguna::where('nomor_induk', $nomor_induk)->firstOrFail();

        // Default date range (bulan ini)
        $firstDay = $request->get('awal', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $lastDay = $request->get('akhir', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Ambil data absensi (eager load jadwal, pivot jadwal, pengguna, mesin, dan cabang)
        $query = Absensi::with(['mesin', 'pengguna.cabangGedung', 'jadwalHarians', 'jadwalHarian'])
            ->where('nomor_induk', $nomor_induk)
            ->whereBetween('absen_at', [$firstDay . ' 00:00:00', $lastDay . ' 23:59:59']);

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori != '0') {
            $query->where('kategori', $request->kategori);
        }

        $absensis = $query->get();

        // Per-record display fields: formatted absen_at, batas (target), selisih menit, status, warna, kategori
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
            $jadwal = $absensi->primaryJadwal;

            // Fallback: if relation not loaded or missing, try by jadwal_harian_id column
            if (!$jadwal && !empty($absensi->jadwal_harian_id)) {
                $jadwal = JadwalHarian::find($absensi->jadwal_harian_id);
            }

            // Second fallback: find jadwal by cabang + hari name (Indonesian) when jadwal id not valid
            if (!$jadwal && $pengguna) {
                $dayIndex = Carbon::parse($absensi->absen_at)->dayOfWeek; // 0..6 (Sun..Sat)
                $dayNames = [
                    0 => 'Minggu',
                    1 => 'Senin',
                    2 => 'Selasa',
                    3 => 'Rabu',
                    4 => 'Kamis',
                    5 => 'Jumat',
                    6 => 'Sabtu',
                ];
                $dayName = $dayNames[$dayIndex] ?? null;
                if ($dayName) {
                    $cabangId = null;
                    if (is_numeric($pengguna->cabang_gedung)) {
                        $cabangId = (int)$pengguna->cabang_gedung;
                    } elseif (isset($pengguna->cabangGedung) && isset($pengguna->cabangGedung->id)) {
                        $cabangId = (int)$pengguna->cabangGedung->id;
                    }

                    if ($cabangId) {
                        $jadwal = JadwalHarian::where('cabang_gedung_id', $cabangId)
                            ->where('hari', $dayName)
                            ->first();
                    }
                }
            }

            // Tentukan kategori label
            switch ((string)$absensi->kategori) {
                case '1':
                    $absensi->kategori_label = 'Masuk';
                    break;
                case '2':
                    $absensi->kategori_label = 'Mulai Istirahat';
                    break;
                case '3':
                    $absensi->kategori_label = 'Selesai Istirahat';
                    break;
                case '4':
                    $absensi->kategori_label = 'Pulang';
                    break;
            }

            if (!$jadwal) {
                continue;
            }

            $tgl = $waktuAbsen->toDateString();
            $isTepat = false;

            switch ((string)$absensi->kategori) {
                case '1': // Masuk
                    if ($jadwal->jam_masuk) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->jam_masuk);
                        $isTepat = $waktuAbsen->between($target->copy()->subMinutes(15), $target->copy()->addMinutes(15));
                    }
                    break;
                case '2': // Mulai Istirahat
                    if (!empty($jadwal->istirahat1_mulai)) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->istirahat1_mulai);
                        $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                    }
                    break;
                case '3': // Selesai Istirahat
                    if (!empty($jadwal->istirahat2_mulai)) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->istirahat2_mulai);
                        $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                    }
                    break;
                case '4': // Pulang
                    if ($jadwal->jam_pulang) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->jam_pulang);
                        $isTepat = $waktuAbsen->greaterThanOrEqualTo($target);
                    }
                    break;
            }

            $absensi->status = $isTepat ? 'tepat' : 'telat';
            $absensi->status_label = $isTepat ? 'Tepat Waktu' : 'Terlambat';
            $absensi->warna = $isTepat ? 'text-green-600' : 'text-red-600';

            // timezone dari cabang pengguna
            $cabangModel = null;
            if (isset($pengguna->cabangGedung) && $pengguna->cabangGedung) {
                $cabangModel = $pengguna->cabangGedung;
            } elseif (is_numeric($pengguna->cabang_gedung)) {
                $cabangModel = CabangGedung::find($pengguna->cabang_gedung);
            }

            $zona = $cabangModel->zona_waktu ?? '1';
            $zonaWaktu = $zona == '1' ? 'WIB' : ($zona == '2' ? 'WITA' : 'WIT');
            $seconds = $zona == '1' ? 25200 : ($zona == '2' ? 28800 : 32400);

            // formatted display times accounting for zona
            $displayWaktu = $waktuAbsen->copy()->addSeconds($seconds);
            $displayTarget = isset($target) ? $target->copy()->addSeconds($seconds) : null;
            $absensi->display_absen = $displayWaktu->format('Y-m-d H:i:s') . ' ' . $zonaWaktu;
            $absensi->display_batas = $displayTarget ? $displayTarget->format('Y-m-d H:i:s') : null;
            $absensi->selisih_menit = isset($target) ? round(abs($waktuAbsen->diffInSeconds($target)) / 60) : null;
        }

        // Ambil data cabang
        $cabang = CabangGedung::find($pengguna->cabang_gedung);

        // Ambil hari libur
        $hariLibur = $this->getHariLibur($cabang);

        // Ambil data cuti
        $cuti = Cuti::where('nomor_induk', $nomor_induk)
            ->whereBetween('tanggal', [$firstDay, $lastDay])
            ->pluck('tanggal')
            ->toArray();

        // Ambil libur khusus
        $liburKhusus = LiburKhusus::whereBetween('tanggal', [$firstDay, $lastDay])
            ->pluck('tanggal')
            ->toArray();

        // Hitung statistik menggunakan `absen_at` dan aturan ±15 menit
        $statistics = $this->calculateStatistics($absensis, $pengguna);

        // Hitung tanggal tanpa absen
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
        if (!$cabang || empty($cabang->hari_libur)) {
            return [];
        }

        return explode(',', $cabang->hari_libur);
    }

    private function calculateStatistics($absensis, $pengguna = null)
    {
        $statistics = [
            'terlambatMasuk' => 0,
            'tepatMasuk' => 0,
            'cepatIstirahatMulai' => 0,
            'tepatIstirahatMulai' => 0,
            'cepatIstirahatSelesai' => 0,
            'tepatIstirahatSelesai' => 0,
            'cepatPulang' => 0,
            'tepatPulang' => 0,
        ];

        foreach ($absensis as $absensi) {
            if (empty($absensi->absen_at)) continue;

            $waktuAbsen = Carbon::parse($absensi->absen_at);
            $tgl = $waktuAbsen->toDateString();

            // Prefer relasi jadwal_harian pada record (many-to-many primary); jika tidak ada, coba cari berdasarkan cabang + hari
            $jadwal = $absensi->primaryJadwal;
            if (!$jadwal && $pengguna) {
                $day = $waktuAbsen->dayOfWeek; // 0 (Sun) .. 6 (Sat)
                $jadwal = JadwalHarian::where('cabang_gedung_id', $pengguna->cabang_gedung)
                    ->where(function ($q) use ($day, $waktuAbsen) {
                        $q->where('hari', $day)
                            ->orWhere('hari', $waktuAbsen->format('N'));
                    })->first();
            }

            if (!$jadwal) continue;

            switch ((string)$absensi->kategori) {
                case '1': // Masuk
                    if ($jadwal->jam_masuk) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->jam_masuk);
                        $isTepat = $waktuAbsen->between($target->copy()->subMinutes(15), $target->copy()->addMinutes(15));
                        if ($isTepat) $statistics['tepatMasuk']++;
                        else $statistics['terlambatMasuk']++;
                    }
                    break;
                case '2': // Mulai Istirahat
                    if (!empty($jadwal->istirahat1_mulai)) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->istirahat1_mulai);
                        $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                        if ($isTepat) $statistics['tepatIstirahatMulai']++;
                        else $statistics['cepatIstirahatMulai']++;
                    }
                    break;
                case '3': // Selesai Istirahat
                    if (!empty($jadwal->istirahat2_mulai)) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->istirahat2_mulai);
                        $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                        if ($isTepat) $statistics['tepatIstirahatSelesai']++;
                        else $statistics['cepatIstirahatSelesai']++;
                    }
                    break;
                case '4': // Pulang
                    if ($jadwal->jam_pulang) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->jam_pulang);
                        $isTepat = $waktuAbsen->greaterThanOrEqualTo($target);
                        if ($isTepat) $statistics['tepatPulang']++;
                        else $statistics['cepatPulang']++;
                    }
                    break;
            }
        }

        return $statistics;
    }

    // Fungsi untuk menghitung selisih seperti sistem lama
    private function dateDifference($date1, $date2)
    {
        $datetime1 = strtotime($date1);
        $datetime2 = strtotime($date2);

        $interval = abs($datetime1 - $datetime2);
        $minutes = round($interval / 60);

        return $minutes;
    }

    private function calculateTanpaAbsen($firstDay, $lastDay, $absensis, $hariLibur, $cuti, $liburKhusus)
    {
        $start = Carbon::parse($firstDay);
        $end = Carbon::parse($lastDay);

        $tanpaAbsenMasuk = [];
        $tanpaAbsenMulai = [];
        $tanpaAbsenSelesai = [];
        $tanpaAbsenPulang = [];

        // Ambil tanggal yang sudah absen berdasarkan kategori
        $absensiByKategori = [
            '1' => [],
            '2' => [],
            '3' => [],
            '4' => [],
        ];

        foreach ($absensis as $absensi) {
            $tanggal = $absensi->absen_at ? Carbon::parse($absensi->absen_at)->format('Y-m-d') : null;
            if ($tanggal) $absensiByKategori[$absensi->kategori][] = $tanggal;
        }

        // Konversi hari libur string ke integer
        $hariLiburInt = array_map('intval', $hariLibur);

        // Generate tanggal range
        while ($start <= $end) {
            $currentDate = $start->format('Y-m-d');
            $dayOfWeek = $start->dayOfWeek; // 0 (Minggu) sampai 6 (Sabtu)

            // Cek apakah hari kerja (bukan hari libur)
            if (!in_array($dayOfWeek, $hariLiburInt)) {
                // Cek apakah ada di cuti
                $isCuti = in_array($currentDate, $cuti);
                // Cek apakah ada di libur khusus
                $isLiburKhusus = in_array($currentDate, $liburKhusus);

                if (!$isCuti && !$isLiburKhusus) {
                    // Masuk
                    if (!in_array($currentDate, $absensiByKategori['1'])) {
                        $tanpaAbsenMasuk[] = [
                            'tanggal' => $currentDate,
                            'keterangan' => 'Tidak Absen',
                            'warna' => 'text-red-600'
                        ];
                    }

                    // Mulai Istirahat
                    if (!in_array($currentDate, $absensiByKategori['2'])) {
                        $tanpaAbsenMulai[] = [
                            'tanggal' => $currentDate,
                            'keterangan' => 'Tidak Absen',
                            'warna' => 'text-red-600'
                        ];
                    }

                    // Selesai Istirahat
                    if (!in_array($currentDate, $absensiByKategori['3'])) {
                        $tanpaAbsenSelesai[] = [
                            'tanggal' => $currentDate,
                            'keterangan' => 'Tidak Absen',
                            'warna' => 'text-red-600'
                        ];
                    }

                    // Pulang
                    if (!in_array($currentDate, $absensiByKategori['4'])) {
                        $tanpaAbsenPulang[] = [
                            'tanggal' => $currentDate,
                            'keterangan' => 'Tidak Absen',
                            'warna' => 'text-red-600'
                        ];
                    }
                } else {
                    // Tanggal cuti atau libur khusus
                    $keterangan = $isCuti ? 'Cuti' : 'Libur';
                    $warna = 'text-green-600';

                    $tanpaAbsenMasuk[] = ['tanggal' => $currentDate, 'keterangan' => $keterangan, 'warna' => $warna];
                    $tanpaAbsenMulai[] = ['tanggal' => $currentDate, 'keterangan' => $keterangan, 'warna' => $warna];
                    $tanpaAbsenSelesai[] = ['tanggal' => $currentDate, 'keterangan' => $keterangan, 'warna' => $warna];
                    $tanpaAbsenPulang[] = ['tanggal' => $currentDate, 'keterangan' => $keterangan, 'warna' => $warna];
                }
            } else {
                // Hari libur
                $tanpaAbsenMasuk[] = ['tanggal' => $currentDate, 'keterangan' => 'Libur', 'warna' => 'text-green-600'];
                $tanpaAbsenMulai[] = ['tanggal' => $currentDate, 'keterangan' => 'Libur', 'warna' => 'text-green-600'];
                $tanpaAbsenSelesai[] = ['tanggal' => $currentDate, 'keterangan' => 'Libur', 'warna' => 'text-green-600'];
                $tanpaAbsenPulang[] = ['tanggal' => $currentDate, 'keterangan' => 'Libur', 'warna' => 'text-green-600'];
            }

            $start->addDay();
        }

        return [
            'masuk' => $tanpaAbsenMasuk,
            'mulai' => $tanpaAbsenMulai,
            'selesai' => $tanpaAbsenSelesai,
            'pulang' => $tanpaAbsenPulang
        ];
    }

    public function rekapSaya(Request $request)
    {
        $user = $request->user();

        return $this->show($user->nomor_induk, $request);
    }
}
