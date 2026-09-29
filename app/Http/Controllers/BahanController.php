<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Laboratorium;
use App\Traits\RejectsDeleteWhenUsed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahanController extends Controller
{
    use RejectsDeleteWhenUsed;
    public function index(Request $request)
    {
        $query = Bahan::with('labId');

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('status_stok')) {
            $status = $request->status_stok;
            if ($status === 'habis') {
                $query->where('jumlah', '<=', 0);
            } elseif ($status === 'menipis') {
                $query->where('jumlah', '>', 0)
                      ->where('stok_minimum', '>', 0)
                      ->whereColumn('jumlah', '<=', 'stok_minimum');
            } elseif ($status === 'tersedia') {
                $query->where('jumlah', '>', 0)
                      ->where(function ($sub) {
                          $sub->whereColumn('jumlah', '>', 'stok_minimum')
                              ->orWhere('stok_minimum', 0);
                      });
            }
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('bahan', 'like', "%{$q}%")
                         ->orWhere('kode', 'like', "%{$q}%")
                         ->orWhere('lokasi_penyimpanan', 'like', "%{$q}%")
                         ->orWhere('spesifikasi', 'like', "%{$q}%");
            });
        }

        $laboratories = Laboratorium::all();
        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $bahan = $query->orderBy('lab_id')->orderBy('kode')->paginate($perPage)->withQueryString();

        return view('bahan.index', compact('bahan', 'laboratories'));
    }

    public function create()
    {
        $laboratories = Laboratorium::all();
        return view('bahan.create', compact('laboratories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bahan' => 'required|string|max:255',
            'kode' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:0',
            'satuan' => 'nullable|string|max:50',
            'lab_id' => 'nullable|exists:laboratorium,id',
            'stok_minimum' => 'nullable|integer|min:0',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'spesifikasi' => 'nullable|string',
        ]);

        $kode = $request->kode;
        if (empty($kode)) {
            $lastBahan = Bahan::orderBy('id', 'desc')->first();
            $nextNum = $lastBahan ? ($lastBahan->id + 1) : 1;
            $kode = 'BHN-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
        }

        Bahan::create([
            'lab_id' => $request->lab_id,
            'kode' => $kode,
            'bahan' => $request->bahan,
            'jumlah' => $request->jumlah ?? 0,
            'satuan' => $request->satuan ?? 'Pcs',
            'stok_minimum' => $request->stok_minimum ?? 0,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
            'spesifikasi' => $request->spesifikasi,
        ]);

        return redirect()->route('bahan.index')->with('success', 'Bahan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $bahan = Bahan::findOrFail($id);
        $laboratories = Laboratorium::all();
        return view('bahan.edit', compact('bahan', 'laboratories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bahan' => 'required|string|max:255',
            'kode' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:0',
            'satuan' => 'nullable|string|max:50',
            'lab_id' => 'nullable|exists:laboratorium,id',
            'stok_minimum' => 'nullable|integer|min:0',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'spesifikasi' => 'nullable|string',
        ]);

        $bahan = Bahan::findOrFail($id);
        $bahan->update([
            'lab_id' => $request->lab_id,
            'kode' => $request->kode,
            'bahan' => $request->bahan,
            'jumlah' => $request->jumlah ?? 0,
            'satuan' => $request->satuan ?? 'Pcs',
            'stok_minimum' => $request->stok_minimum ?? 0,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
            'spesifikasi' => $request->spesifikasi,
        ]);

        return redirect()->route('bahan.index')->with('success', 'Bahan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);

        if ($response = $this->rejectDeleteIfUsed('bahan.index', [
            'peminjaman' => DB::table('pemakaian_bahan')->where('bahan_id', $bahan->id)->count(),
        ])) {
            return $response;
        }

        return $this->deleteOrReject($bahan, 'bahan.index', 'Bahan berhasil dihapus!');
    }

    public function downloadTemplate(Request $request)
    {
        return $this->sendImportTemplate($request, 'bahan_import_template', 'Template_Import_Bahan_SILABO');
    }

    public function import(Request $request)
    {
        $rows = $this->readImportRows($request);
        if ($rows instanceof \Illuminate\Http\RedirectResponse) {
            return $rows;
        }

        $header = array_shift($rows);
        $map = $this->mapInventoryHeaders($header, [
            'kode' => ['kode'],
            'nama' => ['nama_bahan', 'bahan', 'nama'],
            'jumlah' => ['jumlah', 'qty', 'stok'],
            'satuan' => ['satuan'],
            'laboratorium' => ['laboratorium', 'lab', 'nama_lab'],
        ]);

        if (!isset($map['kode'], $map['nama'], $map['jumlah'], $map['laboratorium'])) {
            return redirect()->back()->with('error', 'Header berkas harus memuat kode, nama bahan, jumlah, dan laboratorium.');
        }

        $labs = Laboratorium::all();
        $rowNumber = 1;
        $created = 0;
        $updated = 0;
        $errors = [];

        foreach ($rows as $row) {
            $rowNumber++;
            if ($this->importRowEmpty($row)) {
                continue;
            }

            $kode = trim((string) ($row[$map['kode']] ?? ''));
            $nama = trim((string) ($row[$map['nama']] ?? ''));
            $jumlahRaw = trim((string) ($row[$map['jumlah']] ?? ''));
            $satuan = isset($map['satuan']) ? trim((string) ($row[$map['satuan']] ?? '')) : '';
            $labName = trim((string) ($row[$map['laboratorium']] ?? ''));
            $label = $kode !== '' ? $kode : ($nama !== '' ? $nama : 'baris ' . $rowNumber);

            if ($kode === '') {
                $errors[] = "Baris {$rowNumber}: Kode wajib diisi.";
                continue;
            }
            if ($jumlahRaw === '' || !is_numeric($jumlahRaw) || (int) $jumlahRaw < 0) {
                $errors[] = "Baris {$rowNumber} ({$label}): Jumlah harus berupa angka.";
                continue;
            }

            $lab = $this->findLabByName($labs, $labName);
            if (!$lab) {
                $errors[] = "Baris {$rowNumber} ({$label}): Laboratorium '{$labName}' tidak ditemukan.";
                continue;
            }

            $existing = Bahan::whereRaw('LOWER(kode) = ?', [mb_strtolower($kode)])->first();
            if ($existing) {
                $existing->update([
                    'jumlah' => (int) $jumlahRaw,
                ]);
                $updated++;
                continue;
            }

            if ($nama === '') {
                $errors[] = "Baris {$rowNumber} ({$label}): Nama bahan wajib diisi untuk data baru.";
                continue;
            }

            Bahan::create([
                'kode' => $kode,
                'bahan' => $nama,
                'jumlah' => (int) $jumlahRaw,
                'satuan' => $satuan !== '' ? $satuan : 'Pcs',
                'lab_id' => $lab->id,
                'stok_minimum' => 0,
            ]);
            $created++;
        }

        return $this->importResult('bahan.index', $created, $updated, $errors, 'bahan');
    }

    private function findLabByName($labs, string $name)
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }
        $needle = mb_strtolower($name);

        return $labs->first(function ($lab) use ($needle) {
            return mb_strtolower(trim((string) $lab->laboratorium)) === $needle;
        });
    }

    private function readImportRows(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|max:10240',
        ]);

        $uploadedFile = $request->file('excel_file');
        $ext = strtolower($uploadedFile->getClientOriginalExtension());
        if (!in_array($ext, ['xlsx', 'xls', 'csv', 'txt'])) {
            return redirect()->back()->with('error', 'Format berkas tidak didukung. Unggah berkas .xlsx, .xls, atau .csv.');
        }

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadedFile->getRealPath());
            $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membaca berkas. Gunakan template Excel atau CSV.');
        }

        if (isset($rows[0][0]) && str_starts_with(strtolower(trim((string) $rows[0][0])), 'sep=')) {
            array_shift($rows);
        }

        if (empty($rows) || count($rows) < 2) {
            return redirect()->back()->with('error', 'Berkas yang diunggah kosong.');
        }

        return $rows;
    }

    private function mapInventoryHeaders(array $header, array $aliases): array
    {
        $map = [];
        foreach ($header as $index => $name) {
            $rawKey = strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $name)));
            $rawKey = str_replace([' ', '-'], '_', $rawKey);
            if ($rawKey === '') {
                continue;
            }
            foreach ($aliases as $field => $names) {
                if (in_array($rawKey, $names, true) && !isset($map[$field])) {
                    $map[$field] = $index;
                }
            }
        }

        return $map;
    }

    private function importRowEmpty(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }

    private function importResult(string $route, int $created, int $updated, array $errors, string $noun)
    {
        if ($created === 0 && $updated === 0 && $errors === []) {
            return redirect()->back()->with('error', 'Tidak ada data valid pada berkas.');
        }

        $message = "Import selesai: {$created} {$noun} ditambahkan, {$updated} {$noun} diperbarui.";
        if ($errors !== []) {
            $message .= ' ' . count($errors) . ' baris gagal.';
        }

        return redirect()->route($route)->with('success', $message)->with('import_errors', $errors);
    }

    private function sendImportTemplate(Request $request, string $basename, string $downloadName)
    {
        $format = strtolower($request->get('format', 'xlsx'));
        if ($format === 'csv') {
            $path = public_path('templates/' . $basename . '.csv');
            if (file_exists($path)) {
                return response()->download($path, $downloadName . '.csv', ['Content-Type' => 'text/csv']);
            }
        }

        $path = public_path('templates/' . $basename . '.xlsx');
        if (file_exists($path)) {
            return response()->download($path, $downloadName . '.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }

        return redirect()->back()->with('error', 'Berkas template belum tersedia.');
    }
}