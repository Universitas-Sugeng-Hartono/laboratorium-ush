<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Fakultas;
use App\Models\Matkul;
use App\Models\Jadwal;
use App\Models\Jurnal;
use App\Models\Pemakaian;
use App\Traits\RejectsDeleteWhenUsed;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    use RejectsDeleteWhenUsed;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Program::with('fakultas');

        if ($request->filled('fakultas_id')) {
            $query->where('fakultas_id', $request->fakultas_id);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('program', 'like', "%{$q}%")
                    ->orWhereHas('fakultas', function ($fq) use ($q) {
                        $fq->where('fakultas', 'like', "%{$q}%")
                           ->orWhere('kode', 'like', "%{$q}%");
                    });
            });
        }

        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $programs = $query->orderBy('program')->paginate($perPage)->withQueryString();
        $fakultas = Fakultas::orderBy('kode')->get();

        return view('program.index', compact('programs', 'fakultas'));
    }

    public function create()
    {
        $fakultas = Fakultas::orderBy('kode')->get();
        return view('program.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program'     => 'required|string|max:255',
            'fakultas_id' => 'nullable|exists:fakultas,id',
        ], [
            'program.required'   => 'Nama program studi wajib diisi.',
            'fakultas_id.exists' => 'Fakultas yang dipilih tidak valid.',
        ]);

        Program::create([
            'program'     => trim($request->program),
            'fakultas_id' => $request->fakultas_id ?: null,
        ]);

        return redirect()->route('program.index')->with('success', 'Data Program Studi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        $fakultas = Fakultas::orderBy('kode')->get();
        return view('program.edit', compact('program', 'fakultas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'program'     => 'required|string|max:255',
            'fakultas_id' => 'nullable|exists:fakultas,id',
        ], [
            'program.required'   => 'Nama program studi wajib diisi.',
            'fakultas_id.exists' => 'Fakultas yang dipilih tidak valid.',
        ]);

        $program = Program::findOrFail($id);
        $program->update([
            'program'     => trim($request->program),
            'fakultas_id' => $request->fakultas_id ?: null,
        ]);

        return redirect()->route('program.index')->with('success', 'Data Program Studi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        if ($response = $this->rejectDeleteIfUsed('program.index', [
            'mata kuliah' => Matkul::where('program_id', $program->id)->count(),
            'jadwal' => Jadwal::where('program_id', $program->id)->count(),
            'jurnal' => Jurnal::where('program_id', $program->id)->count(),
            'peminjaman' => Pemakaian::where('program_id', $program->id)->count(),
        ])) {
            return $response;
        }

        return $this->deleteOrReject($program, 'program.index', 'Data Program Studi berhasil dihapus!');
    }
}