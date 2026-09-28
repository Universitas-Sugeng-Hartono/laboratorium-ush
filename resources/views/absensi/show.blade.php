@extends('layout.home')
@section('inti')
<style>
    .detail-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .detail-header {
        padding: 22px 28px;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
    }
    .detail-body {
        padding: 28px;
    }
    .info-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 14.5px;
        color: #0f172a;
        font-weight: 500;
        margin-bottom: 20px;
        line-height: 1.45;
    }
    .section-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 18px;
        padding-bottom: 8px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .signature-box {
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 16px;
        display: inline-block;
        background: #f8fafc;
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
    .btn-action-edit-custom {
        background: #fef3c7 !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }
    .btn-action-edit-custom:hover {
        background: #fde68a !important;
        color: #92400e !important;
        transform: translateY(-1px);
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
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Detail Kunjungan Tamu</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('absensi.index') }}" class="text-muted">Buku Tamu</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Detail Kunjungan #{{ $absen->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="detail-card mb-4">
        <!-- Header -->
        <div class="detail-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px; background: #eff6ff; color: #2563eb; font-size: 22px;">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <h5 class="mb-0 text-dark fw-bold">{{ $absen->tamu }}</h5>
                        @if($absen->kategori_tamu)
                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 font-12">{{ $absen->kategori_tamu }}</span>
                        @endif
                        @if($absen->identitas)
                        <span class="badge bg-light text-secondary border px-2 py-1 font-12">ID: {{ $absen->identitas }}</span>
                        @endif
                    </div>
                    <span class="text-muted small">
                        ID Kunjungan: #{{ $absen->id }} &bull; Tercatat pada: {{ $absen->created_at ? $absen->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                    </span>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="detail-body">
            <div class="row g-4">
                <!-- Kolom 1: Informasi Tamu & Lembaga -->
                <div class="col-md-6">
                    <div class="section-title">
                        <i class="fas fa-id-card text-primary"></i> 1. Identitas & Kontak Tamu
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-label">Nama Lengkap Tamu</div>
                            <div class="info-value fw-bold text-dark">{{ $absen->tamu }}</div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Kategori Pengunjung</div>
                            <div class="info-value">
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $absen->kategori_tamu ?? 'Umum / Tamu' }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Nomor Identitas (NIM / NIK / NIDN)</div>
                            <div class="info-value">{{ $absen->identitas ?? '-' }}</div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Asal Lembaga / Instansi / Prodi</div>
                            <div class="info-value">{{ $absen->instansi ?? '-' }}</div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Nomor Kontak / WhatsApp</div>
                            <div class="info-value">
                                @if($absen->hp)
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $absen->hp)) }}" target="_blank" class="text-success text-decoration-none fw-semibold">
                                    <i class="fab fa-whatsapp me-1"></i> {{ $absen->hp }}
                                </a>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Jumlah Rombongan</div>
                            <div class="info-value">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1">
                                    <i class="fas fa-users me-1"></i> {{ $absen->jumlah_tamu ?? 1 }} Orang
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2: Informasi Kunjungan & Keperluan -->
                <div class="col-md-6">
                    <div class="section-title">
                        <i class="fas fa-microscope text-primary"></i> 2. Ruang & Keperluan Kunjungan
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="info-label">Laboratorium yang Dikunjungi</div>
                            <div class="info-value fw-bold text-primary">
                                {{ optional($absen->labId)->laboratorium ?? '-' }}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Tanggal Kunjungan</div>
                            <div class="info-value">
                                {{ $absen->tanggal ? \Carbon\Carbon::parse($absen->tanggal)->translatedFormat('l, d F Y') : '-' }}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Waktu Masuk (Jam Datang)</div>
                            <div class="info-value">
                                <i class="far fa-clock text-secondary me-1"></i> {{ $absen->jam ? substr($absen->jam, 0, 5) . ' WIB' : '-' }}
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-label">Waktu Selesai (Jam Pulang)</div>
                            <div class="info-value">
                                <i class="far fa-clock text-secondary me-1"></i> {{ $absen->jamselesai ? substr($absen->jamselesai, 0, 5) . ' WIB' : 'Selesai' }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-label">Kategori Keperluan</div>
                            <div class="info-value">
                                <span class="badge bg-info bg-opacity-10 text-info border px-2.5 py-1">
                                    {{ $absen->kategori_keperluan ?? 'Kegiatan Umum' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-label">Uraian / Deskripsi Keperluan</div>
                            <div class="info-value p-3 rounded-3 border bg-light" style="white-space: pre-wrap; font-size: 13.5px;">{{ $absen->keperluan ?? 'Tidak ada rincian keperluan tambahan.' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanda Tangan Digital -->
            <hr class="my-4" style="border-color: #f1f5f9;">
            <div>
                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-signature text-primary me-1"></i> Tanda Tangan Digital Tamu</h6>
                @if ($absen->ttd)
                <div class="signature-box mt-2">
                    <img src="{{ asset('storage/' . $absen->ttd) }}" alt="Tanda Tangan Tamu" style="max-height: 130px; max-width: 280px;" onerror="this.src='{{ asset($absen->ttd) }}'">
                </div>
                @else
                <p class="text-muted small mb-0 fst-italic">Belum ada tanda tangan digital yang tercatat.</p>
                @endif
            </div>

            <!-- Actions Footer -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top" style="border-color: #f1f5f9 !important;">
                <a href="{{ route('absensi.index') }}" class="btn-action-rounded btn-action-back">
                    <i class="fa fa-arrow-left"></i>
                    <span>Kembali ke Daftar Buku Tamu</span>
                </a>
                <div class="d-flex gap-2">
                    @if($absen->hp)
                    @php
                        $cleanHp = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $absen->hp));
                        $waText = rawurlencode("Halo Bapak/Ibu " . $absen->tamu . ", terima kasih telah berkunjung ke Laboratorium Universitas Sugeng Hartono.");
                    @endphp
                    <a href="https://wa.me/{{ $cleanHp }}?text={{ $waText }}" target="_blank" class="btn-action-rounded btn-action-wa">
                        <i class="fab fa-whatsapp" style="font-size: 16px;"></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                    @endif
                    <a href="{{ route('absensi.edit', $absen->id) }}" class="btn-action-rounded btn-action-edit-custom">
                        <i class="fas fa-edit"></i>
                        <span>Edit Data Tamu</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
