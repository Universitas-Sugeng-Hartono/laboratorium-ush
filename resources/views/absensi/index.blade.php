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
    .guest-name { font-weight: 600; color: #0f172a; font-size: 13.5px; }
    .contact-text { color: #64748b; font-size: 12px; margin-top: 2px; }
    .date-label { font-weight: 600; color: #0f172a; }
    .time-label { color: #2563eb; font-size: 12px; font-weight: 500; }
    .lab-label { color: #475569; font-size: 13px; }
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
    .btn-action-view {
        background: #eff6ff;
        color: #2563eb;
    }
    .btn-action-view:hover {
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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Buku Tamu</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('absensi.index') }}" class="text-muted">Buku Tamu</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Daftar Kunjungan</li>
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
        <form action="{{ route('absensi.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
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
                <div class="col-md-2">
                    <label class="mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-2">
                    <label class="mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-4 d-flex gap-2 align-items-end justify-content-end">
                    <button type="submit" class="btn-modern-filter">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    @if(request('lab_id') || request('tanggal_awal') || request('tanggal_akhir'))
                    <a href="{{ route('absensi.index') }}" class="btn-modern-light">Reset</a>
                    @endif
                    <a href="{{ route('absensi.create') }}" class="btn-modern-primary">
                        <i class="fas fa-plus"></i> Catat Tamu
                    </a>
                    <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                </div>
            </div>
        </form>
    </div>

    <!-- Summary & Per-Page Selector -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <span class="summary-text">Menampilkan <strong>{{ $absen->firstItem() ?? 0 }}–{{ $absen->lastItem() ?? 0 }}</strong> dari <strong>{{ $absen->total() }}</strong> kunjungan</span>
        @include('layout.per-page', ['default' => 25])
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th>Nama Tamu & Kontak</th>
                        <th>Laboratorium</th>
                        <th>Tanggal & Waktu</th>
                        <th>Keperluan</th>
                        <th style="width: 90px;" class="text-center">Jumlah</th>
                        <th style="width: 100px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absen as $key => $data)
                    <tr>
                        <td class="text-muted">{{ $absen->firstItem() + $key }}</td>
                        <td>
                            <div class="guest-name fw-bold text-dark">{{ $data->tamu }}</div>
                            <div class="d-flex flex-wrap gap-1 align-items-center mt-1">
                                @if($data->kategori_tamu)
                                <span class="badge bg-primary bg-opacity-10 text-primary font-11 px-2 py-1">{{ $data->kategori_tamu }}</span>
                                @endif
                                @if($data->identitas)
                                <span class="badge bg-light text-secondary border font-11 px-2 py-1">ID: {{ $data->identitas }}</span>
                                @endif
                            </div>
                            @if($data->instansi)
                            <div class="text-muted small mt-1"><i class="fas fa-building text-secondary me-1"></i>{{ $data->instansi }}</div>
                            @endif
                            @if($data->hp)
                            <div class="contact-text small mt-1"><i class="fab fa-whatsapp text-success me-1"></i>{{ $data->hp }}</div>
                            @endif
                        </td>
                        <td class="lab-label">{{ $data->labId->laboratorium ?? '-' }}</td>
                        <td>
                            @if($data->tanggal)
                            <span class="date-label">{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d M Y') }}</span><br>
                            @endif
                            <span class="time-label">{{ substr($data->jam, 0, 5) }} &ndash; {{ substr($data->jamselesai, 0, 5) }}</span>
                        </td>
                        <td>
                            @if($data->kategori_keperluan)
                            <span class="badge bg-info bg-opacity-10 text-info font-11 mb-1 d-inline-block">{{ $data->kategori_keperluan }}</span><br>
                            @endif
                            <div class="text-truncate" style="max-width: 280px;" title="{{ $data->keperluan }}">
                                {{ $data->keperluan ?? '-' }}
                            </div>
                            @if($data->ttd)
                            <span class="badge bg-success bg-opacity-10 text-success font-11 mt-1"><i class="fas fa-check-circle me-1"></i>TTD Digital</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="count-label">{{ $data->jumlah_tamu ?? 1 }}</span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('absensi.show', $data->id) }}" class="btn-action btn-action-view" title="Lihat Detail Tamu">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('absensi.edit', $data->id) }}" class="btn-action btn-action-edit" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('absensi.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data tamu ini?')">
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
                                <i class="far fa-address-book d-block"></i>
                                <h6>Tidak ada data buku tamu</h6>
                                <p>Belum ada catatan kunjungan tamu laboratorium yang sesuai dengan kriteria filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($absen->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $absen->currentPage() }} / {{ $absen->lastPage() }}</span>
            {{ $absen->links() }}
        </div>
        @endif
    </div>
</div>
@endsection