<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Jurnal</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <link href="{{asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.0.0/signature_pad.umd.min.js"></script>
    <style>
    canvas {
        border: 1px solid #000;
        touch-action: none;
        background-color: white;
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Buat Jurnal untuk {{ $jadwal->matkulId->matakuliah }} - {{ $jadwal->jadwal }}</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="/jurnal/store" method="POST">
                    @csrf
                    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">

                    <div class="mb-3">
                        <label for="lab_id" class="form-label">Laboratorium</label>
                        <select class="form-control" name="lab_id" required>
                            <option value="{{ $jadwal->lab_id }}">{{ $jadwal->labId->laboratorium }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                        <select class="form-control" name="matakuliah_id" required>
                            <option value="{{ $jadwal->matakuliah_id }}">{{ $jadwal->matkulId->matakuliah }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="program_id" class="form-label">Program</label>
                        <select class="form-control" name="program_id" required>
                            <option value="{{ $jadwal->program_id }}">{{ $jadwal->programId->program }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal"
                            value="{{ \Carbon\Carbon::parse($jadwal->jadwal)->format('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" name="jam_mulai"
                            value="{{ \Carbon\Carbon::parse($jadwal->jadwal)->format('H:i') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="materi" class="form-label">Materi</label>
                        <textarea class="form-control" name="materi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Peserta</label>
                        <input type="number" class="form-control" name="jumlah" min="1"
                            placeholder="Masukkan jumlah peserta" required>
                    </div>
                    <div class="mb-3">
                        <label for="signature" class="form-label">Tanda Tangan</label>
                        <div class="border p-2">
                            <canvas id="signature-pad" class="border bg-light" width="400" height="200"></canvas>
                        </div>
                        <input type="hidden" name="ttd" id="signature-data" required>
                        <button type="button" class="btn btn-rounded btn-secondary mt-2" id="clear-signature">Hapus
                            Tanda
                            Tangan</button>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-rounded btn-secondary btn-sm">Batal</a>
                        <button type="submit" class="btn btn-rounded btn-primary btn-sm">Simpan Jurnal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{asset('dist/js/feather.min.js') }}"></script>
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{asset('dist/js/custom.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var canvas = document.getElementById("signature-pad");
            var ctx = canvas.getContext("2d");
            var drawing = false;
        
            // Atur warna dan ketebalan garis tanda tangan
            ctx.strokeStyle = "black";
            ctx.lineWidth = 2;
        
            // Mendapatkan posisi kursor atau sentuhan
            function getPos(e) {
                var rect = canvas.getBoundingClientRect();
                if (e.touches) {
                    return {
                        x: e.touches[0].clientX - rect.left,
                        y: e.touches[0].clientY - rect.top
                    };
                } else {
                    return {
                        x: e.offsetX,
                        y: e.offsetY
                    };
                }
            }
        
            // Fungsi untuk mulai menggambar
            function startDrawing(e) {
                e.preventDefault();
                drawing = true;
                var pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            }
        
            // Fungsi menggambar garis
            function draw(e) {
                if (!drawing) return;
                e.preventDefault();
                var pos = getPos(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }
        
            // Fungsi untuk berhenti menggambar
            function stopDrawing(e) {
                drawing = false;
            }
        
            // Event listener untuk mouse
            canvas.addEventListener("mousedown", startDrawing);
            canvas.addEventListener("mousemove", draw);
            canvas.addEventListener("mouseup", stopDrawing);
            canvas.addEventListener("mouseleave", stopDrawing);
        
            // Event listener untuk layar sentuh
            canvas.addEventListener("touchstart", startDrawing);
            canvas.addEventListener("touchmove", draw);
            canvas.addEventListener("touchend", stopDrawing);
        
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
</body>

</html>