<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman Laboratorium - SILABO USH</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #1e293b;
            font-size: 14px;
        }

        /* Top Navigation Bar */
        .portal-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* Header Section */
        .page-header {
            margin-bottom: 24px;
        }

        /* Metric Summary Cards */
        .summary-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            height: 100%;
        }

        .summary-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .icon-blue { background: #eff6ff; color: #2563eb; }
        .icon-green { background: #ecfdf5; color: #059669; }
        .icon-amber { background: #fffbeb; color: #d97706; }

        .summary-count {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }

        .summary-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
            margin-top: 2px;
        }

        /* Main Table Card */
        .table-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .table-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid #f1f5f9;
            background: #ffffff;
        }

        .loan-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        .loan-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 20px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .loan-table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 13.5px;
        }

        .loan-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .loan-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.5;
            white-space: nowrap;
        }

        .status-badge-approved {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .status-badge-pending {
            background: #fffbeb;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .status-badge-rejected {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .status-badge-neutral {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .return-badge-done {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .return-badge-waiting {
            background: #f8fafc;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        /* Footer */
        .portal-footer {
            margin-top: auto;
            padding: 24px 0;
            text-align: center;
            color: #94a3b8;
            font-size: 12.5px;
            border-top: 1px solid #e2e8f0;
            background: #ffffff;
        }

        /* SweetAlert Custom Toast */
        .swal2-toast-silabo {
            border-radius: 12px !important;
            padding: 12px 18px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
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
    </style>
</head>

<body>
    <!-- Top Navigation Bar -->
    <header class="portal-navbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-nowrap">
                <a href="/" class="d-flex align-items-center gap-3 text-decoration-none flex-shrink-0">
                    <img src="{{ asset('img/ushh.png') }}" alt="Logo USH" style="height: 42px; width: 42px; object-fit: contain;" class="flex-shrink-0">
                    <div class="d-none d-sm-block text-start border-start ps-3 border-secondary-subtle">
                        <span class="d-block fw-bold text-dark font-14" style="line-height: 1.2;">SILABO USH</span>
                        <span class="d-block text-muted font-11">Sistem Informasi Laboratorium Terpadu</span>
                    </div>
                </a>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a href="/" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-medium text-nowrap">
                        <i class="fa fa-arrow-left me-1"></i> Ke Portal Utama
                    </a>
                    @if(Auth::check())
                        <a href="/home" class="btn btn-sm btn-primary rounded-pill px-3 fw-medium text-nowrap">
                            <i class="fa fa-gauge me-1"></i> Dashboard
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="container py-4">
        <!-- Page Header -->
        <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h3 class="fw-bold text-dark mb-1">Status Peminjaman Laboratorium</h3>
                <p class="text-muted small mb-0">Pantau status persetujuan dan riwayat permohonan peminjaman laboratorium secara real-time.</p>
            </div>
            <div class="flex-shrink-0">
                <a href="/create-peminjaman" class="btn btn-primary px-3 py-2 rounded-3 fw-semibold shadow-sm d-inline-flex align-items-center gap-2">
                    <i class="fa fa-plus"></i> Ajukan Peminjaman
                </a>
            </div>
        </div>

        <!-- Metric Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="summary-card">
                    <div class="summary-icon icon-blue">
                        <i class="fa fa-folder-open"></i>
                    </div>
                    <div>
                        <div class="summary-count">{{ $totalPinjam ?? 0 }}</div>
                        <div class="summary-label">Total Permohonan</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <div class="summary-icon icon-green">
                        <i class="fa fa-circle-check"></i>
                    </div>
                    <div>
                        <div class="summary-count">{{ $totalSetuju ?? 0 }}</div>
                        <div class="summary-label">Disetujui</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card">
                    <div class="summary-icon icon-amber">
                        <i class="fa fa-clock"></i>
                    </div>
                    <div>
                        <div class="summary-count">{{ $totalProses ?? 0 }}</div>
                        <div class="summary-label">Menunggu Persetujuan</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card with Integrated Toolbar -->
        <div class="table-card">
            <!-- Table Header Toolbar -->
            <div class="table-card-header">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Daftar Permohonan</h6>
                        <small class="text-muted">Menampilkan {{ $pemakaian->count() }} transaksi</small>
                    </div>

                    <!-- Filter Date Form -->
                    <form action="/lihatpeminjaman" method="GET" class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="input-group input-group-sm" style="width: auto;">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="fa fa-calendar-day"></i>
                            </span>
                            <input type="date" name="tgl_peminjaman" class="form-control border-start-0 ps-0"
                                value="{{ request('tgl_peminjaman') }}" style="min-width: 140px;">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary px-3 rounded-2 fw-medium">
                            <i class="fa fa-filter me-1"></i> Filter
                        </button>
                        @if(request('tgl_peminjaman'))
                            <a href="/lihatpeminjaman" class="btn btn-sm btn-light border text-secondary px-2 rounded-2" title="Reset Filter">
                                <i class="fa fa-rotate-left me-1"></i> Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Table Content -->
            @if($pemakaian->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fa fa-inbox text-muted opacity-50" style="font-size: 3rem;"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Tidak Ada Data Peminjaman</h6>
                    <p class="text-muted small mb-3">
                        @if(request('tgl_peminjaman'))
                            Tidak ada permohonan peminjaman pada tanggal <strong>{{ \Carbon\Carbon::parse(request('tgl_peminjaman'))->isoFormat('D MMMM Y') }}</strong>.
                        @else
                            Belum ada catatan transaksi peminjaman laboratorium saat ini.
                        @endif
                    </p>
                    @if(request('tgl_peminjaman'))
                        <a href="/lihatpeminjaman" class="btn btn-sm btn-outline-primary px-3 rounded-2">
                            Tampilkan Semua Data
                        </a>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="loan-table">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th>Nama Peminjam</th>
                                <th>Laboratorium</th>
                                <th>Periode Peminjaman</th>
                                <th>Status Approval</th>
                                <th>Pengembalian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pemakaian as $pinjam)
                                <tr>
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $pinjam->nama }}</div>
                                        <small class="text-muted">{{ Str::limit($pinjam->keperluan, 40) }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">
                                            {{ optional($pinjam->labId)->laboratorium ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-13">
                                            <span class="text-muted">Pinjam:</span> <strong class="text-dark">{{ \Carbon\Carbon::parse($pinjam->tgl_peminjaman)->isoFormat('D MMM Y') }}</strong>
                                        </div>
                                        <div class="font-13 text-secondary">
                                            <span class="text-muted">Kembali:</span> {{ \Carbon\Carbon::parse($pinjam->tgl_pengembalian)->isoFormat('D MMM Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($pinjam->keterangan == 'setuju')
                                            <span class="status-badge status-badge-approved">
                                                <i class="fa fa-circle-check"></i> Disetujui
                                            </span>
                                        @elseif($pinjam->keterangan == 'proses')
                                            <span class="status-badge status-badge-pending">
                                                <i class="fa fa-hourglass-half"></i> Dalam Proses
                                            </span>
                                        @elseif($pinjam->keterangan == 'ditolak')
                                            <span class="status-badge status-badge-rejected">
                                                <i class="fa fa-circle-xmark"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="status-badge status-badge-neutral">
                                                Menunggu Validasi
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pinjam->status_pengembalian == 'sudah')
                                            <span class="status-badge return-badge-done">
                                                <i class="fa fa-check"></i> Sudah Kembali
                                            </span>
                                        @else
                                            <span class="status-badge return-badge-waiting">
                                                Belum Kembali
                                            </span>
                                        @endif
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
                timer: 4500,
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
                title: 'Berhasil!',
                text: '{{ session('success') }}'
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