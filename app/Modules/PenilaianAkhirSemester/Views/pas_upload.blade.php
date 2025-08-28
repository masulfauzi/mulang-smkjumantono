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
                    Informasi Mapel
                </h6>
                <div class="card-body">
                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Mapel</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input disabled type="text" class="form-control" value="{{ $data->mapel['mapel'] }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                <label>Tingkat</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input disabled type="text" class="form-control"
                                    value="{{ $data->kelas->tingkat->tingkat }}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Tabel Data {{ $title }}
                </h6>
                <div class="card-body">
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr align="center">
                                    <th width="15">No</th>
                                    <th>Kelengkapan</th>
                                    <th>File Sekarang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($perangkat)
                                    <tr>
                                        <td>1</td>
                                        <td>Kisi-Kisi</td>
                                        <td align="center">
                                            @if ($perangkat->kisi_kisi)
                                                <a
                                                    href="JavaScript:newPopup('{{ url('/gurumapel/' . $perangkat->kisi_kisi . '/lihat/kisikisi') }}');">
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('penilaianakhirsemester.aksi_upload.index') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                <input type="hidden" name="jenis" value="kisikisi">
                                                <input type="file" name="file" class="form-control">
                                                <button type="submit" class="btn btn-primary mt-1">Upload</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Kunci & Norma Penilaian</td>
                                        <td align="center">
                                            @if ($perangkat->kunci)
                                                <a
                                                    href="JavaScript:newPopup('{{ url('/gurumapel/' . $perangkat->kunci . '/lihat/norma') }}');">
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($perangkat->kisi_kisi)
                                                <form action="{{ route('penilaianakhirsemester.aksi_upload.index') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                                    <input type="hidden" name="jenis" value="norma">
                                                    <input type="file" name="file" class="form-control">
                                                    <button type="submit" class="btn btn-primary mt-1">Upload</button>
                                                </form>
                                            @else
                                                Kisi-Kisi belum di upload.
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Soal</td>
                                        <td align="center">
                                            @if ($perangkat->perangkat)
                                                <a
                                                    href="JavaScript:newPopup('{{ url('/gurumapel/' . $perangkat->perangkat . '/lihat/soal') }}');">
                                                    <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                                </a>
                                            @else
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($perangkat->kunci)
                                                <form action="{{ route('penilaianakhirsemester.aksi_upload.index') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                                    <input type="hidden" name="jenis" value="soal">
                                                    <input type="file" name="file" class="form-control">
                                                    <button type="submit" class="btn btn-primary mt-1">Upload</button>
                                                </form>
                                            @else
                                                Kunci & Norma belum di upload.
                                            @endif

                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>1</td>
                                        <td>Kisi-Kisi</td>
                                        <td align="center">
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        </td>
                                        <td>
                                            <form action="{{ route('penilaianakhirsemester.aksi_upload.index') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                <input type="hidden" name="jenis" value="kisikisi">
                                                <input type="file" name="file" class="form-control">
                                                <button type="submit" class="btn btn-primary mt-1">Upload</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Kunci & Norma Penilaian</td>
                                        <td align="center">
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        </td>
                                        <td>
                                            Kisi-Kisi belum di upload.

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Soal</td>
                                        <td align="center">
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        </td>
                                        <td>
                                            Kunci & Norma belum di upload.

                                        </td>
                                    </tr>
                                @endif


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
                url, 'popUpWindow',
                'height=300,width=400,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes'
            )
        }
    </script>
@endsection

@section('inline-js')
@endsection
