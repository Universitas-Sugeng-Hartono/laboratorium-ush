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
        $query = $this->buildFilteredQuery($request)->with('labId');
        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $absen = $query->orderBy('tanggal', 'desc')->paginate($perPage)->appends($request->query());

        return view('absensi.index', compact('absen', 'labs'));
    }

    public function create()
    {
        $labs = Laboratorium::all();
        return view('absensi.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tamu' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'lab_id' => 'required|exists:laboratorium,id',
            'ttd' => 'required',
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
            'tamu' => $request->tamu,
            'kategori_tamu' => $request->kategori_tamu ?? 'Umum / Tamu',
            'identitas' => $request->identitas,
            'instansi' => $request->instansi,
            'hp' => $request->hp,
            'jumlah_tamu' => $request->jumlah_tamu ?? 1,
            'kategori_keperluan' => $request->kategori_keperluan ?? 'Umum',
            'keperluan' => $request->keperluan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'jamselesai' => $request->jamselesai,
            'lab_id' => $request->lab_id,
            'ttd' => $ttdPath,
        ]);

        return redirect()->route('absensi.index')->with('success', 'Data kunjungan tamu berhasil dicatat!');
    }

    public function exportPdf(Request $request)
    {
        $query = $this->buildFilteredQuery($request);

        $laboratorium = Laboratorium::find($request->lab_id);
        $absensi = $query->orderBy('tanggal')->get();
        $pdf = PDF::loadView('absensi.export-pdf', compact('absensi', 'laboratorium'));

        return $pdf->download('tamu.pdf');
    }

    public function show($id)
    {
        $absen = Absensi::with('labId')->findOrFail($id);
        return view('absensi.show', compact('absen'));
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
            'tamu' => $request->tamu,
            'kategori_tamu' => $request->kategori_tamu ?? $absen->kategori_tamu,
            'identitas' => $request->identitas ?? $absen->identitas,
            'instansi' => $request->instansi ?? $absen->instansi,
            'hp' => $request->hp ?? $absen->hp,
            'jumlah_tamu' => $request->jumlah_tamu ?? $absen->jumlah_tamu,
            'kategori_keperluan' => $request->kategori_keperluan ?? $absen->kategori_keperluan,
            'keperluan' => $request->keperluan,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'jamselesai' => $request->jamselesai ?? $absen->jamselesai,
            'lab_id' => $request->lab_id ?? $absen->lab_id,
            'ttd' => $ttdPath,
        ]);

        return redirect()->route('absensi.index')->with('success', 'Data kunjungan tamu berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $absen = Absensi::findOrFail($id);
        $absen->delete();

        return redirect()->route('absensi.index')->with('success', 'Data kunjungan tamu berhasil dihapus.');
    }
}