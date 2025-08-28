@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('guru.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $guru->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $guru->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Nama</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->nama }}</p></div>
									<div class='col-lg-2'><p>Nip</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->nip }}</p></div>
									<div class='col-lg-2'><p>Nik</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->nik }}</p></div>
									<div class='col-lg-2'><p>Email</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->email }}</p></div>
									<div class='col-lg-2'><p>No Hp</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->no_hp }}</p></div>
									<div class='col-lg-2'><p>Tempat Lahir</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->tempat_lahir }}</p></div>
									<div class='col-lg-2'><p>Tgl Lahir</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->tgl_lahir }}</p></div>
									<div class='col-lg-2'><p>Agama</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->agama->id }}</p></div>
									<div class='col-lg-2'><p>Alamat</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->alamat }}</p></div>
									<div class='col-lg-2'><p>Rt</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->rt }}</p></div>
									<div class='col-lg-2'><p>Rw</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->rw }}</p></div>
									<div class='col-lg-2'><p>Kelurahan</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->kelurahan }}</p></div>
									<div class='col-lg-2'><p>Kecamatan</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->kecamatan }}</p></div>
									<div class='col-lg-2'><p>Kota</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->kota }}</p></div>
									<div class='col-lg-2'><p>Provinsi</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $guru->provinsi }}</p></div>
									
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