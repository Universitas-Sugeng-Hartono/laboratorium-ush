@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Jadwal Praktikum</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4>Tambah Jadwal</h4>
                    <form action="{{ route('jadwal.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Laboratorium</label>
                            <select name="lab_id" class="form-control">
                                <option value="">Pilih Laboratorium</option>
                                @foreach($lab as $labs)
                                <option value="{{ $labs->id }}">{{ $labs->laboratorium }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Program</label>
                            <select name="program_id" class="form-control">
                                <option value="">Pilih Program Studi</option>
                                @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->program }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="matakuliah_id" class="form-label">Mata Kuliah</label>
                            <select name="matakuliah_id" id="matakuliah_id" class="form-control">
                                <option value="">-- Pilih Program Studi dahulu --</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jadwal" class="form-label">Jadwal</label>
                            <input type="datetime-local" name="jadwal" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('select[name="program_id"]').addEventListener('change', function() {
    const programId = this.value;
    const matkulSelect = document.getElementById('matakuliah_id');

    matkulSelect.innerHTML = '<option value="">Memuat...</option>';

    if (!programId) {
        matkulSelect.innerHTML = '<option value="">-- Pilih Program Studi dahulu --</option>';
        return;
    }

    fetch('/api/matkul-by-program/' + programId)
        .then(response => response.json())
        .then(data => {
            matkulSelect.innerHTML = '<option value="">Pilih Mata Kuliah</option>';
            data.forEach(function(matkul) {
                matkulSelect.innerHTML += '<option value="' + matkul.id + '">' + matkul.matakuliah + '</option>';
            });
            if (data.length === 0) {
                matkulSelect.innerHTML = '<option value="">-- Tidak ada mata kuliah --</option>';
            }
        })
        .catch(() => {
            matkulSelect.innerHTML = '<option value="">-- Gagal memuat data --</option>';
        });
});
</script>
@endsection