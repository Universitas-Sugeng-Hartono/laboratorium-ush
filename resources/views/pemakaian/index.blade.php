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
    .borrower-name { font-weight: 600; color: #0f172a; font-size: 13.5px; }
    .purpose-text { color: #64748b; font-size: 12px; margin-top: 2px; }
    .date-label { color: #334155; font-size: 13px; font-weight: 500; }
    .lab-label { color: #475569; font-size: 13px; }
    
    .status-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 500;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        line-height: 1.4;
    }
    .status-tag:hover { transform: translateY(-1px); box-shadow: 0 2px 4px rgba(0,0,0,0.06); }
    .status-tag.success { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
    .status-tag.warning { background: #fffbeb; color: #92400e; border-color: #fde68a; }
    .status-tag.danger { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
    .status-tag.info { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .status-tag.success .status-dot { background: #10b981; }
    .status-tag.warning .status-dot { background: #f59e0b; }
    .status-tag.danger .status-dot { background: #ef4444; }
    .status-tag.info .status-dot { background: #3b82f6; }

    .return-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 500;
    }
    .return-status.returned { color: #059669; }
    .return-status.pending { color: #d97706; }

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
    .btn-action-info {
        background: #e0f2fe;
        color: #0284c7;
    }
    .btn-action-info:hover {
        background: #0284c7;
        color: #ffffff;
    }
    .btn-action-whatsapp {
        background: #dcfce7;
        color: #16a34a;
    }
    .btn-action-whatsapp:hover {
        background: #16a34a;
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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Data Pemakaian & Peminjaman</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Daftar Peminjaman</li>
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
        <form id="searchForm" method="GET" action="{{ route('pemakaian.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="mb-1">Nama Peminjam</label>
                    <input type="text" class="form-control" name="nama" placeholder="Cari nama peminjam..." value="{{ request('nama') }}">
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
                    @if(request('nama') || request('lab_id') || request('tanggal_awal') || request('tanggal_akhir'))
                    <a href="{{ route('pemakaian.index') }}" class="btn-modern-light">Reset</a>
                    @endif
                    <a href="{{ route('pemakaian.create') }}" class="btn-modern-primary">
                        <i class="fas fa-plus"></i> Pinjam
                    </a>
                    <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                </div>
            </div>
        </form>
    </div>

    <!-- Summary & Per-Page Selector -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <span class="summary-text">Menampilkan <strong>{{ $pemakaian->firstItem() ?? 0 }}–{{ $pemakaian->lastItem() ?? 0 }}</strong> dari <strong>{{ $pemakaian->total() }}</strong> data peminjaman</span>
        @include('layout.per-page', ['default' => 25])
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 45px;">#</th>
                        <th>Peminjam & Keperluan</th>
                        <th>Laboratorium</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status Approval</th>
                        <th>Pengembalian</th>
                        <th style="width: 140px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemakaian as $key => $pinjam)
                    <tr>
                        <td class="text-muted">{{ $pemakaian->firstItem() + $key }}</td>
                        <td>
                            <div class="borrower-name">{{ $pinjam->nama }}</div>
                            @if($pinjam->keperluan)
                            <div class="purpose-text text-truncate" style="max-width: 250px;" title="{{ $pinjam->keperluan }}">{{ $pinjam->keperluan }}</div>
                            @endif
                        </td>
                        <td class="lab-label">{{ $pinjam->labId->laboratorium ?? '-' }}</td>
                        <td>
                            @if($pinjam->tgl_peminjaman)
                            <span class="date-label">{{ \Carbon\Carbon::parse($pinjam->tgl_peminjaman)->translatedFormat('d M Y') }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($pinjam->tgl_pengembalian)
                            <span class="date-label">{{ \Carbon\Carbon::parse($pinjam->tgl_pengembalian)->translatedFormat('d M Y') }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($pinjam->keterangan == 'setuju')
                            <button type="button" class="status-tag success" data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $pinjam->id }}" title="Klik untuk ubah status">
                                <span class="status-dot"></span> Disetujui
                            </button>
                            @elseif($pinjam->keterangan == 'proses')
                            <button type="button" class="status-tag info" data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $pinjam->id }}" title="Klik untuk ubah status">
                                <span class="status-dot"></span> Proses
                            </button>
                            @elseif($pinjam->keterangan == 'ditolak')
                            <button type="button" class="status-tag danger" data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $pinjam->id }}" title="Klik untuk ubah status">
                                <span class="status-dot"></span> Ditolak
                            </button>
                            @else
                            <button type="button" class="status-tag warning" data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $pinjam->id }}" title="Klik untuk ubah status">
                                <span class="status-dot"></span> Menunggu
                            </button>
                            @endif
                        </td>
                        <td>
                            @if($pinjam->status_pengembalian === 'sudah')
                            <span class="return-status returned">
                                <i class="fas fa-check-circle"></i> Sudah Kembali
                            </span>
                            @else
                            <span class="return-status pending">
                                <i class="far fa-clock"></i> Belum Kembali
                            </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('pemakaian.show', $pinjam->id) }}" class="btn-action btn-action-primary" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($pinjam->keterangan === 'setuju' && $pinjam->status_pengembalian !== 'sudah')
                                <button type="button" class="btn-action btn-action-info" title="Proses Pengembalian" data-bs-toggle="modal" data-bs-target="#pengembalianModal{{ $pinjam->id }}">
                                    <i class="fas fa-undo-alt"></i>
                                </button>
                                @endif
                                @if($pinjam->status_pengembalian !== 'sudah')
                                <a href="{{ route('kirim.was', $pinjam->id) }}" class="btn-action btn-action-whatsapp" title="Kirim Notifikasi WA">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                @endif
                                <form action="{{ route('pemakaian.destroy', $pinjam->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
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
                                <i class="far fa-folder-open d-block"></i>
                                <h6>Tidak ada data peminjaman</h6>
                                <p>Belum ada catatan pemakaian laboratorium yang sesuai dengan kriteria filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pemakaian->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $pemakaian->currentPage() }} / {{ $pemakaian->lastPage() }}</span>
            {{ $pemakaian->links() }}
        </div>
        @endif
    </div>
</div>

@foreach($pemakaian as $pinjam)
<div class="modal fade app-modal" id="editStatusModal{{ $pinjam->id }}" tabindex="-1" aria-labelledby="editStatusModalLabel{{ $pinjam->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="editStatusModalLabel{{ $pinjam->id }}">Ubah status</h5>
                    <p class="modal-kicker">{{ $pinjam->nama }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('pemakaian.update', $pinjam->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $pinjam->id }}">
                    <input type="hidden" name="nama" value="{{ $pinjam->nama }}">
                    <input type="hidden" name="matakuliah_id" value="{{ $pinjam->matakuliah_id }}">
                    <input type="hidden" name="jadwal_id" value="{{ $pinjam->jadwal_id }}">
                    <input type="hidden" name="program_id" value="{{ $pinjam->program_id }}">
                    <input type="hidden" name="keperluan" value="{{ $pinjam->keperluan }}">
                    <input type="hidden" name="tgl_peminjaman" value="{{ $pinjam->tgl_peminjaman }}">
                    <input type="hidden" name="tgl_pengembalian" value="{{ $pinjam->tgl_pengembalian }}">
                    <input type="hidden" name="alat_id" value="{{ is_array($pinjam->alat_id) ? json_encode($pinjam->alat_id) : $pinjam->alat_id }}">
                    <input type="hidden" name="bahan_id" value="{{ is_array($pinjam->bahan_id) ? json_encode($pinjam->bahan_id) : $pinjam->bahan_id }}">
                    <input type="hidden" name="lab_id" value="{{ $pinjam->lab_id }}">
                    <input type="hidden" name="ttd" value="{{ $pinjam->ttd }}">
                    <div class="field">
                        <label for="status-pinjam-{{ $pinjam->id }}">Status persetujuan</label>
                        <select id="status-pinjam-{{ $pinjam->id }}" name="keterangan" class="form-select">
                            <option value="setuju" {{ $pinjam->keterangan == 'setuju' ? 'selected' : '' }}>Disetujui</option>
                            <option value="proses" {{ $pinjam->keterangan == 'proses' ? 'selected' : '' }}>Sedang diproses</option>
                            <option value="ditolak" {{ $pinjam->keterangan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="menunggu" {{ $pinjam->keterangan == 'menunggu' ? 'selected' : '' }}>Menunggu validasi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($pinjam->keterangan === 'setuju' && $pinjam->status_pengembalian !== 'sudah')
<div class="modal fade app-modal" id="pengembalianModal{{ $pinjam->id }}" tabindex="-1" aria-labelledby="pengembalianModalLabel{{ $pinjam->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('pengembalian.store', $pinjam->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="pengembalianModalLabel{{ $pinjam->id }}">Pengembalian barang</h5>
                        <p class="modal-kicker">Catat jumlah dan kondisi barang yang kembali.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="meta-strip">
                        <div class="row g-2">
                            <div class="col-md-4"><strong>Peminjam</strong><br>{{ $pinjam->nama }}</div>
                            <div class="col-md-4"><strong>Tanggal pinjam</strong><br>{{ $pinjam->tgl_peminjaman }}</div>
                            <div class="col-md-4"><strong>Rencana kembali</strong><br>{{ $pinjam->tgl_pengembalian }}</div>
                        </div>
                    </div>

                    @if($pinjam->pemakaianAlat && $pinjam->pemakaianAlat->count())
                    <div class="section-label">Alat</div>
                    <table class="table table-sm align-middle return-table mb-4">
                        <thead>
                            <tr>
                                <th>Nama alat</th>
                                <th class="text-center" style="width:90px">Pinjam</th>
                                <th class="text-center" style="width:110px">Kembali</th>
                                <th style="width:140px">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pinjam->pemakaianAlat as $alat)
                            <tr>
                                <td>{{ $alat->alatId->alat ?? '-' }}</td>
                                <td class="text-center text-muted">{{ $alat->jumlah_pinjam }}</td>
                                <td>
                                    <input type="number" name="alat_kembali[{{ $alat->id }}][jumlah]" class="form-control form-control-sm text-center" min="0" max="{{ $alat->jumlah_pinjam }}" value="{{ $alat->jumlah_pinjam }}" required>
                                </td>
                                <td>
                                    <select name="alat_kembali[{{ $alat->id }}][rusak]" class="form-select form-select-sm" required>
                                        <option value="normal" selected>Normal</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    @if($pinjam->pemakaianBahan && $pinjam->pemakaianBahan->count())
                    <div class="section-label">Bahan</div>
                    <table class="table table-sm align-middle return-table mb-2">
                        <thead>
                            <tr>
                                <th>Nama bahan</th>
                                <th class="text-center" style="width:90px">Pakai</th>
                                <th class="text-center" style="width:110px">Sisa</th>
                                <th style="width:140px">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pinjam->pemakaianBahan as $bahan)
                            <tr>
                                <td>{{ $bahan->bahanId->bahan ?? '-' }}</td>
                                <td class="text-center text-muted">{{ $bahan->jumlah_pakai }}</td>
                                <td>
                                    <input type="number" name="bahan_kembali[{{ $bahan->id }}][jumlah]" class="form-control form-control-sm text-center" min="0" max="{{ $bahan->jumlah_pakai }}" value="{{ $bahan->jumlah_pakai }}" required>
                                </td>
                                <td>
                                    <select name="bahan_kembali[{{ $bahan->id }}][rusak]" class="form-select form-select-sm" required>
                                        <option value="normal" selected>Normal</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save is-success">Konfirmasi pengembalian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection