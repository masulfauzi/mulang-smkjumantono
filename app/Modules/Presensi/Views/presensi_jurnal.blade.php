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
                    <form action="{{ route('presensi.jurnal.store') }}" method="POST">
                        <input type="hidden" name="id_jurnal" value="{{ $jurnal->id }}">
                        @csrf
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Nama Siswa</td>
                                    <td>Catatan</td>
                                    <td>Status Kehadiran</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($siswa as $item)
                                <input type="hidden" name="id[{{ $no }}]" value="{{ $item->id }}">
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->nama_siswa }}</td>
                                        <td><input class="form-control" type="text" name="catatan[{{ $no }}]" value="{{ $item->catatan }}"></td>
                                        <td>
                                            <input @if ($item->id_statuskehadiran == "5cb7e9bc-79dc-4deb-8bd2-77930dbca9a3")
                                            checked="checked"
                                            @endif value="5cb7e9bc-79dc-4deb-8bd2-77930dbca9a3" type="radio" name="id_statuskehadiran[{{ $no }}]"> Hadir
                                            <input @if ($item->id_statuskehadiran == "594e4276-34ef-4c87-9575-6aeec8e62fa9")
                                            checked="checked"
                                            @endif value="594e4276-34ef-4c87-9575-6aeec8e62fa9" style="margin-left: 15px;" type="radio" name="id_statuskehadiran[{{ $no }}]"> Sakit
                                            <input @if ($item->id_statuskehadiran == "79bab833-e4f7-4ca9-872e-ee17acfb02c2")
                                            checked="checked"
                                            @endif value="79bab833-e4f7-4ca9-872e-ee17acfb02c2" style="margin-left: 15px;" type="radio" name="id_statuskehadiran[{{ $no }}]"> Ijin
                                            <input @if ($item->id_statuskehadiran == "ddce3af2-26e6-4827-af85-f618523cf83e")
                                            checked="checked"
                                            @endif value="ddce3af2-26e6-4827-af85-f618523cf83e" style="margin-left: 15px;" type="radio" name="id_statuskehadiran[{{ $no }}]"> Alfa
                                        </td>
                                    </tr>
                                    @php $no++; @endphp
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center"><i>No data.</i></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
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