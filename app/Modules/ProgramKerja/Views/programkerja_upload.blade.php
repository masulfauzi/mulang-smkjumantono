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

                <div class="card-body">

                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="row">
                                <div class='col-lg-2'>
                                    <p>Unit Kerja</p>
                                </div>
                                <div class='col-lg-10'>
                                    <p class='fw-bold'>{{ $unitkerja->unit_kerja }}</p>
                                </div>
                                <div class='col-lg-2'>
                                    <p>Induk</p>
                                </div>
                                <div class='col-lg-10'>
                                    @if ($unitkerja->induk != '')
                                        <p class='fw-bold'>{{ $unitkerja->indukunit->unit_kerja }}</p>
                                    @else
                                        <p class='fw-bold'></p>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <hr>
                        <form class="form form-horizontal" action="{{ route('programkerja.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                                @csrf
                                @foreach ($forms as $key => $value)
                                    @if ($value[0] == '')
                                        {{ $value[1] }}
                                    @else
                                        <div class="row">
                                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                                <label>{{ $value[0] }}</label>
                                            </div>
                                            <div class="col-md-9 form-group">
                                                {{ $value[1] }}
                                                @error($key)
                                                    <div class="text-danger">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="offset-md-3 ps-2">
                                    <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                                    <a href="{{ route('programkerja.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <section class="section">
            <div class="card">

                <div class="card-body">

                    <div class="table-responsive-md col-12">
                        
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>File</td>

                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama_file }}</td>

                                        

                                        <td>
                                            <a target="_blank" href="{{ url('uploads/program_kerja/'.$item->file) }}" class="btn btn-primary">Lihat File</a>
                                            {{-- <a href="{{ route('programkerja.destroy',  $item->id) }}" class="btn btn-danger">Hapus</a> --}}
                                            <button class="btn btn-danger" onclick="deleteConfirm('{{ route('programkerja.destroy',  $item->id) }}')">Hapus</button>
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
