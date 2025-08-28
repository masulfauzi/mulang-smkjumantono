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
                        <form action="{{ route('prestasi.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">  
						{!! button('prestasi.create', $title) !!}  
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
								<td>Siswa</td>
								<td>Prestasi</td>
                                <td>Tingkat</td>
								<td>Sertifikat</td>
								<td>Status</td>
								<td>Tgl Perolehan</td>
								{{-- <td>Is Pakai</td> --}}
								
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)

                                @if ($item->is_pakai == 1)
                                    @php
                                        $status = "Dipakai";
                                        $class = '';
                                    @endphp
                                @else
                                    @if ($item->is_pakai == '0')
                                        @php
                                            $status = "Tidak Dipakai";
                                            $class = '';
                                        @endphp
                                    @else
                                        @php
                                            $status = "Belum Ditentukan";
                                            $class = 'table-danger';
                                        @endphp
                                    @endif
                                @endif

                                <tr class="{{ $class }}">
                                    <td>{{ $no++ }}</td>
									<td>{{ $item->siswa->nama_siswa }}</td>
									<td>{{ $item->prestasi }}</td>
                                    <td>{{ $item->juara->juara }}</td>
									<td>
                                        <a target="_blank" href="{{ url('uploads/sertifikat_prestasi/'.$item->sertifikat) }}">Lihat</a>
                                    </td>
                                    <td>{{ $status }}</td>
									<td>{{ \App\Helpers\Format::tanggal($item->tgl_perolehan) }}</td>
									{{-- <td>{{ $item->is_pakai }}</td> --}}
									
                                    <td>
										{{-- {!! button('prestasi.show','', $item->id) !!}
										{!! button('prestasi.edit', $title, $item->id) !!}
                                        {!! button('prestasi.destroy', $title, $item->id) !!} --}}

                                        <a href="{{ route('prestasi.ubah_status.edit', [$item->id, '1']) }}" class="btn btn-primary">Pakai</a>
                                        <a href="{{ route('prestasi.ubah_status.edit', [$item->id, '0']) }}" class="btn btn-danger">Tidak Pakai</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center"><i>No data.</i></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
				{{ $data->links() }}
            </div>
        </div>

    </section>
</div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection