@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Manajemen Data {{ $title }} <b>{{ $guru->nama }}</b></h3>
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
                Tabel Data {{ $title }} 
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <a href="{{ route('jammengajar.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                    </div>
                    <div class="col-3">  
						{!! button('jammengajar.create', $title, $guru->id) !!}  
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
								<td>Guru</td>
								<td>Kelas</td>
								<td>Jml Jam</td>
								
                                <th width="30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $no = 1; 
                                $jml_jam = 0;
                            @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
									<td>{{ $item->mapel['mapel'] }}</td>
									<td>{{ $item->kelas }}</td>
									<td>{{ $item->jml_jam }}</td>
									
                                    <td>
                                        {!! button('jammengajar.edit', 'Edit', $item->id) !!}
                                        {!! button('jammengajar.destroy', 'Hapus', $item->id) !!}
                                    </td>
                                </tr>
                                @php
                                    $jml_jam += $item->jml_jam;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center"><i>No data.</i></td>
                                </tr>
                            @endforelse
                                <tr>
                                    <th colspan="3">Jumlah</th>
                                    <th colspan="2">{{ $jml_jam }}</th>
                                </tr>
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