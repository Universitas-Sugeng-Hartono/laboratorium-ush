<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    .header {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        border: 1px solid black;
        padding: 4px 8px;
        text-align: left;
        font-size: 12px;
    }

    th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    /* Trik tabel tanda tangan tanpa border */
    .signature-table {
        width: 100%;
        margin-top: 40px;
    }

    .signature-table td {
        text-align: center;
        padding-top: 50px;
        /* Ruang kosong untuk tanda tangan */
        border: none;
        /* Hilangkan border */
    }

    .footer {
        margin-top: 20px;
        text-align: center;
        font-size: 12px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Detail Peminjaman Laboratorium</div>

        <table class="table table-bordered">
            <tr>
                <th width="30%">Nama Peminjam</th>
                <td width="70%">{{ $peminjaman->nama }}</td>
            </tr>
            <tr>
                <th>Laboratorium</th>
                <td>{{ $peminjaman->labId->laboratorium }}</td>
            </tr>
            <tr>
                <th>Mata Kuliah</th>
                <td>{{ $peminjaman->matkulId->matakuliah ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Peminjaman</th>
                <td>{{ $peminjaman->tgl_peminjaman }}</td>
            </tr>
            <tr>
                <th>Tanggal Pengembalian</th>
                <td>{{ $peminjaman->tgl_pengembalian }}</td>
            </tr>
            <tr>
                <th>Keperluan</th>
                <td>{{ $peminjaman->keperluan }}</td>
            </tr>
        </table>

        <p>Isi Peminjaman/Pemakaian sebagai berikut:</p>
        <table class="table table-bordered">
            @if($peminjaman->alatId)
            <tr>
                <th width="30%">Peralatan</th>
                <td width="70%">{{ $peminjaman->alatId->alat }}</td>
            </tr>
            @endif
            @if($peminjaman->bahanId)
            <tr>
                <th>Bahan</th>
                <td>{{ $peminjaman->bahanId->bahan }}</td>
            </tr>
            @endif
        </table>

        <!-- Tanda tangan dengan trik tabel tanpa border -->
        <table class="signature-table">
            <tr>
                <td width="50%">Peminjam</td>
                <td width="50%">Kepala Program Studi</td>
            </tr>
            <tr>
                <td>
                    {{$peminjaman->ttd}}
                    {{$peminjaman->nama}}
                <td>______________________</td>
            </tr>
        </table>

        <table class="signature-table">
            <tr>
                <td>Kepala Laboratorium</td>
            </tr>
            <tr>
                <td>______________________</td>
            </tr>
        </table>

        <div class="footer">
            <p><i>Dokumen ini dihasilkan secara otomatis oleh sistem.</i></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>