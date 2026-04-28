@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Buku Tamu</a></li>
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
                    <h4 class="card-title">Buku Tamu</h4>
                    <!-- <a href="{{ route('absensi.create') }}" class="btn btn-rounded btn-primary mb-3">Create Tamu
                    </a> -->
                    <div class="row g-2 align-items-center mb-3">
                        <div class="col-md-9">
                            <form action="{{ route('absensi.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                                <div class="input-group">
                                    <label class="input-group-text">Lab</label>
                                    <select name="lab_id" class="form-control">
                                        <option value="">-- Pilih Lab --</option>
                                        @foreach ($labs as $lab)
                                        <option value="{{ $lab->id }}"
                                            {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                                            {{ $lab->laboratorium }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group">
                                    <label class="input-group-text">Dari</label>
                                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                                </div>
                                <div class="input-group">
                                    <label class="input-group-text">Sampai</label>
                                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                                </div>
                                <button type="submit" class="btn btn-primary btn-rounded">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-3 text-end">
                            <form action="/tamu-export-pdf" method="GET" target="_blank">
                                <input type="hidden" name="lab_id" value="{{ request('lab_id') }}">
                                <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                                <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                                <button type="submit" class="btn btn-danger btn-rounded">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tamu</th>
                                <th>Laboratorium</th>
                                <th>Tanggal, Jam</th>
                                <th>Keperluan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absen as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->tamu }}</td>
                                <td>{{ $data->labId->laboratorium }}</td>
                                <td>{{ $data->tanggal }}, {{ $data->jam }}</td>
                                <td>{{ $data->keperluan }}</td>
                                <td>
                                    <a href="{{ route('absensi.edit', $data->id) }}"
                                        class="btn btn-rounded btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('absensi.destroy', $data->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-rounded btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">Delete</button>
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
@endsection