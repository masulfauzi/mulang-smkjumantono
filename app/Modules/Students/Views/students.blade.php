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
                        <form action="{{ route('students.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">  
						{!! button('students.create', $title) !!}  
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
                                <td>Nama Siswa</td>
								<td>Nis</td>
								<td>Nisn</td>
								<td>Nik</td>
								<td>Jeniskelamin</td>
								<td>Agama</td>
								<td>Tahun Masuk</td>
								<td>Tempat Lahir</td>
								<td>Tgl Lahir</td>
								<td>Nama Ayah</td>
								<td>Nama Ibu</td>
								<td>Alamat</td>
								<td>Sekolah Asal</td>
								<td>No Ijazah Smp</td>
								<td>No Skhun</td>
								<td>File Ijazah Smp</td>
								<td>File Skhun</td>
								<td>File Kk</td>
								<td>File Akta Lahir</td>
								<td>Tgl Lulus</td>
								<td>Is Lulus</td>
								
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nama_siswa }}</td>
									<td>{{ $item->nis }}</td>
									<td>{{ $item->nisn }}</td>
									<td>{{ $item->nik }}</td>
									<td>{{ $item->id_jeniskelamin }}</td>
									<td>{{ $item->id_agama }}</td>
									<td>{{ $item->tahun_masuk }}</td>
									<td>{{ $item->tempat_lahir }}</td>
									<td>{{ $item->tgl_lahir }}</td>
									<td>{{ $item->nama_ayah }}</td>
									<td>{{ $item->nama_ibu }}</td>
									<td>{{ $item->alamat }}</td>
									<td>{{ $item->sekolah_asal }}</td>
									<td>{{ $item->no_ijazah_smp }}</td>
									<td>{{ $item->no_skhun }}</td>
									<td>{{ $item->file_ijazah_smp }}</td>
									<td>{{ $item->file_skhun }}</td>
									<td>{{ $item->file_kk }}</td>
									<td>{{ $item->file_akta_lahir }}</td>
									<td>{{ $item->tgl_lulus }}</td>
									<td>{{ $item->is_lulus }}</td>
									
                                    <td>
										{!! button('students.show','', $item->id) !!}
										{!! button('students.edit', $title, $item->id) !!}
                                        {!! button('students.destroy', $title, $item->id) !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="23" class="text-center"><i>No data.</i></td>
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