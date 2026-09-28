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
}