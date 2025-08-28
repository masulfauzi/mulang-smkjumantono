@extends('layouts.app')

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Data {{ $title }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('soal.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Tambah {{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Form Tambah Data {{ $title }}
            </h6>
            @include('Soal::soal_nomor')
            <div class="card-body">
                @include('include.flash')
                <form class="form form-horizontal" action="{{ route('soal.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                        @csrf 
                        <input type="hidden" name="id_ujiansekolah" value="{{ $id_ujian }}">
                        <input type="hidden" name="id_jenissoal" value="{{ $id_jenissoal }}">
                        <input type="hidden" name="no_soal" value="{{ $no_soal }}">
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Soal</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="soal" id="soal" cols="30" rows="10" class="form-control rich-editor">{{ old("soal") }}</textarea>
                                @error('soal')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Gambar Soal</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="file" name="gambar" id="gambar" class="form-control">
                                @error('gambar')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Jawaban A</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="opsi_a" id="opsi_a" cols="30" rows="3" class="form-control">{{ old("opsi_a") }}</textarea>
                                @error('opsi_a')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Gambar Jawaban A</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="file" name="gambar_a" id="gambar_a" class="form-control">
                                @error('gambar_a')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Jawaban B</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="opsi_b" id="opsi_b" cols="30" rows="3" class="form-control">{{ old("opsi_b") }}</textarea>
                                @error('opsi_b')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Gambar Jawaban B</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="file" name="gambar_b" id="gambar_b" class="form-control">
                                @error('gambar_b')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Jawaban C</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="opsi_c" id="opsi_c" cols="30" rows="3" class="form-control">{{ old("opsi_c") }}</textarea>
                                @error('opsi_c')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Gambar Jawaban C</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="file" name="gambar_c" id="gambar_c" class="form-control">
                                @error('gambar_c')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Jawaban D</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="opsi_d" id="opsi_d" cols="30" rows="3" class="form-control">{{ old("opsi_d") }}</textarea>
                                @error('opsi_d')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Gambar Jawaban D</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="file" name="gambar_d" id="gambar_d" class="form-control">
                                @error('gambar_d')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Jawaban E</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="opsi_e" id="opsi_e" cols="30" rows="3" class="form-control">{{ old("opsi_e") }}</textarea>
                                @error('opsi_e')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Gambar Jawaban E</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="file" name="gambar_e" id="gambar_e" class="form-control">
                                @error('gambar_e')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-sm-start text-md-end pt-2">
                                <label>Kunci Jawaban</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="kunci" id="kunci" class="form-control">
                                    <option value="">-PILIH SALAH SATU-</option>
                                    <option @if (old('kunci') == 'A')
                                        selected
                                    @endif value="A">A</option>
                                    <option @if (old('kunci') == 'B')
                                    selected
                                @endif value="B">B</option>
                                    <option @if (old('kunci') == 'C')
                                    selected
                                @endif value="C">C</option>
                                    <option @if (old('kunci') == 'D')
                                    selected
                                @endif value="D">D</option>
                                    <option @if (old('kunci') == 'E')
                                    selected
                                @endif value="E">E</option>
                                </select>
                                @error('kunci')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="offset-md-3 ps-2">
                            <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                        </div>
                  </div>
                </form>
            </div>
            @include('Soal::soal_nomor')
        </div>

    </section>
</div>
@endsection
