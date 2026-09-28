<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Program extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'program';

    protected $fillable = [
        'id',
        'fakultas_id',
        'program',
    ];

    /**
     * Relasi ke Fakultas
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    /**
     * Label representasi untuk audit log
     */
    public function getAuditRecordLabel(): string
    {
        return $this->program ?? "Prodi #{$this->id}";
    }
}