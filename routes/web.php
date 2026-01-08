<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JamPembelajaranController;
use App\Http\Controllers\JabatanStatusController;

Route::get('/jam-pembelajaran', [JamPembelajaranController::class, 'index']);
Route::post('/jam-pembelajaran', [JamPembelajaranController::class, 'store']);
Route::delete('/jam-pembelajaran/{id}', [JamPembelajaranController::class, 'destroy']);



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
