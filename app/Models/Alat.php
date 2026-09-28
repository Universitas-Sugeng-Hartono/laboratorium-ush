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
            'rusak_ringan' => 'bg-warning text-dark',
            'rusak_berat' => 'bg-danger text-white',
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

    public function getQrCodePayloadAttribute()
    {
        return json_encode([
            'kode' => $this->kode,
            'alat' => $this->alat,
            'lab' => $this->labId->laboratorium ?? '-',
            'url' => url('/alat/' . $this->id . '/edit'),
        ], JSON_UNESCAPED_SLASHES);
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