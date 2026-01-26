<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangGedungController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\JabatanStatusController;
use App\Http\Controllers\LiburKhususController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\AbsensiPenggunaController;
use App\Http\Controllers\DendaController;

// routes/web.php
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');



Route::prefix('pengaturan')->middleware(['auth'])->group(function () {
    Route::get('denda', [DendaController::class, 'index'])->name('denda.index');
    Route::get('denda/{id}/edit', [DendaController::class, 'edit'])->name('denda.edit');
    Route::put('denda/{id}', [DendaController::class, 'update'])->name('denda.update');
});


Route::resource('mesin', MesinController::class);
Route::get('/mesin', [MesinController::class, 'index'])->name('mesin.index');
Route::post('/mesin', [MesinController::class, 'store'])->name('mesin.store');
Route::get('/mesin/{id}/edit', [MesinController::class, 'edit'])->name('mesin.edit');
Route::put('/mesin/{id}', [MesinController::class, 'update'])->name('mesin.update');


Route::get('/absensi', [AbsensiController::class, 'index'])
    ->name('absensi.index');
Route::get('/absensi/{id}', [AbsensiController::class, 'show'])
    ->name('absensi.show');
Route::post('/absensi', [AbsensiController::class, 'store'])
    ->name('absensi.store');
Route::get('/absensi-mesin', [AbsensiController::class, 'byMesin'])
    ->name('absensi.mesin');
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
Route::get('/absensi/pengguna/{nomor_induk}', [AbsensiPenggunaController::class, 'show'])
    ->name('absensi.pengguna');

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

// cuti
Route::get('/cuti', [CutiController::class, 'index'])
    ->name('cuti.index');
Route::post('/cuti', [CutiController::class, 'store'])
    ->name('cuti.store');
Route::delete('/cuti/{id}', [CutiController::class, 'destroy'])
    ->name('cuti.destroy');
Route::get('/cuti/{id}/edit', [CutiController::class, 'edit'])
    ->name('cuti.edit');
Route::put('/cuti/{id}', [CutiController::class, 'update'])
    ->name('cuti.update');

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

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
