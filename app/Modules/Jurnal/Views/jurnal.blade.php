@extends('layouts.app')

@section('page-css')
<style>
    .tableFixHead          { overflow: auto; height: 100px; }
    .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

    /* Just common table stuff. Really. */
    table  { border-collapse: collapse; width: 100%; }
    th, td { padding: 8px 16px; }
    th     { background:#eee; }
</style>
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
                    Filter Data
                </h6>
                <div class="card-body">
                    <form action="" method="GET">
                    <div class="row">
                        
                            <div class="col-3">
                                <select name="bulan" id="bulan" class="form-select">
                                    <option @if ($bulan == '01') selected @endif value="01">Januari</option>
                                    <option @if ($bulan == '02') selected @endif value="02">Februari</option>
                                    <option @if ($bulan == '03') selected @endif value="03">Maret</option>
                                    <option @if ($bulan == '04') selected @endif value="04">April</option>
                                    <option @if ($bulan == '05') selected @endif value="05">Mei</option>
                                    <option @if ($bulan == '06') selected @endif value="06">Juni</option>
                                    <option @if ($bulan == '07') selected @endif value="07">Juli</option>
                                    <option @if ($bulan == '08') selected @endif value="08">Agustus</option>
                                    <option @if ($bulan == '09') selected @endif value="09">September</option>
                                    <option @if ($bulan == '10') selected @endif value="10">Oktober</option>
                                    <option @if ($bulan == '11') selected @endif value="11">November</option>
                                    <option @if ($bulan == '12') selected @endif value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select name="tahun" id="tahun" class="form-select">
                                    @for ($i = 2022; $i <= date('Y'); $i++)
                                        <option @if ($tahun == $i) selected @endif value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        
                    </div>
                </form>
                </div>
            </div>

            <div class="card" >
                <h6 class="card-header">
                    Monitoring Jurnal
                </h6>
                <div class="card-body" >

                    @include('include.flash')


                    <div class="table-responsive-md col-12" >
                        <div class="table-responsive tableFixHead" style="min-height: 500px">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th width="15" rowspan="2">No</th>
                                        <th rowspan="2">Nama</th>
                                        <th colspan="31" class="text-center">Tanggal</th>
                                    </tr>
                                    <tr>
                                        @for ($i = 1; $i <= 31; $i++)
                                            <th>{{ $i }}</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @forelse ($guru as $item)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $item->nama }}</td>

                                            @for ($i = 1; $i <= 31; $i++)
                                                @if (strlen($i) < 2)
                                                    @php
                                                        $tgl = '0' . $i;
                                                    @endphp
                                                @else
                                                    @php
                                                        $tgl = $i;
                                                    @endphp
                                                @endif

                                                @php
                                                    $cek = $jurnal
                                                        ->where('id_guru', $item->id)
                                                        ->where('tgl_pembelajaran', 'like', "$tahun-$bulan-$tgl")
                                                        ->first();
                                                @endphp

                                                @if ($cek)
                                                    <td><img width="20px"
                                                            src="{{ asset('assets/images/icon/check.png') }}"
                                                            alt=""></td>
                                                @else
                                                    <td></td>
                                                @endif
                                            @endfor


                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center"><i>No data.</i></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
