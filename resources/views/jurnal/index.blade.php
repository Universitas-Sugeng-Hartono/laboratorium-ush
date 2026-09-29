@extends('layout.home')
@section('inti')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

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
    .materi-text { color: #64748b; font-size: 12px; margin-top: 2px; }
    .lab-label { color: #475569; font-size: 13px; }
    .prodi-text { color: #64748b; font-size: 12px; }
    .date-label { color: #334155; font-size: 13px; font-weight: 500; }
    .time-label { color: #2563eb; font-size: 12px; font-weight: 500; }
    .count-label { color: #0f172a; font-size: 13px; font-weight: 600; }

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
    .btn-action-primary {
        background: #eff6ff;
        color: #2563eb;
    }
    .btn-action-primary:hover {
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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Jurnal Praktikum</h4>
            @can('manageMaster')
            <a href="{{ route('jurnal.pemantauan') }}" class="btn-modern-light mb-2">Pemantauan jurnal</a>
            @endcan
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Daftar Jurnal</li>
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
    @if(!empty($peringatanTa))
    <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
        <i class="fas fa-exclamation-triangle me-1"></i> {{ $peringatanTa }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Card -->
    <div class="filter-card">
        <form action="{{ route('jurnal.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="mb-1">Laboratorium</label>
                    <select name="lab_id" class="form-select">
                        <option value="">Semua Lab</option>
                        @foreach ($labs as $lab)
                        <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                            {{ $lab->laboratorium }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-1">Program Studi</label>
                    <select name="program_id" class="form-select">
                        <option value="">Semua Prodi</option>
                        @foreach ($programs as $program)
                        <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->program }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-2">
                    <label class="mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-2 d-flex gap-2 align-items-end justify-content-end">
                    <button type="submit" class="btn-modern-filter">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    @if(request('lab_id') || request('program_id') || request('tanggal_awal') || request('tanggal_akhir'))
                    <a href="{{ route('jurnal.index') }}" class="btn-modern-light">Reset</a>
                    @endif
                    <a href="{{ route('jurnal.create') }}" class="btn-modern-primary">
                        <i class="fas fa-plus"></i> Jurnal
                    </a>
                    <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                </div>
            </div>
        </form>
    </div>

    <!-- Summary & Export Toolbar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="summary-text">Menampilkan <strong>{{ $jurnals->firstItem() ?? 0 }}–{{ $jurnals->lastItem() ?? 0 }}</strong> dari <strong>{{ $jurnals->total() }}</strong> jurnal praktikum</span>
            @include('layout.per-page', ['default' => 25])
        </div>
        <div class="d-flex flex-wrap gap-2">
            <!-- Dropdown Cetak / Export -->
            <div class="dropdown">
                <button class="btn-modern-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-export me-1 text-muted"></i> Export Data
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius: 10px; overflow: hidden;">
                    <li>
                        <form action="/jurnal-export-csv" method="GET" class="m-0">
                            <input type="hidden" name="lab_id" value="{{ request('lab_id') }}">
                            <input type="hidden" name="program_id" value="{{ request('program_id') }}">
                            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                            <button type="submit" class="dropdown-item py-2 small">
                                <i class="fas fa-file-excel text-success me-2"></i> Export Excel (.csv)
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="/jurnal-export-pdf" method="GET" target="_blank" class="m-0">
                            <input type="hidden" name="lab_id" value="{{ request('lab_id') }}">
                            <input type="hidden" name="program_id" value="{{ request('program_id') }}">
                            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                            <button type="submit" class="dropdown-item py-2 small">
                                <i class="fas fa-file-pdf text-danger me-2"></i> Export PDF (Lengkap)
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="/jurnal-export-pdf-no-ttd" method="GET" target="_blank" class="m-0">
                            <input type="hidden" name="lab_id" value="{{ request('lab_id') }}">
                            <input type="hidden" name="program_id" value="{{ request('program_id') }}">
                            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                            <button type="submit" class="dropdown-item py-2 small">
                                <i class="fas fa-file-pdf text-warning me-2"></i> PDF (Tanpa TTD)
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn-modern-light" data-bs-toggle="modal" data-bs-target="#statusModal">
                <i class="fas fa-print me-1 text-muted"></i> Cetak per Matkul
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th>Mata Kuliah & Materi</th>
                        <th>Laboratorium</th>
                        <th>Program Studi</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th style="width: 80px;" class="text-center">Peserta</th>
                        <th style="width: 120px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jurnals as $key => $jurnal)
                    <tr>
                        <td class="text-muted">{{ $jurnals->firstItem() + $key }}</td>
                        <td>
                            <div class="matkul-name">{{ $jurnal->matkulId->matakuliah ?? '-' }}</div>
                            @if($jurnal->materi)
                            <div class="materi-text text-truncate" style="max-width: 280px;" title="{{ $jurnal->materi }}">{{ $jurnal->materi }}</div>
                            @endif
                        </td>
                        <td class="lab-label">{{ $jurnal->labId->laboratorium ?? '-' }}</td>
                        <td class="prodi-text">{{ $jurnal->programId->program ?? 'Semua Prodi' }}</td>
                        <td>
                            @if($jurnal->tanggal)
                            <span class="date-label">{{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d M Y') }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="time-label">{{ substr($jurnal->jam_mulai, 0, 5) }} &ndash; {{ substr($jurnal->jam_selesai, 0, 5) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="count-label">{{ $jurnal->jumlah ?? 0 }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('jurnal.show', $jurnal->id) }}" class="btn-action btn-action-primary" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn-action btn-action-edit" title="Ubah Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jurnal praktikum ini?')">
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
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="far fa-clipboard d-block"></i>
                                <h6>Tidak ada data jurnal</h6>
                                <p>Tidak ada catatan jurnal praktikum yang sesuai dengan kriteria filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($jurnals->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $jurnals->currentPage() }} / {{ $jurnals->lastPage() }}</span>
            {{ $jurnals->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade app-modal" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="statusModalLabel">Cetak jurnal</h5>
                    <p class="modal-kicker">Pilih mata kuliah untuk rekapitulasi PDF.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="/jurnal-perkuliahan-pdf" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="field">
                        <label for="multiple-select-field">Mata kuliah <span class="req">*</span></label>
                        <select name="matakuliah_id[]" class="form-select" id="multiple-select-field" data-placeholder="Pilih mata kuliah" multiple required>
                            @foreach ($matkuls as $mk)
                            <option value="{{ $mk->id }}" {{ (is_array(request('matakuliah_id')) && in_array($mk->id, request('matakuliah_id'))) ? 'selected' : '' }}>
                                {{ $mk->matakuliah }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Cetak PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    if (window.jQuery && $('#multiple-select-field').length) {
        $('#multiple-select-field').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#statusModal'),
            width: '100%',
            placeholder: 'Pilih satu atau lebih mata kuliah...',
            closeOnSelect: false,
        });
    }
});
</script>
@endsection