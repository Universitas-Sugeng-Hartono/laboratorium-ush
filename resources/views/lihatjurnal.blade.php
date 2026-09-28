<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail E-Journal - {{ $jadwal->matkulId->matakuliah ?? 'Laboratorium' }} - SILABO USH</title>
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
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border-radius: 16px;
            padding: 26px 30px;
            color: #ffffff;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.15);
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

        .materi-box {
            background: #f8fafc;
            border-left: 4px solid #10b981;
            border-radius: 0 12px 12px 0;
            padding: 18px 20px;
            font-size: 14.5px;
            line-height: 1.6;
            color: #1e293b;
            white-space: pre-line;
        }

        .signature-preview-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            padding: 16px;
            display: inline-block;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
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

        .app-modal .modal-dialog { max-width: 520px; }
        .app-modal .modal-content {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.16);
        }
        .app-modal .modal-header { align-items: flex-start; border: 0; padding: 22px 24px 0; }
        .app-modal .modal-title { font-size: 16px; font-weight: 700; color: #0f172a; }
        .app-modal .modal-kicker { margin: 4px 0 0; font-size: 13px; color: #64748b; }
        .app-modal .modal-body { padding: 18px 24px 6px; }
        .app-modal .field { margin-bottom: 14px; }
        .app-modal .field > label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #334155; }
        .app-modal .req { color: #dc2626; }
        .app-modal .field .form-control { min-height: 40px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; }
        .app-modal textarea.form-control { min-height: 96px; }
        .app-modal .form-control:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12); }
        .app-modal .modal-footer { border: 0; justify-content: flex-end; gap: 8px; padding: 8px 24px 22px; }
        .app-modal .btn-modal-cancel,
        .app-modal .btn-modal-save {
            display: inline-flex; align-items: center; justify-content: center;
            min-height: 38px; padding: 8px 14px; border-radius: 8px;
            border: 1px solid transparent; font-size: 13px; font-weight: 600;
        }
        .app-modal .btn-modal-cancel { background: #fff; border-color: #cbd5e1; color: #334155; }
        .app-modal .btn-modal-save { background: #17365d; color: #fff; }
        .app-modal .suffix { margin-left: 8px; font-size: 13px; color: #64748b; }
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
                        <span class="d-block text-muted font-11">Berita Acara & E-Journal</span>
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
                    <span class="badge bg-white text-success rounded-pill px-3 py-1 font-11 fw-bold mb-2">
                        <i class="fa fa-circle-check me-1"></i> E-JOURNAL TERVERIFIKASI
                    </span>
                    <h2 class="fw-bold mb-1 text-white">{{ $jadwal->matkulId->matakuliah ?? 'Mata Kuliah' }}</h2>
                    <p class="mb-0 opacity-75 font-14">
                        Dosen: <strong>{{ $jadwal->matkulId->dosen ?? 'Bapak/Ibu Dosen' }}</strong> • 
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

        @if($jurnals->isEmpty())
            <div class="card-modern text-center py-5">
                <i class="fa fa-file-circle-xmark text-secondary opacity-50 fs-1 mb-3"></i>
                <h5 class="fw-bold text-dark">Belum Ada E-Journal</h5>
                <p class="text-muted small">Jurnal untuk jadwal perkuliahan ini belum dibuat.</p>
                <a href="/create-jurnal/{{ $jadwal->id }}" class="btn btn-success rounded-pill px-4">
                    <i class="fa fa-pen-to-square me-1"></i> Isi E-Journal Sekarang
                </a>
            </div>
        @else
            @foreach ($jurnals as $jurnal)
                <!-- Kartu Berita Acara -->
                <div class="card-modern">
                    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold font-12">
                                <i class="fa fa-check-circle me-1"></i> Berita Acara Pelaksanaan Praktikum
                            </span>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-semibold text-dark" data-bs-toggle="modal" data-bs-target="#editModal{{ $jurnal->id }}">
                                <i class="fa fa-pen me-1 text-warning"></i> Edit Jurnal
                            </button>
                        </div>
                    </div>

                    <!-- 1. Grid Informasi Jadwal -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3 col-sm-6">
                            <div class="info-pill">
                                <span class="info-pill-label"><i class="fa fa-flask me-1 text-success"></i> Laboratorium</span>
                                <span class="info-pill-value">{{ $jurnal->labId->laboratorium ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-pill">
                                <span class="info-pill-label"><i class="fa fa-graduation-cap me-1 text-success"></i> Program Studi</span>
                                <span class="info-pill-value">{{ optional($jurnal->programId)->program ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-pill">
                                <span class="info-pill-label"><i class="fa fa-clock me-1 text-success"></i> Jam Pelaksanaan</span>
                                <span class="info-pill-value">{{ $jurnal->jam_mulai }} – {{ $jurnal->jam_selesai }} WIB</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="info-pill">
                                <span class="info-pill-label"><i class="fa fa-users me-1 text-success"></i> Kehadiran Mahasiswa</span>
                                <span class="info-pill-value">
                                    <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-1 fw-bold">
                                        {{ $jurnal->jumlah ?? 0 }} Mahasiswa
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Materi Praktikum -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-2">
                            <i class="fa fa-book-open me-1 text-success"></i> Materi & Pokok Bahasan Praktikum:
                        </label>
                        <div class="materi-box">
                            {{ $jurnal->materi ?: 'Tidak ada rincian materi.' }}
                        </div>
                    </div>

                    <!-- 3. Tanda Tangan Digital -->
                    <div class="pt-3 border-top">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-2">
                            <i class="fa fa-signature me-1 text-success"></i> Tanda Tangan Digital Dosen Pengampu:
                        </label>
                        <div>
                            @if ($jurnal->ttd)
                                <div class="signature-preview-card">
                                    <img src="{{ Str::startsWith($jurnal->ttd, 'signatures/') ? asset('storage/' . $jurnal->ttd) : asset($jurnal->ttd) }}" 
                                         alt="Tanda Tangan Dosen" 
                                         style="max-height: 120px; max-width: 280px; object-fit: contain;">
                                    <div class="pt-2 border-top mt-2">
                                        <span class="d-block fw-bold text-dark font-13">{{ $jurnal->matkulId->dosen ?? 'Dosen Pengampu' }}</span>
                                        <span class="d-block text-muted font-11">{{ \Carbon\Carbon::parse($jurnal->created_at)->locale('id')->isoFormat('D MMMM Y, H:i') }} WIB</span>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted font-13 fst-italic">Tanda tangan digital tidak tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </main>

    @if(isset($jurnals))
        @foreach($jurnals as $jurnal)
        <div class="modal fade app-modal" id="editModal{{ $jurnal->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $jurnal->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <form action="/jurnal/{{ $jurnal->id }}/update" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" id="editModalLabel{{ $jurnal->id }}">Edit jurnal</h5>
                                <p class="modal-kicker">Perbarui jumlah hadir dan materi praktikum.</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="field">
                                <label for="jumlah-{{ $jurnal->id }}">Jumlah mahasiswa hadir <span class="req">*</span></label>
                                <input id="jumlah-{{ $jurnal->id }}" type="number" class="form-control" name="jumlah" min="1" value="{{ $jurnal->jumlah }}" required>
                                <span class="hint">Diisi dengan jumlah mahasiswa yang hadir.</span>
                            </div>
                            <div class="field">
                                <label for="materi-{{ $jurnal->id }}">Materi dan pokok bahasan <span class="req">*</span></label>
                                <textarea id="materi-{{ $jurnal->id }}" class="form-control" name="materi" rows="4" required>{{ $jurnal->materi }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-modal-save">Simpan perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endif

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
        document.querySelectorAll('.modal').forEach(function (modal) {
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
        });
    </script>
</body>

</html>