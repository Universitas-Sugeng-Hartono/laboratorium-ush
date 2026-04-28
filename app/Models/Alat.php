<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Alat extends Model
{
    use HasFactory;
    protected $table = 'alat';
    protected $fillable = [
        'id',
        'kode',
        'alat',
        'jumlah'
    ];
    
    public function pemakaians()
    {
        return $this->belongsToMany(Pemakaian::class, 'alat_pemakaian')
                    ->withPivot(['jumlah_pakai', 'jumlah_kembali', 'kondisi'])
                    ->withTimestamps();
    }

}