<p>Laboratorium: <strong>{{ $laporan['laboratorium'] }}</strong></p>
<p>Tahun akademik: <strong>{{ $laporan['tahun_akademik'] }}</strong></p>
<p>Dihitung sampai {{ $laporan['hari_ini'] }}. Semester mahasiswa tidak membatasi laporan ini.</p>

<h3>Pemakaian ruangan</h3>
<p>{{ $laporan['pemakaian_ruangan'] }} pertemuan terjadwal</p>

<h3>Jurnal</h3>
<table>
    <tbody>
        <tr><td>Pertemuan yang tanggalnya sudah lewat</td><td>{{ $laporan['jurnal_lewat'] }}</td></tr>
        <tr><td>Sudah diisi</td><td>{{ $laporan['jurnal_sudah'] }}</td></tr>
        <tr><td>Belum diisi</td><td>{{ $laporan['jurnal_belum'] }}</td></tr>
        <tr><td>Persen terisi</td><td>{{ $laporan['jurnal_persen'] }}%</td></tr>
    </tbody>
</table>

<h3>Stok alat dan bahan</h3>
<table>
    <tbody>
        <tr><td>Alat</td><td>{{ $laporan['stok_alat_jenis'] }} jenis, {{ $laporan['stok_alat_unit'] }} unit</td></tr>
        <tr><td>Bahan</td><td>{{ $laporan['stok_bahan_jenis'] }} jenis, {{ $laporan['stok_bahan_unit'] }} unit</td></tr>
    </tbody>
</table>

<h3>Alat rusak atau maintenance</h3>
<p>{{ count($laporan['alat_bermasalah']) }} alat</p>
<table>
    <thead>
        <tr><th>Kode</th><th>Nama</th><th>Kondisi</th><th>Status</th></tr>
    </thead>
    <tbody>
        @forelse($laporan['alat_bermasalah'] as $alat)
        <tr>
            <td>{{ $alat['kode'] }}</td>
            <td>{{ $alat['nama'] }}</td>
            <td>{{ $alat['kondisi'] }}</td>
            <td>{{ $alat['status'] }}</td>
        </tr>
        @empty
        <tr><td colspan="4">Tidak ada</td></tr>
        @endforelse
    </tbody>
</table>

<h3>Bahan habis atau mencapai stok minimum</h3>
<p>{{ count($laporan['bahan_kritis']) }} bahan</p>
<table>
    <thead>
        <tr><th>Kode</th><th>Nama</th><th>Jumlah</th><th>Keadaan</th></tr>
    </thead>
    <tbody>
        @forelse($laporan['bahan_kritis'] as $bahan)
        <tr>
            <td>{{ $bahan['kode'] }}</td>
            <td>{{ $bahan['nama'] }}</td>
            <td>{{ $bahan['jumlah'] }} {{ $bahan['satuan'] }} (min {{ $bahan['minimum'] }})</td>
            <td>{{ $bahan['keadaan'] }}</td>
        </tr>
        @empty
        <tr><td colspan="4">Tidak ada</td></tr>
        @endforelse
    </tbody>
</table>

<h3>Bahan kedaluwarsa</h3>
<p>Sudah kedaluwarsa, atau akan kedaluwarsa sampai {{ $laporan['batas_kedaluwarsa'] }}. {{ count($laporan['bahan_kedaluwarsa']) }} bahan.</p>
<table>
    <thead>
        <tr><th>Kode</th><th>Nama</th><th>Jumlah</th><th>Tanggal</th><th>Tanda</th></tr>
    </thead>
    <tbody>
        @forelse($laporan['bahan_kedaluwarsa'] as $bahan)
        <tr>
            <td>{{ $bahan['kode'] }}</td>
            <td>{{ $bahan['nama'] }}</td>
            <td>{{ $bahan['jumlah'] }} {{ $bahan['satuan'] }}</td>
            <td>{{ $bahan['tanggal'] }}</td>
            <td>{{ $bahan['tanda'] }}</td>
        </tr>
        @empty
        <tr><td colspan="5">Tidak ada</td></tr>
        @endforelse
    </tbody>
</table>
