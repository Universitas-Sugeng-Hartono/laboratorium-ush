<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SILABO USH</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
    body {
        margin: 0;
        background-color: #2d9fc2;
        background-image: url('https://www.transparenttextures.com/patterns/diagmonds.png');
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
    }

    .container {
        width: 80%;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
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
        padding: 30px;
        border-radius: 12px;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        transition: transform 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card h3 {
        margin-top: 15px;
        font-size: 20px;
    }

    .blue-dark {
        background-color: #003366;
    }

    .blue-light {
        background-color: #077194;
    }

    .blue-lightx {
        background-color: #0099cc;
    }

    .card a {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 20px;
        background-color: white;
        color: #003366;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background 0.3s ease;
    }

    .card a:hover {
        background-color: #f4f4f9;
    }

    @media (max-width: 768px) {
        .container {
            grid-template-columns: 1fr;
            width: 90%;
        }
    }
    </style>
</head>

<body>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="container">
        <div class="card blue-dark">
            <i class="fas fa-book fa-3x"></i>
            <h4>Jurnal Laboratorium</h4>
            <a href="/jadwallab">Lihat Jurnal</a>
        </div>
        <div class="card blue-light">
            <i class="fas fa-calendar-check fa-3x"></i>
            <h4>Daftar Tamu</h4>
            <a href="/tamuumum">Tambah Tamu <code>umum</code></a>
        </div>
        <div class="card blue-light">
            <i class="fas fa-calendar-check fa-3x"></i>
            <h4>Peminjaman</h4>
            <a href="/lihatpeminjaman">Bikin Peminjaman</a>
        </div>
        <div class="card blue-lightx">
            <i class="fas fa-shopping-cart fa-3x"></i>
            <h4>Stok Opname</h4>
            <a href="/stokopname">Laporan Stok Opname</a>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
</body>

</html>