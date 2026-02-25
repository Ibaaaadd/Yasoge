<!DOCTYPE html>
<html lang="en">

<head>
    <title>YASOGE</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS-->
    <script defer src="assets/plugins/fontawesome/js/all.min.js"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="assets/css/portal.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="app app-login p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img
                                class="logo-icon me-2" src="{{ asset('logo/Yasoge.png') }}" alt="logo"></a></div>
                    <h1 class="auth-heading text-center mb-5">
                        <div class="fw-bold">YASOGE</div>
                    </h1>
                    <div class="auth-form-container text-start">
                        <!-- Gunakan form Laravel -->
                        <form method="POST" action="{{ route('login') }}" class="auth-form login-form">
                            @csrf
                            <div class="email mb-3">
                                <label class="sr-only" for="email">Email</label>
                                <input id="email" name="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email address" required="required" value="{{ old('email') }}"
                                    autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                            </div><!--//form-group-->
                            <div class="password mb-3">
                                <label class="sr-only" for="password">Password</label>
                                <input id="password" name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required="required" autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                    </span>
                                @enderror
                                <div class="extra mt-3 row justify-content-between">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                Remember me
                                            </label>
                                        </div>
                                    </div><!--//col-6-->
                                    <div class="col-6">
                                        <div class="forgot-password text-end">
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div><!--//col-6-->
                                </div><!--//extra-->
                            </div><!--//form-group-->
                            <div class="text-center">
                                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log
                                    In</button>
                            </div>
                        </form>
                    </div><!--//auth-form-container-->
                </div><!--//auth-body-->

                <footer class="app-auth-footer">
                    <div class="container text-center py-3 mt-5">
                        <small class="copyright">Created
                            <img src="{{ asset('logo/Yasoge.png') }}" alt="Yasoge logo"
                                style="width: 20px; height: auto; color: #fb866a;">
                            by Yasoge @2024
                        </small>
                    </div>
                </footer><!--//app-footer-->
            </div><!--//flex-column-->
        </div><!--//auth-main-col-->
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="image-container">
                <img src="{{ asset('logo/Yasoge Walpaper.jpg') }}" alt="">
            </div>
            <div class="auth-background-mask"></div>
        </div><!--//auth-background-col-->

    </div><!--//row-->

    @if ($errors->has('email'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '{{ addslashes($errors->first('email')) }}',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
    </script>
    @elseif ($errors->has('password'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: '{{ addslashes($errors->first('password')) }}',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
    </script>
    @endif

</body>
<style>
    .auth-background-col {
        position: relative;
        overflow: hidden;
        /* Memastikan konten tidak keluar dari div */
    }

    .image-container {
        height: 100%;
        width: 100%;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Memastikan gambar menutupi seluruh container tanpa distorsi */
        object-position: center;
        /* Menjaga bagian tengah gambar tetap terlihat */
    }
</style>

</html>
