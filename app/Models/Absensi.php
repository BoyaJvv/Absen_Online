<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'nomor_induk',
        'jadwal_harian_id',
        'kategori',
        'idmesin'
    ];

    // File: app/Models/Absensi.php
    public function jadwalHarian()
    {
        return $this->belongsTo(JadwalHarian::class, 'jadwal_harian_id');
    }

    // protected $casts = [
    //     'absen_at' => 'datetime',
    //     'absen_maks' => 'datetime',
    // ];

    public function pengguna()
    {
        return $this->belongsTo(
            Pengguna::class,
            'nomor_induk',
            'nomor_induk'
        );
    }

    public function mesin()
    {
        return $this->belongsTo(
            Mesin::class,
            'idmesin',
            'idmesin'
        );
    }

    // 🔹 Label kategori
    // cont biar langsung panggil di controller
    
    // const KATEGORI_MASUK = 1;
    // const KATEGORI_ISTIRAHAT1 = 2;
    // const KATEGORI_ISTIRAHAT2 = 3;
    // const KATEGORI_PULANG = 4;

    // public function getKategoriLabelAttribute()
    // {
    //     return match ($this->kategori) {
    //         1 => 'Masuk',
    //         2 => 'Mulai Istirahat',
    //         3 => 'Selesai Istirahat',
    //         4 => 'Pulang',
    //         default => '-',
    //     };
    // }
}
