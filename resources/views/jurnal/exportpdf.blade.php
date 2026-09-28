<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Jurnal Perkuliahan Laboratorium</title>
    <style>
        @page { margin: 2px; }
        body { font-family: Arial, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    @php
        $logoPath = storage_path('app/public/signatures/logo.png');
        if (!file_exists($logoPath)) {
            $logoPath = public_path('img/itsk.png');
        }
    @endphp
    @if(file_exists($logoPath))
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}" width="100%">
    @endif
    <center>
        <h2>Laporan Jurnal Praktikum {{ $jurnals->first()?->matkulId?->matakuliah ?? '' }}</br>
            @if ($laboratorium && $program)
                {{ $laboratorium->laboratorium }} dan Program Studi S1 - {{ $program->program }}
            @elseif ($laboratorium)
                {{ $laboratorium->laboratorium }}
            @elseif ($program)
                Program Studi S1 - {{ $program->program }}
            @else
                Semua Laboratorium
            @endif
        </h2>
    </center>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Dosen</th>
                <th>Program Studi</th>
                <th>Mata Kuliah</th>
                <th>Materi</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Jumlah Peserta</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jurnals as $key => $jurnal)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $jurnal->matkulId?->dosen ?? '-' }}</td>
                <td>{{ $jurnal->programId?->program ?? '-' }}</td>
                <td>{{ $jurnal->matkulId?->matakuliah ?? '-' }}</td>
                <td>{{ $jurnal->materi }}</td>
                <td>{{ $jurnal->tanggal }}</td>
                <td>{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</td>
                <td>{{ $jurnal->jumlah }}</td>
                <td>
                    @if($jurnal->ttd && file_exists(storage_path('app/public/'.$jurnal->ttd)))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/'.$jurnal->ttd))) }}" width="50">
                    @else
                        <p class="text-muted">Belum ada tanda tangan</p>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; padding: 15px; color: #64748b;">Tidak ada data jurnal untuk periode / mata kuliah ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <p>{{ $today }}</p>
    @if ($jurnals->count())
    @php
        $pengampus = $jurnals->groupBy('matakuliah_id')->map(function($items) {
            $first = $items->first();
            return [
                'dosen' => $first?->matkulId?->dosen ?? '-',
                'ttd'   => $first?->ttd ?? null
            ];
        })->values();
    @endphp

    <table style="width: 100%; margin-top: 30px; border: none;">
        <tr>
            @foreach ($pengampus as $data)
                <td style="width: 200px; text-align: left; vertical-align: top; border: none; padding-right: 40px;">
                    <strong>Dosen Pengampu:</strong><br><br>
                    @if($data['ttd'] && file_exists(storage_path('app/public/' . $data['ttd'])))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $data['ttd']))) }}" width="125"><br>
                    @else
                        <div style="width: 125px; height: 50px; border: 1px dashed #ccc;"></div><br>
                    @endif
                    <u>{{ $data['dosen'] }}</u>
                </td>
            @endforeach
        </tr>
    </table>
    @endif
</body>
</html>
