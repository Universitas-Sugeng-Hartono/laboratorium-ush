<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class Ta extends Model
{
    use HasFactory, LogsActivity;
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

    public static function pesanJikaTidakAktif(): ?string
    {
        if (static::where('status', 'aktif')->exists()) {
            return null;
        }

        return 'Tahun akademik aktif belum diatur.';
    }
}