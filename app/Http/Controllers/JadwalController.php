<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Matkul;
use App\Models\{Program, Ta};
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::query();
    
        $labs = Laboratorium::all();
        $programs = Program::all();
    
        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }
        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }
        if ($request->filled('jadwal')) {
            $query->whereDate('jadwal', $request->jadwal);
        }
    
        $query->whereHas('matkulId.taId', function ($q) {
            $q->where('status', 'aktif');
        });
    
        $jadwals = $query->orderBy('jadwal', 'desc')->get();
        return view('jadwal.index', compact('jadwals', 'labs', 'programs'));
    }

    public function create()
    {
        $selectedTaId = Ta::where('status', 'aktif')->value('id');
        $matkuls = Matkul::where('ta_id', $selectedTaId)->orderBy('matakuliah', 'asc')->get();
        $programs = Program::all();
        $lab = Laboratorium::all();
        return view('jadwal.create', compact('matkuls', 'programs', 'lab'));
    }
    
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'matakuliah_id' => 'required',
    //         'jadwal' => 'required|date',
    //         'program_id' => 'required',
    //         'lab_id' => 'required',
    //     ]);
    
    //     $tanggalAwal = Carbon::parse($request->jadwal);
    
    //     for ($i = 0; $i < 8; $i++) {
    //         Jadwal::create([
    //             'matakuliah_id' => $request->matakuliah_id,
    //             'jadwal' => $tanggalAwal->copy()->addWeeks($i),
    //             'program_id' => $request->program_id,
    //             'lab_id' => $request->lab_id,
    //         ]);
    //     }
    
    //     return redirect()->route('jadwal.index')->with('success', 'Jadwal 8 minggu berhasil ditambahkan!');
    // }
    
    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_id' => 'required',
            'jadwal' => 'required|date',
            'program_id' => 'required',
            'lab_id' => 'required',
        ]);

        try {
            $this->createWeeklySchedules(
                (int) $request->matakuliah_id,
                (int) $request->program_id,
                (int) $request->lab_id,
                Carbon::parse($request->jadwal)
            );
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal 8 minggu berhasil ditambahkan!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        if (!Ta::where('status', 'aktif')->exists()) {
            return redirect()->back()->with('error', 'Tahun Akademik aktif belum disetting');
        }

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');
        if ($handle === false) {
            return redirect()->back()->with('error', 'File CSV tidak dapat dibaca.');
        }

        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            return redirect()->back()->with('error', 'File CSV kosong.');
        }

        $columnMap = $this->mapCsvHeaders($header);
        $required = ['lab_id', 'program_id', 'matakuliah_id', 'tanggal', 'jam'];
        foreach ($required as $col) {
            if (!isset($columnMap[$col])) {
                fclose($handle);
                return redirect()->back()->with('error', "Kolom wajib tidak ditemukan: {$col}");
            }
        }

        $rowNumber = 1;
        $successRows = 0;
        $createdCount = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            if ($this->isCsvRowEmpty($row)) {
                continue;
            }

            $data = [];
            foreach ($columnMap as $key => $index) {
                $data[$key] = isset($row[$index]) ? trim($row[$index]) : '';
            }

            try {
                $this->importCsvRow($data);
                $successRows++;
                $createdCount += 8;
            } catch (\InvalidArgumentException $e) {
                $label = $data['matakuliah'] ?? "baris {$rowNumber}";
                $errors[] = "Baris {$rowNumber} ({$label}): {$e->getMessage()}";
            }
        }

        fclose($handle);

        if ($successRows === 0 && empty($errors)) {
            return redirect()->back()->with('error', 'Tidak ada data valid di file CSV.');
        }

        $message = "Import selesai: {$successRows} baris ({$createdCount} jadwal) berhasil ditambahkan.";
        if (!empty($errors)) {
            $message .= ' ' . count($errors) . ' baris gagal.';
        }

        return redirect()
            ->route('jadwal.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    public function JadwalLab()
    {
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $jadwalHariIni = Jadwal::whereDate('jadwal', Carbon::today())->get();
        return view('jadwal-laboratorium', compact('jadwalHariIni', 'hariIni'));
    }

    public function show(Jadwal $jadwal)
    {
        return view('jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal)
    {
        $matkuls = Matkul::all();
        $programs = Program::all();
        $lab = Laboratorium::all();
        return view('jadwal.edit', compact('jadwal', 'matkuls', 'programs', 'lab'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'matakuliah_id' => 'required',
            'jadwal' => 'required|date',
            'program_id' => 'required',
            'lab_id' => 'required',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    private function createWeeklySchedules(int $matakuliahId, int $programId, int $labId, Carbon $tanggalAwal): void
    {
        $taAktif = Ta::where('status', 'aktif')->first();
        if (!$taAktif) {
            throw new \RuntimeException('Tahun Akademik aktif belum disetting');
        }

        for ($i = 0; $i < 8; $i++) {
            Jadwal::create([
                'matakuliah_id' => $matakuliahId,
                'jadwal' => $tanggalAwal->copy()->addWeeks($i),
                'program_id' => $programId,
                'lab_id' => $labId,
                'status' => $taAktif->id,
            ]);
        }
    }

    private function importCsvRow(array $data): void
    {
        $labId = $this->parseRequiredInt($data['lab_id'] ?? '', 'lab_id');
        $programId = $this->parseRequiredInt($data['program_id'] ?? '', 'program_id');
        $matakuliahId = $this->parseRequiredInt($data['matakuliah_id'] ?? '', 'matakuliah_id');
        $tanggal = $data['tanggal'] ?? '';
        $jam = $data['jam'] ?? '';

        if ($tanggal === '') {
            throw new \InvalidArgumentException('tanggal wajib diisi');
        }
        if ($jam === '') {
            throw new \InvalidArgumentException('jam wajib diisi');
        }

        if (!Laboratorium::where('id', $labId)->exists()) {
            throw new \InvalidArgumentException("lab_id {$labId} tidak ditemukan");
        }
        if (!Program::where('id', $programId)->exists()) {
            throw new \InvalidArgumentException("program_id {$programId} tidak ditemukan");
        }

        $taAktif = Ta::where('status', 'aktif')->first();
        $matkul = Matkul::where('id', $matakuliahId)
            ->where('program_id', $programId)
            ->where('ta_id', $taAktif->id)
            ->first();

        if (!$matkul) {
            throw new \InvalidArgumentException("matakuliah_id {$matakuliahId} tidak valid untuk program/TA aktif");
        }

        try {
            $tanggalAwal = Carbon::parse($tanggal . ' ' . $jam);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('format tanggal/jam tidak valid');
        }

        $this->createWeeklySchedules($matakuliahId, $programId, $labId, $tanggalAwal);
    }

    private function mapCsvHeaders(array $header): array
    {
        $map = [];
        foreach ($header as $index => $name) {
            $key = strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', $name)));
            if ($key !== '') {
                $map[$key] = $index;
            }
        }
        return $map;
    }

    private function isCsvRowEmpty(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }
        return true;
    }

    private function parseRequiredInt(string $value, string $field): int
    {
        if ($value === '' || !ctype_digit($value)) {
            throw new \InvalidArgumentException("{$field} harus berupa angka");
        }
        return (int) $value;
    }
}