<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CabangGedung extends Model
{
    protected $table = 'cabang_gedung';

    protected $fillable = [
        'lokasi',
        'jam_masuk',
        'jam_pulang',
        'istirahat_mulai',
        'istirahat_selesai',
        'hari_libur',
        'zona_waktu',
        'aktif'
    ];

    public $timestamps = false;
}
