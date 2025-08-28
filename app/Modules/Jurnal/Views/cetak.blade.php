@extends('layouts.app')

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Cetak Jurnal</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jurnal.index') }}">Jurnal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Cetak Jurnal</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Cetak Jurnal Mengajar Guru
            </h6>
            <div class="card-body">
                @include('include.flash')
                <form class="form form-horizontal" action="{{ route('jurnal.cetakjurnal.index') }}" method="GET" onsubmit="target_popup(this)">
                    <div class="form-body">
                        {{-- @csrf  --}}
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Pilih Mapel</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {!! Form::select("id_mapel", $mapel, old("id_mapel"), ["class" => "form-control", "required"]) !!}
                                @error('id_mapel')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Pilih Kelas</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {!! Form::select("id_kelas", $kelas, old("id_kelas"), ["class" => "form-control", "required"]) !!}
                                @error('id_kelas')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="offset-md-3 ps-2">
                            <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                            <a href="{{ route('jurnal.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                  </div>
                </form>
            </div>
        </div>

    </section>
    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Cetak Daftar Hadir Siswa
            </h6>
            <div class="card-body">
                @include('include.flash')
                <form class="form form-horizontal" action="{{ route('jurnal.cetakpresensi.index') }}" method="POST">
                    <div class="form-body">
                        @csrf 
                        
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Pilih Kelas</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {!! Form::select("id_kelas", $kelas, old("id_kelas"), ["class" => "form-control", "required"]) !!}
                                @error('id_kelas')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Pilih Mapel</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {!! Form::select("id_mapel", $mapel, old("id_mapel"), ["class" => "form-control", "required"]) !!}
                                @error('id_mapel')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="offset-md-3 ps-2">
                            <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                            <a href="{{ route('jurnal.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                  </div>
                </form>
            </div>
        </div>

    </section>
</div>
<script>
    function target_popup(form) {
    window.open('', 'formpopup', 'width=1200,height=800,resizeable,scrollbars');
    form.target = 'formpopup';
}
</script>
@endsection
