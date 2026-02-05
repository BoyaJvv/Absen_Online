<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'nomor_induk',
        'absen',
        'absen_maks',
        'kategori',
        'idmesin'
    ];
    
    protected $dates = ['absen', 'absen_maks'];
    
    // Relasi ke pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'nomor_induk', 'nomor_induk');
    }
    
    // Relasi ke mesin (jika ada tabel mesin)
    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'idmesin', 'idmesin');
    }
    
    // Accessor untuk label kategori
    public function getKategoriLabelAttribute()
    {
        $labels = [
            '1' => 'Masuk',
            '2' => 'Mulai Istirahat',
            '3' => 'Selesai Istirahat',
            '4' => 'Pulang',
        ];
        
        return $labels[$this->kategori] ?? 'Tidak Diketahui';
    }
    
    // Accessor untuk selisih menit
    public function getSelisihMenitAttribute()
    {
        if (!$this->absen || !$this->absen_maks) {
            return 0;
        }
        
        try {
            $absen = \Carbon\Carbon::parse($this->absen);
            $maks = \Carbon\Carbon::parse($this->absen_maks);
            return abs($absen->diffInMinutes($maks));
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    // Accessor untuk status
    public function getStatusAttribute()
    {
        if (!$this->absen || !$this->absen_maks) {
            return '-';
        }
        
        try {
            $absen = \Carbon\Carbon::parse($this->absen);
            $maks = \Carbon\Carbon::parse($this->absen_maks);
            
            switch ($this->kategori) {
                case '1': // Masuk
                    return $absen->gt($maks) ? 'Terlambat' : 'Tepat Waktu';
                case '2': // Mulai Istirahat
                    return $absen->gt($maks) ? 'Tepat Waktu' : 'Terlalu Cepat';
                case '3': // Selesai Istirahat
                    return $absen->gt($maks) ? 'Terlalu Cepat' : 'Tepat Waktu';
                case '4': // Pulang
                    return $absen->gt($maks) ? 'Tepat Waktu' : 'Terlalu Cepat';
                default:
                    return '-';
            }
        } catch (\Exception $e) {
            return '-';
        }
    }
    
    // Accessor untuk warna status
    public function getStatusWarnaAttribute()
    {
        $status = $this->status;
        
        if ($status == 'Terlambat' || $status == 'Terlalu Cepat') {
            return 'red';
        } elseif ($status == 'Tepat Waktu') {
            return 'green';
        }
        
        return 'black';
    }
}