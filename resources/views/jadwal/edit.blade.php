@extends('layout.home')
@section('inti')
<style>
    .card-modern-form {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13.5px;
        padding: 9px 13px;
        color: #1e293b;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }
    .form-label {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-text {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 4px;
    }
    .btn-modern-primary {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 9px 22px;
        font-size: 13.5px;
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-modern-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        color: #ffffff;
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
    }
    .btn-modern-light {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 13.5px;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }
    .btn-modern-light:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .badge-ta {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        background: #dbeafe;
        color: #1e40af;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
    }
</style>

<!-- Breadcrumb -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Ubah Jadwal Praktikum</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jadwal.index') }}" class="text-muted">Jadwal Praktikum</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Ubah Jadwal</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9 col-xl-8 mx-auto">

            @if (isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
                <div class="d-flex align-items-center mb-1">
                    <i class="fas fa-exclamation-circle me-2 font-16"></i>
                    <strong>Mohon periksa kembali isian formulir:</strong>
                </div>
                <ul class="mb-0 ps-3 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle me-2 font-16"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <div class="card-modern-form">
                <div class="p-4 border-bottom bg-light bg-opacity-50 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-1"><i class="fas fa-edit text-primary me-2"></i>Form Ubah Jadwal Praktikum</h5>
                        <p class="text-muted small mb-0">Perbarui detail waktu, laboratorium, atau mata kuliah pertemuan ini.</p>
                    </div>
                    @if (isset($taAktif) && $taAktif)
                    <span class="badge-ta">
                        <i class="fas fa-check-circle"></i> TA Aktif: {{ $taAktif->ta }}
                    </span>
                    @endif
                </div>

                <div class="p-4">
                    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="lab_id" class="form-label">Laboratorium <span class="text-danger">*</span></label>
                                <select name="lab_id" id="lab_id" class="form-select" required>
                                    <option value="">-- Pilih Laboratorium --</option>
                                    @foreach($lab as $labs)
                                    <option value="{{ $labs->id }}" {{ old('lab_id', $jadwal->lab_id) == $labs->id ? 'selected' : '' }}>
                                        {{ $labs->laboratorium }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="program_id" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                <select name="program_id" id="program_id" class="form-select" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id', $jadwal->program_id) == $program->id ? 'selected' : '' }}>
                                        {{ $program->program }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="matakuliah_id" class="form-label">Mata Kuliah <span class="text-danger">*</span></label>
                                <select name="matakuliah_id" id="matakuliah_id" class="form-select" required>
                                    @foreach($matkuls as $matkul)
                                    <option value="{{ $matkul->id }}" {{ old('matakuliah_id', $jadwal->matakuliah_id) == $matkul->id ? 'selected' : '' }}>
                                        {{ $matkul->matakuliah }}{{ $matkul->dosen ? ' (Dosen: ' . $matkul->dosen . ')' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                <select name="semester" id="semester" class="form-select" required>
                                    <option value="">-- Pilih Semester --</option>
                                    @for ($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ (string) old('semester', $jadwal->semester) === (string) $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="kelas" class="form-label">Kelas <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="text" name="kelas" id="kelas" class="form-control" maxlength="1" value="{{ old('kelas', $jadwal->kelas) }}" placeholder="A">
                                <div class="form-text">Satu huruf, misalnya A. Kosongkan jika tidak ada kelas.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="jadwal" class="form-label">Tanggal & Jam Mulai <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="jadwal" id="jadwal" class="form-control"
                                    value="{{ old('jadwal', date('Y-m-d\TH:i', strtotime($jadwal->jadwal))) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="jam_selesai" class="form-label">Jam Selesai <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control"
                                    value="{{ old('jam_selesai', $jadwal->jam_selesai ? \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') : '') }}"
                                    placeholder="Otomatis jika kosong">
                                <div class="form-text" id="jamSelesaiHint">
                                    Bila dikosongkan, durasi dihitung otomatis 170 menit (2 jam 50 menit).
                                </div>
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: #f1f5f9;">

                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('jadwal.index') }}" class="btn btn-light border px-4 py-2 font-13 fw-medium" style="border-radius: 8px;">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 py-2 font-13 fw-semibold shadow-sm" style="border-radius: 8px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none;">
                                Perbarui Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const programSelect = document.getElementById('program_id');
    const matkulSelect = document.getElementById('matakuliah_id');
    const jadwalInput = document.getElementById('jadwal');
    const jamSelesaiInput = document.getElementById('jam_selesai');
    const jamSelesaiHint = document.getElementById('jamSelesaiHint');
    const currentMatkulId = "{{ old('matakuliah_id', $jadwal->matakuliah_id) }}";

    function loadMatkul(programId, selectedId = null) {
        if (!programId) {
            matkulSelect.innerHTML = '<option value="">-- Pilih Program Studi terlebih dahulu --</option>';
            return;
        }

        matkulSelect.innerHTML = '<option value="">Memuat daftar mata kuliah...</option>';

        fetch('/api/matkul-by-program/' + programId)
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                if (!data || data.length === 0) {
                    matkulSelect.innerHTML = '<option value="">-- Tidak ada mata kuliah di prodi ini untuk TA aktif --</option>';
                    return;
                }

                let options = '<option value="">-- Pilih Mata Kuliah --</option>';
                data.forEach(function(matkul) {
                    const isSelected = (selectedId && String(matkul.id) === String(selectedId)) ? 'selected' : '';
                    const dosenText = matkul.dosen ? ' (Dosen: ' + matkul.dosen + ')' : '';
                    options += `<option value="${matkul.id}" ${isSelected}>${matkul.matakuliah}${dosenText}</option>`;
                });
                matkulSelect.innerHTML = options;
            })
            .catch(() => {
                matkulSelect.innerHTML = '<option value="">-- Gagal memuat mata kuliah, coba lagi --</option>';
            });
    }

    if (programSelect) {
        programSelect.addEventListener('change', function() {
            loadMatkul(this.value, currentMatkulId);
        });
    }

    // Auto-calculate helper preview when start time changes
    if (jadwalInput) {
        jadwalInput.addEventListener('change', function() {
            if (!this.value) return;
            const startDate = new Date(this.value);
            if (isNaN(startDate.getTime())) return;

            const endDate = new Date(startDate.getTime() + 170 * 60000);
            const hours = String(endDate.getHours()).padStart(2, '0');
            const minutes = String(endDate.getMinutes()).padStart(2, '0');
            const endTimeStr = `${hours}:${minutes}`;

            if (!jamSelesaiInput.value) {
                jamSelesaiHint.innerHTML = `Otomatis dihitung selesai pukul <strong>${endTimeStr}</strong> (+170 menit). Atau tentukan jam khusus di atas.`;
            }
        });

        if (jamSelesaiInput) {
            jamSelesaiInput.addEventListener('input', function() {
                if (this.value) {
                    jamSelesaiHint.innerHTML = `Jam selesai ditentukan manual: <strong>${this.value}</strong>.`;
                } else {
                    jamSelesaiHint.innerHTML = 'Opsional: Kosongkan untuk otomatis dihitung <span class="text-primary font-weight-bold">+170 menit</span>.';
                    jadwalInput.dispatchEvent(new Event('change'));
                }
            });
        }
    }
});
</script>
@endsection