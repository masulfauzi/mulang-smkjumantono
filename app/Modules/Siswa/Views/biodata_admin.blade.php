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

                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Nama Siswa</td>
                                    <td>Kelas</td>
                                    <td>Akta Lahir</td>
                                    <td>Ijazah SMP</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($biodata as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama_siswa }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>
                                            @if ($item->file_akta_lahir)
                                                <a href="JavaScript:newPopup('{{ route('siswa.lihat_file.index',[$item->file_akta_lahir, 'akta']) }}');">
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->file_ijazah_smp)
                                                <a href="JavaScript:newPopup('{{ route('siswa.lihat_file.index',[$item->file_ijazah_smp, 'ijazah']) }}');">
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @endif
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
