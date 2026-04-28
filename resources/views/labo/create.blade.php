@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Laboratorium</a></li>
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
                    <h4>Create Laboratorium</h4>
                    <form action="{{ route('laboratorium.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Laboratorium</label>
                            <input type="text" name="laboratorium" id="laboratorium" class="form-control mb-3"
                                placeholder="Enter name" required>
                        </div>
                        <button type="submit" class="btn btn-rounded btn-primary mb-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection