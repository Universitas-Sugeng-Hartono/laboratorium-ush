@extends('layout.home')
@section('inti')
<style>
    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }
    .profile-header-banner {
        height: 110px;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
        position: relative;
    }
    .profile-avatar-wrapper {
        margin-top: -55px;
        position: relative;
        display: inline-block;
    }
    .profile-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        color: #ffffff;
        font-weight: 700;
        font-size: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        margin: 0 auto;
    }
    .avatar-super { background: linear-gradient(135deg, #7c3aed, #6d28d9); }
    .avatar-laboran { background: linear-gradient(135deg, #059669, #047857); }
    .avatar-dosen { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
    .avatar-default { background: linear-gradient(135deg, #64748b, #475569); }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .role-badge-super { background: #f5f3ff; color: #7c3aed; border: 1px solid #ede9fe; }
    .role-badge-laboran { background: #ecfdf5; color: #059669; border: 1px solid #d1fae5; }
    .role-badge-dosen { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
    .role-badge-mahasiswa { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }

    .info-tile {
        padding: 12px 14px;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        margin-bottom: 10px;
    }
    .info-tile-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 3px;
    }
    .info-tile-value {
        font-size: 13.5px;
        font-weight: 600;
        color: #0f172a;
    }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Profil Pengguna</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        @can('isSuper')
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-muted">Manajemen User</a></li>
                        @endcan
                        <li class="breadcrumb-item text-dark active" aria-current="page">{{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert" style="background: #ecfdf5; color: #065f46;">
        <i class="fa fa-circle-check fs-5 me-2 text-success"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center gap-2 mb-1">
            <i class="fa fa-circle-exclamation fs-5"></i>
            <strong>Terjadi kesalahan validasi:</strong>
        </div>
        <ul class="mb-0 ps-4 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- Left: Summary Card -->
        <div class="col-lg-4">
            <div class="profile-card text-center pb-4">
                <div class="profile-header-banner"></div>
                <div class="px-4">
                    @php
                        $role = strtolower($user->role ?? '');
                        $avatarClass = match(true) {
                            str_contains($role, 'super') => 'avatar-super',
                            str_contains($role, 'lab') => 'avatar-laboran',
                            str_contains($role, 'dosen') => 'avatar-dosen',
                            default => 'avatar-default',
                        };
                        $roleBadgeClass = match(true) {
                            str_contains($role, 'super') => 'role-badge-super',
                            str_contains($role, 'lab') => 'role-badge-laboran',
                            str_contains($role, 'dosen') => 'role-badge-dosen',
                            default => 'role-badge-mahasiswa',
                        };
                        $roleIcon = match(true) {
                            str_contains($role, 'super') => 'fas fa-user-shield',
                            str_contains($role, 'lab') => 'fas fa-flask',
                            str_contains($role, 'dosen') => 'fas fa-chalkboard-teacher',
                            default => 'fas fa-user-graduate',
                        };
                        $roleLabel = match(true) {
                            $role === 'super' => 'Super Admin',
                            $role === 'laboran' => 'Laboran',
                            $role === 'dosen' => 'Dosen / Kaprodi',
                            $role === 'mahasiswa' => 'Mahasiswa',
                            default => ucfirst($user->role ?? 'Pengguna'),
                        };
                    @endphp

                    <div class="profile-avatar-wrapper">
                        <div class="profile-avatar-large {{ $avatarClass }}">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>

                    <h4 class="fw-bold text-dark mt-3 mb-1">{{ $user->name }}</h4>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>

                    <span class="role-badge {{ $roleBadgeClass }} mb-4">
                        <i class="{{ $roleIcon }}"></i> {{ $roleLabel }}
                    </span>

                    <hr class="my-3" style="border-color: #f1f5f9;">

                    <div class="text-start">
                        <div class="info-tile">
                            <div class="info-tile-label"><i class="fa fa-id-card me-1"></i> ID Akun / Pengguna</div>
                            <div class="info-tile-value">#{{ $user->id }}</div>
                        </div>

                        <div class="info-tile">
                            <div class="info-tile-label"><i class="fa fa-phone me-1"></i> Nomor WhatsApp / Telepon</div>
                            <div class="info-tile-value">{{ $user->nomor ?: '-' }}</div>
                        </div>

                        <div class="info-tile">
                            <div class="info-tile-label"><i class="fa fa-calendar-plus me-1"></i> Terdaftar Sejak</div>
                            <div class="info-tile-value">{{ $user->created_at ? $user->created_at->translatedFormat('d F Y, H:i') : '-' }}</div>
                        </div>

                        <div class="info-tile">
                            <div class="info-tile-label"><i class="fa fa-clock-rotate-left me-1"></i> Pembaruan Terakhir</div>
                            <div class="info-tile-value">{{ $user->updated_at ? $user->updated_at->translatedFormat('d F Y, H:i') : '-' }}</div>
                        </div>

                        <div class="mt-3 p-3 rounded-3" style="background: #eff6ff; border: 1px solid #bfdbfe;">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success rounded-pill px-2 py-1 font-11">Aktif</span>
                                <span class="font-12 text-primary fw-semibold">Sistem SILABO USH</span>
                            </div>
                            <p class="font-11 text-muted mb-0 mt-1">Akun ini memiliki hak akses sesuai dengan role <strong>{{ $roleLabel }}</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Edit Form Card -->
        <div class="col-lg-8">
            <div class="profile-card">
                <div class="p-4 border-bottom bg-white">
                    <h5 class="fw-bold text-dark mb-1">Pengaturan Profil & Keamanan</h5>
                    <p class="text-muted small mb-0">Perbarui identitas profil Anda atau ubah kata sandi akun.</p>
                </div>

                <div class="p-4">
                    @php
                        $isSelf = (Auth::id() == $user->id);
                        $formAction = $isSelf ? route('user.profile.update') : route('user.update', $user->id);
                    @endphp

                    <form action="{{ $formAction }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Data Identitas -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa fa-user me-2 text-primary"></i>Informasi Identitas</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label font-13 fw-semibold text-dark">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control font-13"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label font-13 fw-semibold text-dark">
                                        Alamat Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control font-13"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="nomor" class="form-label font-13 fw-semibold text-dark">
                                        Nomor WhatsApp / HP
                                    </label>
                                    <input type="text" name="nomor" id="nomor" class="form-control font-13"
                                        placeholder="Contoh: 081234567890" value="{{ old('nomor', $user->nomor) }}">
                                    <span class="text-muted font-11 d-block mt-1">Digunakan untuk notifikasi jadwal & presensi.</span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label font-13 fw-semibold text-dark">
                                        Peran / Role Akun
                                    </label>
                                    @if(Auth::user()->role === 'super' && !$isSelf)
                                        <select name="role" class="form-select font-13" required>
                                            <option value="super" {{ old('role', $user->role) === 'super' ? 'selected' : '' }}>Super Admin</option>
                                            <option value="laboran" {{ old('role', $user->role) === 'laboran' ? 'selected' : '' }}>Laboran</option>
                                            <option value="dosen" {{ old('role', $user->role) === 'dosen' ? 'selected' : '' }}>Dosen / Kaprodi</option>
                                            <option value="mahasiswa" {{ old('role', $user->role) === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        </select>
                                    @else
                                        <input type="text" class="form-control font-13 bg-light text-muted" value="{{ $roleLabel }}" readonly>
                                        <span class="text-muted font-11 d-block mt-1">Role hanya dapat diubah oleh Administrator Utama.</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: #f1f5f9;">

                        <!-- Section 2: Keamanan / Password -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-1"><i class="fa fa-lock me-2 text-primary"></i>Ubah Password Akun</h6>
                            <p class="text-muted font-12 mb-3">Kosongkan kedua kolom di bawah jika Anda tidak ingin mengubah password akun.</p>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label font-13 fw-semibold text-dark">
                                        Password Baru
                                    </label>
                                    <input type="password" name="password" id="password" class="form-control font-13"
                                        placeholder="Minimal 6 karakter" autocomplete="new-password">
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label font-13 fw-semibold text-dark">
                                        Konfirmasi Password Baru
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control font-13" placeholder="Ulangi password baru" autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top" style="border-color: #f1f5f9 !important;">
                            <a href="{{ route('layout.app') }}" class="btn btn-outline-secondary font-13 px-4 rounded-pill">
                                Kembali ke Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary font-13 px-4 rounded-pill shadow-sm fw-semibold">
                                <i class="fa fa-save me-1"></i> Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
