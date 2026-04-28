<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $fillable = [
        'id',
        'ttd',
        'tamu',
        'hp',
        'jumlah_tamu',
        'keperluan',
        'tanggal',
        'jam',
        'jamselesai',
        'lab_id',
    ];

    public function labId()
    {
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }
}