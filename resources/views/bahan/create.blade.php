@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bahan.index') }}" class="text-muted">Inventaris Bahan</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Tambah Baru</li>
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
                    <h4 class="card-title mb-1">Tambah Bahan Praktikum / Habis Pakai</h4>
                    <p class="text-muted small mb-4">Input data bahan consumables laboratorium, ambang batas stok minimum, dan lokasi penyimpanan.</p>

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

                    <form action="{{ route('bahan.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="lab_id" class="form-label fw-bold">Laboratorium <span class="text-danger">*</span></label>
                                <select name="lab_id" id="lab_id" class="form-control" required>
                                    <option value="">-- Pilih Laboratorium --</option>
                                    @foreach($laboratories as $lab)
                                    <option value="{{ $lab->id }}" {{ old('lab_id') == $lab->id ? 'selected' : '' }}>
                                        {{ $lab->laboratorium }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="kode" class="form-label fw-bold">Kode Bahan</label>
                                <input type="text" name="kode" id="kode" class="form-control"
                                    placeholder="Kosongkan untuk otomatis (BHN-xxx)" value="{{ old('kode') }}">
                                <small class="text-muted">Format rekomendasi: BHN-001 atau kode lab spesifik</small>
                            </div>

                            <div class="col-md-12">
                                <label for="bahan" class="form-label fw-bold">Nama Bahan <span class="text-danger">*</span></label>
                                <input type="text" name="bahan" id="bahan" class="form-control"
                                    placeholder="Contoh: Timah Solder, Resistor 10k, Kabel Jumper, Masker Medis"
                                    value="{{ old('bahan') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="jumlah" class="form-label fw-bold">Jumlah Stok Saat Ini <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control"
                                    placeholder="Contoh: 50" min="0" value="{{ old('jumlah', 1) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="satuan" class="form-label fw-bold">Satuan <span class="text-danger">*</span></label>
                                <input type="text" name="satuan" id="satuan" list="satuanList" class="form-control"
                                    placeholder="Pcs / Roll / Set / Box dll" value="{{ old('satuan', 'Pcs') }}" required>
                                <datalist id="satuanList">
                                    <option value="Pcs">
                                    <option value="Roll">
                                    <option value="Set">
                                    <option value="Unit">
                                    <option value="Box">
                                    <option value="Pack">
                                    <option value="Botol">
                                    <option value="Liter">
                                    <option value="Gram">
                                    <option value="Kg">
                                    <option value="Meter">
                                </datalist>
                            </div>
                            <div class="col-md-4">
                                <label for="stok_minimum" class="form-label fw-bold">Batas Stok Minimum</label>
                                <input type="number" name="stok_minimum" id="stok_minimum" class="form-control"
                                    placeholder="Contoh: 10" min="0" value="{{ old('stok_minimum', 0) }}">
                                <small class="text-muted">Peringatan status menipis jika &le; batas ini</small>
                            </div>
                            <div class="col-md-4">
                                <label for="tanggal_kedaluwarsa" class="form-label fw-bold">Tanggal Kedaluwarsa</label>
                                <input type="date" name="tanggal_kedaluwarsa" id="tanggal_kedaluwarsa" class="form-control" value="{{ old('tanggal_kedaluwarsa') }}">
                            </div>

                            <div class="col-md-12">
                                <label for="lokasi_penyimpanan" class="form-label fw-bold">Lokasi Penyimpanan Spesifik</label>
                                <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" class="form-control"
                                    placeholder="Contoh: Lemari A Rak 2, Kotak Komponen IoT B-03" value="{{ old('lokasi_penyimpanan') }}">
                            </div>

                            <div class="col-md-12">
                                <label for="spesifikasi" class="form-label fw-bold">Deskripsi / Spesifikasi Bahan</label>
                                <textarea name="spesifikasi" id="spesifikasi" rows="3" class="form-control"
                                    placeholder="Contoh: Ukuran diameter 0.8mm, timah alloy 60/40, merk Asahi">{{ old('spesifikasi') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('bahan.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Simpan Bahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection