<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangGedungController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\JabatanStatusController;
use App\Http\Controllers\LiburKhususController;
use App\Http\Controllers\AbsensiController;

Route::get('/absensi', [AbsensiController::class, 'index'])
    ->name('absensi.index');
Route::get('/absensi/{id}', [AbsensiController::class, 'show'])
    ->name('absensi.show');
Route::post('/absensi', [AbsensiController::class, 'store'])
    ->name('absensi.store');
Route::get('/absensi-mesin', [AbsensiController::class, 'byMesin'])
    ->name('absensi.mesin');


// Cabang dan Gedung Routes
Route::get('/cabang-gedung', [CabangGedungController::class, 'index'])
    ->name('cabang-gedung.index');
Route::post('/cabang-gedung', [CabangGedungController::class, 'store'])
    ->name('cabang-gedung.store');
Route::delete('/cabang-gedung/{id}', [CabangGedungController::class, 'destroy'])
    ->name('cabang-gedung.destroy');
Route::get('/cabang-gedung/{id}/edit', [CabangGedungController::class, 'edit'])
    ->name('cabang-gedung.edit');
Route::put('/cabang-gedung/{id}', [CabangGedungController::class, 'update'])
    ->name('cabang-gedung.update');

// libur khusus
Route::prefix('libur_khusus')->name('libur_khusus.')->group(function () {
    Route::get('/', [LiburKhususController::class, 'index'])->name('index');
    Route::post('/', [LiburKhususController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [LiburKhususController::class, 'edit'])->name('edit');
    Route::put('/{id}', [LiburKhususController::class, 'update'])->name('update');

    Route::delete('/{id}', [LiburKhususController::class, 'destroy'])->name('destroy');
});


//jabatan
Route::prefix('jabatan')->name('jabatan.')->group(function () {
    Route::get('/', [JabatanStatusController::class, 'index'])->name('index');
    Route::post('/', [JabatanStatusController::class, 'store'])->name('store');

    Route::get('/{id}/edit', [JabatanStatusController::class, 'edit'])->name('edit');
    Route::put('/{id}', [JabatanStatusController::class, 'update'])->name('update');

    Route::get('/toggle/{id}', [JabatanStatusController::class, 'toggle'])->name('toggle');
});

Route::middleware('auth')->prefix('pengguna')->name('pengguna.')->group(function () {
    Route::get('/', [PenggunaController::class, 'index'])->name('index');
    Route::get('/create', [PenggunaController::class, 'create'])->name('create');
    Route::post('/', [PenggunaController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PenggunaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PenggunaController::class, 'update'])->name('update');
    Route::delete('/{id}', [PenggunaController::class, 'destroy'])->name('destroy'); 
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
