@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-2">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Pengumpulan Soal Ujian Sekolah</h3>
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
                                    <th>Kelengkapan</th>
                                    <th>File Sekarang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>1</td>
                                    <td>Kisi-Kisi</td>
                                    <td align="center">
                                        @if ($data->kisi_kisi)
                                            <a
                                                href="JavaScript:newPopup('{{ url('/gurumapel/' . $data->kisi_kisi . '/lihat/kisikisi') }}');">
                                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                            </a>
                                        @else
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('ujiansekolah.guru.aksi_upload.index') }}" method="POST"
                                            enctype="multipart/form-data">
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
                                        @if ($data->norma_penilaian)
                                            <a
                                                href="JavaScript:newPopup('{{ url('/gurumapel/' . $data->norma_penilaian . '/lihat/norma') }}');">
                                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                            </a>
                                        @else
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->kisi_kisi)
                                            <form action="{{ route('ujiansekolah.guru.aksi_upload.index') }}"
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
                                    <td>Soal Utama</td>
                                    <td align="center">
                                        {{-- @if ($soal_utama->count() > 0) --}}
                                        @if ($data->soal)
                                            {{-- <a href="javascript:void(0);"
                                                onclick="window.open('{{ route('soal.lihat_soal.index', [$data->id, 'c365b003-7203-4e5d-b215-1f934238db2f']) }}', '_blank', 'width=auto,height=auto');">
                                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                            </a> --}}
                                            <a
                                                href="JavaScript:newPopup('{{ url('/gurumapel/' . $data->soal . '/lihat/soal') }}');">
                                                <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                            </a>
                                        @else
                                            <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($data->norma_penilaian)
                                            {{-- <a href="{{ route('soal.input_soal.create', array('id_ujian' => $data->id, 'id_jenissoal' => 'c365b003-7203-4e5d-b215-1f934238db2f', 'no_soal' => '1')) }}" class="btn btn-primary">Input Soal</a> --}}
                                            <hr>
                                            {{-- <form action="{{ route('ujiansekolah.guru.upload_excel.index') }}" --}}
                                            <form action="{{ route('ujiansekolah.guru.aksi_upload.index') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                <input type="hidden" name="id_jenissoal"
                                                    value="c365b003-7203-4e5d-b215-1f934238db2f">
                                                <input type="hidden" name="jenis" value="soal">
                                                <input type="file" name="file" class="form-control">
                                                <button type="submit" class="btn btn-primary mt-1">Upload</button>
                                            </form>
                                        @else
                                            Kunci & Norma belum di upload.
                                        @endif

                                    </td>
                                </tr>
                                {{-- <tr>
                                <td>4</td>
                                <td>Soal Susulan</td>
                                <td align="center">
                                    @if ($soal_susulan->count() > 0)
                                        <a href="javascript:void(0);" onclick="window.open('{{ route('soal.lihat_soal.index', [$data->id, '068aa935-e996-4f86-9689-3da4a9aee8f5']) }}', '_blank', 'width=auto,height=auto');">
                                            <img src="{{ asset('assets/images/icon/check.png') }}" alt="">
                                        </a>
                                    @else
                                        <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                    @endif
                                </td>
                                <td>
                                    @if ($data->norma_penilaian)
                                        <a href="{{ route('soal.input_soal.create', array('id_ujian' => $data->id, 'id_jenissoal' => '068aa935-e996-4f86-9689-3da4a9aee8f5', 'no_soal' => '1')) }}" class="btn btn-primary">Input Soal</a>
                                        <hr>
                                        <form action="{{ route('ujiansekolah.guru.upload_excel.index') }}"  method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                            <input type="hidden" name="id_jenissoal" value="068aa935-e996-4f86-9689-3da4a9aee8f5">
                                            <input type="file" name="file" class="form-control">
                                            <button type="submit" class="btn btn-primary mt-1">Upload</button>
                                        </form>
                                    @else
                                        Kunci & Norma belum di upload.
                                    @endif
                                    
                                </td>
                            </tr> --}}
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
