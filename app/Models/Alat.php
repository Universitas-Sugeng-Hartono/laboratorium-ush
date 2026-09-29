<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class Alat extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'alat';
    protected $fillable = [
        'id',
        'lab_id',
        'kode',
        'alat',
        'jumlah',
        'kondisi',
        'status',
        'spesifikasi',
        'lokasi_penyimpanan'
    ];

    public function getKondisiBadgeAttribute()
    {
        return match ($this->kondisi) {
            'rusak', 'rusak_berat' => 'bg-danger text-white',
            'rusak_ringan' => 'bg-warning text-dark',
            default => 'bg-success text-white',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'dipinjam' => 'bg-primary text-white',
            'maintenance' => 'bg-secondary text-white',
            default => 'bg-info text-white',
        };
    }

    public function getKondisiLabelAttribute(): string
    {
        return match ($this->kondisi) {
            'rusak' => 'Rusak',
            'rusak_ringan' => 'Rusak ringan',
            'rusak_berat' => 'Rusak berat',
            default => 'Baik',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'dipinjam' => 'Dipinjam',
            'maintenance' => 'Dalam perbaikan',
            default => 'Tersedia',
        };
    }

    public function getQrCodePayloadAttribute()
    {
        return route('alat.kartu', $this->id);
    }

    public function riwayat()
    {
        return $this->hasMany(AlatRiwayat::class, 'alat_id')->orderByDesc('tanggal')->orderByDesc('id');
    }

    public function terapkanJenisRiwayat(string $jenis): void
    {
        if ($jenis === 'rusak') {
            $this->kondisi = 'rusak';
        } elseif ($jenis === 'dalam_perbaikan') {
            $this->status = 'maintenance';
        } elseif ($jenis === 'layak_pakai') {
            $this->kondisi = 'baik';
            $this->status = 'tersedia';
        }
    }

    public function labId()
    {
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }
    
    public function pemakaians()
    {
        return $this->belongsToMany(Pemakaian::class, 'alat_pemakaian')
                    ->withPivot(['jumlah_pakai', 'jumlah_kembali', 'kondisi'])
                    ->withTimestamps();
    }

}