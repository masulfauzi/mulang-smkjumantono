@extends('layouts.app')

@section('page-css')
    <style>
        body{
    margin-top:20px;
}
.bg-light-gray {
    background-color: #f7f7f7;
}
.table-bordered thead td, .table-bordered thead th {
    border-bottom-width: 2px;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}


.bg-sky.box-shadow {
    box-shadow: 0px 5px 0px 0px #00a2a7
}

.bg-orange.box-shadow {
    box-shadow: 0px 5px 0px 0px #af4305
}

.bg-green.box-shadow {
    box-shadow: 0px 5px 0px 0px #4ca520
}

.bg-yellow.box-shadow {
    box-shadow: 0px 5px 0px 0px #dcbf02
}

.bg-pink.box-shadow {
    box-shadow: 0px 5px 0px 0px #e82d8b
}

.bg-purple.box-shadow {
    box-shadow: 0px 5px 0px 0px #8343e8
}

.bg-lightred.box-shadow {
    box-shadow: 0px 5px 0px 0px #d84213
}


.bg-sky {
    background-color: #02c2c7
}

.bg-orange {
    background-color: #e95601
}

.bg-green {
    background-color: #5bbd2a
}

.bg-yellow {
    background-color: #f0d001
}

.bg-pink {
    background-color: #ff48a4
}

.bg-purple {
    background-color: #9d60ff
}

.bg-lightred {
    background-color: #ff5722
}

.padding-15px-lr {
    padding-left: 15px;
    padding-right: 15px;
}
.padding-5px-tb {
    padding-top: 5px;
    padding-bottom: 5px;
}
.margin-10px-bottom {
    margin-bottom: 10px;
}
.border-radius-5 {
    border-radius: 5px;
}

.margin-10px-top {
    margin-top: 10px;
}
.font-size14 {
    font-size: 14px;
}

.text-light-gray {
    color: #d6d5d5;
}
.font-size13 {
    font-size: 13px;
}

.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
    </style>
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Jadwal Guru</h3>
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
            <div class="container">
                <div class="timetable-img text-center">
                    <img src="img/content/timetable.png" alt="">
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-light-gray">
                                <th class="text-uppercase" width="10%">Hari/Jam ke
                                </th>
                                <th width="9%" class="text-uppercase">1</th>
                                <th width="9%" class="text-uppercase">2</th>
                                <th width="9%" class="text-uppercase">3</th>
                                <th width="9%" class="text-uppercase">4</th>
                                <th width="9%" class="text-uppercase">5</th>
                                <th width="9%" class="text-uppercase">6</th>
                                <th width="9%" class="text-uppercase">7</th>
                                <th width="9%" class="text-uppercase">8</th>
                                <th width="9%" class="text-uppercase">9</th>
                                <th width="9%" class="text-uppercase">10</th>
                            </tr>
                        </thead>
                        @php
                            $kolom = 1;
                        @endphp
                        <tbody>
                            <tr>
                                <td class="align-middle">Senin</td>

                                @if (1 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','2f13468a-23bf-4659-944d-6ad9f64d43d6', session('id_guru'), get_semester('active_semester_id')))
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                

                                @if (2 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','1ac50a01-b632-4c69-83f9-6abb1ebc1aab', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                                <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 2;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (3 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','b6f34816-2149-4e1e-8ef3-9189888d2bf4', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 3;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (4 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','041e2a71-3bd6-49d8-b841-5b496672aac9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 4;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (5 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','238327a0-4041-4218-a965-a49588d7a226', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                                <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 5;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (6 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','fd67f38c-7a21-4299-940b-8498a41773f2', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                                <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 6;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (7 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','39fed763-71a4-4ed4-9ff9-638ef735b367', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                                <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 7;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (8 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','f00f9283-89e0-4a4b-bcfd-9d6ceaf348d6', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                                <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (9 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','ccebd1e4-27b9-4c50-815d-2f9567bace98', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (10 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('c6b5f9c5-1c05-41bb-bfd8-62efe0832853','4b7cc676-2717-4d99-b0a5-26a3273279b9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                    <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                
                                
                            </tr>

                            {{-- reset kolom --}}
                            @php
                                $kolom = 1;
                            @endphp

                            <tr>
                                <td class="align-middle">Selasa</td>

                                @if (1 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','2f13468a-23bf-4659-944d-6ad9f64d43d6', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                

                                @if (2 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','1ac50a01-b632-4c69-83f9-6abb1ebc1aab', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 2;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (3 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','b6f34816-2149-4e1e-8ef3-9189888d2bf4', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 3;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (4 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','041e2a71-3bd6-49d8-b841-5b496672aac9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 4;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (5 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','238327a0-4041-4218-a965-a49588d7a226', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 5;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (6 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','fd67f38c-7a21-4299-940b-8498a41773f2', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 6;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (7 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','39fed763-71a4-4ed4-9ff9-638ef735b367', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 7;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (8 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','f00f9283-89e0-4a4b-bcfd-9d6ceaf348d6', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (9 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','ccebd1e4-27b9-4c50-815d-2f9567bace98', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (10 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('7fa839f4-716a-4cf9-b6a6-52ae3619215e','4b7cc676-2717-4d99-b0a5-26a3273279b9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                    <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                
                                
                            </tr>

                            {{-- reset kolom --}}
                            @php
                                $kolom = 1;
                            @endphp

                            <tr>
                                <td class="align-middle">Rabu</td>

                                @if (1 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','2f13468a-23bf-4659-944d-6ad9f64d43d6', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                

                                @if (2 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','1ac50a01-b632-4c69-83f9-6abb1ebc1aab', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 2;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (3 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','b6f34816-2149-4e1e-8ef3-9189888d2bf4', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 3;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (4 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','041e2a71-3bd6-49d8-b841-5b496672aac9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 4;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (5 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','238327a0-4041-4218-a965-a49588d7a226', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 5;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (6 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','fd67f38c-7a21-4299-940b-8498a41773f2', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 6;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (7 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','39fed763-71a4-4ed4-9ff9-638ef735b367', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 7;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (8 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','f00f9283-89e0-4a4b-bcfd-9d6ceaf348d6', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (9 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','ccebd1e4-27b9-4c50-815d-2f9567bace98', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (10 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','4b7cc676-2717-4d99-b0a5-26a3273279b9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                    <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                
                                
                            </tr>

                            {{-- reset kolom --}}
                            @php
                                $kolom = 1;
                            @endphp

                            <tr>
                                <td class="align-middle">Kamis</td>

                                @if (1 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('0244a852-535a-48f9-9af0-b88bfe6874e0','2f13468a-23bf-4659-944d-6ad9f64d43d6', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                

                                @if (2 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('0244a852-535a-48f9-9af0-b88bfe6874e0','1ac50a01-b632-4c69-83f9-6abb1ebc1aab', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 2;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (3 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('0244a852-535a-48f9-9af0-b88bfe6874e0','b6f34816-2149-4e1e-8ef3-9189888d2bf4', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 3;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (4 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('0244a852-535a-48f9-9af0-b88bfe6874e0','041e2a71-3bd6-49d8-b841-5b496672aac9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 4;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (5 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('0244a852-535a-48f9-9af0-b88bfe6874e0','238327a0-4041-4218-a965-a49588d7a226', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 5;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (6 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('0244a852-535a-48f9-9af0-b88bfe6874e0','fd67f38c-7a21-4299-940b-8498a41773f2', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 6;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (7 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('0244a852-535a-48f9-9af0-b88bfe6874e0','39fed763-71a4-4ed4-9ff9-638ef735b367', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 7;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (8 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('0244a852-535a-48f9-9af0-b88bfe6874e0','f00f9283-89e0-4a4b-bcfd-9d6ceaf348d6', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (9 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('0244a852-535a-48f9-9af0-b88bfe6874e0','ccebd1e4-27b9-4c50-815d-2f9567bace98', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (10 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('9adfc4ac-3115-4651-8a00-2e4f333f2231','4b7cc676-2717-4d99-b0a5-26a3273279b9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                    <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                
                                
                            </tr>

                            {{-- reset kolom --}}
                            @php
                                $kolom = 1;
                            @endphp

                            <tr>
                                <td class="align-middle">Jumat</td>

                                @if (1 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','2f13468a-23bf-4659-944d-6ad9f64d43d6', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                

                                @if (2 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','1ac50a01-b632-4c69-83f9-6abb1ebc1aab', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 2;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (3 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','b6f34816-2149-4e1e-8ef3-9189888d2bf4', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 3;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (4 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','041e2a71-3bd6-49d8-b841-5b496672aac9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 4;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (5 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','238327a0-4041-4218-a965-a49588d7a226', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 5;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (6 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','fd67f38c-7a21-4299-940b-8498a41773f2', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 6;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (7 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','39fed763-71a4-4ed4-9ff9-638ef735b367', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 7;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (8 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','f00f9283-89e0-4a4b-bcfd-9d6ceaf348d6', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (9 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','ccebd1e4-27b9-4c50-815d-2f9567bace98', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom = 9;
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    
                                @endif

                                @if (10 >= $kolom)
                                    @if($jadwal = App\Modules\Jadwal\Models\Jadwal::get_detail_jadwal('92f1870a-9012-4282-b52a-267c26913aaf','4b7cc676-2717-4d99-b0a5-26a3273279b9', session('id_guru'), get_semester('active_semester_id')))
                                    
                                        <td colspan="{{ $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1 }}">
                                            <a href="{{ route('jurnal.create', ['id_jadwal' => $jadwal->id]) }}">
                                                <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">{{ $jadwal->mapel }}</span>
                                            </a>
                                            <div class="margin-10px-top font-size14">{{ $jadwal->ruang }} | {{ $jadwal->kelas }}
                                            </div>
                                            <div class="font-size13 text-light-gray"></div>
                                        </td>
                                        @php
                                            $kolom += $jam_pelajaran[$jadwal->jam_selesai] - $jam_pelajaran[$jadwal->jam_mulai] + 1;
                                        @endphp
                                    @else
                                    <td></td>
                                    @endif
                                @else
                                    
                                @endif
                                
                                
                            </tr>

                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection