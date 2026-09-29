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
        'dosen2',
        'program_id',
        'nomor',
        'nomor2',
        'ta_id'
    ];

    public function penerimaWhatsapp(): array
    {
        $daftar = [];
        $terpakai = [];

        foreach ([[$this->dosen, $this->nomor], [$this->dosen2, $this->nomor2]] as [$nama, $nomor]) {
            $nomor = trim((string) $nomor);
            if ($nomor === '' || isset($terpakai[$nomor])) {
                continue;
            }

            $terpakai[$nomor] = true;
            $nama = trim((string) $nama);
            $daftar[] = [
                'dosen' => $nama !== '' ? $nama : 'Bapak/Ibu',
                'nomor' => $nomor,
            ];
        }

        return $daftar;
    }

    public function programId()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    
    public function taId()
    {
        return $this->belongsTo(Ta::class, 'ta_id');
    }
}
