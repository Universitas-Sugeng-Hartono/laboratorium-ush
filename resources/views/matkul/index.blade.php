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
        padding: 18px 20px;
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
        font-size: 13.5px;
    }
    .data-table tbody tr:hover { background-color: #f8fafd; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    .matkul-name { font-weight: 600; color: #0f172a; font-size: 13.5px; }
    .dosen-text { color: #475569; font-size: 13px; }
    .prodi-badge {
        display: inline-block;
        font-size: 11.5px;
        font-weight: 600;
        background: #eff6ff;
        color: #2563eb;
        padding: 3px 8px;
        border-radius: 6px;
        border: 1px solid #dbeafe;
    }
    .ta-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 500;
        background: #f1f5f9;
        color: #475569;
        padding: 2px 7px;
        border-radius: 5px;
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
        padding: 7px 18px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
    }
    .btn-modern-filter:hover { background: #1d4ed8; color: #ffffff; }
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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Mata Kuliah</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Master Data</li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Mata Kuliah</li>
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

    @if(session('import_errors') && count(session('import_errors')) > 0)
    <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
        <div class="d-flex align-items-center mb-1">
            <i class="fas fa-exclamation-triangle me-2 text-warning font-16"></i>
            <strong>Beberapa baris data dilewati saat import:</strong>
        </div>
        <ul class="mb-0 ps-3 small">
            @foreach(session('import_errors') as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Card -->
    <div class="filter-card">
        <form action="{{ route('matkul.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="mb-1">Pencarian Mata Kuliah / Dosen</label>
                    <input type="text" name="q" class="form-control" placeholder="Nama mata kuliah atau dosen..." value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <label class="mb-1">Tahun Ajaran</label>
                    <select name="ta_id" class="form-select">
                        <option value="">Semua TA</option>
                        @foreach ($ta as $akademik)
                        <option value="{{ $akademik->id }}" {{ (request('ta_id', $selectedTaId) == $akademik->id) ? 'selected' : '' }}>
                            {{ $akademik->ta }}{{ $akademik->status == 'aktif' ? ' (Aktif)' : '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-1">Program Studi</label>
                    <select name="program_id" class="form-select">
                        <option value="">Semua Prodi</option>
                        @foreach ($programs as $prog)
                        <option value="{{ $prog->id }}" {{ request('program_id') == $prog->id ? 'selected' : '' }}>
                            {{ $prog->program }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2 align-items-end justify-content-end">
                    <button type="submit" class="btn-modern-filter">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['q', 'ta_id', 'program_id']))
                    <a href="{{ route('matkul.index') }}" class="btn-modern-light">Reset</a>
                    @endif
                    <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                </div>
            </div>
        </form>
    </div>

    <!-- Toolbar Summary & Action -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="summary-text">Menampilkan <strong>{{ $matkuls->firstItem() ?? 0 }}–{{ $matkuls->lastItem() ?? 0 }}</strong> dari <strong>{{ $matkuls->total() }}</strong> Mata Kuliah</span>
            @include('layout.per-page', ['default' => 25])
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn-modern-light" data-bs-toggle="modal" data-bs-target="#importMatkulModal">
                <i class="fas fa-file-excel me-1 text-success"></i> Import Excel / CSV
            </button>
            <a href="{{ route('matkul.create') }}" class="btn-modern-primary">
                <i class="fas fa-plus"></i> Tambah Mata Kuliah
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Mata Kuliah</th>
                        <th>Dosen Pengampu</th>
                        <th>Program Studi</th>
                        <th>Tahun Ajaran</th>
                        <th style="width: 100px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($matkuls as $index => $mk)
                    <tr>
                        <td class="text-muted">{{ $matkuls->firstItem() + $index }}</td>
                        <td>
                            <div class="matkul-name">{{ $mk->matakuliah }}</div>
                            @if($mk->nomor)
                            <small class="text-muted">Kode: {{ $mk->nomor }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="dosen-text"><i class="fas fa-user-tie text-muted me-1"></i> {{ $mk->dosen }}</div>
                        </td>
                        <td>
                            <span class="prodi-badge">{{ $mk->programId->program ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="ta-badge">{{ $mk->taId->ta ?? '-' }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('matkul.edit', $mk->id) }}" class="btn-action btn-action-edit" title="Edit Mata Kuliah">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('matkul.destroy', $mk->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')">
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
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-book-open d-block"></i>
                                <h6>Belum Ada Data Mata Kuliah</h6>
                                <p class="text-muted small">Tidak ditemukan mata kuliah yang cocok dengan filter pencarian.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($matkuls->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $matkuls->currentPage() }} / {{ $matkuls->lastPage() }}</span>
            {{ $matkuls->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade app-modal" id="importMatkulModal" tabindex="-1" aria-labelledby="importMatkulModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="importMatkulModalLabel">Import mata kuliah</h5>
                    <p class="modal-kicker">Unggah daftar mata kuliah dan dosen pengampu.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('matkul.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label for="import-matkul-file">Berkas Excel atau CSV <span class="req">*</span></label>
                        <input id="import-matkul-file" type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv,.txt" required>
                        @if(isset($errors) && $errors->has('excel_file'))
                            <span class="hint" style="color:#dc2626;">{{ $errors->first('excel_file') }}</span>
                        @endif
                    </div>
                    <div class="field">
                        <label for="import-matkul-ta">Tahun akademik tujuan</label>
                        <select id="import-matkul-ta" name="default_ta_id" class="form-select">
                            @foreach ($ta as $akademik)
                            <option value="{{ $akademik->id }}" {{ $akademik->status == 'aktif' ? 'selected' : '' }}>
                                {{ $akademik->ta }}{{ $akademik->status == 'aktif' ? ' (aktif)' : '' }}
                            </option>
                            @endforeach
                        </select>
                        <span class="hint">Dipakai bila kolom tahun ajaran pada baris berkas kosong.</span>
                    </div>
                    <div class="template-box">
                        <div class="section-label">Template</div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('matkul.template') }}" class="btn-modal-save" download>Excel (.xlsx)</a>
                            <a href="{{ route('matkul.template', ['format' => 'csv']) }}" class="btn-modal-cancel" download>CSV (.csv)</a>
                        </div>
                        <span class="hint">Berkas Excel menyertakan lembar referensi program studi dan tahun akademik.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Import mata kuliah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection