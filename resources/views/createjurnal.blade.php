<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi E-Journal - {{ $jadwal->matkulId->matakuliah ?? 'Laboratorium' }} - SILABO USH</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
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

        .page-header-box {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            border-radius: 16px;
            padding: 26px 30px;
            color: #ffffff;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.15);
        }

        .card-modern {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 24px;
            padding: 28px;
        }

        .info-pill {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-pill-label {
            font-size: 11.5px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-pill-value {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        .signature-container {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background-color: #ffffff;
            padding: 10px;
            position: relative;
            text-align: center;
        }

        canvas {
            display: block;
            width: 100%;
            height: 200px;
            margin: 0 auto;
            border-radius: 8px;
            background-color: #fcfcfd;
            border: 1px solid #e2e8f0;
            touch-action: none;
            cursor: crosshair;
        }

        .signature-guide {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            color: #cbd5e1;
            font-size: 12px;
            pointer-events: none;
            user-select: none;
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
                        <span class="d-block text-muted font-11">Pengisian E-Journal Praktikum</span>
                    </div>
                </a>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a href="/jadwallab" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold text-nowrap">
                        <i class="fa fa-arrow-left me-1"></i> Kembali ke Jadwal
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
                        FORMULIR E-JOURNAL LABORATORIUM
                    </span>
                    <h2 class="fw-bold mb-1 text-white">{{ $jadwal->matkulId->matakuliah ?? 'Mata Kuliah Praktikum' }}</h2>
                    <p class="mb-0 opacity-75 font-14">
                        Dosen Pengampu: <strong>{{ $jadwal->matkulId->dosen ?? 'Bapak/Ibu Dosen' }}</strong> • 
                        Laboratorium: <strong>{{ $jadwal->labId->laboratorium ?? '-' }}</strong>
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <span class="badge bg-white bg-opacity-25 text-white font-13 px-3 py-2 rounded-pill">
                        <i class="fa fa-calendar-day me-1"></i> {{ \Carbon\Carbon::parse($jadwal->jadwal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert" style="background:#ecfdf5; color:#065f46;">
                <i class="fa fa-circle-check fs-5 me-2 text-success"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger rounded-4 mb-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 1. Ringkasan Informasi Jadwal (Read-Only) -->
        <div class="card-modern mb-4">
            <div class="d-flex align-items-center mb-3">
                <i class="fa fa-circle-info text-primary me-2"></i>
                <h5 class="fw-bold text-dark mb-0">Informasi Jadwal Perkuliahan</h5>
            </div>
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <div class="info-pill">
                        <span class="info-pill-label"><i class="fa fa-flask me-1 text-primary"></i> Laboratorium</span>
                        <span class="info-pill-value">{{ $jadwal->labId->laboratorium ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-pill">
                        <span class="info-pill-label"><i class="fa fa-graduation-cap me-1 text-primary"></i> Program Studi</span>
                        <span class="info-pill-value">{{ optional($jadwal->programId)->program ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-pill">
                        <span class="info-pill-label"><i class="fa fa-calendar-day me-1 text-primary"></i> Tanggal</span>
                        <span class="info-pill-value">{{ \Carbon\Carbon::parse($jadwal->jadwal)->locale('id')->isoFormat('D MMMM Y') }}</span>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="info-pill">
                        <span class="info-pill-label"><i class="fa fa-clock me-1 text-primary"></i> Waktu Pelaksanaan</span>
                        <span class="info-pill-value">
                            {{ \Carbon\Carbon::parse($jadwal->jadwal)->format('H:i') }} - 
                            {{ $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : \Carbon\Carbon::parse($jadwal->jadwal)->addMinutes(170)->format('H:i') }} WIB
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Formulir Pengisian E-Journal -->
        <div class="card-modern">
            <div class="d-flex align-items-center mb-4">
                <i class="fa fa-pen-to-square text-success me-2"></i>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Pengisian Berita Acara Praktikum</h5>
                    <p class="text-muted small mb-0">Silakan lengkapi materi, jumlah kehadiran mahasiswa, dan bubuhkan tanda tangan digital.</p>
                </div>
            </div>

            <form action="/jurnal/store" method="POST" id="formJurnal">
                @csrf
                <!-- Hidden Fields yang Otomatis Terhubung ke Jadwal -->
                <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                <input type="hidden" name="lab_id" value="{{ $jadwal->lab_id }}">
                <input type="hidden" name="matakuliah_id" value="{{ $jadwal->matakuliah_id }}">
                <input type="hidden" name="program_id" value="{{ $jadwal->program_id }}">
                <input type="hidden" name="tanggal" value="{{ \Carbon\Carbon::parse($jadwal->jadwal)->format('Y-m-d') }}">
                <input type="hidden" name="jam_mulai" value="{{ \Carbon\Carbon::parse($jadwal->jadwal)->format('H:i') }}">

                <div class="row g-4">
                    <!-- Jam Selesai -->
                    <div class="col-md-6">
                        <label for="jam_selesai" class="form-label small fw-semibold text-secondary">
                            Jam Selesai Praktikum <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="fa fa-clock"></i></span>
                            <input type="time" class="form-control rounded-end-3" id="jam_selesai" name="jam_selesai"
                                value="{{ $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : \Carbon\Carbon::parse($jadwal->jadwal)->addMinutes(170)->format('H:i') }}" required>
                        </div>
                        <small class="text-muted font-11">Default otomatis terhitung sesuai durasi perkuliahan (dapat disesuaikan jika sesi selesai lebih awal/akhir).</small>
                    </div>

                    <!-- Jumlah Peserta / Mahasiswa Hadir -->
                    <div class="col-md-6">
                        <label for="jumlah" class="form-label small fw-semibold text-secondary">
                            Jumlah Mahasiswa Hadir <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary"><i class="fa fa-users"></i></span>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" min="1"
                                placeholder="Contoh: 28" required value="{{ old('jumlah') }}">
                            <span class="input-group-text bg-light text-secondary fw-medium">Mahasiswa</span>
                        </div>
                        <small class="text-muted font-11">Jumlah mahasiswa yang mengikuti praktikum di ruangan lab.</small>
                    </div>

                    <!-- Pokok Bahasan / Materi -->
                    <div class="col-12">
                        <label for="materi" class="form-label small fw-semibold text-secondary">
                            Materi & Pokok Bahasan Praktikum <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control rounded-3" id="materi" name="materi" rows="4"
                            placeholder="Tuliskan topik praktikum, modul yang dipelajari, alat yang digunakan, atau catatan kegiatan praktikum hari ini..." required>{{ old('materi') }}</textarea>
                    </div>

                    <!-- Tanda Tangan Digital Dosen -->
                    <div class="col-12">
                        <label class="form-label small fw-semibold text-secondary d-flex justify-content-between align-items-center">
                            <span>Tanda Tangan Digital Dosen / Asisten Pengampu <span class="text-danger">*</span></span>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" id="clear-signature">
                                <i class="fa fa-eraser me-1"></i> Hapus Tanda Tangan
                            </button>
                        </label>

                        <div class="signature-container">
                            <canvas id="signature-pad"></canvas>
                            <span class="signature-guide">Goreskan tanda tangan Anda di area ini</span>
                        </div>
                        <input type="hidden" name="ttd" id="signature-data" required>
                        <small class="text-muted font-11 mt-1 d-block">
                            <i class="fa fa-circle-info me-1"></i> Tanda tangan ini berlaku resmi sebagai presensi kehadiran dosen dan berita acara pemakaian laboratorium.
                        </small>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="col-12 mt-4 pt-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <a href="/jadwallab" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                            <i class="fa fa-arrow-left me-1"></i> Batalkan
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold shadow-sm">
                            <i class="fa fa-floppy-disk me-1"></i> Simpan E-Journal
                        </button>
                    </div>
                </div>
            </form>
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

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var canvas = document.getElementById("signature-pad");
            var ctx = canvas.getContext("2d");
            var drawing = false;
            var hasSigned = false;

            // Responsive internal canvas coordinate resolution
            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                var rect = canvas.getBoundingClientRect();
                canvas.width = rect.width * ratio;
                canvas.height = rect.height * ratio;
                ctx.scale(ratio, ratio);
                ctx.strokeStyle = "#0f172a";
                ctx.lineWidth = 2.5;
                ctx.lineCap = "round";
                ctx.lineJoin = "round";
            }
            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            function getPos(e) {
                var rect = canvas.getBoundingClientRect();
                if (e.touches && e.touches.length > 0) {
                    return {
                        x: e.touches[0].clientX - rect.left,
                        y: e.touches[0].clientY - rect.top
                    };
                } else {
                    return {
                        x: e.clientX - rect.left,
                        y: e.clientY - rect.top
                    };
                }
            }

            function startDrawing(e) {
                e.preventDefault();
                drawing = true;
                hasSigned = true;
                var pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            }

            function draw(e) {
                if (!drawing) return;
                e.preventDefault();
                var pos = getPos(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }

            function stopDrawing(e) {
                if (drawing) {
                    drawing = false;
                }
            }

            // Mouse events
            canvas.addEventListener("mousedown", startDrawing);
            canvas.addEventListener("mousemove", draw);
            window.addEventListener("mouseup", stopDrawing);

            // Touch events
            canvas.addEventListener("touchstart", startDrawing, { passive: false });
            canvas.addEventListener("touchmove", draw, { passive: false });
            canvas.addEventListener("touchend", stopDrawing);

            // Submit handler
            document.getElementById("formJurnal").addEventListener("submit", function (e) {
                if (!hasSigned) {
                    alert("Mohon bubuhkan tanda tangan digital Anda terlebih dahulu pada kolom yang disediakan.");
                    e.preventDefault();
                    return false;
                }
                var signatureData = canvas.toDataURL("image/png");
                document.getElementById("signature-data").value = signatureData;
            });

            // Clear handler
            document.getElementById("clear-signature").addEventListener("click", function () {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById("signature-data").value = "";
                hasSigned = false;
            });
        });
    </script>
</body>

</html>