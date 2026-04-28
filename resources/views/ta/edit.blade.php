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
    <h4>Edit Tahun Akademik</h4>
    <form action="{{ route('ta.update', $ta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ta">Tahun Akademik</label>
            <input type="text" name="ta" id="ta" class="form-control" value="{{ $ta->ta }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="non-aktif" {{ $ta->status == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                <option value="aktif" {{ $ta->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
            </select>
            <small class="text-muted">Hanya satu TA yang bisa aktif.</small>
        </div>

        <button type="submit" class="btn btn-success mt-4">Update</button>
        <a href="{{ route('ta.index') }}" class="btn btn-secondary mt-4">Kembali</a>
    </form>
</div>
    </div>
    </div>
    </div>
    </div>
@endsection
