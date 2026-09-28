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
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13.5px;
        padding: 8px 12px;
    }
    .form-control:focus, .form-select:focus {
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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Tambah Pengguna Baru</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-muted">Pengguna</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Tambah</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9 col-lg-7">
            <div class="card-modern">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Nama lengkap pengguna" value="{{ old('name') }}" required>
                        @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="nama@sugenghartono.ac.id" value="{{ old('email') }}" required>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nomor Induk / NIK / NIDN</label>
                            <input type="text" name="nomor" class="form-control" placeholder="Nomor identitas" value="{{ old('nomor') }}">
                            @error('nomor')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Peran (Role) <span class="text-danger">*</span></label>
                            <select name="role" class="form-select" required>
                                <option value="">Pilih Peran Akun...</option>
                                <option value="super" {{ old('role') == 'super' ? 'selected' : '' }}>Super Admin</option>
                                <option value="laboran" {{ old('role') == 'laboran' ? 'selected' : '' }}>Laboran</option>
                                <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen / Kaprodi</option>
                                <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            </select>
                            @error('role')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Password Akun <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-modern-primary">Simpan Pengguna</button>
                        <a href="{{ route('user.index') }}" class="btn-modern-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection