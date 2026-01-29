<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// DEBUG ROUTE - HAPUS SETELAH SELESAI
Route::get('/debug-akses', function () {
    $user = auth()->user();
    
    if (!$user) {
        return response()->json(['error' => 'User tidak login'], 401);
    }
    
    $jabatanStatus = $user->jabatanStatus;
    $hakAkses = $jabatanStatus?->hakAkses;
    
    return response()->json([
        'user' => [
            'nomor_induk' => $user->nomor_induk,
            'nama' => $user->nama,
            'jabatan_status_id' => $user->jabatan_status,
        ],
        'jabatan_status' => [
            'id' => $jabatanStatus?->id,
            'jabatan_status' => $jabatanStatus?->jabatan_status,
            'hak_akses_id' => $jabatanStatus?->hak_akses,
            'aktif' => $jabatanStatus?->aktif,
        ],
        'hak_akses' => [
            'id' => $hakAkses?->id,
            'hak' => $hakAkses?->hak,
        ],
        'all_hak_akses_table' => DB::table('hak_akses')->get(),
        'all_jabatan_status_table' => DB::table('jabatan_status')->get(['id', 'jabatan_status', 'hak_akses', 'aktif']),
    ], 200, [], JSON_PRETTY_PRINT);
});
