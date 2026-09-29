<?php

namespace App\Http\Controllers;

use App\Models\Pemakaian;
use App\Models\Jadwal;
use App\Models\Program;
use App\Models\Matkul;
use App\Models\Laboratorium;
use App\Models\User;
use App\Models\Alat;
use App\Models\Bahan;
use App\Rules\NomorWhatsappRule;
use App\Services\FonnteClient;
use App\Support\NomorWhatsapp;
use App\Http\Controllers\HalamanController;
use Illuminate\Http\Request;
use PDF;
use DB;


class PemakaianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemakaian::with(['jadwalId', 'programId', 'matkulId', 'labId', 'pemakaianAlat', 'pemakaianBahan'])
        ->orderByRaw('ISNULL(status_pengembalian) DESC')
        ->orderByRaw('ISNULL(keterangan) DESC')
        ->orderBy('status_pengembalian');

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tgl_peminjaman', [$request->tanggal_awal, $request->tanggal_akhir]);
        } elseif ($request->filled('tanggal_awal')) {
            $query->where('tgl_peminjaman', '>=', $request->tanggal_awal);
        } elseif ($request->filled('tanggal_akhir')) {
            $query->where('tgl_peminjaman', '<=', $request->tanggal_akhir);
        }

        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $pemakaian = $query->paginate($perPage)->appends($request->query());
        $laboratories = Laboratorium::all();

        return view('pemakaian.index', compact('pemakaian', 'laboratories'));
    }

    public function create()
    {
        $programs = Program::select('id', 'program')->orderBy('program', 'asc')->get();
        $matkul = Matkul::select('id', 'matakuliah', 'program_id')->orderBy('matakuliah', 'asc')->get();
        $laboratorium = Laboratorium::orderBy('laboratorium', 'asc')->get();
        $bahans = Bahan::select('id', 'lab_id', 'bahan', 'jumlah', 'satuan')->orderBy('bahan', 'asc')->get();
        $alats = Alat::select('id', 'lab_id', 'alat', 'jumlah', 'kondisi', 'status')->orderBy('alat', 'asc')->get();

        return view('peminjaman', compact('laboratorium', 'programs', 'matkul', 'bahans', 'alats'));
    }

    public function store(Request $request)
    {
        return app(HalamanController::class)->storePeminjaman($request);
    }

    public function storePemakaian($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $pemakaian = Pemakaian::where('id', $id)->lockForUpdate()->firstOrFail();

                if ($pemakaian->keterangan !== 'setuju') {
                    throw new \RuntimeException('Pengembalian hanya bisa dilakukan setelah peminjaman disetujui.');
                }

                if ($pemakaian->status_pengembalian === 'sudah') {
                    throw new \RuntimeException('Barang pada peminjaman ini sudah dikembalikan.');
                }

                $pemakaian->restoreAlatStock();
                $pemakaian->status_pengembalian = 'sudah';
                $pemakaian->save();
            });
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Alat berhasil dikembalikan. Stok bahan habis pakai tidak dikembalikan.');
    }

    public function edit($id)
    {
        $pemakaian = Pemakaian::findOrFail($id);
        $laboratorium = Laboratorium::orderBy('laboratorium')->get();
        $programs = Program::orderBy('program')->get();
        $matkuls = Matkul::orderBy('matakuliah')->get();

        return view('pemakaian.edit', compact('pemakaian', 'laboratorium', 'programs', 'matkuls'));
    }

    public function show($id)
    {
        $pemakaian = Pemakaian::findOrFail($id);
        $jadwals = Jadwal::all();
        $programs = Program::all();
        $matkuls = Matkul::all();
        $lab = Laboratorium::all();
        $user = User::all();
    
        $alats = DB::table('pemakaian_alat')
            ->join('alat', 'alat.id', '=', 'pemakaian_alat.alat_id')
            ->where('pemakaian_id', $id)
            ->select('alat.alat', 'pemakaian_alat.jumlah_pinjam')
            ->get();
    
        $bahans = DB::table('pemakaian_bahan')
            ->join('bahan', 'bahan.id', '=', 'pemakaian_bahan.bahan_id')
            ->where('pemakaian_id', $id)
            ->select('bahan.bahan', 'pemakaian_bahan.jumlah_pakai')
            ->get();
    
        return view('pemakaian.show', compact('pemakaian', 'jadwals', 'programs', 'matkuls', 'lab', 'user', 'alats', 'bahans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keperluan' => 'required|string',
            'nomor' => ['nullable', 'string', 'max:20', new NomorWhatsappRule],
        ]);

        $data = $request->only([
            'admin_id', 'keterangan', 'matakuliah_id', 'jadwal_id', 'program_id',
            'keperluan', 'tgl_peminjaman', 'tgl_pengembalian', 'alat_id', 'bahan_id',
            'ttd', 'nama', 'lab_id', 'nomor', 'status_pengembalian',
        ]);
        if (isset($data['alat_id']) && is_string($data['alat_id'])) {
            $data['alat_id'] = json_decode($data['alat_id'], true) ?? [];
        }
        if (isset($data['bahan_id']) && is_string($data['bahan_id'])) {
            $data['bahan_id'] = json_decode($data['bahan_id'], true) ?? [];
        }

        unset($data['status_pengembalian']);
        if (array_key_exists('nomor', $data)) {
            $data['nomor'] = NomorWhatsapp::normalize($data['nomor']);
        }

        try {
            DB::transaction(function () use ($id, $data) {
                $pemakaian = Pemakaian::where('id', $id)->lockForUpdate()->firstOrFail();
                $newStatus = array_key_exists('keterangan', $data) ? $data['keterangan'] : $pemakaian->keterangan;
                $wasHeld = $pemakaian->stockIsHeld();
                $willHold = $newStatus === 'setuju' && $pemakaian->status_pengembalian !== 'sudah';

                if (!$wasHeld && $willHold) {
                    $pemakaian->deductStock();
                } elseif ($wasHeld && !$willHold) {
                    $pemakaian->restoreHeldStock();
                }

                $pemakaian->update($data);
            });
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('pemakaian.index')->with('success', 'Data pemakaian berhasil diperbarui');
    }

    /**
     * Menghapus data pemakaian
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $pemakaian = Pemakaian::where('id', $id)->lockForUpdate()->firstOrFail();

                if ($pemakaian->stockIsHeld()) {
                    $pemakaian->restoreHeldStock();
                }

                $pemakaian->delete();
            });
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('pemakaian.index')->with('success', 'Data pemakaian berhasil dihapus');
    }

    public function exportPdf(Request $request)
    {
        set_time_limit(300);
        $query = Pemakaian::query();

        if ($request->filled('lab_id')) {
            $query->where('lab_id', $request->lab_id);
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tgl_peminjaman', [$request->tanggal_awal, $request->tanggal_akhir]);
        } elseif ($request->filled('tanggal_awal')) {
            $query->where('tgl_peminjaman', '>=', $request->tanggal_awal);
        } elseif ($request->filled('tanggal_akhir')) {
            $query->where('tgl_peminjaman', '<=', $request->tanggal_akhir);
        }

        $pemakaian = $query->with(['labId', 'programId'])->orderBy('tgl_peminjaman')->get();
        $laboratorium = Laboratorium::find($request->lab_id);

        $pdf = PDF::loadView('pemakaian.export-pdf', compact('pemakaian', 'laboratorium'))->setPaper('A4', 'landscape');

        return $pdf->download('pemakaian.pdf');
    }
    
    public function KirimWA(Request $request, $id)
    {
        $pemakaian = Pemakaian::findOrFail($id);
        $batas = $pemakaian->tgl_pengembalian
            ? \Carbon\Carbon::parse($pemakaian->tgl_pengembalian)->locale('id')->isoFormat('D MMMM Y')
            : '-';
        $text =
            "Peminjaman atas nama {$pemakaian->nama}\n" .
            "Keperluan: {$pemakaian->keperluan}\n" .
            "Batas pengembalian: {$batas}\n" .
            "Harap segera mengembalikan peminjaman alat atau bahan digunakan.\n" .
            "Terima kasih banyak";

        $result = app(FonnteClient::class)->send((string) $pemakaian->nomor, $text);
        if (!$result['ok']) {
            return redirect()->back()->with('error', 'Gagal mengirim WhatsApp: ' . $result['error']);
        }

        return redirect()->back()->with('success', 'Pesan WhatsApp berhasil dikirim!');
    }
}
