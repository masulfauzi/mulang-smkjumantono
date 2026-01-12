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
                        
                    </div>
                    <div class="col-3">  
						{!! button('jurnal.create', $title) !!}  
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
                                <td>Mapel</td>
                                <td>Kelas</td>
								<td>Materi</td>
								<td>Tgl Pembelajaran</td>
								<td>Catatan</td>
								
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->mapel }}</td>
                                    <td>{{ $item->kelas }}</td>
									<td>{!! $item->materi !!}</td>
									<td>{{ \App\Helpers\Format::tanggal($item->tgl_pembelajaran, 1); }}</td>
									<td>{!! $item->catatan !!}</td>
									
                                    <td>
										<button class="btn btn-secondary" onclick="window.location.href='{{ route('jurnal.detail.index', $item->id) }}'">Detail</button>
										<a class="btn btn-danger" href="javascript:void(0);" onclick="deleteConfirm('{{ route('jurnal.destroy', $item->id) }}')">Delete</a>
										<a class="btn btn-warning mt-1" href="{{ route('jurnal.edit', $item->id) }}">Edit Jurnal</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"><i>No data.</i></td>
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