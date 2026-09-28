<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('dist/img/ushh.png') }}">
    <title>SILABO - Universitas Sugeng Hartono</title>
    <link href="{{asset('dist/css/style.min.css') }}" rel="stylesheet">
    <style>
    .auth-box {
        background-color: #fff;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        border-radius: 15px;
        overflow: hidden;
    }

    .form-control {
        border: 1px solid #ddd;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #17365D;
        box-shadow: 0 0 5px rgba(23, 54, 93, 0.5);
    }

    .btn-primary {
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #145391;
        box-shadow: 0 4px 10px rgba(20, 83, 145, 0.4);
    }

    .auth-wrapper {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text-primary {
        color: #17365D !important;
        text-decoration: none;
    }

    .text-primary:hover {
        text-decoration: underline;
        color: #145391 !important;
    }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url(../assets/images/big/auth-bg.jpg) no-repeat center center; background-size: cover;">
            <div class="auth-box row text-center shadow-lg"
                style="border-radius: 15px; overflow: hidden; width: 400px;">
                <div class="col-lg-12 col-md-7 bg-white p-4">
                    <div class="p-3">
                        <img src="{{asset('img/itsk.png') }}" alt="wrapkit" style="width: 80%; margin-bottom: 20px;">
                        <h2 class="mt-3 text-center" style="font-weight: 700; color: #17365D;">SILABO USH</h2>
                        <p style="font-size: 1rem; color: #555;">SSO Account (SIAKAD)</p>
                        @if (session('error'))
                        <div class="alert alert-danger py-2 small mb-3 text-start" style="border-radius: 10px;">
                            <i class="fa fa-circle-exclamation me-1"></i> {{ session('error') }}
                        </div>
                        @endif
                        <form action="/login" method="POST" class="mt-4">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" name="email" class="form-control" placeholder="Email / NIM / NIDN" required
                                    style="border-radius: 30px; height: 45px; font-size: 14px;" value="{{ old('email') }}">
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    required style="border-radius: 30px; height: 45px; font-size: 14px;">
                            </div>
                            @if (isset($errors) && $errors->has('email'))
                            <div class="text-danger text-left small mb-2">
                                {{ $errors->first('email') }}
                            </div>
                            @endif
                            <button type="submit" class="btn btn-primary btn-block mt-3 w-100"
                                style="border-radius: 30px; height: 45px; background-color: #17365D; font-size: 15px; font-weight: 600;">
                                Masuk ke Sistem
                            </button>
                            <div class="mt-3 text-center">
                                <a href="/" class="text-muted small" style="text-decoration: none;">
                                    &larr; Kembali ke Portal Utama
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(".preloader ").fadeOut();
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
</body>

</html>