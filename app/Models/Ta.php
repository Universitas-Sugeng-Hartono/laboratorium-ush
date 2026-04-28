<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ta extends Model
{
    use HasFactory;
    protected $table = 'ta';
    protected $fillable = [
        'id',
        'ta',
        'status',
    ];
    
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}