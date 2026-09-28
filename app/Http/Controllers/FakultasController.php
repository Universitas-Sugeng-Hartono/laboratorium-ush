<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\Program;
use App\Traits\RejectsDeleteWhenUsed;
use Illuminate\Http\Request;

class FakultasController extends Controller
{
    use RejectsDeleteWhenUsed;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of faculties.
     */
    public function index(Request $request)
    {
        $query = Fakultas::withCount('programs');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('fakultas', 'like', "%{$q}%")
                    ->orWhere('kode', 'like', "%{$q}%")
                    ->orWhere('dekan', 'like', "%{$q}%");
            });
        }

        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $fakultas = $query->orderBy('kode')->paginate($perPage)->withQueryString();

        return view('fakultas.index', compact('fakultas'));
    }

    /**
     * Show the form for creating a new faculty.
     */
    public function create()
    {
        return view('fakultas.create');
    }

    /**
     * Store a newly created faculty in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode'       => 'required|string|max:20|unique:fakultas,kode',
            'fakultas'   => 'required|string|max:255',
            'dekan'      => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'kode.required'     => 'Kode fakultas wajib diisi.',
            'kode.unique'       => 'Kode fakultas sudah digunakan.',
            'fakultas.required' => 'Nama fakultas wajib diisi.',
        ]);

        Fakultas::create([
            'kode'       => strtoupper(trim($request->kode)),
            'fakultas'   => trim($request->fakultas),
            'dekan'      => $request->dekan ? trim($request->dekan) : null,
            'keterangan' => $request->keterangan ? trim($request->keterangan) : null,
        ]);

        return redirect()->route('fakultas.index')->with('success', 'Data Fakultas berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified faculty.
     */
    public function edit($id)
    {
        $fakultas = Fakultas::findOrFail($id);
        return view('fakultas.edit', compact('fakultas'));
    }

    /**
     * Update the specified faculty in storage.
     */
    public function update(Request $request, $id)
    {
        $item = Fakultas::findOrFail($id);

        $request->validate([
            'kode'       => 'required|string|max:20|unique:fakultas,kode,' . $item->id,
            'fakultas'   => 'required|string|max:255',
            'dekan'      => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'kode.required'     => 'Kode fakultas wajib diisi.',
            'kode.unique'       => 'Kode fakultas sudah digunakan.',
            'fakultas.required' => 'Nama fakultas wajib diisi.',
        ]);

        $item->update([
            'kode'       => strtoupper(trim($request->kode)),
            'fakultas'   => trim($request->fakultas),
            'dekan'      => $request->dekan ? trim($request->dekan) : null,
            'keterangan' => $request->keterangan ? trim($request->keterangan) : null,
        ]);

        return redirect()->route('fakultas.index')->with('success', 'Data Fakultas berhasil diperbarui!');
    }

    /**
     * Remove the specified faculty from storage.
     */
    public function destroy($id)
    {
        $item = Fakultas::findOrFail($id);

        if ($response = $this->rejectDeleteIfUsed('fakultas.index', [
            'program studi' => Program::where('fakultas_id', $item->id)->count(),
        ])) {
            return $response;
        }

        return $this->deleteOrReject($item, 'fakultas.index', 'Data Fakultas berhasil dihapus!');
    }
}
