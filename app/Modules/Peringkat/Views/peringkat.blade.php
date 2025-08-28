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
                    Filter Data
                </h6>
                <div class="card-body">

                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <form action="">
                            <table>
                                <tr>
                                    <th>Semester</th>
                                    <td>:</td>
                                    <td>
                                        {{ Form::select("id_semester", $semester, $selected['id_semester'], ["class" => "form-control select2", "required" => "required"]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jurusan</th>
                                    <td>:</td>
                                    <td>
                                        {{ Form::select("id_jurusan", $jurusan, $selected['id_jurusan'], ["class" => "form-control select2", "required" => "required"]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>:</td>
                                    <td>
                                        {{ Form::select("id_kelas", $kelas, $selected['id_kelas'], ["class" => "form-control select2"]) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><button class="btn btn-primary" type="submit">Simpan</button></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>

        </section>


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
                                    <td>Siswa</td>
                                    <td>Semester</td>
                                    <td>Jml Nilai</td>

                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama_siswa }}</td>
                                        <td>{{ $item->semester }}</td>
                                        <td>{{ $item->jml_nilai }}</td>

                                        <td>
                                            {!! button('peringkat.show', '', $item->id) !!}
                                            {!! button('peringkat.edit', $title, $item->id) !!}
                                            {!! button('peringkat.destroy', $title, $item->id) !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <i>No data.</i> <br>
                                            @if ($selected['id_semester'])
                                                <a href="{{ route('peringkat.generate.index', $selected['id_semester']) }}" class="btn btn-success">Generate</a>
                                            @endif
                                        </td>
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
