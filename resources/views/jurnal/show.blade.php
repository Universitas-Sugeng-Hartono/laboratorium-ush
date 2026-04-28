@extends('layout.home')
@section('inti')
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
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Detail Jurnal</h5>
                    <p><strong>Laboratorium:</strong> {{ $jurnal->labId->laboratorium }}</p>
                    <p><strong>Mata Kuliah:</strong> {{ $jurnal->matkulId->matakuliah }}</p>
                    <p><strong>Program Studi:</strong> {{ $jurnal->programId->program }}</p>
                    <p><strong>Tanggal:</strong> {{ $jurnal->tanggal }}</p>
                    <p><strong>Jam:</strong> {{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</p>
                    <p><strong>Jumlah Peserta:</strong> {{ $jurnal->jumlah }}</p>

                    <h5><strong>Tanda Tangan:</strong></h5>
                    @if ($jurnal->ttd)
                    <img src="{{ asset('storage/app/public/' . $jurnal->ttd) }}" width="200">
                    @else
                    <p class="text-muted">Belum ada tanda tangan</p>
                    @endif
                    <div class="modal-footer">
                        <a href="{{ route('jurnal.index') }}" class="btn btn-rounded btn-secondary btn-sm">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection