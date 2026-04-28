@extends('layout.home')
@section('inti')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <!-- <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Form Input Grid</h4> -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html" class="text-muted">Pemakaian/Peminjaman</a>
                        </li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Detail Data</li>
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
                    <h4 class="card-title">Pemakaian/Peminjaman</h4>

                    <h5><strong>Nama:</strong> {{ $pemakaian->nama }}</h5>
                    <h5><strong>Laboratorium:</strong> {{ $pemakaian->labId->laboratorium }}</h5>
                    <h5><strong>Mata Kuliah:</strong>
                        {{ optional($pemakaian->matkulId)->matakuliah ?? 'Tidak ada Mata Kuliah' }}
                    </h5>

                    <h5><strong>Program:</strong> {{ $pemakaian->programId->program }}</h5>
                    <h5><strong>Keperluan:</strong> {{ $pemakaian->keperluan }}</h5>
                    <h5><strong>Tanggal Peminjaman:</strong>
                        {{ \Carbon\Carbon::parse($pemakaian->tgl_peminjaman)->format('d-m-Y') }}
                    </h5>
                    <h5><strong>Tanggal Pengembalian:</strong>
                        {{ \Carbon\Carbon::parse($pemakaian->tgl_pengembalian)->format('d-m-Y') }}
                    </h5>
                    <h5><strong>Alat:</strong></h5>
                    @if($alats->count())
                        <ul>
                            @foreach($alats as $alat)
                                <li>{{ $alat->alat }} (Jumlah: {{ $alat->jumlah_pinjam }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Tidak ada alat yang digunakan.</p>
                    @endif
                    
                    <h5><strong>Bahan:</strong></h5>
                    @if($bahans->count())
                        <ul>
                            @foreach($bahans as $bahan)
                                <li>{{ $bahan->bahan }} (Jumlah: {{ $bahan->jumlah_pakai }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Tidak ada bahan yang digunakan.</p>
                    @endif

                    <div class="mt-3">
                        <h5><strong>Tanda Tangan:</strong></h5>
                        @if ($pemakaian->ttd)
                        <img src="{{ asset('/storage/app/public/' . $pemakaian->ttd) }}" width="200">
                        @else
                        <p class="text-muted">Belum ada tanda tangan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection