<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matkul;
use App\Models\{Program, Ta, Jadwal, Jurnal, Pemakaian};
use App\Rules\NomorWhatsappRule;
use App\Support\NomorWhatsapp;
use App\Traits\RejectsDeleteWhenUsed;

class MataKuliahController extends Controller
{
    use RejectsDeleteWhenUsed;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $ta = Ta::all();
        $selectedTaId = $request->ta_id ?? Ta::where('status', 'aktif')->value('id');
        $programs = Program::orderBy('program')->get();
        
        $query = Matkul::with(['programId', 'taId']);

        if ($request->filled('ta_id')) {
            $query->where('ta_id', $request->ta_id);
        } elseif ($selectedTaId) {
            $query->where('ta_id', $selectedTaId);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('matakuliah', 'like', "%{$q}%")
                    ->orWhere('dosen', 'like', "%{$q}%")
                    ->orWhere('dosen2', 'like', "%{$q}%");
            });
        }

        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $matkuls = $query->orderBy('matakuliah')->paginate($perPage)->withQueryString();

        return view('matkul.index', compact('matkuls', 'ta', 'selectedTaId', 'programs'));
    }

    public function create()
    {
        $programs = Program::orderBy('program')->get();
        $tas = Ta::orderBy('id', 'desc')->get();
        $taAktif = Ta::where('status', 'aktif')->first();
        return view('matkul.create', compact('programs', 'tas', 'taAktif'));
    }

    public function store(Request $request)
    {
        $taAktif = Ta::where('status', 'aktif')->first();
    
        if (!$taAktif && !$request->filled('ta_id')) {
            return redirect()->back()->with('error', 'Tahun Akademik aktif belum disetting di sistem.');
        }
        
        $validated = $request->validate([
            'matakuliah' => 'required|string|max:255',
            'dosen' => 'required|string|max:255',
            'dosen2' => 'nullable|string|max:255',
            'program_id' => 'required|exists:program,id',
            'nomor' => ['nullable', 'string', 'max:20', new NomorWhatsappRule],
            'nomor2' => ['nullable', 'string', 'max:20', new NomorWhatsappRule],
            'ta_id' => 'nullable|exists:ta,id',
        ]);

        $taId = $request->filled('ta_id') ? $request->ta_id : ($taAktif ? $taAktif->id : null);
        $nomor = NomorWhatsapp::normalize($request->nomor);
        $nomor2 = NomorWhatsapp::normalize($request->nomor2);
        $dosen2 = trim((string) $request->dosen2);

        Matkul::create([
            'matakuliah' => trim($validated['matakuliah']),
            'dosen' => trim($validated['dosen']),
            'dosen2' => $dosen2 !== '' ? $dosen2 : null,
            'program_id' => $validated['program_id'],
            'nomor' => $nomor,
            'nomor2' => $nomor2,
            'ta_id' => $taId,
        ]);

        return redirect()->route('matkul.index')->with('success', 'Mata kuliah berhasil ditambahkan');
    }

    public function edit(Matkul $matkul)
    {
        $programs = Program::orderBy('program')->get();
        $tas = Ta::orderBy('id', 'desc')->get();
        $taAktif = Ta::where('status', 'aktif')->first();
        return view('matkul.edit', compact('matkul', 'programs', 'tas', 'taAktif'));
    }

    public function update(Request $request, Matkul $matkul)
    {
        $validated = $request->validate([
            'matakuliah' => 'required|string|max:255',
            'dosen' => 'required|string|max:255',
            'dosen2' => 'nullable|string|max:255',
            'program_id' => 'required|exists:program,id',
            'nomor' => ['nullable', 'string', 'max:20', new NomorWhatsappRule],
            'nomor2' => ['nullable', 'string', 'max:20', new NomorWhatsappRule],
            'ta_id' => 'nullable|exists:ta,id',
        ]);

        $nomor = NomorWhatsapp::normalize($request->nomor);
        $nomor2 = NomorWhatsapp::normalize($request->nomor2);
        $dosen2 = trim((string) $request->dosen2);

        $matkul->update([
            'matakuliah' => trim($validated['matakuliah']),
            'dosen' => trim($validated['dosen']),
            'dosen2' => $dosen2 !== '' ? $dosen2 : null,
            'program_id' => $validated['program_id'],
            'nomor' => $nomor,
            'nomor2' => $nomor2,
            'ta_id' => $request->filled('ta_id') ? $request->ta_id : $matkul->ta_id,
        ]);

        return redirect()->route('matkul.index')->with('success', 'Mata kuliah berhasil diperbarui');
    }

    public function destroy(Matkul $matkul)
    {
        if ($response = $this->rejectDeleteIfUsed('matkul.index', [
            'jadwal' => Jadwal::where('matakuliah_id', $matkul->id)->count(),
            'jurnal' => Jurnal::where('matakuliah_id', $matkul->id)->count(),
            'peminjaman' => Pemakaian::where('matakuliah_id', $matkul->id)->count(),
        ])) {
            return $response;
        }

        return $this->deleteOrReject($matkul, 'matkul.index', 'Mata kuliah berhasil dihapus');
    }

    public function downloadTemplate(Request $request)
    {
        $format = strtolower($request->get('format', 'xlsx'));
        if ($format === 'csv') {
            $path = public_path('templates/matakuliah_import_template.csv');
            if (file_exists($path)) {
                return response()->download($path, 'Template_Import_Mata_Kuliah_SILABO.csv', [
                    'Content-Type' => 'text/csv',
                ]);
            }
        }

        $path = public_path('templates/matakuliah_import_template.xlsx');
        if (file_exists($path)) {
            return response()->download($path, 'Template_Import_Mata_Kuliah_SILABO.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }

        return redirect()->back()->with('error', 'File template belum tersedia.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|max:10240',
        ]);

        $uploadedFile = $request->file('excel_file');
        $ext = strtolower($uploadedFile->getClientOriginalExtension());
        if (!in_array($ext, ['xlsx', 'xls', 'csv', 'txt'])) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Harap upload file .xlsx, .xls, atau .csv');
        }

        $taAktif = Ta::where('status', 'aktif')->first();
        if (!$taAktif) {
            return redirect()->back()->with('error', 'Tahun Akademik aktif belum disetting di sistem.');
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
        $columnMap = $this->mapImportHeaders($header);

        if (!isset($columnMap['matakuliah'])) {
            return redirect()->back()->with('error', 'Kolom wajib "nama_matakuliah" atau "matakuliah" tidak ditemukan pada baris header file.');
        }
        if (!isset($columnMap['dosen'])) {
            return redirect()->back()->with('error', 'Kolom wajib "nama_dosen" atau "dosen" tidak ditemukan pada baris header file.');
        }
        if (!isset($columnMap['program'])) {
            return redirect()->back()->with('error', 'Kolom wajib "program_studi" atau "program_id" tidak ditemukan pada baris header file.');
        }

        $defaultTaId = $request->filled('default_ta_id') ? $request->default_ta_id : $taAktif->id;
        $programs = Program::all();
        $tas = Ta::all();

        $rowNumber = 1;
        $createdCount = 0;
        $updatedCount = 0;
        $errors = [];

        foreach ($rows as $row) {
            $rowNumber++;

            if ($this->isRowEmpty($row)) {
                continue;
            }

            $matakuliah = isset($columnMap['matakuliah'], $row[$columnMap['matakuliah']]) ? trim((string)$row[$columnMap['matakuliah']]) : '';
            $dosen = isset($columnMap['dosen'], $row[$columnMap['dosen']]) ? trim((string)$row[$columnMap['dosen']]) : '';
            $dosen2 = isset($columnMap['dosen2'], $row[$columnMap['dosen2']]) ? trim((string)$row[$columnMap['dosen2']]) : '';
            $programVal = isset($columnMap['program'], $row[$columnMap['program']]) ? trim((string)$row[$columnMap['program']]) : '';
            $nomor = isset($columnMap['nomor'], $row[$columnMap['nomor']]) ? trim((string)$row[$columnMap['nomor']]) : null;
            $nomor2 = isset($columnMap['nomor2'], $row[$columnMap['nomor2']]) ? trim((string)$row[$columnMap['nomor2']]) : null;
            $taVal = isset($columnMap['ta'], $row[$columnMap['ta']]) ? trim((string)$row[$columnMap['ta']]) : '';

            // Skip template subtitle row if user didn't delete it (e.g. contains "(Wajib)")
            if (str_contains(strtolower($matakuliah), '(wajib)') || str_contains(strtolower($dosen), '(wajib)')) {
                continue;
            }

            if ($matakuliah === '') {
                $errors[] = "Baris {$rowNumber}: Nama mata kuliah tidak boleh kosong.";
                continue;
            }

            if ($dosen === '') {
                $errors[] = "Baris {$rowNumber} ({$matakuliah}): Nama dosen pengampu tidak boleh kosong.";
                continue;
            }

            if ($programVal === '') {
                $errors[] = "Baris {$rowNumber} ({$matakuliah}): Program studi tidak boleh kosong.";
                continue;
            }

            // Resolve Program Studi
            $programId = null;
            if (is_numeric($programVal)) {
                $progMatch = $programs->firstWhere('id', (int)$programVal);
                if ($progMatch) {
                    $programId = $progMatch->id;
                }
            }
            if (!$programId) {
                $cleanProgName = strtolower(trim($programVal));
                $progMatch = $programs->first(function ($p) use ($cleanProgName) {
                    $name = strtolower(trim($p->program));
                    return $name === $cleanProgName
                        || str_contains($name, $cleanProgName)
                        || str_contains($cleanProgName, $name);
                });
                if ($progMatch) {
                    $programId = $progMatch->id;
                }
            }

            if (!$programId) {
                $errors[] = "Baris {$rowNumber} ({$matakuliah}): Program studi '{$programVal}' tidak ditemukan di sistem.";
                continue;
            }

            // Resolve Tahun Ajaran
            $taId = $defaultTaId;
            if ($taVal !== '') {
                if (is_numeric($taVal)) {
                    $taMatch = $tas->firstWhere('id', (int)$taVal);
                    if ($taMatch) {
                        $taId = $taMatch->id;
                    }
                } else {
                    $cleanTaName = strtolower(trim($taVal));
                    $taMatch = $tas->first(function ($t) use ($cleanTaName) {
                        $name = strtolower(trim($t->ta));
                        return $name === $cleanTaName || str_contains($name, $cleanTaName);
                    });
                    if ($taMatch) {
                        $taId = $taMatch->id;
                    }
                }
            }

            try {
                $nomor = $this->normalizeImportNomor($nomor);
                $nomor2 = $this->normalizeImportNomor($nomor2);
            } catch (\InvalidArgumentException $e) {
                $errors[] = "Baris {$rowNumber} ({$matakuliah}): {$e->getMessage()}";
                continue;
            }

            // Check existing record in same Program and TA
            $existing = Matkul::where('program_id', $programId)
                ->where('ta_id', $taId)
                ->whereRaw('LOWER(matakuliah) = ?', [mb_strtolower($matakuliah)])
                ->first();

            if ($existing) {
                $payload = [
                    'matakuliah' => $matakuliah,
                    'dosen' => $dosen,
                    'nomor' => $nomor ?: $existing->nomor,
                ];
                if ($dosen2 !== '') {
                    $payload['dosen2'] = $dosen2;
                }
                if ($nomor2) {
                    $payload['nomor2'] = $nomor2;
                }
                $existing->update($payload);
                $updatedCount++;
            } else {
                Matkul::create([
                    'matakuliah' => $matakuliah,
                    'dosen' => $dosen,
                    'dosen2' => $dosen2 !== '' ? $dosen2 : null,
                    'program_id' => $programId,
                    'nomor' => $nomor,
                    'nomor2' => $nomor2,
                    'ta_id' => $taId,
                ]);
                $createdCount++;
            }
        }

        $totalProcessed = $createdCount + $updatedCount;
        if ($totalProcessed === 0 && empty($errors)) {
            return redirect()->back()->with('error', 'Tidak ada data valid yang ditemukan pada file.');
        }

        $message = "Import selesai: {$createdCount} mata kuliah baru ditambahkan";
        if ($updatedCount > 0) {
            $message .= ", {$updatedCount} mata kuliah diperbarui";
        }
        $message .= '.';

        if (!empty($errors)) {
            $message .= ' (' . count($errors) . ' baris dilewati karena format tidak sesuai).';
        }

        return redirect()
            ->route('matkul.index')
            ->with('success', $message)
            ->with('import_errors', $errors);
    }

    private function mapImportHeaders(array $header): array
    {
        $map = [];
        foreach ($header as $index => $name) {
            $rawKey = strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $name)));
            if ($rawKey === '') continue;

            $kedua = str_contains($rawKey, '2') || str_contains($rawKey, 'kedua');

            if (str_contains($rawKey, 'matakuliah') || str_contains($rawKey, 'mata_kuliah') || str_contains($rawKey, 'nama_mk') || $rawKey === 'mk') {
                $map['matakuliah'] = $index;
            } elseif ($kedua && (str_contains($rawKey, 'dosen') || str_contains($rawKey, 'pengampu'))) {
                $map['dosen2'] = $index;
            } elseif (str_contains($rawKey, 'dosen') || str_contains($rawKey, 'pengampu')) {
                $map['dosen'] = $index;
            } elseif (str_contains($rawKey, 'program') || str_contains($rawKey, 'prodi') || str_contains($rawKey, 'jurusan')) {
                $map['program'] = $index;
            } elseif ($kedua && (str_contains($rawKey, 'nomor') || str_contains($rawKey, 'hp') || str_contains($rawKey, 'wa') || str_contains($rawKey, 'telepon'))) {
                $map['nomor2'] = $index;
            } elseif (str_contains($rawKey, 'nomor') || str_contains($rawKey, 'hp') || str_contains($rawKey, 'wa') || str_contains($rawKey, 'telepon')) {
                $map['nomor'] = $index;
            } elseif (str_contains($rawKey, 'tahun') || str_contains($rawKey, 'ta') || str_contains($rawKey, 'akademik')) {
                $map['ta'] = $index;
            }
        }
        return $map;
    }

    private function normalizeImportNomor($nomor): ?string
    {
        if ($nomor === null || trim((string) $nomor) === '') {
            return null;
        }

        if (is_numeric($nomor) && preg_match('/e/i', (string) $nomor)) {
            $nomor = number_format((float) $nomor, 0, '', '');
        }

        return NomorWhatsapp::normalize((string) $nomor);
    }

    private function isRowEmpty(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }
        return true;
    }
}
