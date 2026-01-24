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
    public function show($nomor_induk, Request $request)
    {
        // Validasi pengguna
        $pengguna = Pengguna::where('nomor_induk', $nomor_induk)->firstOrFail();
        
        // Default date range (bulan ini)
        $firstDay = $request->get('awal', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $lastDay = $request->get('akhir', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        // Ambil data absensi
        $query = Absensi::where('nomor_induk', $nomor_induk)
            ->whereBetween('absen', [$firstDay . ' 00:00:00', $lastDay . ' 23:59:59']);
        
        // Filter kategori
        if ($request->filled('kategori') && $request->kategori != '0') {
            $query->where('kategori', $request->kategori);
        }
        
        $absensis = $query->get();
        
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
        
        // Hitung statistik sesuai dengan sistem lama
        $statistics = $this->calculateStatistics($absensis);
        
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
    
    private function calculateStatistics($absensis)
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
            // Hitung selisih seperti sistem lama (dalam menit)
            $selisih = $this->dateDifference($absensi->absen, $absensi->absen_maks);
            
            switch ($absensi->kategori) {
                case '1': // Masuk
                    if ($absensi->absen > $absensi->absen_maks) {
                        $statistics['terlambatMasuk'] += $selisih;
                    } else {
                        $statistics['tepatMasuk'] += $selisih;
                    }
                    break;
                    
                case '2': // Mulai Istirahat
                    if ($absensi->absen > $absensi->absen_maks) {
                        $statistics['tepatIstirahatMulai'] += $selisih;
                    } else {
                        $statistics['cepatIstirahatMulai'] += $selisih;
                    }
                    break;
                    
                case '3': // Selesai Istirahat
                    if ($absensi->absen > $absensi->absen_maks) {
                        $statistics['cepatIstirahatSelesai'] += $selisih;
                    } else {
                        $statistics['tepatIstirahatSelesai'] += $selisih;
                    }
                    break;
                    
                case '4': // Pulang
                    if ($absensi->absen > $absensi->absen_maks) {
                        $statistics['tepatPulang'] += $selisih;
                    } else {
                        $statistics['cepatPulang'] += $selisih;
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
            $tanggal = Carbon::parse($absensi->absen)->format('Y-m-d');
            $absensiByKategori[$absensi->kategori][] = $tanggal;
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
}