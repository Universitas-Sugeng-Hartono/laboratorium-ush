@extends('layout.home')
@section('inti')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Jurnal</a></li>
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
    <div class="row mb-3">
        <!-- Form Pencarian -->
        <div class="col-md-8">
            <form action="{{ route('jurnal.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                <div class="input-group w-100">
                    <label class="input-group-text">Lab</label>
                    <select name="lab_id" class="form-control">
                        <option value="">Pilih Lab</option>
                        @foreach ($labs as $lab)
                        <option value="{{ $lab->id }}" {{ request('lab_id') == $lab->id ? 'selected' : '' }}>
                            {{ $lab->laboratorium }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label class="input-group-text">Prodi</label>
                    <select name="program_id" class="form-control">
                        <option value="">Pilih Prodi</option>
                        @foreach ($programs as $program)
                        <option value="{{ $program->id }}"
                            {{ request('program_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->program }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label class="input-group-text">Dari</label>
                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="input-group">
                    <label class="input-group-text">Sampai</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>

                <button type="submit" class="btn btn-primary btn-rounded">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-4 d-flex justify-content-end gap-1">
            <form action="/jurnal-export-csv" method="GET">
                <input type="hidden" name="lab_id" value="{{ request('lab_id') }}">
                <input type="hidden" name="program_id" value="{{ request('program_id') }}">
                <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                <button type="submit" class="btn btn-success btn-rounded">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </form>
            <form action="/jurnal-export-pdf" method="GET" target="_blank">
                <input type="hidden" name="lab_id" value="{{ request('lab_id') }}">
                <input type="hidden" name="program_id" value="{{ request('program_id') }}">
                <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                <button type="submit" class="btn btn-danger btn-rounded">
                    <i class="fas fa-file-pdf"></i> Export Data
                </button>
            </form>
            <form action="/jurnal-export-pdf-no-ttd" method="GET" target="_blank">
                <input type="hidden" name="lab_id" value="{{ request('lab_id') }}">
                <input type="hidden" name="program_id" value="{{ request('program_id') }}">
                <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                <button type="submit" class="btn btn-warning btn-rounded">
                    <i class="fas fa-file-pdf"></i> Tanpa TTD
                </button>
            </form>
            <span class="btn btn-danger btn-rounded" style="cursor: pointer; border-radius: 15px;"
                data-bs-toggle="modal" data-bs-target="#statusModal">
                <i class="fas fa-file-pdf"></i> Jurnal
            </span>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Laboratorium</th>
                                <th>Mata Kuliah</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Jumlah Peserta</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jurnals as $key => $jurnal)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $jurnal->labId->laboratorium }}</td>
                                <td>{{ $jurnal->matkulId->matakuliah }}</td>
                                <td>{{ $jurnal->tanggal }}</td>
                                <td>{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</td>
                                <td>{{ $jurnal->jumlah }}</td>
                                <td>
                                    <a href="{{ route('jurnal.show', $jurnal->id) }}"
                                        class="btn btn-rounded btn-primary btn-sm" title="Lihat"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ route('jurnal.edit', $jurnal->id) }}"
                                        class="btn btn-rounded btn-warning btn-sm" title="Ubah"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-rounded btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')" title="Hapus"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $jurnals->links()}}
                            <div class="modal fade" id="statusModal" tabindex="-1"
                                aria-labelledby="statusModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/jurnal-perkuliahan-pdf" method="GET" target="_blank">
                                                <div class="mb-3">
                                                    <label for="waMessage" class="form-label">Mata Kuliah</label>
                                                    <select name="matakuliah_id[]" class="form-select" id="multiple-select-field" data-placeholder="Choose Matkul" multiple>
                                                        <option value="">-- Pilih Mata Kuliah --</option>
                                                        @foreach ($matkuls as $mk)
                                                        <option value="{{ $mk->id }}"
                                                            {{ request('matakuliah_id') == $mk->id ? 'selected' : '' }}>
                                                            {{ $mk->matakuliah }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-rounded btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit"
                                                        class="btn btn-rounded btn-danger">Export</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script>
$( '#multiple-select-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
    closeOnSelect: false,
} );
</script>
@endsection