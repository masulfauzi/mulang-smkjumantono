@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Pengumpulan Soal PAS</h3>
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
                        <form action="{{ route('gurumapel.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">  
						{!! button('gurumapel.create', $title) !!}  
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr align="center">
                                <th width="15">No</th>
                                <th>Guru</th>
								<th>Mapel</th>
								<th>Tingkat</th>
								<th>Jurusan</th>
								<th>Kisi-Kisi</th>
								<th>Norma Penilaian & Kunci Jawaban</th>
								<th>Soal</th>
								
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->guru['nama'] }}</td>
									<td>{{ $item->mapel['mapel'] }}</td>
									<td>{{ $item->tingkat['tingkat'] }}</td>
									<td>{{ $item->jurusan['jurusan'] }}</td>
									<td  align="center">
                                        @if ($item->kisikisi)
                                            <a href="JavaScript:newPopup('{{ url('/gurumapel/'.$item->kisikisi.'/lihat/kisikisi') }}');">
                                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                            </a>
                                        @else
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if ($item->norma)
                                            <a href="JavaScript:newPopup('{{ url('/gurumapel/'.$item->norma.'/lihat/norma') }}');">
                                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                            </a>
                                        @else
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if ($item->soal)
                                            <a href="JavaScript:newPopup('{{ url('/gurumapel/'.$item->soal.'/lihat/soal') }}');">
                                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                            </a>
                                        @else
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        @endif
                                    </td>
                                    <td>
										{!! button('gurumapel.show','', $item->id) !!}
										{!! button('gurumapel.edit', $title, $item->id) !!}
                                        {!! button('gurumapel.destroy', $title, $item->id) !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center"><i>No data.</i></td>
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
    <script type="text/javascript">
        // Popup window code
        function newPopup(url) {
            popupWindow = window.open(
                url,'popUpWindow','height=300,width=400,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
        }
    </script>
@endsection

@section('inline-js')
@endsection