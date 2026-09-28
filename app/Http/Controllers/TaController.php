<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ta;
use App\Models\Matkul;
use App\Traits\RejectsDeleteWhenUsed;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaController extends Controller
{
    use RejectsDeleteWhenUsed;
    public function index()
    {
        $ta = Ta::orderBy('id', 'desc')->get();
        $taAktif = Ta::where('status', 'aktif')->first();
        $totalTa = $ta->count();
        $totalGanjil = Ta::where('ta', 'LIKE', '%Ganjil%')->count();
        $totalGenap = Ta::where('ta', 'LIKE', '%Genap%')->count();
        $dates = Carbon::now();

        return view('ta.index', compact('ta', 'taAktif', 'totalTa', 'totalGanjil', 'totalGenap', 'dates'));
    }
    
    public function generateTA()
    {
        Ta::where('status', 'aktif')->update(['status' => 'non-aktif']);
        $lastTA = Ta::orderByDesc('id')->first();

        if (!$lastTA) {
            $startYear = now()->year;
            $nextSemester = 'Ganjil';
        } else {
            if (preg_match('/(\d{4})\/(\d{4}) (Ganjil|Genap)/i', $lastTA->ta, $matches)) {
                $tahun1 = (int)$matches[1];
                $tahun2 = (int)$matches[2];
                $semester = ucfirst(strtolower($matches[3]));
        
                if ($semester === 'Ganjil') {
                    $startYear = $tahun1;
                    $nextSemester = 'Genap';
                } else {
                    $startYear = $tahun2;
                    $nextSemester = 'Ganjil';
                }
            } else {
                $startYear = now()->year;
                $nextSemester = 'Ganjil';
            }
        }
    
        $nextYear = $startYear + 1;
        $newTA = "$startYear/$nextYear $nextSemester";
        Ta::create([
            'ta' => $newTA,
            'status' => 'aktif',
        ]);
    
        return redirect()->route('ta.index')->with('success', "Tahun Akademik $newTA berhasil digenerate dan diaktifkan!");
    }

    public function create()
    {
        return view('ta.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ta' => 'required|string|max:100',
            'status' => 'required|in:aktif,non-aktif',
        ], [
            'ta.required' => 'Format Tahun Akademik wajib diisi (contoh: 2024/2025 Ganjil).',
            'status.required' => 'Status aktif/non-aktif wajib dipilih.',
        ]);

        if ($request->status == 'aktif') {
            Ta::where('status', 'aktif')->update(['status' => 'non-aktif']);
        }
    
        Ta::create([
            'ta' => $request->ta,
            'status' => $request->status,
        ]);

        return redirect()->route('ta.index')->with('success', 'Tahun Akademik berhasil ditambahkan!');
    }
    
    public function show($id)
    {
        return redirect()->route('ta.index');
    }

    public function edit($id)
    {
        $ta = Ta::findOrFail($id);
        return view('ta.edit', compact('ta'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ta' => 'required|string|max:100',
            'status' => 'required|in:aktif,non-aktif',
        ], [
            'ta.required' => 'Format Tahun Akademik wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        if ($request->status == 'aktif') {
            Ta::where('id', '!=', $id)->where('status', 'aktif')->update(['status' => 'non-aktif']);
        }
    
        $ta = Ta::findOrFail($id);
        $ta->update([
            'ta' => $request->ta,
            'status' => $request->status,
        ]);
    
        return redirect()->route('ta.index')->with('success', 'Tahun Akademik berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ta = Ta::findOrFail($id);

        if ($response = $this->rejectDeleteIfUsed('ta.index', [
            'mata kuliah' => Matkul::where('ta_id', $ta->id)->count(),
        ])) {
            return $response;
        }

        return $this->deleteOrReject($ta, 'ta.index', 'Tahun Akademik berhasil dihapus!');
    }
}