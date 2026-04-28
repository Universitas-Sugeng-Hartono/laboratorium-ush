<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman</title>
    <link rel="stylesheet" href="{{ asset('dist/css/style.min.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
</head>
<style>
    .table-responsive {
            overflow-x: auto;
        }
</style>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Daftar Peminjaman Laboratorium</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card-header text-white d-flex justify-content-between align-items-center">
                    <a href="/create-peminjaman" class="btn btn-rounded btn-primary">
                        Buat Peminjaman Baru
                    </a>

                    <form action="/lihatpeminjaman" method="GET" class="d-flex">
                        <input type="date" name="tgl_peminjaman" class="form-control me-2"
                            value="{{ request('tgl_peminjaman') }}" required>
                        <button type="submit" class="btn btn-rounded  btn-light">Cari</button>
                    </form>
                </div>
                @if(request('tgl_peminjaman'))
                @if(isset($pemakaian) && $pemakaian->isEmpty())
                <div class="alert alert-warning text-center">Tidak ada data peminjaman untuk tanggal tersebut.</div>
                @elseif(isset($pemakaian))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peminjam</th>
                                    <th>Laboratorium</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Pengembalian</th>
                                    <th>Approval</th>
                                    <th>Pengembalian</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pemakaian as $pinjam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pinjam->nama }}</td>
                                    <td>{{ $pinjam->labId->laboratorium ?? '-' }}</td>
                                    <td>{{ $pinjam->tgl_peminjaman }}</td>
                                    <td>{{ $pinjam->tgl_pengembalian }}</td>
                                    <td>
                                        @if($pinjam->keterangan == 'setuju')
                                            <span class="badge bg-success text-white rounded-pill px-3 py-1">Disetujui</span>
                                        @elseif($pinjam->keterangan == 'proses')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1">Proses</span>
                                        @elseif($pinjam->keterangan == 'ditolak')
                                            <span class="badge bg-danger text-white rounded-pill px-3 py-1">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary text-white rounded-pill px-3 py-1">Menunggu Validasi</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pinjam->status_pengembalian == 'sudah')
                                            <span class="badge bg-success text-white rounded-pill px-3 py-1">Sudah</span>
                                        @else
                                            <span class="badge bg-secondary text-white rounded-pill px-3 py-1">Belum</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pinjam->keterangan == 'setuju')
                                            <a href="/peminjaman/{{ $pinjam->id }}/cetak" class="btn btn-rounded btn-primary btn-sm">Cetak</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @else
                <div class="alert alert-info text-center">Silakan pilih tanggal peminjaman untuk melihat data peminjaman.</div>
                @endif
            </div>
        </div>
    </div>
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{asset('dist/js/feather.min.js') }}"></script>
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{asset('dist/js/custom.min.js') }}"></script>
</body>

</html>