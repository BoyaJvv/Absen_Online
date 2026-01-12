<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuti extends Model
{
    

    protected $table = 'cuti';
     protected $primaryKey = 'id';
      public $timestamps = false;

    protected $fillable = [
       'nomor_induk',
       'tanggal',
    ];

     protected $casts = [
        'tanggal' => 'date'
    ];

    /**
     * Relasi ke model Pengguna
     */
/**
     * Relasi ke model Pengguna
     * Hapus type hinting jika ragu, atau gunakan yang benar
     */
    public function pengguna(): BelongsTo
    {
        // Perhatikan: menggunakan `belongsTo` bukan `BelongsToMany`
        // Jika ini one-to-many (satu cuti milik satu pengguna)
        return $this->belongsTo(Pengguna::class, 'nomor_induk', 'nomor_induk');
    }

    /**
     * Scope untuk filter tanggal
     */
    public function scopeTanggalRange($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }

    /**
     * Scope untuk nomor induk
     */
    public function scopeByNomorInduk($query, $nomorInduk)
    {
        return $query->where('nomor_induk', $nomorInduk);
    }
}
