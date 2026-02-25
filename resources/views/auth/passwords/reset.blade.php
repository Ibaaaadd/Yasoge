<!DOCTYPE html>
<html lang="en">

<head>
    <title>YASOGE - Reset Password</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="{{ asset('assets/plugins/fontawesome/js/all.min.js') }}"></script>
    <link id="theme-style" rel="stylesheet" href="{{ asset('assets/css/portal.css') }}">
</head>

<body class="app app-login p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4">
                        <a class="app-logo" href="{{ route('login') }}">
                            <img class="logo-icon me-2" src="{{ asset('logo/Yasoge.png') }}" alt="logo">
                        </a>
                    </div>
                    <h1 class="auth-heading text-center mb-3">
                        <div class="fw-bold">Reset Password</div>
                    </h1>
                    <p class="text-muted mb-4">Buat password baru untuk akun Anda.</p>

                    <div class="auth-form-container text-start">
                        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="email mb-3">
                                <label class="sr-only" for="email">Email</label>
                                <input id="email" name="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email address" required value="{{ $email ?? old('email') }}"
                                    autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="password mb-3">
                                <label class="sr-only" for="password">Password Baru</label>
                                <input id="password" name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password baru" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="password mb-3">
                                <label class="sr-only" for="password-confirm">Konfirmasi Password</label>
                                <input id="password-confirm" name="password_confirmation" type="password"
                                    class="form-control"
                                    placeholder="Konfirmasi password baru" required autocomplete="new-password">
                            </div>

                            <div class="text-center mb-3">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">
                                    <i class="fa-solid fa-key me-2"></i>Reset Password
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="btn btn-link text-muted">
                                    <i class="fa-solid fa-arrow-left me-1"></i>Kembali ke Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <footer class="app-auth-footer">
                    <div class="container text-center py-3 mt-5">
                        <small class="copyright">Created
                            <img src="{{ asset('logo/Yasoge.png') }}" alt="Yasoge logo"
                                style="width: 20px; height: auto; color: #fb866a;">
                            by Yasoge @2024
                        </small>
                    </div>
                </footer>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="image-container">
                <img src="{{ asset('logo/Yasoge Walpaper.jpg') }}" alt="">
            </div>
            <div class="auth-background-mask"></div>
        </div>
    </div>
</body>

<style>
    .auth-background-col {
        position: relative;
        overflow: hidden;
    }
    .image-container {
        height: 100%;
        width: 100%;
    }
    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
</style>

</html>
