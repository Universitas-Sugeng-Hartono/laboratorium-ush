<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alat;
use App\Models\Laboratorium;
use Illuminate\Support\Facades\DB;

class SyncInventoryMultimediaSeeder extends Seeder
{
    public function run()
    {
        $lab = Laboratorium::where('laboratorium', 'like', '%Multimedia%')->first();
        if (!$lab) {
            $lab = Laboratorium::find(4);
        }

        $labId = $lab ? $lab->id : 4;

        $items = [
            ['nama' => 'Kursi', 'merk' => 'Futura', 'satuan' => 'Unit', 'jumlah' => 10, 'kondisi' => 'baik'],
            ['nama' => 'Kursi Bar', 'merk' => null, 'satuan' => 'Unit', 'jumlah' => 2, 'kondisi' => 'baik'],
            ['nama' => 'Meja Kayu', 'merk' => 'Stop Kontak', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Meja Kayu', 'merk' => 'Polos', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Meja PC', 'merk' => null, 'satuan' => 'Unit', 'jumlah' => 2, 'kondisi' => 'baik'],
            ['nama' => 'Meja Lipat Kelas', 'merk' => null, 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Meja Bulat', 'merk' => null, 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Meja Front Desk', 'merk' => 'Putih', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Sofa Besar', 'merk' => 'Coklat', 'satuan' => 'Unit', 'jumlah' => 2, 'kondisi' => 'baik'],
            ['nama' => 'Sofa Kecil', 'merk' => 'Abu-abu', 'satuan' => 'Unit', 'jumlah' => 7, 'kondisi' => 'rusak_ringan', 'catatan' => '1 unit kaki patah, 6 unit baik'],
            ['nama' => 'Bantal Sofa', 'merk' => 'Persegi Coklat', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Sofa Bulat', 'merk' => 'Abu-abu', 'satuan' => 'Unit', 'jumlah' => 2, 'kondisi' => 'baik'],
            ['nama' => 'AC', 'merk' => 'Gree', 'satuan' => 'Unit', 'jumlah' => 2, 'kondisi' => 'baik'],
            ['nama' => 'Remote AC', 'merk' => 'Gree', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'TV 55"', 'merk' => 'Panasonic TH-50C410G', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'LED TV 55"', 'merk' => 'LG MAY67733101', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Remote TV', 'merk' => 'Panasonic', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Stand & Breket TV', 'merk' => null, 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Lemari Kaca', 'merk' => 'Putih', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Background Dinding', 'merk' => 'Hitam, Hijau, Biru', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Background Dinding', 'merk' => 'Tassel Oranye', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Background Dinding', 'merk' => 'Brokat Emas', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Background & Stand', 'merk' => 'Green', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Background (Kain saja)', 'merk' => 'Green', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Soft Box Besar', 'merk' => 'Godox MS300', 'satuan' => 'Unit', 'jumlah' => 2, 'kondisi' => 'baik'],
            ['nama' => 'Soft Box Kecil', 'merk' => 'TNW', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Remote Soft Box', 'merk' => 'TNW', 'satuan' => 'Unit', 'jumlah' => 2, 'kondisi' => 'baik'],
            ['nama' => 'Monitor PC', 'merk' => 'HP V22Ve G5', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'CPU', 'merk' => 'HP 4CE425B5K5', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Keyboard', 'merk' => 'HP', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Keyboard', 'merk' => 'MTech', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Mouse', 'merk' => 'HP', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Gantungan Baju', 'merk' => null, 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Hanger', 'merk' => null, 'satuan' => 'Unit', 'jumlah' => 5, 'kondisi' => 'baik'],
            ['nama' => 'Jas Almamater', 'merk' => 'S, M, L, XL, XXL', 'satuan' => 'Unit', 'jumlah' => 5, 'kondisi' => 'baik'],
            ['nama' => 'White Board', 'merk' => null, 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Penghapus White Board', 'merk' => 'Gunindo WB-803', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Cermin Standing', 'merk' => null, 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Tripod', 'merk' => 'WF WT3150', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Tripod', 'merk' => 'Benro T600EX', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Tripod', 'merk' => 'Somita ST-3520', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Drone', 'merk' => 'Tello TLW004', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Kamera', 'merk' => 'Canon 750D', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Tas Camera', 'merk' => 'Canon', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Battery Charger', 'merk' => 'Canon 750D', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Braket TV', 'merk' => null, 'satuan' => 'Set', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Kabel USB Connector', 'merk' => 'Biru', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Tas Camera', 'merk' => 'Eos', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Wireless Microphone', 'merk' => 'Mixio Lavalier', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Microport Receiver', 'merk' => 'Sennheiser SKM9000 MK II', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'LCD', 'merk' => 'Epson', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Microphone', 'merk' => 'Advance MIC-301', 'satuan' => 'Set', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Roll Kabel', 'merk' => 'Putih - 3', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Roll Kabel', 'merk' => 'Putih - 4', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Box File', 'merk' => 'Ficaro Biru', 'satuan' => 'Unit', 'jumlah' => 4, 'kondisi' => 'baik'],
            ['nama' => 'Logbook', 'merk' => 'Gelatik', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Kabel Aux', 'merk' => 'Abu-abu', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Kabel RCA 2 Way + Connector', 'merk' => 'Teracota', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
            ['nama' => 'Gunting', 'merk' => 'Hitam', 'satuan' => 'Unit', 'jumlah' => 2, 'kondisi' => 'baik'],
            ['nama' => 'Sisir', 'merk' => 'Ungu', 'satuan' => 'Unit', 'jumlah' => 1, 'kondisi' => 'baik'],
        ];

        DB::transaction(function () use ($labId, $items) {
            // Re-sync Lab 4 items:
            // First get existing items in Lab 4
            $existing = Alat::where('lab_id', $labId)->orderBy('id')->get();

            foreach ($items as $index => $item) {
                $codeNum = sprintf('%03d', 55 + $index);
                $title = '[Lab Multimedia] ' . $item['nama'] . ($item['merk'] ? ' (' . $item['merk'] . ')' : '');
                $spesifikasi = ($item['merk'] ? 'Merk/Tipe: ' . $item['merk'] . ', ' : '') . 'Satuan: ' . $item['satuan'] . (isset($item['catatan']) ? ' | ' . $item['catatan'] : '');

                if (isset($existing[$index])) {
                    // Update existing row in place to preserve relation IDs
                    $existing[$index]->update([
                        'kode' => 'ALT-' . $codeNum,
                        'alat' => $title,
                        'jumlah' => $item['jumlah'],
                        'kondisi' => $item['kondisi'],
                        'status' => 'tersedia',
                        'spesifikasi' => $spesifikasi,
                        'lokasi_penyimpanan' => 'Lab Multimedia FTHB'
                    ]);
                } else {
                    // Insert new row
                    Alat::create([
                        'lab_id' => $labId,
                        'kode' => 'ALT-' . $codeNum,
                        'alat' => $title,
                        'jumlah' => $item['jumlah'],
                        'kondisi' => $item['kondisi'],
                        'status' => 'tersedia',
                        'spesifikasi' => $spesifikasi,
                        'lokasi_penyimpanan' => 'Lab Multimedia FTHB'
                    ]);
                }
            }
        });
    }
}
