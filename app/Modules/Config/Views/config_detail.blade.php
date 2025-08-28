@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('config.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('config.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $config->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $config->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Key</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $config->key }}</p></div>
									<div class='col-lg-2'><p>Deskripsi</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $config->deskripsi }}</p></div>
									<div class='col-lg-2'><p>Default</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $config->default }}</p></div>
									<div class='col-lg-2'><p>Form Type</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $config->form_type }}</p></div>
									<div class='col-lg-2'><p>Form Label</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $config->form_label }}</p></div>
									<div class='col-lg-2'><p>Value</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $config->value }}</p></div>
									
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