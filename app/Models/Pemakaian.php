<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pemakaian extends Model
{
    use HasFactory;
    protected $table = 'pemakaian';
    protected $fillable = [
        'id',
        'admin_id',
        'keterangan',
        'matakuliah_id',
        'jadwal_id',
        'program_id',
        'keperluan',
        'tgl_peminjaman',
        'tgl_pengembalian',
        'alat_id',
        'bahan_id',
        'ttd',
        'nama',
        'lab_id',
        'nomor',

    ];
    protected $casts = [
        'alat_id' => 'array',
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

    public function alatId()
    {
        return $this->belongsToMany(Alat::class, 'alat_id');
    }

    public function alat()
    {
        return $this->belongsToMany(Alat::class, 'pemakaian_alat')->withPivot('jumlah');
    }
    
    public function bahan()
    {
        return $this->belongsToMany(Bahan::class, 'bahan_pemakaian')->withPivot('jumlah');
    }
    
    public function alatData()
    {
        return $this->hasMany(PemakaianAlat::class); 
    }
    
    public function bahanData()
    {
        return $this->hasMany(PemakaianBahan::class);
    }
    
    public function pemakaianAlat()
    {
        return $this->hasMany(PemakaianAlat::class);
    }
    
    public function pemakaianBahan()
    {
        return $this->hasMany(PemakaianBahan::class);
    }


    public function userId()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}