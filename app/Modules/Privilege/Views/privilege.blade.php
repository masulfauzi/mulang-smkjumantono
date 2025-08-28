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
            <h5 class="card-header">
                Tabel Data {{ $title }} untuk Role <u>{{ $role->role }}</u>
            </h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <form action="{{ route('privilege.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">  
						{!! button('privilege.create', $title, ['id_role' => $role->id]) !!}  
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
								<td>Menu</td>
                                <td class="text-center">Create</td>
								<td class="text-center">Read</td>
								<td class="text-center">Update</td>
								<td class="text-center">Delete</td>
								<td class="text-center">Show Menu</td>
                                <th class="text-center" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
									<td>{{ $item->menu->menu }}</td>
                                    <td class="text-center">{!! $item->create ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>' !!}</td>
									<td class="text-center">{!! $item->read ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>' !!}</td>
									<td class="text-center">{!! $item->update ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>' !!}</td>
									<td class="text-center">{!! $item->delete ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>' !!}</td>
									<td class="text-center">{!! $item->show_menu ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-ban text-danger"></i>' !!}</td>
                                    <td class="text-center">
										{!! button('privilege.edit', $title, ['privilege' => $item->id, 'id_role' => $role->id]) !!}
                                        {!! button('privilege.destroy', $title, ['privilege' => $item->id, 'id_role' => $role->id]) !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center"><i>No data.</i></td>
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