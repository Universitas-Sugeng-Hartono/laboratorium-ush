@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Pemakaian/Peminjaman</a>
                        </li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pemakaian/Peminjaman</h4>
                    <form id="searchForm" method="GET" action="{{ route('pemakaian.index') }}" class="mb-3">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="searchNama" name="nama"
                                    placeholder="Cari Nama Peminjam" value="{{ request('nama') }}">
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" id="searchLab" name="lab_id">
                                    <option value="">-- Pilih Laboratorium --</option>
                                    @foreach($laboratories as $lab)
                                    <option value="{{ $lab->id }}"
                                        {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                                        {{ $lab->laboratorium }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <label class="input-group-text">Dari</label>
                                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <label class="input-group-text">Sampai</label>
                                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                                </div>
                            </div>
                            <div class="col-md-2 d-flex gap-1">
                                <button type="submit" class="btn btn-primary btn-rounded">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button type="submit" formaction="/pemakaian-export-pdf" formtarget="_blank"
                                    class="btn btn-danger btn-rounded">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </button>
                            </div>
                        </div>
                    </form>
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemakaian as $pinjam)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pinjam->nama }}</td>
                                <td>{{ $pinjam->labId->laboratorium }}</td>
                                <td>{{ $pinjam->tgl_peminjaman }}</td>
                                <td>{{ $pinjam->tgl_pengembalian }}</td>
                                <td>
                                    @if($pinjam->keterangan == 'setuju')
                                    <button class="btn btn-rounded btn-sm btn-success border ms-2"
                                        data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $pinjam->id }}">Setuju
                                    </button>
                                    @elseif($pinjam->keterangan == 'proses')
                                    <button class="btn btn-rounded btn-sm btn-light border ms-2" data-bs-toggle="modal"
                                        data-bs-target="#editStatusModal{{ $pinjam->id }}">Proses
                                    </button>
                                    @elseif($pinjam->keterangan == 'ditolak')
                                    <button class="btn btn-rounded btn-sm btn-danger border ms-2" data-bs-toggle="modal"
                                        data-bs-target="#editStatusModal{{ $pinjam->id }}">Ditolak
                                    </button>
                                    @else
                                    <button class="btn btn-rounded btn-sm btn-warning border ms-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editStatusModal{{ $pinjam->id }}">Menunggu
                                        Validasi
                                    </button>
                                    @endif
                                    <!-- Modal Ubah Status -->
                                    <div class="modal fade" id="editStatusModal{{ $pinjam->id }}" tabindex="-1"
                                        aria-labelledby="editStatusLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editStatusLabel">Ubah Status Peminjaman
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('pemakaian.update', $pinjam->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="{{ $pinjam->id }}">
                                                        <input type="hidden" name="nama" value="{{ $pinjam->nama }}">
                                                        <input type="hidden" name="matakuliah_id"
                                                            value="{{ $pinjam->matakuliah_id }}">
                                                        <input type="hidden" name="jadwal_id"
                                                            value="{{ $pinjam->jadwal_id }}">
                                                        <input type="hidden" name="program_id"
                                                            value="{{ $pinjam->program_id }}">
                                                        <input type="hidden" name="keperluan"
                                                            value="{{ $pinjam->keperluan }}">
                                                        <input type="hidden" name="tgl_peminjaman"
                                                            value="{{ $pinjam->tgl_peminjaman }}">
                                                        <input type="hidden" name="tgl_pengembalian"
                                                            value="{{ $pinjam->tgl_pengembalian }}">
                                                        <input type="hidden" name="alat_id"
                                                            value="{{ $pinjam->alat_id }}">
                                                        <input type="hidden" name="bahan_id"
                                                            value="{{ $pinjam->bahan_id }}">
                                                        <input type="hidden" name="lab_id"
                                                            value="{{ $pinjam->lab_id }}">
                                                        <input type="hidden" name="ttd" value="{{ Auth::user()->id }}">
                                                        <input type="hidden" name="ttd" value="{{ $pinjam->ttd }}">
                                                        <label for="keterangan" class="form-label">Status</label>
                                                        <select name="keterangan" id="keterangan" class="form-control">
                                                            <option value="setuju"
                                                                {{ $pinjam->keterangan == 'setuju' ? 'selected' : '' }}>
                                                                Disetujui</option>
                                                            <option value="proses"
                                                                {{ $pinjam->keterangan == 'proses' ? 'selected' : '' }}>
                                                                Proses</option>
                                                            <option value="ditolak"
                                                                {{ $pinjam->keterangan == 'ditolak' ? 'selected' : '' }}>
                                                                Ditolak</option>
                                                            <option value="menunggu"
                                                                {{ $pinjam->keterangan == 'menunggu' ? 'selected' : '' }}>
                                                                Menunggu Validasi</option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-rounded btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-rounded btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <a href="{{ route('pemakaian.show', $pinjam->id) }}"
                                        class="btn btn-rounded btn-warning btn-sm">Show</a>
                                    @if($pinjam->status_pengembalian !== 'sudah')
                                        <button class="btn btn-rounded btn-info btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#pengembalianModal{{ $pinjam->id }}">
                                            Pengembalian
                                        </button>
                                        <a href="{{ route('kirim.was', $pinjam->id) }}"
                                        class="btn btn-rounded btn-success btn-sm">Notify</a>
                                    @else
                                        <span class="badge btn-rounded bg-success">Sudah Dikembalikan</span>
                                    @endif
                                    <!-- Modal Pengembalian -->
                                    <div class="modal fade" id="pengembalianModal{{ $pinjam->id }}" tabindex="-1"
                                        aria-labelledby="pengembalianLabel{{ $pinjam->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg"> {{-- diperbesar agar tabel muat --}}
                                            <div class="modal-content">
                                                <form action="{{ route('pengembalian.store', $pinjam->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="pengembalianLabel{{ $pinjam->id }}">Pengembalian Barang</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Nama Peminjam:</strong> {{ $pinjam->nama }}</p>
                                                        <p><strong>Tanggal Peminjaman:</strong> {{ $pinjam->tgl_peminjaman }}</p>
                                                        <p><strong>Tanggal Pengembalian:</strong> {{ $pinjam->tgl_pengembalian }}</p>
                                                        <p class="text-danger">Pilih kondisi pengembalian untuk setiap item.</p>
                                    
                                                        <h5>Alat</h5>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Alat</th>
                                                                    <th>Jumlah Pinjam</th>
                                                                    <th>Jumlah Kembali</th>
                                                                    <th>Kondisi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if($pinjam->pemakaianAlat)
                                                                @foreach($pinjam->pemakaianAlat as $alat)
                                                                <tr>
                                                                    <td>{{ $alat->alatId->alat }}</td>
                                                                    <td>{{ $alat->jumlah_pinjam }}</td>
                                                                    <td>
                                                                        <input type="number" name="alat_kembali[{{ $alat->id }}][jumlah]"
                                                                            class="form-control" min="0" max="{{ $alat->jumlah_pinjam }}" required>
                                                                    </td>
                                                                    <td>
                                                                        <select name="alat_kembali[{{ $alat->id }}][rusak]" class="form-control" required>
                                                                            <option value="">-- Pilih Kondisi --</option>
                                                                            <option value="normal">Normal</option>
                                                                            <option value="rusak">Rusak</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                    
                                                        <h5>Bahan</h5>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Bahan</th>
                                                                    <th>Jumlah Pinjam</th>
                                                                    <th>Jumlah Kembali</th>
                                                                    <th>Kondisi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if($pinjam->pemakaianBahan)
                                                                @foreach($pinjam->pemakaianBahan as $bahan)
                                                                <tr>
                                                                    <td>{{ $bahan->bahanId->bahan }}</td>
                                                                    <td>{{ $bahan->jumlah_pakai }}</td>
                                                                    <td>
                                                                        <input type="number" name="bahan_kembali[{{ $bahan->id }}][jumlah]"
                                                                            class="form-control" min="0" max="{{ $bahan->jumlah_pakai }}" required>
                                                                    </td>
                                                                    <td>
                                                                        <select name="bahan_kembali[{{ $bahan->id }}][rusak]" class="form-control" required>
                                                                            <option value="">-- Pilih Kondisi --</option>
                                                                            <option value="normal">Normal</option>
                                                                            <option value="rusak">Rusak</option>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success btn-rounded">Konfirmasi Pengembalian</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="{{ route('pemakaian.destroy', $pinjam->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemakaian ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-rounded btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('searchLab').addEventListener('change', function() {
    document.getElementById('searchForm').submit();
});
</script>
@endsection