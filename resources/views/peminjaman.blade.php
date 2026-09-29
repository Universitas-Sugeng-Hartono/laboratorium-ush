<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Peminjaman Laboratorium - SILABO USH</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Modern SweetAlert2 SILABO Theme */
        .swal2-popup {
            border-radius: 16px !important;
            padding: 24px 22px !important;
            font-family: 'Inter', sans-serif !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
            border: 1px solid #e2e8f0 !important;
        }
        .swal2-icon {
            border-width: 3px !important;
            margin: 8px auto 16px auto !important;
            transform: scale(0.9);
        }
        .swal2-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-bottom: 6px !important;
        }
        .swal2-html-container {
            font-size: 13.5px !important;
            color: #64748b !important;
            line-height: 1.5 !important;
            margin: 0 !important;
        }
        .swal2-actions {
            margin-top: 20px !important;
            gap: 10px !important;
        }
        .swal2-styled.swal2-confirm {
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 9px 22px !important;
            background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.25) !important;
            transition: all 0.2s ease !important;
        }
        .swal2-styled.swal2-confirm:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af) !important;
            transform: translateY(-1px) !important;
        }
        .swal2-styled.swal2-cancel {
            border-radius: 8px !important;
            font-weight: 500 !important;
            font-size: 13px !important;
            padding: 9px 18px !important;
            background: #f8fafc !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1 !important;
            box-shadow: none !important;
        }
        .swal2-styled.swal2-cancel:hover {
            background: #f1f5f9 !important;
            color: #1e293b !important;
        }
        .swal2-ush-logo {
            object-fit: contain !important;
            margin: 6px auto 14px auto !important;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.08));
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

        .page-header-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 22px 28px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .card-modern {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .card-modern-header {
            padding: 18px 24px;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-modern-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-modern-body {
            padding: 24px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #64748b;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        .selector-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 16px;
        }

        .item-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .item-table thead th {
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .item-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 13.5px;
        }

        .item-table tbody tr:hover {
            background-color: #f8fafd;
        }

        .btn-add {
            background: #4f46e5;
            color: #ffffff;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            padding: 10px 18px;
            border: none;
            transition: all 0.2s;
        }

        .btn-add:hover {
            background: #4338ca;
            color: #ffffff;
        }

        .empty-placeholder {
            text-align: center;
            padding: 30px 20px;
            color: #94a3b8;
            font-size: 13.5px;
        }

        .canvas-container {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background: #ffffff;
            display: inline-block;
            position: relative;
            cursor: crosshair;
            width: 100%;
            max-width: 480px;
        }

        #signature-pad {
            display: block;
            width: 100%;
            height: 180px;
            border-radius: 10px;
            touch-action: none;
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
                        <span class="d-block text-muted font-11">Sistem Informasi Laboratorium</span>
                    </div>
                </a>

                @php
                    $isAdmin = request()->is('pemakaian*') || (auth()->check() && str_contains(url()->previous(), 'pemakaian'));
                    $backUrl = $isAdmin ? route('pemakaian.index') : '/lihatpeminjaman';
                    $backLabel = $isAdmin ? 'Kembali ke Data Pemakaian' : 'Kembali ke Daftar';
                @endphp

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a href="{{ $backUrl }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold text-nowrap">
                        <i class="fa fa-arrow-left me-1"></i> {{ $backLabel }}
                    </a>
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
                    <h3 class="fw-bold mb-1 text-dark">Formulir Peminjaman Laboratorium</h3>
                    <p class="mb-0 text-muted font-14">
                        Pengajuan pemakaian ruang laboratorium terpadu, peralatan praktikum, dan bahan penelitian.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="/lihatpeminjaman" class="btn btn-outline-primary rounded-pill px-3 py-1.5 font-13 fw-semibold">
                        <i class="fa fa-list-check me-1"></i> Pantau Status Peminjaman
                    </a>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert" style="background:#fef2f2; color:#991b1b;">
                <i class="fa fa-triangle-exclamation fs-5 me-2 text-danger"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
                <h6 class="fw-bold mb-2"><i class="fa fa-circle-exclamation me-1"></i> Terdapat kesalahan pada isian formulir:</h6>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="/peminjaman/store" method="POST" id="peminjamanForm">
            @csrf

            <!-- Section 1: Data Pemohon & Ruangan -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h5>1. Informasi Pemohon & Ruang Laboratorium</h5>
                </div>
                <div class="card-modern-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap Pemohon / Peminjam <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor WhatsApp / HP Aktif <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nomor" id="inputNomor" value="{{ old('nomor') }}" placeholder="08... atau 628..." inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="15" required>
                            <small class="text-muted font-11">Awalan 08 atau 628. Nomor disimpan sebagai 628.</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Program Studi</label>
                            <select class="form-select" name="program_id" id="selectProgram">
                                <option value="">-- Pilih Program Studi (Opsional) --</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Laboratorium yang Digunakan <span class="text-danger">*</span></label>
                            <select class="form-select" name="lab_id" id="selectLaboratorium" required>
                                <option value="">-- Pilih Laboratorium --</option>
                                @foreach($laboratorium as $lab)
                                    <option value="{{ $lab->id }}" {{ old('lab_id') == $lab->id ? 'selected' : '' }}>
                                        {{ $lab->laboratorium }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted font-11">Peralatan dan bahan akan disesuaikan dengan lab ini.</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Mata Kuliah</label>
                            <select class="form-select" name="matakuliah_id" id="selectMatkul">
                                <option value="">-- Pilih Program Studi terlebih dahulu --</option>
                                <option value="100" {{ old('matakuliah_id') == '100' ? 'selected' : '' }}>Tidak Berdasarkan Mata Kuliah (Kegiatan Mandiri/Riset)</option>
                            </select>
                            <small class="text-muted font-11" id="matkulHelperText">Mata kuliah disesuaikan dengan prodi terpilih.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai Peminjaman <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tgl_peminjaman" id="tgl_peminjaman" value="{{ old('tgl_peminjaman', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Selesai / Pengembalian <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tgl_pengembalian" id="tgl_pengembalian" value="{{ old('tgl_pengembalian', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Keperluan / Deskripsi Kegiatan <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="keperluan" rows="3" placeholder="Jelaskan tujuan pemakaian laboratorium (misal: Praktikum Jaringan Komputer Modul 3, Riset Tugas Akhir, dll.)" required>{{ old('keperluan') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Peralatan Tambahan (Dinamis) -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h5>2. Peminjaman Peralatan Khusus <span class="text-muted font-12 fw-normal">(Opsional)</span></h5>
                    <span class="badge bg-light text-secondary border font-11 px-3 py-1">Keranjang Dinamis</span>
                </div>
                <div class="card-modern-body">
                    <p class="text-muted font-13 mb-3">
                        Pilih peralatan khusus yang ingin dipinjam dari laboratorium terpilih. Fasilitas umum ruangan (kursi, meja, AC) sudah otomatis tercakup dalam pemakaian lab.
                    </p>

                    <!-- Selector Bar -->
                    <div class="selector-box">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-7">
                                <label class="form-label font-12 mb-1">Pilih Alat yang Tersedia:</label>
                                <select id="inputAlatSelect" class="form-select">
                                    <option value="">-- Pilih Laboratorium terlebih dahulu --</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-12 mb-1">Jumlah Unit:</label>
                                <input type="number" id="inputAlatJumlah" class="form-control" min="1" value="1" placeholder="Jml">
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="btnTambahAlat" class="btn btn-add w-100">
                                    <i class="fa fa-plus me-1"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <div id="alatStockFeedback" class="font-11 text-muted mt-2"></div>
                    </div>

                    <!-- Table of Selected Tools -->
                    <div class="table-responsive rounded-3 border">
                        <table class="item-table" id="tableSelectedAlat">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Peralatan</th>
                                    <th width="150" class="text-center">Sisa Stok Lab</th>
                                    <th width="150" class="text-center">Jumlah Dipinjam</th>
                                    <th width="80" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodySelectedAlat">
                                <tr id="emptyAlatRow">
                                    <td colspan="5" class="empty-placeholder">
                                        <i class="fa fa-box-open fs-3 d-block mb-2 text-secondary opacity-50"></i>
                                        Belum ada peralatan khusus yang ditambahkan ke daftar peminjaman.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section 3: Bahan Habis Pakai (Dinamis) -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h5>3. Kebutuhan Bahan Habis Pakai <span class="text-muted font-12 fw-normal">(Opsional)</span></h5>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" id="checkNeedBahan">
                        <label class="form-check-label font-12 fw-semibold" for="checkNeedBahan">Perlu Bahan?</label>
                    </div>
                </div>
                <div class="card-modern-body" id="bahanSectionContent" style="display: none;">
                    <p class="text-muted font-13 mb-3">
                        Pilih bahan praktikum / penelitian yang dibutuhkan beserta jumlah pemakaian.
                    </p>

                    <!-- Selector Bar Bahan -->
                    <div class="selector-box">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-7">
                                <label class="form-label font-12 mb-1">Pilih Bahan yang Tersedia:</label>
                                <select id="inputBahanSelect" class="form-select">
                                    <option value="">-- Pilih Laboratorium terlebih dahulu --</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label font-12 mb-1">Jumlah Pakai:</label>
                                <input type="number" id="inputBahanJumlah" class="form-control" min="1" value="1" placeholder="Jml">
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="btnTambahBahan" class="btn btn-add w-100">
                                    <i class="fa fa-plus me-1"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <div id="bahanStockFeedback" class="font-11 text-muted mt-2"></div>
                    </div>

                    <!-- Table of Selected Materials -->
                    <div class="table-responsive rounded-3 border">
                        <table class="item-table" id="tableSelectedBahan">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Bahan Praktikum</th>
                                    <th width="150" class="text-center">Sisa Stok Lab</th>
                                    <th width="150" class="text-center">Jumlah Dipakai</th>
                                    <th width="80" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="bodySelectedBahan">
                                <tr id="emptyBahanRow">
                                    <td colspan="5" class="empty-placeholder">
                                        <i class="fa fa-vial fs-3 d-block mb-2 text-secondary opacity-50"></i>
                                        Belum ada bahan yang ditambahkan ke daftar peminjaman.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section 4: Tanda Tangan Digital Pemohon -->
            <div class="card-modern">
                <div class="card-modern-header">
                    <h5>4. Tanda Tangan Digital Pemohon <span class="text-danger">*</span></h5>
                </div>
                <div class="card-modern-body">
                    <p class="text-muted font-13 mb-3">
                        Goreskan tanda tangan digital Anda pada area kanvas di bawah ini menggunakan mouse atau jari (layar sentuh).
                    </p>

                    <div class="row align-items-center">
                        <div class="col-md-auto text-center mb-3 mb-md-0">
                            <div class="canvas-container">
                                <canvas id="signature-pad" width="480" height="180"></canvas>
                            </div>
                            <input type="hidden" name="ttd" id="signature-data">
                        </div>
                        <div class="col-md">
                            <div class="ps-md-3">
                                <button type="button" id="clear-signature" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-3">
                                    <i class="fa fa-rotate-left me-1"></i> Bersihkan Tanda Tangan
                                </button>
                                <div class="alert alert-light border rounded-3 font-12 text-secondary mb-0">
                                    <i class="fa fa-circle-info text-primary me-1"></i>
                                    Dengan menandatangani dan mengirimkan formulir ini, Anda menyatakan bertanggung jawab penuh atas penggunaan dan keutuhan fasilitas laboratorium yang dipinjam sesuai tata tertib Universitas Sugeng Hartono.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Submission Bar -->
            <div class="d-flex align-items-center justify-content-between p-3 bg-white rounded-3 border shadow-sm mb-5">
                <a href="{{ $backUrl }}" class="btn btn-outline-secondary rounded-pill px-4 fw-medium font-14">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold font-14 shadow-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border:none;">
                    Kirim Permohonan Peminjaman
                </button>
            </div>
        </form>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container">
            <p class="mb-0">
                &copy; {{ date('Y') }} <strong>Universitas Sugeng Hartono</strong>. Laboratorium Terpadu - All Rights Reserved.
            </p>
        </div>
    </footer>

    <!-- Master Data JSON for Dynamic Filtering -->
    <script>
        const masterAlats = @json($alats);
        const masterBahans = @json($bahans);
        const masterMatkuls = @json($matkul);
        let initialMatkulId = "{{ old('matakuliah_id') }}";
    </script>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectProgram = document.getElementById("selectProgram");
            const selectMatkul = document.getElementById("selectMatkul");
            const matkulHelperText = document.getElementById("matkulHelperText");

            const selectLab = document.getElementById("selectLaboratorium");
            const inputAlatSelect = document.getElementById("inputAlatSelect");
            const inputAlatJumlah = document.getElementById("inputAlatJumlah");
            const btnTambahAlat = document.getElementById("btnTambahAlat");
            const bodySelectedAlat = document.getElementById("bodySelectedAlat");
            const emptyAlatRow = document.getElementById("emptyAlatRow");
            const alatStockFeedback = document.getElementById("alatStockFeedback");

            const checkNeedBahan = document.getElementById("checkNeedBahan");
            const bahanSectionContent = document.getElementById("bahanSectionContent");
            const inputBahanSelect = document.getElementById("inputBahanSelect");
            const inputBahanJumlah = document.getElementById("inputBahanJumlah");
            const btnTambahBahan = document.getElementById("btnTambahBahan");
            const bodySelectedBahan = document.getElementById("bodySelectedBahan");
            const emptyBahanRow = document.getElementById("emptyBahanRow");
            const bahanStockFeedback = document.getElementById("bahanStockFeedback");

            // Track selected items to prevent duplicates
            let selectedAlatIds = new Set();
            let selectedBahanIds = new Set();

            // Filter Mata Kuliah when Program Studi changes
            function updateAvailableMatkul() {
                const programId = parseInt(selectProgram.value);
                const currentVal = selectMatkul.value || initialMatkulId;

                selectMatkul.innerHTML = "";

                const defaultOpt = document.createElement("option");
                defaultOpt.value = "";
                defaultOpt.textContent = programId 
                    ? "-- Pilih Mata Kuliah (Opsional) --" 
                    : "-- Pilih Program Studi terlebih dahulu --";
                selectMatkul.appendChild(defaultOpt);

                const mandiriOpt = document.createElement("option");
                mandiriOpt.value = "100";
                mandiriOpt.textContent = "Tidak Berdasarkan Mata Kuliah (Kegiatan Mandiri/Riset)";
                if (currentVal === "100") {
                    mandiriOpt.selected = true;
                }
                selectMatkul.appendChild(mandiriOpt);

                if (!programId) {
                    if (matkulHelperText) {
                        matkulHelperText.innerHTML = '<i class="fa fa-info-circle me-1"></i>Pilih Program Studi untuk memfilter mata kuliah.';
                        matkulHelperText.className = "text-muted font-11";
                    }
                } else {
                    const filteredMatkuls = masterMatkuls.filter(m => m.program_id === programId);
                    if (filteredMatkuls.length === 0) {
                        const emptyOpt = document.createElement("option");
                        emptyOpt.value = "";
                        emptyOpt.disabled = true;
                        emptyOpt.textContent = "-- Belum ada mata kuliah untuk prodi ini --";
                        selectMatkul.appendChild(emptyOpt);
                        if (matkulHelperText) {
                            matkulHelperText.innerHTML = '<i class="fa fa-circle-exclamation me-1"></i>Tidak ada mata kuliah terdaftar untuk prodi ini.';
                            matkulHelperText.className = "text-secondary font-11";
                        }
                    } else {
                        filteredMatkuls.forEach(m => {
                            const opt = document.createElement("option");
                            opt.value = m.id;
                            opt.textContent = m.matakuliah;
                            if (currentVal == m.id) {
                                opt.selected = true;
                            }
                            selectMatkul.appendChild(opt);
                        });
                        if (matkulHelperText) {
                            matkulHelperText.innerHTML = `<i class="fa fa-check me-1"></i>${filteredMatkuls.length} mata kuliah tersedia untuk prodi ini.`;
                            matkulHelperText.className = "text-success font-11";
                        }
                    }
                }
            }

            selectProgram.addEventListener("change", function () {
                initialMatkulId = "";
                updateAvailableMatkul();
            });

            // Initial call for Matkul
            updateAvailableMatkul();

            // Toggle Bahan Section
            checkNeedBahan.addEventListener("change", function () {
                bahanSectionContent.style.display = this.checked ? "block" : "none";
            });

            // Filter Alat and Bahan when Lab changes
            function updateAvailableItems() {
                const labId = parseInt(selectLab.value);

                // Update Alat Dropdown
                inputAlatSelect.innerHTML = "";
                if (!labId) {
                    inputAlatSelect.innerHTML = '<option value="">-- Pilih Laboratorium terlebih dahulu --</option>';
                    alatStockFeedback.innerText = "";
                } else {
                    const filteredAlats = masterAlats.filter(item => item.lab_id === labId && item.jumlah > 0);
                    if (filteredAlats.length === 0) {
                        inputAlatSelect.innerHTML = '<option value="">-- Tidak ada peralatan tersedia di laboratorium ini --</option>';
                        alatStockFeedback.innerText = "";
                    } else {
                        inputAlatSelect.innerHTML = '<option value="">-- Pilih Alat yang Ingin Dipinjam --</option>';
                        filteredAlats.forEach(item => {
                            const opt = document.createElement("option");
                            opt.value = item.id;
                            opt.textContent = `${item.alat} (Tersedia: ${item.jumlah} unit)`;
                            opt.dataset.stok = item.jumlah;
                            opt.dataset.nama = item.alat;
                            inputAlatSelect.appendChild(opt);
                        });
                    }
                }

                // Update Bahan Dropdown
                inputBahanSelect.innerHTML = "";
                if (!labId) {
                    inputBahanSelect.innerHTML = '<option value="">-- Pilih Laboratorium terlebih dahulu --</option>';
                    bahanStockFeedback.innerText = "";
                } else {
                    const filteredBahans = masterBahans.filter(item => item.lab_id === labId && item.jumlah > 0);
                    if (filteredBahans.length === 0) {
                        inputBahanSelect.innerHTML = '<option value="">-- Tidak ada bahan habis pakai di laboratorium ini --</option>';
                        bahanStockFeedback.innerText = "";
                    } else {
                        inputBahanSelect.innerHTML = '<option value="">-- Pilih Bahan Praktikum --</option>';
                        filteredBahans.forEach(item => {
                            const opt = document.createElement("option");
                            opt.value = item.id;
                            opt.textContent = `${item.bahan} (Stok: ${item.jumlah} ${item.satuan || 'unit'})`;
                            opt.dataset.stok = item.jumlah;
                            opt.dataset.nama = item.bahan;
                            opt.dataset.satuan = item.satuan || 'unit';
                            inputBahanSelect.appendChild(opt);
                        });
                    }
                }
            }

            // SweetAlert2 Toast Mixin
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2800,
                timerProgressBar: true,
            });

            let previousLabValue = selectLab.value;

            selectLab.addEventListener("change", function () {
                const newLab = this.value;
                if (selectedAlatIds.size > 0 || selectedBahanIds.size > 0) {
                    Swal.fire({
                        title: 'Ganti Laboratorium?',
                        text: 'Mengganti laboratorium akan mengosongkan daftar peralatan dan bahan yang sudah Anda pilih. Apakah Anda yakin ingin melanjutkan?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Ganti',
                        cancelButtonText: 'Batalkan',
                        confirmButtonColor: '#4f46e5',
                        cancelButtonColor: '#64748b',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            bodySelectedAlat.innerHTML = '';
                            bodySelectedAlat.appendChild(emptyAlatRow);
                            selectedAlatIds.clear();

                            bodySelectedBahan.innerHTML = '';
                            bodySelectedBahan.appendChild(emptyBahanRow);
                            selectedBahanIds.clear();

                            previousLabValue = newLab;
                            updateAvailableItems();
                            Toast.fire({ icon: 'info', title: 'Daftar alat & bahan telah direset' });
                        } else {
                            selectLab.value = previousLabValue;
                        }
                    });
                } else {
                    previousLabValue = newLab;
                    updateAvailableItems();
                }
            });

            // Initial load of items if lab was pre-selected
            if (selectLab.value) {
                updateAvailableItems();
            }

            // Feedback stock on Alat Select
            inputAlatSelect.addEventListener("change", function () {
                const opt = this.options[this.selectedIndex];
                if (opt && opt.dataset.stok) {
                    const stok = parseInt(opt.dataset.stok);
                    alatStockFeedback.innerHTML = `<span class="badge bg-light text-dark border">Stok tersedia: <strong>${stok}</strong> unit</span>`;
                    inputAlatJumlah.max = stok;
                    inputAlatJumlah.value = 1;
                } else {
                    alatStockFeedback.innerText = "";
                }
            });

            // Feedback stock on Bahan Select
            inputBahanSelect.addEventListener("change", function () {
                const opt = this.options[this.selectedIndex];
                if (opt && opt.dataset.stok) {
                    const stok = parseInt(opt.dataset.stok);
                    const satuan = opt.dataset.satuan;
                    bahanStockFeedback.innerHTML = `<span class="badge bg-light text-dark border">Stok tersedia: <strong>${stok}</strong> ${satuan}</span>`;
                    inputBahanJumlah.max = stok;
                    inputBahanJumlah.value = 1;
                } else {
                    bahanStockFeedback.innerText = "";
                }
            });

            // Add Alat to Table
            btnTambahAlat.addEventListener("click", function () {
                const opt = inputAlatSelect.options[inputAlatSelect.selectedIndex];
                if (!opt || !opt.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Alat Terlebih Dahulu',
                        text: 'Silakan tentukan alat praktikum yang ingin dipinjam dari daftar pilihan.',
                        confirmButtonText: 'Baik',
                        confirmButtonColor: '#4f46e5',
                    });
                    return;
                }

                const alatId = opt.value;
                const namaAlat = opt.dataset.nama;
                const maxStok = parseInt(opt.dataset.stok);
                const jumlah = parseInt(inputAlatJumlah.value);

                if (!jumlah || jumlah < 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jumlah Tidak Valid',
                        text: 'Masukkan jumlah peminjaman yang valid (minimal 1 unit).',
                        confirmButtonText: 'Baik',
                        confirmButtonColor: '#4f46e5',
                    });
                    return;
                }

                if (jumlah > maxStok) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stok Tidak Mencukupi',
                        html: `Jumlah pinjam (<strong>${jumlah} unit</strong>) melebihi sisa stok yang tersedia di laboratorium (<strong>${maxStok} unit</strong>).`,
                        confirmButtonText: 'Sesuaikan Jumlah',
                        confirmButtonColor: '#4f46e5',
                    });
                    return;
                }

                if (selectedAlatIds.has(alatId)) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Alat Sudah Ada di Daftar',
                        html: `Peralatan <strong>"${namaAlat}"</strong> sudah ada di dalam daftar peminjaman.<br><small class="text-muted d-block mt-2">Jika ingin mengganti jumlah unit, silakan hapus baris alat ini pada tabel terlebih dahulu.</small>`,
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#4f46e5',
                    });
                    return;
                }

                if (emptyAlatRow && emptyAlatRow.parentNode === bodySelectedAlat) {
                    bodySelectedAlat.removeChild(emptyAlatRow);
                }

                selectedAlatIds.add(alatId);
                const row = document.createElement("tr");
                row.id = `row-alat-${alatId}`;
                row.innerHTML = `
                    <td class="row-num text-center"></td>
                    <td>
                        <div class="fw-semibold text-dark">${namaAlat}</div>
                        <input type="hidden" name="alat_id[]" value="${alatId}">
                    </td>
                    <td class="text-center text-muted font-13">${maxStok} unit</td>
                    <td class="text-center">
                        <span class="badge px-3 py-2" style="background:#e0e7ff; color:#3730a3; font-weight:700; border-radius:8px;">
                            ${jumlah} unit
                        </span>
                        <input type="hidden" name="jumlah_alat[]" value="${jumlah}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle px-2 py-1 btn-delete-alat" data-id="${alatId}" title="Hapus dari daftar">
                            <i class="fa fa-trash-can"></i>
                        </button>
                    </td>
                `;
                bodySelectedAlat.appendChild(row);
                reindexRows(bodySelectedAlat);

                Toast.fire({
                    icon: 'success',
                    title: `Alat "${namaAlat}" berhasil ditambahkan`
                });

                // Reset inputs
                inputAlatSelect.value = "";
                inputAlatJumlah.value = 1;
                alatStockFeedback.innerText = "";
            });

            // Delete Alat from Table
            bodySelectedAlat.addEventListener("click", function (e) {
                const btn = e.target.closest(".btn-delete-alat");
                if (btn) {
                    const id = btn.dataset.id;
                    const row = document.getElementById(`row-alat-${id}`);
                    if (row) {
                        row.remove();
                        selectedAlatIds.delete(id);
                        if (selectedAlatIds.size === 0) {
                            bodySelectedAlat.appendChild(emptyAlatRow);
                        } else {
                            reindexRows(bodySelectedAlat);
                        }
                        Toast.fire({
                            icon: 'info',
                            title: 'Alat telah dihapus dari daftar'
                        });
                    }
                }
            });

            // Add Bahan to Table
            btnTambahBahan.addEventListener("click", function () {
                const opt = inputBahanSelect.options[inputBahanSelect.selectedIndex];
                if (!opt || !opt.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Bahan Terlebih Dahulu',
                        text: 'Silakan pilih bahan praktikum yang ingin digunakan dari daftar pilihan.',
                        confirmButtonText: 'Baik',
                        confirmButtonColor: '#4f46e5',
                    });
                    return;
                }

                const bahanId = opt.value;
                const namaBahan = opt.dataset.nama;
                const maxStok = parseInt(opt.dataset.stok);
                const satuan = opt.dataset.satuan;
                const jumlah = parseInt(inputBahanJumlah.value);

                if (!jumlah || jumlah < 1) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jumlah Tidak Valid',
                        text: 'Masukkan jumlah pemakaian bahan yang valid (minimal 1).',
                        confirmButtonText: 'Baik',
                        confirmButtonColor: '#4f46e5',
                    });
                    return;
                }

                if (jumlah > maxStok) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stok Bahan Tidak Mencukupi',
                        html: `Jumlah pemakaian (<strong>${jumlah} ${satuan}</strong>) melebihi sisa stok yang tersedia di laboratorium (<strong>${maxStok} ${satuan}</strong>).`,
                        confirmButtonText: 'Sesuaikan Jumlah',
                        confirmButtonColor: '#4f46e5',
                    });
                    return;
                }

                if (selectedBahanIds.has(bahanId)) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Bahan Sudah Ada di Daftar',
                        html: `Bahan praktikum <strong>"${namaBahan}"</strong> sudah ada di dalam daftar peminjaman.<br><small class="text-muted d-block mt-2">Jika ingin mengganti jumlah pemakaian, silakan hapus baris bahan ini pada tabel terlebih dahulu.</small>`,
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#4f46e5',
                    });
                    return;
                }

                if (emptyBahanRow && emptyBahanRow.parentNode === bodySelectedBahan) {
                    bodySelectedBahan.removeChild(emptyBahanRow);
                }

                selectedBahanIds.add(bahanId);
                const row = document.createElement("tr");
                row.id = `row-bahan-${bahanId}`;
                row.innerHTML = `
                    <td class="row-num text-center"></td>
                    <td>
                        <div class="fw-semibold text-dark">${namaBahan}</div>
                        <input type="hidden" name="bahan_id[]" value="${bahanId}">
                    </td>
                    <td class="text-center text-muted font-13">${maxStok} ${satuan}</td>
                    <td class="text-center">
                        <span class="badge px-3 py-2" style="background:#fef3c7; color:#92400e; font-weight:700; border-radius:8px;">
                            ${jumlah} ${satuan}
                        </span>
                        <input type="hidden" name="jumlah_bahan[]" value="${jumlah}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle px-2 py-1 btn-delete-bahan" data-id="${bahanId}" title="Hapus dari daftar">
                            <i class="fa fa-trash-can"></i>
                        </button>
                    </td>
                `;
                bodySelectedBahan.appendChild(row);
                reindexRows(bodySelectedBahan);

                Toast.fire({
                    icon: 'success',
                    title: `Bahan "${namaBahan}" berhasil ditambahkan`
                });

                // Reset inputs
                inputBahanSelect.value = "";
                inputBahanJumlah.value = 1;
                bahanStockFeedback.innerText = "";
            });

            // Delete Bahan from Table
            bodySelectedBahan.addEventListener("click", function (e) {
                const btn = e.target.closest(".btn-delete-bahan");
                if (btn) {
                    const id = btn.dataset.id;
                    const row = document.getElementById(`row-bahan-${id}`);
                    if (row) {
                        row.remove();
                        selectedBahanIds.delete(id);
                        if (selectedBahanIds.size === 0) {
                            bodySelectedBahan.appendChild(emptyBahanRow);
                        } else {
                            reindexRows(bodySelectedBahan);
                        }
                        Toast.fire({
                            icon: 'info',
                            title: 'Bahan telah dihapus dari daftar'
                        });
                    }
                }
            });

            function reindexRows(tbody) {
                const rows = tbody.querySelectorAll("tr:not([id*='empty'])");
                rows.forEach((r, idx) => {
                    const numCell = r.querySelector(".row-num");
                    if (numCell) numCell.innerText = idx + 1;
                });
            }

            // Signature Pad Implementation
            const canvas = document.getElementById("signature-pad");
            const ctx = canvas.getContext("2d");
            let isDrawing = false;
            let hasDrawn = false;

            ctx.lineWidth = 2.5;
            ctx.lineCap = "round";
            ctx.lineJoin = "round";
            ctx.strokeStyle = "#1e293b";

            function getCanvasCoordinates(e) {
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;

                let clientX, clientY;
                if (e.touches && e.touches.length > 0) {
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                } else {
                    clientX = e.clientX;
                    clientY = e.clientY;
                }

                return {
                    x: (clientX - rect.left) * scaleX,
                    y: (clientY - rect.top) * scaleY
                };
            }

            function startDraw(e) {
                e.preventDefault();
                isDrawing = true;
                hasDrawn = true;
                const pos = getCanvasCoordinates(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            }

            function draw(e) {
                if (!isDrawing) return;
                e.preventDefault();
                const pos = getCanvasCoordinates(e);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
            }

            function stopDraw() {
                isDrawing = false;
            }

            canvas.addEventListener("mousedown", startDraw);
            canvas.addEventListener("mousemove", draw);
            window.addEventListener("mouseup", stopDraw);

            canvas.addEventListener("touchstart", startDraw, { passive: false });
            canvas.addEventListener("touchmove", draw, { passive: false });
            window.addEventListener("touchend", stopDraw);

            document.getElementById("clear-signature").addEventListener("click", function () {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById("signature-data").value = "";
                hasDrawn = false;
            });

            // Form Submit with Comprehensive Validation & Confirmation Dialog
            const peminjamanForm = document.getElementById("peminjamanForm");
            let isConfirmedSubmit = false;

            peminjamanForm.addEventListener("submit", function (e) {
                if (isConfirmedSubmit) {
                    return true;
                }

                e.preventDefault();

                // 1. Validasi Kelengkapan Field Wajib HTML5
                if (!peminjamanForm.checkValidity()) {
                    peminjamanForm.reportValidity();
                    return;
                }

                const nomor = peminjamanForm.querySelector('[name="nomor"]').value.trim();
                if (!/^(08\d{8,12}|628\d{8,12})$/.test(nomor)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Nomor WhatsApp Tidak Sesuai',
                        text: 'Nomor WhatsApp harus diawali 08 atau 628.',
                        confirmButtonColor: '#4f46e5'
                    });
                    return;
                }

                // 3. Validasi Tanggal Peminjaman vs Pengembalian
                const tglPinjam = document.getElementById("tgl_peminjaman").value;
                const tglKembali = document.getElementById("tgl_pengembalian").value;
                if (tglKembali && tglPinjam && tglKembali < tglPinjam) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal Tidak Sesuai',
                        text: 'Tanggal selesai/pengembalian tidak boleh lebih awal dari tanggal mulai peminjaman.',
                        confirmButtonColor: '#4f46e5'
                    });
                    return;
                }

                // 4. Wajib ada alat atau bahan
                const alatTerpilih = document.querySelectorAll("#bodySelectedAlat input[name='jumlah_alat[]']");
                const bahanTerpilih = document.querySelectorAll("#bodySelectedBahan input[name='jumlah_bahan[]']");
                const adaAlat = Array.from(alatTerpilih).some(input => parseInt(input.value, 10) > 0);
                const adaBahan = Array.from(bahanTerpilih).some(input => parseInt(input.value, 10) > 0);
                if (!adaAlat && !adaBahan) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Alat atau Bahan Belum Dipilih',
                        text: 'Pilih minimal satu alat atau satu bahan sebelum mengirim permohonan.',
                        confirmButtonColor: '#4f46e5'
                    });
                    return;
                }

                // 5. Validasi Tanda Tangan Digital
                if (!hasDrawn) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanda Tangan Belum Diisi',
                        text: 'Mohon bubuhkan tanda tangan digital Anda pada kolom yang disediakan sebelum mengirimkan permohonan peminjaman.',
                        confirmButtonColor: '#4f46e5'
                    });
                    return;
                }

                // 6. Kumpulkan Ringkasan Data yang Telah Diinput
                const nama = peminjamanForm.querySelector('[name="nama"]').value.trim();
                const prodiText = selectProgram.value ? selectProgram.options[selectProgram.selectedIndex].text : 'Umum / Non-Prodi';
                const matkulText = (selectMatkul.value && selectMatkul.value != "") ? selectMatkul.options[selectMatkul.selectedIndex].text : '-';
                const labText = selectLab.options[selectLab.selectedIndex]?.text || '-';
                const keperluan = peminjamanForm.querySelector('[name="keperluan"]').value.trim();

                let alatList = [];
                document.querySelectorAll("#bodySelectedAlat tr").forEach(tr => {
                    const nameEl = tr.querySelector(".item-name");
                    const qtyInput = tr.querySelector("input[name='jumlah_alat[]']");
                    if (nameEl && qtyInput && parseInt(qtyInput.value) > 0) {
                        alatList.push(`${nameEl.innerText.trim()} (${qtyInput.value} unit)`);
                    }
                });
                const alatSummary = alatList.length > 0 
                    ? `<span class="badge bg-primary bg-opacity-10 text-primary p-2 d-inline-block text-wrap text-start">${alatList.join(", ")}</span>`
                    : '<span class="text-muted fst-italic">Tanpa peralatan tambahan</span>';

                let bahanList = [];
                document.querySelectorAll("#bodySelectedBahan tr").forEach(tr => {
                    const nameEl = tr.querySelector(".item-name");
                    const qtyInput = tr.querySelector("input[name='jumlah_bahan[]']");
                    if (nameEl && qtyInput && parseInt(qtyInput.value) > 0) {
                        bahanList.push(`${nameEl.innerText.trim()} (${qtyInput.value})`);
                    }
                });
                const bahanSummary = bahanList.length > 0 
                    ? `<span class="badge bg-success bg-opacity-10 text-success p-2 d-inline-block text-wrap text-start">${bahanList.join(", ")}</span>`
                    : '<span class="text-muted fst-italic">Tanpa bahan tambahan</span>';

                // 6. Tampilkan Modal Konfirmasi / Review Sebelum Submit
                Swal.fire({
                    title: 'Konfirmasi Data Peminjaman',
                    imageUrl: "{{ asset('img/ushh.png') }}",
                    imageWidth: 64,
                    imageHeight: 64,
                    imageAlt: 'Logo USH',
                    customClass: {
                        image: 'swal2-ush-logo'
                    },
                    html: `
                        <div class="text-start font-13 text-secondary mb-3">
                            Mohon periksa kembali apakah data yang Anda isi sudah benar sebelum dikirimkan ke laboran:
                        </div>
                        <div class="card p-3 border rounded-3 text-start" style="background:#f8fafc; font-size:13px;">
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted">Nama Pemohon:</span>
                                <strong class="text-dark">${nama}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted">No. WhatsApp:</span>
                                <strong class="text-dark">${nomor}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted">Program Studi:</span>
                                <strong class="text-dark">${prodiText}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted">Laboratorium:</span>
                                <strong class="text-primary">${labText}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted">Mata Kuliah:</span>
                                <span class="text-secondary">${matkulText}</span>
                            </div>
                            <div class="d-flex justify-content-between py-1 border-bottom">
                                <span class="text-muted">Periode Pinjam:</span>
                                <strong class="text-dark">${tglPinjam} s/d ${tglKembali}</strong>
                            </div>
                            <div class="py-1 border-bottom">
                                <span class="text-muted d-block mb-1">Peralatan Dipinjam:</span>
                                <div>${alatSummary}</div>
                            </div>
                            <div class="py-1 border-bottom">
                                <span class="text-muted d-block mb-1">Bahan Digunakan:</span>
                                <div>${bahanSummary}</div>
                            </div>
                            <div class="py-1">
                                <span class="text-muted d-block">Keperluan:</span>
                                <div class="text-dark fw-semibold mt-1" style="white-space: pre-wrap;">${keperluan}</div>
                            </div>
                        </div>
                        <div class="mt-3 text-start small text-muted" style="font-size:11.5px;">
                            <i class="fa fa-info-circle text-primary me-1"></i> Data yang dikirim akan diverifikasi oleh Laboran USH sebelum disetujui.
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-paper-plane me-1"></i> Ya, Kirim Permohonan',
                    cancelButtonText: '<i class="fa fa-pen me-1"></i> Periksa Kembali',
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#64748b',
                    reverseButtons: true,
                    width: '520px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("signature-data").value = canvas.toDataURL("image/png");
                        isConfirmedSubmit = true;
                        peminjamanForm.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>