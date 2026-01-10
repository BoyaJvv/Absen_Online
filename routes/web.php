<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangGedungController;
use App\Http\Controllers\JabatanStatusController;
use App\Http\Controllers\LiburKhususController;


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


Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
