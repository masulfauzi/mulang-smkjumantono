@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('karyawan.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('karyawan.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $karyawan->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $karyawan->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Bagian</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $karyawan->bagian->id }}</p></div>
									<div class='col-lg-2'><p>Jenis Kelamin</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $karyawan->jenisKelamin->id }}</p></div>
									<div class='col-lg-2'><p>Agama</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $karyawan->agama->id }}</p></div>
									<div class='col-lg-2'><p>Nama Karyawan</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $karyawan->nama_karyawan }}</p></div>
									<div class='col-lg-2'><p>Tempat Lahir</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $karyawan->tempat_lahir }}</p></div>
									<div class='col-lg-2'><p>Tgl Lahir</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $karyawan->tgl_lahir }}</p></div>
									<div class='col-lg-2'><p>Nik</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $karyawan->nik }}</p></div>
									
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