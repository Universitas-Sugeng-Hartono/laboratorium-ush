<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Praktikum & E-Journal - SILABO USH</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Modern SweetAlert2 Toast for SILABO */
        .swal2-toast-silabo {
            border-radius: 14px !important;
            padding: 12px 18px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05) !important;
            border: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
        }
        .swal2-toast-silabo .swal2-title {
            font-size: 14px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin: 0 !important;
        }
        .swal2-toast-silabo .swal2-html-container {
            font-size: 12.5px !important;
            color: #64748b !important;
            margin-top: 3px !important;
        }
        * {
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #334155;
        }

        .portal-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .card-modern {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .page-header-box {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            border-radius: 16px;
            padding: 26px 30px;
            color: #ffffff;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.12);
        }

        .filter-toolbar {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .schedule-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .schedule-table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 18px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .schedule-table tbody td {
            padding: 16px 18px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 13.5px;
        }

        .schedule-table tbody tr:hover {
            background-color: #f8fafd;
        }

        .schedule-table tbody tr:last-child td {
            border-bottom: none;
        }

        .time-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #1e40af;
            border: 1px solid #bfdbfe;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .portal-footer {
            margin-top: auto;
            padding: 24px 0;
            text-align: center;
            color: #94a3b8;
            font-size: 12.5px;
            border-top: 1px solid #e2e8f0;
            background: #ffffff;
        }
    </style>
</head>

<body>
    <!-- Top Navigation Bar -->
    <header class="portal-navbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-nowrap">
                <a href="/" class="d-flex align-items-center gap-3 text-decoration-none flex-shrink-0">
                    <img src="{{ asset('img/ushh.png') }}" alt="Logo USH" style="height: 44px; width: 44px; object-fit: contain;" class="flex-shrink-0">
                    <div class="d-none d-sm-block text-start border-start ps-3 border-secondary">
                        <span class="d-block fw-bold text-dark font-14">SILABO USH</span>
                        <span class="d-block text-muted font-11">Jadwal Praktikum & E-Journal</span>
                    </div>
                </a>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a href="/" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold text-nowrap">
                        <i class="fa fa-arrow-left me-1"></i> Ke Portal Utama
                    </a>
                    @if(Auth::check())
                        <a href="/home" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold text-nowrap">
                            <i class="fa fa-gauge me-1"></i> Dashboard
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="container py-4">
        <!-- Page Header Banner -->
        <div class="page-header-box">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-primary rounded-pill px-3 py-1 font-11 fw-bold mb-2">
                        JADWAL LABORATORIUM HARIAN
                    </span>
                    <h2 class="fw-bold mb-1 text-white">Jadwal Praktikum - {{ ucfirst($hariIni) }}</h2>
                    <p class="mb-0 opacity-75 font-14">
                        {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM Y') }} - Silakan dosen atau asisten mengisi E-Journal perkuliahan setelah sesi selesai.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="/jadwallab" class="btn btn-light rounded-pill px-4 shadow-sm fw-semibold text-primary">
                        <i class="fa fa-calendar-day me-1"></i> Hari Ini
                    </a>
                </div>
            </div>
        </div>



        <!-- Filter Date Bar -->
        <div class="filter-toolbar">
            <form method="GET" action="/jadwallab" class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="tanggal" class="small fw-bold text-secondary text-uppercase mb-0">Pilih Tanggal:</label>
                </div>
                <div class="col-md-4 col-sm-6">
                    <input type="date" id="tanggal" name="tanggal" class="form-control rounded-3"
                        value="{{ request()->has('tanggal') ? request('tanggal') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fa fa-filter me-1"></i> Tampilkan Jadwal
                    </button>
                </div>
                <div class="col text-end text-muted small d-none d-md-block">
                    Total: <strong class="text-dark">{{ $jadwalHariIni->count() }}</strong> sesi praktikum
                </div>
            </form>
        </div>

        <!-- Schedule Table -->
        <div class="card-modern">
            @if($jadwalHariIni->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fa fa-calendar-xmark fs-1 mb-3 d-block opacity-50 text-secondary"></i>
                    <h5 class="fw-bold text-dark">Tidak Ada Jadwal Praktikum</h5>
                    @if(!empty($peringatanTa))
                    <p class="font-14 mb-0">{{ $peringatanTa }}</p>
                    @else
                    <p class="font-14 mb-0">Tidak ada jadwal praktikum yang terdaftar pada tanggal {{ \Carbon\Carbon::parse($tanggal)->isoFormat('D MMMM Y') }}.</p>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th width="210">Waktu Pelaksanaan</th>
                                <th>Mata Kuliah & Dosen</th>
                                <th>Laboratorium</th>
                                <th>Program Studi</th>
                                <th width="200" class="text-center">Status E-Journal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalHariIni as $jadwal)
                                @php
                                    $jamMulai = \Carbon\Carbon::parse($jadwal->jadwal)->format('H:i');
                                    $jamSelesai = $jadwal->jam_selesai_formatted;
                                    $hasJurnal = isset($jurnal[$jadwal->id]);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="time-pill">
                                            <i class="fa fa-clock"></i>
                                            <span>{{ $jamMulai }} &ndash; {{ $jamSelesai }} WIB</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark font-14 mb-1">
                                            {{ optional($jadwal->matkulId)->matakuliah ?? '-' }}
                                        </div>
                                        <div class="text-muted font-12 d-flex align-items-center gap-1">
                                            <i class="fa fa-chalkboard-user text-secondary"></i>
                                            <span>{{ optional($jadwal->matkulId)->dosen ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background:#f1f5f9; color:#334155; border:1px solid #e2e8f0; border-radius:8px; padding:6px 10px; font-weight:600;">
                                            <i class="fa fa-door-open me-1 text-primary"></i>
                                            {{ optional($jadwal->labId)->laboratorium ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background:#f5f3ff; color:#7c3aed; border:1px solid #ede9fe; border-radius:8px; padding:6px 10px; font-weight:600;">
                                            {{ optional($jadwal->programId)->program ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-2">
                                            @if($hasJurnal)
                                                <a href="/lihat-jurnal/{{ $jadwal->id }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 w-100 shadow-sm">
                                                    <i class="fa fa-circle-check me-1 text-success"></i> Lihat Jurnal
                                                </a>
                                            @else
                                                <a href="/create-jurnal/{{ $jadwal->id }}" class="btn btn-success btn-sm rounded-pill px-3 w-100 shadow-sm">
                                                    <i class="fa fa-pen-to-square me-1"></i> Isi E-Journal
                                                </a>
                                            @endif

                                            @if(Auth::check())
                                                <a href="{{ route('kirim.wa', $jadwal->id) }}" 
                                                   class="btn btn-outline-success btn-sm rounded-pill px-3 w-100 auto-click"
                                                   data-time="{{ \Carbon\Carbon::parse($jadwal->jadwal)->format('Y-m-d H:i') }}">
                                                   <i class="fa fa-brands fa-whatsapp me-1"></i> Ingatkan Dosen
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container">
            <p class="mb-0">
                &copy; {{ date('Y') }} <strong>Universitas Sugeng Hartono</strong>. Laboratorium Terpadu - All Rights Reserved.
            </p>
        </div>
    </footer>

    <!-- WhatsApp Auto Sender Script for Logged-In Officers -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const scheduledTimes = @json($scheduledTimes);
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
                scheduledTimes.forEach(time => {
                    if (!sentTimes.includes(time) && time === now) {
                        const button = document.querySelector(`.auto-click[data-time="${time}"]`);
                        if (button) {
                            button.click();
                            button.disabled = true;
                            button.textContent = "WA Terkirim";
                            sentTimes.push(time);
                            localStorage.setItem("waSent", JSON.stringify(sentTimes));
                        }
                    }
                });

                if (sentTimes.length >= scheduledTimes.length && scheduledTimes.length > 0) {
                    clearInterval(checkInterval);
                }
            }

            checkAndClickButton();
            const checkInterval = setInterval(checkAndClickButton, 60000);
        });
    </script>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success') || session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal2-toast-silabo'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                text: 'Data telah berhasil tercatat ke dalam sistem.'
            });
            @endif

            @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}'
            });
            @endif
        });
    </script>
    @endif
</body>

</html>