<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    protected $table = 'mesin';
    protected $primaryKey = 'idmesin';
    public $incrementing = false; // karena string
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'idmesin',
        'id_cabang_gedung',
        'keterangan',
    ];

    public function absensi()
    {
        return $this->hasMany(
            Absensi::class,
            'idmesin',
            'idmesin'
        );
    }
}
