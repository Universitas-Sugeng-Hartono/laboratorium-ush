@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Jadwal Praktikum</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4>Ubah Jadwal</h4>
                    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Laboratorium</label>
                            <select name="lab_id" class="form-control">
                                <option value="">Pilih Laboratorium</option>
                                @foreach($lab as $labs)
                                <option value="{{ $labs->id }}" {{ $jadwal->lab_id == $labs->id ? 'selected' : '' }}>
                                    {{ $labs->laboratorium }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Program Studi</label>
                            <select name="program_id" class="form-control">
                                @foreach($programs as $program)
                                <option value="{{ $program->id }}"
                                    {{ $jadwal->program_id == $program->id ? 'selected' : '' }}>
                                    {{ $program->program }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                            <select name="matakuliah_id" class="form-control">
                                @foreach($matkuls as $matkul)
                                <option value="{{ $matkul->id }}"
                                    {{ $jadwal->matakuliah_id == $matkul->id ? 'selected' : '' }}>
                                    {{ $matkul->matakuliah }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jadwal" class="form-label">Jadwal</label>
                            <input type="datetime-local" name="jadwal" class="form-control"
                                value="{{ date('Y-m-d\TH:i', strtotime($jadwal->jadwal)) }}" required>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-primary">Update</button>
                        <a href="{{ route('jadwal.index') }}" class="btn btn-rounded btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection