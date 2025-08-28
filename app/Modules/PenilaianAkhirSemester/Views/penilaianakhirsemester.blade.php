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
                                    @if (session('active_role')['id'] != '9ec7541e-5a5e-4a3a-a255-6ffb46895f46')
                                        <td>Guru</td>
                                    @endif
                                    <td>Mapel</td>
                                    <td>Tingkat</td>
                                    <td>Kisi-Kisi</td>
                                    <td>Kunci & Norma Penilaian</td>
                                    <td>Lembar Soal</td>

                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @inject('pas', 'App\Modules\PenilaianAkhirSemester\Models\PenilaianAkhirSemester')
                                @forelse ($data as $item)
                                    @php
                                        $perangkat = $pas->get_perangkat($item);
                                        // dd($perangkat->kisi_kisi);
                                    @endphp
                                    @if ($perangkat)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            @if (session('active_role')['id'] != '9ec7541e-5a5e-4a3a-a255-6ffb46895f46')
                                                <td>{{ $item->nama_guru }}</td>
                                            @endif
                                            <td>{{ $item->mapel }}</td>
                                            <td>{{ $item->tingkat }}</td>
                                            {{-- <td>{{ $item->id_semester }}</td> --}}
                                            <td>
                                                @if ($perangkat->kisi_kisi)
                                                    <a href="{{ url('uploads/kisikisi/' . $perangkat->kisi_kisi) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('assets/images/icon/check.png') }}"
                                                            alt="">
                                                    </a>
                                                @else
                                                    <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($perangkat->kunci)
                                                    <a href="{{ url('uploads/norma/' . $perangkat->kunci) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('assets/images/icon/check.png') }}"
                                                            alt="">
                                                    </a>
                                                @else
                                                    <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                                @endif
                                            </td>
                                            <td>
                                                @if ($perangkat->perangkat)
                                                    <a href="{{ url('uploads/soal/' . $perangkat->perangkat) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('assets/images/icon/check.png') }}"
                                                            alt="">
                                                    </a>
                                                @else
                                                    <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('penilaianakhirsemester.upload.index', $item->id) }}"
                                                    class="btn btn-primary">Upload</a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            @if (session('active_role')['id'] != '9ec7541e-5a5e-4a3a-a255-6ffb46895f46')
                                                <td>{{ $item->nama_guru }}</td>
                                            @endif
                                            <td>{{ $item->mapel }}</td>
                                            <td>{{ $item->tingkat }}</td>
                                            {{-- <td>{{ $item->id_semester }}</td> --}}
                                            <td>
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            </td>
                                            <td>
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            </td>
                                            <td>
                                                <img src="{{ asset('assets/images/icon/cross.png') }}" alt="">
                                            </td>

                                            <td>
                                                <a href="{{ route('penilaianakhirsemester.upload.index', $item->id) }}"
                                                    class="btn btn-primary">Upload</a>
                                            </td>
                                        </tr>
                                    @endif
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
@endsection

@section('inline-js')
@endsection
