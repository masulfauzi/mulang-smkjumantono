@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('kelas.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Naik Kelas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <form class="form form-horizontal" action="{{ route('kelas.naik.store') }}" method="POST">
        <div class="card">
            <h6 class="card-header">
                Data Peserta Didik
            </h6>
            <div class="card-body">
                @include('include.flash')
                <div class="row">
                    <div class="col-lg-10">
                        <div class="row">
                            <table class="table">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Pilih</th>
                                </tr>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->siswa['nama_siswa'] }}</td>
                                        <td>{{ $item->siswa['nisn'] }}</td>
                                        <td><input type="checkbox" name="id_pesertadidik[]" value="{{ $item->id }}" id="" checked></td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="row">
                                <div class="form-body">
                                    @csrf 
                                    {!! Form::hidden('id_kelas', $kelas->id) !!}
                                    {!! Form::hidden('id_semester', $semester) !!}
                                    <div class="row">
                                        <div class="col-md-3 text-sm-start text-md-end pt-2">
                                            <label>Kelas</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            <input type="text" class="form-control" name="kelas" disabled value="{{ $kelas->kelas }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 text-sm-start text-md-end pt-2">
                                            <label>Naik Ke Kelas</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            {!! Form::select('id_kelas_naik', $data_kelas, old('id_kelas_naik'), ["class" => "form-control select2"]) !!}
                                            @error('id_kelas_naik')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 text-sm-start text-md-end pt-2">
                                            <label>Semester</label>
                                        </div>
                                        <div class="col-md-9 form-group">
                                            {!! Form::select('id_semester_naik', $data_semester, old('id_kelas_naik'), ["class" => "form-control select2"]) !!}
                                            @error('id_kelas_naik')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="offset-md-3 ps-2">
                                        <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                                        <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Batal</a>
                                    </div>
                              </div>
                            </form>
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