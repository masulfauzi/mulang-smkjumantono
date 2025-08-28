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
        <div style="text-align: right;">
            <a href="{{ route('jurnal.guru.index') }}" class="btn btn-primary mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        
        <div class="card">
            <h6 class="card-header">
                Jurnal Pembelajaran
            </h6>
            <div class="card-body">
                
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <tr>
                            <th>Mapel</th>
                            <td>:</td>
                            <td>{{ $jurnal->mapel }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>:</td>
                            <td>{{ $jurnal->kelas }}</td>
                        </tr>
                        <tr>
                            <th>Materi</th>
                            <td>:</td>
                            <td>{!! $jurnal->materi !!}</td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>:</td>
                            <td>{!! $jurnal->catatan !!}</td>
                        </tr>
                    </table>
                </div>
				
            </div>

            
        </div>
        
        <div class="card">
            <h6 class="card-header">
                Presensi Siswa
            </h6>
            <div class="card-body">
                
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    
                        <input type="hidden" name="id_jurnal" value="{{ $jurnal->id }}">
                        @csrf
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Nama Siswa</td>
                                    <td>Status Kehadiran</td>
                                    <td>Catatan</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($siswa as $item)
                                <input type="hidden" name="id[{{ $no }}]" value="{{ $item->id }}">
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->nama_siswa }}</td>
                                        <td>
                                            {{ $item->status_kehadiran }}
                                        </td>
                                        <td>{{ $item->catatan }}</td>
                                    </tr>
                                    @php $no++; @endphp
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center"><i>No data.</i></td>
                                    </tr>
                                @endforelse
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