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
        $query = Jadwal::with(['matkulId', 'labId', 'programId']);
    
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
    
        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $jadwals = $query->orderBy('jadwal', 'desc')->paginate($perPage)->appends($request->query());
        return view('jadwal.index', compact('jadwals', 'labs', 'programs'));
    }

    public function create()
    {
        $taAktif = Ta::where('status', 'aktif')->first();
        $selectedTaId = $taAktif ? $taAktif->id : null;
        $matkuls = Matkul::where('ta_id', $selectedTaId)->orderBy('matakuliah', 'asc')->get();
        $programs = Program::all();
        $lab = Laboratorium::all();
        return view('jadwal.create', compact('matkuls', 'programs', 'lab', 'taAktif'));
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
            'jam_selesai' => 'nullable',
            'program_id' => 'required',
            'lab_id' => 'required',
        ]);

        $jamSelesai = $request->jam_selesai;
        if (!$jamSelesai) {
            $jamSelesai = Carbon::parse($request->jadwal)->addMinutes(170)->format('H:i');
        }

        try {
            $this->createWeeklySchedules(
                (int) $request->matakuliah_id,
                (int) $request->program_id,
                (int) $request->lab_id,
                Carbon::parse($request->jadwal),
                $jamSelesai
            );
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal 8 minggu berhasil ditambahkan!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|max:10240',
        ]);

        $uploadedFile = $request->file('csv_file');
        $ext = strtolower($uploadedFile->getClientOriginalExtension());
        if (!in_array($ext, ['xlsx', 'xls', 'csv', 'txt'])) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Harap upload file .xlsx, .xls, atau .csv');
        }

        if (!Ta::where('status', 'aktif')->exists()) {
            return redirect()->back()->with('error', 'Tahun Akademik aktif belum disetting');
        }

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadedFile->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca file: ' . $e->getMessage());
        }

        if (empty($rows)) {
            return redirect()->back()->with('error', 'File yang diupload kosong.');
        }

        // If first row is sep=..., skip it
        if (isset($rows[0][0]) && str_starts_with(strtolower(trim((string)$rows[0][0])), 'sep=')) {
            array_shift($rows);
        }

        if (empty($rows)) {
            return redirect()->back()->with('error', 'File yang diupload kosong.');
        }

        $header = array_shift($rows);
        $columnMap = $this->mapCsvHeaders($header);
        $required = ['lab_id', 'program_id', 'matakuliah_id', 'tanggal', 'jam'];
        foreach ($required as $col) {
            if (!isset($columnMap[$col])) {
                return redirect()->back()->with('error', "Kolom wajib tidak ditemukan di baris header: {$col}");
            }
        }

        $rowNumber = 1;
        $successRows = 0;
        $createdCount = 0;
        $errors = [];

        foreach ($rows as $row) {
            $rowNumber++;
            if ($this->isCsvRowEmpty($row)) {
                continue;
            }

            $data = [];
            foreach ($columnMap as $key => $index) {
                $val = isset($row[$index]) ? $row[$index] : '';
                $data[$key] = trim((string) $val);
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

        if ($successRows === 0 && empty($errors)) {
            return redirect()->back()->with('error', 'Tidak ada data valid di file yang diunggah.');
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
        $jadwal->load(['matkulId', 'programId', 'labId']);

        return view('jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal)
    {
        $taAktif = Ta::where('status', 'aktif')->first();
        $matkuls = Matkul::when($taAktif, function($q) use ($taAktif, $jadwal) {
            $q->where('ta_id', $taAktif->id)->orWhere('id', $jadwal->matakuliah_id);
        })->orderBy('matakuliah', 'asc')->get();
        $programs = Program::all();
        $lab = Laboratorium::all();
        return view('jadwal.edit', compact('jadwal', 'matkuls', 'programs', 'lab', 'taAktif'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'matakuliah_id' => 'required',
            'jadwal' => 'required|date',
            'jam_selesai' => 'nullable',
            'program_id' => 'required',
            'lab_id' => 'required',
        ]);

        $jamSelesai = $request->jam_selesai;
        if (!$jamSelesai) {
            $jamSelesai = Carbon::parse($request->jadwal)->addMinutes(170)->format('H:i');
        }

        $data = $request->only(['matakuliah_id', 'jadwal', 'jam_selesai', 'program_id', 'lab_id']);
        $data['jam_selesai'] = $jamSelesai;
        $jadwal->update($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    private function createWeeklySchedules(int $matakuliahId, int $programId, int $labId, Carbon $tanggalAwal, ?string $jamSelesai = null): void
    {
        $taAktif = Ta::where('status', 'aktif')->first();
        if (!$taAktif) {
            throw new \RuntimeException('Tahun Akademik aktif belum disetting');
        }

        if (!$jamSelesai) {
            $jamSelesai = $tanggalAwal->copy()->addMinutes(170)->format('H:i');
        }

        for ($i = 0; $i < 8; $i++) {
            Jadwal::create([
                'matakuliah_id' => $matakuliahId,
                'jadwal' => $tanggalAwal->copy()->addWeeks($i),
                'jam_selesai' => $jamSelesai,
                'program_id' => $programId,
                'lab_id' => $labId,
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
        $jamSelesai = $data['jam_selesai'] ?? null;

        // Convert Excel serial date numbers if applicable
        if (is_numeric($tanggal) && $tanggal > 30000 && $tanggal < 60000) {
            $tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal)->format('Y-m-d');
        }
        if (is_numeric($jam) && $jam < 1) {
            $jam = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($jam)->format('H:i');
        }
        if ($jamSelesai && is_numeric($jamSelesai) && $jamSelesai < 1) {
            $jamSelesai = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($jamSelesai)->format('H:i');
        }

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

        if (!$jamSelesai) {
            $jamSelesai = $tanggalAwal->copy()->addMinutes(170)->format('H:i');
        }

        $this->createWeeklySchedules($matakuliahId, $programId, $labId, $tanggalAwal, $jamSelesai);
    }

    private function mapCsvHeaders(array $header): array
    {
        $map = [];
        foreach ($header as $index => $name) {
            $rawKey = strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $name)));
            if ($rawKey === '') continue;

            if (str_contains($rawKey, 'lab_id')) {
                $map['lab_id'] = $index;
            } elseif (str_contains($rawKey, 'program_id')) {
                $map['program_id'] = $index;
            } elseif (str_contains($rawKey, 'matakuliah_id') || str_contains($rawKey, 'matkul_id')) {
                $map['matakuliah_id'] = $index;
            } elseif (str_contains($rawKey, 'tanggal')) {
                $map['tanggal'] = $index;
            } elseif (str_contains($rawKey, 'selesai')) {
                $map['jam_selesai'] = $index;
            } elseif (str_contains($rawKey, 'jam') || str_contains($rawKey, 'mulai')) {
                if (!isset($map['jam'])) {
                    $map['jam'] = $index;
                }
            } elseif (str_contains($rawKey, 'matakuliah') || str_contains($rawKey, 'matkul')) {
                $map['matakuliah'] = $index;
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