<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalHarian extends Model
{
    protected $table = 'jadwal_harian';

    protected $fillable = [
        'cabang_gedung_id',
        'hari',
        'libur',
        'jam_masuk',
        'jam_pulang',
        'istirahat1_mulai',
        'istirahat1_selesai',
        'istirahat2_mulai',
        'istirahat2_selesai',
    ];

    protected $casts = [
        'libur' => 'boolean', // agar di PHP otomatis jadi true/false
    ];

    public $timestamps = false;

    public function cabangGedung()
    {
        return $this->belongsTo(CabangGedung::class, 'cabang_gedung_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'jadwal_harian_id');
    }

    // Many-to-many: jadwal_harian can be related to multiple absensi via pivot
    public function absensisMany()
    {
        return $this->belongsToMany(
            Absensi::class,
            'absensi_jadwal_harian',
            'jadwal_harian_id',
            'absensi_id'
        );
    }
}
    
