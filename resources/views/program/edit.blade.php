@extends('layout.home')
@section('inti')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a href="index.html" class="text-muted"> Program Studi</a></li>
                            <li class="breadcrumb-item text-muted active" aria-current="page">Ubah</li>
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
                        <h4>Ubah Program Studi</h4>
                        <form action="{{ route('program.update', $program->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nama Prodi</label>
                                <input type="text" name="program" id="program" class="form-control mb-3"
                                    placeholder="Enter name" value="{{ $program->program }}" required>
                            </div>
                            <button type="submit" class="btn btn-rounded btn-primary mb-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection