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
use App\Models\Ta;
use App\Rules\NomorWhatsappRule;
use App\Services\FonnteClient;
use App\Support\NomorWhatsapp;
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



    public function JadwalLab(Request $request)
    {
        $tanggal = $request->input('tanggal')
            ? Carbon::parse($request->input('tanggal'))
            : Carbon::today();

        $hariIni = $tanggal->locale('id')->isoFormat('dddd');
        $peringatanTa = Ta::pesanJikaTidakAktif();
        $jadwalHariIni = Jadwal::with(['matkulId', 'labId', 'programId'])
            ->padaTaAktif()
            ->whereDate('jadwal', $tanggal)
            ->orderBy('jadwal', 'asc')
            ->get();

        $jurnal = Jurnal::whereIn('jadwal_id', $jadwalHariIni->pluck('id'))
            ->get()
            ->keyBy('jadwal_id');

        $scheduledTimes = $jadwalHariIni->map(fn($jadwal) => Carbon::parse($jadwal->jadwal)->format('H:i'))->toArray();
        return view('welcome', compact('jadwalHariIni', 'hariIni', 'jurnal', 'scheduledTimes', 'tanggal', 'peringatanTa'));
    }


    public function TamuLab()
    {
        $dates = Carbon::now();
        $lab = Laboratorium::select('id', 'laboratorium')->get();
        $year = $dates->year;
        $month = $dates->month;
        $startOfMonth = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $jadwal = Jadwal::padaTaAktif()
            ->whereMonth('jadwal', $month)
            ->whereYear('jadwal', $year)
            ->get();
        return view('tamu', compact('lab', 'dates', 'jadwal', 'year', 'month', 'startOfMonth', 'daysInMonth'));
    }

    public function sessionJurnal(Request $request, $id)
    {
        $jadwal = Jadwal::padaTaAktif()->find($id);
        if (!$jadwal) {
            return redirect()->route('jadwallab')->with('error', Ta::pesanJikaTidakAktif() ?? 'Jadwal ini bukan bagian dari tahun akademik aktif.');
        }
        $programs = Program::select('id', 'program')->get();
        $matkul = Matkul::select('id', 'matakuliah')->get();
        $lab = Laboratorium::select('id', 'laboratorium')->get();
        return view('createjurnal', compact('jadwal', 'programs', 'matkul', 'lab'));
    }

    public function sessionLihatJurnal(Request $request, $id)
    {
        $jadwal = Jadwal::padaTaAktif()->find($id);
        if (!$jadwal) {
            return redirect()->route('jadwallab')->with('error', Ta::pesanJikaTidakAktif() ?? 'Jadwal ini bukan bagian dari tahun akademik aktif.');
        }
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

        $jamSelesai = $request->jam_selesai;
        if (!$jamSelesai) {
            $jamSelesai = Carbon::parse($request->jam_mulai)->addMinutes(170)->format('H:i');
        }

        $jurnal = Jurnal::create([
            'matakuliah_id' => $request->matakuliah_id,
            'program_id' => $request->program_id,
            'jadwal_id' => $request->jadwal_id,
            'materi' => $request->materi,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $jamSelesai,
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
            'tamu' => 'required|string|max:255',
            'kategori_tamu' => 'required|string|max:60',
            'identitas' => 'nullable|string|max:50',
            'instansi' => 'nullable|string|max:150',
            'hp' => ['required', 'string', 'max:20', new NomorWhatsappRule],
            'jumlah_tamu' => 'required|integer|min:1',
            'lab_id' => 'required|exists:laboratorium,id',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'jamselesai' => 'required',
            'kategori_keperluan' => 'required|string|max:100',
            'keperluan' => 'required|string',
            'ttd' => 'required|string',
            'setuju_k3' => 'accepted',
        ], [
            'tamu.required' => 'Nama lengkap tamu wajib diisi.',
            'kategori_tamu.required' => 'Kategori pengunjung wajib dipilih.',
            'hp.required' => 'Nomor WhatsApp / Handphone wajib diisi.',
            'hp.' . NomorWhatsappRule::class => NomorWhatsapp::PESAN,
            'jumlah_tamu.required' => 'Jumlah tamu wajib diisi.',
            'jumlah_tamu.integer' => 'Jumlah tamu harus berupa angka.',
            'jumlah_tamu.min' => 'Jumlah tamu minimal 1 orang.',
            'lab_id.required' => 'Laboratorium tujuan wajib dipilih.',
            'kategori_keperluan.required' => 'Kategori keperluan wajib dipilih.',
            'keperluan.required' => 'Rincian keperluan wajib diisi.',
            'ttd.required' => 'Tanda tangan digital wajib dibubuhkan.',
            'setuju_k3.accepted' => 'Anda wajib menyetujui tata tertib dan keselamatan kerja (K3) laboratorium.',
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
            'tamu' => trim($request->tamu),
            'kategori_tamu' => $request->kategori_tamu,
            'identitas' => $request->identitas ? trim($request->identitas) : null,
            'instansi' => $request->instansi ? trim($request->instansi) : null,
            'hp' => NomorWhatsapp::normalize($request->hp),
            'jumlah_tamu' => (int) $request->jumlah_tamu,
            'kategori_keperluan' => $request->kategori_keperluan,
            'keperluan' => trim($request->keperluan),
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'jamselesai' => $request->jamselesai,
            'ttd' => $ttdPath,
            'lab_id' => $request->lab_id,
        ]);

        $lab = Laboratorium::find($request->lab_id);

        return redirect()->route('tamuumum')
            ->with('success', 'Presensi kunjungan laboratorium berhasil disimpan. Selamat beraktivitas di laboratorium USH!')
            ->with('tamu_success', [
                'nama' => trim($request->tamu),
                'kategori' => $request->kategori_tamu,
                'identitas' => $request->identitas ? trim($request->identitas) : '-',
                'instansi' => $request->instansi ? trim($request->instansi) : '-',
                'lab' => $lab ? $lab->laboratorium : 'Laboratorium USH',
                'tanggal' => \Carbon\Carbon::parse($request->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y'),
                'jam' => $request->jam . ' - ' . $request->jamselesai . ' WIB',
                'jumlah' => $request->jumlah_tamu . ' Orang',
                'keperluan' => $request->kategori_keperluan,
            ]);
    }

    public function JadwalPinjam(Request $request)
    {
        $query = Pemakaian::with(['jadwalId', 'programId', 'matkulId', 'labId'])->orderBy('id', 'desc');

        if ($request->has('tgl_peminjaman') && !empty($request->tgl_peminjaman)) {
            $query->whereDate('tgl_peminjaman', $request->tgl_peminjaman);
        }

        $pemakaian = $query->get();
        $totalPinjam = Pemakaian::count();
        $totalSetuju = Pemakaian::where('keterangan', 'setuju')->count();
        $totalProses = Pemakaian::where(function ($q) {
            $q->whereIn('keterangan', ['proses', 'ditolak'])
                ->orWhereNull('keterangan');
        })->count();

        return view('pemakaianlihat', compact('pemakaian', 'totalPinjam', 'totalSetuju', 'totalProses'));
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
    }

    public function sessionCreatePeminjaman()
    {
        $programs = Program::select('id', 'program')->orderBy('program', 'asc')->get();
        $matkul = Matkul::select('id', 'matakuliah', 'program_id')->orderBy('matakuliah', 'asc')->get();
        $laboratorium = Laboratorium::orderBy('laboratorium', 'asc')->get();
        $bahans = Bahan::select('id', 'lab_id', 'bahan', 'jumlah', 'satuan')->orderBy('bahan', 'asc')->get();
        $alats = Alat::select('id', 'lab_id', 'alat', 'jumlah', 'kondisi', 'status')->orderBy('alat', 'asc')->get();
        return view('peminjaman', compact('laboratorium', 'programs', 'matkul', 'bahans', 'alats'));
    }

    public function storePeminjaman(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor' => ['required', 'string', 'max:20', new NomorWhatsappRule],
            'lab_id' => 'required|integer|exists:laboratorium,id',
            'matakuliah_id' => 'nullable|integer',
            'program_id' => 'nullable|integer',
            'keperluan' => 'required|string',
            'tgl_peminjaman' => 'required|date',
            'tgl_pengembalian' => 'required|date|after_or_equal:tgl_peminjaman',
            'alat_id' => 'nullable|array',
            'alat_id.*' => 'integer|exists:alat,id',
            'jumlah_alat' => 'nullable|array',
            'jumlah_alat.*' => 'nullable|integer|min:1',
            'bahan_id' => 'nullable|array',
            'bahan_id.*' => 'integer|exists:bahan,id',
            'jumlah_bahan' => 'nullable|array',
            'jumlah_bahan.*' => 'nullable|integer|min:1',
            'ttd' => 'nullable|string',
        ]);

        if (!$this->peminjamanHasItem($request)) {
            return redirect()->back()->withInput()->with('error', 'Pilih minimal satu alat atau satu bahan.');
        }

        try {
            DB::transaction(function () use ($request) {
                $ttdPath = null;
                if ($request->filled('ttd') && str_contains($request->ttd, 'base64')) {
                    $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $request->ttd);
                    $imageName = 'signature_' . uniqid('', true) . '.png';
                    Storage::disk('public')->put('signaturespeminjaman/' . $imageName, base64_decode($image));
                    $ttdPath = 'signaturespeminjaman/' . $imageName;
                }

                $pemakaian = Pemakaian::create([
                    'nama' => $request->nama,
                    'nomor' => NomorWhatsapp::normalize($request->nomor),
                    'lab_id' => $request->lab_id,
                    'matakuliah_id' => $request->matakuliah_id,
                    'program_id' => $request->program_id,
                    'keperluan' => $request->keperluan,
                    'tgl_peminjaman' => $request->tgl_peminjaman,
                    'tgl_pengembalian' => $request->tgl_pengembalian,
                    'ttd' => $ttdPath,
                    'keterangan' => 'proses',
                    'status_pengembalian' => 'belum',
                ]);

                if ($request->filled('alat_id') && is_array($request->alat_id)) {
                    $reservedAlat = [];
                    foreach ($request->alat_id as $index => $alatId) {
                        $jumlah = (int) ($request->jumlah_alat[$index] ?? 0);
                        if ($jumlah <= 0) {
                            continue;
                        }

                        $alat = Alat::where('id', $alatId)->lockForUpdate()->firstOrFail();
                        $reservedAlat[$alatId] = ($reservedAlat[$alatId] ?? 0) + $jumlah;

                        if ((int) $alat->jumlah < $reservedAlat[$alatId]) {
                            throw new \Exception("Stok alat tidak mencukupi untuk '{$alat->alat}'. Sisa stok tersedia: {$alat->jumlah}.");
                        }

                        DB::table('pemakaian_alat')->insert([
                            'pemakaian_id' => $pemakaian->id,
                            'alat_id' => $alatId,
                            'jumlah_pinjam' => $jumlah,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                if ($request->filled('bahan_id') && is_array($request->bahan_id)) {
                    $reservedBahan = [];
                    foreach ($request->bahan_id as $index => $bahanId) {
                        $jumlah = (int) ($request->jumlah_bahan[$index] ?? 0);
                        if ($jumlah <= 0) {
                            continue;
                        }

                        $bahan = Bahan::where('id', $bahanId)->lockForUpdate()->firstOrFail();
                        $reservedBahan[$bahanId] = ($reservedBahan[$bahanId] ?? 0) + $jumlah;

                        if ((int) $bahan->jumlah < $reservedBahan[$bahanId]) {
                            throw new \Exception("Stok bahan tidak mencukupi untuk '{$bahan->bahan}'. Sisa stok tersedia: {$bahan->jumlah}.");
                        }

                        DB::table('pemakaian_bahan')->insert([
                            'pemakaian_id' => $pemakaian->id,
                            'bahan_id' => $bahanId,
                            'jumlah_pakai' => $jumlah,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            });

            return redirect('/lihatpeminjaman')->with('success', 'Permohonan peminjaman laboratorium berhasil dikirim! Silakan pantau status persetujuan pada tabel.');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if ($e instanceof \Illuminate\Database\QueryException || str_contains($message, 'SQLSTATE')) {
                $message = 'Data tidak dapat diproses. Periksa isian Anda, atau hubungi admin jika masalah ini berulang.';
            }
            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    public function StokOpname()
    {
        $bahan = Bahan::orderBy('bahan', 'asc')->get();
        $totalBahan = $bahan->count();
        $totalStok = $bahan->sum('jumlah');
        return view('stokopname', compact('bahan', 'totalBahan', 'totalStok'));
    }

    public function KirimWA(Request $request, $id)
    {
        $jadwal = Jadwal::with(['matkulId', 'labId'])->findOrFail($id);
        if (!Jadwal::padaTaAktif()->where('id', $jadwal->id)->exists()) {
            return redirect()->back()->with('error', Ta::pesanJikaTidakAktif() ?? 'Pengingat hanya dikirim untuk jadwal tahun akademik aktif.');
        }
        $result = $this->sendJadwalReminder($jadwal);

        if (!$result['ok']) {
            return redirect()->back()->with('error', 'Gagal mengirim WhatsApp: ' . $result['error']);
        }

        return redirect()->back()->with('success', 'Pesan WhatsApp berhasil dikirim!');
    }

    public function AutoKirimWA(Request $request)
    {
        if ($request->query('token') !== null) {
            abort(403, 'Akses ditolak. Token cron dikirim lewat header X-Cron-Token.');
        }

        if (!$this->cronAuthorized($request)) {
            abort(403, 'Akses ditolak. Token tidak valid.');
        }

        date_default_timezone_set('Asia/Jakarta');

        if ($pesanTa = Ta::pesanJikaTidakAktif()) {
            return $pesanTa;
        }

        $now = Carbon::now('Asia/Jakarta');
        $jadwals = Jadwal::with(['matkulId', 'labId'])
            ->padaTaAktif()
            ->whereDate('jadwal', $now->toDateString())
            ->whereNull('wa_sent_at')
            ->get();

        if ($jadwals->isEmpty()) {
            return "Tidak ada jadwal hari ini atau semua sudah terkirim.";
        }

        $sent = 0;
        foreach ($jadwals as $jadwal) {
            $jadwalTime = Carbon::parse($jadwal->jadwal, 'Asia/Jakarta');
            $diffMinutes = $now->diffInMinutes($jadwalTime, false);
            if ($diffMinutes > 0 || $diffMinutes < -5) {
                continue;
            }

            $result = $this->sendJadwalReminder($jadwal);
            if ($result['ok']) {
                $jadwal->update(['wa_sent_at' => now()]);
                $sent++;
            }
        }

        return "Proses auto WA selesai. Terkirim: {$sent}.";
    }

    /**
     * API untuk cronjob: kirim WA reminder ke dosen yang belum menulis jurnal.
     * Hanya mengirim untuk jadwal yang waktunya sudah lewat.
     *
     * Autentikasi lewat header X-Cron-Token, bukan query string.
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
        if ($request->query('token') !== null) {
            abort(403, 'Akses ditolak. Token cron dikirim lewat header X-Cron-Token.');
        }

        if (!$this->cronAuthorized($request)) {
            abort(403, 'Akses ditolak. Token tidak valid.');
        }

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

        if ($pesanTa = Ta::pesanJikaTidakAktif()) {
            return response()->json([
                'message' => $pesanTa,
                'tanggal' => $labelTanggal,
                'waktu_cek' => $nowTime->format('H:i:s'),
                'total_jadwal' => 0,
                'belum_jurnal' => 0,
                'terkirim' => 0,
                'gagal' => 0,
                'sudah_jurnal' => 0,
                'belum_waktunya' => 0,
                'detail' => [],
            ]);
        }

        // Query jadwal berdasarkan tanggal
        $query = Jadwal::with(['matkulId', 'labId'])->padaTaAktif();

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

            $result = app(FonnteClient::class)->send($destination, $stringPesanan);

            if (!$result['ok']) {
                $results['gagal']++;
                $results['detail'][] = [
                    'jadwal_id' => $jadwal->id,
                    'dosen' => $dosen,
                    'matakuliah' => $matakuliah,
                    'tanggal' => $jadwalDate,
                    'status' => 'gagal',
                    'keterangan' => $result['error'],
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
                ];
            }

            usleep(1000000);
        }

        return response()->json($results);
    }

    private function peminjamanHasItem(Request $request): bool
    {
        $alatIds = $request->input('alat_id', []);
        $alatQty = $request->input('jumlah_alat', []);
        if (is_array($alatIds)) {
            foreach ($alatIds as $index => $alatId) {
                if ($alatId && (int) ($alatQty[$index] ?? 0) > 0) {
                    return true;
                }
            }
        }

        $bahanIds = $request->input('bahan_id', []);
        $bahanQty = $request->input('jumlah_bahan', []);
        if (is_array($bahanIds)) {
            foreach ($bahanIds as $index => $bahanId) {
                if ($bahanId && (int) ($bahanQty[$index] ?? 0) > 0) {
                    return true;
                }
            }
        }

        return false;
    }

    private function cronAuthorized(Request $request): bool
    {
        $secret = (string) env('CRON_SECRET', '');
        if ($secret === '') {
            return false;
        }

        $given = (string) $request->header('X-Cron-Token', '');
        if ($given === '') {
            $given = (string) $request->bearerToken();
        }

        return $given !== '' && hash_equals($secret, $given);
    }

    private function sendJadwalReminder(Jadwal $jadwal): array
    {
        $nomor = optional($jadwal->matkulId)->nomor;
        if (!$nomor) {
            return ['ok' => false, 'error' => 'Nomor WhatsApp dosen tidak ditemukan.'];
        }

        $dosen = optional($jadwal->matkulId)->dosen ?? 'Bapak/Ibu';
        $matkul = optional($jadwal->matkulId)->matakuliah ?? '-';
        $lab = optional($jadwal->labId)->laboratorium ?? '-';
        $text =
            "Yth. Bapak/Ibu {$dosen}.\n" .
            "Jadwal {$lab} - {$jadwal->jadwal}.\n" .
            "Mata Kuliah {$matkul}\n" .
            "Dimohon untuk mengisi E-Journal Laboratorium sebelum meninggalkan ruangan {$lab}\n" .
            "https://laboratorium.sugenghartono.ac.id/jadwallab\n" .
            "Terima Kasih Banyak";

        return app(FonnteClient::class)->send($nomor, $text);
    }

}