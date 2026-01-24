<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanStatus extends Model
{
    protected $table = 'jabatan_status';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['jabatan_status', 'hak_akses', 'aktif'];

    // Relasi ke Hak Akses
    public function hakAkses()
    {
        return $this->belongsTo(HakAkses::class, 'hak_akses', 'id');
    }

    // Relasi ke Pengguna
    public function penggunas()
    {
        return $this->hasMany(Pengguna::class, 'jabatan_status', 'id');
    }
}