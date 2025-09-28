<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Code extends Model
{
    use HasFactory;

    protected $table = 'codes';

    protected $fillable = [
        'kode',
        'tanggal',
        'jenis',
        'aktif_dari',
        'aktif_sampai',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'aktif_dari' => 'datetime:H:i:s',
        'aktif_sampai' => 'datetime:H:i:s',
    ];

    public function pengumpulan()
    {
        return $this->hasMany(\App\Models\Pengumpulan::class, 'kode', 'kode');
    }

    public function isActive()
    {
        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');
        $currentDate = $now->toDateString();

        return $this->tanggal->toDateString() === $currentDate
            && $currentTime >= $this->aktif_dari->format('H:i:s')
            && $currentTime <= $this->aktif_sampai->format('H:i:s');
    }

    public static function generateKode($tanggal, $jenis)
    {
        return strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6));

    }
}
