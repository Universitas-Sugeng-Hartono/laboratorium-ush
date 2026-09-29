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
            'semester' => 'required|integer|min:1|max:8',
            'kelas' => ['nullable', 'regex:/^[A-Za-z]$/'],
        ], [
            'kelas.regex' => 'Kelas harus berupa satu huruf.',
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
                $jamSelesai,
                (int) $request->semester,
                $request->filled('kelas') ? strtoupper($request->kelas) : null
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
            return redirect()->back()->with('error', 'Gagal membaca berkas. Gunakan template Excel atau CSV.');
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
        if (!isset($columnMap['laboratorium'], $columnMap['program'], $columnMap['matakuliah'], $columnMap['semester'], $columnMap['tanggal'], $columnMap['jam'])) {
            return redirect()->back()->with('error', 'Header berkas harus memuat laboratorium, program_studi, mata_kuliah, semester, tanggal, dan jam.');
        }

        $rowNumber = 1;
        $addedRows = 0;
        $skippedRows = 0;
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
                $result = $this->importCsvRow($data);
                if ($result === 'skipped') {
                    $skippedRows++;
                } else {
                    $addedRows++;
                    $createdCount += 8;
                }
            } catch (\InvalidArgumentException $e) {
                $label = $data['matakuliah'] ?? ($data['matakuliah_id'] ?? "baris {$rowNumber}");
                $errors[] = "Baris {$rowNumber} ({$label}): {$e->getMessage()}";
            }
        }

        if ($addedRows === 0 && $skippedRows === 0 && empty($errors)) {
            return redirect()->back()->with('error', 'Tidak ada data valid di file yang diunggah.');
        }

        $message = "Import selesai: {$addedRows} baris ditambahkan ({$createdCount} jadwal), {$skippedRows} baris dilewati karena jadwal sudah ada.";
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
            'semester' => 'sometimes|required|integer|min:1|max:8',
            'kelas' => ['nullable', 'regex:/^[A-Za-z]$/'],
        ], [
            'kelas.regex' => 'Kelas harus berupa satu huruf.',
        ]);

        $jamSelesai = $request->jam_selesai;
        if (!$jamSelesai) {
            $jamSelesai = Carbon::parse($request->jadwal)->addMinutes(170)->format('H:i');
        }

        $data = $request->only(['matakuliah_id', 'jadwal', 'jam_selesai', 'program_id', 'lab_id']);
        $data['jam_selesai'] = $jamSelesai;
        if ($request->exists('semester')) {
            $data['semester'] = (int) $request->semester;
        }
        if ($request->exists('kelas')) {
            $data['kelas'] = $request->filled('kelas') ? strtoupper($request->kelas) : null;
        }
        $jadwal->update($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    private function createWeeklySchedules(int $matakuliahId, int $programId, int $labId, Carbon $tanggalAwal, ?string $jamSelesai = null, ?int $semester = null, ?string $kelas = null): void
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
                'semester' => $semester,
                'kelas' => $kelas,
            ]);
        }
    }

    private function importCsvRow(array $data): string
    {
        $labId = $this->resolveImportId(
            $data['laboratorium'] ?? '',
            '',
            Laboratorium::all(),
            'laboratorium',
            'Laboratorium'
        );
        $programId = $this->resolveImportId(
            $data['program'] ?? '',
            '',
            Program::all(),
            'program',
            'Program studi'
        );
        $tanggal = $data['tanggal'] ?? '';
        $jam = $data['jam'] ?? '';
        $jamSelesai = trim((string) ($data['jam_selesai'] ?? ''));
        $semester = $this->parseSemester($data['semester'] ?? '');
        $kelas = $this->parseKelas($data['kelas'] ?? '');

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

        $taAktif = Ta::where('status', 'aktif')->first();
        $matkulName = trim((string) ($data['matakuliah'] ?? ''));
        if ($matkulName === '') {
            throw new \InvalidArgumentException('Nama mata kuliah wajib diisi');
        }

        $needle = mb_strtolower($matkulName);
        $matkul = Matkul::where('program_id', $programId)
            ->where('ta_id', $taAktif->id)
            ->whereRaw('LOWER(matakuliah) = ?', [$needle])
            ->first();
        if (!$matkul) {
            throw new \InvalidArgumentException("Mata kuliah '{$matkulName}' tidak ditemukan pada program studi dan tahun akademik aktif");
        }

        $matakuliahId = $matkul->id;

        try {
            $tanggalAwal = Carbon::parse($tanggal . ' ' . $jam);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('format tanggal/jam tidak valid');
        }

        if (!$jamSelesai) {
            $jamSelesai = $tanggalAwal->copy()->addMinutes(170)->format('H:i');
        }

        if ($this->scheduleAlreadyExists($matakuliahId, $programId, $labId, $semester, $kelas, $tanggalAwal)) {
            return 'skipped';
        }

        $this->createWeeklySchedules($matakuliahId, $programId, $labId, $tanggalAwal, $jamSelesai, $semester, $kelas);

        return 'created';
    }

    private function resolveImportId(string $name, string $idValue, $records, string $field, string $label): int
    {
        $name = trim($name);
        if ($name !== '') {
            $needle = mb_strtolower($name);
            $match = $records->first(function ($record) use ($needle, $field) {
                return mb_strtolower(trim((string) $record->{$field})) === $needle;
            });
            if (!$match) {
                throw new \InvalidArgumentException("{$label} '{$name}' tidak ditemukan");
            }
            return (int) $match->id;
        }

        if ($idValue !== '' && ctype_digit($idValue)) {
            $match = $records->firstWhere('id', (int) $idValue);
            if (!$match) {
                throw new \InvalidArgumentException("{$label} tidak ditemukan");
            }
            return (int) $match->id;
        }

        throw new \InvalidArgumentException("{$label} wajib diisi");
    }

    private function mapCsvHeaders(array $header): array
    {
        $map = [];
        foreach ($header as $index => $name) {
            $rawKey = strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $name)));
            if ($rawKey === '') continue;

            if ($rawKey === 'lab_id' || str_ends_with($rawKey, 'lab_id')) {
                $map['lab_id'] = $index;
            } elseif (str_contains($rawKey, 'laboratorium') || $rawKey === 'lab') {
                $map['laboratorium'] = $index;
            } elseif ($rawKey === 'program_id' || str_ends_with($rawKey, 'program_id')) {
                $map['program_id'] = $index;
            } elseif (str_contains($rawKey, 'program') || str_contains($rawKey, 'prodi') || str_contains($rawKey, 'jurusan')) {
                $map['program'] = $index;
            } elseif (str_contains($rawKey, 'matakuliah_id') || str_contains($rawKey, 'matkul_id')) {
                $map['matakuliah_id'] = $index;
            } elseif ($rawKey === 'semester') {
                $map['semester'] = $index;
            } elseif ($rawKey === 'kelas') {
                $map['kelas'] = $index;
            } elseif (str_contains($rawKey, 'tanggal')) {
                $map['tanggal'] = $index;
            } elseif (str_contains($rawKey, 'selesai')) {
                $map['jam_selesai'] = $index;
            } elseif (str_contains($rawKey, 'jam') || str_contains($rawKey, 'mulai')) {
                if (!isset($map['jam'])) {
                    $map['jam'] = $index;
                }
            } elseif (str_contains($rawKey, 'matakuliah') || str_contains($rawKey, 'mata_kuliah') || str_contains($rawKey, 'matkul')) {
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

    private function parseSemester(string $value): int
    {
        $value = trim($value);
        if ($value === '' || !is_numeric($value)) {
            throw new \InvalidArgumentException('semester harus angka 1 sampai 8');
        }

        $number = (int) $value;
        if ($number < 1 || $number > 8 || abs((float) $value - $number) > 0.001) {
            throw new \InvalidArgumentException('semester harus angka 1 sampai 8');
        }

        return $number;
    }

    private function parseKelas(string $value): ?string
    {
        $value = trim($value);
        if ($value === '') {
            return null;
        }

        if (!preg_match('/^[A-Za-z]$/', $value)) {
            throw new \InvalidArgumentException('kelas harus satu huruf atau dikosongkan');
        }

        return strtoupper($value);
    }

    private function scheduleAlreadyExists(int $matakuliahId, int $programId, int $labId, int $semester, ?string $kelas, Carbon $tanggalAwal): bool
    {
        $start = $tanggalAwal->copy()->startOfMinute();
        $query = Jadwal::where('matakuliah_id', $matakuliahId)
            ->where('program_id', $programId)
            ->where('lab_id', $labId)
            ->where('semester', $semester)
            ->where('jadwal', '>=', $start->format('Y-m-d H:i:s'))
            ->where('jadwal', '<', $start->copy()->addMinute()->format('Y-m-d H:i:s'));

        if ($kelas === null || $kelas === '') {
            $query->where(function ($q) {
                $q->whereNull('kelas')->orWhere('kelas', '');
            });
        } else {
            $query->whereRaw('UPPER(kelas) = ?', [$kelas]);
        }

        return $query->exists();
    }

}