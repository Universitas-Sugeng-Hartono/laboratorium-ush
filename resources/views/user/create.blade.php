@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Pengguna</a></li>
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
                    <h4>Create Pengguna</h4>
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nama <code>*</code></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Nama Lengkap">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Email <code>*</code></label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">NIK <code>*</code></label>
                                        <input type="number" name="nomor" id="nomor" class="form-control"
                                            placeholder="Nomer Induk Mahasiswa">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Password <code>*</code></label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Role <code>*</code></label>
                                    <select name="role" id="role" class="form-select mr-sm-2">
                                        <option selected="">Choose...</option>
                                        <option value="super">Super Admin</option>
                                        <option value="dosen">Kepala Program Studi</option>
                                        <option value="laboran">Laboran</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-primary mb-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection