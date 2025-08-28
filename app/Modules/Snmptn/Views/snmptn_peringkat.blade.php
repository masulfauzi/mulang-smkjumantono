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
                Tabel Data {{ $jurusan->jurusan }}
            </h6>
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <form action="{{ route('snmptn.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">  
						<a href="{{ route('snmptn.hitung.index', $id_jurusan) }}" class="btn btn-primary">Hitung Ulang</a>
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
                                <td>NISN</td>
                                <td>Nama</td>
                                <td>Kelas</td>
                                <td>Rata-Rata Nilai</td>
                                <td>Prestasi</td>
                                <td>Peringkat</td>
                                <td>Bersedia</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse ($siswa as $item)
                                <tr
                                @if ($item->is_eligible == '0')
                                    class="table-danger"
                                @endif
                                >
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->nisn }}</td>
                                    <td>{{ $item->nama_siswa }}</td>
                                    <td>{{ $item->kelas }}</td>
                                    <td>{{ $item->rata_rata }}</td>
                                    <td>{{ $item->prestasi }}</td>
                                    <td>{{ $item->peringkat }}</td>
                                    <td>
                                        @if ($item->is_bersedia == '1')
                                            Ya
                                        @else
                                            Tidak
                                        @endif
                                    </td>
                                    <td><a class="btn btn-primary" href="{{ route('snmptn.edit.index', $item->id) }}">Edit</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center"><i>No data.</i></td>
                                </tr>
                            @endforelse
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