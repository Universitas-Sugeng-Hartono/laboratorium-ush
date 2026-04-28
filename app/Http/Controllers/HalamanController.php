<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Jurnal;
use App\Models\Absensi;
use App\Models\Matkul;
use App\Models\Bahan;
use App\Models\Alat;
use App\Models\Program;
use App\Models\Laboratorium;
use App\Models\Pemakaian;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;
use DB;

class HalamanController extends Controller
{
    public function PilihanCourse()
    {
        return view('halamanawal');
    }

    // public function JadwalLab()
    // {
    //     $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
    //     $jadwalHariIni = Jadwal::whereDate('jadwal', Carbon::today())->get();
    //     $jurnal = Jurnal::whereIn('jadwal_id', $jadwalHariIni->pluck('id'))
    //                     ->get()
    //                     ->keyBy('jadwal_id');

    //     $scheduledTimes = $jadwalHariIni->map(fn($jadwal) => Carbon::parse($jadwal->jadwal)->format('H:i'))->toArray();

    //     return view('welcome', compact('jadwalHariIni', 'hariIni', 'jurnal', 'scheduledTimes'));
    // }

    public function JadwalLab(Request $request)
    {
        $tanggal = $request->input('tanggal')
            ? Carbon::parse($request->input('tanggal'))
            : Carbon::today();

        $hariIni = $tanggal->locale('id')->isoFormat('dddd');
        $jadwalHariIni = Jadwal::whereDate('jadwal', $tanggal)->get();
        $jurnal = Jurnal::whereIn('jadwal_id', $jadwalHariIni->pluck('id'))
            ->get()
            ->keyBy('jadwal_id');
        $scheduledTimes = $jadwalHariIni->map(fn($jadwal) => Carbon::parse($jadwal->jadwal)->format('H:i'))->toArray();
        return view('welcome', compact('jadwalHariIni', 'hariIni', 'jurnal', 'scheduledTimes'));
    }


    public function TamuLab()
    {
        $dates = Carbon::now();
        $lab = Laboratorium::select('id', 'laboratorium')->get();
        $year = $dates->year;
        $month = $dates->month;
        $startOfMonth = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $jadwal = Jadwal::whereMonth('jadwal', $month)
            ->whereYear('jadwal', $year)
            ->get();
        return view('tamu', compact('lab', 'dates', 'jadwal', 'year', 'month', 'startOfMonth', 'daysInMonth'));
    }

    public function sessionJurnal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $programs = Program::select('id', 'program')->get();
        $matkul = Matkul::select('id', 'matakuliah')->get();
        $lab = Laboratorium::select('id', 'laboratorium')->get();
        return view('createjurnal', compact('jadwal', 'programs', 'matkul', 'lab'));
    }

    public function sessionLihatJurnal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jurnals = Jurnal::where('jadwal_id', $id)->get();
        return view('lihatjurnal', compact('jadwal', 'jurnals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matakuliah_id' => 'required|exists:matakuliah,id',
            'program_id' => 'required|exists:program,id',
            'jadwal_id' => 'required|exists:jadwal,id',
            'materi' => 'nullable|string',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'nullable',
            'ttd' => 'nullable|string',
            'jumlah' => 'nullable|integer',
            'lab_id' => 'required',
        ]);

        $ttdPath = null;
        if ($request->ttd) {
            $image = str_replace('data:image/png;base64,', '', $request->ttd);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signature_' . time() . '.png';
            Storage::disk('public')->put('signatures/' . $imageName, base64_decode($image));

            $ttdPath = 'signatures/' . $imageName;
        }

        $jam_mulai = Carbon::parse($request->jam_mulai);
        $jam_selesai = $jam_mulai->addMinutes(170);

        $jurnal = Jurnal::create([
            'matakuliah_id' => $request->matakuliah_id,
            'program_id' => $request->program_id,
            'jadwal_id' => $request->jadwal_id,
            'materi' => $request->materi,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $jam_selesai->format('H:i'),
            'ttd' => $ttdPath,
            'jumlah' => $request->jumlah,
            'lab_id' => $request->lab_id,
        ]);

        Absensi::create([
            'tamu' => $jurnal->matkulId->dosen,
            'tanggal' => $jurnal->tanggal,
            'jam' => $jurnal->jam_mulai,
            'keperluan' => 'Praktikum',
            'ttd' => $jurnal->ttd,
            'lab_id' => $jurnal->lab_id,
        ]);

        return redirect()->route('jadwallab')->with('success', 'Jurnal berhasil dibuat!');
    }

    public function updateJurnal(Request $request, $id)
    {
        $request->validate([
            'materi' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        $jurnal = Jurnal::findOrFail($id);
        $jurnal->materi = $request->materi;
        $jurnal->jumlah = $request->jumlah;
        $jurnal->save();

        return redirect()->back()->with('success', 'Jurnal berhasil diperbarui.');
    }


    public function storeTamu(Request $request)
    {
        $request->validate([
            'tamu' => 'nullable|string',
            'hp' => 'required|string',
            'jumlah_tamu' => 'required|string',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'jamselesai' => 'required',
            'keperluan' => 'required',
            'ttd' => 'required|string',
            'lab_id' => 'nullable|string',
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
            'hp' => $request->hp,
            'jumlah_tamu' => $request->jumlah_tamu,
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'jamselesai' => $request->jamselesai,
            'keperluan' => $request->keperluan,
            'ttd' => $ttdPath,
            'lab_id' => $request->lab_id,
        ]);

        return redirect()->route('awal')->with('success', 'Daftar Hadir Tamu berhasil dibuat!');
    }

    public function JadwalPinjam(Request $request)
    {
        $query = Pemakaian::with(['jadwalId', 'programId', 'matkulId', 'labId']);

        if ($request->has('tgl_peminjaman') && !empty($request->tgl_peminjaman)) {
            $query->whereDate('tgl_peminjaman', $request->tgl_peminjaman);
        }

        $pemakaian = $query->get();
        return view('pemakaianlihat', compact('pemakaian'));
    }


    public function exportPinPdf($id)
    {
        $peminjaman = Pemakaian::findOrFail($id);
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

        return view('peminjaman.pdf1', compact('peminjaman', 'alats', 'bahans'));
        $pdf = PDF::loadView('peminjaman.pdf', compact('peminjaman'));
    }

    public function sessionCreatePeminjaman()
    {
        $programs = Program::select('id', 'program')->get();
        $matkul = Matkul::select('id', 'matakuliah')->get();
        $laboratorium = Laboratorium::all();
        $bahans = Bahan::all();
        $alats = Alat::all();
        return view('peminjaman', compact('laboratorium', 'programs', 'matkul', 'bahans', 'alats'));
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'lab_id' => 'required|integer',
            'matakuliah_id' => 'nullable|integer',
            'program_id' => 'nullable|integer',
            'keperluan' => 'required|string',
            'tgl_peminjaman' => 'required|date',
            'tgl_pengembalian' => 'required|date',
            'alat_id' => 'nullable|array',
            'alat_id.*' => 'integer',
            'jumlah_alat.*' => 'nullable|integer|min:1',
            'bahan_id' => 'nullable|array',
            'bahan_id.*' => 'integer',
            'jumlah_bahan.*' => 'nullable|integer|min:1',
            'ttd' => 'nullable',
            'nomor' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $ttdPath = null;
            if ($request->ttd) {
                $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->ttd);
                $imageName = 'signature_' . time() . '.png';
                Storage::disk('public')->put('signaturespeminjaman/' . $imageName, base64_decode($image));
                $ttdPath = 'signaturespeminjaman/' . $imageName;
            }

            $pemakaian = Pemakaian::create([
                'nama' => $request->nama,
                'lab_id' => $request->lab_id,
                'matakuliah_id' => $request->matakuliah_id,
                'program_id' => $request->program_id,
                'keperluan' => $request->keperluan,
                'tgl_peminjaman' => $request->tgl_peminjaman,
                'tgl_pengembalian' => $request->tgl_pengembalian,
                'nomor' => $request->nomor,
                'ttd' => $ttdPath,
            ]);

            if ($request->alat_id) {
                foreach ($request->alat_id as $index => $alatId) {
                    $jumlah = $request->jumlah_alat[$index] ?? 0;
                    $alat = Alat::findOrFail($alatId);

                    if ($alat->jumlah >= $jumlah) {
                        $alat->decrement('jumlah', $jumlah);
                        DB::table('pemakaian_alat')->insert([
                            'pemakaian_id' => $pemakaian->id,
                            'alat_id' => $alatId,
                            'jumlah_pinjam' => $jumlah,
                        ]);
                    } else {
                        throw new \Exception("Stok alat tidak mencukupi untuk {$alat->alat}");
                    }
                }
            }

            if ($request->bahan_id) {
                foreach ($request->bahan_id as $index => $bahanId) {
                    $jumlah = $request->jumlah_bahan[$index] ?? 0;
                    $bahan = Bahan::findOrFail($bahanId);

                    if ($bahan->jumlah >= $jumlah) {
                        $bahan->decrement('jumlah', $jumlah);
                        DB::table('bahan_pemakaian')->insert([
                            'pemakaian_id' => $pemakaian->id,
                            'bahan_id' => $bahanId,
                            'jumlah_pakai' => $jumlah,
                        ]);
                    } else {
                        throw new \Exception("Stok bahan tidak mencukupi untuk {$bahan->bahan}");
                    }
                }
            }
        });

        return view('pemakaianlihat')->with('success', 'Peminjaman berhasil disimpan!');
    }

    public function StokOpname()
    {
        $bahan = Bahan::all();
        return view('stokopname', compact('bahan'));
    }

    public function KirimWA(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $curl = curl_init();

        // Nomor tujuan (format internasional 62)
        $destination = $jadwal->matkulId->nomor;

        // Pesan teks (tanpa heredoc)
        $stringPesanan =
            "Yth. Bapak/Ibu {$jadwal->matkulId->dosen}.\n" .
            "Jadwal {$jadwal->labId->laboratorium} - {$jadwal->jadwal}.\n" .
            "Mata Kuliah {$jadwal->matkulId->matakuliah}\n" .
            "Dimohon untuk mengisi E-Journal Laboratorium sebelum meninggalkan ruangan {$jadwal->labId->laboratorium}\n" .
            "https://laboratorium.sugenghartono.ac.id/jadwallab \n" .
            "Terima Kasih Banyak";

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'target' => $destination,
                'message' => $stringPesanan,
                'delay' => 2,
                'typing' => false,
                'countryCode' => '62',
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: cb4br9SeSXNT4V6Xi7LP'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return redirect()->back()->with('error', 'Gagal mengirim WhatsApp: ' . $error_msg);
        }

        curl_close($curl);

        return redirect()->back()->with('success', 'Pesan WhatsApp berhasil dikirim!');
    }

    public function AutoKirimWA()
    {
        date_default_timezone_set('Asia/Jakarta'); // penting di shared hosting

        $nowDate = date('Y-m-d');
        $nowTime = date('H:i');

        // Ambil semua jadwal hari ini yang belum pernah dikirimi WA
        $jadwals = Jadwal::whereDate('jadwal', $nowDate)
            ->whereNull('wa_sent_at')  // agar tidak kirim 2x
            ->get();

        if ($jadwals->isEmpty()) {
            return "Tidak ada jadwal hari ini atau semua sudah terkirim.";
        }

        foreach ($jadwals as $jadwal) {

            // Cek apakah waktu jadwal sudah sama dengan waktu saat ini (format HH:MM)
            $jadwalTime = date('H:i', strtotime($jadwal->jadwal));

            if ($jadwalTime === $nowTime) {

                // Panggil function KirimWA yang sudah ada
                $this->KirimWA(request(), $jadwal->id);

                // Tandai agar tidak kirim 2x
                $jadwal->update([
                    'wa_sent_at' => now()
                ]);
            }
        }

        return "Proses auto WA selesai.";
    }

    /**
     * API untuk cronjob: kirim WA reminder ke dosen yang belum menulis jurnal.
     * Hanya mengirim untuk jadwal yang waktunya sudah lewat.
     *
     * Parameter opsional (query string):
     * - tanggal    : tanggal spesifik (format Y-m-d), contoh: ?tanggal=2026-04-15
     * - start_date : tanggal mulai range (format Y-m-d), contoh: ?start_date=2026-04-10&end_date=2026-04-15
     * - end_date   : tanggal akhir range (format Y-m-d)
     *
     * Jika tidak ada parameter, default = hari ini.
     * Jika tanggal diisi, cek semua jadwal di tanggal tsb (tanpa cek waktu).
     * Jika start_date & end_date diisi, cek semua jadwal di range tsb.
     */
    public function ReminderJurnalWA(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $nowTime = Carbon::now();

        // Tentukan tanggal yang dicek
        $tanggal = $request->query('tanggal');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Flag: apakah user mengirim parameter tanggal (bukan hari ini)
        $isCustomDate = false;

        if ($tanggal) {
            // Mode: tanggal spesifik
            $isCustomDate = true;
            $dates = [Carbon::parse($tanggal)];
            $labelTanggal = $tanggal;
        } elseif ($startDate && $endDate) {
            // Mode: range tanggal
            $isCustomDate = true;
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $dates = [];
            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $dates[] = $date->copy();
            }
            $labelTanggal = $startDate . ' s/d ' . $endDate;
        } else {
            // Mode: hari ini (default)
            $dates = [Carbon::today()];
            $labelTanggal = Carbon::today()->format('Y-m-d');
        }

        // Query jadwal berdasarkan tanggal
        $query = Jadwal::with(['matkulId', 'labId']);

        if (count($dates) === 1) {
            $query->whereDate('jadwal', $dates[0]);
        } else {
            $query->whereDate('jadwal', '>=', $dates[0])
                  ->whereDate('jadwal', '<=', end($dates));
        }

        $jadwals = $query->get();

        $results = [
            'tanggal' => $labelTanggal,
            'waktu_cek' => $nowTime->format('H:i:s'),
            'total_jadwal' => $jadwals->count(),
            'belum_jurnal' => 0,
            'terkirim' => 0,
            'gagal' => 0,
            'sudah_jurnal' => 0,
            'belum_waktunya' => 0,
            'detail' => [],
        ];

        foreach ($jadwals as $jadwal) {
            $jadwalTime = Carbon::parse($jadwal->jadwal);
            $jadwalDate = $jadwalTime->format('Y-m-d');

            // Jika bukan custom date (hari ini), lewati jadwal yang belum waktunya
            if (!$isCustomDate && $nowTime->lt($jadwalTime)) {
                $results['belum_waktunya']++;
                continue;
            }

            // Cek apakah sudah ada jurnal untuk jadwal ini
            $jurnalExists = Jurnal::where('jadwal_id', $jadwal->id)->exists();

            if ($jurnalExists) {
                $results['sudah_jurnal']++;
                continue;
            }

            $results['belum_jurnal']++;

            // Kirim WA reminder
            $dosen = $jadwal->matkulId->dosen ?? 'Bapak/Ibu Dosen';
            $matakuliah = $jadwal->matkulId->matakuliah ?? '-';
            $lab = $jadwal->labId->laboratorium ?? '-';
            $destination = $jadwal->matkulId->nomor ?? null;

            if (!$destination) {
                $results['gagal']++;
                $results['detail'][] = [
                    'jadwal_id' => $jadwal->id,
                    'dosen' => $dosen,
                    'matakuliah' => $matakuliah,
                    'tanggal' => $jadwalDate,
                    'status' => 'gagal',
                    'keterangan' => 'Nomor HP tidak tersedia',
                ];
                continue;
            }

            // Link dengan parameter tanggal
            $linkJadwal = "https://laboratorium.sugenghartono.ac.id/jadwallab?tanggal={$jadwalDate}";

            $stringPesanan =
                "Yth. Bapak/Ibu {$dosen}.\n" .
                "Ini adalah pengingat bahwa jurnal perkuliahan untuk:\n" .
                "Mata Kuliah: {$matakuliah}\n" .
                "Laboratorium: {$lab}\n" .
                "Jadwal: {$jadwal->jadwal}\n" .
                "belum diisi.\n\n" .
                "Dimohon untuk segera mengisi E-Journal Laboratorium melalui:\n" .
                "{$linkJadwal}\n\n" .
                "Terima kasih atas perhatiannya.";

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'target' => $destination,
                    'message' => $stringPesanan,
                    'delay' => 2,
                    'typing' => false,
                    'countryCode' => '62',
                ],
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . env('FONNTE_TOKEN', 'cb4br9SeSXNT4V6Xi7LP')
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_errno($curl) ? curl_error($curl) : null;
            curl_close($curl);

            if ($error) {
                $results['gagal']++;
                $results['detail'][] = [
                    'jadwal_id' => $jadwal->id,
                    'dosen' => $dosen,
                    'matakuliah' => $matakuliah,
                    'tanggal' => $jadwalDate,
                    'status' => 'gagal',
                    'keterangan' => $error,
                ];
            } else {
                $results['terkirim']++;
                $results['detail'][] = [
                    'jadwal_id' => $jadwal->id,
                    'dosen' => $dosen,
                    'matakuliah' => $matakuliah,
                    'tanggal' => $jadwalDate,
                    'nomor' => $destination,
                    'status' => 'terkirim',
                    'response' => json_decode($response, true),
                ];
            }

            // Delay antar pesan agar tidak spam
            usleep(1000000); // 1 detik
        }

        return response()->json($results);
    }


    /*
    public function KirimWA(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $curl = curl_init();
        $ownNumber = '6281575946172';
        $urlEasyWa = 'https://wa.sugenghartono.cloud/sendmessage?number=' . $ownNumber;
        $destination = $jadwal->matkulId->nomor . '@s.whatsapp.net';
        $stringPesanan = <<<STR
Yth. Bapak/Ibu {$jadwal->matkulId->dosen}.
Jadwal {$jadwal->labId->laboratorium} - {$jadwal->jadwal}.
Mata Kuliah {$jadwal->matkulId->matakuliah}
Dimohon untuk mengisi E-Journal Laboratorium sebelum meninggalkan ruangan {$jadwal->labId->laboratorium}
https://laboratorium.sugenghartono.ac.id/jadwallab
Terima Kasih Banyak
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
    */

    //     public function KirimWA(Request $request, $id)
//     {
//         $jadwal = Jadwal::findOrFail($id);

    //         switch ($jadwal->program_id) {
//             case 1:
//                 $ownNumber = '6281234567890'; //bisdig
//                 break;
//             case 2:
//                 $ownNumber = '6282345678901'; //informatika
//                 break;
//             case 3:
//                 $ownNumber = '6283456789012'; //Gizi
//                 break;
//             case 4:
//                 $ownNumber = '6283456789012'; //Tekpang
//                 break;
//             case 5:
//                 $ownNumber = '6283456789012'; //Hukum
//                 break;
//             case 6:
//                 $ownNumber = '6283456789012'; //mbi
//                 break;
//             default:
//                 $ownNumber = '6281575946172';
//                 break;
//         }

    //         $curl = curl_init();
//         $urlEasyWa = 'https://wa.sugenghartono.cloud/sendmessage?number=' . $ownNumber;
//         $destination = $jadwal->matkulId->nomor . '@s.whatsapp.net';

    //         $stringPesanan = <<<STR
// Yth. Bapak/Ibu {$jadwal->matkulId->dosen}.
// Jadwal {$jadwal->labId->laboratorium} - {$jadwal->jadwal}.
// Mata Kuliah {$jadwal->matkulId->matakuliah}
// Dimohon untuk mengisi E-Journal Laboratorium sebelum meninggalkan ruangan {$jadwal->labId->laboratorium}
// https://laboratorium.sugenghartono.ac.id/jadwallab
// Terima Kasih Banyak
// STR;

    //         $message = [
//             'to' => $destination,
//             'message' => [
//                 'text' => $stringPesanan
//             ],
//         ];

    //         $sendMessage = json_encode($message, 1);

    //         curl_setopt_array($curl, [
//             CURLOPT_URL => $urlEasyWa,
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_ENCODING => '',
//             CURLOPT_MAXREDIRS => 10,
//             CURLOPT_TIMEOUT => 0,
//             CURLOPT_FOLLOWLOCATION => true,
//             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//             CURLOPT_CUSTOMREQUEST => 'POST',
//             CURLOPT_POSTFIELDS => $sendMessage,
//             CURLOPT_HTTPHEADER => [
//                 'Content-Type: application/json',
//             ],
//         ]);

    //         $response = curl_exec($curl);
//         curl_close($curl);

    //         return redirect()->back()->with('success', 'Pesan WhatsApp berhasil dikirim!');
//     }
}