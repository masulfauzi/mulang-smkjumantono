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
                    Tabel Data {{ $title }}
                </h6>
                <div class="card-body">

                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Jenis Workshop</td>
                                    <td>Link Modul Ajar</td>
                                    <td>Link Video Pembelajaran</td>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $no = 1; 
                                    $status_video = 0;
                                    $status_modul = 0;
                                @endphp
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->jenis_workshop }}</td>
                                        <td>
                                            @if ($item->link_modul_ajar == null)
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @else
                                                @php
                                                    
                                                    $pecah = explode('guru.kemdikbud.go.id', $item->link_modul_ajar);
                                                    // dd($pecah);
                                                @endphp

                                                @if (count($pecah) == 1)
                                                    Cek kembali link yang diupload.
                                                @else
                                                    @php
                                                        $status_modul = 1;
                                                    @endphp
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                @endif
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->link_video == null)
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @else
                                                @php
                                                    
                                                    $pecah = explode('guru.kemdikbud.go.id', $item->link_video);
                                                    // dd($pecah);
                                                @endphp

                                                @if (count($pecah) == 1)
                                                    Cek kembali link yang diupload.
                                                @else
                                                    @php
                                                        $status_video = 1;
                                                    @endphp
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                @endif
                                            @endif
                                        </td>

                                        <td>
                                            <a class="btn btn-primary"
                                                href="{{ route('sertifikat.create', ['id_jenis_workshop' => $item->id]) }}">Upload
                                                Bukti</a>

                                            @if ($status_modul == 1 && $status_video == 1)
                                                <a class="btn btn-danger"
                                                    href="{{ url('download_sertifikat/' . $item->folder . '/' . Auth::user()->username . '.pdf') }}">Download
                                                    Sertifikat
                                                </a>
                                                
                                            @endif

                                            
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center"><i>No data.</i></td>
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
