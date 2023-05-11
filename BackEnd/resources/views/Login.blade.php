<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login page</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    {{-- Favicons --}}
    <link href="{{ Vite::asset('resources/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ Vite::asset('resources/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    {{-- Link css, js vite --}}
    @vite(['resources/css/app.css', 'resources/js/main.js', 'resources/js/app.js', 'resources/assets/vendor/bootstrap/css/bootstrap.min.css', 'resources/assets/vendor/bootstrap-icons/bootstrap-icons.css', 'resources/assets/vendor/boxicons/css/boxicons.min.css', 'resources/assets/vendor/quill/quill.snow.css', 'resources/assets/vendor/quill/quill.bubble.css', 'resources/assets/vendor/remixicon/remixicon.css', 'resources/assets/vendor/simple-datatables/style.css', 'resources/assets/vendor/apexcharts/apexcharts.min.js', 'resources/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', 'resources/assets/vendor/chart.js/chart.umd.js', 'resources/assets/vendor/echarts/echarts.min.js', 'resources/assets/vendor/quill/quill.min.js', 'resources/assets/vendor/simple-datatables/simple-datatables.js', 'resources/assets/vendor/tinymce/tinymce.min.js', 'resources/assets/vendor/php-email-form/validate.js'])
</head>

<body>
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Enterprise Manager</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-2 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your email & password to login</p>
                                    </div>

                                    <form class="row g-3 needs-validation" method="POST">
                                        @csrf
                                        @if (Session::has('error'))
                                            <div class="alert alert-danger">
                                                {{ Session::get('error') }}
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email
                                                address</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="name@runsystem.net" name="email"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <div class="invalidate">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                placeholder="Please enter your password">
                                            @error('password')
                                                <div class="invalidate">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main><!-- End #main -->
</body>

</html>
