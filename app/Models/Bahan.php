<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bahan extends Model
{
    use HasFactory;
    protected $table = 'bahan';
    protected $fillable = [
        'id',
        'kode',
        'bahan',
        'jumlah',
        'satuan',
    ];
    
    public function pemakaians()
    {
        return $this->belongsToMany(Pemakaian::class, 'bahan_pemakaian')
                    ->withPivot(['jumlah_pakai', 'jumlah_kembali', 'kondisi'])
                    ->withTimestamps();
    }

}