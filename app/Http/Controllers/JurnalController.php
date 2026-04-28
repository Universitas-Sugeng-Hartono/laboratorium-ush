<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Jadwal;
use App\Models\Program;
use App\Models\Matkul;
use App\Models\Laboratorium;
use App\Models\Ta;
use Illuminate\Support\Facades\Storage;
use App\Exports\JurnalExport;
use Excel;
use PDF;
use Carbon\Carbon;

class JurnalController extends Controller
{
    /**
     * Build filtered jurnal query from request params (shared by index, exportPdf, exportCsv).
     */
    private function buildFilteredQuery(Request $request)
    {
        $query = Jurnal::query();

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
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
        $programs = Program::all();
        $taAktif = Ta::where('status', 'aktif')->first();
        if (!$taAktif) {
            return back()->with('error', 'TA aktif belum disetting.');
        }
        $matkuls = Matkul::where('ta_id', $taAktif->id)->get();

        $query = $this->buildFilteredQuery($request);
        $jurnals = $query->orderBy('tanggal', 'desc')->simplePaginate(10)->appends($request->query());

        return view('jurnal.index', compact('jurnals', 'labs', 'programs', 'matkuls'));
    }


    public function show($id)
    {
        $jurnal = Jurnal::with(['jadwalId', 'programId', 'matkulId', 'labId'])->findOrFail($id);
        return view('jurnal.show', compact('jurnal'));
    }

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $jadwals = Jadwal::all();
        $programs = Program::all();
        $matkuls = Matkul::all();
        $lab = Laboratorium::all();
        return view('jurnal.edit', compact('jurnal', 'jadwals', 'programs', 'matkuls', 'lab'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'materi' => 'nullable|string',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'nullable',
            'jumlah' => 'nullable|integer',
            'ttd' => 'nullable|image|max:2048',
            'lab_id' => 'required',

        ]);

        $jurnal = Jurnal::findOrFail($id);
        $jurnal->update($request->except(['ttd']));

        if ($request->hasFile('ttd')) {
            if ($jurnal->ttd) {
                Storage::delete('public/' . $jurnal->ttd);
            }
            $path = $request->file('ttd')->store('ttd', 'public');
            $jurnal->ttd = $path;
            $jurnal->save();
        }

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui');
    }
    
    public function exportPdfPkh(Request $request)
    {
        $matakuliahIds = $request->matakuliah_id;
    
        $jurnals = Jurnal::with(['matkulId', 'programId'])
            ->when($matakuliahIds, function ($query) use ($matakuliahIds) {
                $query->whereIn('matakuliah_id', $matakuliahIds);
            })
            ->orderBy('tanggal')
            ->get();
    
        $laboratorium = $jurnals->first()?->laboratorium ?? null;
        $program = $jurnals->first()?->programId ?? null;
    
        $today = Carbon::now()->translatedFormat('d F Y');
    
        $pdf = Pdf::loadView('jurnal.exportpdf', [
            'jurnals' => $jurnals,
            'laboratorium' => $laboratorium,
            'program' => $program,
            'today' => $today,
        ])->setPaper('a4', 'landscape');
    
        return $pdf->stream('jurnal-perkuliahan.pdf');
    }

    public function getCsv()
    {
        $datas = Jurnal::all();
        return view('jurnal.getcsv', compact('datas'));
    }

    public function exportCsv(Request $request)
    {
        $nama_file = 'laporan_jurnal.csv';
        return Excel::download(new JurnalExport(
            $request->lab_id,
            $request->program_id,
            $request->tanggal_awal,
            $request->tanggal_akhir
        ), $nama_file);
    }
    
    public function exportPdf(Request $request)
    {
        $query = $this->buildFilteredQuery($request);

        $laboratorium = Laboratorium::find($request->lab_id);
        $program = Program::find($request->program_id);
        $jurnals = $query->orderBy('tanggal')->get();
    
        $pdf = PDF::loadView('jurnal.export-pdf', compact('jurnals', 'laboratorium', 'program'))
                 ->setPaper('a4', 'landscape');
    
        return $pdf->download('jurnal.pdf');
    }

    public function exportPdfNoTtd(Request $request)
    {
        $query = $this->buildFilteredQuery($request);

        $laboratorium = Laboratorium::find($request->lab_id);
        $program = Program::find($request->program_id);
        $jurnals = $query->orderBy('tanggal')->get();

        $pdf = PDF::loadView('jurnal.export-pdf-no-ttd', compact('jurnals', 'laboratorium', 'program'))
                 ->setPaper('a4', 'landscape');

        return $pdf->download('jurnal-tanpa-ttd.pdf');
    }


    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        if ($jurnal->ttd) {
            Storage::delete('public/' . $jurnal->ttd);
        }
        $jurnal->delete();

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil dihapus');
    }
}