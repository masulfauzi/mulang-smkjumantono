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
                        <form action="{{ route('ujiansemester.index') }}" method="get">
                            <div class="form-group col-md-3 has-icon-left position-relative">
                                <input type="text" class="form-control" value="{{ request()->get('search') }}" name="search" placeholder="Search">
                                <div class="form-control-icon"><i class="fa fa-search"></i></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-3">
                        {!! button('ujiansemester.create', $title) !!}
                    </div>
                </div>
                @include('include.flash')
                <div class="table-responsive-md col-12">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th width="15">No</th>
                                <td>Mapel</td>
                                <td>Guru</td>
                                <td>Jurusan</td>
                                <td>Tingkat</td>
                                <td>Jml Soal</td>
                                <td>Kisi Kisi</td>
                                <td>Norma Penilaian</td>
                                <td>Soal</td>

                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = $data->firstItem(); @endphp
                            @forelse ($data as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->mapel->mapel }}</td>
                                <td>{{ $item->guru->nama }}</td>
                                <td>{{ $item->jurusan->jurusan }}</td>
                                <td>{{ $item->tingkat->tingkat }}</td>
                                <td>{{ $item->jml_soal }}</td>
                                <td>
                                    @if ($item->kisi_kisi)
                                    <a href="JavaScript:newPopup('{{ url('/gurumapel/'.$item->kisi_kisi.'/lihat/kisikisi') }}');">
                                        <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                    </a>
                                    @else
                                    <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                    @endif
                                </td>
                                <td>
                                    @if ($item->norma_penilaian)
                                    <a href="JavaScript:newPopup('{{ url('/gurumapel/'.$item->norma_penilaian.'/lihat/kisikisi') }}');">
                                        <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                    </a>
                                    @else
                                    <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $soal = \App\Modules\SoalSemester\Models\SoalSemester::where('id_ujiansemester', $item->id)->get();
                                    @endphp

                                    @if (count($soal) > 0)
                                        <a href="javascript:void(0);" onclick="window.open('{{ route('soalsemester.lihat_soal.index', [$item->id, 'c365b003-7203-4e5d-b215-1f934238db2f']) }}', '_blank', 'width=auto,height=auto');">
                                            <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                        </a>
                                        {{-- <a href="JavaScript:newPopup('{{ url('/gurumapel/'.$item->id.'/lihat/kisikisi') }}');">
                                            <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                        </a> --}}
                                    @else
                                        <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('ujiansemester.upload.index', $item->id) }}" class="btn btn-success">Upload Berkas</a>
                                    <a href="{{ route('ujiansemester.export.index', $item->id) }}" class="btn btn-primary">Export</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center"><i>No data.</i></td>
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