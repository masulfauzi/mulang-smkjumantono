@extends('layouts.app')

@section('page-css')
    <style>
        body .modal-ku {
            width: 750px;
            margin: auto;
        }
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
                    Biodata Siswa
                </h6>
                <div class="card-body">

                    @include('include.flash')
                    <div class="table-responsive-md col-12">
                        <table class="table" id="">
                            <tbody>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <td>{{ $siswa->nama_siswa }}</td>

                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <a href="{{ route('prestasi.daftar_siswa.index', session('id_kelas')) }}"
                        class="btn btn-success">Kembali</a>
                </div>
            </div>
            <div class="card">
                <h6 class="card-header">
                    Tabel Data {{ $title }}
                </h6>
                <div class="card-body">
                    <div class="table-responsive-md col-12">
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <td>Siswa</td>

                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($prestasi as $item)
                                    @if ($item->is_verif == 1)
                                        <tr class="">
                                        @else
                                        <tr class="table-danger">
                                    @endif
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $item->prestasi }}</td>

                                    <td>
                                        <button class="btn btn-primary"
                                            onclick="detail_prestasi('{{ $item->id }}')">Detail</button>
                                    </td>
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

        </section>
    </div>
    <!-- Modal -->
    <div class="modal" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true" style="overflow:hidden;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">


                </div>

            </div>
        </div>

    </div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
    <script>
        function detail_prestasi(id_prestasi) {
            var id = id_prestasi;
            $.ajax({
                url: "{{ route('prestasi.detail.index') }}?id_prestasi=" + id,
                type: "GET",
                dataType: "html",
                success: function(html) {
                    $("#modal-body").html(html);
                    // $("#geojson").val(shape_for_db);
                    // document.getElementById('koordinat').value = shape_for_db;


                    $('#exampleModal').modal('show');
                }
            });
        }
    </script>
@endsection
