<?php

namespace App\Support;

use App\Models\Alat;
use App\Models\Bahan;
use App\Models\Jadwal;
use App\Models\Laboratorium;
use App\Models\Ta;
use Carbon\Carbon;

class LaporanPimpinan
{
    public const HARI_MENJELANG_KEDALUWARSA = 30;

    public static function susun(int $labId, int $taId): array
    {
        $lab = Laboratorium::findOrFail($labId);
        $ta = Ta::findOrFail($taId);
        $hariIni = Carbon::now('Asia/Jakarta')->startOfDay();
        $batasKedaluwarsa = $hariIni->copy()->addDays(self::HARI_MENJELANG_KEDALUWARSA);

        $pertemuan = Jadwal::query()
            ->where('lab_id', $lab->id)
            ->whereHas('matkulId', function ($matkul) use ($ta) {
                $matkul->where('ta_id', $ta->id);
            });

        $jumlahPertemuan = (clone $pertemuan)->count();
        $lewat = (clone $pertemuan)->whereDate('jadwal', '<', $hariIni->toDateString());
        $jumlahLewat = (clone $lewat)->count();
        $sudahDiisi = (clone $lewat)->whereHas('jurnals')->count();
        $belumDiisi = (clone $lewat)->whereDoesntHave('jurnals')->count();
        $persen = $jumlahLewat === 0 ? 0 : round($sudahDiisi / $jumlahLewat * 100, 1);

        $alat = Alat::where('lab_id', $lab->id)->orderBy('kode')->get();
        $bahan = Bahan::where('lab_id', $lab->id)->orderBy('kode')->get();

        $alatBermasalah = $alat->filter(function (Alat $item) {
            return in_array($item->kondisi, ['rusak', 'rusak_ringan', 'rusak_berat'], true)
                || $item->status === 'maintenance';
        })->values();

        $bahanKritis = $bahan->filter(function (Bahan $item) {
            return $item->status_stok === 'habis' || $item->status_stok === 'menipis';
        })->values();

        $bahanKedaluwarsa = $bahan->filter(function (Bahan $item) use ($batasKedaluwarsa) {
            return $item->tanggal_kedaluwarsa && $item->tanggal_kedaluwarsa->copy()->startOfDay()->lte($batasKedaluwarsa);
        })->map(function (Bahan $item) use ($hariIni) {
            $tanggal = $item->tanggal_kedaluwarsa->copy()->startOfDay();

            return [
                'kode' => $item->kode ?: '-',
                'nama' => $item->bahan,
                'jumlah' => (int) $item->jumlah,
                'satuan' => $item->satuan ?: 'Pcs',
                'tanggal' => $tanggal->locale('id')->isoFormat('D MMMM Y'),
                'tanda' => $tanggal->lte($hariIni) ? 'Sudah kedaluwarsa' : 'Akan kedaluwarsa',
            ];
        })->values();

        return [
            'laboratorium' => $lab->laboratorium,
            'tahun_akademik' => $ta->ta,
            'hari_ini' => $hariIni->locale('id')->isoFormat('D MMMM Y'),
            'batas_kedaluwarsa' => $batasKedaluwarsa->locale('id')->isoFormat('D MMMM Y'),
            'pemakaian_ruangan' => $jumlahPertemuan,
            'jurnal_lewat' => $jumlahLewat,
            'jurnal_sudah' => $sudahDiisi,
            'jurnal_belum' => $belumDiisi,
            'jurnal_persen' => number_format($persen, 1, ',', '.'),
            'stok_alat_jenis' => $alat->count(),
            'stok_alat_unit' => (int) $alat->sum('jumlah'),
            'stok_bahan_jenis' => $bahan->count(),
            'stok_bahan_unit' => (int) $bahan->sum('jumlah'),
            'alat_bermasalah' => $alatBermasalah->map(function (Alat $item) {
                return [
                    'kode' => $item->kode ?: '-',
                    'nama' => $item->alat,
                    'kondisi' => $item->kondisi_label,
                    'status' => $item->status_label,
                ];
            })->all(),
            'bahan_kritis' => $bahanKritis->map(function (Bahan $item) {
                return [
                    'kode' => $item->kode ?: '-',
                    'nama' => $item->bahan,
                    'jumlah' => (int) $item->jumlah,
                    'satuan' => $item->satuan ?: 'Pcs',
                    'minimum' => (int) $item->stok_minimum,
                    'keadaan' => $item->status_stok === 'habis' ? 'Habis' : 'Mencapai stok minimum',
                ];
            })->all(),
            'bahan_kedaluwarsa' => $bahanKedaluwarsa->all(),
        ];
    }
}
