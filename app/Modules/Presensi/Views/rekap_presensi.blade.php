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
                        <div class="col-12">
                            <form action="" method="get" class="form form-horizontal">
                                <div class="row">
                                    <div class="col-md-4">
                                        {{ Form::select('id_kelas', $kelas, $kelas_terpilih, ['class' => 'form-control select2']) }}
                                    </div>
                                    <div class="col-md-3">
                                        {{ Form::select('bulan', $bulan, $bulan_terpilih, ['class' => 'form-control select2']) }}
                                    </div>
                                    <div class="col-md-3">
                                        @php
                                            $year_now = date('Y');
                                            $years = [];
                                            for ($y = 2025; $y <= $year_now; $y++) {
                                                $years[$y] = $y;
                                            }
                                        @endphp
                                        {{ Form::select('tahun', $years, request('tahun', $year_now), ['class' => 'form-control select2']) }}
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary">Lihat Data</button>
                                        @if ($kelas_terpilih)
                                            <a target="_blank"
                                                href="{{ route('presensi.export.index', ['id_kelas' => $kelas_terpilih, 'bulan' => $bulan_terpilih]) }}"
                                                class="btn btn-secondary">Export</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15" rowspan="2">No</th>
                                    <td rowspan="2">Nama</td>
                                    <td colspan="31">Tanggal</td>
                                    <td colspan="31">Keterangan</td>
                                </tr>
                                <tr>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <td>{{ $i }}</td>
                                    @endfor
                                    <td>S</td>
                                    <td>I</td>
                                    <td>A</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                    $sakit = 0;
                                    $ijin = 0;
                                    $alfa = 0;
                                @endphp
                                @foreach ($pesertadidik as $p)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $p->nama_siswa }}</td>
                                        @for ($i = 1; $i <= 31; $i++)
                                            @php
                                                if ($i < 10) {
                                                    $tgl = $tahun_terpilih . '-' . $bulan_terpilih . '-' . '0' . $i;
                                                } else {
                                                    $tgl = $tahun_terpilih . '-' . $bulan_terpilih . '-' . $i;
                                                }
                                            @endphp

                                            @if ($data = $presensi->where('tgl_pembelajaran', '=', $tgl)->where('id_pesertadidik', '=', $p->id)->where('status_kehadiran_pendek', '=', 'H')->first())
                                                <td>{{ $data->status_kehadiran_pendek }}</td>
                                            @else
                                                @if ($data2 = $presensi->where('tgl_pembelajaran', '=', $tgl)->where('id_pesertadidik', '=', $p->id)->where('status_kehadiran_pendek', '=', 'S')->first())
                                                    <td>{{ $data2->status_kehadiran_pendek }}</td>
                                                    @php
                                                        $sakit++;
                                                    @endphp
                                                @else
                                                    @if ($data3 = $presensi->where('tgl_pembelajaran', '=', $tgl)->where('id_pesertadidik', '=', $p->id)->where('status_kehadiran_pendek', '=', 'I')->first())
                                                        <td>{{ $data3->status_kehadiran_pendek }}</td>
                                                        @php
                                                            $ijin++;
                                                        @endphp
                                                    @else
                                                        @if ($data4 = $presensi->where('tgl_pembelajaran', '=', $tgl)->where('id_pesertadidik', '=', $p->id)->where('status_kehadiran_pendek', '=', 'A')->first())
                                                            <td>{{ $data4->status_kehadiran_pendek }}</td>
                                                            @php
                                                                $alfa++;
                                                            @endphp
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endfor
                                        <td>{{ $sakit }}</td>
                                        <td>{{ $ijin }}</td>
                                        <td>{{ $alfa }}</td>

                                    </tr>
                                    @php
                                        $sakit = 0;
                                        $ijin = 0;
                                        $alfa = 0;
                                    @endphp
                                @endforeach
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