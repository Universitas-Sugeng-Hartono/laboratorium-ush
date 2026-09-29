<!DOCTYPE html>
<html dir="ltr" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <title>SILABO - Universitas Sugeng Hartono</title>
    <link href="{{asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Modern SweetAlert2 SILABO Theme */
        .swal2-popup {
            border-radius: 16px !important;
            padding: 26px 22px !important;
            font-family: inherit !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
            border: 1px solid #e2e8f0 !important;
        }
        .swal2-icon {
            border-width: 3px !important;
            margin: 8px auto 16px auto !important;
            transform: scale(0.9);
        }
        .swal2-title {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-bottom: 6px !important;
        }
        .swal2-html-container {
            font-size: 13.5px !important;
            color: #64748b !important;
            line-height: 1.5 !important;
            margin: 0 !important;
        }
        .swal2-actions {
            margin-top: 22px !important;
            gap: 10px !important;
        }
        .swal2-styled.swal2-confirm {
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            padding: 9px 22px !important;
            background: linear-gradient(135deg, #dc2626, #b91c1c) !important;
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.25) !important;
            transition: all 0.2s ease !important;
        }
        .swal2-styled.swal2-confirm:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b) !important;
            transform: translateY(-1px) !important;
        }
        .swal2-styled.swal2-cancel {
            border-radius: 8px !important;
            font-weight: 500 !important;
            font-size: 13px !important;
            padding: 9px 18px !important;
            background: #f8fafc !important;
            color: #475569 !important;
            border: 1px solid #cbd5e1 !important;
            transition: all 0.2s ease !important;
        }
        .swal2-styled.swal2-cancel:hover {
            background: #f1f5f9 !important;
            color: #0f172a !important;
        }

        /* SILABO Theme: Active Sidebar Item in Brand Primary Blue (#2563eb) */
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link,
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link:hover,
        .sidebar-nav #sidebarnav .sidebar-item.active > .sidebar-link,
        .sidebar-nav #sidebarnav .sidebar-item.active > .sidebar-link:hover,
        .sidebar-nav #sidebarnav .sidebar-item > .sidebar-link.active,
        .sidebar-nav #sidebarnav .sidebar-item > .sidebar-link.active:hover,
        .sidebar-nav #sidebarnav .sidebar-link.active,
        .sidebar-nav #sidebarnav .sidebar-link.active:hover,
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link,
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link:hover,
        .sidebar-nav ul .sidebar-item.active > .sidebar-link,
        .sidebar-nav ul .sidebar-item.active > .sidebar-link:hover,
        .sidebar-nav ul .sidebar-item > .sidebar-link.active,
        .sidebar-nav ul .sidebar-item > .sidebar-link.active:hover {
            background: #2563eb !important;
            background-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0px 6px 14px 0px rgba(37, 99, 235, 0.3) !important;
            opacity: 1 !important;
        }
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link i,
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link:hover i,
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link .feather-icon,
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link:hover .feather-icon,
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link span,
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link:hover span,
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link .hide-menu,
        .sidebar-nav #sidebarnav .sidebar-item.selected > .sidebar-link:hover .hide-menu,
        .sidebar-nav #sidebarnav .sidebar-item.active > .sidebar-link i,
        .sidebar-nav #sidebarnav .sidebar-item.active > .sidebar-link:hover i,
        .sidebar-nav #sidebarnav .sidebar-item.active > .sidebar-link span,
        .sidebar-nav #sidebarnav .sidebar-item.active > .sidebar-link:hover span,
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link i,
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link:hover i,
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link span,
        .sidebar-nav ul .sidebar-item.selected > .sidebar-link:hover span {
            color: #ffffff !important;
            background: transparent !important;
            background-color: transparent !important;
        }
        .sidebar-nav #sidebarnav a.has-arrow,
        .sidebar-nav #sidebarnav .sidebar-item.selected > a.has-arrow,
        .sidebar-nav #sidebarnav .sidebar-item.active > a.has-arrow {
            background: transparent !important;
            background-color: transparent !important;
            color: #2a3547 !important;
            box-shadow: none !important;
        }
        .sidebar-nav #sidebarnav a.has-arrow i,
        .sidebar-nav #sidebarnav a.has-arrow .feather-icon,
        .sidebar-nav #sidebarnav a.has-arrow span {
            color: #2a3547 !important;
        }
        .sidebar-nav #sidebarnav li.selected > a.has-arrow::after,
        .sidebar-nav #sidebarnav li.active > a.has-arrow::after,
        .sidebar-nav #sidebarnav a.has-arrow.active::after {
            border-color: #2a3547 !important;
        }
        .sidebar-nav .nav-small-cap {
            font-size: 10.5px !important;
            font-weight: 700 !important;
            letter-spacing: 0.6px !important;
            text-transform: uppercase !important;
            color: #94a3b8 !important;
            padding: 14px 16px 4px 16px !important;
        }
        .sidebar-nav .list-divider {
            margin: 6px 16px !important;
            border-top: 1px solid #f1f5f9 !important;
        }

        /* Disable preloader to prevent white flash screen */
        .preloader {
            display: none !important;
        }

        .app-modal .modal-dialog { max-width: 520px; }
        .app-modal .modal-dialog.modal-sm { max-width: 420px; }
        .app-modal .modal-dialog.modal-lg { max-width: 760px; }
        .app-modal .modal-content {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.16);
            overflow: hidden;
        }
        .app-modal .modal-header {
            align-items: flex-start;
            border: 0;
            padding: 22px 24px 0;
            gap: 12px;
        }
        .app-modal .modal-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.3;
        }
        .app-modal .modal-kicker {
            margin: 4px 0 0;
            font-size: 13px;
            line-height: 1.45;
            color: #64748b;
        }
        .app-modal .btn-close { margin-top: 2px; }
        .app-modal .modal-body { padding: 18px 24px 6px; }
        .app-modal .field { margin-bottom: 14px; }
        .app-modal .field > label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }
        .app-modal .req { color: #dc2626; }
        .app-modal .hint {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            line-height: 1.45;
            color: #64748b;
        }
        .app-modal .field .form-control,
        .app-modal .field .form-select {
            min-height: 40px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            color: #0f172a;
        }
        .app-modal textarea.form-control { min-height: 80px; }
        .app-modal .form-control:focus,
        .app-modal .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }
        .app-modal .modal-footer {
            border: 0;
            justify-content: flex-end;
            gap: 8px;
            padding: 8px 24px 22px;
        }
        .app-modal .btn-modal-cancel,
        .app-modal .btn-modal-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 38px;
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid transparent;
            font-size: 13px;
            font-weight: 600;
            line-height: 1;
        }
        .app-modal .btn-modal-cancel {
            background: #fff;
            border-color: #cbd5e1;
            color: #334155;
        }
        .app-modal .btn-modal-cancel:hover { background: #f8fafc; color: #0f172a; }
        .app-modal .btn-modal-save { background: #17365d; color: #fff; }
        .app-modal .btn-modal-save:hover { background: #102744; color: #fff; }
        .app-modal .btn-modal-save.is-success { background: #047857; }
        .app-modal .btn-modal-save.is-success:hover { background: #065f46; }
        .app-modal .meta-strip {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 16px;
            font-size: 13px;
            color: #334155;
        }
        .app-modal .section-label {
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #64748b;
        }
        .app-modal .return-table { font-size: 13px; }
        .app-modal .return-table th {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #64748b;
            border-bottom-color: #e2e8f0;
        }
        .app-modal .return-table .form-control,
        .app-modal .return-table .form-select {
            min-height: 34px;
            border-radius: 8px;
            font-size: 13px;
        }
        .app-modal .template-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
        }

        .page-wrapper {
            display: block !important;
            transition: none !important;
            background-color: #f8fafc;
            min-height: calc(100vh - 64px);
        }

        .topbar .top-navbar,
        .topbar .navbar-collapse {
            flex-wrap: nowrap;
        }
        .topbar .navbar-collapse > .navbar-nav {
            flex-wrap: nowrap;
            align-items: center;
        }
        .topbar #current-time {
            display: inline-block;
            white-space: nowrap;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
            color: #1e293b;
        }
        .topbar .user-name {
            display: inline-block;
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: middle;
            line-height: 1.2;
        }

        .sidebar-nav #sidebarnav .sidebar-item:not(.selected):not(.active) > .sidebar-link:not(.active):hover,
        .sidebar-nav #sidebarnav .sidebar-item:not(.selected):not(.active) > .sidebar-link:not(.active):hover span {
            background: #f1f5f9 !important;
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }
        .sidebar-nav .has-arrow::after {
            transition: none !important;
        }

        #main-wrapper[data-layout=vertical][data-sidebar-position=fixed] .left-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            height: 100vh;
            overflow: hidden;
        }
        .scroll-sidebar,
        .scroll-sidebar.ps {
            height: 100% !important;
            max-height: none !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
        }
    </style>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
</head>

<body>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-lg">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <div class="navbar-brand">
                        <!-- Logo icon -->
                        <a href="/home">
                            <img src="{{asset('img/itsk.png') }}" alt="Logo USH" class="img-fluid" style="max-height: 48px; object-fit: contain;">
                        </a>
                    </div>
                    <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                        data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle pl-md-3 position-relative" href="javascript:void(0)"
                                id="bell" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <span><i data-feather="bell" class="svg-icon"></i></span>
                                <span class="badge text-bg-primary notify-no rounded-circle"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left mailbox animated bounceInDown">
                                <ul class="list-style-none">
                                    <li>
                                        <div class="message-center notifications position-relative">
                                        </div>
                                    </li>
                                    <li>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                onclick="toggleFullScreen()" title="Full Screen">
                                <i data-feather="maximize" class="svg-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown d-none">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Mode Night">
                                <i data-feather="moon" class="svg-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link" href="javascript:void(0)">
                                <div class="customize-input">
                                    <span id="current-time"></span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item d-none">
                            <a class="nav-link" href="javascript:void(0)">
                                <div class="customize-input">
                                    <select id="languageSelect"
                                        class="custom-select form-control bg-white custom-radius custom-shadow border-0">
                                        <option value="ind" selected>🇮🇩 INDONESIA</option>
                                        <option value="eng">🇺🇸 ENGLISH</option>
                                    </select>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-end">
                        <li class="nav-item d-none">
                            <a class="nav-link" href="javascript:void(0)">
                                <form>
                                    <div class="customize-input">
                                        <input class="form-control custom-shadow custom-radius border-0 bg-white"
                                            type="search" placeholder="Search" aria-label="Search">
                                        <i class="form-control-icon" data-feather="search"></i>
                                    </div>
                                </form>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('assets/images/users/1.jpg') }}" alt="user" class="rounded-circle"
                                    width="40">
                                @php $headerName = Auth::user()->name ?? session('siakad_user_name', 'Pengguna'); @endphp
                                <span class="ms-2 d-none d-lg-inline-block"><span>Halo,</span> <span
                                        class="text-dark user-name" title="{{ $headerName }}">{{ $headerName }}</span> <i data-feather="chevron-down"
                                        class="svg-icon"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                                <a class="dropdown-item" href="{{ route('user.profile') }}"><i data-feather="user"
                                        class="svg-icon me-2 ms-1"></i>
                                    Profil saya</a>
                                <!--<a class="dropdown-item" href="javascript:void(0)"><i data-feather="settings"-->
                                <!--        class="svg-icon me-2 ms-1"></i>-->
                                <!--    Account Setting</a>-->
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="/logout" id="logout-form" style="display:inline;">
                                    @csrf
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i data-feather="power"
                                            class="svg-icon me-2 ms-1"></i>
                                        Keluar</a>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                @include('layout.sidebar')
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            @yield('inti')
            <footer class="footer text-center text-muted">
                Hak cipta 2025. <a href="https://sugenghartono.ac.id/">Universitas
                    Sugeng Hartono</a>.
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
    <script>
    // Initialize Feather icons
    feather.replace(); // This replaces the data-feather="maximize" with the SVG icon

    // Function to toggle full screen
    function toggleFullScreen() {
        // Check if the browser supports full screen
        if (!document.fullscreenElement && // Check if we're not in fullscreen
            !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {

            // Request full screen for the document body
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) { // Firefox
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) { // Chrome, Safari and Opera
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) { // IE/Edge
                document.documentElement.msRequestFullscreen();
            }
        } else {
            // Exit full screen if we're already in full screen
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { // Firefox
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) { // Chrome, Safari and Opera
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { // IE/Edge
                document.msExitFullscreen();
            }
        }
    }
    </script>
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.querySelectorAll('.modal').forEach(function (modal) {
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
        });
    </script>
    <!-- apps -->
    <!-- apps -->
    <script src="{{asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{asset('dist/js/feather.min.js') }}"></script>
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('dist/js/custom.min.js') }}"></script>
    <script>
    function formatDateToWIB(date) {
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour12: false
        };
        return date.toLocaleString('id-ID', options);
    }

    setInterval(function() {
        const currentTime = new Date();
        document.getElementById("current-time").textContent = formatDateToWIB(currentTime);
    }, 1000);
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const languageSelect = document.getElementById("languageSelect");
        if (!languageSelect) {
            return;
        }

        // Fungsi untuk mengubah bahasa menggunakan Google Translate
        function translatePage(language) {
            if (language === 'en') {
                // Redirect menggunakan Google Translate
                const currentUrl = window.location.href;
                const googleTranslateUrl =
                    `https://translate.google.com/translate?sl=id&tl=en&u=${encodeURIComponent(currentUrl)}`;
                window.location.href = googleTranslateUrl;
            } else {
                // Kembali ke halaman original tanpa terjemahan
                window.location.reload();
            }
        }

        // Event listener untuk dropdown
        languageSelect.addEventListener("change", function() {
            const selectedLanguage = languageSelect.value;
            translatePage(selectedLanguage);
        });
    });

    function updatePerPage(val) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', val);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
    </script>

    <!-- SweetAlert2 Library & Global Professional Confirmation Handler -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Intercept forms that have onsubmit with confirm() or class .form-delete
        document.querySelectorAll('form[onsubmit*="confirm"], form.form-delete').forEach(function(form) {
            const onsubmitAttr = form.getAttribute('onsubmit') || '';
            const dataTitle = form.getAttribute('data-title');
            const dataText = form.getAttribute('data-text');

            let message = 'Data yang dihapus tidak dapat dikembalikan.';
            if (dataText) {
                message = dataText;
            } else if (onsubmitAttr) {
                const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
                if (match && match[1]) {
                    message = match[1];
                }
            }

            const methodInput = form.querySelector('input[name="_method"]');
            const method = (methodInput ? methodInput.value : 'POST').toUpperCase();
            const isDelete = method === 'DELETE' || /hapus/.test(message.toLowerCase());
            const title = dataTitle || (isDelete ? 'Hapus data?' : 'Konfirmasi');

            // Remove native inline onsubmit so browser native popup never fires
            form.removeAttribute('onsubmit');
            form.onsubmit = null;

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: title,
                    text: message,
                    icon: isDelete ? 'warning' : 'question',
                    showCancelButton: true,
                    confirmButtonColor: isDelete ? '#dc2626' : '#2563eb',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: isDelete ? '<i class="fas fa-trash me-1"></i> Ya, Hapus' : 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // 2. Intercept links that have onclick with confirm()
        document.querySelectorAll('a[onclick*="confirm"]').forEach(function(link) {
            const onclickAttr = link.getAttribute('onclick') || '';
            const match = onclickAttr.match(/confirm\(['"](.*?)['"]\)/);
            const message = match && match[1] ? match[1] : 'Apakah Anda yakin ingin melanjutkan tindakan ini?';

            link.removeAttribute('onclick');
            link.onclick = null;

            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetUrl = link.getAttribute('href');
                Swal.fire({
                    title: 'Konfirmasi Tindakan',
                    text: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed && targetUrl && targetUrl !== '#') {
                        window.location.href = targetUrl;
                    }
                });
            });
        });

        // 3. Delegate handler for dynamically clicked delete buttons
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-trigger-delete, [data-confirm-delete]');
            if (btn) {
                e.preventDefault();
                const form = btn.closest('form');
                const title = btn.getAttribute('data-title') || form?.getAttribute('data-title') || 'Hapus Jadwal?';
                const text = btn.getAttribute('data-text') || form?.getAttribute('data-text') || 'Data ini akan dihapus secara permanen.';

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-trash me-1"></i> Ya, Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed && form) {
                        form.submit();
                    }
                });
            }
        });

        const sidebarnav = document.querySelector('#sidebarnav');
        if (sidebarnav) {
            sidebarnav.addEventListener('click', function (event) {
                const arrow = event.target.closest('a.has-arrow');
                if (!arrow || !sidebarnav.contains(arrow)) {
                    return;
                }
                event.preventDefault();
                event.stopPropagation();

                const submenu = arrow.nextElementSibling;
                if (!submenu || !submenu.classList.contains('collapse')) {
                    return;
                }

                const willOpen = !submenu.classList.contains('in');
                submenu.classList.toggle('in', willOpen);
                submenu.classList.toggle('show', willOpen);
                submenu.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                arrow.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                arrow.classList.remove('active');
            }, true);
        }

        const sidebarScroller = document.querySelector('.scroll-sidebar');
        if (window.jQuery && jQuery.fn.perfectScrollbar && sidebarScroller) {
            try {
                jQuery(sidebarScroller).perfectScrollbar('destroy');
            } catch (error) {}
            sidebarScroller.style.height = '';
            sidebarScroller.style.overflow = '';
        }

        function scrollActiveIntoView(link) {
            if (!sidebarScroller || !link || link.offsetHeight < 1) {
                return;
            }
            const linkRect = link.getBoundingClientRect();
            const scrollerRect = sidebarScroller.getBoundingClientRect();
            const padding = 12;
            if (linkRect.top >= scrollerRect.top + padding && linkRect.bottom <= scrollerRect.bottom - padding) {
                return;
            }
            sidebarScroller.scrollTop += linkRect.top - scrollerRect.top - padding;
        }

        (function keepSidebarOnCurrentMenu() {
            const current = (location.pathname || '/').replace(/\/+$/, '') || '/';
            const links = Array.from(document.querySelectorAll('#sidebarnav a.sidebar-link'));
            let match = null;
            let matchLength = -1;

            links.forEach(function (link) {
                const href = link.getAttribute('href') || '';
                if (!href || href === '#' || href.indexOf('javascript:') === 0) {
                    return;
                }
                let path;
                try {
                    path = new URL(href, location.origin).pathname.replace(/\/+$/, '') || '/';
                } catch (error) {
                    return;
                }
                if (path !== '/' && (path === current || current.indexOf(path + '/') === 0)) {
                    if (path.length > matchLength) {
                        match = link;
                        matchLength = path.length;
                    }
                }
            });

            if (!match) {
                return;
            }

            links.forEach(function (link) {
                link.classList.remove('active');
                const item = link.closest('.sidebar-item');
                if (item) {
                    item.classList.remove('active', 'selected');
                }
            });

            match.classList.add('active');
            const item = match.closest('.sidebar-item');
            if (item) {
                item.classList.add('selected');
            }

            const submenu = match.closest('ul.collapse');
            if (submenu) {
                submenu.classList.add('in', 'show');
                const parentLink = submenu.parentElement ? submenu.parentElement.querySelector(':scope > a.has-arrow') : null;
                if (parentLink) {
                    parentLink.setAttribute('aria-expanded', 'true');
                }
            }

            function clearParentArrow() {
                document.querySelectorAll('#sidebarnav a.has-arrow').forEach(function (arrow) {
                    arrow.classList.remove('active');
                    const parentItem = arrow.closest('.sidebar-item');
                    if (parentItem) {
                        parentItem.classList.remove('active', 'selected');
                    }
                });
            }

            clearParentArrow();
            scrollActiveIntoView(match);
            window.addEventListener('load', function () {
                clearParentArrow();
                scrollActiveIntoView(match);
            });
            setTimeout(clearParentArrow, 30);
        })();
    });
    </script>

</body>

</html>