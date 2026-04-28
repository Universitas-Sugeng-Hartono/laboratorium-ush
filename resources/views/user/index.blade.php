@extends('layout.home')
@section('inti')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <h4 class="page-title">Daftar Pengguna</h4>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Pengguna</h4>
                    <div class="d-flex">
                        <a href="{{ route('user.create') }}" class="btn btn-rounded btn-primary mb-3 me-3">Create
                            Pengguna</a>
                        <!-- <button type="button" class="btn btn-rounded btn-success mb-3" data-bs-toggle="modal"
                            data-bs-target="#importCsvModal">
                            Import CSV
                        </button> -->
                    </div>
                    <!-- <div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="importCsvModalLabel">Upload CSV File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="csv_file">Upload CSV File:</label>
                                            <input type="file" name="csv_file" id="csv_file" class="form-control"
                                                required>
                                        </div>
                                        <code>Contoh format <a href="Format Contoh.csv">Download</a></code>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-rounded btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-rounded btn-primary">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> -->
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dosen</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }} / {{ $item->nomor }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>
                                        <a href="{{ route('user.edit', $item->id) }}"
                                            class="btn btn-rounded btn-warning btn-sm">Edit</a>
                                        <form onsubmit="return confirm('Apakah anda yakin ingin menghapus ?');"
                                            action="{{ route('user.destroy',$item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-rounded btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                            @empty
                            <div class="bg-red-500 text-white p-3 rounded shadow-sm mb-3">
                                Data Belum Tersedia!
                            </div>
                            @endforelse
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $user->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection