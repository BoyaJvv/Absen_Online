<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CabangGedungController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\JabatanStatusController;
use App\Http\Controllers\LiburKhususController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiPenggunaController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\ScanController;

/*
|--------------------------------------------------------------------------
| Public / Machine Routes
|--------------------------------------------------------------------------
*/
Route::match(['get', 'post'], '/pengguna/scan', [ScanController::class, 'index'])->name('pengguna.scan');
Route::match(['get', 'post'], '/absensi-machine', [AbsensiController::class, 'storeFromMachine']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (Semua Role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'hakAkses:nusabot,full,general'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| General User Routes (Role General)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/absensi/pengguna', [AbsensiPenggunaController::class, 'rekapSaya'])->name('absensi.pengguna.saya');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role: Nusabot & Full)
|--------------------------------------------------------------------------
*/
Route::middleware('hakAkses:nusabot,full')->group(function () {

    // Absensi Admin
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('index');
        Route::post('/', [AbsensiController::class, 'store'])->name('store');
        Route::get('/mesin', [AbsensiController::class, 'byMesin'])->name('mesin');
        Route::get('/pengguna/{nomor_induk}', [AbsensiPenggunaController::class, 'rekap'])->name('pengguna');
        Route::get('/{id}', [AbsensiController::class, 'show'])->name('show');
    });

    // Kelola Pengguna
    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [PenggunaController::class, 'index'])->name('index');
        Route::get('/create', [PenggunaController::class, 'create'])->name('create');
        Route::post('/', [PenggunaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PenggunaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PenggunaController::class, 'update'])->name('update');
        Route::delete('/{id}', [PenggunaController::class, 'destroy'])->name('destroy');
    });

    // Kelola Mesin
    Route::prefix('mesin')->name('mesin.')->group(function () {
        Route::get('/', [MesinController::class, 'index'])->name('index');
        Route::post('/', [MesinController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MesinController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MesinController::class, 'update'])->name('update');
    });

    // Kelola Cuti
    Route::prefix('cuti')->name('cuti.')->group(function () {
        Route::get('/', [CutiController::class, 'index'])->name('index');
        Route::post('/', [CutiController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CutiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CutiController::class, 'update'])->name('update');
        Route::delete('/{id}', [CutiController::class, 'destroy'])->name('destroy');
    });

    // Cabang dan Gedung
    Route::prefix('cabang-gedung')->name('cabang-gedung.')->group(function () {
        Route::get('/', [CabangGedungController::class, 'index'])->name('index');
        Route::post('/', [CabangGedungController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CabangGedungController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CabangGedungController::class, 'update'])->name('update');
        Route::delete('/{id}', [CabangGedungController::class, 'destroy'])->name('destroy');
    });

    // Libur Khusus
    Route::prefix('libur_khusus')->name('libur_khusus.')->group(function () {
        Route::get('/', [LiburKhususController::class, 'index'])->name('index');
        Route::post('/', [LiburKhususController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [LiburKhususController::class, 'edit'])->name('edit');
        Route::put('/{id}', [LiburKhususController::class, 'update'])->name('update');
        Route::delete('/{id}', [LiburKhususController::class, 'destroy'])->name('destroy');
    });

    // Jabatan & Status
    Route::prefix('jabatan')->name('jabatan.')->group(function () {
        Route::get('/', [JabatanStatusController::class, 'index'])->name('index');
        Route::post('/', [JabatanStatusController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [JabatanStatusController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JabatanStatusController::class, 'update'])->name('update');
        Route::delete('/{id}', [JabatanStatusController::class, 'destroy'])->name('destroy');
    });

    // Pengaturan Denda
    Route::prefix('pengaturan/denda')->name('denda.')->group(function () {
        Route::get('/', [DendaController::class, 'index'])->name('index');
        Route::get('/create', [DendaController::class, 'create'])->name('create');
        Route::post('/', [DendaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DendaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DendaController::class, 'update'])->name('update');
        Route::delete('/{id}', [DendaController::class, 'destroy'])->name('destroy');
    });

});

/*
|--------------------------------------------------------------------------
| Debug Route
|--------------------------------------------------------------------------
*/
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
        'all_hak_akses_table' => \Illuminate\Support\Facades\DB::table('hak_akses')->get(),
        'all_jabatan_status_table' => \Illuminate\Support\Facades\DB::table('jabatan_status')->get(['id', 'jabatan_status', 'hak_akses', 'aktif']),
    ], 200, [], JSON_PRETTY_PRINT);
})->middleware('auth');

require __DIR__.'/auth.php';