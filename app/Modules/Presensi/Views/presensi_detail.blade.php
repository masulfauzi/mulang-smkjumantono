@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('presensi.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('presensi.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $presensi->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $presensi->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Jurnal</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $presensi->jurnal->id }}</p></div>
									<div class='col-lg-2'><p>Pesertadidik</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $presensi->pesertadidik->id }}</p></div>
									<div class='col-lg-2'><p>Statuskehadiran</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $presensi->statuskehadiran->id }}</p></div>
									<div class='col-lg-2'><p>Catatan</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $presensi->catatan }}</p></div>
									
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