<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{Absensi, Laboratorium};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class AbsensiController extends Controller
{
    /**
     * Build filtered query (shared by index and exportPdf).
     */
    private function buildFilteredQuery(Request $request)
    {
        $query = Absensi::query();

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);
        } elseif ($request->filled('tanggal_awal')) {
            $query->where('tanggal', '>=', $request->tanggal_awal);
        } elseif ($request->filled('tanggal_akhir')) {
            $query->where('tanggal', '<=', $request->tanggal_akhir);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $labs = Laboratorium::all();
        $query = $this->buildFilteredQuery($request);
        $absen = $query->orderBy('tanggal', 'desc')->get();

        return view('absensi.index', compact('absen', 'labs'));
    }

    public function create()
    {
        return view('absensi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ttd' => 'required',
            'keperluan' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'jam' => 'nullable',
            'tamu' => 'nullable',
        ]);

        $ttdPath = null;
        if ($request->ttd) {
            $image = str_replace('data:image/png;base64,', '', $request->ttd);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signature_' . time() . '.png';
            Storage::disk('public')->put('signatures/' . $imageName, base64_decode($image));

            $ttdPath = 'signatures/' . $imageName;
        }

        Absensi::create([
            'keperluan' => $request->keperluan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'tamu' => $request->tamu,
            'ttd' => $ttdPath,
        ]);
        return redirect()->route('absensi.index')->with('success', 'Jurnal berhasil dibuat!');
    }

    public function exportPdf(Request $request)
    {
        $query = $this->buildFilteredQuery($request);

        $laboratorium = Laboratorium::find($request->lab_id);
        $absensi = $query->orderBy('tanggal')->get();
        $pdf = PDF::loadView('absensi.export-pdf', compact('absensi', 'laboratorium'));

        return $pdf->download('tamu.pdf');
    }

    public function edit($id)
    {
        $absen = Absensi::findOrFail($id);
        return view('absensi.edit', compact('absen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ttd' => 'required',
            'keperluan' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'jam' => 'nullable',
            'tamu' => 'nullable',
        ]);

        $absen = Absensi::findOrFail($id);
        $ttdPath = $absen->ttd;

        if ($request->ttd && $request->ttd !== $ttdPath) {
            $image = str_replace('data:image/png;base64,', '', $request->ttd);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signature_' . time() . '.png';
            Storage::disk('public')->put('signatures/' . $imageName, base64_decode($image));
            $ttdPath = 'signatures/' . $imageName;
        }

        $absen->update([
            'keperluan' => $request->keperluan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'tamu' => $request->tamu,
            'ttd' => $ttdPath,
        ]);

        return redirect()->route('absensi.index')->with('success', 'Absensi updated successfully!');
    }

    public function destroy($id)
    {
        $absen = Absensi::findOrFail($id);
        $absen->delete();

        return redirect()->route('absensi.index')->with('success', 'Absensi deleted successfully!');
    }
}