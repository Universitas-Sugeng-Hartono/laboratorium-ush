@extends('layout.home')
@section('inti')
<style>
    .detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }
    .info-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 14px;
        color: #0f172a;
        font-weight: 500;
        margin-bottom: 18px;
    }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Detail Jadwal Praktikum</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jadwal.index') }}" class="text-muted">Jadwal Praktikum</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="detail-card">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">{{ optional($jadwal->matkulId)->matakuliah ?? 'Mata kuliah' }}</h5>
                        <p class="text-muted small mb-0">{{ optional($jadwal->matkulId)->dosen ?? 'Dosen belum diisi' }}</p>
                    </div>
                    <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="btn btn-primary" style="border-radius: 8px;">Ubah Jadwal</a>
                </div>
                <div class="p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label">Laboratorium</div>
                            <div class="info-value">{{ optional($jadwal->labId)->laboratorium ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Program Studi</div>
                            <div class="info-value">{{ optional($jadwal->programId)->program ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Tanggal & Jam Mulai</div>
                            <div class="info-value">{{ $jadwal->jadwal ? \Carbon\Carbon::parse($jadwal->jadwal)->translatedFormat('dddd, D MMMM Y HH:mm') : '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Jam Selesai</div>
                            <div class="info-value">{{ $jadwal->jam_selesai_formatted }} WIB</div>
                        </div>
                    </div>
                    <a href="{{ route('jadwal.index') }}" class="btn btn-light border" style="border-radius: 8px;">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
