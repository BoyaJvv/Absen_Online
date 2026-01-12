<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query cuti dengan pagination
        $query = Cuti::with('pengguna')
            ->orderBy('tanggal', 'desc');

        // Filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Filter berdasarkan nomor induk
        if ($request->has('nomor_induk')) {
            $query->where('nomor_induk', $request->nomor_induk);
        }

        $cuti = $query->paginate(20);
        
        // Ambil semua pengguna aktif untuk dropdown
        $penggunaList = Pengguna::where('aktif', '1')
            ->orderBy('nama')
            ->get();
        
        return view('cuti.index', compact('cuti', 'penggunaList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengguna = Pengguna::where('aktif', '1')
            ->orderBy('nama')
            ->get();
        return view('cuti.create', compact('pengguna'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Lihat data yang dikirim
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'nomor_induk' => 'required',
           'tanggal' => 'required|date|after_or_equal:today'

        ], [
            'nomor_induk.required' => 'Nomor induk wajib diisi.',
            'nomor_induk.exists' => 'Nomor induk tidak ditemukan dalam sistem.',
            'tanggal.required' => 'Tanggal cuti wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'tanggal.after_or_equal' => 'Tanggal cuti tidak boleh kurang dari hari ini.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Silakan periksa data yang dimasukkan.');
        }

        // Cek duplikasi cuti pada tanggal yang sama
        $existingCuti = Cuti::where('nomor_induk', $request->nomor_induk)
            ->where('tanggal', $request->tanggal)
            ->first();

        if ($existingCuti) {
            return redirect()->back()
                ->with('error', 'Karyawan sudah memiliki cuti pada tanggal tersebut.')
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            $cuti = Cuti::create([
                'nomor_induk' => $request->nomor_induk,
                'tanggal' => $request->tanggal
            ]);

            // Ambil nama pengguna untuk pesan sukses
            $namaPengguna = Pengguna::where('nomor_induk', $request->nomor_induk)
                ->value('nama');

            DB::commit();

            return redirect()->route('cuti.index')
                ->with('success', "Cuti untuk <b>$namaPengguna</b> berhasil ditambahkan.");
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Debug: Lihat error
            // dd($e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cuti = Cuti::with('pengguna')->findOrFail($id);
        $pengguna = Pengguna::where('aktif', '1')
            ->orderBy('nama')
            ->get();
        
        return view('cuti.edit', compact('cuti', 'pengguna'));
    }

    /**
 * Update the specified resource in storage.
 */
public function update(Request $request, string $id)
{
    $validator = Validator::make($request->all(), [
        'nomor_induk' => 'required|exists:pengguna,nomor_induk',
        'tanggal' => 'required|date'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $cuti = Cuti::findOrFail($id);
    $oldNomorInduk = $cuti->nomor_induk;
    $oldTanggal = $cuti->tanggal;

    // Cek duplikasi HANYA JIKA nomor_induk atau tanggal BERUBAH
    if ($request->nomor_induk != $oldNomorInduk || $request->tanggal != $oldTanggal) {
        $existingCuti = Cuti::where('nomor_induk', $request->nomor_induk)
            ->where('tanggal', $request->tanggal)
            ->where('id', '!=', $id)
            ->first();

        if ($existingCuti) {
            return redirect()->back()
                ->with('error', 'Karyawan sudah memiliki cuti pada tanggal tersebut.')
                ->withInput();
        }
    }

    try {
        DB::beginTransaction();
        
        $cuti->update([
            'nomor_induk' => $request->nomor_induk,
            'tanggal' => $request->tanggal
        ]);

        // Ambil nama pengguna baru untuk pesan sukses
        $namaPenggunaBaru = Pengguna::where('nomor_induk', $request->nomor_induk)
            ->value('nama');
        
        $namaPenggunaLama = Pengguna::where('nomor_induk', $oldNomorInduk)
            ->value('nama');

        DB::commit();

        $message = "Cuti ";
        
        if ($oldNomorInduk != $request->nomor_induk) {
            $message .= "berhasil dipindahkan dari <b>$namaPenggunaLama</b> ke <b>$namaPenggunaBaru</b>";
        } else {
            $message .= "untuk <b>$namaPenggunaBaru</b> berhasil diubah";
        }
        
        if ($oldTanggal != $request->tanggal) {
            $message .= " (tanggal diubah)";
        }

        return redirect()->route('cuti.index')
            ->with('success', $message . ".");
            
    } catch (\Exception $e) {
        DB::rollBack();
        
        return redirect()->back()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cuti = Cuti::with('pengguna')->findOrFail($id);
        
        $nomorInduk = $cuti->nomor_induk;
        $tanggal = \Carbon\Carbon::parse($cuti->tanggal)->format('d-m-Y');
        $namaPengguna = $cuti->pengguna ? $cuti->pengguna->nama : 'Tidak Diketahui';
        
        $cuti->delete();

        return redirect()->route('cuti.index')
            ->with('warning', "Cuti untuk <b>$namaPengguna</b> tanggal <b>$tanggal</b> telah dibatalkan.");
    }

    /**
     * API untuk cek cuti berdasarkan tanggal (untuk integrasi absensi)
     */
    public function checkCuti(Request $request)
    {
        $request->validate([
            'nomor_induk' => 'required|string',
            'tanggal' => 'required|date'
        ]);

        $cuti = Cuti::where('nomor_induk', $request->nomor_induk)
            ->where('tanggal', $request->tanggal)
            ->exists();

        return response()->json([
            'is_cuti' => $cuti,
            'message' => $cuti ? 'Karyawan sedang cuti' : 'Karyawan tidak cuti'
        ]);
    }
}