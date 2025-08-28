@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <a href="{{ route('unitkerja.index') }}" class="btn btn-sm icon icon-left btn-outline-secondary"><i class="fa fa-arrow-left"></i> Kembali </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unitkerja.index') }}">{{ $title }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $unitkerja->nama }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <h6 class="card-header">
                Detail Data {{ $title }}: {{ $unitkerja->nama }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-2">
                        <div class="row">
                            <div class='col-lg-2'><p>Unit Kerja</p></div><div class='col-lg-10'><p class='fw-bold'>{{ $unitkerja->unit_kerja }}</p></div>
									<div class='col-lg-2'><p>Induk</p></div><div class='col-lg-10'>
                                        @if ($unitkerja->induk != '')
                                        <p class='fw-bold'>{{ $unitkerja->indukunit->unit_kerja }}</p>
                                        
                                        @else
                                        <p class='fw-bold'></p>
                                            
                                        @endif
                                    </div>
									
                        </div>
                    </div>
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Unit Kerja</td>
                                    <td>Induk</td>

                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->unit_kerja }}</td>
                                        @if ($item->induk != '')
                                            <td>{{ $item->indukunit->unit_kerja }}</td>
                                        @else
                                            <td></td>
                                        @endif

                                        <td>
                                            {!! button('unitkerja.show', '', $item->id) !!}
                                            {!! button('unitkerja.edit', $title, $item->id) !!}
                                            {!! button('unitkerja.destroy', $title, $item->id) !!}
                                            <a class="btn btn-success"
                                                href="{{ route('unitkerja.create', ['induk' => $item->id]) }}">Tambah
                                                Child</a>
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
        </div>

    </section>
</div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection