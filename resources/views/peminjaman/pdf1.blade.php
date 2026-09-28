<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    @page {
        margin: 3px;
    }

    .container {
        width: 100%;
        max-width: 800px;
        margin: auto;
        font-family: Arial, sans-serif;
    }

    .header-logo {
        text-align: center;
    }

    .header-logo img {
        width: 100%;
        max-width: 1000px;
        display: block;
        margin: auto;
    }

    .header {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        margin-top: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .table th,
    .table td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    .signature-table {
        width: 100%;
        text-align: center;
        margin-top: 20px;
    }

    .signature-table td {
        padding: 20px;
    }

    .signature img {
        width: 150px;
        height: auto;
    }

    .footer {
        position: fixed;
        bottom: 10px;
        right: 10px;
        font-size: 12px;
        color: #555;
        font-style: italic;
    }

    .tight-spacing {
        margin: 2px 0;
        line-height: 1;
    }

    @media print {
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .container {
            max-width: none;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Kop Surat (Logo) -->
        <div class="header-logo">
            <img src="{{ file_exists(public_path('storage/signatures/logo.png')) ? asset('storage/signatures/logo.png') : asset('img/itsk.png') }}" width="100%" alt="Kop Surat">
        </div>

        <div class="header">Detail Peminjaman Laboratorium</div>

        <!-- Data Peminjaman -->
        <table class="table">
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
            @if($alats->isNotEmpty())
            <tr>
                <th width="30%">Peralatan</th>
                <td width="70%">
                    <ul class="list-unstyled">
                        @foreach($alats as $alat)
                        <li>{{ $alat->alat }} (Jumlah: {{ $alat->jumlah_pinjam }})</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endif
            @if($bahans->isNotEmpty())
            <tr>
                <th width="30%">Bahan</th>
                <td width="70%">
                    <ul class="list-unstyled">
                        @foreach($bahans as $bahan)
                        <li>{{ $bahan->bahan }} - {{ $bahan->pivot->jumlah_pakai }}{{ $bahan->satuan }} </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endif
        </table>
        <!-- Tanda Tangan -->
        <table class="signature-table">
            <tr>
                <center>
                    <td colspan="2" class="text-right">
                        Sukoharjo, {{ $peminjaman->tgl_peminjaman }}
                    </td>
                </center>
            </tr>
            <tr>
                <td>Peminjam</td>
                <td>Laboran/Teknisi</td>
            </tr>
            <tr>
                <td class="signature">
                    @if($peminjaman->ttd)
                    <img src="{{ asset('storage/app/public/' . $peminjaman->ttd) }}" alt="Tanda Tangan Peminjam">
                    @else
                    <p>______________________</p>
                    @endif
                    <p class="tight-spacing">{{ $peminjaman->nama }}</p>
                    <p class="tight-spacing">______________________</p>
                </td>
                <td class="signature">
                    @if($peminjaman->ttd)
                    <img src="{{ asset('storage/app/public/' . $peminjaman->ttd) }}" alt="Tanda Tangan Peminjam">
                    @else
                    @endif
                    <p class="tight-spacing">
                        @if(in_array($peminjaman->lab_id, [1, 7]))
                        FIkri Lutfi Satrianto, Amd.Kom
                        @elseif(in_array($peminjaman->lab_id, [2, 3]))
                        FIkri Lutfi Satrianto, Amd.Kom
                        @elseif(in_array($peminjaman->lab_id, [4, 5, 6]))
                        Rika Wahyuningsih, Amd.Si
                        @elseif(in_array($peminjaman->lab_id, [9, 10]))
                        Wida
                        @else
                        Kepala Program Studi Tidak Diketahui
                        @endif
                    </p>
                    <p class="tight-spacing">______________________</p>
                </td>
            </tr>
        </table>

        <!-- Tanda tangan Kepala Laboratorium -->
        <table class="signature-table">
            <tr>
                <td>Kepala Program Studi</td>
            </tr>
            <tr>
                <td class="signature">
                    </br></br></br>
                    <p style="margin-bottom: 0;">
                        @if(in_array($peminjaman->lab_id, [1, 7]))
                        Dwi Utari Iswavirga, S.ST, M.Kom
                        @elseif(in_array($peminjaman->lab_id, [2, 3]))
                        Graceilla Kristia Serpahim Budiono, S.E, M.B.A
                        @elseif(in_array($peminjaman->lab_id, [4, 5, 6, 9, 10]))
                        Yuniar Renowening, S.Gz, M.Gz
                        @else
                        Kepala Program Studi Tidak Diketahui
                        @endif
                    </p>
                    <p style="margin-top: -10px;">______________________</p>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p><i>Dokumen ini dihasilkan secara otomatis oleh sistem.</i></p>
        </div>
    </div>
    <script>
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 500); // Delay 500ms agar halaman sepenuhnya dimuat
    };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>