@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Tamu</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4>Create Data Tamu</h4>
                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Tamu</label>
                            <input type="text" name="tamu" id="tamu" class="form-control mb-3" placeholder="Nama Tamu"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="name">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control mb-3"
                                placeholder="Tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Jam</label>
                            <input type="time" name="jam" id="jam" class="form-control mb-3" placeholder="Jam" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Keperluan</label>
                            <textarea name="keperluan" id="keperluan" class="form-control mb-3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="signature" class="form-label">Tanda Tangan</label>
                            <div class="border p-2">
                                <canvas id="signature-pad" class="border bg-light" width="400" height="200"></canvas>
                            </div>
                            <input type="hidden" name="ttd" id="signature-data">
                            <button type="button" class="btn btn-rounded btn-secondary mt-2" id="clear-signature">Hapus
                                Tanda
                                Tangan</button>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-primary mb-3">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var canvas = document.getElementById("signature-pad");
    var ctx = canvas.getContext("2d");
    var drawing = false;

    // Atur warna dan ketebalan garis tanda tangan
    ctx.strokeStyle = "black";
    ctx.lineWidth = 2;

    // Fungsi untuk mulai menggambar
    canvas.addEventListener("mousedown", function(e) {
        drawing = true;
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

    // Fungsi untuk menyimpan tanda tangan ke input hidden
    document.querySelector("form").addEventListener("submit", function() {
        var signatureData = canvas.toDataURL("image/png");
        document.getElementById("signature-data").value = signatureData;
    });

    // Fungsi untuk menghapus tanda tangan
    document.getElementById("clear-signature").addEventListener("click", function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        document.getElementById("signature-data").value = "";
    });
});
</script>
@endsection