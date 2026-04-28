<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Jurnal</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <link href="{{asset('dist/css/style.min.css') }}" rel="stylesheet">
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
                <h4 class="mb-0">TAMU LABORATORIUM UNIVERSITAS SUGENG HARTONO</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="/tamu/store" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="materi" class="form-label">Tamu</label>
                        <input type="text" class="form-control" name="tamu" placeholder="Masukkan nama tamu">
                    </div>
                    <div class="mb-3">
                        <label for="hp" class="form-label">Nomor HP</label>
                        <input type="text" class="form-control" name="hp" placeholder="No HP">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_tamu" class="form-label">Jumlah Tamu</label>
                        <input type="text" class="form-control" name="jumlah_tamu" placeholder="Jumlah Tamu">
                    </div>
                    <div class="mb-3">
                        <label for="program_id" class="form-label">Laboratorium</label>
                        <select name="lab_id" class="form-control" required>
                            <option value="">Pilih Laboratorium</option>
                            @foreach($lab as $labs)
                            <option value="{{ $labs->id }}">{{ $labs->laboratorium }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Tanggal Berkunjung</label>
                        <input type="date" class="form-control" name="tanggal"
                            placeholder="Masukkan Tanggal Berkunjung">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jam Berkunjung</label>
                        <input type="time" class="form-control" name="jam" placeholder="Masukkan Jam Berkunjung">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control" name="jamselesai" placeholder="Masukkan Jam Selesai">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Keperluan</label>
                        <input type="text" class="form-control" name="keperluan"
                            placeholder="Masukkan Keperluan Berkunjung">
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
                        <button type="submit" class="btn btn-rounded btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card border-end">
                <div class="card-body">
                    <h3>Kalender Jadwal Praktikum - {{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $startDay = $startOfMonth->dayOfWeek;
                            $daysInMonth = $startOfMonth->daysInMonth;
                            $weeks = [];
                            $currentDay = 1;

                            for ($row = 0; $row < 6; $row++) { $week=[]; for ($col=0; $col < 7; $col++) { if (($row==0
                                && $col < $startDay) || $currentDay> $daysInMonth) {
                                $week[] = null;
                                } else {
                                $week[] = $currentDay++;
                                }
                                }
                                $weeks[] = $week;
                                }
                                @endphp
                                @php
                                use Carbon\Carbon;
                                @endphp
                                @foreach ($weeks as $week)
                                <tr>
                                    @foreach ($week as $day)
                                    <td>
                                        @if ($day)
                                        <div>{{ $day }}</div>
                                        @foreach ($jadwal as $event)
                                        @php
                                        $jadwalDate = Carbon::parse($event->jadwal)->format('Y-m-d');
                                        $currentDate = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
                                        @endphp
                                        @if ($jadwalDate == $currentDate)
                                        <small>{{ $event->matkulId->matakuliah }} -
                                            {{ $event->labId->laboratorium }}</small><br>
                                        @endif
                                        @endforeach

                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                        </tbody>

                    </table>
                </div>
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