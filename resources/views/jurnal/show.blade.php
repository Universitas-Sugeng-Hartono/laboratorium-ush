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
    .signature-box {
        border: 1px dashed #d5dce6;
        border-radius: 8px;
        padding: 16px;
        display: inline-block;
        background: #fafbfc;
    }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Detail Jurnal Praktikum</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jurnal.index') }}" class="text-muted">Jurnal</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Detail Data #{{ $jurnal->id }}</li>
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
                <h5 class="mb-1 text-dark fw-bold">{{ optional($jurnal->matkulId)->matakuliah ?? 'Jurnal Praktikum' }}</h5>
                <span class="text-muted small">ID Jurnal: #{{ $jurnal->id }} &bull; Dosen: {{ optional($jurnal->matkulId)->dosen ?? '-' }}</span>
            </div>
            <div>
                <a href="{{ route('jurnal.edit', $jurnal->id) }}" class="btn btn-sm btn-light border px-3" style="font-size: 13px;">
                    <i class="fas fa-edit me-1 text-muted"></i> Ubah Data
                </a>
            </div>
        </div>

        <!-- Body -->
        <div class="detail-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-label">Laboratorium</div>
                    <div class="info-value">{{ optional($jurnal->labId)->laboratorium ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Program Studi</div>
                    <div class="info-value">{{ optional($jurnal->programId)->program ?? 'Semua Prodi' }}</div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Mata Kuliah</div>
                    <div class="info-value">{{ optional($jurnal->matkulId)->matakuliah ?? '-' }}</div>
                </div>

                <div class="col-md-4">
                    <div class="info-label">Tanggal Pelaksanaan</div>
                    <div class="info-value">
                        {{ $jurnal->tanggal ? \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Waktu</div>
                    <div class="info-value">
                        {{ substr($jurnal->jam_mulai, 0, 5) }} &ndash; {{ substr($jurnal->jam_selesai, 0, 5) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-label">Jumlah Mahasiswa / Peserta</div>
                    <div class="info-value">{{ $jurnal->jumlah ?? 0 }} Orang</div>
                </div>

                <div class="col-12">
                    <div class="info-label">Materi / Bahasan Praktikum</div>
                    <div class="info-value" style="font-size: 13.5px; line-height: 1.6;">
                        {{ $jurnal->materi ?? '-' }}
                    </div>
                </div>
            </div>

            <!-- Tanda Tangan -->
            <hr class="my-3" style="border-color: #f0f2f5;">
            <div>
                <h6 class="fw-bold text-dark mb-2">Tanda Tangan Dosen / Asisten</h6>
                @if ($jurnal->ttd)
                <div class="signature-box mt-2">
                    <img src="{{ asset('storage/' . $jurnal->ttd) }}" alt="Tanda Tangan" style="max-height: 120px; max-width: 260px;" onerror="this.src='{{ asset($jurnal->ttd) }}'">
                </div>
                @else
                <p class="text-muted small mb-0">Belum ada tanda tangan yang tersimpan.</p>
                @endif
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top" style="border-color: #f0f2f5 !important;">
                <a href="{{ route('jurnal.index') }}" class="btn btn-sm btn-light border px-3" style="font-size: 13px;">
                    &larr; Kembali ke Daftar Jurnal
                </a>
            </div>
        </div>
    </div>
</div>
@endsection