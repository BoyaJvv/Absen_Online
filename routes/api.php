<?php

use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;

Route::get('/absensi-machine', [AbsensiController::class, 'storeFromMachine']);

