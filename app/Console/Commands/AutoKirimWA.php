<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use App\Models\Ta;
use App\Services\FonnteClient;
use Carbon\Carbon;

class AutoKirimWA extends Command
{
    protected $signature = 'wa:auto-kirim';
    protected $description = 'Kirim WhatsApp reminder otomatis ke dosen berdasarkan jadwal hari ini';

    public function handle()
    {
        $now = Carbon::now('Asia/Jakarta');

        $this->info("[{$now}] Memulai auto kirim WA...");

        if ($pesanTa = Ta::pesanJikaTidakAktif()) {
            $this->info($pesanTa);
            return 0;
        }

        $jadwals = Jadwal::with(['matkulId', 'labId'])
            ->padaTaAktif()
            ->whereDate('jadwal', $now->toDateString())
            ->whereNull('wa_sent_at')
            ->get();

        if ($jadwals->isEmpty()) {
            $this->info("Tidak ada jadwal hari ini atau semua sudah terkirim.");
            return 0;
        }

        $sent = 0;
        $fonnte = app(FonnteClient::class);

        foreach ($jadwals as $jadwal) {
            $jadwalTime = Carbon::parse($jadwal->jadwal, 'Asia/Jakarta');
            $diffMinutes = $now->diffInMinutes($jadwalTime, false);

            if ($diffMinutes > 0 || $diffMinutes < -5) {
                continue;
            }

            $nomor = optional($jadwal->matkulId)->nomor;
            $dosen = optional($jadwal->matkulId)->dosen ?? 'Bapak/Ibu';
            $matkul = optional($jadwal->matkulId)->matakuliah ?? '-';
            $lab = optional($jadwal->labId)->laboratorium ?? '-';

            if (!$nomor) {
                $this->error("Nomor dosen kosong: {$matkul}");
                continue;
            }

            $waktu = Carbon::parse($jadwal->jadwal)->locale('id');
            $selesai = $jadwal->jam_selesai
                ? Carbon::parse($jadwal->jam_selesai)->format('H.i')
                : $waktu->copy()->addMinutes(170)->format('H.i');
            $text =
                "Yth. Bapak/Ibu {$dosen}.\n" .
                "Pengingat jadwal praktikum.\n" .
                "Mata kuliah: {$matkul}\n" .
                "Laboratorium: {$lab}\n" .
                "Tanggal: {$waktu->isoFormat('D MMMM Y')}\n" .
                "Jam: {$waktu->format('H.i')} - {$selesai}\n" .
                "https://silabo.ush.ac.id/jadwallab\n" .
                "Terima kasih.";

            $result = $fonnte->send($nomor, $text);
            if (!$result['ok']) {
                $this->error("Gagal kirim {$matkul}: {$result['error']}");
                continue;
            }

            $jadwal->update(['wa_sent_at' => now()]);
            $sent++;
            $this->info("Terkirim: {$matkul} - {$dosen}");
        }

        $this->info("Selesai. {$sent} pesan terkirim.");
        return 0;
    }
}
