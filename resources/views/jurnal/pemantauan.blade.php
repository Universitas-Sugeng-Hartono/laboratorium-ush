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
    .dosen-name { color: #334155; font-size: 13px; }
    .dosen-kedua { color: #64748b; font-size: 12px; margin-top: 2px; }
    .lab-label { color: #475569; font-size: 13px; }
    .date-label { color: #334155; font-size: 13px; font-weight: 500; }
    .time-label { color: #2563eb; font-size: 12px; font-weight: 500; }
    .status-sudah, .status-belum {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-sudah { background: #dcfce7; color: #166534; }
    .status-belum { background: #fef3c7; color: #92400e; }
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
    .btn-action-whatsapp { background: #dcfce7; color: #16a34a; }
    .btn-action-whatsapp:hover { background: #16a34a; color: #ffffff; }
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
    .btn-modern-filter:hover { background: #1d4ed8; color: #ffffff; }
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
    .btn-modern-light:hover { background: #f1f5f9; color: #0f172a; border-color: #94a3b8; }
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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Pemantauan Jurnal</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Jurnal Praktikum</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center text-end">
            <a href="{{ route('jurnal.index') }}" class="btn-modern-light">Daftar jurnal</a>
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

    <div class="filter-card">
        <form action="{{ route('jurnal.pemantauan') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="mb-1">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="belum" {{ request('status') === 'belum' ? 'selected' : '' }}>Belum</option>
                        <option value="sudah" {{ request('status') === 'sudah' ? 'selected' : '' }}>Sudah</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}" max="{{ $hariIni }}">
                </div>
                <div class="col-md-2">
                    <label class="mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}" max="{{ $hariIni }}">
                </div>
                <div class="col-md-2">
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
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn-modern-filter">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['status', 'tanggal_awal', 'tanggal_akhir', 'lab_id', 'program_id']))
                    <a href="{{ route('jurnal.pemantauan') }}" class="btn-modern-light">Reset</a>
                    @endif
                    <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                </div>
            </div>
        </form>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="summary-text">Menampilkan <strong>{{ $jadwals->firstItem() ?? 0 }}–{{ $jadwals->lastItem() ?? 0 }}</strong> dari <strong>{{ $jadwals->total() }}</strong> jadwal sampai {{ \Carbon\Carbon::parse($hariIni)->translatedFormat('d M Y') }}</span>
            @include('layout.per-page', ['default' => 25])
        </div>
    </div>

    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th>Dosen</th>
                        <th>Mata Kuliah</th>
                        <th>Laboratorium</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        @can('isSuper')
                        <th style="width: 80px;" class="text-end">Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwals as $key => $jadwal)
                    <tr>
                        <td class="text-muted">{{ $jadwals->firstItem() + $key }}</td>
                        <td>
                            <div class="dosen-name">{{ $jadwal->matkulId->dosen ?? '-' }}</div>
                            @if(!empty($jadwal->matkulId->dosen2))
                            <div class="dosen-kedua">{{ $jadwal->matkulId->dosen2 }}</div>
                            @endif
                        </td>
                        <td><div class="matkul-name">{{ $jadwal->matkulId->matakuliah ?? '-' }}</div></td>
                        <td class="lab-label">{{ $jadwal->labId->laboratorium ?? '-' }}</td>
                        <td>
                            <span class="date-label">{{ \Carbon\Carbon::parse($jadwal->jadwal)->translatedFormat('d M Y') }}</span>
                        </td>
                        <td>
                            <span class="time-label">{{ $jadwal->jam_mulai }} &ndash; {{ $jadwal->jam_selesai_formatted }}</span>
                        </td>
                        <td>
                            @if($jadwal->sudah_jurnal)
                            <span class="status-sudah">Sudah</span>
                            @else
                            <span class="status-belum">Belum</span>
                            @endif
                        </td>
                        @can('isSuper')
                        <td class="text-end">
                            @if(!$jadwal->sudah_jurnal)
                            <form action="{{ route('jurnal.pengingat', $jadwal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Kirim pengingat WhatsApp kepada dosen untuk jadwal ini?')">
                                @csrf
                                <button type="submit" class="btn-action btn-action-whatsapp" title="Kirim pengingat WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                        @endcan
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->can('isSuper') ? 8 : 7 }}">
                            <div class="empty-state">
                                <i class="far fa-clipboard d-block"></i>
                                <h6>{{ $peringatanTa ? 'Belum ada tahun akademik aktif' : 'Tidak ada jadwal' }}</h6>
                                <p>{{ $peringatanTa ?: 'Tidak ada jadwal tahun akademik aktif pada rentang tanggal ini.' }}</p>
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
@endsection
