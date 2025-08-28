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
                                <td>Guru</td>
								
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ route('jadwal.mapping_guru.store') }}" method="POST">
                                @csrf
                           @php
                               $no = 1;
                           @endphp
                            @forelse ($teachers as $teacher)
                                {!! Form::hidden('teacherids[]', $teacher->id) !!}
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $teacher->name }}</td>
									
                                    <td>
                                        {!! Form::select('id_guru[]', $guru, null, ["class" => "form-control select2", "required" => "required"]) !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center"><i>No data.</i></td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="3" class="text-center"><button class="btn btn-primary" type="submit">Simpan</button></td>
                            </tr>
                        </form>
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