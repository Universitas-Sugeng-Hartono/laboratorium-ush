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
    .matkul-name { font-weight: 600; color: #0f172a; font-size: 13.5px; }
    .dosen-name { color: #64748b; font-size: 12px; margin-top: 2px; }
    .day-label { font-weight: 600; color: #0f172a; }
    .date-label { color: #64748b; font-size: 12px; }
    .time-label { color: #2563eb; font-weight: 600; font-size: 13px; }
    .prodi-text { color: #475569; font-size: 13px; }

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
    .btn-action-reschedule {
        background: #eff6ff;
        color: #2563eb;
    }
    .btn-action-reschedule:hover {
        background: #2563eb;
        color: #ffffff;
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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Jadwal Perkuliahan</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Jadwal</li>
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
    @if(session('import_errors'))
    <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
        <strong>Detail baris gagal:</strong>
        <ul class="mb-0 mt-1 small">
            @foreach(session('import_errors') as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Card -->
    <div class="filter-card">
        <form action="{{ route('jadwal.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="mb-1">Laboratorium</label>
                    <select name="lab_id" class="form-select">
                        <option value="">Semua Lab</option>
                        @foreach ($labs as $lab)
                        <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>{{ $lab->laboratorium }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-1">Program Studi</label>
                    <select name="program_id" class="form-select">
                        <option value="">Semua Prodi</option>
                        @foreach ($programs as $program)
                        <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->program }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="mb-1">Tanggal</label>
                    <input type="date" name="jadwal" class="form-control" value="{{ request('jadwal') }}">
                </div>
                <div class="col-md-4 d-flex gap-2 align-items-end justify-content-end">
                    <button type="submit" class="btn-modern-filter">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    @if(request('lab_id') || request('program_id') || request('jadwal'))
                    <a href="{{ route('jadwal.index') }}" class="btn-modern-light">Reset</a>
                    @endif
                    <button type="button" class="btn-modern-light" data-bs-toggle="modal" data-bs-target="#importJadwalModal">
                        <i class="fas fa-file-excel me-1 text-success"></i> Import Excel / CSV
                    </button>
                    <a href="{{ route('jadwal.create') }}" class="btn-modern-primary">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                    <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                </div>
            </div>
        </form>
    </div>

    <!-- Summary & Per-Page Selector -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <span class="summary-text">Menampilkan <strong>{{ $jadwals->firstItem() ?? 0 }}–{{ $jadwals->lastItem() ?? 0 }}</strong> dari <strong>{{ $jadwals->total() }}</strong> jadwal</span>
        @include('layout.per-page', ['default' => 25])
    </div>

    <!-- Table -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width:45px">#</th>
                        <th>Mata Kuliah</th>
                        <th>Laboratorium</th>
                        <th>Hari / Tanggal</th>
                        <th style="white-space: nowrap;">Waktu (Mulai &ndash; Selesai)</th>
                        <th>Prodi</th>
                        <th style="width:120px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $key => $jadwal)
                    @php $dt = \Carbon\Carbon::parse($jadwal->jadwal); @endphp
                    <tr>
                        <td class="text-muted">{{ $jadwals->firstItem() + $key }}</td>
                        <td>
                            <div class="matkul-name">{{ $jadwal->matkulId->matakuliah ?? '-' }}</div>
                            <div class="dosen-name">{{ $jadwal->matkulId->dosen ?? '' }}</div>
                        </td>
                        <td>{{ $jadwal->labId->laboratorium ?? '-' }}</td>
                        <td>
                            <span class="day-label">{{ $dt->translatedFormat('l') }}</span><br>
                            <span class="date-label">{{ $dt->translatedFormat('d M Y') }}</span>
                        </td>
                        <td>
                            <span class="time-label" style="white-space: nowrap;">{{ $jadwal->jam_mulai }} &ndash; {{ $jadwal->jam_selesai_formatted }}</span>
                        </td>
                        <td class="prodi-text">{{ $jadwal->programId->program ?? '-' }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn-action btn-action-reschedule" data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $jadwal->id }}" title="Reschedule">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                                <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="btn-action btn-action-edit" title="Edit Jadwal">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" class="d-inline form-delete"
                                    data-title="Hapus Jadwal Praktikum?"
                                    data-text="Mata kuliah {{ $jadwal->matkulId->matakuliah ?? 'Jadwal ini' }} ({{ date('d/m/Y', strtotime($jadwal->jadwal)) }}). Tindakan ini tidak dapat dibatalkan.">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-action-delete" title="Hapus Jadwal">
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
                                <i class="far fa-calendar-times d-block"></i>
                                <h6>Tidak ada jadwal</h6>
                                <p>Coba ubah filter atau tambah jadwal baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($jadwals->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $jadwals->currentPage() }} / {{ $jadwals->lastPage() }}</span>
            {{ $jadwals->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade app-modal" id="importJadwalModal" tabindex="-1" aria-labelledby="importJadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="importJadwalModalLabel">Import jadwal</h5>
                    <p class="modal-kicker">Isi nama laboratorium, program studi, dan mata kuliah. Setiap baris baru membuat 8 jadwal mingguan. Jadwal yang sudah ada dilewati.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('jadwal.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="field">
                        <label for="import-jadwal-file">Berkas Excel atau CSV <span class="req">*</span></label>
                        <input id="import-jadwal-file" type="file" name="csv_file" class="form-control" accept=".xlsx,.xls,.csv,.txt" required>
                        @if(isset($errors) && $errors->has('csv_file'))<span class="hint" style="color:#dc2626;">{{ $errors->first('csv_file') }}</span>@endif
                    </div>
                    <div class="template-box">
                        <div class="section-label">Template</div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ asset('templates/jadwal_import_template.xlsx') }}" class="btn-modal-save" download>Excel (.xlsx)</a>
                            <a href="{{ asset('templates/jadwal_import_template.csv') }}" class="btn-modal-cancel" download>CSV (.csv)</a>
                        </div>
                        <span class="hint">Berkas Excel menjaga kolom tetap terpisah saat dibuka di Microsoft Excel.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Import jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($jadwals as $jadwal)
<div class="modal fade app-modal" id="editStatusModal{{ $jadwal->id }}" tabindex="-1" aria-labelledby="editStatusModalLabel{{ $jadwal->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="editStatusModalLabel{{ $jadwal->id }}">Ubah jadwal</h5>
                    <p class="modal-kicker">{{ $jadwal->matkulId->matakuliah ?? 'Sesi praktikum' }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="field">
                        <label for="reschedule-start-{{ $jadwal->id }}">Tanggal dan jam mulai <span class="req">*</span></label>
                        <input id="reschedule-start-{{ $jadwal->id }}" type="datetime-local" name="jadwal" class="form-control" value="{{ $jadwal->jadwal }}" required>
                    </div>
                    <div class="field">
                        <label for="reschedule-end-{{ $jadwal->id }}">Jam selesai</label>
                        <input id="reschedule-end-{{ $jadwal->id }}" type="time" name="jam_selesai" class="form-control" value="{{ $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '' }}">
                        <span class="hint">Kosongkan untuk menghitung otomatis, 170 menit setelah jam mulai.</span>
                    </div>
                    <input type="hidden" name="lab_id" value="{{ $jadwal->lab_id }}">
                    <input type="hidden" name="matakuliah_id" value="{{ $jadwal->matakuliah_id }}">
                    <input type="hidden" name="program_id" value="{{ $jadwal->program_id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection