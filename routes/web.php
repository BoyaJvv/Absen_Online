<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CabangGedungController;


// Cabang dan Gedung Routes
Route::get('/cabang-gedung', [CabangGedungController::class, 'index'])
    ->name('cabang-gedung.index');
Route::post('/cabang-gedung', [CabangGedungController::class, 'store'])
    ->name('cabang-gedung.store');
Route::delete('/cabang-gedung/{id}', [CabangGedungController::class, 'destroy'])
    ->name('cabang-gedung.destroy');

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
