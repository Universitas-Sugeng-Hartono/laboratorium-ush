<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Peminjaman</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <link href="{{asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.0.0/signature_pad.umd.min.js"></script>
    <style>
    canvas {
        border: 1px solid #000;
        touch-action: none;
        background-color: white;
    }

    select[multiple] {
        height: auto !important;
        min-height: 100px;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"> Formulir Peminjaman dan Pemakaian Laboratorium</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="/peminjaman/store" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Nama Peminjam/Pemakai</label>
                                <input type="text" class="form-control" name="nama"
                                    placeholder="Masukkan Nama Peminjam">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Nomor Peminjam/Pemakai</label>
                                <input type="number" class="form-control" name="nomor"
                                    placeholder="6282xxxxxxx">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="program_id" class="form-label">Program</label>
                                <select class="form-control" name="program_id">
                                    <option value="">Pilih Program Studi</option>
                                    @foreach($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->program }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="lab_id" class="form-label">Laboratorium</label>
                                <select class="form-control" name="lab_id" required>
                                    <option value="">Pilih Laboratorium</option>
                                    @foreach($laboratorium as $lab)
                                    <option value="{{ $lab->id }}">{{ $lab->laboratorium }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                                <select class="form-control select2" name="matakuliah_id">
                                    <option value="">Pilih Mata Kuliah</option>
                                    <option value="100">Tidak Berdasarkan Mata Kuliah</option>
                                    @foreach($matkul as $mata)
                                    <option value="{{ $mata->id }}">{{ $mata->matakuliah }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="bahan_id" class="form-label">Alat</label>
                            <input type="text" id="searchAlat" class="form-control" placeholder="Cari alat...">
                            <div class="space-y-4 mb-6" id="alatList">
                                @foreach($alats as $index => $alat)
                                    <div class="flex items-center space-x-4 alat-item">
                                        <input type="checkbox" name="alat_id[]" value="{{ $alat->id }}" id="alat_{{ $alat->id }}" class="mr-2">
                                        <label for="alat_{{ $alat->id }}" class="flex-grow">{{ $alat->alat }} (Stok: {{ $alat->jumlah }})</label>
                                        <input type="number" name="jumlah_alat[]" min="1" class="w-24 rounded-lg border-gray-300" placeholder="Jumlah">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="memerlukan_bahan" class="form-label" style="color: blue;">Memerlukan
                                    Bahan?</label>
                                <input type="checkbox" id="memerlukan_bahan" class="form-check-input">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" id="bahan_form" style="display: none;">
                            <div class="mb-3">
                                <label for="bahan_id" class="form-label">Bahan</label>
                                <input type="text" id="searchBahan" class="form-control" placeholder="Cari bahan...">
                                <div class="space-y-4 mb-6" id="bahanList">
                                    @foreach($bahans as $index => $bahan)
                                        <div class="flex items-center space-x-4 bahan-item">
                                            <input type="checkbox" name="bahan_id[]" value="{{ $bahan->id }}" id="bahan_{{ $bahan->id }}" class="mr-2">
                                            <label for="bahan_{{ $bahan->id }}" class="flex-grow">{{ $bahan->bahan }} (Stok: {{ $bahan->jumlah }})</label>
                                            <input type="number" name="jumlah_bahan[]" min="1" class="w-24 rounded-lg border-gray-300" placeholder="Jumlah">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Peminjaman/Pemakaian</label>
                                <input type="date" class="form-control" name="tgl_peminjaman" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Pengembalian</label>
                                <input type="date" class="form-control" name="tgl_pengembalian" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="materi" class="form-label">Keperluan</label>
                        <textarea class="form-control" name="keperluan"></textarea>
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

                    <div class="modal-footer">
                        <a href="#" class="btn btn-rounded btn-secondary btn-sm">Batal</a>
                        <button type="submit" class="btn btn-rounded btn-primary btn-sm">Submit Peminjaman</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Mata Kuliah",
                allowClear: true
            });
        });
    </script>
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

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        let alatSelect = document.querySelector("select[name='alat_id[]']");
        if (alatSelect) {
            alatSelect.addEventListener("click", function() {
                console.log("Dropdown diklik!");
            });
        }
    });
    </script>
    <script>
    document.getElementById('memerlukan_bahan').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('bahan_form').style.display = 'block';
            document.getElementById('jumlah_form').style.display = 'block';
        } else {
            document.getElementById('bahan_form').style.display = 'none';
            document.getElementById('jumlah_form').style.display = 'none';
        }
    });
</script>
<script>
    document.getElementById('searchAlat').addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        const items = document.querySelectorAll('#alatList .alat-item');

        items.forEach(item => {
            const label = item.querySelector('label').innerText.toLowerCase();
            if (label.includes(keyword)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
<script>
    document.getElementById('searchBahan').addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        const items = document.querySelectorAll('#bahanList .bahan-item');

        items.forEach(item => {
            const label = item.querySelector('label').innerText.toLowerCase();
            if (label.includes(keyword)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>

</body>

</html>