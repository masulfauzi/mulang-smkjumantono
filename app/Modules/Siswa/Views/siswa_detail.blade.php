@extends('layouts.app')

@section('page-css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
@endsection

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-2">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <a href="{{ route('siswa.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i
                            class="fa fa-arrow-left"></i> Kembali </a>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">{{ $title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $siswa->nama }}</li>
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
                            <h5 class="card-title">Detail Siswa</h5>
                        </div>
                        <div class="card-body">
                            @include('include.flash')
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link @if ($tab == 'biodata') active @endif" id="home-tab"
                                        data-bs-toggle="tab" href="#home" role="tab" aria-controls="home"
                                        aria-selected="true">Biodata</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link @if ($tab == 'transkrip') active @endif" id="profile-tab"
                                        data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                                        aria-selected="false">Transkrip Nilai</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link @if ($tab == 'abm') active @endif" id="abm-tab"
                                        data-bs-toggle="tab" href="#abm" role="tab" aria-controls="profile"
                                        aria-selected="false">Hasil ABM</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade  m-3 @if ($tab == 'biodata') show active @endif"
                                    id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <table class="table">
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>{{ $siswa->nama_siswa }}</td>
                                        </tr>
                                        <tr>
                                            <td>NISN</td>
                                            <td>:</td>
                                            <td>{{ $siswa->nisn }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane fade m-3 @if ($tab == 'transkrip') show active @endif"
                                    id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <table id="transkrip" class="cell-border compact stripe">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Mapel</th>
                                                <th>Semester</th>
                                                <th>Nilai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($nilai as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $item->mapel->mapel }}</td>
                                                    <td>{{ $item->semester->semester }}</td>
                                                    <td>{{ $item->nilai }}</td>
                                                    <td>
                                                        <a href="{{ route('nilai.edit', $item->id) }}"
                                                            class="btn btn-sm btn-primary">Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                                <div class="tab-pane fade m-3 @if ($tab == 'abm') show active @endif"
                                    id="abm" role="tabpanel" aria-labelledby="profile-tab">
                                    <object data="{{ url('download/abm/' . $siswa->nisn . '.pdf') }}"
                                        type="application/pdf" width="100%" height="900px">
                                        <p>Unable to display PDF file. <a
                                                href="{{ url('download/abm/' . $siswa->nisn . '.pdf') }}">Download</a>
                                            instead.</p>
                                    </object>
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
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
@endsection

@section('inline-js')
    <script>
        let table = new DataTable('#transkrip');
    </script>
@endsection
