@extends('layout.home')
@section('inti')
<style>
        .table-responsive {
            overflow-x: auto;
        }
</style>
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Bahan</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Data</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(session('import_errors'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Detail baris gagal:</strong>
        <ul class="mb-0 mt-2">
            @foreach(session('import_errors') as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="row mb-3">
        <!-- Form Pencarian -->
        <div class="col-md-8">
            <form action="{{ route('jadwal.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                <div class="input-group w-100">
                    <label class="input-group-text">Lab</label>
                    <select name="lab_id" class="form-control">
                        <option value="">-- Pilih Lab --</option>
                        @foreach ($labs as $lab)
                        <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                            {{ $lab->laboratorium }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group w-100">
                    <label class="input-group-text">Prodi</label>
                    <select name="program_id" class="form-control">
                        <option value="">-- Pilih Program --</option>
                        @foreach ($programs as $program)
                        <option value="{{ $program->id }}"
                            {{ request('program_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->program }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group w-100">
                    <label class="input-group-text">Tanggal</label>
                    <input type="date" name="jadwal" class="form-control" value="{{ request('jadwal') }}">
                </div>
                <button type="submit" class="btn btn-primary btn-rounded">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Jadwal Praktikum</h4>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="{{ route('jadwal.create') }}" class="btn btn-rounded btn-primary">Tambah Jadwal</a>
                        <button type="button" class="btn btn-rounded btn-success" data-bs-toggle="modal"
                            data-bs-target="#importJadwalModal">
                            Import CSV
                        </button>
                    </div>
                    <div class="modal fade" id="importJadwalModal" tabindex="-1" aria-labelledby="importJadwalModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importJadwalModalLabel">Import Jadwal dari CSV</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('jadwal.import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted small">
                                            Setiap baris CSV akan membuat <strong>8 jadwal mingguan</strong> (sama seperti tambah manual).
                                            Kolom wajib: <code>lab_id</code>, <code>program_id</code>, <code>matakuliah_id</code>, <code>tanggal</code>, <code>jam</code>.
                                        </p>
                                        <div class="mb-3">
                                            <label for="csv_file" class="form-label">File CSV</label>
                                            <input type="file" name="csv_file" id="csv_file" class="form-control"
                                                accept=".csv,.txt" required>
                                            @error('csv_file')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <a href="{{ asset('templates/jadwal_import_template.csv') }}" class="small" download>
                                            Download template CSV
                                        </a>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-rounded btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-rounded btn-primary">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mata Kuliah</th>
                                <th>Lab</th>
                                <th>Jadwal</th>
                                <th>Program</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwals as $jadwal)
                            <tr>
                                <td>{{ $jadwal->id }}</td>
                                <td>{{ $jadwal->matkulId->matakuliah }}</td>
                                <td>{{ $jadwal->labId->laboratorium }}</td>
                                <td>{{ $jadwal->jadwal }}</td>
                                <td>{{ $jadwal->programId->program }}</td>
                                <td>
                                    <button class="btn btn-rounded btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editStatusModal{{ $jadwal->id }}" title="Reschedule"><i
                                            class="fas fa-calendar"></i>
                                    </button>
                                    <!-- popup -->
                                    <div class="modal fade" id="editStatusModal{{ $jadwal->id }}" tabindex="-1"
                                        aria-labelledby="editStatusLabel{{ $jadwal->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editStatusLabel{{ $jadwal->id }}">Ubah
                                                        Status Penjadwalan
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="tanggal" class="form-label">Tanggal</label>
                                                            <input type="datetime-local" name="jadwal"
                                                                class="form-control" value="{{ $jadwal->jadwal }}"
                                                                required>
                                                            <input type="hidden" class="form-control" name="lab_id"
                                                                value="{{ $jadwal->lab_id }}" required>
                                                            <input type="hidden" class="form-control"
                                                                name="matakuliah_id"
                                                                value="{{ $jadwal->matakuliah_id }}" required>
                                                            <input type="hidden" class="form-control" name="program_id"
                                                                value="{{ $jadwal->program_id }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-rounded btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-rounded btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('jadwal.edit', $jadwal->id) }}"
                                        class="btn btn-rounded btn-warning btn-sm" title="Ubah"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-rounded btn-danger btn-sm" title="Hapus"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", function(event) {
        console.log("Form Submitted:", this);
    });
});
</script>
@endsection