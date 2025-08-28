@extends('layouts.app')

@section('page-css')
    <style>
        .sembunyi {
            display: none;
        }
    </style>
    <style>
        .timer {
            margin: 0 0 45px;
            font-family: sans-serif;
            color: #fff;
            display: inline-block;
            font-weight: 100;
            text-align: center;
            font-size: 30px;
        }

        .timer div {
            padding: 10px;
            border-radius: 3px;
            background: #6b02ff;
            display: inline-block;
            font-family: Oswald;
            font-size: 26px;
            font-weight: 400;
            width: 80px;
        }

        .timer .smalltext {
            color: #ffffff;
            font-size: 12px;
            font-family: Poppins;
            font-weight: 500;
            display: block;
            padding: 0;
            width: auto;
        }

        .timer #time-up {
            margin: 8px 0 0;
            text-align: left;
            font-size: 14px;
            font-style: normal;
            color: #000000;
            font-weight: 500;
            letter-spacing: 1px;
        }
    </style>
@endsection

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-2">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Data {{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Form Transkrip Nilai
                </h6>
                <div class="card-body">
                    @include('include.flash')
                    <form class="form form-horizontal" action="{{ route('nilai.siswa.index') }}" method="GET"
                        enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Semester</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {!! Form::select('id_semester', $ref_semester, $id_semester, ['class' => 'form-control select2']) !!}
                                </div>
                            </div>
                            <div class="offset-md-3 ps-2">
                                <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </section>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Tabel Transkrip Nilai
                </h6>
                <div class="card-body">
                    @if ($semester != null)
                        <p style="text-align: center; font-size: large;">TRANSKRIP NILAI SEMESTER {{ $semester->semester }}
                        </p>
                    @endif

                    <table class="table">
                        <tr>
                            <th>No</th>
                            <th>Mapel</th>
                            <th>Nilai</th>
                        </tr>
                        @php
                            $no = 1;
                        @endphp

                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->mapel->mapel }}</td>
                                <td>{{ $item->nilai }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center"><i>No data.</i></td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>

            @if ($id_semester)
                <div class="card">
                    <h6 class="card-header">
                        Konfirmasi Nilai Semester
                    </h6>
                    <div class="card-body">

                        @if ($konfirmasi)
                            @if ($konfirmasi->is_sesuai == 1)
                                <p>Data Nilai sudah dikonfirmasi sesuai</p>
                            @else
                                <p>Data Nilai sudah dikonfirmasi Tidak sesuai</p>
                                <p>Keterangan:</p>
                                {!! $konfirmasi->keterangan !!}
                                <p>Bukti:</p>
                                <img src="{{ url('uploads/bukti_nilai/' . $konfirmasi->bukti) }}" width="400px;"
                                    alt="Foto Pekerjaan">
                            @endif

                            <a href="{{ route('konfirmasinilai.batal_konfirmasi.store', $konfirmasi->id) }}"
                                class="btn btn-danger">Reset
                                Konfirmasi</a>
                        @else
                            <h5 id="xpengumuman">Konfirmasi Nilai telah berakhir</h5>
                            <h5 id="pengumuman">Konfirmasi Nilai akan berakhir pada:</h5>
                            <div class="timer" id="timer">
                                <div>
                                    <span class="days" id="day"></span>
                                    <div class="smalltext">Hari</div>
                                </div>
                                <div>
                                    <span class="hours" id="hour"></span>
                                    <div class="smalltext">Jam</div>
                                </div>
                                <div>
                                    <span class="minutes" id="minute"></span>
                                    <div class="smalltext">Menit</div>
                                </div>
                                <div>
                                    <span class="seconds" id="second"></span>
                                    <div class="smalltext">Detik</div>
                                </div>
                                <p id="time-up"></p>
                            </div>
                            @if ($waktu_sekarang > $batas_waktu)
                                <h3>Waktu verifikasi nilai sudah habis.</h3>
                            @else
                                <form class="form form-horizontal" method="POST" enctype="multipart/form-data"
                                    action="{{ route('konfirmasinilai.store') }}">
                                    @csrf
                                    <input type="hidden" name="id_siswa" value="{{ session('id_siswa') }}">
                                    <input type="hidden" name="id_semester" value="{{ $id_semester }}">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                                <label>Konfirmasi Nilai</label>
                                            </div>
                                            <div class="col-md-9 form-group">
                                                <input type="radio" name="is_sesuai" value="1"
                                                    onclick="disableKeterangan()">
                                                Sudah Sesuai
                                                <br>
                                                <input type="radio" name="is_sesuai" value="0"
                                                    onclick="enableKeterangan()">
                                                Belum Sesuai

                                            </div>
                                        </div>
                                        <div class="keterangan sembunyi" id="keterangan">

                                            <div class="row">
                                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                                    <label>Keterangan</label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <textarea name="keterangan" cols="30" rows="10" class="form-control rich-editor"></textarea>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                                    <label>Bukti</label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="file" name="bukti" class="form-control">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                                <label></label>
                                            </div>
                                            <div class="col-md-9 form-group">

                                                <button class="btn btn-primary" type="submit">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        @endif




                    </div>
                </div>
            @endif

        </section>
    </div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
    <script>
        function enableKeterangan() {
            // document.getElementById("keterangan").disabled = false;
            document.getElementById("keterangan").setAttribute('class', '');
            // document.getElementById("bukti").disabled = false;


        }

        function disableKeterangan() {
            // document.getElementById("keterangan").disabled = true;
            document.getElementById("keterangan").setAttribute('class', 'sembunyi');
            // document.getElementById("bukti").disabled = true;


        }
    </script>

    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("{{ $batas_pengisian }}").getTime();
        $("#xpengumuman").hide();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("day").innerHTML = days;
            document.getElementById("hour").innerHTML = hours;
            document.getElementById("minute").innerHTML = minutes;
            document.getElementById("second").innerHTML = seconds;

            // Display the result in the element with id="demo"
            //   document.getElementById("demo").innerHTML = "Pengumuman dapat dilihat " + days + " Hari " + hours + " Jam "
            //   + minutes + " Menit " + seconds + " Detik lagi.";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                // document.getElementById("demo").innerHTML = "EXPIRED";
                $("#xpengumuman").show();
                $("#pengumuman").hide();
                $("#timer").hide();
            }
        }, 1000);
    </script>
@endsection
