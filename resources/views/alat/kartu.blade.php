<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $alat->kode ?: 'Kartu alat' }}</title>
    <style>
        body { margin: 0; background: #f8fafc; color: #0f172a; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        main { max-width: 760px; margin: 0 auto; padding: 24px 16px 48px; }
        h1 { font-size: 22px; margin: 0 0 4px; }
        h2 { font-size: 16px; margin: 28px 0 10px; }
        .kode { color: #b91c1c; font-family: ui-monospace, monospace; font-weight: 700; }
        .kartu, .panel { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; }
        .kartu { margin-top: 16px; }
        dl { display: grid; grid-template-columns: 140px 1fr; gap: 8px 12px; margin: 0; }
        dt { color: #64748b; font-size: 13px; }
        dd { margin: 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { border-bottom: 1px solid #e2e8f0; text-align: left; padding: 8px 6px; vertical-align: top; }
        th { color: #64748b; font-size: 11px; text-transform: uppercase; }
        .aksi { display: flex; gap: 8px; margin-top: 16px; }
        a.tombol, button.tombol { background: #2563eb; color: #fff; text-decoration: none; border: 0; border-radius: 8px; padding: 8px 14px; font-size: 13px; cursor: pointer; }
        label { display: block; font-size: 12px; color: #64748b; margin-bottom: 4px; }
        input, select, textarea { width: 100%; box-sizing: border-box; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px; font: inherit; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .penuh { grid-column: 1 / -1; }
        .sukses { background: #dcfce7; color: #166534; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; }
        .galat { background: #fee2e2; color: #991b1b; border-radius: 8px; padding: 10px 12px; margin-bottom: 12px; }
        .kosong { color: #64748b; font-size: 13px; }
        @media (max-width: 640px) { dl, .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<main>
    @if(session('success'))
    <div class="sukses">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="galat">{{ $errors->first() }}</div>
    @endif

    <div class="kode">{{ $alat->kode ?: '-' }}</div>
    <h1>{{ $alat->alat }}</h1>
    <div class="kartu">
        <dl>
            <dt>Laboratorium</dt>
            <dd>{{ $alat->labId->laboratorium ?? '-' }}</dd>
            <dt>Lokasi simpan</dt>
            <dd>{{ $alat->lokasi_penyimpanan ?: '-' }}</dd>
            <dt>Keadaan sekarang</dt>
            <dd>{{ $alat->kondisi_label }} · {{ $alat->status_label }}</dd>
        </dl>
        @if($bolehUbah)
        <div class="aksi">
            <a class="tombol" href="{{ route('alat.edit', $alat->id) }}">Ubah</a>
        </div>
        @endif
    </div>

    <h2>Riwayat</h2>
    <div class="panel">
        @if($alat->riwayat->isEmpty())
        <p class="kosong">Belum ada riwayat.</p>
        @else
        <table>
            <thead>
                <tr><th>Tanggal</th><th>Pelapor</th><th>Jenis</th><th>Keterangan</th></tr>
            </thead>
            <tbody>
                @foreach($alat->riwayat as $riwayat)
                <tr>
                    <td>{{ $riwayat->tanggal->locale('id')->isoFormat('D MMMM Y') }}</td>
                    <td>{{ $riwayat->nama_pelapor }}</td>
                    <td>{{ $riwayat->jenis_label }}</td>
                    <td>{{ $riwayat->keterangan ?: '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <h2>Peminjaman</h2>
    <div class="panel">
        @if($peminjaman->isEmpty())
        <p class="kosong">Belum ada peminjaman tercatat.</p>
        @else
        <table>
            <thead>
                <tr><th>Tanggal</th><th>Nama</th><th>Keperluan</th><th>Jumlah</th><th>Pengembalian</th></tr>
            </thead>
            <tbody>
                @foreach($peminjaman as $baris)
                <tr>
                    <td>{{ optional($baris->pemakaian)->tgl_peminjaman ? \Carbon\Carbon::parse($baris->pemakaian->tgl_peminjaman)->locale('id')->isoFormat('D MMMM Y') : '-' }}</td>
                    <td>{{ optional($baris->pemakaian)->nama ?: '-' }}</td>
                    <td>{{ optional($baris->pemakaian)->keperluan ?: '-' }}</td>
                    <td>{{ $baris->jumlah_pinjam ?? '-' }}</td>
                    <td>{{ optional($baris->pemakaian)->status_pengembalian === 'sudah' ? 'Sudah kembali' : 'Belum kembali' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    @if($bolehUbah)
    <h2>Catat perubahan</h2>
    <form class="panel" method="POST" action="{{ route('alat.riwayat.store', $alat->id) }}">
        @csrf
        <div class="grid">
            <div>
                <label for="tanggal">Tanggal</label>
                <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', now()->timezone('Asia/Jakarta')->toDateString()) }}" required>
            </div>
            <div>
                <label for="nama_pelapor">Nama pelapor</label>
                <input id="nama_pelapor" type="text" name="nama_pelapor" value="{{ old('nama_pelapor', auth()->user()->name) }}" required>
            </div>
            <div>
                <label for="jenis">Jenis</label>
                <select id="jenis" name="jenis" required>
                    <option value="rusak" {{ old('jenis') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="dalam_perbaikan" {{ old('jenis') === 'dalam_perbaikan' ? 'selected' : '' }}>Dalam perbaikan</option>
                    <option value="layak_pakai" {{ old('jenis') === 'layak_pakai' ? 'selected' : '' }}>Layak pakai</option>
                </select>
            </div>
            <div class="penuh">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
            </div>
        </div>
        <div class="aksi">
            <button class="tombol" type="submit">Simpan riwayat</button>
        </div>
    </form>
    @endif
</main>
</body>
</html>
