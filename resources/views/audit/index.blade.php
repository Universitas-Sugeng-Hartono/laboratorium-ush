@extends('layout.home')
@section('inti')
<style>
    /* Design Tokens & Layout */
    .metric-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        gap: 16px;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
    }
    .metric-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .metric-icon-blue { background: #eff6ff; color: #2563eb; }
    .metric-icon-emerald { background: #ecfdf5; color: #059669; }
    .metric-icon-purple { background: #f5f3ff; color: #7c3aed; }
    .metric-icon-rose { background: #fee2e2; color: #dc2626; }

    .metric-value {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }
    .metric-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
        margin-top: 2px;
    }

    .card-modern {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
    }
    .filter-card .form-control, .filter-card .form-select {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        padding: 7px 12px;
    }
    .filter-card .form-control:focus, .filter-card .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
    }
    .filter-card label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .data-table { border-collapse: separate; border-spacing: 0; }
    .data-table thead th {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 600;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 16px;
        white-space: nowrap;
    }
    .data-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        color: #334155;
        font-size: 13px;
    }
    .data-table tbody tr:hover { background-color: #f8fafd; }
    .data-table tbody tr:last-child td { border-bottom: none; }

    /* User Avatar */
    .user-avatar-circle {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #ffffff;
        font-weight: 600;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .actor-name { font-weight: 600; color: #0f172a; font-size: 13px; }
    .actor-role { font-size: 11px; color: #64748b; }

    /* Action Chips */
    .action-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .action-create { background: #ecfdf5; color: #059669; }
    .action-update { background: #eff6ff; color: #2563eb; }
    .action-delete { background: #fee2e2; color: #dc2626; }
    .action-status { background: #f5f3ff; color: #7c3aed; }
    .action-login  { background: #ecfeff; color: #0891b2; }
    .action-logout { background: #f1f5f9; color: #64748b; }
    .action-import { background: #eef2ff; color: #4f46e5; }

    /* Module Badge */
    .module-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    /* IP & Timestamp */
    .ip-badge {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 11px;
        color: #64748b;
        background: #f8fafc;
        padding: 2px 6px;
        border-radius: 4px;
        border: 1px solid #e2e8f0;
    }
    .time-primary { font-weight: 600; color: #0f172a; font-size: 12.5px; }
    .time-relative { font-size: 11px; color: #94a3b8; }

    /* Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        cursor: pointer;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
    }
    .btn-action-primary { background: #eff6ff; color: #2563eb; }
    .btn-action-primary:hover { background: #2563eb; color: #ffffff; }

    .btn-modern-filter {
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 7px 18px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-modern-filter:hover {
        background: #1d4ed8;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
    }
    .btn-modern-light {
        background: #f8fafc;
        color: #475569;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 7px 14px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-modern-light:hover { background: #f1f5f9; color: #0f172a; }

    .summary-text { font-size: 13px; color: #64748b; }
    .summary-text strong { color: #0f172a; }
    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-state i { font-size: 40px; color: #cbd5e1; margin-bottom: 12px; }
    .empty-state h6 { color: #475569; font-weight: 600; margin-bottom: 4px; }
    .empty-state p { color: #94a3b8; font-size: 13px; }

    /* Diff Table */
    .diff-table { width: 100%; border-collapse: collapse; }
    .diff-table th {
        background: #f8fafc;
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }
    .diff-table td {
        padding: 8px 12px;
        font-size: 12.5px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
    }
    .diff-old {
        background-color: #fef2f2;
        color: #b91c1c;
        font-family: ui-monospace, monospace;
        font-size: 12px;
        word-break: break-all;
    }
    .diff-new {
        background-color: #f0fdf4;
        color: #15803d;
        font-family: ui-monospace, monospace;
        font-size: 12px;
        word-break: break-all;
    }
</style>

<!-- Breadcrumb -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Audit Log & Aktivitas</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('layout.app') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item text-dark active" aria-current="page">Audit Log</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-blue">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div>
                    <div class="metric-value">{{ number_format($totalLogs) }}</div>
                    <div class="metric-label">Total Aktivitas</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-emerald">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div>
                    <div class="metric-value">{{ number_format($todayLogs) }}</div>
                    <div class="metric-label">Aktivitas Hari Ini</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-purple">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <div class="metric-value">{{ number_format($updateLogs) }}</div>
                    <div class="metric-label">Perubahan Data</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="metric-card">
                <div class="metric-icon-box metric-icon-rose">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <div>
                    <div class="metric-value">{{ number_format($deleteLogs) }}</div>
                    <div class="metric-label">Penghapusan Data</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <form action="{{ route('audit.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="mb-1">Pencarian Deskripsi / Target</label>
                    <input type="text" name="q" class="form-control" placeholder="Kata kunci aktivitas..." value="{{ request('q') }}">
                </div>
                <div class="col-md-2">
                    <label class="mb-1">Modul Sistem</label>
                    <select name="module" class="form-select">
                        <option value="">Semua Modul</option>
                        @foreach ($modules as $m)
                        <option value="{{ $m }}" {{ request('module') == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="mb-1">Jenis Aksi</label>
                    <select name="action" class="form-select">
                        <option value="">Semua Aksi</option>
                        @foreach ($actions as $act)
                        <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ $act }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="mb-1">Pengguna</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua Pengguna</option>
                        @foreach ($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2 align-items-end justify-content-end">
                    <button type="submit" class="btn-modern-filter">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['q', 'module', 'action', 'user_id', 'start_date', 'end_date']))
                    <a href="{{ route('audit.index') }}" class="btn-modern-light">Reset</a>
                    @endif
                    <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Count & Per-Page Selector -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <span class="summary-text">Menampilkan <strong>{{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }}</strong> dari <strong>{{ $logs->total() }}</strong> jejak aktivitas</span>
        @include('layout.per-page', ['default' => 25])
    </div>

    <!-- Table Card -->
    <div class="card-modern">
        <div class="table-responsive">
            <table class="data-table w-100">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="width: 170px;">Waktu Kejadian</th>
                        <th style="width: 200px;">Pengguna (Pelaku)</th>
                        <th style="width: 130px;">Aksi</th>
                        <th style="width: 110px;">Modul</th>
                        <th>Deskripsi Aktivitas</th>
                        <th style="width: 140px;">IP Address</th>
                        <th style="width: 70px;" class="text-end">Diff</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $key => $log)
                    <tr>
                        <td class="text-muted">{{ $logs->firstItem() + $key }}</td>
                        <td>
                            <div class="time-primary">{{ $log->created_at ? $log->created_at->translatedFormat('d M Y H:i') : '-' }}</div>
                            <div class="time-relative">{{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="user-avatar-circle">
                                    {{ strtoupper(substr($log->user_name ?? ($log->user->name ?? 'U'), 0, 2)) }}
                                </div>
                                <div>
                                    <div class="actor-name">{{ $log->user_name ?? ($log->user->name ?? 'Sistem / Tamu') }}</div>
                                    <div class="actor-role">{{ ucfirst($log->user_role ?? ($log->user->role ?? 'Guest')) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $act = strtoupper($log->action);
                                $badgeClass = match($act) {
                                    'CREATE' => 'action-create',
                                    'UPDATE' => 'action-update',
                                    'DELETE' => 'action-delete',
                                    'STATUS_CHANGE' => 'action-status',
                                    'LOGIN'  => 'action-login',
                                    'LOGOUT' => 'action-logout',
                                    'IMPORT' => 'action-import',
                                    default  => 'action-status',
                                };
                                $iconClass = match($act) {
                                    'CREATE' => 'fas fa-plus-circle',
                                    'UPDATE' => 'fas fa-edit',
                                    'DELETE' => 'fas fa-trash',
                                    'STATUS_CHANGE' => 'fas fa-sync-alt',
                                    'LOGIN'  => 'fas fa-sign-in-alt',
                                    'LOGOUT' => 'fas fa-sign-out-alt',
                                    'IMPORT' => 'fas fa-file-import',
                                    default  => 'fas fa-info-circle',
                                };
                            @endphp
                            <span class="action-tag {{ $badgeClass }}">
                                <i class="{{ $iconClass }}"></i> {{ $act }}
                            </span>
                        </td>
                        <td>
                            <span class="module-badge">{{ $log->module ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="fw-medium text-dark">{{ $log->description ?? '-' }}</div>
                            @if($log->record_label && $log->record_label !== $log->description)
                            <small class="text-muted">Target: <strong>{{ $log->record_label }}</strong></small>
                            @endif
                        </td>
                        <td>
                            <span class="ip-badge">{{ $log->ip_address ?? '127.0.0.1' }}</span>
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn-action btn-action-primary" title="Lihat Detail Diff Perubahan" onclick="showDiffModal({{ $log->id }})">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-shield-alt d-block"></i>
                                <h6>Belum Ada Riwayat Aktivitas</h6>
                                <p>Tidak ditemukan data audit log yang sesuai dengan filter pencarian.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4" style="border-color: #f1f5f9 !important;">
            <span class="summary-text">Hal. {{ $logs->currentPage() }} / {{ $logs->lastPage() }}</span>
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade app-modal" id="diffModal" tabindex="-1" aria-labelledby="diffModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="diffModalTitle">Detail perubahan</h5>
                    <p class="modal-kicker" id="diffModalSubtitle">Perbandingan nilai sebelum dan sesudah perubahan.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="meta-strip">
                    <div class="row g-2">
                        <div class="col-sm-6"><strong>Pengguna</strong><br><span id="diffUser">-</span></div>
                        <div class="col-sm-6"><strong>Waktu</strong><br><span id="diffTime">-</span></div>
                        <div class="col-sm-6"><strong>Aksi</strong><br><span id="diffAction">-</span></div>
                        <div class="col-sm-6"><strong>Alamat IP</strong><br><span id="diffIp">-</span></div>
                        <div class="col-12"><strong>Deskripsi</strong><br><span id="diffDesc">-</span></div>
                    </div>
                </div>
                <div id="diffContentContainer"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function showDiffModal(logId) {
    const modalEl = document.getElementById('diffModal');
    const modal = new bootstrap.Modal(modalEl);
    const container = document.getElementById('diffContentContainer');
    
    container.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i><p class="small text-muted mt-2">Memuat detail perbandingan...</p></div>';
    modal.show();

    fetch(`/audit-log/${logId}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('diffUser').textContent = `${data.user_name} (${data.user_role})`;
            document.getElementById('diffTime').textContent = data.created_at;
            document.getElementById('diffAction').textContent = `${data.action} [${data.module}]`;
            document.getElementById('diffIp').textContent = data.ip_address || '-';
            document.getElementById('diffDesc').textContent = data.description || '-';

            const oldVals = data.old_values || {};
            const newVals = data.new_values || {};
            const allKeys = Array.from(new Set([...Object.keys(oldVals), ...Object.keys(newVals)]));

            if (allKeys.length === 0) {
                container.innerHTML = `
                    <div class="alert alert-info border-0 rounded-3 small mb-0">
                        <i class="fas fa-info-circle me-1"></i> Tidak ada perubahan atribut data tersimpan untuk aktivitas ini (misalnya sesi login/logout atau penghapusan tanpa snapshot).
                    </div>
                `;
                return;
            }

            let rows = '';
            allKeys.forEach(k => {
                const oldV = oldVals[k] !== undefined && oldVals[k] !== null ? (typeof oldVals[k] === 'object' ? JSON.stringify(oldVals[k]) : String(oldVals[k])) : '<em class="text-muted">-</em>';
                const newV = newVals[k] !== undefined && newVals[k] !== null ? (typeof newVals[k] === 'object' ? JSON.stringify(newVals[k]) : String(newVals[k])) : '<em class="text-muted">-</em>';
                
                rows += `
                    <tr>
                        <td class="fw-semibold text-dark">${k}</td>
                        <td class="diff-old">${oldV}</td>
                        <td class="diff-new">${newV}</td>
                    </tr>
                `;
            });

            container.innerHTML = `
                <div class="table-responsive border rounded-3 overflow-hidden">
                    <table class="diff-table">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Nama Kolom</th>
                                <th style="width: 37.5%;" class="text-danger"><i class="fas fa-minus-circle me-1"></i> Nilai Sebelum (Lama)</th>
                                <th style="width: 37.5%;" class="text-success"><i class="fas fa-plus-circle me-1"></i> Nilai Sesudah (Baru)</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
            `;
        })
        .catch(err => {
            container.innerHTML = `<div class="alert alert-danger small">Gagal memuat detail log: ${err.message}</div>`;
        });
}
</script>
@endsection
