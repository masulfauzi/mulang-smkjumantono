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
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr align="center">
                                <th width="15">No</th>
								<th>Mapel</th>
								<th>Tingkat</th>
								<th>Jurusan</th>
								<th>Kisi-Kisi</th>
								<th>Kunci & Norma Penilaian</th>
								<th>Soal</th>
								
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $no++ }}</td>
									<td>{{ $item->mapel['mapel'] }}</td>
									<td>{{ $item->tingkat['tingkat'] }}</td>
									<td>{{ $item->jurusan['jurusan'] }}</td>
									<td align="center">
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
                                        @if ( $item->soal)
                                            <a href="JavaScript:newPopup('{{ url('/gurumapel/'.$item->soal.'/lihat/soal') }}');">
                                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                            </a>
                                        @else
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        @endif
                                    </td>
									
									
                                    <td>
										{{-- {!! button('gurumapel.show','', $item->id) !!}
										{!! button('gurumapel.edit', $title, $item->id) !!}
                                        {!! button('gurumapel.destroy', $title, $item->id) !!} --}}

                                        <a href="{{ url('/pas/upload/'.$item->id) }}" class="btn btn-primary">Upload File</a>
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