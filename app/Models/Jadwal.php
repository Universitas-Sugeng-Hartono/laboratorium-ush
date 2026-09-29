<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class Jadwal extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'jadwal';
    protected $fillable = [
        'matakuliah_id',
        'jadwal',
        'jam_selesai',
        'program_id',
        'lab_id',
        'semester',
        'kelas',
        'wa_sent_at',
    ];

    public function getJamMulaiAttribute()
    {
        return $this->jadwal ? \Carbon\Carbon::parse($this->jadwal)->format('H:i') : '-';
    }

    public function getJamSelesaiFormattedAttribute()
    {
        if ($this->jam_selesai) {
            return \Carbon\Carbon::parse($this->jam_selesai)->format('H:i');
        }
        return $this->jadwal ? \Carbon\Carbon::parse($this->jadwal)->addMinutes(170)->format('H:i') : '-';
    }

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

    public function getAuditRecordLabel(): string
    {
        $matkul = $this->matkulId?->matakuliah ?? "Jadwal #{$this->id}";
        $tgl = $this->jadwal ? date('d/m/Y H:i', strtotime($this->jadwal)) : '';
        return "{$matkul} ({$tgl})";
    }
}