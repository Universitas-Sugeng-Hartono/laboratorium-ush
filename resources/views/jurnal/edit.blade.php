@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Jurnal</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Update</li>
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
                    <form action="{{ route('jurnal.update', $jurnal->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Mata Kuliah</label>
                            <select name="matakuliah_id" class="form-control">
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($matkuls as $matkul)
                                <option value="{{ $matkul->id }}"
                                    {{ $jurnal->matakuliah_id == $matkul->id ? 'selected' : '' }}>
                                    {{ $matkul->matakuliah }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Program Studi</label>
                            <select name="program_id" class="form-control">
                                <option value="">Pilih Program Studi</option>
                                @foreach($programs as $program)
                                <option value="{{ $program->id }}"
                                    {{ $jurnal->program_id == $program->id ? 'selected' : '' }}>
                                    {{ $program->program }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="program_id" class="form-label">Laboratorium</label>
                            <select name="lab_id" class="form-control">
                                <option value="">Pilih Laboratorium</option>
                                @foreach($lab as $labs)
                                <option value="{{ $labs->id }}" {{ $jurnal->lab_id == $labs->id ? 'selected' : '' }}>
                                    {{ $labs->laboratorium }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="materi" class="form-label">Materi</label>
                            <input type="text" class="form-control" name="materi" value="{{ $jurnal->materi }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ $jurnal->tanggal }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" name="jam_mulai" value="{{ $jurnal->jam_mulai }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" name="jam_selesai"
                                value="{{ $jurnal->jam_selesai }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="ttd" class="form-label">Tanda Tangan (Gambar)</label>
                            <input type="file" class="form-control" name="ttd">
                            @if ($jurnal->ttd)
                            <img src="{{ asset('storage/' . $jurnal->ttd) }}" width="200">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Peserta</label>
                            <input type="number" class="form-control" name="jumlah" value="{{ $jurnal->jumlah }}">
                        </div>

                        <button type="submit" class="btn btn-rounded btn-primary btn-sm">Update</button>
                        <a href="{{ route('jurnal.index') }}" class="btn btn-rounded btn-secondary btn-sm">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection