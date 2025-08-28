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
                        <div class="col-9">
                            <form action="{{ route('snbp.index') }}" method="get">
                                <div class="form-group col-md-3 has-icon-left position-relative">
                                    <input type="text" class="form-control" value="{{ request()->get('search') }}"
                                        name="search" placeholder="Search">
                                    <div class="form-control-icon"><i class="fa fa-search"></i></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-3">
                            <a href="{{ route('snbp.generate.create', $jurusan->id) }}" class="btn btn-primary">Generate</a>
                            <a href="{{ route('snbp.finalisasi.create', $jurusan->id) }}"
                                class="btn btn-success">Finalisasi</a>
                        </div>
                    </div>
                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Nama Siswa</td>
                                    <td>NISN</td>
                                    <td>Nilai</td>
                                    <td>Nilai Tambah</td>
                                    <td>Total</td>
                                    <td>Berminat</td>
                                    <td>Eligible</td>
                                    <td>Peringkat</td>
                                    <td>Eligible Final</td>
                                    <td>Peringkat Final</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                    $kuota = (40 / 100) * count($data);
                                @endphp

                                @forelse ($data as $item)
                                    @if ($item->is_berminat == 1)
                                        @php
                                            $berminat = 'Berminat';
                                        @endphp
                                    @else
                                        @if ($item->is_berminat == '0')
                                            @php
                                                $berminat = 'Tidak Berminat';
                                            @endphp
                                        @else
                                            @php
                                                $berminat = 'Belum Ditentukan';
                                            @endphp
                                        @endif
                                    @endif

                                    @if ($item->is_eligible == 1)
                                        @php
                                            $eligible = 'Eligible';
                                        @endphp
                                    @else
                                        @php
                                            $eligible = 'Tidak Eligible';
                                        @endphp
                                    @endif

                                    @if ($item->is_eligible_final == 1)
                                        @php
                                            $eligible_final = 'Eligible';
                                        @endphp
                                    @else
                                        @php
                                            $eligible_final = 'Tidak Eligible';
                                        @endphp
                                    @endif

                                    @if ($no <= $kuota)
                                        @php
                                            $class = '';
                                        @endphp
                                    @else
                                        @php
                                            $class = 'table-danger';
                                        @endphp
                                    @endif

                                    <tr class="{{ $class }}">
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama_siswa }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->rata_rata }}</td>
                                        <td>{{ $item->nilai_tambah }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>{{ $berminat }}</td>
                                        <td>{{ $eligible }}</td>
                                        <td>{{ $item->peringkat }}</td>
                                        <td>{{ $eligible_final }}</td>
                                        <td>{{ $item->peringkat_final }}</td>

                                    </tr>
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
