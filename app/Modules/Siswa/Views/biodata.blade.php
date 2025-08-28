@extends('layouts.app')

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Biodata Siswa</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Biodata</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Edit Biodata Siswa
            </h6>
            <div class="card-body">
                @include('include.flash')
                <form class="form form-horizontal" action="{{ route('siswa.biodata.store.index') }}" method="POST">
                    <div class="form-body">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        @csrf 
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Nama Lengkap (HURUF KAPITAL)</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="nama_siswa" class="form-control" value="{{ old('nama_siswa', $data['nama_siswa']) }}">
                                @error('nama_siswa')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>NIS</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="nis" class="form-control" value="{{ $data['nis'] }}" disabled>
                                @error('nis')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>NISN</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="nisn" class="form-control" value="{{ $data['nisn'] }}" disabled>
                                @error('nisn')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>No HP (Whatsapp)</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="no_hp" class="form-control" placeholder="Contoh 628512345678" value="{{ $data['no_hp'] }}" >
                                @error('no_hp')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Tempat Lahir</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $data['tempat_lahir']) }}">
                                @error('tempat_lahir')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Tanggal Lahir</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="tgl_lahir" class="form-control datepicker" value="{{ old('tgl_lahir', $data['tgl_lahir']) }}">
                                @error('tgl_lahir')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Nama Ayah Kandung</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah', $data['nama_ayah']) }}">
                                @error('nama_ayah')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Nama Ibu Kandung</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu', $data['nama_ibu']) }}">
                                @error('nama_ibu')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Alamat</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control">{{ old('alamat', $data['alamat']) }}</textarea>
                                @error('alamat')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Sekolah Asal (SMP/MTs)</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="sekolah_asal" class="form-control" value="{{ old('sekolah_asal', $data['sekolah_asal']) }}">
                                @error('sekolah_asal')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Nomor Seri Ijazah (SMP/MTs)</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="no_ijazah_smp" class="form-control" value="{{ old('no_ijazah_smp', $data['no_ijazah_smp']) }}">
                                @error('no_ijazah_smp')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Nomor Seri SKHUN SMP/MTs (Bagi yang memiliki)</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="no_skhun" class="form-control" value="{{ old('no_skhun', $data['no_skhun']) }}">
                                @error('no_skhun')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="offset-md-3 ps-2">
                            <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                  </div>
                </form>
            </div>
        </div>

    </section>
</div>
@endsection
