<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Pemakaian extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'pemakaian';
    protected $fillable = [
        'admin_id',
        'keterangan',
        'matakuliah_id',
        'jadwal_id',
        'program_id',
        'keperluan',
        'tgl_peminjaman',
        'tgl_pengembalian',
        'alat_id',
        'bahan_id',
        'ttd',
        'nama',
        'lab_id',
        'nomor',
        'status_pengembalian',
    ];
    protected $casts = [
        'alat_id' => 'array',
        'bahan_id' => 'array',
    ];

    public function programId()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function matkulId()
    {
        return $this->belongsTo(Matkul::class, 'matakuliah_id');
    }

    public function jadwalId()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function labId()
    {
        return $this->belongsTo(Laboratorium::class, 'lab_id');
    }

    public function alatId()
    {
        return $this->belongsToMany(Alat::class, 'pemakaian_alat')->withPivot('jumlah_pinjam');
    }

    public function alat()
    {
        return $this->belongsToMany(Alat::class, 'pemakaian_alat')->withPivot('jumlah_pinjam');
    }
    
    public function bahan()
    {
        return $this->belongsToMany(Bahan::class, 'pemakaian_bahan')->withPivot('jumlah_pakai');
    }
    
    public function alatData()
    {
        return $this->hasMany(PemakaianAlat::class); 
    }
    
    public function bahanData()
    {
        return $this->hasMany(PemakaianBahan::class);
    }
    
    public function pemakaianAlat()
    {
        return $this->hasMany(PemakaianAlat::class);
    }
    
    public function pemakaianBahan()
    {
        return $this->hasMany(PemakaianBahan::class);
    }


    public function userId()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function stockIsHeld(): bool
    {
        return $this->keterangan === 'setuju' && $this->status_pengembalian !== 'sudah';
    }

    public function deductStock(): void
    {
        $this->load(['pemakaianAlat', 'pemakaianBahan']);

        foreach ($this->pemakaianAlat as $row) {
            $qty = (int) $row->jumlah_pinjam;
            if ($qty <= 0) {
                continue;
            }

            $alat = Alat::where('id', $row->alat_id)->lockForUpdate()->first();
            if (!$alat || (int) $alat->jumlah < $qty) {
                $nama = $alat->alat ?? 'alat';
                $sisa = $alat->jumlah ?? 0;
                throw new \RuntimeException("Stok alat tidak mencukupi untuk '{$nama}'. Sisa stok tersedia: {$sisa}.");
            }
            $alat->decrement('jumlah', $qty);
        }

        foreach ($this->pemakaianBahan as $row) {
            $qty = (int) $row->jumlah_pakai;
            if ($qty <= 0) {
                continue;
            }

            $bahan = Bahan::where('id', $row->bahan_id)->lockForUpdate()->first();
            if (!$bahan || (int) $bahan->jumlah < $qty) {
                $nama = $bahan->bahan ?? 'bahan';
                $sisa = $bahan->jumlah ?? 0;
                throw new \RuntimeException("Stok bahan tidak mencukupi untuk '{$nama}'. Sisa stok tersedia: {$sisa}.");
            }
            $bahan->decrement('jumlah', $qty);
        }
    }

    public function restoreAlatStock(): void
    {
        $this->load('pemakaianAlat');

        foreach ($this->pemakaianAlat as $row) {
            $qty = (int) $row->jumlah_pinjam;
            if ($qty <= 0) {
                continue;
            }

            $alat = Alat::where('id', $row->alat_id)->lockForUpdate()->first();
            if (!$alat) {
                throw new \RuntimeException('Data alat tidak ditemukan saat mengembalikan stok.');
            }
            $alat->increment('jumlah', $qty);
        }
    }

    public function restoreBahanStock(): void
    {
        $this->load('pemakaianBahan');

        foreach ($this->pemakaianBahan as $row) {
            $qty = (int) $row->jumlah_pakai;
            if ($qty <= 0) {
                continue;
            }

            $bahan = Bahan::where('id', $row->bahan_id)->lockForUpdate()->first();
            if (!$bahan) {
                throw new \RuntimeException('Data bahan tidak ditemukan saat mengembalikan stok.');
            }
            $bahan->increment('jumlah', $qty);
        }
    }

    public function restoreHeldStock(): void
    {
        $this->restoreAlatStock();
        $this->restoreBahanStock();
    }
}