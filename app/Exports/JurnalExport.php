<?php

namespace App\Exports;

use App\Models\Jurnal;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JurnalExport implements WithCustomCsvSettings, WithHeadings, FromView
{
    protected $labId;
    protected $programId;
    protected $tanggalAwal;
    protected $tanggalAkhir;

    public function __construct($labId = null, $programId = null, $tanggalAwal = null, $tanggalAkhir = null)
    {
        $this->labId = $labId;
        $this->programId = $programId;
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ["Dosen", "Program Studi", "Mata Kuliah", "Materi", "Tanggal", "Jam Mulai - Selesai", "Jumlah"];
    }

    public function view(): View
    {
        $query = Jurnal::query();

        if ($this->labId) {
            $query->where('lab_id', $this->labId);
        }

        if ($this->programId) {
            $query->where('program_id', $this->programId);
        }

        if ($this->tanggalAwal && $this->tanggalAkhir) {
            $query->whereBetween('tanggal', [$this->tanggalAwal, $this->tanggalAkhir]);
        } elseif ($this->tanggalAwal) {
            $query->where('tanggal', '>=', $this->tanggalAwal);
        } elseif ($this->tanggalAkhir) {
            $query->where('tanggal', '<=', $this->tanggalAkhir);
        }

        return view('jurnal.getcsv', [
            'datas' => $query->orderBy('tanggal')->get()
        ]);
    }
}