<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('img/ushh.png') }}">
    <title>SILABO Universitas Sugeng Hartono</title>
    <link href="{{asset('dist/css/style.min.css') }}" rel="stylesheet">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-lg">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <div class="navbar-brand">
                        <!-- Logo icon -->
                        <a href="">
                            <img src="{{asset('img/itsk.png') }}" alt="" class="img-fluid">
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
                        <li class="nav-item dropdown">
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
                        <li class="nav-item d-none d-md-block">
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
                        <li class="nav-item d-none d-md-block">
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
                                <span class="ms-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                        class="text-dark">{{ session('siakad_user_name', 'Pengguna') }}</span> <i data-feather="chevron-down"
                                        class="svg-icon"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                                <a class="dropdown-item" href="/viewuser"><i data-feather="user"
                                        class="svg-icon me-2 ms-1"></i>
                                    My Profile</a>
                                <!--<a class="dropdown-item" href="javascript:void(0)"><i data-feather="settings"-->
                                <!--        class="svg-icon me-2 ms-1"></i>-->
                                <!--    Account Setting</a>-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/logout"><i data-feather="power"
                                        class="svg-icon me-2 ms-1"></i>
                                    Logout</a>
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
                All Rights Reserved 2025. Designed and Developed by <a href="https://sugenghartono.ac.id/">Universitas
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
    </script>

</body>

</html>