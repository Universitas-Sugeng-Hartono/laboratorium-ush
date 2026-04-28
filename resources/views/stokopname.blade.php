<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <title>SILABO USH</title>

    <style>
    body {
        margin: 0;
        background-color: #f4f4f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        display: none;
        /* Disembunyikan sebelum muncul */
        width: 100%;
        animation: fadeIn 1s ease forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background: white;
    }

    .card-header {
        background-color: #007bff;
        color: white;
        padding: 15px;
        border-radius: 8px 8px 0 0;
        text-align: center;
    }

    #searchInput {
        background-color: white !important;
        color: black;
        border: 1px solid #ccc;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Stok Opname Bahan</h5>
                <input type="text" id="searchInput" class="form-control w-25" placeholder="Cari Nama Bahan..."
                    style="background-color: white;">
            </div>
            <div class="card-body">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Bahan</th>
                            <th>Jumlah Stok</th>
                        </tr>
                    </thead>
                    <tbody id="bahanTable">
                        @foreach($bahan as $key => $ba)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $ba->kode }}</td>
                            <td class="nama-bahan">{{ $ba->bahan }}</td>
                            <td>{{ $ba->jumlah }}{{ $ba->satuan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    // Menampilkan card setelah halaman selesai dimuat
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector(".container").style.display = "block";
    });
    </script>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#bahanTable tr");

        rows.forEach(row => {
            let namaBahan = row.querySelector(".nama-bahan").textContent.toLowerCase();
            row.style.display = namaBahan.includes(filter) ? "" : "none";
        });
    });
    </script>

</body>

</html>