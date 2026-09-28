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
}