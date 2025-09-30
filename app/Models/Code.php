<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $table = 'codes';

    protected $fillable = [
        'kode',
        'tanggal',
        'jenis',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pengumpulan()
    {
        return $this->hasMany(\App\Models\Pengumpulan::class, 'kode', 'kode');
    }

    // cek apakah kode aktif
    public function isActive()
    {
        return $this->status === 'aktif';
    }

    // scope untuk query kode yang aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public static function generateKode($tanggal, $jenis)
    {
        return strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6));
    }
}
