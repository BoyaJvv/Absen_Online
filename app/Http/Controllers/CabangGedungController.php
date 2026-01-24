<?php

namespace App\Http\Controllers;

use App\Models\CabangGedung;
use App\Models\JadwalHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangGedungController extends Controller
{
    /**
     * =========================
     * INDEX
     * =========================
     */
    public function index()
    {
        $data = CabangGedung::with([
            'jadwalHarian' => function ($q) {
                $q->orderByRaw("FIELD(hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')");
            }
        ])->get();

        return view('cabang_gedung.index', compact('data'));
    }

    /**
     * =========================
     * STORE (ADD CABANG + JADWAL)
     * =========================
     */
    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string',
            'jadwal' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            // Simpan cabang
            $cabang = CabangGedung::create([
                'lokasi' => $request->lokasi,
                'zona_waktu' => 1,
                'aktif' => 1,
            ]);

            // Simpan jadwal harian
            foreach ($request->jadwal as $hari => $j) {

                $libur = isset($j['libur']);

                JadwalHarian::create([
                    'cabang_gedung_id' => $cabang->id,
                    'hari' => $hari,
                    'jam_masuk' => $libur ? null : ($j['jam_masuk'] ?? null),
                    'jam_pulang' => $libur ? null : ($j['jam_pulang'] ?? null),
                    'istirahat1_mulai' => $libur ? null : ($j['istirahat1_mulai'] ?? null),
                    'istirahat1_selesai' => $libur ? null : ($j['istirahat1_selesai'] ?? null),
                    'istirahat2_mulai' => $libur ? null : ($j['istirahat2_mulai'] ?? null),
                    'istirahat2_selesai' => $libur ? null : ($j['istirahat2_selesai'] ?? null),
                    'keterangan' => $libur ? 'libur' : 'kerja',
                    'libur' => $libur,
                ]);
            }
        });

        return back()->with('success', 'Cabang & jadwal berhasil disimpan');
    }

    /**
     * =========================
     * EDIT PAGE
     * =========================
     */
    public function edit($id)
    {
        $cabang = CabangGedung::with('JadwalHarian')->findOrFail($id);

        // biar gampang dipakai di blade
        $jadwal = $cabang->jadwalHarian->keyBy('hari');

        return view('cabang_gedung.edit', compact('cabang', 'jadwal'));
    }

    /**
     * =========================
     * UPDATE CABANG + JADWAL
     * =========================
     */
    public function update(Request $request, $id)
    {
        $cabang = CabangGedung::findOrFail($id); // Memanggil data
        $daftar_hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; // Mention 7 hari

        foreach ($daftar_hari as $hari) {
            // Ambil data input berdasarkan hari
            $inputHari = $request->input("jadwal.$hari");

            $cabang->jadwalHarian()->updateOrCreate(
                ['hari' => $hari], // Kunci pencarian
                [
                    'libur'      => isset($inputHari['libur']),
                    'jam_masuk'  => isset($inputHari['libur']) ? null : $inputHari['jam_masuk'],
                    'jam_pulang' => isset($inputHari['libur']) ? null : $inputHari['jam_pulang'],
                    'istirahat1_mulai' => isset($inputHari['libur']) ? null : $inputHari['istirahat1_mulai'],
                    'istirahat1_selesai' => isset($inputHari['libur']) ? null : $inputHari['istirahat1_selesai'],
                    'istirahat2_mulai' => isset($inputHari['libur']) ? null : $inputHari['istirahat2_mulai'],
                    'istirahat2_selesai' => isset($inputHari['libur']) ? null : $inputHari['istirahat2_selesai'],
                    'keterangan' => isset($inputHari['libur']) ? null : 'kerja', 
                ]
            );
        }

        return redirect()->back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * =========================
     * DELETE
     * =========================
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            JadwalHarian::where('cabang_gedung_id', $id)->delete();
            CabangGedung::where('id', $id)->delete();
        });

        return back()->with('success', 'Cabang berhasil dihapus');
    }
}
