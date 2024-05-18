<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Reset Password</title>
    <link rel="icon" href="{{asset('assets/img/unsplash/logo.png')}}" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-social/bootstrap-social.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/izitoast/css/iziToast.min.css')}}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body.bg-image {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh; /* Ensure the body takes at least the full viewport height */
            position: relative;
        }

        body.bg-image::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5); /* Adjust the color and opacity as needed */
            z-index: -1;
        }

        .content {
            flex-grow: 1; /* Allow the content to take up remaining space */
        }
    </style>
</head>

<body  style="height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-info shadow">
                    <div class="card-header text-white">
                        <h4 class="text-info">Rubah Password</h4>
                    </div>
                    <div class="card-body">
                        <!-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif -->
                        @if (session()->has('status'))
                            <div class="alert alert-success">
                                {{ session()->get('status') }}
                            </div>
                        @endif
                        <form action="{{ route('password.update') }}" method="post">
                            @csrf
                            <input type="hidden" name="token" value="{{ request()->token }}">
                            <input type="hidden" name="email" value="{{ request()->email }}">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="password Baru">
                                <div id="warning-message" style="color: red; display: none;">
                                    Password minimal 8 karakter dan 1 huruf kapital
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password Baru">
                            </div>
                            <button type="submit" class="btn btn-info btn-block">Rubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    
    <!-- General JS Scripts -->
    <script src="{{asset('assets/modules/jquery.min.js')}}"></script>
    <script src="{{asset('assets/modules/popper.js')}}"></script>
    <script src="{{asset('assets/modules/tooltip.js')}}"></script>
    <script src="{{asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('assets/modules/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/stisla.js')}}"></script>

    <!-- JS Libraies -->
    <script src="{{asset('assets/modules/izitoast/js/iziToast.min.js')}}"></script>
    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <!-- Custom Script for Izitoast alert -->
<script>
    $(document).ready(function () {
        @if ($errors->has('password'))
            iziToast.error({
                title: 'Error',
                message: '{{ $errors->first('password') }}',
                position: 'topRight',
            });
        @endif

        @if ($errors->has('password_confirmation'))
            iziToast.error({
                title: 'Error',
                message: '{{ $errors->first('password_confirmation') }}',
                position: 'topRight',
            });
        @endif

        @if ($errors->has('token'))
            iziToast.error({
                title: 'Error',
                message: '{{ $errors->first('token') }}',
                position: 'topRight',
            });
        @endif

        @if ($errors->has('email'))
            iziToast.error({
                title: 'Error',
                message: '{{ $errors->first('email') }}',
                position: 'topRight',
            });
        @endif

        @if (session()->has('status'))
            iziToast.success({
                title: 'Success',
                message: '{{ session()->get('status') }}',
                position: 'topRight',
            });
        @endif
    });

    // Ambil referensi ke elemen input password
    const passwordInput = document.getElementById('password');

    // Tambahkan event listener untuk memeriksa input setiap kali pengguna mengetik
    passwordInput.addEventListener('input', function() {
        // Ambil nilai password dari input
        const password = passwordInput.value;

        // Periksa panjang password
        const isLengthValid = password.length >= 8;

        // Periksa apakah setidaknya satu huruf kapital ada di dalam password
        const hasCapitalLetter = /[A-Z]/.test(password);

        // Jika panjang password tidak mencukupi atau tidak memiliki huruf kapital
        if (!isLengthValid || !hasCapitalLetter) {
            // Tampilkan pesan kesalahan
            document.getElementById('warning-message').style.display = 'block';
        } else {
            // Hapus pesan kesalahan jika password valid
            document.getElementById('warning-message').style.display = 'none';
        }
    });
</script>

</body>
</html>