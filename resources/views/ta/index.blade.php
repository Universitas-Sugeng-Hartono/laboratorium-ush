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
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .metric-icon-emerald { background: #ecfdf5; color: #059669; }
    .metric-icon-sky { background: #f0f9ff; color: #0284c7; }
    .metric-icon-purple { background: #f5f3ff; color: #7c3aed; }

    .metric-value {
        font-size: 19px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .metric-label {
        font-size: 11.5px;
        color: #64748b;
        font-weight: 500;
        margin-top: 3px;
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

    .data-table { border-collapse: separate; border-spacing: 0; width: 100%; }
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
    .btn-action-edit:hover { background: #fde68a; color: #b45309; }
    .btn-action-delete { background: #fee2e2; color: #dc2626; }
    .btn-action-delete:hover { background: #fecaca; color: #b91c1c; }
    .btn-action-activate { background: #ecfdf5; color: #059669; }
    .btn-action-activate:hover { background: #d1fae5; color: #047857; }

    /* Pulse Dot */
    .pulse-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulse-green 1.8s infinite;
    }
    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Tahun Akademik</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="/home" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><span class="text-muted">Master Data</span></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Tahun Akademik</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('ta.otomatis') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center" onclick="return confirm('Buat tahun akademik semester berikutnya dan jadikan aktif?')">
                    <i class="fa fa-wand-magic-sparkles me-2 text-warning"></i> Generate TA Otomatis
                </a>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm d-flex align-items-center ms-2" data-bs-toggle="modal" data-bs-target="#modalTambahTa">
                    <i class="fa fa-plus me-2"></i> Tambah TA
                </button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" role="alert" style="background:#ecfdf5; color:#065f46;">
            <i class="fa fa-circle-check fs-5 me-2 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" role="alert">
            <i class="fa fa-circle-exclamation fs-5 me-2"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 3 Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-emerald">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="metric-value d-flex align-items-center gap-2">
                        @if($taAktif)
                            <span>{{ $taAktif->ta }}</span>
                            <span class="pulse-dot" title="Sedang Aktif"></span>
                        @else
                            <span class="text-muted fs-6">Belum Ada yang Aktif</span>
                        @endif
                    </div>
                    <div class="metric-label">Semester & TA Aktif Saat Ini</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-sky">
                    <i class="fa fa-calendar-days"></i>
                </div>
                <div>
                    <div class="metric-value">{{ $totalTa }}</div>
                    <div class="metric-label">Total Periode Terdaftar</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-purple">
                    <i class="fa fa-chart-pie"></i>
                </div>
                <div>
                    <div class="metric-value">{{ $totalGanjil }} <span class="fs-6 fw-normal text-muted">Ganjil</span> / {{ $totalGenap }} <span class="fs-6 fw-normal text-muted">Genap</span></div>
                    <div class="metric-label">Distribusi Semester</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="filter-card">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa fa-search"></i></span>
                    <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari Tahun Akademik (misal: 2024, Ganjil)...">
                </div>
            </div>
            <div class="col-md-4">
                <select id="statusFilter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="non-aktif">Non-Aktif</option>
                </select>
            </div>
            <div class="col-md-3 text-md-end text-muted small">
                Menampilkan <span id="visibleCount" class="fw-bold text-dark">{{ $ta->count() }}</span> periode
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table" id="taTable">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Periode Tahun Akademik</th>
                        <th>Semester</th>
                        <th>Status Operasional</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ta as $item)
                        @php
                            $isGanjil = stripos($item->ta, 'Ganjil') !== false;
                            $isGenap = stripos($item->ta, 'Genap') !== false;
                        @endphp
                        <tr class="ta-row" data-ta="{{ strtolower($item->ta) }}" data-status="{{ $item->status }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge rounded-circle p-2 {{ $item->status == 'aktif' ? 'bg-success-subtle text-success' : 'bg-light text-muted' }}" style="width:32px; height:32px; display:inline-flex; align-items:center; justify-content:center;">
                                        <i class="fa fa-calendar-check"></i>
                                    </span>
                                    <span class="fw-semibold text-dark fs-6">{{ $item->ta }}</span>
                                </div>
                            </td>
                            <td>
                                @if($isGanjil)
                                    <span class="badge" style="background:#fef3c7; color:#d97706; border-radius:6px; font-weight:600; padding:4px 8px;">Semester Ganjil</span>
                                @elseif($isGenap)
                                    <span class="badge" style="background:#e0f2fe; color:#0369a1; border-radius:6px; font-weight:600; padding:4px 8px;">Semester Genap</span>
                                @else
                                    <span class="badge bg-light text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 'aktif')
                                    <span class="badge d-inline-flex align-items-center gap-2 px-3 py-2" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; border-radius:20px; font-weight:600;">
                                        <span class="pulse-dot"></span> Aktif / Berjalan
                                    </span>
                                @else
                                    <span class="badge px-3 py-2" style="background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0; border-radius:20px; font-weight:500;">
                                        Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex align-items-center gap-2">
                                    @if($item->status != 'aktif')
                                        <form action="{{ route('ta.update', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Aktifkan Tahun Akademik {{ $item->ta }} sebagai semester berjalan?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="ta" value="{{ $item->ta }}">
                                            <input type="hidden" name="status" value="aktif">
                                            <button type="submit" class="btn-action btn-action-activate" title="Set sebagai Aktif">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <button type="button" class="btn-action btn-action-edit" title="Edit Data"
                                        onclick="openEditModal({{ $item->id }}, '{{ addslashes($item->ta) }}', '{{ $item->status }}')">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <form action="{{ route('ta.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Tahun Akademik {{ $item->ta }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-action-delete" title="Hapus Data">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyRow">
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa fa-calendar-xmark fs-2 mb-2 d-block opacity-50"></i>
                                Belum ada data Tahun Akademik yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade app-modal" id="modalTambahTa" tabindex="-1" aria-labelledby="modalTambahTaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="modalTambahTaLabel">Tambah tahun akademik</h5>
                    <p class="modal-kicker">Hanya satu tahun akademik yang berstatus aktif.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('ta.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label for="ta_input">Tahun akademik dan semester <span class="req">*</span></label>
                        <input type="text" name="ta" id="ta_input" class="form-control" placeholder="Contoh: 2024/2025 Ganjil" required>
                        <span class="hint">Format: Tahun1/Tahun2 Ganjil atau Genap.</span>
                    </div>
                    <div class="field">
                        <label for="status_select">Status</label>
                        <select name="status" id="status_select" class="form-select">
                            <option value="non-aktif" selected>Nonaktif</option>
                            <option value="aktif">Aktif, sebagai semester berjalan</option>
                        </select>
                        <span class="hint">Jika diatur aktif, status tahun akademik lain menjadi nonaktif.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan tahun akademik</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade app-modal" id="modalEditTa" tabindex="-1" aria-labelledby="modalEditTaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="modalEditTaLabel">Ubah tahun akademik</h5>
                    <p class="modal-kicker">Perbarui nama semester dan status berjalan.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditTa" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="field">
                        <label for="edit_ta_input">Tahun akademik dan semester <span class="req">*</span></label>
                        <input type="text" name="ta" id="edit_ta_input" class="form-control" required>
                    </div>
                    <div class="field">
                        <label for="edit_status_select">Status</label>
                        <select name="status" id="edit_status_select" class="form-select">
                            <option value="non-aktif">Nonaktif</option>
                            <option value="aktif">Aktif, sebagai semester berjalan</option>
                        </select>
                        <span class="hint">Hanya satu tahun akademik yang dapat berstatus aktif.</span>
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

<script>
    function openEditModal(id, ta, status) {
        document.getElementById('formEditTa').action = '/ta/' + id;
        document.getElementById('edit_ta_input').value = ta;
        document.getElementById('edit_status_select').value = status;
        
        var editModal = new bootstrap.Modal(document.getElementById('modalEditTa'));
        editModal.show();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const rows = document.querySelectorAll('.ta-row');
        const visibleCount = document.getElementById('visibleCount');

        function filterRows() {
            const query = (searchInput.value || '').toLowerCase().trim();
            const status = (statusFilter.value || '').toLowerCase();
            let count = 0;

            rows.forEach(function (row) {
                const taText = row.getAttribute('data-ta') || '';
                const rowStatus = row.getAttribute('data-status') || '';

                const matchesQuery = !query || taText.includes(query);
                const matchesStatus = !status || rowStatus === status;

                if (matchesQuery && matchesStatus) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (visibleCount) {
                visibleCount.textContent = count;
            }
        }

        if (searchInput) searchInput.addEventListener('input', filterRows);
        if (statusFilter) statusFilter.addEventListener('change', filterRows);
    });
</script>
@endsection
