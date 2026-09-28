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
        padding: 13px 16px;
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
    .item-name { font-weight: 600; color: #0f172a; font-size: 13.5px; }
    .spec-text { color: #64748b; font-size: 12px; margin-top: 2px; }
    .code-text { font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 12px; color: #475569; font-weight: 600; }
    .lab-label { color: #0f172a; font-size: 13px; font-weight: 500; }
    .loc-text { color: #64748b; font-size: 12px; }
    .qty-label { font-weight: 600; color: #0f172a; font-size: 13px; }
    .min-text { color: #64748b; font-size: 11px; }

    .status-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 500;
        border: 1px solid transparent;
        line-height: 1.4;
    }
    .status-tag.success { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
    .status-tag.warning { background: #fffbeb; color: #92400e; border-color: #fde68a; }
    .status-tag.danger { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .status-tag.success .status-dot { background: #10b981; }
    .status-tag.warning .status-dot { background: #f59e0b; }
    .status-tag.danger .status-dot { background: #ef4444; }

    /* Action Icon Chips with Fresh, Professional Hues */
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
    .btn-action-edit {
        background: #fef3c7;
        color: #d97706;
    }
    .btn-action-edit:hover {
        background: #d97706;
        color: #ffffff;
    }
    .btn-action-delete {
        background: #fee2e2;
        color: #dc2626;
    }
    .btn-action-delete:hover {
        background: #dc2626;
        color: #ffffff;
    }

    /* Modern Buttons */
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
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-modern-filter:hover {
        background: #1d4ed8;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }
    .btn-modern-light {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-modern-light:hover {
        background: #f1f5f9;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .summary-text { font-size: 13px; color: #64748b; }
    .summary-text strong { color: #0f172a; }
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-state i { font-size: 40px; color: #cbd5e1; margin-bottom: 12px; }
    .empty-state h6 { color: #475569; font-weight: 600; margin-bottom: 4px; }
    .empty-state p { color: #94a3b8; font-size: 13px; }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Inventaris Bahan Praktikum</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bahan.index') }}" class="text-muted">Inventaris</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Daftar Bahan</li>
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

    <!-- Filter Card -->
    <div class="filter-card">
        <form id="filterForm" method="GET" action="{{ route('bahan.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="mb-1">Pencarian</label>
                    <input type="text" class="form-control" name="q" placeholder="Nama / Kode / Lokasi..." value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <label class="mb-1">Laboratorium</label>
                    <select class="form-select" name="lab_id">
                        <option value="">Semua Lab</option>
                        @foreach($laboratories as $lab)
                        <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                            {{ $lab->laboratorium }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-1">Status Ketersediaan</label>
                    <select class="form-select" name="status_stok">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status_stok') == 'tersedia' ? 'selected' : '' }}>Tersedia (Aman)</option>
                        <option value="menipis" {{ request('status_stok') == 'menipis' ? 'selected' : '' }}>Menipis (&le; Min)</option>
                        <option value="habis" {{ request('status_stok') == 'habis' ? 'selected' : '' }}>Habis (0)</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2 align-items-end justify-content-end">
                    <button type="submit" class="btn-modern-filter">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    @if(request()->filled('lab_id') || request()->filled('status_stok') || request()->filled('q'))
                    <a href="{{ route('bahan.index') }}" class="btn-modern-light">Reset</a>
                    @endif
                    <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                </div>
            </div>
        </form>
    </div>

    <!-- Toolbar Summary & Action -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="summary-text">Menampilkan <strong>{{ $bahan->firstItem() ?? 0 }}–{{ $bahan->lastItem() ?? 0 }}</strong> dari <strong>{{ $bahan->total() }}</strong> jenis bahan</span>
            @include('layout.per-page', ['default' => 25])
        </div>
        <div>
            <a href="{{ route('bahan.create') }}" class="btn-modern-primary">
                <i class="fas fa-plus"></i> Tambah Bahan
            </a>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th style="width: 110px;">Kode</th>
                        <th>Nama Bahan & Spesifikasi</th>
                        <th>Laboratorium & Lokasi</th>
                        <th style="width: 120px;" class="text-center">Stok</th>
                        <th style="width: 110px;">Status</th>
                        <th style="width: 90px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahan as $data)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration + ($bahan->currentPage() - 1) * $bahan->perPage() }}</td>
                        <td>
                            <span class="code-text">{{ $data->kode ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="item-name">{{ $data->bahan }}</div>
                            @if($data->spesifikasi)
                            <div class="spec-text text-truncate" style="max-width: 280px;" title="{{ $data->spesifikasi }}">{{ $data->spesifikasi }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="lab-label">{{ $data->labId->laboratorium ?? 'Lab Umum' }}</div>
                            @if($data->lokasi_penyimpanan)
                            <div class="loc-text">{{ $data->lokasi_penyimpanan }}</div>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="qty-label">{{ $data->jumlah }} {{ $data->satuan ?? 'Pcs' }}</span>
                            @if($data->stok_minimum > 0)
                            <div class="min-text">Min: {{ $data->stok_minimum }}</div>
                            @endif
                        </td>
                        <td>
                            @if(($data->status_stok ?? 'tersedia') == 'tersedia')
                            <span class="status-tag success"><span class="status-dot"></span> Tersedia</span>
                            @elseif($data->status_stok == 'menipis')
                            <span class="status-tag warning"><span class="status-dot"></span> Menipis</span>
                            @else
                            <span class="status-tag danger"><span class="status-dot"></span> Habis</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('bahan.edit', $data->id) }}" class="btn-action btn-action-edit" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('bahan.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data bahan ini?')">
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
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="far fa-folder d-block"></i>
                                <h6>Tidak ada data bahan</h6>
                                <p>Tidak ditemukan inventaris bahan praktikum yang cocok dengan filter pencarian.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bahan->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $bahan->currentPage() }} / {{ $bahan->lastPage() }}</span>
            {{ $bahan->links() }}
        </div>
        @endif
    </div>
</div>
@endsection