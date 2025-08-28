<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{  config('app.name', 'Laralag') }}</title>
    
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
        <div class="col-12 col-lg-2">
        </div>
        <div class="col-12 col-lg-8">
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Cek Status Siswa Eligible SNBP</h4>
                        </div>
                        <div class="card-body">

                            @if (!$data)
                                Data tidak ditemukan.
                            @else

                                <table class="table table-bordered">
                                    <tr>
                                        <th>Nama</th>
                                        <td>{{ $data->nama_siswa }}</td>
                                    </tr>
                                    <tr>
                                        <th>NISN</th>
                                        <td>{{ $data->nisn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td>{{ $data->kelas }}</td>
                                    </tr>
                                </table>

                                <table class="table">
                                    <tr>
                                        <th>No</th>
                                        <th>Semester</th>
                                        <th style="text-align: center;">Rata-Rata Nilai</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Semester 1</td>
                                        <td style="text-align: center;">{{ round($data->jml_nilai_1/$data->pembagi_1,3) }}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Semester 2</td>
                                        <td style="text-align: center;">{{ round($data->jml_nilai_2/$data->pembagi_2,3) }}</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Semester 3</td>
                                        <td style="text-align: center;">{{ round($data->jml_nilai_3/$data->pembagi_3,3) }}</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Semester 4</td>
                                        <td style="text-align: center;">{{ round($data->jml_nilai_4/$data->pembagi_4,3) }}</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Semester 5</td>
                                        <td style="text-align: center;">{{ round($data->jml_nilai_5/$data->pembagi_5,3) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Rata-Rata Nilai Akhir</td>
                                        <td style="font-size: 20px; font-weight: bold; background-color: #c7b19f; text-align: center;">{{ $data->rata_rata }}</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td colspan="3">Anda peringkat {{ $data->peringkat }} dari {{ count($kuota) }} siswa.</td>
                                    </tr>
                                    @if ($data->is_eligible == 1)
                                        <tr>
                                            <td colspan="3" style="text-align: center; color: green; font-size: 25px;">SELAMAT! Anda masuk kriteria siswa Eligible SNBP.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Download Form Pernyataan:<br>
                                            <ul>
                                                <li><a href="{{ url('/download/form/SURAT PERNYATAAN MASUK PERINGKAT BERMINAT.docx') }}">Eligible & Berminat</a></li>
                                                <li><a href="{{ url('/download/form/SURAT PERNYATAAN MASUK PERINGKAT TIDAK BERMINAT.docx') }}">Eligible tapi Tidak Berminat</a></li>
                                            </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Download Nilai
                                                <ul>
                                                    @php
                                                        $link = '/download/nilai/';
                                                        $link .= strtolower($data->singkatan);
                                                        $link .= '/'.$data->nisn.'.pdf';
                                                    @endphp
                                                    <li><a target="_blank" href="{{ url($link) }}">Download Nilai Eligible</a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="3" style="text-align: center; color: red; font-size: 25px;">Anda belum termasuk kriteria siswa Eligible SNBP. <br>
                                            Tetap Semangat, Silahkan mengikuti seleksi jalur yang lain.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Download Form Pernyataan:<br>
                                                <ul>
                                                    <li><a href="{{ url('/download/form/SURAT PERNYATAAN TIDAK MASUK PERINGKAT BERMINAT.docx') }}">Tidak Eligible & Berminat</a></li>
                                                </ul>
                                                </td>
                                        </tr>
                                    @endif
                                    
                                    
                                </table>

                            @endif
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
