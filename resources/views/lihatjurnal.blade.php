<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Jurnal</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <link href="{{asset('dist/css/style.min.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.0.0/signature_pad.umd.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <div class="card">
             @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Hasil Jurnal</h4>
            </div>
            <div class="card-body">
                @foreach ($jurnals as $jurnal)
                    <h5><strong>Laboratorium:</strong> {{ $jurnal->labId->laboratorium }}</h5>
                    <h5><strong>Mata Kuliah:</strong> {{ $jurnal->matkulId->matakuliah }}</h5>
                    <h5><strong>Program:</strong> {{ $jurnal->programId->program }}</h5>
                    <h5><strong>Materi:</strong> {{ $jurnal->materi }}</h5>
                    <h5><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d-m-Y') }}</h5>
                    <h5><strong>Jam Mulai:</strong> {{ $jurnal->jam_mulai }}</h5>
                    <h5><strong>Jam Selesai:</strong> {{ $jurnal->jam_selesai }}</h5>
                    <h5><strong>Jumlah Peserta:</strong> {{ $jurnal->jumlah }}</h5>
                    <div class="mt-3">
                        <h5><strong>Tanda Tangan:</strong></h5>
                        @if ($jurnal->ttd)
                            <img src="{{ asset('storage/app/public/' . $jurnal->ttd) }}" width="200">
                        @else
                            <p class="text-muted">Belum ada tanda tangan</p>
                        @endif
                    </div>
                    <hr>
                
                @if ($jurnals->isEmpty())
                    <p class="text-danger">Tidak ada jurnal yang tersedia.</p>
                @endif

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal{{ $jurnal->id }}">
                        Edit
                    </button>&nbsp;
                    <a href="{{ url()->previous() }}" class="btn btn-rounded btn-secondary btn-sm">Back</a>
                </div>
                @endforeach
            </div>
            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $jurnal->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $jurnal->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                       <form action="/jurnal/{{ $jurnal->id }}/update" method="POST">
                        @csrf
                        @method('PUT')
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="editModalLabel{{ $jurnal->id }}">Edit Jurnal</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="materi" class="form-label">Materi</label>
                                    <textarea class="form-control" name="materi" required>{{ $jurnal->materi }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Peserta</label>
                                    <input type="number" class="form-control" name="jumlah" min="1" value="{{ $jurnal->jumlah }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-sm btn-rounded" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success btn-sm btn-rounded">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{asset('dist/js/feather.min.js') }}"></script>
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{asset('dist/js/custom.min.js') }}"></script>

</body>

</html>