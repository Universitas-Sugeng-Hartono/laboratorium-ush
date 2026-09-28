@extends('layout.home')
@section('inti')
<style>
    .card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        padding: 24px;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13.5px;
        padding: 8px 12px;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
    }
    .btn-modern-primary {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 8px 20px;
        font-size: 13.5px;
        font-weight: 500;
        cursor: pointer;
    }
    .btn-modern-light {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 13.5px;
        text-decoration: none;
    }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Tambah Data Fakultas</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('fakultas.index') }}" class="text-muted">Fakultas</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card-modern">
                <form action="{{ route('fakultas.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kode Fakultas <span class="text-danger">*</span></label>
                        <input type="text" name="kode" class="form-control" placeholder="Contoh: FTHB, FPIK" value="{{ old('kode') }}" required>
                        @error('kode')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap Fakultas <span class="text-danger">*</span></label>
                        <input type="text" name="fakultas" class="form-control" placeholder="Contoh: Fakultas Teknologi, Hukum, dan Bisnis" value="{{ old('fakultas') }}" required>
                        @error('fakultas')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Dekan / Pimpinan (Opsional)</label>
                        <input type="text" name="dekan" class="form-control" placeholder="Contoh: Dr. Nama Dekan, M.Kom" value="{{ old('dekan') }}">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Deskripsi atau catatan tentang fakultas">{{ old('keterangan') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern-primary">Simpan Fakultas</button>
                        <a href="{{ route('fakultas.index') }}" class="btn-modern-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
