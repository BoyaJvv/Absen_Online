<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    protected $table = 'mesin';
    public $timestamps = false;

    protected $primaryKey = 'id_mesin'; // kalau memang ada
    public $incrementing = true;

    protected $fillable = [
        'idmesin',
        'id_cabang_gedung',
        'keterangan',
    ];

    // 🔹 relasi ke absensi
    public function absensis()
    {
        return $this->hasMany(
            Absensi::class,
            'idmesin',
            'idmesin'
        );
    }
}
