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
                        <li class="breadcrumb-item"><a href="{{ route('nilai.index') }}">{{ $title }}</a></li>
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
            <div class="card-body">
                @include('include.flash')
                <form class="form form-horizontal" action="{{ route('nilai.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                        @csrf 
                        @foreach ($forms as $key => $value)
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>{{ $value[0] }}</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {{ $value[1] }}
                                    @error($key)
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                        <div class="offset-md-3 ps-2">
                            <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                            <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                  </div>
                </form>
            </div>
        </div>

    </section>
    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Cari ID Mapel
            </h6>
            <div class="card-body">
                @include('include.flash')
                <form class="form form-horizontal"  method="POST" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Mapel</label>
                            </div>
                            <div class="col-md-9 form-group">
                                {!! Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2", "onchange" => "tampil_id();", "id" => "select_mapel"]) !!}
                            </div>
                        </div>
                  </div>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>ID</label>
                            </div>
                            <div class="col-md-9 form-group" >
                                <div id="id_mapel" class="form-control"></div>
                            </div>
                        </div>
                  </div>
                </form>
            </div>
        </div>

    </section>
</div>
@endsection

@section('inline-js')
    <script>
        function tampil_id() {
            var select = document.getElementById("select_mapel");
            var value = select.options[select.selectedIndex].value;
            document.getElementById("id_mapel").innerHTML = value; 
            return true;
        }
    </script>
@endsection