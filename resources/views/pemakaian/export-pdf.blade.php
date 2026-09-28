<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pemakaian / Peminjaman Peralatan Laboratorium</title>
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
        <h2>Laporan Pemakaian / Peminjaman Peralatan
            {{ $laboratorium->laboratorium ?? 'Semua Laboratorium' }}
        </h2>
    </center>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Laboratorium</th>
                <th>Program Studi</th>
                <th>Tanggal Pemakaian</th>
                <th>Tanggal Pengembalian</th>
                <th>Keperluan</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemakaian as $key => $pemakaian)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $pemakaian->nama }}</td>
                <td>{{ $pemakaian->labId->laboratorium }}</td>
                <td>{{ $pemakaian->programId->program }}</td>
                <td>{{ $pemakaian->tgl_peminjaman }}</td>
                <td>{{ $pemakaian->tgl_pengembalian }}</td>
                <td>{{ $pemakaian->keperluan }}</td>
                <td>
                    @if($pemakaian->ttd && file_exists(storage_path('app/public/'.$pemakaian->ttd)))
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/'.$pemakaian->ttd))) }}"
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