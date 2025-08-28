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
                        <form action="{{ route('soalsemester.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">  
						{!! button('soalsemester.create', $title) !!}  
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
                                <td>Ujiansemester</td>
								<td>No Soal</td>
								<td>Soal</td>
								<td>Gambar</td>
								<td>Opsi A</td>
								<td>Opsi B</td>
								<td>Opsi C</td>
								<td>Opsi D</td>
								<td>Opsi E</td>
								<td>Gambar A</td>
								<td>Gambar B</td>
								<td>Gambar C</td>
								<td>Gambar D</td>
								<td>Gambar E</td>
								
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->id_ujiansemester }}</td>
									<td>{{ $item->no_soal }}</td>
									<td>{{ $item->soal }}</td>
									<td>{{ $item->gambar }}</td>
									<td>{{ $item->opsi_a }}</td>
									<td>{{ $item->opsi_b }}</td>
									<td>{{ $item->opsi_c }}</td>
									<td>{{ $item->opsi_d }}</td>
									<td>{{ $item->opsi_e }}</td>
									<td>{{ $item->gambar_a }}</td>
									<td>{{ $item->gambar_b }}</td>
									<td>{{ $item->gambar_c }}</td>
									<td>{{ $item->gambar_d }}</td>
									<td>{{ $item->gambar_e }}</td>
									
                                    <td>
										{!! button('soalsemester.show','', $item->id) !!}
										{!! button('soalsemester.edit', $title, $item->id) !!}
                                        {!! button('soalsemester.destroy', $title, $item->id) !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="16" class="text-center"><i>No data.</i></td>
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