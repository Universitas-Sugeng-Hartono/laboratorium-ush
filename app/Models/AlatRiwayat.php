<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatRiwayat extends Model
{
    use HasFactory;

    protected $table = 'alat_riwayat';

    protected $fillable = [
        'alat_id',
        'tanggal',
        'nama_pelapor',
        'jenis',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis) {
            'rusak' => 'Rusak',
            'dalam_perbaikan' => 'Dalam perbaikan',
            'layak_pakai' => 'Layak pakai',
            default => $this->jenis,
        };
    }
}
