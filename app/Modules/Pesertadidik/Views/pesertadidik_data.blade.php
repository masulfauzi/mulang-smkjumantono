@extends('layouts.app')

@section('page-css')
@endsection

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-2">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Statistik Data Peserta Didik</h3>
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

        <div class="row">
            <div class="col-12">
                <section class="section">
                    <div class="card">
                        <h6 class="card-header">
                            Filter Data
                        </h6>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tingkat</label>
                                    {!! Form::select('tingkat', $tingkat, $filter['tingkat'], ['class'=>'form-control select2']) !!}
                                    
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>

                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <section class="section">
                    <div class="card">
                        <h6 class="card-header">
                            Jumlah Siswa Perjurusan
                        </h6>
                        <div class="card-body">
                            <div id="perjurusan"></div>
                        </div>
                    </div>

                </section>
            </div>
            <div class="col-6">
                <section class="section">
                    <div class="card">
                        <h6 class="card-header">
                            Jumlah Siswa Perjurusan
                        </h6>
                        <div class="card-body">
                            <div id="jenis_kelamin"></div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <section class="section">
                    <div class="card">
                        <h6 class="card-header">
                            Jumlah Siswa by Jenis Kelamin
                        </h6>
                        <div class="card-body">
                            <div id="jk"></div>
                        </div>
                    </div>

                </section>
            </div>
            <div class="col-6">
                <section class="section">
                    <div class="card">
                        <h6 class="card-header">
                            Jumlah Siswa by Agama
                        </h6>
                        <div class="card-body">
                            <div id="agama"></div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <section class="section">
                    <div class="card">
                        <h6 class="card-header">
                            Jumlah Siswa by Kelas
                        </h6>
                        <div class="card-body">
                            <div id="kelas"></div>
                        </div>
                    </div>

                </section>
            </div>

        </div>




    </div>
@endsection

@section('page-js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
@endsection

@section('inline-js')
    <script>
        // Data retrieved from https://netmarketshare.com
        Highcharts.chart('perjurusan', {
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
                pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
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
                    @foreach ($perjurusan as $item)
                        {
                            name: "{{ $item->jurusan }}",
                            y: {{ $item->jml }}
                        },
                    @endforeach
                ]
            }]
        });
    </script>
    <script>
        // Data retrieved from https://netmarketshare.com
        Highcharts.chart('agama', {
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
                pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
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
                    @foreach ($agama as $item)
                        {
                            name: "{{ $item->agama }}",
                            y: {{ $item->jml }}
                        },
                    @endforeach
                ]
            }]
        });
    </script>
    <script>
        // Data retrieved from https://netmarketshare.com
        Highcharts.chart('jk', {
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
                pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
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
                    @foreach ($jk as $item)
                        {
                            name: "{{ $item->jeniskelamin }}",
                            y: {{ $item->jml }}
                        },
                    @endforeach
                ]
            }]
        });
    </script>

    <script>
        Highcharts.chart('jenis_kelamin', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
                align: 'left'
            },
            xAxis: {
                categories: [
                    @foreach ($jenis_kelamin as $item)
                        "{{ $item->jurusan }}",
                    @endforeach
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Siswa'
                },
                stackLabels: {
                    enabled: true
                }
            },
            legend: {
                align: 'left',
                x: 70,
                verticalAlign: 'top',
                y: 70,
                floating: true,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Laki-Laki',
                data: [
                    @foreach ($jenis_kelamin as $item)
                        {{ $item->laki_laki }},
                    @endforeach
                ]
            }, {
                name: 'Perempuan',
                data: [
                    @foreach ($jenis_kelamin as $item)
                        {{ $item->perempuan }},
                    @endforeach
                ]
            }]
        });
    </script>
    <script>
        Highcharts.chart('kelas', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
                align: 'left'
            },
            xAxis: {
                categories: [
                    @foreach ($kelas as $item)
                        "{{ $item->kelas }}",
                    @endforeach
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Siswa'
                },
                stackLabels: {
                    enabled: true
                }
            },
            legend: {
                align: 'left',
                x: 70,
                verticalAlign: 'top',
                y: 70,
                floating: true,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Laki-Laki',
                data: [
                    @foreach ($kelas as $item)
                        {{ $item->laki_laki }},
                    @endforeach
                ]
            }, {
                name: 'Perempuan',
                data: [
                    @foreach ($kelas as $item)
                        {{ $item->perempuan }},
                    @endforeach
                ]
            }]
        });
    </script>
@endsection
