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
<div class="row">
<div class="col-sm-12 col-md-12">
<div class="card">
<div class="card-body">
<div class="container">
    <h4>Tambah Tahun Akademik</h4>
    <form action="{{ route('ta.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="ta">Tahun Akademik</label>
            <input type="text" name="ta" id="ta" class="form-control" placeholder="Contoh: 2023/2024 Ganjil" required>
        </div>

        <div class="form-group mt-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="non-aktif">Non-Aktif</option>
                <option value="aktif">Aktif</option>
            </select>
            <small class="text-muted">Jika memilih Aktif, data TA lain otomatis menjadi non-aktif.</small>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Simpan</button>
        <a href="{{ route('ta.index') }}" class="btn btn-secondary mt-4">Kembali</a>
    </form>
</div>
    </div>
    </div>
    </div>
    </div>
@endsection
