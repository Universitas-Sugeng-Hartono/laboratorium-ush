<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Jurnal Perkuliahan Laboratorium</title>
    <style>
    @page {
        margin: 2px;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
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
        <h2>Laporan Jurnal
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
            </tr>
        </thead>
        <tbody>
            @foreach ($jurnals as $key => $jurnal)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $jurnal->matkulId->dosen }}</td>
                <td>{{ $jurnal->matkulId->matakuliah }}</td>
                <td>{{ $jurnal->programId->program }}</td>
                <td>{{ $jurnal->materi }}</td>
                <td>{{ $jurnal->tanggal }}</td>
                <td>{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</td>
                <td>{{ $jurnal->jumlah }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
