<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class Absensi extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'absensi';
    protected $fillable = [
        'id',
        'ttd',
        'tamu',
        'kategori_tamu',
        'identitas',
        'instansi',
        'hp',
        'jumlah_tamu',
        'kategori_keperluan',
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