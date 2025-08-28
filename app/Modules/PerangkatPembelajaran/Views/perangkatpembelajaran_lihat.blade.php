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
                Informasi Perangkat Pembelajaran
            </h6>
            <div class="card-body">
                
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <form class="form form-horizontal" action="{{ route('perangkatpembelajaran.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="form-body">
                            @csrf 
                           
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Guru</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    <div class="form-control">{{ $data->guru['nama'] }}</div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Mapel</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    <div class="form-control">{{ $data->mapel['mapel'] }}</div>
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
                                        <a class="btn btn-primary" target="_blank" href="{{ route('perangkatpembelajaran.detail.index', $item->id) }}">Lihat</a>
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