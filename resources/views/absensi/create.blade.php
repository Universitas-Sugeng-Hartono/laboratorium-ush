@extends('layout.home')
@section('inti')
<style>
    .card-modern-form {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13.5px;
        padding: 9px 13px;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }
    .form-label {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-section-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding-bottom: 8px;
        border-bottom: 1.5px solid #f1f5f9;
        margin-bottom: 16px;
        margin-top: 8px;
    }
    .canvas-container {
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        background: #fafbfc;
        display: inline-block;
        padding: 6px;
    }
    canvas#signature-pad {
        background: #ffffff;
        border-radius: 8px;
        display: block;
        cursor: crosshair;
        touch-action: none;
    }
</style>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Catat Tamu Laboratorium</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('absensi.index') }}" class="text-muted">Buku Tamu</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Catat Tamu</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
                <div class="d-flex align-items-center mb-1">
                    <i class="fas fa-exclamation-circle me-2 font-16"></i>
                    <strong>Mohon periksa kembali isian formulir:</strong>
                </div>
                <ul class="mb-0 ps-3 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card-modern-form mb-4">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Formulir Kunjungan Tamu</h5>
                        <p class="text-muted small mb-0">Catat identitas, tujuan laboratorium, dan tanda tangan digital pengunjung.</p>
                    </div>
                </div>

                <div class="p-4">
                    <form action="{{ route('absensi.store') }}" method="POST" id="formCatatTamu">
                        @csrf

                        <!-- Bagian 1: Identitas Tamu -->
                        <div class="form-section-title">1. Identitas & Kontak Tamu</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-7">
                                <label for="tamu" class="form-label">Nama Lengkap Tamu <span class="text-danger">*</span></label>
                                <input type="text" name="tamu" id="tamu" class="form-control"
                                    placeholder="Contoh: Budi Santoso" value="{{ old('tamu') }}" required>
                            </div>

                            <div class="col-md-5">
                                <label for="kategori_tamu" class="form-label">Kategori Pengunjung <span class="text-danger">*</span></label>
                                <select name="kategori_tamu" id="kategori_tamu" class="form-select" required>
                                    <option value="Mahasiswa USH" {{ old('kategori_tamu') == 'Mahasiswa USH' ? 'selected' : '' }}>Mahasiswa USH</option>
                                    <option value="Dosen / Tendik USH" {{ old('kategori_tamu') == 'Dosen / Tendik USH' ? 'selected' : '' }}>Dosen / Tendik USH</option>
                                    <option value="Mahasiswa / Peneliti Eksternal" {{ old('kategori_tamu') == 'Mahasiswa / Peneliti Eksternal' ? 'selected' : '' }}>Mahasiswa / Peneliti Eksternal</option>
                                    <option value="Siswa / Sekolah" {{ old('kategori_tamu') == 'Siswa / Sekolah' ? 'selected' : '' }}>Siswa / Rombongan Sekolah</option>
                                    <option value="Tamu Industri / Umum" {{ old('kategori_tamu') == 'Tamu Industri / Umum' ? 'selected' : '' }}>Mitra Industri / Tamu Umum</option>
                                    <option value="Vendor / Teknisi" {{ old('kategori_tamu') == 'Vendor / Teknisi' ? 'selected' : '' }}>Vendor / Teknisi Alat</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="identitas" class="form-label">Nomor Identitas (NIM / NIDN / NIK)</label>
                                <input type="text" name="identitas" id="identitas" class="form-control"
                                    placeholder="Nomor kartu identitas" value="{{ old('identitas') }}">
                            </div>

                            <div class="col-md-4">
                                <label for="instansi" class="form-label">Asal Instansi / Fakultas / Lembaga</label>
                                <input type="text" name="instansi" id="instansi" class="form-control"
                                    placeholder="Contoh: USH / Univ. Lain / Umum" value="{{ old('instansi') }}">
                            </div>

                            <div class="col-md-4">
                                <label for="hp" class="form-label">Nomor WhatsApp / HP</label>
                                <input type="text" name="hp" id="hp" class="form-control"
                                    placeholder="08... atau 628..." inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="15"
                                    value="{{ old('hp') }}">
                            </div>
                        </div>

                        <!-- Bagian 2: Kunjungan & Keperluan -->
                        <div class="form-section-title">2. Ruang Laboratorium & Keperluan</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="lab_id" class="form-label">Laboratorium yang Dikunjungi <span class="text-danger">*</span></label>
                                <select name="lab_id" id="lab_id" class="form-select" required>
                                    <option value="">-- Pilih Laboratorium --</option>
                                    @foreach($labs as $l)
                                    <option value="{{ $l->id }}" {{ old('lab_id') == $l->id ? 'selected' : '' }}>
                                        {{ $l->laboratorium }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="jumlah_tamu" class="form-label">Jumlah Rombongan</label>
                                <div class="input-group">
                                    <input type="number" name="jumlah_tamu" id="jumlah_tamu" class="form-control"
                                        min="1" value="{{ old('jumlah_tamu', 1) }}">
                                    <span class="input-group-text bg-light text-muted font-13">Orang</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="tanggal" class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="jam" class="form-label">Waktu Masuk (Jam Datang) <span class="text-danger">*</span></label>
                                <input type="time" name="jam" id="jam" class="form-control"
                                    value="{{ old('jam', date('H:i')) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="jamselesai" class="form-label">Waktu Selesai <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="time" name="jamselesai" id="jamselesai" class="form-control"
                                    value="{{ old('jamselesai') }}">
                            </div>

                            <div class="col-md-6">
                                <label for="kategori_keperluan" class="form-label">Kategori Keperluan</label>
                                <select name="kategori_keperluan" id="kategori_keperluan" class="form-select">
                                    <option value="Praktikum Mandiri / Tugas Akhir" {{ old('kategori_keperluan') == 'Praktikum Mandiri / Tugas Akhir' ? 'selected' : '' }}>Praktikum Mandiri / Tugas Akhir</option>
                                    <option value="Penelitian Dosen / Riset" {{ old('kategori_keperluan') == 'Penelitian Dosen / Riset' ? 'selected' : '' }}>Penelitian Dosen / Riset</option>
                                    <option value="Kunjungan Studi / Observasi" {{ old('kategori_keperluan') == 'Kunjungan Studi / Observasi' ? 'selected' : '' }}>Kunjungan Studi / Observasi</option>
                                    <option value="Pemeliharaan / Servis Alat" {{ old('kategori_keperluan') == 'Pemeliharaan / Servis Alat' ? 'selected' : '' }}>Pemeliharaan / Servis Alat</option>
                                    <option value="Kegiatan Organisasi / UKM" {{ old('kategori_keperluan') == 'Kegiatan Organisasi / UKM' ? 'selected' : '' }}>Kegiatan Organisasi / UKM</option>
                                    <option value="Lainnya" {{ old('kategori_keperluan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="keperluan" class="form-label">Uraian / Deskripsi Keperluan</label>
                                <textarea name="keperluan" id="keperluan" class="form-control" rows="1"
                                    placeholder="Jelaskan maksud kunjungan...">{{ old('keperluan') }}</textarea>
                            </div>
                        </div>

                        <!-- Bagian 3: Tanda Tangan Digital -->
                        <div class="form-section-title">3. Tanda Tangan Digital Tamu <span class="text-danger">*</span></div>
                        <div class="mb-4">
                            <p class="text-muted small mb-2">Bubuhkan tanda tangan menggunakan mouse atau jari pada area kanvas di bawah ini.</p>
                            <div class="canvas-container">
                                <canvas id="signature-pad" width="460" height="170"></canvas>
                            </div>
                            <input type="hidden" name="ttd" id="signature-data">
                            <div class="mt-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="clear-signature" style="border-radius: 6px;">
                                    <i class="fas fa-undo me-1"></i> Bersihkan Tanda Tangan
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top" style="border-color: #f1f5f9;">
                            <a href="{{ route('absensi.index') }}" class="btn btn-light border px-4 py-2 font-13 fw-medium" style="border-radius: 8px;">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 py-2 font-13 fw-semibold shadow-sm" id="btnSubmit" style="border-radius: 8px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
                                Simpan Data Tamu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var canvas = document.getElementById("signature-pad");
    var ctx = canvas.getContext("2d");
    var drawing = false;
    var hasDrawn = false;

    ctx.strokeStyle = "#0f172a";
    ctx.lineWidth = 2.2;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";

    function getMousePos(canvasDom, mouseEvent) {
        var rect = canvasDom.getBoundingClientRect();
        return {
            x: (mouseEvent.clientX - rect.left) * (canvasDom.width / rect.width),
            y: (mouseEvent.clientY - rect.top) * (canvasDom.height / rect.height)
        };
    }

    function getTouchPos(canvasDom, touchEvent) {
        var rect = canvasDom.getBoundingClientRect();
        return {
            x: (touchEvent.touches[0].clientX - rect.left) * (canvasDom.width / rect.width),
            y: (touchEvent.touches[0].clientY - rect.top) * (canvasDom.height / rect.height)
        };
    }

    // Mouse Events
    canvas.addEventListener("mousedown", function(e) {
        drawing = true;
        hasDrawn = true;
        var pos = getMousePos(canvas, e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    });

    canvas.addEventListener("mousemove", function(e) {
        if (drawing) {
            var pos = getMousePos(canvas, e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
    });

    window.addEventListener("mouseup", function() {
        drawing = false;
    });

    // Touch Events
    canvas.addEventListener("touchstart", function(e) {
        e.preventDefault();
        drawing = true;
        hasDrawn = true;
        var pos = getTouchPos(canvas, e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
    }, { passive: false });

    canvas.addEventListener("touchmove", function(e) {
        e.preventDefault();
        if (drawing) {
            var pos = getTouchPos(canvas, e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
    }, { passive: false });

    canvas.addEventListener("touchend", function() {
        drawing = false;
    });

    // Clear Canvas
    document.getElementById("clear-signature").addEventListener("click", function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById("signature-data").value = "";
        hasDrawn = false;
    });

    // Form submit check
    document.getElementById("formCatatTamu").addEventListener("submit", function(e) {
        if (!hasDrawn) {
            e.preventDefault();
            alert("Mohon bubuhkan tanda tangan tamu terlebih dahulu sebelum menyimpan.");
            return false;
        }
        var signatureData = canvas.toDataURL("image/png");
        document.getElementById("signature-data").value = signatureData;
    });
});
</script>
@endsection