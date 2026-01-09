<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalHarian extends Model
{
    protected $table = 'jadwal_harian';

    protected $fillable = [
        'cabang_gedung_id',
        'hari',
        'jam_masuk',
        'jam_pulang',
        'istirahat1_mulai',
        'istirahat1_selesai',
        'keterangan',
    ];

    public $timestamps = false;
}
