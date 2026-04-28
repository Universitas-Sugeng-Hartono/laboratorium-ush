<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PemakaianBahan extends Model
{
    use HasFactory;
    protected $table = 'pemakaian_bahan';
    protected $fillable = [
        'id',
        'pemakaian_id',
        'bahan_id',
        'jumlah_pakai',
        'jumlah_kembali',
        'rusak',
    ];
    
    public function bahanid()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }

}
