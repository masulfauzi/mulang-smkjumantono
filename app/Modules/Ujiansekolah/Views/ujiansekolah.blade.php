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
                            <form action="{{ route('ujiansekolah.index') }}" method="get">
                                <div class="form-group col-md-3 has-icon-left position-relative">
                                    <input type="text" class="form-control" value="{{ request()->get('search') }}"
                                        name="search" placeholder="Search">
                                    <div class="form-control-icon"><i class="fa fa-search"></i></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-3">
                            {!! button('ujiansekolah.create', $title) !!}
                        </div>
                    </div>
                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Guru</td>
                                    <td>Mapel</td>
                                    <td>Jurusan</td>
                                    <td>Jml Soal</td>
                                    <td>Kisi Kisi</td>
                                    <td>Norma Penilaian</td>
                                    <td>Soal Utama</td>
                                    {{-- <td>Soal Susulan</td> --}}


                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = $data->firstItem(); @endphp
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->guru['nama'] }}</td>
                                        <td>{{ $item->mapel['mapel'] }}</td>
                                        <td>{{ $item->jurusan['jurusan'] }}</td>
                                        <td>{{ $item->jml_soal }}</td>
                                        <td>
                                            @if ($item->kisi_kisi)
                                                <a
                                                    href="JavaScript:newPopup('{{ url('/gurumapel/' . $item->kisi_kisi . '/lihat/kisikisi') }}');">
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->norma_penilaian)
                                                <a
                                                    href="JavaScript:newPopup('{{ url('/gurumapel/' . $item->norma_penilaian . '/lihat/norma') }}');">
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->soal)
                                                <a
                                                    href="JavaScript:newPopup('{{ url('/gurumapel/' . $item->soal . '/lihat/soal') }}');">
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @endif
                                        </td>
                                        {{-- <td>
                                            <a href="javascript:void(0);"
                                                onclick="window.open('{{ route('soal.lihat_soal.index', [$item->id, 'c365b003-7203-4e5d-b215-1f934238db2f']) }}', '_blank', 'width=auto,height=auto');">
                                                <a href="{{ route('soal.lihat_soal.index', [$data->id, 'c365b003-7203-4e5d-b215-1f934238db2f']) }}">
                                                Lihat Soal
                                            </a>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);"
                                                onclick="window.open('{{ route('soal.lihat_soal.index', [$item->id, '068aa935-e996-4f86-9689-3da4a9aee8f5']) }}', '_blank', 'width=auto,height=auto');">
                                                <a href="{{ route('soal.lihat_soal.index', [$data->id, 'c365b003-7203-4e5d-b215-1f934238db2f']) }}">
                                                Lihat Soal
                                            </a>
                                        </td> --}}


                                        <td>
                                            {!! button('ujiansekolah.show', '', $item->id) !!}
                                            {!! button('ujiansekolah.edit', $title, $item->id) !!}
                                            {!! button('ujiansekolah.destroy', $title, $item->id) !!}
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
    <script type="text/javascript">
        // Popup window code
        function newPopup(url) {
            popupWindow = window.open(
                url, 'popUpWindow',
                'height=300,width=400,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes'
            )
        }
    </script>
@endsection

@section('inline-js')
@endsection
