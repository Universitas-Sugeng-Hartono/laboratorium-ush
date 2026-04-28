@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">TA</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Tahun Akademik</h4>
        <div>
            <a href="{{ route('ta.otomatis') }}" class="btn btn-warning btn-rounded">Generate TA Otomatis</a>
            <a href="{{ route('ta.create') }}" class="btn btn-rounded btn-primary">Tambah TA</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<div class="row">
<div class="col-sm-12 col-md-12">
<div class="card">
    <div class="card-body">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Tahun Akademik</th>
                <th>Status</th>
                <th width="180">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ta as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->ta }}</td>
                    <td>
                        @if($item->status == 'aktif')
                            <span class="badge bg-success" style="border-radius:10px;">Aktif</span>
                        @else
                            <span class="badge bg-secondary" style="border-radius:10px;">Non-Aktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('ta.edit', $item->id) }}" class="btn btn-rounded btn-sm btn-warning">Edit</a>
                        <form action="{{ route('ta.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus TA ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-rounded btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Data Tahun Akademik belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>
</div>
@endsection
