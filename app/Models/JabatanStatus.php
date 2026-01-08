<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanStatus extends Model
{
    protected $table = 'jabatan_status';

    protected $primaryKey = 'id';

    protected $fillable = [
        'jabatan_status',
        'hak_akses',
    ];

    public $timestamps = false;
}
