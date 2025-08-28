@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('files.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('files.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $files->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $files->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Table Name</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $files->table_name }}</p></div>
									<div class='col-lg-2'><p>Table Id</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $files->table_id }}</p></div>
									<div class='col-lg-2'><p>Jenis</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $files->jenis->id }}</p></div>
									<div class='col-lg-2'><p>Nama File</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $files->nama_file }}</p></div>
									<div class='col-lg-2'><p>Path File</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $files->path_file }}</p></div>
									<div class='col-lg-2'><p>File Size</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $files->file_size }}</p></div>
									<div class='col-lg-2'><p>File Type</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $files->file_type }}</p></div>
									
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