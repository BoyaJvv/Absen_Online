<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    public $timestamps = false;

    protected $primaryKey = 'nomor_induk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nomor_induk',
        'nama',
        'tag',
        'jabatan_status',
        'cabang_gedung',
        'password',
        'aktif',
    ];

    // 🔹 Cabang / Gedung
    public function cabangGedung()
    {
        return $this->belongsTo(
            CabangGedung::class,
            'cabang_gedung',
            'id'
        );
    }
    public function jabatanStatus()
    {
        return $this->belongsTo(
            JabatanStatus::class,
            'jabatan_status',
            'id'
        );
    }

    // 🔹 Absensi
    public function absensis()
    {
        return $this->hasMany(
            Absensi::class,
            'nomor_induk',
            'nomor_induk'
        );
    }

    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'nomor_induk', 'nomor_induk');
    }

}


