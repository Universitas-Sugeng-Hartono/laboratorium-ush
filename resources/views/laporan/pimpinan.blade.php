@extends('layout.home')
@section('inti')
<style>
    .filter-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; margin-bottom: 20px; }
    .filter-card label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 600; }
    .laporan-isi table { width: 100%; border-collapse: collapse; margin: 8px 0 18px; }
    .laporan-isi th, .laporan-isi td { border: 1px solid #e2e8f0; padding: 8px 10px; font-size: 13px; text-align: left; }
    .laporan-isi th { background: #f8fafc; color: #475569; }
    .laporan-isi h3 { font-size: 16px; margin: 18px 0 6px; color: #0f172a; }
    .btn-modern-filter { background: #2563eb; color: #fff; border: none; border-radius: 8px; padding: 7px 18px; font-size: 13px; }
    .btn-modern-light { background: #f8fafc; color: #475569; border: 1px solid #cbd5e1; border-radius: 8px; padding: 7px 14px; font-size: 13px; text-decoration: none; }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Laporan Pimpinan</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Laporan Pimpinan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="filter-card">
        <form action="{{ route('laporan.pimpinan') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="mb-1">Laboratorium</label>
                    <select name="lab_id" class="form-select" required>
                        <option value="">Pilih laboratorium</option>
                        @foreach($laboratories as $lab)
                        <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>{{ $lab->laboratorium }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="mb-1">Tahun akademik</label>
                    <select name="ta_id" class="form-select" required>
                        <option value="">Pilih tahun akademik</option>
                        @foreach($tahun as $ta)
                        <option value="{{ $ta->id }}" {{ request('ta_id') == $ta->id ? 'selected' : '' }}>{{ $ta->ta }}{{ $ta->status === 'aktif' ? ' (Aktif)' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn-modern-filter">Tampilkan</button>
                    @if($laporan)
                    <a class="btn-modern-light" href="{{ route('laporan.pimpinan.pdf', request()->only(['lab_id', 'ta_id'])) }}">Unduh PDF</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    @if($laporan)
    <div class="card border-0 shadow-sm">
        <div class="card-body laporan-isi">
            @include('laporan.isi')
        </div>
    </div>
    @else
    <p class="text-muted">Pilih laboratorium dan tahun akademik untuk menghitung laporan dari data yang ada.</p>
    @endif
</div>
@endsection
