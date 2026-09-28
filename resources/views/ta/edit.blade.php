@extends('layout.home')
@section('inti')
<style>
    .card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        padding: 24px 28px;
    }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Ubah Tahun Akademik</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/home" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ta.index') }}" class="text-muted">Tahun Akademik</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Edit Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-modern">
                <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom">
                    <div class="p-2 rounded-3 bg-warning-subtle text-warning">
                        <i class="fa fa-calendar-check fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Ubah Data Tahun Akademik</h5>
                        <small class="text-muted">Perbarui informasi periode akademik dan status aktif sistem</small>
                    </div>
                </div>

                @if(isset($errors) && $errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('ta.update', $ta->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="ta" class="form-label small fw-semibold text-secondary">Tahun Akademik & Semester <span class="text-danger">*</span></label>
                        <input type="text" name="ta" id="ta" class="form-control rounded-3" value="{{ old('ta', $ta->ta) }}" required>
                        <div class="form-text small text-muted">Format standar: <code>[Tahun1]/[Tahun2] [Ganjil/Genap]</code>.</div>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label small fw-semibold text-secondary">Status Sistem</label>
                        <select name="status" id="status" class="form-select rounded-3">
                            <option value="non-aktif" {{ old('status', $ta->status) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            <option value="aktif" {{ old('status', $ta->status) == 'aktif' ? 'selected' : '' }}>Aktif (Sebagai Semester Berjalan)</option>
                        </select>
                        <div class="form-text small text-muted">Hanya 1 Tahun Akademik yang dapat berstatus aktif pada satu waktu.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="{{ route('ta.index') }}" class="btn btn-light rounded-pill px-4">Kembali</a>
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
