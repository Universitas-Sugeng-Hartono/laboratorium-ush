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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Tambah Mata Kuliah</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('matkul.index') }}" class="text-muted">Data Mata Kuliah</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Tambah Baru</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto">
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
                    <h5 class="fw-bold text-dark mb-1"><i class="fas fa-book text-primary me-2"></i>Form Mata Kuliah Baru</h5>
                    <p class="text-muted small mb-0">Lengkapi data mata kuliah, dosen pengampu, program studi, dan tahun akademik.</p>
                </div>
                <div class="p-4">
                    <form action="{{ route('matkul.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="matakuliah" class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                                <input type="text" name="matakuliah" id="matakuliah" class="form-control"
                                    placeholder="Contoh: Pemrograman Web Lanjut" value="{{ old('matakuliah') }}" required autofocus>
                            </div>

                            <div class="col-md-7">
                                <label for="dosen" class="form-label">Dosen Pengampu <span class="text-danger">*</span></label>
                                <input type="text" name="dosen" id="dosen" class="form-control"
                                    placeholder="Contoh: Dr. Budi Santoso, M.Kom" value="{{ old('dosen') }}" required>
                            </div>

                            <div class="col-md-5">
                                <label for="nomor" class="form-label">No. WhatsApp / HP Dosen</label>
                                <input type="tel" name="nomor" id="nomor" class="form-control"
                                    placeholder="08... atau 628..." inputmode="numeric" maxlength="15"
                                    value="{{ old('nomor') }}">
                                <div class="form-text">Awalan 08 atau 628. Nomor disimpan sebagai 628.</div>
                            </div>

                            <div class="col-md-7">
                                <label for="dosen2" class="form-label">Dosen Kedua</label>
                                <input type="text" name="dosen2" id="dosen2" class="form-control"
                                    placeholder="Opsional" value="{{ old('dosen2') }}">
                            </div>

                            <div class="col-md-5">
                                <label for="nomor2" class="form-label">No. WhatsApp Dosen Kedua</label>
                                <input type="tel" name="nomor2" id="nomor2" class="form-control"
                                    placeholder="08... atau 628..." inputmode="numeric" maxlength="15"
                                    value="{{ old('nomor2') }}">
                                <div class="form-text">Opsional. Awalan 08 atau 628, disimpan sebagai 628.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="program_id" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <select name="program_id" id="program_id" class="form-select" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->program }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="ta_id" class="form-label">Tahun Akademik</label>
                                <select name="ta_id" id="ta_id" class="form-select">
                                    @foreach($tas as $akademik)
                                    <option value="{{ $akademik->id }}" 
                                        {{ (old('ta_id', $taAktif?->id) == $akademik->id) ? 'selected' : '' }}>
                                        {{ $akademik->ta }}{{ $akademik->status == 'aktif' ? ' (Aktif)' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Secara default terisi Tahun Akademik aktif saat ini.</div>
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: #f1f5f9;">

                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('matkul.index') }}" class="btn-modern-light">Batal</a>
                            <button type="submit" class="btn-modern-primary">
                                <i class="fas fa-save"></i> Simpan Mata Kuliah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection