<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';
    protected $fillable = [
        'id',
        'matakuliah_id',
        'jadwal',
        'program_id',
        'lab_id',
        'wa_sent_at'
    ];

    public function programId()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function matkulId()
    {
        return $this->belongsTo(Matkul::class, 'matakuliah_id');
    }

    public function labId()
    {
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }
}