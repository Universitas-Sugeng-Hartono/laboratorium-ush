<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Katalog Stok Opname Bahan - SILABO USH</title>
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
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #334155;
        }

        .portal-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .page-header-box {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border-radius: 16px;
            padding: 26px 30px;
            color: #ffffff;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.15);
        }

        /* Metric Cards */
        .metric-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            gap: 16px;
            height: 100%;
        }

        .metric-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .metric-icon-sky { background: #f0f9ff; color: #0284c7; }
        .metric-icon-emerald { background: #ecfdf5; color: #059669; }

        .metric-value {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
        }

        .metric-label {
            font-size: 11.5px;
            color: #64748b;
            font-weight: 500;
            margin-top: 2px;
        }

        .filter-toolbar {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .card-modern {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 18px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .data-table tbody td {
            padding: 16px 18px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 13.5px;
        }

        .data-table tbody tr:hover {
            background-color: #f8fafd;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .portal-footer {
            margin-top: auto;
            padding: 24px 0;
            text-align: center;
            color: #94a3b8;
            font-size: 12.5px;
            border-top: 1px solid #e2e8f0;
            background: #ffffff;
        }
    </style>
</head>

<body>
    <!-- Top Navigation Bar -->
    <header class="portal-navbar">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-nowrap">
                <a href="/" class="d-flex align-items-center gap-3 text-decoration-none flex-shrink-0">
                    <img src="{{ asset('img/ushh.png') }}" alt="Logo USH" style="height: 44px; width: 44px; object-fit: contain;" class="flex-shrink-0">
                    <div class="d-none d-sm-block text-start border-start ps-3 border-secondary">
                        <span class="d-block fw-bold text-dark font-14">SILABO USH</span>
                        <span class="d-block text-muted font-11">Stok Opname Bahan</span>
                    </div>
                </a>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <a href="/" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-semibold text-nowrap">
                        <i class="fa fa-arrow-left me-1"></i> Ke Portal Utama
                    </a>
                    @if(Auth::check())
                        <a href="/home" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold text-nowrap">
                            <i class="fa fa-gauge me-1"></i> Dashboard
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="container py-4">
        <!-- Page Header Banner -->
        <div class="page-header-box">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-info rounded-pill px-3 py-1 font-11 fw-bold mb-2">
                        INVENTARIS & STOK BAHAN
                    </span>
                    <h2 class="fw-bold mb-1 text-white">Katalog Stok Opname Bahan</h2>
                    <p class="mb-0 opacity-75 font-14">
                        Pemantauan ketersediaan bahan kimia, reagen, dan bahan habis pakai di seluruh laboratorium Universitas Sugeng Hartono.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <span class="badge bg-white bg-opacity-25 text-white font-13 px-3 py-2 rounded-pill">
                        <i class="fa fa-boxes-stacked me-1"></i> Data Terintegrasi
                    </span>
                </div>
            </div>
        </div>

        <!-- 2 Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="metric-card">
                    <div class="metric-icon-box metric-icon-sky">
                        <i class="fa fa-flask"></i>
                    </div>
                    <div>
                        <div class="metric-value">{{ $totalBahan ?? $bahan->count() }}</div>
                        <div class="metric-label">Total Jenis Bahan Terdaftar</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="metric-card">
                    <div class="metric-icon-box metric-icon-emerald">
                        <i class="fa fa-cubes-stacked"></i>
                    </div>
                    <div>
                        <div class="metric-value">{{ $totalStok ?? $bahan->sum('jumlah') }}</div>
                        <div class="metric-label">Akumulasi Total Unit Stok Tersedia</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="filter-toolbar">
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa fa-search"></i></span>
                        <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari nama bahan atau kode inventaris...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select id="stockFilter" class="form-select">
                        <option value="">Semua Kondisi Stok</option>
                        <option value="tersedia">Stok Tersedia (> 0)</option>
                        <option value="habis">Stok Habis (0)</option>
                    </select>
                </div>
                <div class="col-md-3 text-md-end text-muted small">
                    Menampilkan <span id="visibleCount" class="fw-bold text-dark">{{ $bahan->count() }}</span> jenis bahan
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card-modern">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th width="160">Kode Inventaris</th>
                            <th>Nama Bahan Kimia / Habis Pakai</th>
                            <th width="180">Jumlah Stok Fisik</th>
                            <th width="150" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="bahanTable">
                        @forelse($bahan as $key => $ba)
                            @php
                                $isAvailable = ($ba->jumlah > 0);
                            @endphp
                            <tr class="bahan-row" data-text="{{ strtolower($ba->kode . ' ' . $ba->bahan) }}" data-status="{{ $isAvailable ? 'tersedia' : 'habis' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge" style="background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; border-radius:6px; font-family:monospace; font-size:12px; padding:4px 8px;">
                                        {{ $ba->kode ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark font-14">{{ $ba->bahan }}</div>
                                </td>
                                <td>
                                    <span class="fw-bold fs-6 text-dark">{{ $ba->jumlah }}</span>
                                    <span class="text-muted font-12">{{ $ba->satuan ?? 'Unit' }}</span>
                                </td>
                                <td class="text-center">
                                    @if($ba->jumlah > 10)
                                        <span class="badge px-3 py-2" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; border-radius:20px; font-weight:600;">
                                            <i class="fa fa-circle-check me-1"></i> Tersedia
                                        </span>
                                    @elseif($ba->jumlah > 0)
                                        <span class="badge px-3 py-2" style="background:#fffbeb; color:#92400e; border:1px solid #fde68a; border-radius:20px; font-weight:600;">
                                            <i class="fa fa-triangle-exclamation me-1"></i> Terbatas
                                        </span>
                                    @else
                                        <span class="badge px-3 py-2" style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca; border-radius:20px; font-weight:600;">
                                            <i class="fa fa-circle-xmark me-1"></i> Habis
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa fa-box-open fs-1 mb-3 d-block opacity-50 text-secondary"></i>
                                    <h5 class="fw-bold text-dark">Belum Ada Data Bahan</h5>
                                    <p class="font-14 mb-0">Belum ada bahan kimia atau habis pakai yang terdaftar pada sistem.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container">
            <p class="mb-0">
                &copy; {{ date('Y') }} <strong>Universitas Sugeng Hartono</strong>. Laboratorium Terpadu - All Rights Reserved.
            </p>
        </div>
    </footer>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
            const stockFilter = document.getElementById("stockFilter");
            const rows = document.querySelectorAll(".bahan-row");
            const visibleCount = document.getElementById("visibleCount");

            function filterTable() {
                const query = (searchInput.value || "").toLowerCase().trim();
                const stockStatus = (stockFilter.value || "").toLowerCase();
                let count = 0;

                rows.forEach(function (row) {
                    const text = row.getAttribute("data-text") || "";
                    const status = row.getAttribute("data-status") || "";

                    const matchesQuery = !query || text.includes(query);
                    const matchesStock = !stockStatus || status === stockStatus;

                    if (matchesQuery && matchesStock) {
                        row.style.display = "";
                        count++;
                    } else {
                        row.style.display = "none";
                    }
                });

                if (visibleCount) {
                    visibleCount.textContent = count;
                }
            }

            if (searchInput) searchInput.addEventListener("input", filterTable);
            if (stockFilter) stockFilter.addEventListener("change", filterTable);
        });
    </script>
</body>

</html>