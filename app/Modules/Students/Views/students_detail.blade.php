@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('students.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('students.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $students->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $students->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Nama Siswa</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->nama_siswa }}</p></div>
									<div class='col-lg-2'><p>Nis</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->nis }}</p></div>
									<div class='col-lg-2'><p>Nisn</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->nisn }}</p></div>
									<div class='col-lg-2'><p>Nik</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->nik }}</p></div>
									<div class='col-lg-2'><p>Jeniskelamin</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->jeniskelamin->id }}</p></div>
									<div class='col-lg-2'><p>Agama</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->agama->id }}</p></div>
									<div class='col-lg-2'><p>Tahun Masuk</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->tahun_masuk }}</p></div>
									<div class='col-lg-2'><p>Tempat Lahir</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->tempat_lahir }}</p></div>
									<div class='col-lg-2'><p>Tgl Lahir</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->tgl_lahir }}</p></div>
									<div class='col-lg-2'><p>Nama Ayah</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->nama_ayah }}</p></div>
									<div class='col-lg-2'><p>Nama Ibu</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->nama_ibu }}</p></div>
									<div class='col-lg-2'><p>Alamat</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->alamat }}</p></div>
									<div class='col-lg-2'><p>Sekolah Asal</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->sekolah_asal }}</p></div>
									<div class='col-lg-2'><p>No Ijazah Smp</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->no_ijazah_smp }}</p></div>
									<div class='col-lg-2'><p>No Skhun</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->no_skhun }}</p></div>
									<div class='col-lg-2'><p>File Ijazah Smp</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->file_ijazah_smp }}</p></div>
									<div class='col-lg-2'><p>File Skhun</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->file_skhun }}</p></div>
									<div class='col-lg-2'><p>File Kk</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->file_kk }}</p></div>
									<div class='col-lg-2'><p>File Akta Lahir</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->file_akta_lahir }}</p></div>
									<div class='col-lg-2'><p>Tgl Lulus</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->tgl_lulus }}</p></div>
									<div class='col-lg-2'><p>Is Lulus</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $students->is_lulus }}</p></div>
									
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