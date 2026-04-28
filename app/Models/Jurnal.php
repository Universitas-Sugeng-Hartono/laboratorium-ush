<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Jurnal extends Model
{
    use HasFactory;
    protected $table = 'jurnal';
    protected $fillable = [
        'id',
        'matakuliah_id',
        'jadwal_id',
        'program_id',
        'materi',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'ttd',
        'jumlah',
        'lab_id',
    ];

    public function programId()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function matkulId()
    {
        return $this->belongsTo(Matkul::class, 'matakuliah_id');
    }

    public function jadwalId()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function labId()
    {
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }
}