@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Mata Kuliah</a></li>
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
                    <h4>Create Mata Kuliah</h4>
                    <form action="{{ route('matkul.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Mata Kuliah</label>
                            <input type="text" name="matakuliah" id="matakuliah" class="form-control mb-3"
                                placeholder="Enter Mata Kuliah" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Dosen</label>
                            <input type="text" name="dosen" id="dosen" class="form-control mb-3"
                                placeholder="Enter Dosen" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nomor HP</label>
                            <input type="number" name="nomor" id="nomor" class="form-control mb-3"
                                placeholder="Dengan mengetikan 628xxxxxxxx">
                        </div>
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Program Studi</label>
                            <select name="program_id" class="form-control">
                                <option value="">Pilih Program Studi</option>
                                @foreach($programs as $program)
                                <option value="{{ $program->id }}">{{ $program->program }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-primary mb-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection