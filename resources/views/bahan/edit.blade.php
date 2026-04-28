@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted"> Bahan</a></li>
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
                    <h4>Ubah Bahan</h4>
                    <form action="{{ route('bahan.update', $bahan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Kode Bahan</label>
                            <input type="text" name="kode" id="kode" class="form-control mb-3" placeholder="Enter Code"
                                value="{{ $bahan->kode }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Bahan</label>
                            <input type="text" name="bahan" id="bahan" class="form-control mb-3"
                                placeholder="Enter name" value="{{ $bahan->bahan }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Jumlah Bahan</label>
                            <input type="text" name="jumlah" id="jumlah" class="form-control mb-3"
                                placeholder="Enter Jumlah" value="{{ $bahan->jumlah }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Satuan Bahan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control mb-3"
                                placeholder="Kg/gr/Pack/Liter dll" value="{{ $bahan->satuan }}" required>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-primary mb-3">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection