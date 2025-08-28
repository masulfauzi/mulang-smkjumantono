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
                        <form action="{{ route('kelas.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">  
						{!! button('kelas.create', $title) !!}  
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
                                <td>Kelas</td>
								<td>Tingkat</td>
								<td>Jurusan</td>
								<td>Ruang</td>
								
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->kelas }}</td>
									<td>{{ $item->tingkat['tingkat'] }}</td>
									<td>{{ $item->jurusan['jurusan'] }}</td>
									<td>{{ $item->ruang['ruang'] }}</td>
									
                                    <td>
										{!! button('kelas.show','', $item->id) !!}
										{!! button('kelas.edit', $title, $item->id) !!}
                                        {!! button('kelas.destroy', $title, $item->id) !!}
                                        <a href="{{ route('kelas.naik.index', $item->id) }}" class="btn btn-primary">Naik Kelas</a>
                                        <a href="{{ route('kelas.download_file_smp_pdf.show', $item->id) }}" class="btn btn-secondary">Download Ijazah SMP PDF</a>
                                        <a href="{{ route('kelas.download_file_smp_image.show', $item->id) }}" class="btn btn-secondary">Download Ijazah SMP Gambar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center"><i>No data.</i></td>
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