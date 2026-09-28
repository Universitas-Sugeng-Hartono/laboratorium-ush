<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Fakultas extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fakultas';

    protected $fillable = [
        'kode',
        'fakultas',
        'dekan',
        'keterangan',
    ];

    /**
     * Relasi ke Program Studi di bawah Fakultas ini
     */
    public function programs()
    {
        return $this->hasMany(Program::class, 'fakultas_id');
    }

    /**
     * Label representation for audit logs
     */
    public function getAuditRecordLabel(): string
    {
        return "{$this->kode} - {$this->fakultas}";
    }
}
