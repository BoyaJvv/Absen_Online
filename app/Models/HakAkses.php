<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    protected $table = 'hak_akses';
    public $timestamps = false;
    protected $fillable = ['hak'];
    protected $guarded = [];

    public function jabatanStatuses()
    {
        return $this->hasMany(JabatanStatus::class, 'hak_akses', 'id');
    }
}