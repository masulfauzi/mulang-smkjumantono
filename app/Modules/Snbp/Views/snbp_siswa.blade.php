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
                    Info Data Eligible FINAL
                </h6>
                <div class="card-body">

                    @include('include.flash')

                    @if ($data->is_eligible_final == 1)
                        <div class="table-responsive-md col-12">
                            <p class="text-center text-xl"><strong>SELAMAT!</strong> Anda termasuk dalam siswa
                                <strong>ELIGIBLE</strong>.
                            </p>
                            <p class="text-center text-xl">Jangan lupa untuk membuat akun di SNPMB.</p>
                        </div>
                    @else
                        <div class="table-responsive-md col-12">
                            <p class="text-center text-xl"><strong>MAAF! ANDA TIDAK TERMASUK SISWA ELIGIBLE</strong>.</p>
                            <p class="text-center text-xl">Tetap Semangat!</p>
                        </div>
                    @endif

                </div>
            </div>

        </section>

    </div>
@endsection

@section('page-js')
@endsection

@section('inline-js')
@endsection
