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
        $query = Jadwal::query();
    
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
    
        $jadwals = $query->orderBy('jadwal', 'desc')->get();
        return view('jadwal.index', compact('jadwals', 'labs', 'programs'));
    }

    public function create()
    {
        $selectedTaId = Ta::where('status', 'aktif')->value('id');
        $matkuls = Matkul::where('ta_id', $selectedTaId)->orderBy('matakuliah', 'asc')->get();
        $programs = Program::all();
        $lab = Laboratorium::all();
        return view('jadwal.create', compact('matkuls', 'programs', 'lab'));
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
            'program_id' => 'required',
            'lab_id' => 'required',
        ]);
    
        $tanggalAwal = Carbon::parse($request->jadwal);
        $taAktif = Ta::where('status', 'aktif')->first();
    
        if (!$taAktif) {
            return redirect()->back()->with('error', 'Tahun Akademik aktif belum disetting');
        }
        for ($i = 0; $i < 8; $i++) {
            Jadwal::create([
                'matakuliah_id' => $request->matakuliah_id,
                'jadwal' => $tanggalAwal->copy()->addWeeks($i),
                'program_id' => $request->program_id,
                'lab_id' => $request->lab_id,
                'status' => $taAktif->id,
            ]);
        }
        return redirect()->route('jadwal.index')->with('success', 'Jadwal 8 minggu berhasil ditambahkan!');
    }

    public function JadwalLab()
    {
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
        $jadwalHariIni = Jadwal::whereDate('jadwal', Carbon::today())->get();
        return view('jadwal-laboratorium', compact('jadwalHariIni', 'hariIni'));
    }

    public function show(Jadwal $jadwal)
    {
        return view('jadwal.show', compact('jadwal'));
    }

    public function edit(Jadwal $jadwal)
    {
        $matkuls = Matkul::all();
        $programs = Program::all();
        $lab = Laboratorium::all();
        return view('jadwal.edit', compact('jadwal', 'matkuls', 'programs', 'lab'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'matakuliah_id' => 'required',
            'jadwal' => 'required|date',
            'program_id' => 'required',
            'lab_id' => 'required',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }
}