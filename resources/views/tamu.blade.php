<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu & Presensi Kunjungan - SILABO USH</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Custom Modern SweetAlert2 for Guest Check-in */
        .swal2-popup.swal2-tamu-popup {
            border-radius: 20px !important;
            padding: 26px 22px !important;
            font-family: 'Inter', sans-serif !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            border: 1px solid #e2e8f0 !important;
            max-width: 520px !important;
            width: 92% !important;
        }
        .swal2-tamu-popup .swal2-icon.swal2-success {
            border-color: #10b981 !important;
            color: #10b981 !important;
            margin: 10px auto 14px auto !important;
            transform: scale(0.9);
        }
        .swal2-tamu-popup .swal2-success-ring {
            border-color: rgba(16, 185, 129, 0.3) !important;
        }
        .swal2-tamu-popup .swal2-success [class^='swal2-success-line'] {
            background-color: #10b981 !important;
        }
        .swal2-tamu-popup .swal2-title {
            font-size: 20px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-bottom: 4px !important;
        }
        .tamu-confirm-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 16px;
            margin-top: 14px;
            text-align: left;
            font-size: 13px;
        }
        .tamu-confirm-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .tamu-confirm-row:last-child {
            border-bottom: none;
        }
        .tamu-confirm-label {
            color: #64748b;
            font-weight: 500;
        }
        .tamu-confirm-value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
            max-width: 60%;
        }
        .tamu-k3-notice {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 10px;
            padding: 10px 12px;
            margin-top: 14px;
            font-size: 12px;
            color: #065f46;
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
        }
        .swal2-tamu-btn {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 13.5px !important;
            padding: 10px 24px !important;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;
            color: #ffffff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
            cursor: pointer;
        }
        .swal2-timer-progress-bar {
            background: #10b981 !important;
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
            padding: 30px;
        }

        .page-header-box {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border-radius: 16px;
            padding: 26px 30px;
            color: #ffffff;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15);
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
            max-width: 500px;
            height: 200px;
            margin: 0 auto;
            border-radius: 8px;
            background-color: #fcfcfd;
            border: 1px solid #e2e8f0;
            touch-action: none;
            cursor: crosshair;
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
                        <span class="d-block text-muted font-11">Buku Tamu Laboratorium</span>
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
                    <span class="badge bg-white text-success rounded-pill px-3 py-1 font-11 fw-bold mb-2">
                        PRESENSI KUNJUNGAN LAB
                    </span>
                    <h2 class="fw-bold mb-1 text-white">Buku Tamu Laboratorium</h2>
                    <p class="mb-0 opacity-75 font-14">
                        Universitas Sugeng Hartono - Silakan mengisi data kunjungan dan tanda tangan digital untuk keperluan administrasi laboratorium.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <span class="badge bg-white bg-opacity-25 text-white font-13 px-3 py-2 rounded-pill">
                        <i class="fa fa-calendar-day me-1"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>
        </div>

        @if(session('success') && !session('tamu_success'))
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

        <!-- Form Card -->
        <div class="card-modern">
            <form action="/tamu/store" method="POST" id="formTamu">
                        @csrf
                        <div class="row g-3">
                            <!-- Kategori Pengunjung -->
                            <div class="col-md-4">
                                <label for="kategori_tamu" class="form-label small fw-semibold text-secondary">Kategori Pengunjung <span class="text-danger">*</span></label>
                                <select name="kategori_tamu" id="kategori_tamu" class="form-select rounded-3" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Mahasiswa USH" {{ old('kategori_tamu') == 'Mahasiswa USH' ? 'selected' : '' }}>Mahasiswa USH</option>
                                    <option value="Dosen / Tendik USH" {{ old('kategori_tamu') == 'Dosen / Tendik USH' ? 'selected' : '' }}>Dosen / Tendik USH</option>
                                    <option value="Mahasiswa / Peneliti Eksternal" {{ old('kategori_tamu') == 'Mahasiswa / Peneliti Eksternal' ? 'selected' : '' }}>Mahasiswa / Peneliti Eksternal</option>
                                    <option value="Siswa / Sekolah" {{ old('kategori_tamu') == 'Siswa / Sekolah' ? 'selected' : '' }}>Siswa / Rombongan Sekolah</option>
                                    <option value="Tamu Industri / Umum" {{ old('kategori_tamu') == 'Tamu Industri / Umum' ? 'selected' : '' }}>Mitra Industri / Tamu Umum</option>
                                    <option value="Vendor / Teknisi" {{ old('kategori_tamu') == 'Vendor / Teknisi' ? 'selected' : '' }}>Vendor / Teknisi Alat</option>
                                </select>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="col-md-4">
                                <label for="tamu" class="form-label small fw-semibold text-secondary">Nama Lengkap Tamu <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-3" name="tamu" id="tamu" placeholder="Contoh: Muhammad Ihsan, S.Kom." required value="{{ old('tamu') }}">
                            </div>

                            <!-- Nomor Identitas -->
                            <div class="col-md-4">
                                <label for="identitas" class="form-label small fw-semibold text-secondary">Nomor Identitas (NIM / NIDN / NIK)</label>
                                <input type="text" class="form-control rounded-3" name="identitas" id="identitas" placeholder="Contoh: 230101001 atau NIK" value="{{ old('identitas') }}">
                            </div>

                            <!-- Asal Instansi / Prodi -->
                            <div class="col-md-4">
                                <label for="instansi" class="form-label small fw-semibold text-secondary">Asal Instansi / Fakultas / Prodi / Sekolah</label>
                                <input type="text" class="form-control rounded-3" name="instansi" id="instansi" placeholder="Contoh: S1 Teknologi Informasi / SMA N 1" value="{{ old('instansi') }}">
                            </div>

                            <!-- Nomor HP / WhatsApp -->
                            <div class="col-md-4">
                                <label for="hp" class="form-label small fw-semibold text-secondary">Nomor Handphone / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-3" name="hp" id="hp" placeholder="08... atau 628..." inputmode="numeric" maxlength="15" required value="{{ old('hp') }}">
                            </div>

                            <!-- Jumlah Tamu -->
                            <div class="col-md-4">
                                <label for="jumlah_tamu" class="form-label small fw-semibold text-secondary">Jumlah Tamu / Rombongan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" min="1" class="form-control rounded-start-3" name="jumlah_tamu" id="jumlah_tamu" placeholder="1" required value="{{ old('jumlah_tamu', 1) }}">
                                    <span class="input-group-text bg-light text-secondary rounded-end-3 fw-medium">Orang</span>
                                </div>
                            </div>

                            <!-- Laboratorium Tujuan -->
                            <div class="col-md-6">
                                <label for="lab_id" class="form-label small fw-semibold text-secondary">Laboratorium Tujuan <span class="text-danger">*</span></label>
                                <select name="lab_id" id="lab_id" class="form-select rounded-3" required>
                                    <option value="">-- Pilih Ruang Laboratorium --</option>
                                    @foreach($lab as $labs)
                                        <option value="{{ $labs->id }}" {{ old('lab_id') == $labs->id ? 'selected' : '' }}>
                                            {{ $labs->laboratorium }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kategori Keperluan -->
                            <div class="col-md-6">
                                <label for="kategori_keperluan" class="form-label small fw-semibold text-secondary">Kategori Keperluan <span class="text-danger">*</span></label>
                                <select name="kategori_keperluan" id="kategori_keperluan" class="form-select rounded-3" required>
                                    <option value="">-- Pilih Kategori Keperluan --</option>
                                    <option value="Praktikum Mandiri / Tugas Akhir" {{ old('kategori_keperluan') == 'Praktikum Mandiri / Tugas Akhir' ? 'selected' : '' }}>Praktikum Mandiri / Skripsi / Tugas Akhir</option>
                                    <option value="Penelitian / Uji Sampel" {{ old('kategori_keperluan') == 'Penelitian / Uji Sampel' ? 'selected' : '' }}>Penelitian / Uji Sampel Lab</option>
                                    <option value="Kunjungan Edukasi / Studi Banding" {{ old('kategori_keperluan') == 'Kunjungan Edukasi / Studi Banding' ? 'selected' : '' }}>Kunjungan Edukasi / Studi Banding</option>
                                    <option value="Servis / Maintenance Alat" {{ old('kategori_keperluan') == 'Servis / Maintenance Alat' ? 'selected' : '' }}>Servis, Perawatan, atau Kalibrasi Alat</option>
                                    <option value="Rapat / Diskusi / Konsultasi" {{ old('kategori_keperluan') == 'Rapat / Diskusi / Konsultasi' ? 'selected' : '' }}>Rapat, Diskusi, atau Konsultasi Lab</option>
                                    <option value="Keperluan Lainnya" {{ old('kategori_keperluan') == 'Keperluan Lainnya' ? 'selected' : '' }}>Keperluan Administrasi / Lainnya</option>
                                </select>
                            </div>

                            <!-- Detail Rincian Keperluan -->
                            <div class="col-12">
                                <label for="keperluan" class="form-label small fw-semibold text-secondary">Rincian Keperluan / Aktivitas Kunjungan <span class="text-danger">*</span></label>
                                <textarea class="form-control rounded-3" name="keperluan" id="keperluan" rows="2" placeholder="Jelaskan secara ringkas aktivitas praktikum, pengujian, atau agenda kunjungan Anda..." required>{{ old('keperluan') }}</textarea>
                            </div>

                            <!-- Waktu Kunjungan -->
                            <div class="col-md-4">
                                <label for="tanggal" class="form-label small fw-semibold text-secondary">Tanggal Berkunjung <span class="text-danger">*</span></label>
                                <input type="date" class="form-control rounded-3" name="tanggal" id="tanggal" required value="{{ old('tanggal', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="jam" class="form-label small fw-semibold text-secondary">Jam Masuk / Mulai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control rounded-3" name="jam" id="jam" required value="{{ old('jam', \Carbon\Carbon::now()->format('H:i')) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="jamselesai" class="form-label small fw-semibold text-secondary">Estimasi Jam Selesai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control rounded-3" name="jamselesai" id="jamselesai" required value="{{ old('jamselesai', \Carbon\Carbon::now()->addHours(2)->format('H:i')) }}">
                            </div>

                            <!-- K3 Agreement Box -->
                            <div class="col-12 mt-3">
                                <div class="p-3 rounded-3 border" style="background-color: #f0fdf4; border-color: #bbf7d0 !important;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="setuju_k3" id="setuju_k3" value="1" required {{ old('setuju_k3') ? 'checked' : '' }}>
                                        <label class="form-check-label font-13 text-dark fw-semibold" for="setuju_k3">
                                            Pernyataan Kepatuhan Tata Tertib & Keselamatan Kerja (K3) Laboratorium
                                        </label>
                                        <p class="font-11 text-muted mb-0 mt-1">
                                            Saya menyatakan data di atas benar serta bersedia mematuhi seluruh Standar Operasional Prosedur (SOP), penggunaan APD (Jas Lab, Sepatu Tertutup), tidak makan/minum, dan menjaga kebersihan serta keutuhan alat laboratorium Universitas Sugeng Hartono.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tanda Tangan Digital -->
                            <div class="col-12 mt-4">
                                <label class="form-label small fw-semibold text-secondary d-flex justify-content-between align-items-center">
                                    <span>Tanda Tangan Digital Tamu <span class="text-danger">*</span></span>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 font-11" id="clear-signature">
                                        <i class="fa fa-eraser me-1"></i> Hapus Tanda Tangan
                                    </button>
                                </label>
                                <div class="signature-container">
                                    <canvas id="signature-pad" width="500" height="200"></canvas>
                                    <small class="text-muted d-block mt-2 font-11">
                                        Gunakan jari (pada layar sentuh HP/Tablet) atau kursor mouse untuk menandatangani di area di atas.
                                    </small>
                                </div>
                                <input type="hidden" name="ttd" id="signature-data" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="/" class="btn btn-light rounded-pill px-4">Batal</a>
                            <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm fw-semibold">
                                <i class="fa fa-check me-1"></i> Simpan Presensi Tamu
                            </button>
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
            document.getElementById("formTamu").addEventListener("submit", function(e) {
                if (!hasSigned) {
                    alert("Mohon bubuhkan tanda tangan digital Anda terlebih dahulu pada kolom yang disediakan.");
                    e.preventDefault();
                    return false;
                }
                var signatureData = canvas.toDataURL("image/png");
                document.getElementById("signature-data").value = signatureData;
            });

            // Clear handler
            document.getElementById("clear-signature").addEventListener("click", function() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById("signature-data").value = "";
                hasSigned = false;
            });
        });
    </script>

    <!-- SweetAlert2 Library & Guest Check-in Success Modal -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('tamu_success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let timerInterval;
            Swal.fire({
                title: 'Presensi Berhasil Dicatat!',
                customClass: {
                    popup: 'swal2-tamu-popup',
                    confirmButton: 'swal2-tamu-btn'
                },
                icon: 'success',
                html: `
                    <div style="font-size: 13.5px; color: #64748b; margin-bottom: 6px;">
                        Selamat datang di Laboratorium Universitas Sugeng Hartono.
                    </div>
                    <div class="tamu-confirm-card">
                        <div class="tamu-confirm-row">
                            <span class="tamu-confirm-label">Nama Tamu</span>
                            <span class="tamu-confirm-value">{{ session('tamu_success')['nama'] }}</span>
                        </div>
                        <div class="tamu-confirm-row">
                            <span class="tamu-confirm-label">Kategori</span>
                            <span class="tamu-confirm-value text-success">{{ session('tamu_success')['kategori'] }}</span>
                        </div>
                        @if(session('tamu_success')['instansi'] !== '-')
                        <div class="tamu-confirm-row">
                            <span class="tamu-confirm-label">Instansi / Prodi</span>
                            <span class="tamu-confirm-value">{{ session('tamu_success')['instansi'] }}</span>
                        </div>
                        @endif
                        <div class="tamu-confirm-row">
                            <span class="tamu-confirm-label">Lab Tujuan</span>
                            <span class="tamu-confirm-value text-primary">{{ session('tamu_success')['lab'] }}</span>
                        </div>
                        <div class="tamu-confirm-row">
                            <span class="tamu-confirm-label">Waktu Presensi</span>
                            <span class="tamu-confirm-value">{{ session('tamu_success')['tanggal'] }} ({{ session('tamu_success')['jam'] }})</span>
                        </div>
                        <div class="tamu-confirm-row">
                            <span class="tamu-confirm-label">Rombongan</span>
                            <span class="tamu-confirm-value">{{ session('tamu_success')['jumlah'] }}</span>
                        </div>
                        <div class="tamu-confirm-row">
                            <span class="tamu-confirm-label">Keperluan</span>
                            <span class="tamu-confirm-value">{{ session('tamu_success')['keperluan'] }}</span>
                        </div>
                    </div>
                    <div class="tamu-k3-notice">
                        <i class="fa fa-shield-halved text-success fs-5"></i>
                        <span>Mohon selalu mematuhi tata tertib keselamatan kerja (K3) selama berada di dalam laboratorium.</span>
                    </div>
                    <div class="mt-3 text-muted small" style="font-size: 12px;">
                        Modal akan tertutup otomatis dalam <b id="countdownSec" class="text-success fw-bold">8</b> detik.
                    </div>
                `,
                timer: 8000,
                timerProgressBar: true,
                confirmButtonText: '<i class="fa fa-check me-1"></i> Selesai / Tamu Baru',
                didOpen: () => {
                    const timerElem = document.getElementById('countdownSec');
                    if (timerElem) {
                        timerInterval = setInterval(() => {
                            const remaining = Math.ceil(Swal.getTimerLeft() / 1000);
                            if (timerElem) {
                                timerElem.textContent = remaining > 0 ? remaining : 0;
                            }
                        }, 500);
                    }
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            });
        });
    </script>
    @endif
</body>

</html>