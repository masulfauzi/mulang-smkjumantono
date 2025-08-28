<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ config('app.name', 'Laralag') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">

</head>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <div class="logo">
                            <a href="{{ route('frontend.index') }}">
                                <h5 class="mb-0"> <i class="bi bi-tornado"></i> {{ config('app.name') }}</h5>
                            </a>
                        </div>
                        <div class="header-top-right">

                            <!-- Burger button responsive -->
                            <a href="#" class="burger-btn d-block d-xl-none">
                                <i class="bi bi-justify fs-3"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <nav class="main-navbar">
                    <div class="container">
                        <ul>
                            <li class="menu-item">
                                <a href="{{ route('frontend.index') }}" class='menu-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Home</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('login') }}" class='menu-link'>
                                    <i class="bi bi-door-open-fill"></i>
                                    <span>Login</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('snbp') }}" class='menu-link'>
                                    <i class="bi bi-door-open-fill"></i>
                                    <span>SNBP</span>
                                </a>
                            </li>
                            {{-- <li class="menu-item active has-sub">
                                <a href="#" class='menu-link'>
                                    <i class="bi bi-grid-1x2-fill"></i>
                                    <span>Layouts</span>
                                </a>
                                <div class="submenu">
                                    <div class="submenu-group-wrapper">
                                        <ul class="submenu-group">
                                            <li class="submenu-item">
                                                <a href="layout-default.html" class='submenu-link'>Default Layout</a>
                                            </li>
                                            <li class="submenu-item">
                                                <a href="layout-vertical-1-column.html" class='submenu-link'>1 Column</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                </nav>
                <hr class="m-0 bg-primary">
            </header>
            <div class="content-wrapper container">


                <div class="page-content">
                    <section class="row">
                        <div class="col-12 col-lg-4">
                        </div>
                        <div class="col-12 col-lg-4">

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Cek Status Siswa Eligible</h4>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('snbp') }}" method="POST">
                                                @csrf
                                                <x-form-group class="position-relative has-icon-left mb-4">
                                                    <input type="text" class="form-control form-control-xl"
                                                        placeholder="NISN" name="nisn" :value="old('nisn')"
                                                        required autofocus>
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </x-form-group>
                                                <button
                                                    class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Kirim!</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </section>
                </div>

            </div>

            <footer>
                <div class="container">
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-start">
                            <p>2021 &copy; Mazer</p>
                        </div>
                        <div class="float-end">
                            <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                    href="https://saugi.me">Saugi</a></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/pages/horizontal-layout.js') }}"></script>
</body>

</html>
