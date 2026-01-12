<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'nomor_induk',
        'absen',
        'absen_maks',
        'kategori',
        'idmesin'
    ];

    protected $casts = [
        'absen' => 'datetime',
        'absen_maks' => 'datetime',
    ];

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
    public function getKategoriLabelAttribute()
    {
        return match ($this->kategori) {
            1 => 'Masuk',
            2 => 'Mulai Istirahat',
            3 => 'Selesai Istirahat',
            4 => 'Pulang',
            default => '-',
        };
    }
}
