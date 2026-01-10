<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    public $timestamps = false;
    protected $table = 'pengguna';
    protected $fillable = [
        'nomor_induk',
        'nama',
        'tag',
        'jabatan_status',
        'cabang_gedung',
        'password',
        'aktif',
    ];

    // public function cuti(){
    //     return $this->belongsToMany(Cuti::class);
    // }
}
