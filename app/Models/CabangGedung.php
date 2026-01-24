<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalHarian;
use App\Models\Pengguna;

class CabangGedung extends Model
{
    protected $table = 'cabang_gedung';
    public $timestamps = false;

    protected $fillable = [
        'lokasi',
        'jam_masuk',
        'jam_pulang',
        'istirahat1_mulai',
        'istirahat1_selesai',
        'istirahat2_mulai',
        'istirahat2_selesai',
        'hari_libur',
        'zona_waktu',
        'aktif',
    ];

    // 🔹 Jadwal
    public function jadwalHarian()
    {
        return $this->hasMany(
            JadwalHarian::class,
            'cabang_gedung_id',
            'id'
        );
    }

    // 🔹 Pengguna di cabang ini
    public function penggunas()
    {
        return $this->hasMany(
            Pengguna::class,
            'cabang_gedung',
            'id'
        );
    }
}
