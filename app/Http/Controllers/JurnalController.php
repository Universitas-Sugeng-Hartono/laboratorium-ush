<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Jadwal;
use App\Models\Program;
use App\Models\Matkul;
use App\Models\Laboratorium;
use App\Models\Ta;
use App\Models\Absensi;
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
        $matkuls = $taAktif
            ? Matkul::where('ta_id', $taAktif->id)->get()
            : collect();
        $peringatanTa = $taAktif
            ? null
            : 'Tahun akademik aktif belum diatur. Daftar jurnal tetap ditampilkan, filter mata kuliah menunggu TA aktif.';

        $query = $this->buildFilteredQuery($request)->with(['labId', 'matkulId', 'programId']);
        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $jurnals = $query->orderBy('tanggal', 'desc')->paginate($perPage)->appends($request->query());

        return view('jurnal.index', compact('jurnals', 'labs', 'programs', 'matkuls', 'peringatanTa'));
    }


    public function create(Request $request)
    {
        $taAktif = Ta::where('status', 'aktif')->first();
        $selectedTaId = $taAktif ? $taAktif->id : null;

        $matkuls = Matkul::when($selectedTaId, function($q) use ($selectedTaId) {
            $q->where('ta_id', $selectedTaId);
        })->orderBy('matakuliah', 'asc')->get();

        $labs = Laboratorium::orderBy('laboratorium', 'asc')->get();
        $programs = Program::orderBy('program', 'asc')->get();

        $peringatanTa = Ta::pesanJikaTidakAktif();
        $jadwals = Jadwal::with(['matkulId', 'labId', 'programId'])
            ->padaTaAktif()
            ->orderBy('jadwal', 'desc')
            ->take(150)
            ->get();

        $selectedJadwal = null;
        if ($request->filled('jadwal_id')) {
            $selectedJadwal = Jadwal::with(['matkulId', 'labId', 'programId'])
                ->padaTaAktif()
                ->find($request->jadwal_id);
        }

        return view('jurnal.create', compact('matkuls', 'labs', 'programs', 'jadwals', 'selectedJadwal', 'taAktif', 'peringatanTa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'program_id' => 'required|exists:program,id',
            'lab_id' => 'required|exists:laboratorium,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'nullable',
            'materi' => 'nullable|string',
            'jumlah' => 'nullable|integer|min:0',
            'jadwal_id' => 'nullable|exists:jadwal,id',
            'ttd' => 'nullable|image|max:2048',
            'ttd_signature' => 'nullable|string',
        ]);

        $jadwalId = $request->jadwal_id;
        if ($jadwalId && !Jadwal::padaTaAktif()->where('id', $jadwalId)->exists()) {
            $pesan = Ta::pesanJikaTidakAktif() ?? 'Jadwal yang dipilih bukan bagian dari tahun akademik aktif.';
            return redirect()->back()->withInput()->withErrors(['jadwal_id' => $pesan]);
        }
        if (!$jadwalId) {
            $jadwal = Jadwal::create([
                'matakuliah_id' => $request->matakuliah_id,
                'program_id' => $request->program_id,
                'lab_id' => $request->lab_id,
                'jadwal' => Carbon::parse($request->tanggal . ' ' . $request->jam_mulai),
            ]);
            $jadwalId = $jadwal->id;
        }

        $ttdPath = null;
        if ($request->hasFile('ttd')) {
            $ttdPath = $request->file('ttd')->store('ttd', 'public');
        } elseif ($request->filled('ttd_signature')) {
            $image = str_replace('data:image/png;base64,', '', $request->ttd_signature);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signature_' . time() . '.png';
            Storage::disk('public')->put('signatures/' . $imageName, base64_decode($image));
            $ttdPath = 'signatures/' . $imageName;
        }

        $jamSelesai = $request->jam_selesai;
        if (!$jamSelesai) {
            $jamSelesai = Carbon::parse($request->jam_mulai)->addMinutes(170)->format('H:i');
        }

        $jurnal = Jurnal::create([
            'matakuliah_id' => $request->matakuliah_id,
            'program_id' => $request->program_id,
            'jadwal_id' => $jadwalId,
            'lab_id' => $request->lab_id,
            'materi' => $request->materi,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $jamSelesai,
            'ttd' => $ttdPath,
            'jumlah' => $request->jumlah ?? 0,
        ]);

        if ($jurnal->matkulId && $jurnal->matkulId->dosen) {
            Absensi::create([
                'tamu' => $jurnal->matkulId->dosen,
                'tanggal' => $jurnal->tanggal,
                'jam' => $jurnal->jam_mulai,
                'keperluan' => 'Praktikum - ' . $jurnal->matkulId->matakuliah,
                'ttd' => $jurnal->ttd,
                'lab_id' => $jurnal->lab_id,
            ]);
        }

        return redirect()->route('jurnal.index')->with('success', 'Jurnal praktikum berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jurnal = Jurnal::with(['jadwalId', 'programId', 'matkulId', 'labId'])->findOrFail($id);
        return view('jurnal.show', compact('jurnal'));
    }

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $jadwals = Jadwal::padaTaAktif()->orderBy('jadwal', 'desc')->get();
        if ($jurnal->jadwal_id && !$jadwals->contains('id', $jurnal->jadwal_id)) {
            $current = Jadwal::find($jurnal->jadwal_id);
            if ($current) {
                $jadwals->prepend($current);
            }
        }
        $programs = Program::all();
        $matkuls = Matkul::all();
        $lab = Laboratorium::all();
        return view('jurnal.edit', compact('jurnal', 'jadwals', 'programs', 'matkuls', 'lab'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'matakuliah_id' => 'nullable|exists:matakuliah,id',
            'program_id' => 'nullable|exists:program,id',
            'materi' => 'nullable|string',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'nullable',
            'jumlah' => 'nullable|integer',
            'ttd' => 'nullable|image|max:2048',
            'ttd_signature' => 'nullable|string',
            'lab_id' => 'required',
        ]);

        $jurnal = Jurnal::findOrFail($id);
        $jurnal->update($request->except(['ttd', 'ttd_signature']));

        if ($request->hasFile('ttd')) {
            if ($jurnal->ttd) {
                Storage::delete('public/' . $jurnal->ttd);
            }
            $path = $request->file('ttd')->store('ttd', 'public');
            $jurnal->ttd = $path;
            $jurnal->save();
        } elseif ($request->filled('ttd_signature')) {
            if ($jurnal->ttd) {
                Storage::delete('public/' . $jurnal->ttd);
            }
            $image = str_replace('data:image/png;base64,', '', $request->ttd_signature);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signature_' . time() . '.png';
            Storage::disk('public')->put('signatures/' . $imageName, base64_decode($image));
            $jurnal->ttd = 'signatures/' . $imageName;
            $jurnal->save();
        }

        return redirect()->route('jurnal.index')->with('success', 'Jurnal berhasil diperbarui');
    }
    
    public function exportPdfPkh(Request $request)
    {
        $matakuliahIds = $request->matakuliah_id;
    
        $jurnals = Jurnal::with(['matkulId', 'programId', 'labId'])
            ->when($matakuliahIds, function ($query) use ($matakuliahIds) {
                $query->whereIn('matakuliah_id', $matakuliahIds);
            })
            ->orderBy('tanggal')
            ->get();

        $laboratorium = $jurnals->first()?->labId;
        $program = $jurnals->first()?->programId;
    
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