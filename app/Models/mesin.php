<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CabangGedung;

class Mesin extends Model
{
    protected $table = 'mesin';
    protected $primaryKey = 'id_mesin';
    public $timestamps = false;

    protected $fillable = [
        'idmesin',
        'id_cabang_gedung',
        'keterangan',
    ];

    // 🔥 RELASI KE CABANG GEDUNG
    public function cabangGedung()
    {
        return $this->belongsTo(
            CabangGedung::class,
            'id_cabang_gedung',
            'id'
        );
    }
}
