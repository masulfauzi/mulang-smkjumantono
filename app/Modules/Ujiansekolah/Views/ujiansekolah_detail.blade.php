@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('ujiansekolah.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ujiansekolah.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $ujiansekolah->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $ujiansekolah->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Semester</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $ujiansekolah->semester->id }}</p></div>
									<div class='col-lg-2'><p>Mapel</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $ujiansekolah->mapel->id }}</p></div>
									<div class='col-lg-2'><p>Guru</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $ujiansekolah->guru->id }}</p></div>
									<div class='col-lg-2'><p>Kisi Kisi</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $ujiansekolah->kisi_kisi }}</p></div>
									<div class='col-lg-2'><p>Norma Penilaian</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $ujiansekolah->norma_penilaian }}</p></div>
									<div class='col-lg-2'><p>Jurusan</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $ujiansekolah->jurusan->id }}</p></div>
									
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