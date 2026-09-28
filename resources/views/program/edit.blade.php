@extends('layout.home')
@section('inti')
<style>
    .card-modern-form {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13.5px;
        padding: 9px 13px;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }
    .form-label {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-text {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 4px;
    }
    .btn-modern-primary {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 9px 22px;
        font-size: 13.5px;
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-modern-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        color: #ffffff;
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
    }
    .btn-modern-light {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 13.5px;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }
    .btn-modern-light:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
</style>

<!-- Breadcrumb -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Ubah Program Studi</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('program.index') }}" class="text-muted">Data Program Studi</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Ubah Program Studi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-xl-7 mx-auto">

            @if (isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
                <div class="d-flex align-items-center mb-1">
                    <i class="fas fa-exclamation-circle me-2 font-16"></i>
                    <strong>Mohon periksa kembali isian formulir:</strong>
                </div>
                <ul class="mb-0 ps-3 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card-modern-form">
                <div class="p-4 border-bottom bg-light bg-opacity-50">
                    <h5 class="fw-bold text-dark mb-1"><i class="fas fa-edit text-primary me-2"></i>Form Ubah Program Studi</h5>
                    <p class="text-muted small mb-0">Perbarui data nama program studi atau fakultas naungan.</p>
                </div>

                <div class="p-4">
                    <form action="{{ route('program.update', $program->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="program" class="form-label">Nama Program Studi <span class="text-danger">*</span></label>
                                <input type="text" name="program" id="program" class="form-control"
                                    value="{{ old('program', $program->program) }}" required autofocus>
                            </div>

                            <div class="col-12">
                                <label for="fakultas_id" class="form-label">Fakultas Naungan</label>
                                <select name="fakultas_id" id="fakultas_id" class="form-select">
                                    <option value="">-- Tanpa Fakultas (Independen) --</option>
                                    @foreach($fakultas as $fak)
                                    <option value="{{ $fak->id }}" {{ old('fakultas_id', $program->fakultas_id) == $fak->id ? 'selected' : '' }}>
                                        [{{ $fak->kode }}] {{ $fak->fakultas }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pilih fakultas induk dari program studi ini.</div>
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: #f1f5f9;">

                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('program.index') }}" class="btn-modern-light">Batal</a>
                            <button type="submit" class="btn-modern-primary">
                                <i class="fas fa-save"></i> Perbarui Program Studi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection