<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use Carbon\Carbon;

class AutoKirimWA extends Command
{
    protected $signature = 'wa:auto-kirim';
    protected $description = 'Kirim WhatsApp reminder otomatis ke dosen berdasarkan jadwal hari ini';

    public function handle()
    {
        $now = Carbon::now('Asia/Jakarta');
        $nowDate = $now->format('Y-m-d');
        $nowTime = $now->format('H:i');

        $this->info("[{$now}] Memulai auto kirim WA...");

        // Ambil jadwal hari ini yang belum dikirim WA dan sudah waktunya (atau sudah lewat max 5 menit)
        $jadwals = Jadwal::whereDate('jadwal', $nowDate)
            ->whereNull('wa_sent_at')
            ->get();

        if ($jadwals->isEmpty()) {
            $this->info("Tidak ada jadwal hari ini atau semua sudah terkirim.");
            return 0;
        }

        $sent = 0;

        foreach ($jadwals as $jadwal) {
            $jadwalTime = Carbon::parse($jadwal->jadwal, 'Asia/Jakarta');
            $diffMinutes = $now->diffInMinutes($jadwalTime, false); // negative = sudah lewat

            // Kirim jika waktunya sudah tiba (0 sampai 5 menit yang lalu)
            if ($diffMinutes <= 0 && $diffMinutes >= -5) {
                $this->kirimPesan($jadwal);
                $jadwal->update(['wa_sent_at' => now()]);
                $sent++;
                $this->info("✓ Terkirim: {$jadwal->matkulId->matakuliah} - {$jadwal->matkulId->dosen}");
            }
        }

        $this->info("Selesai. {$sent} pesan terkirim.");
        return 0;
    }

    private function kirimPesan(Jadwal $jadwal)
    {
        $destination = $jadwal->matkulId->nomor;

        $stringPesanan =
            "Yth. Bapak/Ibu {$jadwal->matkulId->dosen}.\n" .
            "Jadwal {$jadwal->labId->laboratorium} - {$jadwal->jadwal}.\n" .
            "Mata Kuliah {$jadwal->matkulId->matakuliah}\n" .
            "Dimohon untuk mengisi E-Journal Laboratorium sebelum meninggalkan ruangan {$jadwal->labId->laboratorium}\n" .
            "https://laboratorium.sugenghartono.ac.id/jadwallab\n" .
            "Terima Kasih Banyak";

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
                'target'      => $destination,
                'message'     => $stringPesanan,
                'delay'       => 2,
                'typing'      => false,
                'countryCode' => '62',
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: cb4br9SeSXNT4V6Xi7LP'
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $this->error("Gagal kirim ke {$destination}: " . curl_error($curl));
        }

        curl_close($curl);
    }
}
