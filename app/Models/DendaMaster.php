<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DendaMaster extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'prioritas';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'prioritas',
        'jenis',
        'per_menit',
        'rupiah_pertama',
        'rupiah_selanjutnya',
    ];
}
