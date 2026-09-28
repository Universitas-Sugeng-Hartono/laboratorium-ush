<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class Matkul extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'matakuliah';
    protected $fillable = [
        'matakuliah',
        'dosen',
        'program_id',
        'nomor',
        'ta_id'
    ];

    public function programId()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    
    public function taId()
    {
        return $this->belongsTo(Ta::class, 'ta_id');
    }
}
