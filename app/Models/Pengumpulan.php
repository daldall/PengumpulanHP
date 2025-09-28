<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumpulan extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan';

    protected $fillable = [
        'user_id',
        'kode',
        'status',
        'metode',
        'waktu_input',
    ];

    protected $casts = [
        'waktu_input' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function code()
    {
        // Relasi ke model Code berdasarkan kolom 'kode'
        return $this->belongsTo(Code::class, 'kode', 'kode');
    }
}
