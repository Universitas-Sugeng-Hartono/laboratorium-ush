@extends('layout.home')
@section('inti')
<style>
        .table-responsive {
            overflow-x: auto;
        }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Mata Kuliah</a></li>
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
    <div class="row mb-3">
        <!-- Form Pencarian -->
        <div class="col-md-4">
            <form action="{{ route('matkul.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                <div class="input-group w-100">
                    <label class="input-group-text">Tahun Ajaran</label>
                    <select name="ta_id" class="form-control">
                        <option value="">-- Pilih TA --</option>
                        @foreach ($ta as $akademik)
                        <option value="{{ $akademik->id }}" 
                            {{ (request('ta_id', $selectedTaId ?? '') == $akademik->id) ? 'selected' : '' }}>
                            {{ $akademik->ta }}{{ $akademik->status == 'aktif' ? ' (Aktif)' : '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-rounded">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Mata Kuliah</h4>
                    <a href="{{ route('matkul.create') }}" class="btn btn-rounded btn-primary mb-3">Create
                        Mata Kuliah</a>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Matakuliah</th>
                                <th>Dosen</th>
                                <th>Program Studi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matkuls as $index => $mk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mk->matakuliah }}</td>
                                <td>{{ $mk->dosen }}</td>
                                <td>{{ $mk->programId->program ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('matkul.edit', $mk->id) }}"
                                        class="btn btn-warning btn-rounded btn-sm">Edit</a>
                                    <form action="{{ route('matkul.destroy', $mk->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-rounded btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
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