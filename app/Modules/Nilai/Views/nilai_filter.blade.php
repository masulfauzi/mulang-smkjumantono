@extends('layouts.app')

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Data Nilai</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('nilai.index') }}">{{ $title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lihat Nilai</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Filter Nilai
                </h6>
                <div class="card-body">
                    @include('include.flash')
                    <form class="form form-horizontal" action="{{ route('nilai.index') }}" method="GET"
                        enctype="multipart/form-data">
                        <div class="form-body">
                            {{-- @csrf  --}}
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Semester</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {!! Form::select('id_semester', $semester, $selected['id_semester'], [
                                        'class' => 'form-control select2',
                                        'required',
                                    ]) !!}
                                    @error('id_semester')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-sm-start text-md-end pt-2">
                                    <label>Jurusan</label>
                                </div>
                                <div class="col-md-9 form-group">
                                    {!! Form::select('id_jurusan', $jurusan, $selected['id_jurusan'], [
                                        'class' => 'form-control select2',
                                        'required',
                                    ]) !!}
                                    @error('id_jurusan')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="offset-md-3 ps-2">
                                <button class="btn btn-primary" type="submit">Simpan</button> &nbsp;
                                <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </section>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Data Nilai
                </h6>
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">

                        </div>
                        <div class="col-3">
                            {!! button('nilai.create', $title) !!}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NISN</th>
                                <th>Peringkat</th>
                                @foreach ($mapel as $item)
                                    <th>{{ $item->mapel }}</th>
                                @endforeach
                            </tr>
                            @php
                                $no = 1;
                                $skip = [
                                    '41add181-313c-4c27-9f7e-1a0236e1cdea',
                                    'afad1365-e60b-4c5a-8956-3d1c4dc98d0e',
                                    '471f4a09-5b09-40d5-b01b-7bff3490ee2f',
                                ];
                            @endphp

                            @foreach ($siswa as $item_siswa)
                                @if (in_array($item_siswa->id, $skip))
                                @else
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item_siswa->nama_siswa }}</td>
                                        <td>{{ $item_siswa->nisn }}</td>
                                        <td>{{ $item_siswa->peringkat_final }}</td>

                                        @foreach ($mapel as $item_mapel)
                                            @php
                                                $tampil_nilai = \App\Modules\Nilai\Models\Nilai::where(
                                                    'id_siswa',
                                                    $item_siswa->id,
                                                )
                                                    ->where('id_semester', $selected['id_semester'])
                                                    ->where('id_mapel', $item_mapel->id)
                                                    ->first()->nilai;
                                            @endphp

                                            @if ($tampil_nilai == '')
                                                @php
                                                    die($tampil_nilai);
                                                @endphp
                                            @endif

                                            <th>{!! $tampil_nilai !!}</th>
                                        @endforeach

                                    </tr>
                                @endif


                                {{-- @if ($no == 11)
                                {{ die(); }}
                            @endif --}}
                            @endforeach

                        </table>
                    </div>

                </div>
            </div>

        </section>



    </div>
@endsection

@section('inline-js')
@endsection
