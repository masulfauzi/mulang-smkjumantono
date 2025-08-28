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
                Tabel Data Peringkat Kelas
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <form action="" method="get">
                            <div class="form-group col-md-6 has-icon-left position-relative">
                                <label for="semester">Semester</label>
                                <select name="semester" id="" class="form-control">
                                    <option value="">-PILIH SALAH  SATU-</option>
                                    <option @if ($semester == 1)
                                        selected
                                    @endif value="1">Semester 1</option>
                                    <option @if ($semester == 2)
                                    selected
                                    @endif value="2">Semester 2</option>
                                    <option @if ($semester == 3)
                                    selected
                                    @endif value="3">Semester 3</option>
                                    <option @if ($semester == 4)
                                    selected
                                    @endif value="4">Semester 4</option>
                                    <option @if ($semester == 5)
                                    selected
                                    @endif value="5">Semester 5</option>
                                    <option @if ($semester == 6)
                                    selected
                                    @endif value="6">Semester 6</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 has-icon-left position-relative">
                                <label for="id_jurusan">Jurusan</label>
                                <select name="id_jurusan" id="" class="form-control">
                                    @foreach ($jurusan as $key => $item)
                                        <option @if ($id_jurusan == $key)
                                            selected
                                        @endif value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 has-icon-left position-relative">
                                <label for="id_kelas">Kelas</label>
                                <select name="id_kelas" id="" class="form-control">
                                    @foreach ($kelas as $keys => $items)
                                        <option @if ($id_kelas == $keys)
                                            selected
                                        @endif value="{{ $keys }}">{{ $items }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                    
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
                                <td>NISN</td>
                                <td>Nama</td>
                                <td>Peringkat</td>
                                <td>Nilai</td>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @if ($data)
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->nama_siswa }}</td>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nilai }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">Tidak ada data.</td>
                                </tr>
                            @endif
                            
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