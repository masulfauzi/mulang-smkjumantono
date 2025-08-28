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
                    <div class="row">
                        <div class="col-3">Nama</div>
                        <div class="col-3">{{ $siswa->nama_siswa }}</div>
    
                    </div>
                    <div class="row">
                        <div class="col-9"></div>
                        <div class="col-3">
                            <a href="{{ route('nilai.daftar_siswa.index', session('id_kelas')) }}" class="btn btn-success">Kembali</a>
                        </div>
                    </div>
                    @include('include.flash')
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach ($semester as $item)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="{{ $item->semester->id }}-tab" data-bs-toggle="tab"
                                    href="#tab-{{ $item->semester->id }}" role="tab" aria-controls="home"
                                    aria-selected="false">{{ $item->semester->semester }}</a>
                            </li>
                        @endforeach

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($semester as $item)
                            @php
                                $data_konfirmasi = $konfirmasi->where('id_semester', '=', $item->id_semester)->first();
                            @endphp
                            <div class="tab-pane fade show @if ($no == 1) active @endif"
                                id="tab-{{ $item->semester->id }}" role="tabpanel"
                                aria-labelledby="{{ $item->semester->id }}-tab">
                                <h2 class="my-2">Daftar Nilai Semester {{ $item->semester->semester }}</h2>
                                <div class="row">
                                    <div class="col-6">

                                        <form action="{{ route('nilai.verif_nilai.store') }}" method="POST">

                                            @csrf
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Mapel</th>
                                                    <th>Nilai</th>
                                                </tr>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($nilai->where('id_semester', '=', $item->id_semester) as $item_nilai)
                                                    <input type="hidden" name="id_nilai[]" value="{{ $item_nilai->id }}">
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>{{ $item_nilai->mapel->mapel }}</td>
                                                        {{-- <td>{{ $item_nilai->nilai }}</td> --}}
                                                        <td><input class="form-control" type="text" name="nilai[]"
                                                                value="{{ $item_nilai->nilai }}"></td>
                                                    </tr>
                                                    @php
                                                        $no++;
                                                    @endphp
                                                @endforeach
                                            </table>
                                            @if ($data_konfirmasi)
                                                <input type="hidden" name="id_konfirmasi"
                                                    value="{{ $data_konfirmasi->id }}">
                                                <button class="btn btn-danger" type="submit">Verifikasi</button>
                                            @else
                                            @endif
                                        </form>
                                    </div>
                                    <div class="col-6">
                                        @if ($data_konfirmasi)
                                            @if ($data_konfirmasi->is_verif == 1)
                                                <h4>Data Semester Ini Sudah Diverifikasi.</h4>
                                            @else
                                                @if ($data_konfirmasi->is_sesuai == 1)
                                                    <h4>Data Semester Ini Sudah Sesuai.</h4>
                                                @else
                                                    <h5>Data Semester Ini Belum Sesuai.</h5>
                                                    <p>Catatan: {!! $data_konfirmasi->keterangan !!}</p>
                                                    <img src="{{ url('uploads/bukti_nilai/' . $data_konfirmasi->bukti) }}"
                                                        width="400px;" alt="Foto Pekerjaan">
                                                @endif
                                            @endif
                                        @else
                                            <h4>Nilai Semester Ini Belum Dikonfirmasi</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php
                                $no++;
                            @endphp
                        @endforeach


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
