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
    .filter-card .form-control {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        padding: 7px 12px;
    }
    .filter-card .form-control:focus {
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

    .lab-name { font-weight: 600; color: #0f172a; font-size: 14px; }
    .status-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .status-tag.active { background: #ecfdf5; color: #059669; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Laboratorium</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Master Data</li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Laboratorium</li>
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

    <!-- Toolbar & Filter -->
    <div class="filter-card">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <form action="{{ route('laboratorium.index') }}" method="GET" class="d-flex gap-2 flex-grow-1" style="max-width: 450px;">
                <input type="text" name="q" class="form-control" placeholder="Cari nama laboratorium..." value="{{ request('q') }}">
                <button type="submit" class="btn-modern-filter">Cari</button>
                @if(request('q'))
                <a href="{{ route('laboratorium.index') }}" class="btn-modern-light">Reset</a>
                @endif
                <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
            </form>
            <div>
                <button type="button" class="btn-modern-primary" data-bs-toggle="modal" data-bs-target="#createLabModal">
                    <i class="fas fa-plus"></i> Tambah Laboratorium
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Count & Per-Page Selector -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <span class="summary-text">Menampilkan <strong>{{ $labo->firstItem() ?? 0 }}–{{ $labo->lastItem() ?? 0 }}</strong> dari <strong>{{ $labo->total() }}</strong> Laboratorium aktif</span>
        @include('layout.per-page', ['default' => 25])
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Laboratorium</th>
                        <th style="width: 160px;">Status Operasional</th>
                        <th style="width: 100px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($labo as $key => $data)
                    <tr>
                        <td class="text-muted">{{ $labo->firstItem() + $key }}</td>
                        <td>
                            <div class="lab-name"><i class="fas fa-door-open text-primary me-2"></i> {{ $data->laboratorium }}</div>
                        </td>
                        <td>
                            <span class="status-tag active"><span class="status-dot"></span> Aktif Beroperasi</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn-action btn-action-edit" title="Edit Laboratorium" data-bs-toggle="modal" data-bs-target="#editLabModal{{ $data->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('laboratorium.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data laboratorium ini?')">
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
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="fas fa-flask d-block"></i>
                                <h6>Belum Ada Data Laboratorium</h6>
                                <p class="text-muted small">Silakan klik tombol <strong>+ Tambah Laboratorium</strong> untuk menambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($labo->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $labo->currentPage() }} / {{ $labo->lastPage() }}</span>
            {{ $labo->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade app-modal" id="createLabModal" tabindex="-1" aria-labelledby="createLabModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="createLabModalLabel">Tambah laboratorium</h5>
                    <p class="modal-kicker">Ruang baru dapat dipakai pada jadwal dan inventaris.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('laboratorium.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label for="create-lab-name">Nama laboratorium <span class="req">*</span></label>
                        <input id="create-lab-name" type="text" name="laboratorium" class="form-control" placeholder="Contoh: Laboratorium IoT & Jaringan" value="{{ old('laboratorium') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan laboratorium</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($labo as $data)
<div class="modal fade app-modal" id="editLabModal{{ $data->id }}" tabindex="-1" aria-labelledby="editLabModalLabel{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="editLabModalLabel{{ $data->id }}">Edit laboratorium</h5>
                    <p class="modal-kicker">Perbarui nama ruang laboratorium.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('laboratorium.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="field">
                        <label for="edit-lab-name-{{ $data->id }}">Nama laboratorium <span class="req">*</span></label>
                        <input id="edit-lab-name-{{ $data->id }}" type="text" name="laboratorium" class="form-control" value="{{ old('laboratorium', $data->laboratorium) }}" required>
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