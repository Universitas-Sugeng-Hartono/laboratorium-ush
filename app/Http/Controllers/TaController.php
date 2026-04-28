<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaController extends Controller
{
    public function index()
    {
        $ta = Ta::all();
        $dates = Carbon::now();
        return view('ta.index', compact('ta', 'dates'));
    }
    
    public function generateTA()
    {
        Ta::where('status', 'aktif')->update(['status' => 'non-aktif']);
        $lastTA = Ta::orderByDesc('id')->first();

        if (!$lastTA) {
            $startYear = now()->year;
            $nextSemester = 'Ganjil';
        } else {
            preg_match('/(\d{4})\/(\d{4}) (Ganjil|Genap)/', $lastTA->ta, $matches);
            $tahun1 = (int)$matches[1];
            $tahun2 = (int)$matches[2];
            $semester = $matches[3];
    
            if ($semester === 'Ganjil') {
                $startYear = $tahun1;
                $nextSemester = 'Genap';
            } else {
                $startYear = $tahun2;
                $nextSemester = 'Ganjil';
            }
        }
    
        $nextYear = $startYear + 1;
        $newTA = "$startYear/$nextYear $nextSemester";
        Ta::create([
            'ta' => $newTA,
            'status' => 'aktif',
        ]);
    
        return redirect()->route('ta.index')->with('success', "TA $newTA berhasil dibuat dan diaktifkan!");
    }

    public function create()
    {
        return view('ta.create');
    }

    public function store(Request $request)
    {
        if ($request->status == 'aktif') {
            Ta::where('status', 'aktif')->update(['status' => 'non-aktif']);
        }
    
        Ta::create($request->all());
        return redirect()->route('ta.index')->with('success', 'TA created successfully!');
    }
    
    public function show($id)
    {
    }

    public function edit($id)
    {
        $ta = Ta::findOrFail($id);
        return view('ta.edit', compact('ta'));
    }

    public function update(Request $request, $id)
    {
        if ($request->status == 'aktif') {
            Ta::where('status', 'aktif')->update(['status' => 'non-aktif']);
        }
    
        $ta = Ta::findOrFail($id);
        $ta->update($request->all());
    
        return redirect()->route('ta.index')->with('success', 'TA updated successfully!');
    }

    public function destroy($id)
    {
        $ta = Ta::findOrFail($id);
        $ta->delete();

        return redirect()->route('ta.index')->with('success', 'TA deleted successfully!');
    }
}