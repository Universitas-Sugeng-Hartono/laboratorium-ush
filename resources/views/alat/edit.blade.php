@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted"> Inventari Alat</a></li>
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
                    <h4>Ubah Inventari Alat</h4>
                    <form action="{{ route('alat.update', $alat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Kode Alat</label>
                            <input type="text" name="kode" id="kode" class="form-control mb-3" placeholder="Enter Code"
                                value="{{ $alat->kode }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Alat</label>
                            <input type="text" name="alat" id="alat" class="form-control mb-3" placeholder="Enter name"
                                value="{{ $alat->alat }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Jumlah Alat</label>
                            <input type="text" name="jumlah" id="jumlah" class="form-control mb-3"
                                placeholder="Enter Jumlah" value="{{ $alat->jumlah }}" required>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-primary mb-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection