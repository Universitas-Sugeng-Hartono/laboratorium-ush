@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Edit Data Tamu</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('absensi.index') }}" class="text-muted">Buku Tamu</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="fas fa-user-edit text-warning fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Edit Data Tamu</h5>
                            <p class="text-muted small mb-0">Perbarui informasi kunjungan tamu laboratorium</p>
                        </div>
                    </div>

                    <form action="{{ route('absensi.update', $absen->id) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="tamu" class="form-label fw-bold small">Nama Tamu <span class="text-danger">*</span></label>
                                <input type="text" name="tamu" id="tamu" class="form-control"
                                    placeholder="Masukkan nama tamu" value="{{ old('tamu', $absen->tamu) }}" required>
                                @error('tamu')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal" class="form-label fw-bold small">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control"
                                    value="{{ old('tanggal', $absen->tanggal) }}" required>
                                @error('tanggal')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jam" class="form-label fw-bold small">Jam <span class="text-danger">*</span></label>
                                <input type="time" name="jam" id="jam" class="form-control"
                                    value="{{ old('jam', $absen->jam) }}" required>
                                @error('jam')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="keperluan" class="form-label fw-bold small">Keperluan</label>
                                <textarea name="keperluan" id="keperluan" class="form-control" rows="3"
                                    placeholder="Tuliskan keperluan kunjungan...">{{ old('keperluan', $absen->keperluan) }}</textarea>
                                @error('keperluan')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="signature" class="form-label fw-bold small">Tanda Tangan <span class="text-danger">*</span></label>
                                @if($absen->ttd)
                                <div class="mb-2">
                                    <p class="text-muted small mb-1">Tanda tangan saat ini:</p>
                                    <img src="{{ asset('storage/' . $absen->ttd) }}" alt="Tanda Tangan"
                                        class="border rounded bg-light p-1" style="max-width: 300px; max-height: 150px;">
                                </div>
                                @endif
                                <div class="border rounded p-2 bg-light">
                                    <canvas id="signature-pad" class="border bg-white rounded" width="400" height="200" style="cursor: crosshair;"></canvas>
                                </div>
                                <input type="hidden" name="ttd" id="signature-data" value="{{ $absen->ttd }}">
                                <div class="mt-2 d-flex gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="clear-signature">
                                        <i class="fas fa-eraser me-1"></i> Hapus Tanda Tangan
                                    </button>
                                    <small class="text-muted align-self-center">Gambar tanda tangan baru di atas untuk mengganti</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('absensi.index') }}" class="btn btn-outline-secondary btn-rounded px-4">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-rounded px-4">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
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

    ctx.strokeStyle = "black";
    ctx.lineWidth = 2;

    canvas.addEventListener("mousedown", function(e) {
        drawing = true;
        hasDrawn = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener("mousemove", function(e) {
        if (drawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    });

    canvas.addEventListener("mouseup", function() {
        drawing = false;
    });

    canvas.addEventListener("mouseleave", function() {
        drawing = false;
    });

    // Touch support
    canvas.addEventListener("touchstart", function(e) {
        e.preventDefault();
        var touch = e.touches[0];
        var rect = canvas.getBoundingClientRect();
        drawing = true;
        hasDrawn = true;
        ctx.beginPath();
        ctx.moveTo(touch.clientX - rect.left, touch.clientY - rect.top);
    });

    canvas.addEventListener("touchmove", function(e) {
        e.preventDefault();
        if (drawing) {
            var touch = e.touches[0];
            var rect = canvas.getBoundingClientRect();
            ctx.lineTo(touch.clientX - rect.left, touch.clientY - rect.top);
            ctx.stroke();
        }
    });

    canvas.addEventListener("touchend", function() {
        drawing = false;
    });

    document.getElementById("editForm").addEventListener("submit", function() {
        if (hasDrawn) {
            var signatureData = canvas.toDataURL("image/png");
            document.getElementById("signature-data").value = signatureData;
        }
    });

    document.getElementById("clear-signature").addEventListener("click", function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById("signature-data").value = "";
        hasDrawn = false;
    });
});
</script>
@endsection
