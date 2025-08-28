@extends('layouts.app')

@section('page-css')
    
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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Pembagian Jam Mengajar</h5>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home"
                                        role="tab" aria-controls="home" aria-selected="true">Perguru</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                        aria-controls="profile" aria-selected="false">Perkelas</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                        aria-controls="contact" aria-selected="false">Contact</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div class="card">

                                        <div class="card-body">

                                            @include('include.flash')
                                            <div class="table-responsive-md col-12">
                                                <table class="table" id="table1">
                                                    <thead>
                                                        <tr>
                                                            <th width="15">No</th>
                                                            <td>Guru</td>
                                                            <td>Jml Jam</td>

                                                            <th width="30%">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $no = 1; @endphp
                                                        @forelse ($data as $item)
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $item->nama }}</td>
                                                                <td>{{ $item->jml_jam }}</td>

                                                                <td>
                                                                    <a href="{{ route('jammengajar.guru.index', $item->id_guru) }}"
                                                                        class="btn btn-success">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" class="text-center"><i>No data.</i></td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="card">

                                        <div class="card-body">

                                            @include('include.flash')
                                            <div class="table-responsive-md col-12">
                                                <table class="table" id="table1">
                                                    <thead>
                                                        <tr>
                                                            <th width="15">No</th>
                                                            <td>Kelas</td>
                                                            <td>Jml Jam</td>

                                                            <th width="30%">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $no = 1; @endphp
                                                        @forelse ($kelas as $item_kelas)
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $item_kelas->kelas }}</td>
                                                                <td>{{ $item_kelas->jml_jam }}</td>

                                                                <td>
                                                                    <a href="{{ route('jammengajar.kelas.index', $item_kelas->id_kelas) }}"
                                                                        class="btn btn-success">Detail</a>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" class="text-center"><i>No data.</i></td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                    <a href="{{ route('jammengajar.cetak.index') }}" class="btn btn-secondary">Cetak</a>
                                    <div id="printableArea">
                                        @foreach ($data as $guru_cetak)
                                            <h2>{{ $guru_cetak->nama }}</h2>
                                            @php
                                                $data_jam_mengajar = App\Modules\JamMengajar\Models\JamMengajar::whereIdGuru(
                                                    $guru_cetak->id_guru,
                                                )
                                                    ->whereIdSemester($id_semester)
                                                    ->OrderBy('id_kelas')
                                                    ->get();
                                            @endphp

                                            <table class="table">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kelas</th>
                                                    <th>Mapel</th>
                                                    <th>Jml Jam</th>
                                                </tr>
                                                @php
                                                    $no = 1;
                                                    $tmp_jam = 0;
                                                @endphp
                                                @foreach ($data_jam_mengajar as $item_jam)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $item_jam->kelas->kelas }}</td>
                                                        <td>{{ $item_jam->mapel->mapel }}</td>
                                                        <td>{{ $item_jam->jml_jam }}</td>
                                                    </tr>
                                                    @php
                                                        $tmp_jam += $item_jam->jml_jam;
                                                    @endphp
                                                @endforeach


                                                <tr>
                                                    <th colspan="3">Total Jam Mengajar</th>
                                                    <th>{{ $tmp_jam }}</th>
                                                </tr>
                                            </table>

                                            <div class="page_break"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
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
