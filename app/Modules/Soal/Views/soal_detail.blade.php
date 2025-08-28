@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('soal.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('soal.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $soal->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $soal->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Ujiansekolah</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->ujiansekolah->id }}</p></div>
									<div class='col-lg-2'><p>Jenissoal</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->jenissoal->id }}</p></div>
									<div class='col-lg-2'><p>No Soal</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->no_soal }}</p></div>
									<div class='col-lg-2'><p>Soal</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->soal }}</p></div>
									<div class='col-lg-2'><p>Gambar</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->gambar }}</p></div>
									<div class='col-lg-2'><p>Opsi A</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->opsi_a }}</p></div>
									<div class='col-lg-2'><p>Opsi B</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->opsi_b }}</p></div>
									<div class='col-lg-2'><p>Opsi C</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->opsi_c }}</p></div>
									<div class='col-lg-2'><p>Opsi D</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->opsi_d }}</p></div>
									<div class='col-lg-2'><p>Opsi E</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->opsi_e }}</p></div>
									<div class='col-lg-2'><p>Gambar A</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->gambar_a }}</p></div>
									<div class='col-lg-2'><p>Gambar B</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->gambar_b }}</p></div>
									<div class='col-lg-2'><p>Gambar C</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->gambar_c }}</p></div>
									<div class='col-lg-2'><p>Gambar D</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->gambar_d }}</p></div>
									<div class='col-lg-2'><p>Gambar E</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $soal->gambar_e }}</p></div>
									
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