@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('alat.index') }}" class="text-muted">Inventaris Alat</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Ubah Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="card-title mb-1">Ubah Inventaris Alat</h4>
                            <p class="text-muted small mb-0">Perbarui kondisi fisik, status ketersediaan, atau lokasi alat.</p>
                        </div>
                        <a href="{{ route('alat.cetak.qr', $alat->id) }}" target="_blank" class="btn btn-outline-dark btn-sm">
                            <i class="fas fa-qrcode me-1"></i> Cetak Label QR
                        </a>
                    </div>

                    @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('alat.update', $alat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="lab_id" class="form-label fw-bold">Laboratorium <span class="text-danger">*</span></label>
                                <select name="lab_id" id="lab_id" class="form-control" required>
                                    <option value="">-- Pilih Laboratorium --</option>
                                    @foreach($laboratories as $lab)
                                    <option value="{{ $lab->id }}" {{ old('lab_id', $alat->lab_id) == $lab->id ? 'selected' : '' }}>
                                        {{ $lab->laboratorium }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="kode" class="form-label fw-bold">Kode Inventaris <span class="text-danger">*</span></label>
                                <input type="text" name="kode" id="kode" class="form-control" placeholder="Contoh: USH/LAB-ICT1/ALT/001"
                                    value="{{ old('kode', $alat->kode) }}" required>
                            </div>

                            <div class="col-md-8">
                                <label for="alat" class="form-label fw-bold">Nama Alat / Aset <span class="text-danger">*</span></label>
                                <input type="text" name="alat" id="alat" class="form-control"
                                    value="{{ old('alat', $alat->alat) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="jumlah" class="form-label fw-bold">Jumlah Unit <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control"
                                    min="0" value="{{ old('jumlah', $alat->jumlah) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="kondisi" class="form-label fw-bold">Kondisi Fisik</label>
                                <select name="kondisi" id="kondisi" class="form-control">
                                    <option value="baik" {{ old('kondisi', $alat->kondisi) == 'baik' ? 'selected' : '' }}>Baik (Layak Pakai Penuh)</option>
                                    <option value="rusak_ringan" {{ old('kondisi', $alat->kondisi) == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan (Perlu Servis Minor)</option>
                                    <option value="rusak" {{ old('kondisi', $alat->kondisi) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                    <option value="rusak_berat" {{ old('kondisi', $alat->kondisi) == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat (Tidak Layak/Afkir)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">Status Ketersediaan</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="tersedia" {{ old('status', $alat->status) == 'tersedia' ? 'selected' : '' }}>Tersedia di Lab</option>
                                    <option value="dipinjam" {{ old('status', $alat->status) == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                                    <option value="maintenance" {{ old('status', $alat->status) == 'maintenance' ? 'selected' : '' }}>Dalam Maintenance / Kalibrasi</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="lokasi_penyimpanan" class="form-label fw-bold">Lokasi Penyimpanan Spesifik</label>
                                <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" class="form-control"
                                    value="{{ old('lokasi_penyimpanan', $alat->lokasi_penyimpanan) }}" placeholder="Contoh: Rak Komputer A, Meja 1">
                            </div>

                            <div class="col-md-12">
                                <label for="spesifikasi" class="form-label fw-bold">Spesifikasi Detail / Catatan Teknis</label>
                                <textarea name="spesifikasi" id="spesifikasi" rows="3" class="form-control">{{ old('spesifikasi', $alat->spesifikasi) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('alat.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection