<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    protected $table = 'mesin';
    protected $primaryKey = 'idmesin';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'idmesin',
        'id_cabang_gedung',
        'keterangan',
    ];

    // RELASI KE CABANG GEDUNG
    public function cabangGedung()
    {
        return $this->belongsTo(
            CabangGedung::class,
            'id_cabang_gedung',
            'id'
        );
    }
}