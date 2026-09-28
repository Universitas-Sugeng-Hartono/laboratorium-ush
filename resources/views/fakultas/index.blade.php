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

    .code-badge {
        display: inline-block;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 12px;
        font-weight: 700;
        background: #eff6ff;
        color: #2563eb;
        padding: 3px 8px;
        border-radius: 6px;
        border: 1px solid #dbeafe;
    }
    .faculty-name { font-weight: 600; color: #0f172a; font-size: 14px; }
    .dekan-name { color: #475569; font-size: 13px; }
    .dekan-title { color: #94a3b8; font-size: 11px; }

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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Fakultas</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-muted">Master Data</li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Fakultas</li>
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
            <form action="{{ route('fakultas.index') }}" method="GET" class="d-flex gap-2 flex-grow-1" style="max-width: 480px;">
                <input type="text" name="q" class="form-control" placeholder="Cari kode, nama fakultas, dekan..." value="{{ request('q') }}">
                <button type="submit" class="btn-modern-filter">Cari</button>
                @if(request('q'))
                <a href="{{ route('fakultas.index') }}" class="btn-modern-light">Reset</a>
                @endif
                <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
            </form>
            <div>
                <button type="button" class="btn-modern-primary" data-bs-toggle="modal" data-bs-target="#createFakultasModal">
                    <i class="fas fa-plus"></i> Tambah Fakultas
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Count & Per-Page Selector -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <span class="summary-text">Menampilkan <strong>{{ $fakultas->firstItem() ?? 0 }}–{{ $fakultas->lastItem() ?? 0 }}</strong> dari <strong>{{ $fakultas->total() }}</strong> Fakultas aktif</span>
        @include('layout.per-page', ['default' => 25])
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="width: 120px;">Kode</th>
                        <th>Nama Fakultas</th>
                        <th>Pimpinan / Dekan</th>
                        <th>Keterangan</th>
                        <th style="width: 100px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fakultas as $key => $item)
                    <tr>
                        <td class="text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <span class="code-badge">{{ $item->kode }}</span>
                        </td>
                        <td>
                            <div class="faculty-name">{{ $item->fakultas }}</div>
                            <div class="mt-1">
                                <a href="{{ route('program.index', ['fakultas_id' => $item->id]) }}" class="badge bg-light text-primary border text-decoration-none" title="Lihat Program Studi di bawah Fakultas ini" style="font-size: 11px;">
                                    <i class="fas fa-graduation-cap me-1"></i> {{ $item->programs_count ?? 0 }} Program Studi
                                </a>
                            </div>
                        </td>
                        <td>
                            @if($item->dekan)
                            <div class="dekan-name"><i class="fas fa-user-tie text-muted me-1"></i> {{ $item->dekan }}</div>
                            @else
                            <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted small">{{ $item->keterangan ?? '-' }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn-action btn-action-edit" title="Edit Fakultas" data-bs-toggle="modal" data-bs-target="#editFakultasModal{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('fakultas.destroy', $item->id) }}" method="POST" class="d-inline form-delete"
                                    data-title="Hapus Data Fakultas?"
                                    data-text="Fakultas [{{ $item->kode }}] {{ $item->fakultas }} akan dihapus. Tindakan ini tidak dapat dibatalkan.">
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
                                <i class="fas fa-university d-block"></i>
                                <h6>Belum Ada Data Fakultas</h6>
                                <p class="text-muted small">Silakan klik tombol <strong>+ Tambah Fakultas</strong> untuk menambahkan fakultas baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($fakultas->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $fakultas->currentPage() }} / {{ $fakultas->lastPage() }}</span>
            {{ $fakultas->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade app-modal" id="createFakultasModal" tabindex="-1" aria-labelledby="createFakultasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="createFakultasModalLabel">Tambah fakultas</h5>
                    <p class="modal-kicker">Fakultas baru dapat dipilih pada program studi.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('fakultas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label for="create-fakultas-kode">Kode fakultas <span class="req">*</span></label>
                        <input id="create-fakultas-kode" type="text" name="kode" class="form-control" placeholder="Contoh: FTHB" value="{{ old('kode') }}" required>
                    </div>
                    <div class="field">
                        <label for="create-fakultas-nama">Nama fakultas <span class="req">*</span></label>
                        <input id="create-fakultas-nama" type="text" name="fakultas" class="form-control" placeholder="Contoh: Fakultas Teknologi, Hukum, dan Bisnis" value="{{ old('fakultas') }}" required>
                    </div>
                    <div class="field">
                        <label for="create-fakultas-dekan">Dekan / pimpinan</label>
                        <input id="create-fakultas-dekan" type="text" name="dekan" class="form-control" placeholder="Nama dan gelar" value="{{ old('dekan') }}">
                    </div>
                    <div class="field">
                        <label for="create-fakultas-ket">Keterangan</label>
                        <textarea id="create-fakultas-ket" name="keterangan" class="form-control" rows="2" placeholder="Catatan singkat">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan fakultas</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($fakultas as $item)
<div class="modal fade app-modal" id="editFakultasModal{{ $item->id }}" tabindex="-1" aria-labelledby="editFakultasModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="editFakultasModalLabel{{ $item->id }}">Edit fakultas</h5>
                    <p class="modal-kicker">Perbarui kode, nama, dan pimpinan.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('fakultas.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="field">
                        <label for="edit-fakultas-kode-{{ $item->id }}">Kode fakultas <span class="req">*</span></label>
                        <input id="edit-fakultas-kode-{{ $item->id }}" type="text" name="kode" class="form-control" value="{{ old('kode', $item->kode) }}" required>
                        <span class="hint">Contoh: FTHB, FPIK</span>
                    </div>
                    <div class="field">
                        <label for="edit-fakultas-nama-{{ $item->id }}">Nama fakultas <span class="req">*</span></label>
                        <input id="edit-fakultas-nama-{{ $item->id }}" type="text" name="fakultas" class="form-control" value="{{ old('fakultas', $item->fakultas) }}" required>
                    </div>
                    <div class="field">
                        <label for="edit-fakultas-dekan-{{ $item->id }}">Dekan / pimpinan</label>
                        <input id="edit-fakultas-dekan-{{ $item->id }}" type="text" name="dekan" class="form-control" value="{{ old('dekan', $item->dekan) }}">
                    </div>
                    <div class="field">
                        <label for="edit-fakultas-ket-{{ $item->id }}">Keterangan</label>
                        <textarea id="edit-fakultas-ket-{{ $item->id }}" name="keterangan" class="form-control" rows="2">{{ old('keterangan', $item->keterangan) }}</textarea>
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
