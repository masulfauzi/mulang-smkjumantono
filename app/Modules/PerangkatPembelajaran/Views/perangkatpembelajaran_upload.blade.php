@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Data {{ $title }}</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        

        <div class="card">
            <h6 class="card-header">
                Upload Perangkat Pembelajaran
            </h6>
            <div class="card-body">
                
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <form class="form form-horizontal" action="{{ route('perangkatpembelajaran.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="form-body">
                            @csrf 
                            <input type="hidden" name="id_mapel" value="{{ $data->id_mapel }}">
                            <input type="hidden" name="id_tingkat" value="{{ $data->kelas['id_tingkat'] }}">
                            <input type="hidden" name="id_semester" value="{{ $data->id_semester }}">
                            <input type="hidden" name="id_guru" value="{{ $data->id_guru }}">
                            <input type="hidden" name="id_jam_mengajar" value="{{ $data->id }}">
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Mapel</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    <input disabled type="text" class="form-control" value="{{ $data->mapel['mapel'] }}">
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Kelas</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    <ul>
                                        @foreach ($mapel as $item_mapel)
                                            <li>{{ $item_mapel->kelas['kelas'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Nama Perangkat</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {!! Form::text('nama_perangkat', NULL, ["class" => "form-control"]) !!}
                                    @error('nama_perangkat')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Jenis Perangkat</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {!! Form::select('id_jenis_perangkat', $jns_perangkat, NULL, ['class' => "form-control select2"]) !!}
                                    @error('id_jenis_perangkat')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Pilih File</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {!! Form::file('file', ['class' => "form-control"]) !!}
                                    @error('file')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="offset-md-3 ps-2">
                                <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                                <a href="{{ route('perangkatpembelajaran.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <h6 class="card-header">
                Perangkat yang Sudah Terupload
            </h6>
            <div class="card-body">
                <div class="table-responsive-md col-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Perangkat</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($perangkat as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nama_perangkat }}</td>
                                    <td>{{ $item->jenisPerangkat['jenis_perangkat'] }}</td>
                                    <td>
                                        <a target="_blank" href="{{ url('uploads/perangkat/'.$item->file) }}" class="btn btn-outline btn-outline-primary"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                                        {!! button('perangkatpembelajaran.destroy', 'Hapus', $item->id) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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