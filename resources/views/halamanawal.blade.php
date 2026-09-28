<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SILABO - Universitas Sugeng Hartono</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/ushh.png') }}">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #334155;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle mesh background effect */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 480px;
            background: radial-gradient(circle at 50% 20%, rgba(37, 99, 235, 0.18) 0%, rgba(15, 23, 42, 0) 70%);
            pointer-events: none;
        }

        .portal-navbar {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .hero-section {
            padding: 50px 0 35px 0;
            text-align: center;
            color: #ffffff;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .portal-title {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .portal-subtitle {
            font-size: 15px;
            color: #94a3b8;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Modern Grid Cards */
        .service-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 32px 28px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            text-align: center;
        }

        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.18);
            border-color: #93c5fd;
        }

        .service-icon-wrapper {
            width: 62px;
            height: 62px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 22px auto;
        }

        .icon-blue { background: #eff6ff; color: #2563eb; }
        .icon-emerald { background: #ecfdf5; color: #059669; }
        .icon-purple { background: #f5f3ff; color: #7c3aed; }
        .icon-sky { background: #f0f9ff; color: #0284c7; }

        .service-title {
            font-size: 19px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            text-align: center;
        }

        .service-desc {
            font-size: 13.5px;
            color: #64748b;
            line-height: 1.55;
            margin-bottom: 24px;
            flex-grow: 1;
            text-align: center;
        }

        .service-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13.5px;
            text-decoration: none;
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-blue { background: #eff6ff; color: #2563eb; }
        .btn-blue:hover { background: #2563eb; color: #ffffff; }

        .btn-emerald { background: #ecfdf5; color: #059669; }
        .btn-emerald:hover { background: #059669; color: #ffffff; }

        .btn-purple { background: #f5f3ff; color: #7c3aed; }
        .btn-purple:hover { background: #7c3aed; color: #ffffff; }

        .btn-sky { background: #f0f9ff; color: #0284c7; }
        .btn-sky:hover { background: #0284c7; color: #ffffff; }

        .portal-footer {
            margin-top: auto;
            padding: 30px 0;
            text-align: center;
            color: #64748b;
            font-size: 12.5px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Pulse dot */
        .live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 1.8s infinite;
        }

        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
</head>

<body>
    <!-- Top Navigation Bar -->
    <header class="portal-navbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-nowrap">
                <a href="/" class="d-flex align-items-center gap-3 text-decoration-none flex-shrink-0">
                    <img src="{{ asset('img/ushh.png') }}" alt="Logo USH" style="height: 48px; width: 48px; object-fit: contain;" class="flex-shrink-0">
                    <div class="d-none d-sm-block text-start border-start ps-3 border-secondary">
                        <span class="d-block fw-bold text-white font-15" style="letter-spacing: 0.3px;">SILABO USH</span>
                        <span class="d-block text-muted font-11">Laboratorium Terpadu Universitas Sugeng Hartono</span>
                    </div>
                </a>

                <div class="d-flex align-items-center gap-3 flex-shrink-0">
                    <div class="d-none d-md-flex align-items-center gap-2 text-light font-12 bg-white bg-opacity-10 px-3 py-1 rounded-pill text-nowrap">
                        <span class="live-dot"></span>
                        <span id="liveTime" style="white-space: nowrap;">WIB</span>
                    </div>
                    @if(Auth::check())
                        <a href="/home" class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm fw-semibold text-nowrap">
                            <i class="fa fa-gauge me-1"></i> Dashboard Admin
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            
            <h1 class="portal-title">Universitas Sugeng Hartono</h1>
            <p class="portal-subtitle">
                Portal pelayanan terpadu bagi Dosen, Mahasiswa, Asisten, dan Tamu Kampus untuk jadwal praktikum, presensi kunjungan, peminjaman alat, dan inventaris bahan.
            </p>
        </div>
    </section>

    <!-- Main Service Cards -->
    <main class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert" style="background:#ecfdf5; color:#065f46;">
                <i class="fa fa-circle-check fs-5 me-2 text-success"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 justify-content-center">
            <!-- Card 1: Jurnal & Jadwal Lab -->
            <div class="col-md-6 col-lg-6">
                <div class="service-card text-center">
                    <div>
                        <div class="service-icon-wrapper icon-blue mx-auto">
                            <i class="fa fa-book-open-reader"></i>
                        </div>
                        <h2 class="service-title">Jurnal & Jadwal Praktikum</h2>
                        <p class="service-desc">
                            Lihat jadwal praktikum laboratorium harian dan akses pengisian form <strong>E-Journal perkuliahan</strong> secara langsung untuk dosen dan asisten praktikum.
                        </p>
                    </div>
                    <a href="/jadwallab" class="service-btn btn-blue">
                        <span>Buka Jadwal & E-Journal</span>
                        <i class="fa fa-arrow-right font-12"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2: Buku Tamu -->
            <div class="col-md-6 col-lg-6">
                <div class="service-card text-center">
                    <div>
                        <div class="service-icon-wrapper icon-emerald mx-auto">
                            <i class="fa fa-user-pen"></i>
                        </div>
                        <h2 class="service-title">Buku Tamu & Kunjungan Lab</h2>
                        <p class="service-desc">
                            Formulir presensi digital bagi tamu umum, siswa, peneliti, atau dosen tamu yang berkunjung ke laboratorium lengkap dengan <strong>tanda tangan digital</strong>.
                        </p>
                    </div>
                    <a href="/tamuumum" class="service-btn btn-emerald">
                        <span>Isi Presensi Tamu</span>
                        <i class="fa fa-arrow-right font-12"></i>
                    </a>
                </div>
            </div>

            <!-- Card 3: Peminjaman Alat & Lab -->
            <div class="col-md-6 col-lg-6">
                <div class="service-card text-center">
                    <div>
                        <div class="service-icon-wrapper icon-purple mx-auto">
                            <i class="fa fa-hand-holding-hand"></i>
                        </div>
                        <h2 class="service-title">Lacak & Ajukan Peminjaman</h2>
                        <p class="service-desc">
                            Periksa status persetujuan peminjaman alat atau ruangan laboratorium oleh mahasiswa/dosen, unduh berkas peminjaman, atau ajukan permohonan baru.
                        </p>
                    </div>
                    <a href="/lihatpeminjaman" class="service-btn btn-purple">
                        <span>Lacak Peminjaman</span>
                        <i class="fa fa-arrow-right font-12"></i>
                    </a>
                </div>
            </div>

            <!-- Card 4: Stok Opname Bahan -->
            <div class="col-md-6 col-lg-6">
                <div class="service-card text-center">
                    <div>
                        <div class="service-icon-wrapper icon-sky mx-auto">
                            <i class="fa fa-flask-vial"></i>
                        </div>
                        <h2 class="service-title">Katalog & Stok Opname Bahan</h2>
                        <p class="service-desc">
                            Katalog pemantauan sisa stok bahan kimia, reagen, dan bahan habis pakai di seluruh laboratorium Universitas Sugeng Hartono secara transparan.
                        </p>
                    </div>
                    <a href="/stokopname" class="service-btn btn-sky">
                        <span>Lihat Stok Bahan</span>
                        <i class="fa fa-arrow-right font-12"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container">
            <p class="mb-0">
                &copy; {{ date('Y') }} <strong>Universitas Sugeng Hartono</strong>.
            </p>
        </div>
    </footer>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        function updateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            const el = document.getElementById('liveTime');
            if (el) {
                el.textContent = now.toLocaleDateString('id-ID', options) + ' WIB';
            }
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>

</html>