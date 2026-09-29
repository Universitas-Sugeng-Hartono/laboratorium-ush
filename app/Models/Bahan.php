<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class Bahan extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'bahan';
    protected $fillable = [
        'id',
        'lab_id',
        'kode',
        'bahan',
        'jumlah',
        'satuan',
        'stok_minimum',
        'tanggal_kedaluwarsa',
        'lokasi_penyimpanan',
        'spesifikasi',
    ];

    protected $casts = [
        'tanggal_kedaluwarsa' => 'date',
    ];

    public function getStatusStokAttribute()
    {
        if ($this->jumlah <= 0) {
            return 'habis';
        }
        if ($this->stok_minimum > 0 && $this->jumlah <= $this->stok_minimum) {
            return 'menipis';
        }
        return 'tersedia';
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status_stok) {
            'habis' => 'bg-danger text-white',
            'menipis' => 'bg-warning text-dark',
            default => 'bg-success text-white',
        };
    }

    public function labId()
    {
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }
    
    public function pemakaians()
    {
        return $this->belongsToMany(Pemakaian::class, 'pemakaian_bahan')
                    ->withPivot(['jumlah_pakai', 'jumlah_kembali', 'kondisi'])
                    ->withTimestamps();
    }
}