@extends('layouts.app')

@section('main')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Data {{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pesan.index') }}">{{ $title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Form Tambah {{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <h6 class="card-header">
                    Form Tambah Data {{ $title }}
                </h6>
                <div class="card-body">
                    @include('Pesan::pesan_tombol_tab')
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="nomor" role="tabpanel"
                            aria-labelledby="detail_kps-tab">

                            <div class="row match-height">
                                <div class="col-md-12 col-12">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <form class="form form-horizontal" action="{{ route('pesan.banyak_nomor.store') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    <div class="form-body">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                                                <label>Nomor-Nomor</label>
                                                            </div>
                                                            <div class="col-md-9 form-group">
                                                                {{ Form::textarea('nomor', old('nomor'), ['class' => 'form-control', 'placeholder' => '']) }}
                                                                @error('nomor')
                                                                    <div class="text-danger">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <div class="col-md-3">

                                                            </div>
                                                            <div class="col-md-9">
                                                                <button class="btn btn-outline-primary" type="button"
                                                                    onclick="insertTag('isi_pesan', '*', '*')">Bold</button>
                                                                <button class="btn btn-outline-primary" type="button"
                                                                    onclick="insertTag('isi_pesan', '_', '_')">Italic</button>
                                                                <button class="btn btn-outline-primary" type="button"
                                                                    onclick="insertTag('isi_pesan', '```', '```')">Monoscope</button>
                                                                <button class="btn btn-outline-primary" type="button"
                                                                    onclick="insertTag('isi_pesan', '~', '~')">Strike</button>
                                                                <button class="btn btn-outline-primary" type="button"
                                                                    onclick="insertTag('isi_pesan', '~', '~')">Strike</button>
                                                                <button type="button"
                                                                    class="emojipick btn btn-outline-primary">Emoji</button>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                                                <label>Isi Pesan</label>
                                                            </div>
                                                            <div class="col-md-9 form-group">
                                                                {{ Form::textarea('isi_pesan', old('isi_pesan'), ['class' => 'form-control one', 'id' => 'isi_pesan']) }}
                                                                @error('isi_pesan')
                                                                    <div class="text-danger">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 text-sm-start text-md-end pt-2">
                                                                <label>File</label>
                                                            </div>
                                                            <div class="col-md-9 form-group">
                                                                {{ Form::file('file', ['class' => 'form-control', 'placeholder' => '']) }}
                                                                @error('file')
                                                                    <div class="text-danger">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="offset-md-3 ps-2">
                                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                                            &nbsp;
                                                            <a href="{{ route('pesan.index') }}"
                                                                class="btn btn-secondary">Batal</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        

                    </div>

                </div>
            </div>

        </section>
    </div>
@endsection

@section('page-js')
    <script src="https://woody180.github.io/vanilla-javascript-emoji-picker/vanillaEmojiPicker.js"></script>
@endsection

@section('inline-js')
    <script>
        new EmojiPicker({
            trigger: [{
                selector: '.emojipick',
                insertInto: ['.one'] // '.selector' can be used without array
            }],
            closeButton: true,
            //specialButtons: green
        });

        function insertTag(textareaId, openTag, closeTag) {
            var textarea = document.getElementById(textareaId);
            var startPos = textarea.selectionStart;
            var endPos = textarea.selectionEnd;
            var selectedText = textarea.value.substring(startPos, endPos);
            var newText = openTag + selectedText + closeTag;
            textarea.value = textarea.value.substring(0, startPos) + newText + textarea.value.substring(endPos, textarea
                .value.length);
            textarea.focus();
            textarea.setSelectionRange(endPos + openTag.length + closeTag.length, endPos + openTag.length + closeTag
                .length);
        }
    </script>
@endsection
