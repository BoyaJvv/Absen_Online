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

            // 1️⃣ Simpan cabang
            $cabang = CabangGedung::create([
                'lokasi' => $request->lokasi,
                'zona_waktu' => 1,
                'aktif' => 1,
                'jam_masuk' => '00:00:00',
                'jam_pulang' => '00:00:00',
                'istirahat_mulai' => '00:00:00',
                'istirahat_selesai' => '00:00:00',
                'hari_libur' => '',
            ]);

            // 2️⃣ Simpan jadwal harian
            foreach ($request->jadwal as $hari => $j) {

                $libur = isset($j['libur']);

                JadwalHarian::create([
                    'cabang_gedung_id' => $cabang->id,
                    'hari' => $hari,
                    'jam_masuk' => $libur ? null : ($j['jam_masuk'] ?? null),
                    'jam_pulang' => $libur ? null : ($j['jam_pulang'] ?? null),
                    'istirahat1_mulai' => $libur ? null : ($j['istirahat_mulai'] ?? null),
                    'istirahat1_selesai' => $libur ? null : ($j['istirahat_selesai'] ?? null),
                    'keterangan' => $libur ? 'libur' : 'kerja',
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
        $cabang = CabangGedung::with('jadwalHarian')->findOrFail($id);

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
        $request->validate([
            'lokasi' => 'required|string',
            'jadwal' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $id) {

            $cabang = CabangGedung::findOrFail($id);
            $cabang->update([
                'lokasi' => $request->lokasi,
            ]);

            foreach ($request->jadwal as $hari => $j) {

                $libur = isset($j['libur']);

                JadwalHarian::updateOrCreate(
                    [
                        'cabang_gedung_id' => $id,
                        'hari' => $hari,
                    ],
                    [
                        'jam_masuk' => $libur ? null : ($j['jam_masuk'] ?? null),
                        'jam_pulang' => $libur ? null : ($j['jam_pulang'] ?? null),
                        'istirahat1_mulai' => $libur ? null : ($j['istirahat_mulai'] ?? null),
                        'istirahat1_selesai' => $libur ? null : ($j['istirahat_selesai'] ?? null),
                        'keterangan' => $libur ? 'libur' : 'kerja',
                    ]
                );
            }
        });

        return redirect()
            ->route('cabang-gedung.index')
            ->with('success', 'Cabang & jadwal berhasil diperbarui');
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
