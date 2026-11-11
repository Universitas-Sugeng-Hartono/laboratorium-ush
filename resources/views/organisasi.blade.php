<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struktur Organisasi - SILABO USH</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .portal-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .chart-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .chart-box img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        footer {
            margin-top: auto;
            padding: 20px 0;
            text-align: center;
            font-size: 13px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            background: #ffffff;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <header class="portal-navbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="/" class="d-flex align-items-center gap-3 text-decoration-none">
                <img src="{{ asset('img/ushh.png') }}" alt="Logo USH" style="height: 42px; width: 42px; object-fit: contain;">
                <div class="border-start ps-3 border-secondary">
                    <span class="d-block fw-bold text-dark font-14">SILABO USH</span>
                    <span class="d-block text-muted font-11">Struktur Organisasi</span>
                </div>
            </a>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ asset('img/susunan-pengurus.png') }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="fa fa-arrow-up-right-from-square me-1"></i> Buka Gambar
                </a>
                <a href="/" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div>
                <h4 class="fw-bold text-dark mb-1">Struktur Organisasi</h4>
                <p class="text-muted font-13 mb-0">Laboratorium Terpadu & Departemen IST Universitas Sugeng Hartono</p>
            </div>
            <a href="{{ asset('img/susunan-pengurus.png') }}" download class="btn btn-sm btn-primary rounded-pill px-3">
                <i class="fa fa-download me-1"></i> Unduh Bagan
            </a>
        </div>

        <div class="chart-box p-3 p-md-4">
            @include('partials.organisasi-chart')
        </div>
    </main>

    <footer>
        <div class="container">
            &copy; {{ date('Y') }} Universitas Sugeng Hartono
        </div>
    </footer>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
