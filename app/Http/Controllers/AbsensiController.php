<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\CabangGedung;
use App\Models\Pengguna;
use App\Models\Mesin;
use App\Models\JadwalHarian;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            'pengguna.cabangGedung',
            'jadwalHarian' // Relasi via jadwal_harian_id
        ]);

        // Filter Tanggal menggunakan kolom absen_at
        if ($request->filled('awal') && $request->filled('akhir')) {
            $query->whereBetween('absen_at', [
                $request->awal . ' 00:00:00',
                $request->akhir . ' 23:59:59'
            ]);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('cabang_gedung')) {
            $query->whereHas('pengguna', function ($q) use ($request) {
                $q->where('cabang_gedung', $request->cabang_gedung);
            });
        }

        $absensis = $query->orderBy('absen_at', 'asc')->get();

        // Add `status` for each absensi based on related jadwal_harian and tolerance rules
            foreach ($absensis as $absensi) {
                $absensi->status = null;
                $absensi->status_label = null;
                $absensi->warna = 'text-gray-700';
                $absensi->display_absen = null;
                $absensi->display_batas = null;
                $absensi->selisih_menit = null;

                if (empty($absensi->absen_at)) continue;

                $waktuAbsen = Carbon::parse($absensi->absen_at);
                $jadwal = $absensi->primaryJadwal;

                // Fallback: if relation not loaded or missing, try by jadwal_harian_id column
                if (!$jadwal && !empty($absensi->jadwal_harian_id)) {
                    $jadwal = JadwalHarian::find($absensi->jadwal_harian_id);
                }

                // Second fallback: find jadwal by cabang + hari name (Indonesian) when jadwal id not valid
                if (!$jadwal && $absensi->pengguna) {
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
                        // resolve cabang id (could be FK integer or relation object `cabangGedung`)
                        $cabangId = null;
                        if (is_numeric($absensi->pengguna->cabang_gedung)) {
                            $cabangId = (int)$absensi->pengguna->cabang_gedung;
                        } elseif (isset($absensi->pengguna->cabangGedung) && isset($absensi->pengguna->cabangGedung->id)) {
                            $cabangId = (int)$absensi->pengguna->cabangGedung->id;
                        }

                        if ($cabangId) {
                            $jadwal = JadwalHarian::where('cabang_gedung_id', $cabangId)
                                ->where('hari', $dayName)
                                ->first();
                        }
                    }
                }

                // if after fallbacks we still don't have a jadwal, skip
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
                    case '2': // Istirahat 1
                        if (!empty($jadwal->istirahat1_mulai)) {
                            $target = Carbon::parse($tgl . ' ' . $jadwal->istirahat1_mulai);
                            $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                        }
                        break;
                    case '3': // Istirahat 2
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
                if (isset($absensi->pengguna->cabangGedung) && $absensi->pengguna->cabangGedung) {
                    $cabangModel = $absensi->pengguna->cabangGedung;
                } elseif (is_numeric($absensi->pengguna->cabang_gedung)) {
                    $cabangModel = CabangGedung::find($absensi->pengguna->cabang_gedung);
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

            $waktuAbsen = Carbon::parse($absensi->absen_at);
            $jadwal = $absensi->primaryJadwal;
            // Fallback: if relation not loaded or missing, try by jadwal_harian_id column
            if (!$jadwal && !empty($absensi->jadwal_harian_id)) {
                $jadwal = JadwalHarian::find($absensi->jadwal_harian_id);
            }

            // Second fallback: find jadwal by cabang + hari name (Indonesian) when jadwal id not valid
            if (!$jadwal && $absensi->pengguna) {
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
                    // resolve cabang id (could be FK integer or relation object `cabangGedung`)
                    $cabangId = null;
                    if (is_numeric($absensi->pengguna->cabang_gedung)) {
                        $cabangId = (int)$absensi->pengguna->cabang_gedung;
                    } elseif (isset($absensi->pengguna->cabangGedung) && isset($absensi->pengguna->cabangGedung->id)) {
                        $cabangId = (int)$absensi->pengguna->cabangGedung->id;
                    }

                    if ($cabangId) {
                        $jadwal = JadwalHarian::where('cabang_gedung_id', $cabangId)
                            ->where('hari', $dayName)
                            ->first();
                    }
                }
            }
            // if after fallbacks we still don't have a jadwal, skip
            if (!$jadwal) {
                continue;
            }

            $tgl = $waktuAbsen->toDateString();
            $isTepat = false;

            switch ((int)$absensi->kategori) {
                case 1: // Masuk
                    if ($jadwal->jam_masuk) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->jam_masuk);
                        $isTepat = $waktuAbsen->between($target->copy()->subMinutes(15), $target->copy()->addMinutes(15));
                    }
                    break;
                case 2: // Istirahat 1
                    if (!empty($jadwal->istirahat1_mulai)) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->istirahat1_mulai);
                        $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                    }
                    break;
                case 3: // Istirahat 2
                    if (!empty($jadwal->istirahat2_mulai)) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->istirahat2_mulai);
                        $isTepat = $waktuAbsen->lessThanOrEqualTo($target->copy()->addMinutes(15));
                    }
                    break;
                case 4: // Pulang
                    if ($jadwal->jam_pulang) {
                        $target = Carbon::parse($tgl . ' ' . $jadwal->jam_pulang);
                        $isTepat = $waktuAbsen->greaterThanOrEqualTo($target);
                    }
                    break;
            }

            $absensi->status = $isTepat ? 'tepat' : 'telat';
        }

        if ($request->wantsJson()) {
            return response()->json($absensis);
        }

        return view('absensi.index', compact('absensis', 'cabangGedungs'));
    }

    /**
     * DETAIL ABSENSI
     */
    public function show($id)
    {
        $absensi = Absensi::with(['mesin', 'pengguna.cabangGedung', 'jadwalHarians', 'jadwalHarian'])->findOrFail($id);
        return response()->json($absensi);
    }

    /**
     * SIMPAN ABSENSI
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_induk'       => 'required|exists:pengguna,nomor_induk',
            'absen_at'          => 'required|datetime',
            'jadwal_harian_id'  => 'required|exists:jadwal_harian,id', // Validasi kolom baru
            'kategori'          => 'required|in:1,2,3,4',
            'idmesin'           => 'nullable',
        ]);

        $absensi = Absensi::create($data);

        // Attach pivot relation if jadwal_harian_id provided
        if (!empty($data['jadwal_harian_id']) && Schema::hasTable('absensi_jadwal_harian')) {
            try {
                $absensi->jadwalHarians()->syncWithoutDetaching([$data['jadwal_harian_id']]);
            } catch (\Exception $e) {
                // ignore pivot attach errors to avoid breaking creation
            }
        }

        return response()->json($absensi->load('jadwalHarians', 'jadwalHarian'), 201);
    }

    /**
     * API DASHBOARD (Statistik JSON)
     */
    public function dashboard(Request $request)
    {
        $today = now()->format('Y-m-d');
        
        $todayStats = Absensi::whereDate('absen_at', $today)
            ->selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->get()
            ->pluck('total', 'kategori');

        $monthStart = now()->startOfMonth()->format('Y-m-d');
        $monthEnd = now()->endOfMonth()->format('Y-m-d');
        
        $monthlyStats = Absensi::whereBetween('absen_at', [$monthStart, $monthEnd])
            ->selectRaw('DATE(absen_at) as tanggal, count(*) as total')
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