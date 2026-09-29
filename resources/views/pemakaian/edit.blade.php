@extends('layout.home')
@section('inti')
<style>
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13.5px;
    }
    .form-label {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
    }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Ubah Peminjaman</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pemakaian.index') }}" class="text-muted">Peminjaman Lab</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Ubah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9 mx-auto">
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(isset($errors) && $errors->any())
            <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 10px;">
                <ul class="mb-0 small">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-body p-4">
                    <form action="{{ route('pemakaian.update', $pemakaian->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="nama">Nama peminjam</label>
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pemakaian->nama) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="nomor">Nomor WhatsApp</label>
                                <input type="text" name="nomor" id="nomor" class="form-control" inputmode="numeric" maxlength="15" placeholder="08... atau 628..." value="{{ old('nomor', $pemakaian->nomor) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="lab_id">Laboratorium</label>
                                <select name="lab_id" id="lab_id" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    @foreach($laboratorium as $lab)
                                    <option value="{{ $lab->id }}" {{ (string) old('lab_id', $pemakaian->lab_id) === (string) $lab->id ? 'selected' : '' }}>{{ $lab->laboratorium }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="program_id">Program studi</label>
                                <select name="program_id" id="program_id" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ (string) old('program_id', $pemakaian->program_id) === (string) $program->id ? 'selected' : '' }}>{{ $program->program }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="matakuliah_id">Mata kuliah</label>
                                <select name="matakuliah_id" id="matakuliah_id" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    @foreach($matkuls as $matkul)
                                    <option value="{{ $matkul->id }}" {{ (string) old('matakuliah_id', $pemakaian->matakuliah_id) === (string) $matkul->id ? 'selected' : '' }}>{{ $matkul->matakuliah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="keterangan">Status persetujuan</label>
                                <select name="keterangan" id="keterangan" class="form-select">
                                    @foreach(['setuju' => 'Disetujui', 'proses' => 'Sedang Diproses', 'ditolak' => 'Ditolak', 'menunggu' => 'Menunggu Validasi'] as $value => $label)
                                    <option value="{{ $value }}" {{ old('keterangan', $pemakaian->keterangan) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="tgl_peminjaman">Tanggal pinjam</label>
                                <input type="date" name="tgl_peminjaman" id="tgl_peminjaman" class="form-control" value="{{ old('tgl_peminjaman', $pemakaian->tgl_peminjaman ? \Carbon\Carbon::parse($pemakaian->tgl_peminjaman)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="tgl_pengembalian">Tanggal kembali</label>
                                <input type="date" name="tgl_pengembalian" id="tgl_pengembalian" class="form-control" value="{{ old('tgl_pengembalian', $pemakaian->tgl_pengembalian ? \Carbon\Carbon::parse($pemakaian->tgl_pengembalian)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="keperluan">Keperluan</label>
                                <textarea name="keperluan" id="keperluan" class="form-control" rows="3" required>{{ old('keperluan', $pemakaian->keperluan) }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('pemakaian.show', $pemakaian->id) }}" class="btn btn-light border" style="border-radius: 8px;">Batal</a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 8px;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
