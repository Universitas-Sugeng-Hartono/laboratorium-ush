@extends('layout.home')
@section('inti')
<style>
    .detail-card {
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #eaedf1;
    }
    .detail-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f0f2f5;
    }
    .detail-body {
        padding: 24px;
    }
    .info-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #8392a5;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 14px;
        color: #1b2e4b;
        font-weight: 500;
        margin-bottom: 18px;
    }
    .status-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid transparent;
        line-height: 1.4;
    }
    .status-tag.success { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
    .status-tag.warning { background: #fffbeb; color: #92400e; border-color: #fde68a; }
    .status-tag.danger { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
    .status-tag.info { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .status-tag.success .status-dot { background: #10b981; }
    .status-tag.warning .status-dot { background: #f59e0b; }
    .status-tag.danger .status-dot { background: #ef4444; }
    .status-tag.info .status-dot { background: #3b82f6; }

    .items-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    .items-table th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #8392a5;
        font-weight: 600;
        border-bottom: 2px solid #e3e7ed;
        padding: 10px 14px;
    }
    .items-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f0f2f5;
        font-size: 13.5px;
        color: #3b4863;
    }
    .items-table tr:last-child td { border-bottom: none; }
    .signature-box {
        border: 1px dashed #d5dce6;
        border-radius: 8px;
        padding: 16px;
        display: inline-block;
        background: #fafbfc;
    }
    .btn-action-rounded {
        border-radius: 50px !important;
        padding: 9px 22px !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        text-decoration: none !important;
    }
    .btn-action-back {
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important;
        color: #475569 !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }
    .btn-action-back:hover {
        background: #f8fafc !important;
        color: #0f172a !important;
        border-color: #94a3b8 !important;
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08) !important;
    }
    .btn-action-wa {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25) !important;
    }
    .btn-action-wa:hover {
        background: linear-gradient(135deg, #22bf5b 0%, #0e786b 100%) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 211, 102, 0.35) !important;
    }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Detail Pemakaian & Peminjaman</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pemakaian.index') }}" class="text-muted">Pemakaian</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Detail Data #{{ $pemakaian->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="detail-card shadow-sm mb-4">
        <!-- Header -->
        <div class="detail-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h5 class="mb-1 text-dark fw-bold">{{ $pemakaian->nama }}</h5>
                <span class="text-muted small">ID Peminjaman: #{{ $pemakaian->id }} &bull; Dibuat pada {{ $pemakaian->created_at ? $pemakaian->created_at->translatedFormat('d F Y, H:i') : '-' }}</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if($pemakaian->keterangan == 'setuju')
                <span class="status-tag success"><span class="status-dot"></span> Disetujui</span>
                @elseif($pemakaian->keterangan == 'proses')
                <span class="status-tag info"><span class="status-dot"></span> Sedang Diproses</span>
                @elseif($pemakaian->keterangan == 'ditolak')
                <span class="status-tag danger"><span class="status-dot"></span> Ditolak</span>
                @else
                <span class="status-tag warning"><span class="status-dot"></span> Menunggu Validasi</span>
                @endif

                @if($pemakaian->status_pengembalian === 'sudah')
                <span class="status-tag success"><i class="fas fa-check-circle me-1"></i> Sudah Kembali</span>
                @else
                <span class="status-tag warning"><i class="far fa-clock me-1"></i> Belum Kembali</span>
                @endif
            </div>
        </div>

        <!-- Body -->
        <div class="detail-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-label">Nama Peminjam</div>
                    <div class="info-value">{{ $pemakaian->nama }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Kontak / No. HP</div>
                    <div class="info-value">{{ $pemakaian->nomor ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Laboratorium</div>
                    <div class="info-value">{{ optional($pemakaian->labId)->laboratorium ?? '-' }}</div>
                </div>

                <div class="col-md-4">
                    <div class="info-label">Program Studi</div>
                    <div class="info-value">{{ optional($pemakaian->programId)->program ?? 'Umum / Non-Prodi' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Mata Kuliah</div>
                    <div class="info-value">{{ optional($pemakaian->matkulId)->matakuliah ?? 'Tidak ada mata kuliah' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Keperluan</div>
                    <div class="info-value">{{ $pemakaian->keperluan ?? '-' }}</div>
                </div>

                <div class="col-md-4">
                    <div class="info-label">Tanggal Peminjaman</div>
                    <div class="info-value">
                        {{ $pemakaian->tgl_peminjaman ? \Carbon\Carbon::parse($pemakaian->tgl_peminjaman)->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Tanggal Pengembalian</div>
                    <div class="info-value">
                        {{ $pemakaian->tgl_pengembalian ? \Carbon\Carbon::parse($pemakaian->tgl_pengembalian)->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Jadwal Praktikum</div>
                    <div class="info-value">{{ optional($pemakaian->jadwalId)->jadwal ?? '-' }}</div>
                </div>
            </div>

            <hr class="my-3" style="border-color: #f0f2f5;">

            <!-- Daftar Item Alat & Bahan -->
            <div class="row g-4 mt-1">
                <!-- Alat -->
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3"><i class="fas fa-tools me-2 text-muted"></i>Daftar Alat Dipinjam</h6>
                    @if(isset($alats) && $alats->count())
                    <div class="border rounded" style="border-color: #f0f2f5 !important;">
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>Nama Alat</th>
                                    <th class="text-center" style="width: 100px;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alats as $alat)
                                <tr>
                                    <td>{{ $alat->alat }}</td>
                                    <td class="text-center fw-bold">{{ $alat->jumlah_pinjam }} Unit</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted small mb-0">Tidak ada alat yang tercatat untuk peminjaman ini.</p>
                    @endif
                </div>

                <!-- Bahan -->
                <div class="col-md-6">
                    <h6 class="fw-bold text-dark mb-3"><i class="fas fa-flask me-2 text-muted"></i>Daftar Bahan Digunakan</h6>
                    @if(isset($bahans) && $bahans->count())
                    <div class="border rounded" style="border-color: #f0f2f5 !important;">
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>Nama Bahan</th>
                                    <th class="text-center" style="width: 100px;">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bahans as $bahan)
                                <tr>
                                    <td>{{ $bahan->bahan }}</td>
                                    <td class="text-center fw-bold">{{ $bahan->jumlah_pakai }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted small mb-0">Tidak ada bahan habis pakai yang digunakan.</p>
                    @endif
                </div>
            </div>

            <!-- Tanda Tangan -->
            <hr class="my-4" style="border-color: #f0f2f5;">
            <div>
                <h6 class="fw-bold text-dark mb-2">Tanda Tangan Peminjam</h6>
                @if ($pemakaian->ttd)
                <div class="signature-box mt-2">
                    <img src="{{ asset('storage/' . $pemakaian->ttd) }}" alt="Tanda Tangan" style="max-height: 120px; max-width: 260px;" onerror="this.src='{{ asset($pemakaian->ttd) }}'">
                </div>
                @else
                <p class="text-muted small mb-0">Belum ada tanda tangan yang tersimpan.</p>
                @endif
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top" style="border-color: #f0f2f5 !important;">
                <a href="{{ route('pemakaian.index') }}" class="btn-action-rounded btn-action-back">
                    <i class="fa fa-arrow-left"></i>
                    <span>Kembali ke Daftar</span>
                </a>
                <div class="d-flex gap-2">
                    @if($pemakaian->nomor)
                    <a href="{{ route('kirim.was', $pemakaian->id) }}" 
                       class="btn-action-rounded btn-action-wa"
                       onclick="return confirm('Kirim pesan pengingat pengembalian WhatsApp ke peminjam {{ $pemakaian->nama }} ({{ $pemakaian->nomor }})?')">
                        <i class="fab fa-whatsapp" style="font-size: 16px;"></i>
                        <span>Kirim Pengingat WhatsApp</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection