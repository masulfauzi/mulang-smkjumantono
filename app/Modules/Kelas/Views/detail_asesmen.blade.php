@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
<div class="page-heading">
    <div class="page-title">
        <div class="row mb-2">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Asesmen Diagnostik kelas {{ $kelas->kelas }}</h3>
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

    @if ($kelas->tingkat->tingkat == 'X')
        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Aspek Fisik
                </h6>
                <div class="card-body">
                    <div id="aspek_fisik"></div>
                </div>
            </div>

        </section>
        
        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Aspek Psikis
                </h6>
                <div class="card-body">
                    <div id="aspek_psikis"></div>
                </div>
            </div>

        </section>
        
        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Aspek Sarana
                </h6>
                <div class="card-body">
                    <div id="aspek_sarana"></div>
                </div>
            </div>

        </section>
        
        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Gaya Belajar
                </h6>
                <div class="card-body">
                    <div id="gaya_belajar"></div>
                </div>
            </div>

        </section>
    @endif

    @if ($kelas->tingkat->tingkat == 'XI')
        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Kesesuaian Jurusan
                </h6>
                <div class="card-body">
                    <div id="kesesuaian"></div>
                </div>
            </div>

        </section>
    @endif

    
</div>
@endsection

@section('page-js')
<script src="https://code.highcharts.com/highcharts.js"></script>
@endsection
 
@section('inline-js')
@if ($kelas->tingkat->tingkat == 'XI')
    <script>
        // Data retrieved from https://netmarketshare.com
    Highcharts.chart('kesesuaian', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '',
            align: 'left'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                @foreach($kesesuaian as $item => $key)
                    {
                        name: "{{ $item }}",
                        y: {{ $key }}
                    },
                @endforeach
            ]
        }]
    });

    </script>
@endif
@if ($kelas->tingkat->tingkat == 'X')
    <script>
        // Data retrieved from https://netmarketshare.com
    Highcharts.chart('aspek_fisik', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '',
            align: 'left'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                @foreach($aspek_fisik as $item => $key)
                    {
                        name: "{{ $item }}",
                        y: {{ $key }}
                    },
                @endforeach
            ]
        }]
    });

    </script>
    <script>
        // Data retrieved from https://netmarketshare.com
    Highcharts.chart('aspek_psikis', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '',
            align: 'left'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                @foreach($aspek_psikis as $item => $key)
                    {
                        name: "{{ $item }}",
                        y: {{ $key }}
                    },
                @endforeach
            ]
        }]
    });

    </script>
    <script>
        // Data retrieved from https://netmarketshare.com
    Highcharts.chart('aspek_sarana', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '',
            align: 'left'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                @foreach($aspek_sarana as $item => $key)
                    {
                        name: "{{ $item }}",
                        y: {{ $key }}
                    },
                @endforeach
            ]
        }]
    });

    </script>
    <script>
        // Data retrieved from https://netmarketshare.com
    Highcharts.chart('gaya_belajar', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '',
            align: 'left'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Jumlah',
            colorByPoint: true,
            data: [
                @foreach($gaya_belajar as $item => $key)
                    {
                        name: "{{ $item }}",
                        y: {{ $key }}
                    },
                @endforeach
            ]
        }]
    });

    </script>
@endif

@endsection