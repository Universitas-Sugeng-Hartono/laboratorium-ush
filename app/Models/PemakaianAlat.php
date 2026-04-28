<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PemakaianAlat extends Model
{
    use HasFactory;
    protected $table = 'pemakaian_alat';
    protected $fillable = [
        'id',
        'pemakaian_id',
        'alat_id',
        'jumlah_pinjam',
        'jumlah_kembali',
        'rusak',
    ];
    
    public function alatid()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

}
