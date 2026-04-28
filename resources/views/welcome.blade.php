<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <title>SILABO USH</title>

    <style>
        body {
            margin: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            padding: 30px 15px; /* agar ada ruang */
            min-height: 100vh; /* bukan height penuh */
            overflow-y: auto; /* bisa scroll */
        }
    
        .container {
            width: 100%;
            max-width: 900px;
            animation: fadeIn 1s ease forwards;
        }
    
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0;
            background: white;
            width: 100%;
        }
    
        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
    
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Jadwal Laboratorium - {{ ucfirst($hariIni) }}</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="/jadwallab" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', request()->has('tanggal') ? request('tanggal') : \Carbon\Carbon::now()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-rounded btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                @if($jadwalHariIni->isEmpty())
                <p class="text-center">Tidak ada jadwal laboratorium untuk hari ini.</p>
                @else
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Laboratorium</th>
                            <th>Mata Kuliah</th>
                            <th>Program</th>
                            <th>Dosen</th>
                            <th>Jurnal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwalHariIni as $jadwal)
                        <tr>
                            <td class="jadwal-waktu"
                                data-hari="{{ \Carbon\Carbon::parse($jadwal->jadwal)->isoFormat('dddd') }}"
                                data-waktu="{{ \Carbon\Carbon::parse($jadwal->jadwal)->format('H:i') }}">
                                {{ \Carbon\Carbon::parse($jadwal->jadwal)->isoFormat('dddd') }} -
                                {{ \Carbon\Carbon::parse($jadwal->jadwal)->format('H:i') }}
                            </td>
                            <td>{{ $jadwal->labId->laboratorium ?? '-' }}</td>
                            <td>{{ $jadwal->matkulId->matakuliah ?? '-' }}</td>
                            <td>{{ $jadwal->programId->program ?? '-' }}</td>
                            <td>{{ $jadwal->matkulId->dosen ?? '-' }}</td>
                            <td>
                                @if(isset($jurnal[$jadwal->id])) 
                                    <a href="/lihat-jurnal/{{ $jadwal->id }}" class="btn btn-rounded btn-primary btn-sm">Lihat Jurnal</a>
                                @else
                                    <a href="/create-jurnal/{{ $jadwal->id }}" class="btn btn-rounded btn-success btn-sm">Create Jurnal</a>
                                @endif
                                @if(Auth::check())
                                    <a href="{{ route('kirim.wa', $jadwal->id) }}" 
                                       class="btn btn-success btn-sm auto-click"
                                       data-time="{{ \Carbon\Carbon::parse($jadwal->jadwal)->format('Y-m-d H:i') }}">
                                       Kirim WA {{ \Carbon\Carbon::parse($jadwal->jadwal)->format('H:i') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".container").style.display = "block";
        });
    </script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Ambil jadwal dari server (format: "YYYY-MM-DD HH:mm")
        const scheduledTimes = @json($scheduledTimes);

        // Ambil dari localStorage untuk mencegah klik ulang
        let sentTimes = JSON.parse(localStorage.getItem("waSent")) || [];

        function getCurrentDateTime() {
            const now = new Date();
            const year = now.getFullYear();
            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const day = now.getDate().toString().padStart(2, '0');
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            return `${year}-${month}-${day} ${hours}:${minutes}`;
        }

        function checkAndClickButton() {
            const now = getCurrentDateTime();
            console.log("⏰ Waktu sekarang:", now);

            scheduledTimes.forEach(time => {
                if (!sentTimes.includes(time) && time === now) {
                    const button = document.querySelector(`.auto-click[data-time="${time}"]`);

                    if (button) {
                        button.click(); // Klik tombol
                        button.disabled = true; // Disable tombol biar tidak bisa diklik lagi
                        button.textContent = "WA Terkirim"; // Opsional: Ubah teks
                        sentTimes.push(time);
                        localStorage.setItem("waSent", JSON.stringify(sentTimes));

                        console.log("✅ Tombol auto-kirim berhasil untuk:", time);
                    } else {
                        console.log("❌ Tidak menemukan tombol untuk:", time);
                    }
                }
            });

            // Jika semua sudah dikirim, hentikan interval
            if (sentTimes.length >= scheduledTimes.length) {
                clearInterval(checkInterval);
                console.log("🎉 Semua WA sudah dikirim.");
            }
        }

        // Cek saat halaman dimuat
        checkAndClickButton();

        // Cek ulang setiap menit
        const checkInterval = setInterval(checkAndClickButton, 60000);
    });
</script>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>

</body>

</html>