@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Tambah Jurnal Praktikum</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jurnal.index') }}" class="text-muted">Jurnal</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Tambah Baru</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1 text-dark fw-bold">Formulir Jurnal Perkuliahan & Praktikum</h5>
                            <p class="text-muted small mb-0">Catat pelaksanaan praktikum harian, kehadiran mahasiswa, dan tanda tangan dosen/asisten.</p>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill font-12 fw-semibold">
                            <i class="fa fa-calendar-check me-1"></i> TA Aktif: {{ $taAktif->ta ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="fa fa-circle-exclamation fs-5"></i>
                            <strong>Periksa kembali data yang dimasukkan:</strong>
                        </div>
                        <ul class="mb-0 ps-4 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('jurnal.store') }}" method="POST" enctype="multipart/form-data" id="formJurnal">
                        @csrf

                        <!-- Quick Schedule Selector -->
                        <div class="p-3 mb-4 rounded-3 border" style="background-color: #f8fafc; border-color: #e2e8f0;">
                            <label for="jadwal_select" class="form-label fw-bold text-dark font-13 mb-1">
                                <i class="fa fa-link text-primary me-1"></i> Hubungkan dengan Jadwal Praktikum (Opsional)
                            </label>
                            <p class="text-muted font-11 mb-2">Pilih jadwal yang sudah ada untuk mengisi Mata Kuliah, Laboratorium, Prodi, Tanggal, dan Jam secara otomatis.</p>
                            @if(!empty($peringatanTa))
                            <p class="text-warning font-12 mb-2"><i class="fa fa-exclamation-triangle me-1"></i>{{ $peringatanTa }}</p>
                            @endif
                            <select name="jadwal_id" id="jadwal_select" class="form-select font-13">
                                <option value="">-- Input Manual (Bukan dari Jadwal Terjadwal) --</option>
                                @foreach($jadwals as $j)
                                    @php
                                        $jDate = \Carbon\Carbon::parse($j->jadwal);
                                        $isSel = old('jadwal_id', $selectedJadwal->id ?? '') == $j->id;
                                    @endphp
                                    <option value="{{ $j->id }}"
                                        data-matkul="{{ $j->matakuliah_id }}"
                                        data-program="{{ $j->program_id }}"
                                        data-lab="{{ $j->lab_id }}"
                                        data-tanggal="{{ $jDate->format('Y-m-d') }}"
                                        data-jam="{{ $jDate->format('H:i') }}"
                                        data-jam-selesai="{{ $j->jam_selesai_formatted }}"
                                        {{ $isSel ? 'selected' : '' }}>
                                        [{{ $jDate->translatedFormat('d M Y') }} | {{ $j->jam_mulai }} &ndash; {{ $j->jam_selesai_formatted }}] — {{ optional($j->matkulId)->matakuliah ?? 'Mata Kuliah' }} ({{ optional($j->matkulId)->dosen ?? '-' }}) | {{ optional($j->labId)->laboratorium ?? 'Lab' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-3">
                            <!-- Mata Kuliah -->
                            <div class="col-md-6">
                                <label for="matakuliah_id" class="form-label fw-semibold text-dark font-13">
                                    Mata Kuliah <span class="text-danger">*</span>
                                </label>
                                <select name="matakuliah_id" id="matakuliah_id" class="form-select font-13" required>
                                    <option value="">-- Pilih Mata Kuliah --</option>
                                    @foreach($matkuls as $m)
                                    <option value="{{ $m->id }}"
                                        data-program="{{ $m->program_id }}"
                                        {{ old('matakuliah_id', $selectedJadwal->matakuliah_id ?? '') == $m->id ? 'selected' : '' }}>
                                        {{ $m->matakuliah }} (Dosen: {{ $m->dosen }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Program Studi -->
                            <div class="col-md-6">
                                <label for="program_id" class="form-label fw-semibold text-dark font-13">
                                    Program Studi <span class="text-danger">*</span>
                                </label>
                                <select name="program_id" id="program_id" class="form-select font-13" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach($programs as $p)
                                    <option value="{{ $p->id }}" {{ old('program_id', $selectedJadwal->program_id ?? '') == $p->id ? 'selected' : '' }}>
                                        {{ $p->program }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Laboratorium -->
                            <div class="col-md-6">
                                <label for="lab_id" class="form-label fw-semibold text-dark font-13">
                                    Laboratorium <span class="text-danger">*</span>
                                </label>
                                <select name="lab_id" id="lab_id" class="form-select font-13" required>
                                    <option value="">-- Pilih Laboratorium --</option>
                                    @foreach($labs as $l)
                                    <option value="{{ $l->id }}" {{ old('lab_id', $selectedJadwal->lab_id ?? '') == $l->id ? 'selected' : '' }}>
                                        {{ $l->laboratorium }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tanggal -->
                            <div class="col-md-6">
                                <label for="tanggal" class="form-label fw-semibold text-dark font-13">
                                    Tanggal Pelaksanaan <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control font-13"
                                    value="{{ old('tanggal', $selectedJadwal ? \Carbon\Carbon::parse($selectedJadwal->jadwal)->format('Y-m-d') : date('Y-m-d')) }}" required>
                            </div>

                            <!-- Jam Mulai & Jam Selesai -->
                            <div class="col-md-4">
                                <label for="jam_mulai" class="form-label fw-semibold text-dark font-13">
                                    Jam Mulai <span class="text-danger">*</span>
                                </label>
                                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control font-13"
                                    value="{{ old('jam_mulai', $selectedJadwal ? \Carbon\Carbon::parse($selectedJadwal->jadwal)->format('H:i') : date('H:i')) }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="jam_selesai" class="form-label fw-semibold text-dark font-13">
                                    Jam Selesai
                                </label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control font-13"
                                    value="{{ old('jam_selesai') }}" placeholder="Otomatis terhitung jika kosong">
                                <span class="text-muted font-11 d-block mt-1">Opsional (default: +2 jam 50 mnt)</span>
                            </div>

                            <!-- Jumlah Peserta -->
                            <div class="col-md-4">
                                <label for="jumlah" class="form-label fw-semibold text-dark font-13">
                                    Jumlah Mahasiswa Hadir
                                </label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control font-13" min="0"
                                    placeholder="Contoh: 30" value="{{ old('jumlah') }}">
                            </div>

                            <!-- Materi Praktikum -->
                            <div class="col-12">
                                <label for="materi" class="form-label fw-semibold text-dark font-13">
                                    Materi / Pokok Bahasan Praktikum <span class="text-danger">*</span>
                                </label>
                                <textarea name="materi" id="materi" rows="3" class="form-control font-13"
                                    placeholder="Tuliskan topik, modul, atau bahasan praktikum yang dipelajari..." required>{{ old('materi') }}</textarea>
                            </div>

                            <!-- Tanda Tangan Section -->
                            <div class="col-12 mt-4 pt-3 border-top">
                                <label class="form-label fw-semibold text-dark font-13 mb-1">
                                    Tanda Tangan Dosen / Asisten (Digital Pad atau Upload File)
                                </label>
                                <p class="text-muted font-11 mb-3">Tanda tangani langsung di canvas menggunakan mouse / touchscreen, atau unggah gambar tanda tangan yang sudah ada.</p>

                                <ul class="nav nav-pills mb-3" id="ttdTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active btn-sm font-12 py-1 px-3" id="pad-tab" data-bs-toggle="pill" data-bs-target="#tab-pad" type="button" role="tab">
                                            <i class="fa fa-pen-nib me-1"></i> Tanda Tangan Digital (Canvas)
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link btn-sm font-12 py-1 px-3" id="file-tab" data-bs-toggle="pill" data-bs-target="#tab-file" type="button" role="tab">
                                            <i class="fa fa-upload me-1"></i> Unggah File Gambar
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="ttdTabContent">
                                    <!-- Pad Tab -->
                                    <div class="tab-pane fade show active" id="tab-pad" role="tabpanel">
                                        <div class="border rounded-3 p-2 bg-light d-inline-block">
                                            <canvas id="signatureCanvas" width="460" height="180" class="border bg-white rounded-2" style="touch-action: none; cursor: crosshair; display: block;"></canvas>
                                        </div>
                                        <input type="hidden" name="ttd_signature" id="ttd_signature">
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary font-12 rounded-pill px-3" id="btnClearPad">
                                                <i class="fa fa-rotate-left me-1"></i> Hapus Goresan
                                            </button>
                                            <span class="text-muted font-11 ms-2">Goreskan tanda tangan di dalam kotak putih.</span>
                                        </div>
                                    </div>

                                    <!-- File Upload Tab -->
                                    <div class="tab-pane fade" id="tab-file" role="tabpanel">
                                        <div class="col-md-6">
                                            <input type="file" name="ttd" id="ttd_file" class="form-control font-13" accept="image/png,image/jpeg">
                                            <span class="text-muted font-11 d-block mt-1">Format gambar: JPG, PNG (Maksimal 2 MB).</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('jurnal.index') }}" class="btn btn-outline-secondary font-13 px-4 rounded-pill">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary font-13 px-4 rounded-pill shadow-sm fw-semibold" id="btnSubmit">
                                <i class="fa fa-check me-1"></i> Simpan Jurnal Praktikum
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Auto-fill from Jadwal Selector
    const jadwalSelect = document.getElementById('jadwal_select');
    const matkulSelect = document.getElementById('matakuliah_id');
    const programSelect = document.getElementById('program_id');
    const labSelect = document.getElementById('lab_id');
    const tanggalInput = document.getElementById('tanggal');
    const jamMulaiInput = document.getElementById('jam_mulai');
    const jamSelesaiInput = document.getElementById('jam_selesai');

    if (jadwalSelect) {
        jadwalSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            if (selected && selected.value) {
                const matkulId = selected.getAttribute('data-matkul');
                const programId = selected.getAttribute('data-program');
                const labId = selected.getAttribute('data-lab');
                const tanggal = selected.getAttribute('data-tanggal');
                const jam = selected.getAttribute('data-jam');
                const jamSelesai = selected.getAttribute('data-jam-selesai');

                if (matkulId) matkulSelect.value = matkulId;
                if (programId) programSelect.value = programId;
                if (labId) labSelect.value = labId;
                if (tanggal) tanggalInput.value = tanggal;
                if (jam) jamMulaiInput.value = jam;
                if (jamSelesai && jamSelesaiInput) jamSelesaiInput.value = jamSelesai;
            }
        });
    }

    // 2. Auto-sync program from selected matkul
    if (matkulSelect) {
        matkulSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            if (selected && selected.value) {
                const progId = selected.getAttribute('data-program');
                if (progId && programSelect) {
                    programSelect.value = progId;
                }
            }
        });
    }

    // 3. Signature Pad Canvas logic
    const canvas = document.getElementById('signatureCanvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        ctx.strokeStyle = '#0f172a';
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';

        let isDrawing = false;
        let hasDrawn = false;

        function getPos(e) {
            const rect = canvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return {
                x: clientX - rect.left,
                y: clientY - rect.top
            };
        }

        function startDraw(e) {
            isDrawing = true;
            const pos = getPos(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            e.preventDefault();
        }

        function draw(e) {
            if (!isDrawing) return;
            const pos = getPos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            hasDrawn = true;
            e.preventDefault();
        }

        function stopDraw() {
            if (!isDrawing) return;
            isDrawing = false;
        }

        canvas.addEventListener('mousedown', startDraw);
        canvas.addEventListener('mousemove', draw);
        window.addEventListener('mouseup', stopDraw);

        canvas.addEventListener('touchstart', startDraw, { passive: false });
        canvas.addEventListener('touchmove', draw, { passive: false });
        window.addEventListener('touchend', stopDraw);

        const btnClear = document.getElementById('btnClearPad');
        if (btnClear) {
            btnClear.addEventListener('click', function () {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById('ttd_signature').value = '';
                hasDrawn = false;
            });
        }

        // On form submit, if drawn on canvas, save to hidden input
        const form = document.getElementById('formJurnal');
        if (form) {
            form.addEventListener('submit', function () {
                if (hasDrawn) {
                    document.getElementById('ttd_signature').value = canvas.toDataURL('image/png');
                }
            });
        }
    }
});
</script>
@endsection
