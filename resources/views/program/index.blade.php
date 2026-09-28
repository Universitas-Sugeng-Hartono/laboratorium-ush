@extends('layout.home')
@section('inti')
<style>
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
        font-size: 13.5px;
    }
    .data-table tbody tr:hover { background-color: #f8fafd; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    .program-name { font-weight: 600; color: #0f172a; font-size: 14px; }
    .degree-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
        padding: 2px 7px;
        border-radius: 5px;
        border: 1px solid #e2e8f0;
    }
    .fakultas-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 500;
        background: #eff6ff;
        color: #1d4ed8;
        padding: 4px 9px;
        border-radius: 6px;
        border: 1px solid #bfdbfe;
    }

    /* Action Icon Chips */
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

    .summary-text { font-size: 13px; color: #64748b; }
    .summary-text strong { color: #0f172a; }
    .empty-state { padding: 50px 20px; text-align: center; }
    .empty-state i { font-size: 36px; color: #cbd5e1; margin-bottom: 10px; }
</style>

<!-- Breadcrumb -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Program Studi</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Master Data</li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Program Studi</li>
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

    @if(isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
        <ul class="mb-0 small">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Toolbar & Filter -->
    <div class="filter-card">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <form action="{{ route('program.index') }}" method="GET" class="d-flex flex-wrap gap-2 flex-grow-1" style="max-width: 600px;">
                <input type="text" name="q" class="form-control" style="max-width: 260px;" placeholder="Cari prodi / fakultas..." value="{{ request('q') }}">
                
                <select name="fakultas_id" class="form-select" style="max-width: 220px;">
                    <option value="">-- Semua Fakultas --</option>
                    @foreach($fakultas as $fak)
                    <option value="{{ $fak->id }}" {{ request('fakultas_id') == $fak->id ? 'selected' : '' }}>
                        [{{ $fak->kode }}] {{ $fak->fakultas }}
                    </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-modern-filter">Filter</button>
                @if(request('q') || request('fakultas_id'))
                <a href="{{ route('program.index') }}" class="btn-modern-light">Reset</a>
                @endif
                <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
            </form>
            <div>
                <button type="button" class="btn-modern-primary" data-bs-toggle="modal" data-bs-target="#createProgramModal">
                    <i class="fas fa-plus"></i> Tambah Program Studi
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Count & Per-Page Selector -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <span class="summary-text">Menampilkan <strong>{{ $programs->firstItem() ?? 0 }}–{{ $programs->lastItem() ?? 0 }}</strong> dari <strong>{{ $programs->total() }}</strong> Program Studi aktif</span>
        @include('layout.per-page', ['default' => 25])
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Program Studi</th>
                        <th>Fakultas Naungan</th>
                        <th>Jenjang</th>
                        <th style="width: 100px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $key => $program)
                    <tr>
                        <td class="text-muted">{{ $programs->firstItem() + $key }}</td>
                        <td>
                            <div class="program-name">{{ $program->program }}</div>
                        </td>
                        <td>
                            @if($program->fakultas)
                            <span class="fakultas-badge" title="Dekan: {{ $program->fakultas->dekan ?? '-' }}">
                                <i class="fas fa-university"></i>
                                <strong>[{{ $program->fakultas->kode }}]</strong> {{ $program->fakultas->fakultas }}
                            </span>
                            @else
                            <span class="text-muted small fst-italic">Belum dihubungkan</span>
                            @endif
                        </td>
                        <td>
                            <span class="degree-badge"><i class="fas fa-graduation-cap me-1 text-primary"></i> Sarjana (S1)</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn-action btn-action-edit" title="Edit Program Studi" data-bs-toggle="modal" data-bs-target="#editProgramModal{{ $program->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('program.destroy', $program->id) }}" method="POST" class="d-inline form-delete"
                                    data-title="Hapus Program Studi?"
                                    data-text="Program Studi {{ $program->program }} akan dihapus dari sistem. Tindakan ini tidak dapat dibatalkan.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-action-delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-graduation-cap d-block"></i>
                                <h6>Belum Ada Data Program Studi</h6>
                                <p class="text-muted small">Silakan klik tombol <strong>+ Tambah Program Studi</strong> untuk menambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($programs->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $programs->currentPage() }} / {{ $programs->lastPage() }}</span>
            {{ $programs->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade app-modal" id="createProgramModal" tabindex="-1" aria-labelledby="createProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="createProgramModalLabel">Tambah program studi</h5>
                    <p class="modal-kicker">Program studi baru muncul di data master dan jadwal.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('program.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label for="create-program-name">Nama program studi <span class="req">*</span></label>
                        <input id="create-program-name" type="text" name="program" class="form-control" placeholder="Contoh: Bisnis Digital" value="{{ old('program') }}" required>
                    </div>
                    <div class="field">
                        <label for="create-program-fakultas">Fakultas</label>
                        <select id="create-program-fakultas" name="fakultas_id" class="form-select">
                            <option value="">Tanpa fakultas</option>
                            @foreach($fakultas as $fak)
                            <option value="{{ $fak->id }}" {{ old('fakultas_id') == $fak->id ? 'selected' : '' }}>
                                [{{ $fak->kode }}] {{ $fak->fakultas }}
                            </option>
                            @endforeach
                        </select>
                        <span class="hint">Pilih fakultas yang membawahi program studi ini.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan program studi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($programs as $program)
<div class="modal fade app-modal" id="editProgramModal{{ $program->id }}" tabindex="-1" aria-labelledby="editProgramModalLabel{{ $program->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="editProgramModalLabel{{ $program->id }}">Edit program studi</h5>
                    <p class="modal-kicker">Perbarui nama dan fakultas naungan.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('program.update', $program->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="field">
                        <label for="edit-program-name-{{ $program->id }}">Nama program studi <span class="req">*</span></label>
                        <input id="edit-program-name-{{ $program->id }}" type="text" name="program" class="form-control" value="{{ old('program', $program->program) }}" required>
                    </div>
                    <div class="field">
                        <label for="edit-program-fakultas-{{ $program->id }}">Fakultas</label>
                        <select id="edit-program-fakultas-{{ $program->id }}" name="fakultas_id" class="form-select">
                            <option value="">Tanpa fakultas</option>
                            @foreach($fakultas as $fak)
                            <option value="{{ $fak->id }}" {{ old('fakultas_id', $program->fakultas_id) == $fak->id ? 'selected' : '' }}>
                                [{{ $fak->kode }}] {{ $fak->fakultas }}
                            </option>
                            @endforeach
                        </select>
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