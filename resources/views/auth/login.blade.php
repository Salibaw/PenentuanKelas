<!doctype html>
<html lang="en">

<head>
    {{-- buat tes ngrok --}}
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login Page</title>
    <link href="{{ asset('tabler/dist/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('tabler/dist/css/demo.min.css?1692870487') }}" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        /* PERBAIKAN: Sembunyikan mata bawaan dari browser (seperti Microsoft Edge) */
        input::-ms-reveal,
        input::-ms-clear {
            display: none !important;
        }
    </style>
</head>

<body class=" d-flex flex-column">
    <script src="{{ asset('tabler/dist/js/demo-theme.min.js?1692870487') }}"></script>
    <div class="page page-center">
        <div class="container container-normal py-4">
            <div class="row align-items-center g-4">
                <div class="col-lg">
                    <div class="container-tight">
                        <div class="text-center mb-4">
                            <a href="{{ url()->previous() }}" class="btn btn-link mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12h14" />
                                    <path d="M5 12l6 -6" />
                                    <path d="M5 12l6 6" />
                                </svg>
                                Back
                            </a>
                            <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg"
                                    height="36" alt="">
                            </a>
                        </div>
                        <div class="card card-md">
                            <div class="card-body">
                                <h2 class="h2 text-center mb-4">Login to your account</h2>
                                @if (Session::get('warning'))
                                <div class="alert alert-warning">
                                    <p>{{ Session::get('warning') }}</p>
                                </div>
                                @endif

                                <form action="{{ route('proseslogin') }}" method="post" autocomplete="off" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="your@email.com" autocomplete="off" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">
                                            Password
                                            <span class="form-label-description">
                                                <a href="{{ route('password.request') }}">I forgot password</a>
                                            </span>
                                        </label>
                                        <div class="input-group input-group-flat">
                                            {{-- PERBAIKAN: Menambahkan ID pada input password --}}
                                            <input type="password" name="password" id="password" class="form-control"
                                                placeholder="Your password" autocomplete="off">
                                            <span class="input-group-text">
                                                {{-- PERBAIKAN: Menambahkan ID pada tombol toggle --}}
                                                <a href="#" class="link-secondary" id="toggle-password" title="Show password" style="text-decoration: none;">
                                                    
                                                    {{-- Ikon Mata Terbuka --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-eye"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                    </svg>

                                                    {{-- Ikon Mata Dicoret (Tersembunyi di awal dengan kelas d-none) --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-eye-off d-none" 
                                                        width="24" height="24" viewBox="0 0 24 24" 
                                                        stroke-width="2" stroke="currentColor" fill="none" 
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" />
                                                        <path d="M9.363 5.365a9 9 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
                                                        <path d="M3 3l18 18" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input" />
                                            <span class="form-check-label">Remember me on this device</span>
                                        </label>
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-lg d-none d-lg-block">
                    <img src="{{ asset('tabler/static/illustrations/undraw_secure_login_pdn4.svg') }}" height="300"
                        class="d-block mx-auto" alt="">
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('tabler/dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('tabler/dist/js/demo.min.js?1692870487') }}" defer></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            
            if (togglePassword && passwordInput) {
                const iconEye = togglePassword.querySelector('.icon-eye');
                const iconEyeOff = togglePassword.querySelector('.icon-eye-off');

                togglePassword.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        iconEye.classList.add('d-none');       // Sembunyikan ikon mata normal
                        iconEyeOff.classList.remove('d-none'); // Tampilkan ikon mata dicoret
                    } else {
                        // Kembalikan ke mode tersembunyi
                        passwordInput.type = 'password';
                        iconEye.classList.remove('d-none');    // Tampilkan ikon mata normal
                        iconEyeOff.classList.add('d-none');    // Sembunyikan ikon mata dicoret
                    }
                });
            }
        });
    </script>
</body>

</html>