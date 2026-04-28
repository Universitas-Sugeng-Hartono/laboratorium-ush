<?php

namespace App\Http\Controllers;

use App\Models\Pemakaian;
use App\Models\Jadwal;
use App\Models\Program;
use App\Models\Matkul;
use App\Models\Laboratorium;
use App\Models\User;
use App\Models\Alat;
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

        $pemakaian = $query->get();
        $laboratories = Laboratorium::all();

        return view('pemakaian.index', compact('pemakaian', 'laboratories'));
    }

    public function storePemakaian($id)
    {
        $pemakaian = Pemakaian::findOrFail($id);
    
        foreach ($pemakaian->alatData ?? [] as $alat) {
            DB::table('alat')->where('id', $alat->alat_id)->increment('jumlah', (int) $alat->jumlah_pinjam);
        }
        
        foreach ($pemakaian->bahanData ?? [] as $bahan) {
            DB::table('bahan')->where('id', $bahan->bahan_id)->increment('jumlah', (int) $bahan->jumlah_pakai);
        }

        $pemakaian->status_pengembalian = 'sudah';
        $pemakaian->save();
    
        return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
    }

    public function edit($id)
    {
        $pemakaian = Pemakaian::findOrFail($id);
        return view('pemakaian.edit', compact('pemakaian'));
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
        ]);

        $pemakaian = Pemakaian::findOrFail($id);
        $pemakaian->update($request->all());

        return redirect()->route('pemakaian.index')->with('success', 'Data pemakaian berhasil diperbarui');
    }

    /**
     * Menghapus data pemakaian
     */
    public function destroy($id)
    {
        $pemakaian = Pemakaian::findOrFail($id);
        $pemakaian->delete();

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
        $curl = curl_init();
        $ownNumber = '6281575946172';
        $urlEasyWa = 'https://wa.sugenghartono.ac.id/sendmessage?number=' . $ownNumber;
        $destination = $pemakaian->nomor . '@s.whatsapp.net';
        $stringPesanan = <<<STR
Peminjaman atas nama {$pemakaian->nama}
Dengan keperluan peminjaman digunakan untuk {$pemakaian->keperluan}
Sudah melewati batas pengembalian pada tanggal {$pemakaian->tanggal_pengembalian}
Harap segera mengembalikan peminjaman alat atau bahan digunakan.
Terima kasih banyak
STR;
        $message = [
            'to' => $destination,
            'message' => [
                'text' => $stringPesanan
            ],
        ];
        $sendMessage = json_encode($message, 1);

        curl_setopt_array($curl, [
            CURLOPT_URL => $urlEasyWa,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $sendMessage,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return redirect()->back()->with('success', 'Pesan WhatsApp berhasil dikirim!');
    }
}
