<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lihat Soal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <table class="table">
                @foreach ($soal as $item)
                    <tr>
                        <td rowspan="4" width="20px;">{{ $item->no_soal }}</td>
                        <td colspan="6">
                            @if ($item->gambar)
                                <img src="{{ asset('/ujian/soal/'. $item->gambar) }}" alt="Gambar Soal" width="100%;">
                            @endif
                            {!! $item->soal !!}
                        </td>
                    </tr>
                    <tr>
                        <td>A.</td>
                        <td>@if ($item->gambar_a)
                            <img src="{{ asset('/ujian/jawaban/'. $item->gambar_a) }}" alt="Gambar Jawaban A" width="300px;"> <br>
                        @endif
                        {!! $item->opsi_a !!}</td>
                        <td>C.</td>
                        <td>@if ($item->gambar_c)
                            <img src="{{ asset('/ujian/jawaban/'. $item->gambar_c) }}" alt="Gambar Jawaban C" width="300px;"> <br>
                        @endif
                        {!! $item->opsi_c !!}</td>
                        <td>E.</td>
                        <td>@if ($item->gambar_e)
                            <img src="{{ asset('/ujian/jawaban/'. $item->gambar_e) }}" alt="Gambar Jawaban E" width="300px;"> <br>
                        @endif
                        {!! $item->opsi_e !!}</td>
                    </tr>
                    <tr>
                        <td>B.</td>
                        <td>@if ($item->gambar_b)
                            <img src="{{ asset('/ujian/jawaban/'. $item->gambar_b) }}" alt="Gambar Jawaban B" width="300px;"> <br>
                        @endif
                        {!! $item->opsi_b !!}</td>
                        <td>D.</td>
                        <td>@if ($item->gambar_d)
                            <img src="{{ asset('/ujian/jawaban/'. $item->gambar_d) }}" alt="Gambar Jawaban D" width="300px;"> <br>
                        @endif
                        {!! $item->opsi_d !!}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Kunci: {{ $item->kunci }}</td>
                    </tr>
                @endforeach
                
            </table>
        </div>
    </div>
    
</body>
</html>