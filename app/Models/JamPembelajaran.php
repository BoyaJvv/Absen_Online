<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JamPembelajaran extends Model
{
    protected $table = 'jam_pembelajaran';

    protected $fillable = [
        'jam_masuk',
        'jam_pulang',
        'jam_mulai',
        'jam_selesai',
    ];

    public $timestamps = false;
}
