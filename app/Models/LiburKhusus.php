<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiburKhusus extends Model
{
    protected $table = 'libur_khusus';

    protected $fillable = [
        'tanggal',
        'keterangan'
    ];

    public $timestamps = false;
}

