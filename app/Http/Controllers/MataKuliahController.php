<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matkul;
use App\Models\{Program, Ta};

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $ta = Ta::all();
        $selectedTaId = $request->ta_id ?? Ta::where('status', 'aktif')->value('id');
        if (!$selectedTaId) {
            return back()->with('error', 'TA aktif belum disetting dan tidak ada pilihan TA.');
        }
        $matkuls = Matkul::where('ta_id', $selectedTaId)->get();
        return view('matkul.index', compact('matkuls', 'ta', 'selectedTaId'));
    }

    public function create()
    {
        $programs = Program::all();
        return view('matkul.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $taAktif = Ta::where('status', 'aktif')->first();
    
        if (!$taAktif) {
            return redirect()->back()->with('error', 'Tahun Akademik aktif belum disetting');
        }
        
        $validated = $request->validate([
            'matakuliah' => 'required|string|max:255',
            'dosen' => 'required|string|max:255',
            'program_id' => 'required|exists:program,id',
            'nomor' => 'nullable',
        ]);

        Matkul::create(array_merge($validated, ['ta_id' => $taAktif->id]));

        return redirect()->route('matkul.index')->with('success', 'Mata kuliah berhasil ditambahkan');
    }

    public function edit(Matkul $matkul)
    {
        $programs = Program::all();
        return view('matkul.edit', compact('matkul', 'programs'));
    }

    public function update(Request $request, Matkul $matkul)
    {
        $request->validate([
            'matakuliah' => 'required|string|max:255',
            'dosen' => 'required|string|max:255',
            'program_id' => 'required|exists:program,id',
            'nomor' => 'nullable',
        ]);

        $matkul->update($request->all());

        return redirect()->route('matkul.index')->with('success', 'Mata kuliah berhasil diperbarui');
    }

    public function destroy(Matkul $matkul)
    {
        $matkul->delete();
        return redirect()->route('matkul.index')->with('success', 'Mata kuliah berhasil dihapus');
    }
}
