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
                                {{-- <td>Guru</td> --}}
								<td>Mapel</td>
								<td>Tingkat</td>
								{{-- <td>Semester</td> --}}
								{{-- <td>Jenis Kosp</td> --}}
								<td>Jenis Perangkat</td>
								<td>File Sekarang</td>
								<td>Pilih File</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td rowspan="2">{{ $no++ }}</td>
                                    {{-- <td rowspan="2">{{ $item->guru['nama'] }}</td> --}}
									<td rowspan="2">{{ $item->mapel['mapel'] }}</td>
									<td rowspan="2">{{ $item->tingkat['tingkat'] }}</td>
									{{-- <td>{{ $item->id_semester }}</td> --}}
									{{-- <td>{{ $item->jenisKosp['jenis'] }}</td> --}}
									<td>
                                        File Silabus/ATP
                                    </td>
                                    <td>
                                        @if ($item->file_atp)
                                            <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                        @else
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        @endif
                                    </td>
									<td>
                                        <form action="">
                                            <input type="file" class="form-control">
                                            {{-- <br> --}}
                                            <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>File RPP/Module</td>
                                    <td>
                                        @if ($item->file_module)
                                            <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                        @else
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        <form action="">
                                            <input type="file" class="form-control">
                                            <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center"><i>No data.</i></td>
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