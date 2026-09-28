@extends('layout.home')
@section('inti')
<style>
    /* Metric Cards */
    .metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }
    .metric-icon-box {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .metric-icon-blue { background: #eff6ff; color: #2563eb; }
    .metric-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .metric-icon-emerald { background: #ecfdf5; color: #059669; }
    .metric-icon-sky { background: #f0f9ff; color: #0284c7; }

    .metric-value {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .metric-label {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 500;
        margin-top: 2px;
    }

    .card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }
    .filter-card .form-control, .filter-card .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        padding: 7px 12px;
    }
    .filter-card .form-control:focus, .filter-card .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
    }
    .filter-card label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .data-table { border-collapse: separate; border-spacing: 0; }
    .data-table thead th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 600;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 16px;
        white-space: nowrap;
    }
    .data-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
        font-size: 13px;
    }
    .data-table tbody tr:hover { background-color: #f8fafd; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    /* User Avatar */
    .user-avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        color: #ffffff;
        font-weight: 600;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .avatar-super { background: linear-gradient(135deg, #7c3aed, #6d28d9); }
    .avatar-laboran { background: linear-gradient(135deg, #059669, #047857); }
    .avatar-dosen { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
    .avatar-default { background: linear-gradient(135deg, #64748b, #475569); }

    .user-name-text { font-weight: 600; color: #0f172a; font-size: 13.5px; }
    .user-nomor-text { font-size: 11.5px; color: #64748b; }

    /* Role Badges */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .role-badge-super { background: #f5f3ff; color: #7c3aed; border: 1px solid #ede9fe; }
    .role-badge-laboran { background: #ecfdf5; color: #059669; border: 1px solid #d1fae5; }
    .role-badge-dosen { background: #eff6ff; color: #2563eb; border: 1px solid #dbeafe; }
    .role-badge-mahasiswa { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; }

    /* Action Chips */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        cursor: pointer;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
    }
    .btn-action-edit { background: #fef3c7; color: #d97706; }
    .btn-action-edit:hover { background: #d97706; color: #ffffff; }
    .btn-action-delete { background: #fee2e2; color: #dc2626; }
    .btn-action-delete:hover { background: #dc2626; color: #ffffff; }

    .btn-modern-primary {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 7px 16px;
        font-size: 13px;
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-modern-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        color: #ffffff;
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
    }
    .btn-modern-filter {
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 7px 16px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
    }
    .btn-modern-light {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-modern-light:hover { background: #f1f5f9; color: #0f172a; }

    .summary-text { font-size: 13px; color: #64748b; }
    .summary-text strong { color: #0f172a; }
    .empty-state { padding: 50px 20px; text-align: center; }
    .empty-state i { font-size: 36px; color: #cbd5e1; margin-bottom: 10px; }
</style>

<!-- Breadcrumb -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Manajemen Pengguna</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Sistem & Keamanan</li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Pengguna</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
        <ul class="mb-0 small">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-blue">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="metric-value">{{ number_format($totalUsers) }}</div>
                    <div class="metric-label">Total Pengguna</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-purple">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <div class="metric-value">{{ number_format($superUsers) }}</div>
                    <div class="metric-label">Super Admin</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-emerald">
                    <i class="fas fa-flask"></i>
                </div>
                <div>
                    <div class="metric-value">{{ number_format($laboranUsers) }}</div>
                    <div class="metric-label">Laboran & Teknisi</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-sky">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <div class="metric-value">{{ number_format($dosenUsers) }}</div>
                    <div class="metric-label">Dosen / Kaprodi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <form action="{{ route('user.index') }}" method="GET" class="d-flex flex-wrap gap-2 flex-grow-1" style="max-width: 600px;">
                <input type="text" name="q" class="form-control" style="max-width: 320px;" placeholder="Cari nama, email, NIK/NIDN..." value="{{ request('q') }}">
                <select name="role" class="form-select" style="max-width: 170px;">
                    <option value="">Semua Peran</option>
                    <option value="super" {{ request('role') == 'super' ? 'selected' : '' }}>Super Admin</option>
                    <option value="laboran" {{ request('role') == 'laboran' ? 'selected' : '' }}>Laboran</option>
                    <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
                <button type="submit" class="btn-modern-filter">Cari</button>
                @if(request('q') || request('role'))
                <a href="{{ route('user.index') }}" class="btn-modern-light">Reset</a>
                @endif
                <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
            </form>
            <div>
                <button type="button" class="btn-modern-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="fas fa-user-plus"></i> Tambah Pengguna
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Count & Per-Page Selector -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <span class="summary-text">Menampilkan <strong>{{ $user->firstItem() ?? 0 }}–{{ $user->lastItem() ?? 0 }}</strong> dari <strong>{{ $user->total() }}</strong> pengguna sistem</span>
        @include('layout.per-page', ['default' => 25])
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Profil Pengguna</th>
                        <th>Alamat Email</th>
                        <th style="width: 160px;">Peran (Role)</th>
                        <th style="width: 140px;">Terdaftar</th>
                        <th style="width: 100px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user as $key => $item)
                    <tr>
                        <td class="text-muted">{{ $user->firstItem() + $key }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @php
                                    $role = strtolower($item->role ?? '');
                                    $avatarClass = match(true) {
                                        str_contains($role, 'super') => 'avatar-super',
                                        str_contains($role, 'lab') => 'avatar-laboran',
                                        str_contains($role, 'dosen') => 'avatar-dosen',
                                        default => 'avatar-default',
                                    };
                                @endphp
                                <div class="user-avatar-circle {{ $avatarClass }}">
                                    {{ strtoupper(substr($item->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="user-name-text">{{ $item->name }}</div>
                                    @if($item->nomor)
                                    <div class="user-nomor-text">ID/NIK: {{ $item->nomor }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark"><i class="far fa-envelope text-muted me-1"></i> {{ $item->email }}</div>
                        </td>
                        <td>
                            @php
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
                                    default => ucfirst($item->role ?? 'Pengguna'),
                                };
                            @endphp
                            <span class="role-badge {{ $roleBadgeClass }}">
                                <i class="{{ $roleIcon }}"></i> {{ $roleLabel }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted small">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn-action btn-action-edit" title="Edit Pengguna" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if(Auth::id() != $item->id)
                                <form action="{{ route('user.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $item->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-action-delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-users-slash d-block"></i>
                                <h6>Tidak Ada Pengguna Ditemukan</h6>
                                <p class="text-muted small">Coba ubah kata kunci pencarian atau filter peran.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($user->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $user->currentPage() }} / {{ $user->lastPage() }}</span>
            {{ $user->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade app-modal" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="createUserModalLabel">Tambah Pengguna</h5>
                    <p class="modal-kicker">Akun baru dapat langsung masuk ke SILABO.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label for="create-user-name">Nama lengkap <span class="req">*</span></label>
                        <input id="create-user-name" type="text" name="name" class="form-control" placeholder="Nama lengkap beserta gelar" value="{{ old('name') }}" required>
                    </div>
                    <div class="field">
                        <label for="create-user-email">Alamat email <span class="req">*</span></label>
                        <input id="create-user-email" type="email" name="email" class="form-control" placeholder="nama@sugenghartono.ac.id" value="{{ old('email') }}" required>
                    </div>
                    <div class="field">
                        <label for="create-user-nomor">Nomor induk / NIK / NIDN</label>
                        <input id="create-user-nomor" type="text" name="nomor" class="form-control" placeholder="Nomor identitas akademik" value="{{ old('nomor') }}">
                    </div>
                    <div class="field">
                        <label for="create-user-role">Peran <span class="req">*</span></label>
                        <select id="create-user-role" name="role" class="form-select" required>
                            <option value="">Pilih peran akun</option>
                            <option value="super" {{ old('role') == 'super' ? 'selected' : '' }}>Super Admin</option>
                            <option value="laboran" {{ old('role') == 'laboran' ? 'selected' : '' }}>Laboran</option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen / Kaprodi</option>
                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="create-user-password">Kata sandi <span class="req">*</span></label>
                        <input id="create-user-password" type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($user as $item)
<div class="modal fade app-modal" id="editUserModal{{ $item->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="editUserModalLabel{{ $item->id }}">Edit pengguna</h5>
                    <p class="modal-kicker">Perbarui identitas, peran, dan kata sandi akun.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('user.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="field">
                        <label for="edit-user-name-{{ $item->id }}">Nama lengkap <span class="req">*</span></label>
                        <input id="edit-user-name-{{ $item->id }}" type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                    </div>
                    <div class="field">
                        <label for="edit-user-email-{{ $item->id }}">Alamat email <span class="req">*</span></label>
                        <input id="edit-user-email-{{ $item->id }}" type="email" name="email" class="form-control" value="{{ old('email', $item->email) }}" required>
                    </div>
                    <div class="field">
                        <label for="edit-user-nomor-{{ $item->id }}">Nomor induk / NIK / NIDN</label>
                        <input id="edit-user-nomor-{{ $item->id }}" type="text" name="nomor" class="form-control" value="{{ old('nomor', $item->nomor) }}">
                    </div>
                    <div class="field">
                        <label for="edit-user-role-{{ $item->id }}">Peran <span class="req">*</span></label>
                        <select id="edit-user-role-{{ $item->id }}" name="role" class="form-select" required>
                            <option value="super" {{ $item->role == 'super' ? 'selected' : '' }}>Super Admin</option>
                            <option value="laboran" {{ $item->role == 'laboran' ? 'selected' : '' }}>Laboran</option>
                            <option value="dosen" {{ $item->role == 'dosen' ? 'selected' : '' }}>Dosen / Kaprodi</option>
                            <option value="mahasiswa" {{ $item->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="edit-user-password-{{ $item->id }}">Kata sandi baru</label>
                        <input id="edit-user-password-{{ $item->id }}" type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah" autocomplete="new-password">
                        <span class="hint">Isi minimal 6 karakter hanya jika kata sandi diganti.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection