<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\JadwalHarian;

$all = JadwalHarian::all()->toArray();
echo json_encode($all, JSON_PRETTY_PRINT);
