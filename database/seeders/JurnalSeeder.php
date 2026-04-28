<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Jurnal;
use Carbon\Carbon;

class JurnalSeeder extends Seeder
{
    /**
     * Jumlah mahasiswa per matakuliah_id (dari CSV).
     */
    private function getJumlahMahasiswa(): array
    {
        return [
            73 => 44,  // Database Design
            74 => 24,  // Distributed Systems
            75 => 25,  // Business Statistic A1
            76 => 44,  // Business Process
            77 => 25,  // Business Statistic A2
            78 => 25,  // Database Management A2
            79 => 25,  // Programming and Algorithms A2
            80 => 44,  // Basic Programming
            81 => 25,  // Programming and Algorithms A1
            83 => 36,  // Artificial Intelegent
            84 => 25,  // UI/IX (A2)
            85 => 25,  // Database Management A1
            86 => 24,  // Indirect
            87 => 36,  // Business Intelligence
            88 => 36,  // Network Security
            89 => 25,  // UI/IX (A1)
            90 => 25,  // Mobile Dev (A1)
            91 => 25,  // Mobile Dev (A2)
            92 => 36,  // Web Programming II
            93 => 20,  // Grafika Komputer
            96 => 36,  // Digital Marketing (IT)
            98 => 24,  // Internet Of Things (IT)
        ];
    }

    /**
     * Materi sample per matakuliah_id.
     * Setiap matkul punya array 4 materi (untuk 4 pertemuan).
     */
    private function getMateri(): array
    {
        return [
            73 => [
                'Pengenalan Database Design dan Normalisasi',
                'Entity Relationship Diagram (ERD)',
                'Normalisasi 1NF, 2NF, 3NF',
                'Implementasi DDL dan DML',
            ],
            74 => [
                'Pengenalan Sistem Terdistribusi',
                'Arsitektur Client-Server dan P2P',
                'Remote Procedure Call (RPC)',
                'Middleware dan Message Passing',
            ],
            75 => [
                'Pengantar Statistika Bisnis',
                'Distribusi Frekuensi dan Visualisasi Data',
                'Ukuran Pemusatan Data',
                'Ukuran Penyebaran Data',
            ],
            76 => [
                'Pengenalan Proses Bisnis',
                'Business Process Modeling Notation (BPMN)',
                'Analisis dan Optimasi Proses Bisnis',
                'Implementasi Workflow Automation',
            ],
            77 => [
                'Pengantar Statistika Bisnis',
                'Distribusi Frekuensi dan Visualisasi Data',
                'Ukuran Pemusatan Data',
                'Ukuran Penyebaran Data',
            ],
            78 => [
                'Pengenalan DBMS dan SQL Dasar',
                'DDL: Create, Alter, Drop',
                'DML: Insert, Update, Delete, Select',
                'Join dan Subquery',
            ],
            79 => [
                'Pengenalan Algoritma dan Pseudocode',
                'Struktur Kontrol: Percabangan',
                'Struktur Kontrol: Perulangan',
                'Array dan Fungsi',
            ],
            80 => [
                'Pengenalan Pemrograman dan IDE',
                'Variabel, Tipe Data, dan Operator',
                'Percabangan If-Else dan Switch',
                'Perulangan For, While, Do-While',
            ],
            81 => [
                'Pengenalan Algoritma dan Pseudocode',
                'Struktur Kontrol: Percabangan',
                'Struktur Kontrol: Perulangan',
                'Array dan Fungsi',
            ],
            83 => [
                'Pengenalan Artificial Intelligence',
                'Search Algorithms: BFS dan DFS',
                'Heuristic Search dan A*',
                'Machine Learning: Supervised Learning',
            ],
            84 => [
                'Prinsip Dasar UI/UX Design',
                'User Research dan Persona',
                'Wireframing dan Prototyping',
                'Usability Testing',
            ],
            85 => [
                'Pengenalan DBMS dan SQL Dasar',
                'DDL: Create, Alter, Drop',
                'DML: Insert, Update, Delete, Select',
                'Join dan Subquery',
            ],
            86 => [
                'Sesi Bimbingan dan Konsultasi Tugas',
                'Review Materi dan Diskusi',
                'Presentasi Progress Tugas',
                'Evaluasi dan Feedback',
            ],
            87 => [
                'Pengenalan Business Intelligence',
                'Data Warehousing Concept',
                'ETL Process',
                'Dashboard dan Data Visualization',
            ],
            88 => [
                'Pengenalan Keamanan Jaringan',
                'Kriptografi dan Enkripsi',
                'Firewall dan IDS/IPS',
                'Network Scanning dan Vulnerability Assessment',
            ],
            89 => [
                'Prinsip Dasar UI/UX Design',
                'User Research dan Persona',
                'Wireframing dan Prototyping',
                'Usability Testing',
            ],
            90 => [
                'Pengenalan Mobile Development',
                'Layout dan Widget Dasar',
                'Navigation dan State Management',
                'API Integration',
            ],
            91 => [
                'Pengenalan Mobile Development',
                'Layout dan Widget Dasar',
                'Navigation dan State Management',
                'API Integration',
            ],
            92 => [
                'Review Web Programming I dan Setup Framework',
                'MVC Architecture dan Routing',
                'Database Migration dan Eloquent ORM',
                'CRUD Operations dan Form Handling',
            ],
            93 => [
                'Pengenalan Grafika Komputer',
                'Transformasi 2D: Translasi, Rotasi, Skala',
                'Rendering dan Shading',
                'Animasi dan Interaksi',
            ],
            96 => [
                'Pengenalan Digital Marketing',
                'SEO dan SEM Fundamentals',
                'Social Media Marketing Strategy',
                'Content Marketing dan Analytics',
            ],
            98 => [
                'Pengenalan Internet of Things',
                'Arsitektur IoT dan Sensor',
                'Protokol Komunikasi IoT (MQTT, CoAP)',
                'Implementasi IoT dengan Microcontroller',
            ],
        ];
    }

    public function run()
    {
        $jumlahMap = $this->getJumlahMahasiswa();
        $materiMap = $this->getMateri();

        // Matkul IDs dari CSV (hanya yang ada di jadwal)
        $csvMkIds = array_keys($jumlahMap);

        // Ambil jadwal dalam 2 rentang tanggal
        $jadwals = Jadwal::whereIn('matakuliah_id', $csvMkIds)
            ->where(function ($q) {
                $q->whereBetween('jadwal', ['2026-03-09', '2026-03-18 23:59:59'])
                   ->orWhereBetween('jadwal', ['2026-03-31', '2026-04-09 23:59:59']);
            })
            ->orderBy('jadwal')
            ->get();

        // Track materi index per matakuliah_id
        $materiIndex = [];

        $created = 0;

        foreach ($jadwals as $jadwal) {
            $mkId = $jadwal->matakuliah_id;

            // Skip jika sudah ada jurnal untuk jadwal ini
            if (Jurnal::where('jadwal_id', $jadwal->id)->exists()) {
                continue;
            }

            // Tentukan index materi (cycle melalui array materi)
            if (!isset($materiIndex[$mkId])) {
                $materiIndex[$mkId] = 0;
            }
            $materiList = $materiMap[$mkId] ?? ['Materi Praktikum'];
            $materi = $materiList[$materiIndex[$mkId] % count($materiList)];
            $materiIndex[$mkId]++;

            // Jam mulai dari jadwal, jam selesai +170 menit (2 jam 50 menit)
            $jamMulai = Carbon::parse($jadwal->jadwal);
            $tanggal = $jamMulai->format('Y-m-d');
            $jamMulaiStr = $jamMulai->format('H:i');
            $jamSelesai = $jamMulai->copy()->addMinutes(170)->format('H:i');

            // Jumlah peserta dari CSV
            $jumlah = $jumlahMap[$mkId] ?? 25;

            Jurnal::create([
                'matakuliah_id' => $mkId,
                'jadwal_id'     => $jadwal->id,
                'program_id'    => $jadwal->program_id,
                'materi'        => $materi,
                'tanggal'       => $tanggal,
                'jam_mulai'     => $jamMulaiStr,
                'jam_selesai'   => $jamSelesai,
                'ttd'           => null,
                'jumlah'        => $jumlah,
                'lab_id'        => $jadwal->lab_id,
            ]);

            $created++;
        }

        $this->command->info("Berhasil membuat {$created} jurnal.");
    }
}
