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
            <div class="card">
                <h6 class="card-header">
                    Filter Data
                </h6>
                <div class="card-body">

                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <form action="">
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Pilih Semester</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {{ Form::select('id_semester', $ref_semester, $semester_aktif, ['class' => 'form-control select2', 'required']) }}

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Pilih Kelas</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {{ Form::select('id_kelas', $ref_kelas, $kelas_aktif, ['class' => 'form-control select2', 'required']) }}

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <button type="submit" class="btn btn-primary">Filter Data</button>
                                </div>
                                <div class="col-md-9 form-group">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Tabel Data {{ $title }}
                </h6>
                <div class="card-body">

                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Nama Siswa</td>
                                    <td>NISN</td>
                                    @if ($mapel)
                                        @foreach ($mapel as $item_mapel)
                                            <td>{{ $item_mapel->mapel }}</td>
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp

                                @forelse ($data as $item)
                                    <tr class="">
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama_siswa }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        @if ($mapel)
                                            @foreach ($mapel as $item_mapel)
                                                @php
                                                    $nilai_angka = $nilai
                                                        ->where('id_mapel', $item_mapel->id_mapel)
                                                        ->where('id_siswa', $item->id_siswa)
                                                        ->first();
                                                @endphp
                                                <td>
                                                    @if ($nilai_angka)
                                                        {{ $nilai_angka->nilai }}
                                                    @endif
                                                </td>
                                            @endforeach
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center"><i>No data.</i></td>
                                    </tr>
                                @endforelse
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
