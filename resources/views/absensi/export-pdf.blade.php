<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Daftar Hadir Tamu Laboratorium</title>
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
        <h2>Laporan Daftar Kunjungan Tamu
            @if ($laboratorium)
            {{ $laboratorium->laboratorium }}
            @else
            Semua Laboratorium
            @endif
        </h2>
    </center>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tamu</th>
                <th>Laboratorium</th>
                <th>Tanggal, Jam</th>
                <th>Keperluan</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $key => $absensi)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $absensi->tamu }}</td>
                <td>{{ $absensi->labId->laboratorium }}</td>
                <td>{{ $absensi->tanggal }}, {{ $absensi->jam }}</td>
                <td>{{ $absensi->keperluan }}</td>
                <td>
                    @if($absensi->ttd && file_exists(storage_path('app/public/'.$absensi->ttd)))
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/'.$absensi->ttd))) }}"
                        width="50">
                    @else
                    <p class="text-muted">Belum ada tanda tangan</p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>