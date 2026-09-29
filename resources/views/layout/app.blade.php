@extends('layout.home')
@section('inti')
<style>
    /* Executive Dashboard Header */
    .dashboard-header {
        margin-bottom: 22px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    /* Metric Cards */
    .metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        gap: 18px;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        text-decoration: none !important;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        border-color: #cbd5e1;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.06);
    }
    .metric-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .metric-icon-blue { background: #eff6ff; color: #2563eb; }
    .metric-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .metric-icon-emerald { background: #ecfdf5; color: #059669; }
    .metric-icon-sky { background: #f0f9ff; color: #0284c7; }
    .metric-icon-amber { background: #fffbeb; color: #d97706; }

    .metric-value {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .metric-label {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 500;
        margin-top: 3px;
    }

    /* Attention Bar */
    .attention-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 20px;
        margin-bottom: 24px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }
    .quick-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .quick-pill:hover { transform: translateY(-1px); }
    .quick-pill-warning { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .quick-pill-danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .quick-pill-info { background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }

    /* Modern Calendar */
    .calendar-container {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }
    .calendar-header {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fafbfc;
        flex-wrap: wrap;
        gap: 12px;
    }
    .calendar-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .calendar-table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 8px;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #f1f5f9;
    }
    .calendar-table thead th:last-child { border-right: none; }

    .calendar-cell {
        height: 110px;
        vertical-align: top;
        padding: 8px;
        border-right: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        background: #ffffff;
        transition: background-color 0.15s ease;
        position: relative;
    }
    .calendar-cell:last-child { border-right: none; }
    .calendar-cell:hover { background-color: #fafbfc; }
    .calendar-cell-other-month { background-color: #fafafa; opacity: 0.5; }
    .calendar-cell-today {
        background-color: #f0fdf4 !important;
        border: 2px solid #86efac !important;
    }

    .day-number-badge {
        width: 26px;
        height: 26px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 600;
        color: #334155;
    }
    .day-today-badge {
        background: #16a34a;
        color: #ffffff !important;
        box-shadow: 0 2px 6px rgba(22, 163, 74, 0.35);
    }

    .event-chip {
        display: block;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #1e40af;
        border-radius: 6px;
        padding: 3px 6px;
        font-size: 11px;
        line-height: 1.25;
        margin-top: 4px;
        text-decoration: none !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: all 0.15s ease;
    }
    .event-chip:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    /* Pulse Dot */
    .pulse-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulse-green 1.8s infinite;
    }
    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>

<div class="container-fluid pt-3">
    <!-- Executive Dashboard Header -->
    <div class="dashboard-header">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <h3 class="fw-bold text-dark mb-0">Dashboard Operasional Lab</h3>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 font-12 fw-semibold d-inline-flex align-items-center gap-2">
                        <span class="pulse-dot"></span>
                        TA: {{ optional($taAktif)->ta ?? 'Belum Diatur' }}
                    </span>
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1 font-12 fw-medium">
                        {{ $totalLab }} Ruang Lab
                    </span>
                </div>
                <p class="text-muted small mb-0">
                    Selamat datang, <strong class="text-dark">{{ session('siakad_user_name', Auth::user()->name ?? 'Administrator') }}</strong>. Kelola jadwal praktikum, peminjaman alat, dan presensi lab terpadu.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                @can('operateLab')
                <a href="{{ route('jadwal.create') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm d-inline-flex align-items-center gap-2 font-13">
                    <i class="fa fa-calendar-plus"></i> Buat Jadwal
                </a>
                @endcan
                @can('isSuper')
                <a href="{{ route('audit.index') }}" class="btn btn-outline-secondary rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center gap-2 font-13">
                    <i class="fa fa-shield-halved"></i> Audit Log
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- 4 Primary Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            @can('operateLab')
            <a href="{{ route('jurnal.index') }}" class="metric-card">
            @else
            <div class="metric-card">
            @endcan
                <div class="metric-icon-box metric-icon-blue">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <div class="metric-value">{{ $jurnal }}</div>
                    <div class="metric-label">Jurnal Praktikum</div>
                </div>
            @can('operateLab')
            </a>
            @else
            </div>
            @endcan
        </div>
        <div class="col-sm-6 col-lg-3">
            @can('operateLab')
            <a href="{{ route('absensi.index') }}" class="metric-card">
            @else
            <div class="metric-card">
            @endcan
                <div class="metric-icon-box metric-icon-purple">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <div class="metric-value">{{ $tamu }}</div>
                    <div class="metric-label">Presensi & Tamu Lab</div>
                </div>
            @can('operateLab')
            </a>
            @else
            </div>
            @endcan
        </div>
        <div class="col-sm-6 col-lg-3">
            @can('operateLab')
            <a href="{{ route('pemakaian.index') }}" class="metric-card">
            @else
            <div class="metric-card">
            @endcan
                <div class="metric-icon-box metric-icon-emerald">
                    <i class="fa-solid fa-handshake"></i>
                </div>
                <div>
                    <div class="metric-value">{{ $pemakaian }}</div>
                    <div class="metric-label">Peminjaman Disetujui</div>
                </div>
            @can('operateLab')
            </a>
            @else
            </div>
            @endcan
        </div>
        <div class="col-sm-6 col-lg-3">
            @can('manageMaster')
            <a href="{{ route('alat.index') }}" class="metric-card">
            @else
            <div class="metric-card">
            @endcan
                <div class="metric-icon-box metric-icon-sky">
                    <i class="fa-solid fa-microscope"></i>
                </div>
                <div>
                    <div class="metric-value">{{ $totalAlat + $totalBahan }}</div>
                    <div class="metric-label">{{ $totalAlat }} Alat • {{ $totalBahan }} Bahan</div>
                </div>
            @can('manageMaster')
            </a>
            @else
            </div>
            @endcan
        </div>
    </div>

    <!-- Attention Bar: Peminjaman Pending & Belum Dikembalikan -->
    @can('operateLab')
    @if($pemakaian1 > 0 || $pemakaian2 > 0)
        <div class="attention-card">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <span class="fw-bold text-dark font-13">
                        <i class="fa fa-bell text-warning me-1"></i> Perhatian Operasional:
                    </span>
                    @if($pemakaian1 > 0)
                        <a href="{{ route('pemakaian.index') }}" class="quick-pill quick-pill-warning">
                            <i class="fa fa-clock"></i> {{ $pemakaian1 }} Permintaan Peminjaman Butuh Persetujuan
                        </a>
                    @endif
                    @if($pemakaian2 > 0)
                        <a href="{{ route('pemakaian.index') }}" class="quick-pill quick-pill-danger">
                            <i class="fa fa-box-open"></i> {{ $pemakaian2 }} Peminjaman Belum Dikembalikan
                        </a>
                    @endif
                </div>
                <div>
                    <a href="{{ route('pemakaian.index') }}" class="btn btn-sm btn-link text-primary text-decoration-none fw-semibold">
                        Kelola Transaksi <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif
    @endcan

    <!-- Modern Calendar Section -->
    <div class="calendar-container mb-4">
        <div class="calendar-header">
            <div>
                <h4 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="fa fa-calendar-days text-primary"></i>
                    <span>Jadwal Praktikum Laboratorium</span>
                    <span class="badge bg-primary-subtle text-primary rounded-pill font-13 px-3 py-1 fw-semibold">
                        {{ $namaBulanTeks }} {{ $year }}
                    </span>
                </h4>
                <small class="text-muted">Total {{ $jadwal->count() }} sesi praktikum terdaftar pada bulan ini</small>
                @if(!empty($peringatanTa))
                <div class="small text-warning mt-1"><i class="fa fa-exclamation-triangle me-1"></i>{{ $peringatanTa }}</div>
                @endif
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('layout.app', ['month' => $prevDate->month, 'year' => $prevDate->year]) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3" title="Bulan Sebelumnya">
                    <i class="fa fa-chevron-left me-1"></i> {{ $prevDate->format('M') }}
                </a>
                <a href="{{ route('layout.app') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-semibold border" title="Kembali ke Hari Ini">
                    Hari Ini
                </a>
                <a href="{{ route('layout.app', ['month' => $nextDate->month, 'year' => $nextDate->year]) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3" title="Bulan Berikutnya">
                    {{ $nextDate->format('M') }} <i class="fa fa-chevron-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th width="14.28%">Minggu</th>
                        <th width="14.28%">Senin</th>
                        <th width="14.28%">Selasa</th>
                        <th width="14.28%">Rabu</th>
                        <th width="14.28%">Kamis</th>
                        <th width="14.28%">Jumat</th>
                        <th width="14.28%">Sabtu</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startDay = $startOfMonth->dayOfWeek; // 0 (Sunday) to 6 (Saturday)
                        $currentDay = 1;
                        $todayFormatted = $today->format('Y-m-d');
                        $calendarEventsMap = [];
                    @endphp

                    @for ($row = 0; $row < 6; $row++)
                        @if ($currentDay > $daysInMonth)
                            @break
                        @endif
                        <tr>
                            @for ($col = 0; $col < 7; $col++)
                                @if (($row == 0 && $col < $startDay) || $currentDay > $daysInMonth)
                                    <td class="calendar-cell calendar-cell-other-month"></td>
                                @else
                                    @php
                                        $cellDateStr = sprintf('%04d-%02d-%02d', $year, $month, $currentDay);
                                        $isToday = ($cellDateStr === $todayFormatted);
                                        $eventsToday = $jadwalByDate->get($cellDateStr, collect());
                                        $totalEvents = $eventsToday->count();

                                        // Store events in JS-friendly array for modal preview
                                        $calendarEventsMap[$cellDateStr] = $eventsToday->map(function($ev) {
                                            $jamMulai = $ev->jam_mulai;
                                            $jamSelesai = $ev->jam_selesai_formatted;
                                            return [
                                                'id' => $ev->id,
                                                'jam' => $jamMulai,
                                                'jam_selesai' => $jamSelesai,
                                                'waktu' => $jamMulai . ' – ' . $jamSelesai,
                                                'matkul' => optional($ev->matkulId)->matakuliah ?? 'Mata Kuliah',
                                                'dosen' => optional($ev->matkulId)->dosen ?? '',
                                                'lab' => optional($ev->labId)->laboratorium ?? 'Laboratorium',
                                                'prodi' => optional($ev->programId)->program ?? 'Prodi',
                                            ];
                                        })->values()->all();
                                    @endphp
                                    <td class="calendar-cell {{ $isToday ? 'calendar-cell-today' : '' }}">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="day-number-badge {{ $isToday ? 'day-today-badge' : '' }}" title="{{ $isToday ? 'Hari Ini' : '' }}">
                                                {{ $currentDay }}
                                            </span>
                                            @if($totalEvents > 0)
                                                <button type="button" class="btn btn-xs badge rounded-pill border-0 p-1 px-2" style="background:#eff6ff; color:#2563eb; font-size:10.5px;" onclick="openDayModal('{{ $cellDateStr }}', '{{ $currentDay }} {{ $namaBulanTeks }} {{ $year }}')">
                                                    {{ $totalEvents }} Sesi
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Preview top 2 events -->
                                        @foreach($eventsToday->take(2) as $ev)
                                            @php
                                                $jamMulai = $ev->jam_mulai;
                                                $jamSelesai = $ev->jam_selesai_formatted;
                                                $matkulNama = optional($ev->matkulId)->matakuliah ?? 'Mata Kuliah';
                                                $labNama = optional($ev->labId)->laboratorium ?? 'Lab';
                                            @endphp
                                            <a href="javascript:void(0)" class="event-chip" onclick="openDayModal('{{ $cellDateStr }}', '{{ $currentDay }} {{ $namaBulanTeks }} {{ $year }}')" title="{{ $jamMulai }} – {{ $jamSelesai }} WIB : {{ $matkulNama }} ({{ $labNama }})">
                                                <span class="fw-bold">{{ $jamMulai }}–{{ $jamSelesai }}</span> {{ Str::limit($matkulNama, 12) }}
                                            </a>
                                        @endforeach

                                        @if($totalEvents > 2)
                                            <button type="button" class="btn btn-link text-primary p-0 font-11 fw-semibold text-decoration-none mt-1 d-block text-truncate" onclick="openDayModal('{{ $cellDateStr }}', '{{ $currentDay }} {{ $namaBulanTeks }} {{ $year }}')">
                                                +{{ $totalEvents - 2 }} jadwal lainnya...
                                            </button>
                                        @endif

                                        @php $currentDay++; @endphp
                                    </td>
                                @endif
                            @endfor
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade app-modal" id="modalDetailJadwal" tabindex="-1" aria-labelledby="modalDetailJadwalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="modalDetailJadwalLabel">Jadwal praktikum</h5>
                    <p class="modal-kicker" id="modalDetailDateSubtitle"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div id="modalDetailContent" class="d-flex flex-column gap-2"></div>
            </div>
            @can('operateLab')
            <div class="modal-footer">
                <a href="{{ route('jadwal.index') }}" class="btn-modal-cancel">Lihat seluruh jadwal</a>
                <a href="{{ route('jadwal.create') }}" class="btn-modal-save">Tambah jadwal</a>
            </div>
            @endcan
        </div>
    </div>
</div>

<script>
    const calendarEventsData = @json($calendarEventsMap);

    function openDayModal(dateStr, formattedDate) {
        document.getElementById('modalDetailDateSubtitle').textContent = formattedDate;
        const container = document.getElementById('modalDetailContent');
        container.innerHTML = '';

        const events = calendarEventsData[dateStr] || [];

        if (events.length === 0) {
            container.innerHTML = `
                <div class="text-center py-4 text-muted">
                    <i class="fa fa-calendar-xmark fs-2 mb-2 d-block opacity-50"></i>
                    Tidak ada jadwal praktikum yang terdaftar pada tanggal ini.
                </div>
            `;
        } else {
            events.forEach(function (ev, index) {
                const itemHtml = `
                    <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between flex-wrap gap-2" style="background:#f8fafc; border-color:#e2e8f0;">
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-primary text-white rounded-3 px-3 py-2 font-12 fw-bold text-nowrap" style="text-align:center;">
                                <i class="fa fa-clock me-1"></i> ${ev.waktu} WIB
                            </span>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">${ev.matkul}</h6>
                                <div class="d-flex align-items-center gap-2 font-12 text-muted flex-wrap">
                                    ${ev.dosen ? `<span><i class="fa fa-chalkboard-user me-1 text-secondary"></i> ${ev.dosen}</span><span>•</span>` : ''}
                                    <span><i class="fa fa-door-open me-1 text-primary"></i> ${ev.lab}</span>
                                    <span>•</span>
                                    <span><i class="fa fa-graduation-cap me-1 text-secondary"></i> ${ev.prodi}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="/jadwal/${ev.id}/edit" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                <i class="fa fa-edit me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', itemHtml);
            });
        }

        var dayModal = new bootstrap.Modal(document.getElementById('modalDetailJadwal'));
        dayModal.show();
    }
</script>
@endsection