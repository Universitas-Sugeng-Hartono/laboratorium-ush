<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laboratorium;
use App\Models\Jadwal;
use App\Models\Jurnal;
use App\Models\Absensi;
use App\Models\Alat;
use App\Models\Bahan;
use App\Models\Pemakaian;
use App\Traits\RejectsDeleteWhenUsed;
use Illuminate\Http\Request;

class LaboratoriumController extends Controller
{
    use RejectsDeleteWhenUsed;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Laboratorium::query();
        if ($request->filled('q')) {
            $query->where('laboratorium', 'like', "%{$request->q}%");
        }
        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $labo = $query->orderBy('laboratorium')->paginate($perPage)->withQueryString();
        return view('labo.index', compact('labo'));
    }

    public function create()
    {
        return view('labo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'laboratorium' => 'required|string|max:255',
        ]);

        Laboratorium::create(['laboratorium' => $request->laboratorium]);

        return redirect()->route('laboratorium.index')->with('success', 'Laboratorium berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $labo = Laboratorium::findOrFail($id);
        return view('labo.edit', compact('labo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'laboratorium' => 'required|string|max:255',
        ]);

        $labo = Laboratorium::findOrFail($id);
        $labo->update(['laboratorium' => $request->laboratorium]);

        return redirect()->route('laboratorium.index')->with('success', 'Laboratorium berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $labo = Laboratorium::findOrFail($id);

        if ($response = $this->rejectDeleteIfUsed('laboratorium.index', [
            'jadwal' => Jadwal::where('lab_id', $labo->id)->count(),
            'jurnal' => Jurnal::where('lab_id', $labo->id)->count(),
            'presensi' => Absensi::where('lab_id', $labo->id)->count(),
            'alat' => Alat::where('lab_id', $labo->id)->count(),
            'bahan' => Bahan::where('lab_id', $labo->id)->count(),
            'peminjaman' => Pemakaian::where('lab_id', $labo->id)->count(),
        ])) {
            return $response;
        }

        return $this->deleteOrReject($labo, 'laboratorium.index', 'Laboratorium berhasil dihapus.');
    }
}