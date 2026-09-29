<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Laboratorium;
use App\Traits\RejectsDeleteWhenUsed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlatController extends Controller
{
    use RejectsDeleteWhenUsed;
    public function index(Request $request)
    {
        $query = Alat::with('labId');

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('alat', 'like', "%{$q}%")
                         ->orWhere('kode', 'like', "%{$q}%")
                         ->orWhere('lokasi_penyimpanan', 'like', "%{$q}%");
            });
        }

        $laboratories = Laboratorium::all();
        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $alat = $query->orderBy('lab_id')->orderBy('kode')->paginate($perPage)->withQueryString();

        return view('alat.index', compact('alat', 'laboratories'));
    }

    public function create()
    {
        $laboratories = Laboratorium::all();
        return view('alat.create', compact('laboratories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alat' => 'required|string|max:255',
            'kode' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:0',
            'lab_id' => 'nullable|exists:laboratorium,id',
            'kondisi' => 'nullable|in:baik,rusak_ringan,rusak_berat',
            'status' => 'nullable|in:tersedia,dipinjam,maintenance',
            'spesifikasi' => 'nullable|string',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
        ]);

        Alat::create([
            'alat' => $request->alat,
            'kode' => $request->kode,
            'jumlah' => $request->jumlah ?? 0,
            'lab_id' => $request->lab_id,
            'kondisi' => $request->kondisi ?? 'baik',
            'status' => $request->status ?? 'tersedia',
            'spesifikasi' => $request->spesifikasi,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
        ]);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        $laboratories = Laboratorium::all();
        return view('alat.edit', compact('alat', 'laboratories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alat' => 'required|string|max:255',
            'kode' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:0',
            'lab_id' => 'nullable|exists:laboratorium,id',
            'kondisi' => 'nullable|in:baik,rusak_ringan,rusak_berat',
            'status' => 'nullable|in:tersedia,dipinjam,maintenance',
            'spesifikasi' => 'nullable|string',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
        ]);

        $alat = Alat::findOrFail($id);
        $alat->update([
            'alat' => $request->alat,
            'kode' => $request->kode,
            'jumlah' => $request->jumlah ?? 0,
            'lab_id' => $request->lab_id,
            'kondisi' => $request->kondisi ?? 'baik',
            'status' => $request->status ?? 'tersedia',
            'spesifikasi' => $request->spesifikasi,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
        ]);

        return redirect()->route('alat.index')->with('success', 'Alat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        if ($response = $this->rejectDeleteIfUsed('alat.index', [
            'peminjaman' => DB::table('pemakaian_alat')->where('alat_id', $alat->id)->count(),
        ])) {
            return $response;
        }

        return $this->deleteOrReject($alat, 'alat.index', 'Alat berhasil dihapus!');
    }

    public function cetakQr($id)
    {
        $alat = Alat::with('labId')->findOrFail($id);
        $alats = collect([$alat]);
        return view('alat.cetak-qr', compact('alats'));
    }

    public function cetakQrBatch(Request $request)
    {
        $query = Alat::with('labId');

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('alat', 'like', "%{$q}%")
                         ->orWhere('kode', 'like', "%{$q}%");
            });
        }

        $alats = $query->orderBy('lab_id')->orderBy('kode')->get();

        return view('alat.cetak-qr', compact('alats'));
    }

    public function downloadTemplate(Request $request)
    {
        return $this->sendImportTemplate($request, 'alat_import_template', 'Template_Import_Alat_SILABO');
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
            'nama' => ['nama_alat', 'alat', 'nama'],
            'jumlah' => ['jumlah', 'qty', 'stok'],
            'kondisi' => ['kondisi'],
            'laboratorium' => ['laboratorium', 'lab', 'nama_lab'],
        ]);

        if (!isset($map['kode'], $map['nama'], $map['jumlah'], $map['laboratorium'])) {
            return redirect()->back()->with('error', 'Header berkas harus memuat kode, nama alat, jumlah, dan laboratorium.');
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
            $kondisiRaw = isset($map['kondisi']) ? trim((string) ($row[$map['kondisi']] ?? '')) : '';
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

            $kondisi = $this->normalizeKondisi($kondisiRaw);
            if ($kondisiRaw !== '' && $kondisi === null) {
                $errors[] = "Baris {$rowNumber} ({$label}): Kondisi harus baik, rusak ringan, atau rusak berat.";
                continue;
            }

            $lab = $this->findLabByName($labs, $labName);
            if (!$lab) {
                $errors[] = "Baris {$rowNumber} ({$label}): Laboratorium '{$labName}' tidak ditemukan.";
                continue;
            }

            $existing = Alat::whereRaw('LOWER(kode) = ?', [mb_strtolower($kode)])->first();
            if ($existing) {
                $existing->update([
                    'jumlah' => (int) $jumlahRaw,
                    'kondisi' => $kondisi ?? $existing->kondisi,
                ]);
                $updated++;
                continue;
            }

            if ($nama === '') {
                $errors[] = "Baris {$rowNumber} ({$label}): Nama alat wajib diisi untuk data baru.";
                continue;
            }

            Alat::create([
                'kode' => $kode,
                'alat' => $nama,
                'jumlah' => (int) $jumlahRaw,
                'lab_id' => $lab->id,
                'kondisi' => $kondisi ?? 'baik',
                'status' => 'tersedia',
            ]);
            $created++;
        }

        return $this->importResult('alat.index', $created, $updated, $errors, 'alat');
    }

    private function normalizeKondisi(string $value): ?string
    {
        $value = mb_strtolower(trim(str_replace(['-', ' '], '_', $value)));
        $value = str_replace('__', '_', $value);
        $map = [
            'baik' => 'baik',
            'rusak_ringan' => 'rusak_ringan',
            'rusakringan' => 'rusak_ringan',
            'rusak_berat' => 'rusak_berat',
            'rusakberat' => 'rusak_berat',
        ];

        return $map[$value] ?? null;
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