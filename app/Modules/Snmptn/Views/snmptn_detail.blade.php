@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('snmptn.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('snmptn.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $snmptn->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $snmptn->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Pesertadidik</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->pesertadidik->id }}</p></div>
									<div class='col-lg-2'><p>Jml Nilai 1</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->jml_nilai_1 }}</p></div>
									<div class='col-lg-2'><p>Pembagi 1</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->pembagi_1 }}</p></div>
									<div class='col-lg-2'><p>Jml Nilai 2</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->jml_nilai_2 }}</p></div>
									<div class='col-lg-2'><p>Pembagi 2</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->pembagi_2 }}</p></div>
									<div class='col-lg-2'><p>Jml Nilai 3</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->jml_nilai_3 }}</p></div>
									<div class='col-lg-2'><p>Pembagi 3</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->pembagi_3 }}</p></div>
									<div class='col-lg-2'><p>Jml Nilai 4</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->jml_nilai_4 }}</p></div>
									<div class='col-lg-2'><p>Pembagi 4</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->pembagi_4 }}</p></div>
									<div class='col-lg-2'><p>Jml Nilai 5</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->jml_nilai_5 }}</p></div>
									<div class='col-lg-2'><p>Pembagi 5</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->pembagi_5 }}</p></div>
									<div class='col-lg-2'><p>Rata Rata</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->rata_rata }}</p></div>
									<div class='col-lg-2'><p>Is Bersedia</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->is_bersedia }}</p></div>
									<div class='col-lg-2'><p>Peringkat</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $snmptn->peringkat }}</p></div>
									
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