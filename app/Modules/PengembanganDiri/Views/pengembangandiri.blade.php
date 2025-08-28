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
                        <form action="{{ route('pengembangandiri.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">  
                        @if (session('active_role')['id'] == '9ec7541e-5a5e-4a3a-a255-6ffb46895f46')
						    {!! button('pengembangandiri.create', $title) !!}  
                        @else
                            <a href="{{ route('pengembangandiri.cetak.show') }}" class="btn btn-warning">Export Data</a>
                        @endif
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
                                <td>Jenis Pengembangan</td>
                                @if (session('active_role')['id'] != '9ec7541e-5a5e-4a3a-a255-6ffb46895f46')
                                    <td>Guru</td>
                                @endif
								<td>Nama Kegiatan</td>
								<td>Tgl Kegiatan</td>
								<td>Tempat</td>
								{{-- <td>Tahun</td> --}}
                                <td>Sertifikat</td>
                                <td>Laporan</td>
								
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->jenisPengembangan->jenis_pengembangan }}</td>
                                    @if (session('active_role')['id'] != '9ec7541e-5a5e-4a3a-a255-6ffb46895f46')
									    <td>{{ $item->guru->nama }}</td>
                                    @endif
									<td>{{ $item->nama_kegiatan }}</td>
									<td>{{ \App\Helpers\Format::tanggal($item->tgl_kegiatan) }}</td>
									<td>{{ $item->tempat }}</td>
									{{-- <td>{{ $item->tahun }}</td> --}}
                                    <td><span class="badge bg-primary"><a target="_blank" href="{{ url('uploads/pengembangan_diri/'.$item->sertifikat) }}" class="text-white">Lihat</a></span></td>
                                    <td>
                                        @if ($item->laporan)
                                            <span class="badge bg-success"><a target="_blank" href="{{ url('uploads/pengembangan_diri/'.$item->laporan) }}" class="text-white">Lihat</a></span></td>
                                        @else
                                            <span class="badge bg-warning">Belum Ada Laporan</span></td>
                                        @endif
									
                                    <td>
										{{-- {!! button('pengembangandiri.show','', $item->id) !!}
										{!! button('pengembangandiri.edit', $title, $item->id) !!} --}}
                                        {!! button('pengembangandiri.destroy', $title, $item->id) !!}
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