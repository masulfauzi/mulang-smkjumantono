@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('log.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('log.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $log->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $log->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>User</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $log->user->id }}</p></div>
									<div class='col-lg-2'><p>Aktivitas</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $log->aktivitas }}</p></div>
									<div class='col-lg-2'><p>Route</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $log->route }}</p></div>
									<div class='col-lg-2'><p>Action</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $log->action }}</p></div>
									<div class='col-lg-2'><p>Context</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $log->context }}</p></div>
									<div class='col-lg-2'><p>Data</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $log->data }}</p></div>
									
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