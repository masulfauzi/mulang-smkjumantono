<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .page_break {
            page-break-before: always;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    @foreach ($data as $guru_cetak)
        <h2>{{ $guru_cetak->nama }}</h2>
        @php
            $data_jam_mengajar = App\Modules\JamMengajar\Models\JamMengajar::whereIdGuru($guru_cetak->id_guru)
                ->whereIdSemester($id_semester)
                ->OrderBy('id_kelas')
                ->get();
        @endphp

        <table class="table">
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Jml Jam</th>
            </tr>
            @php
                $no = 1;
                $tmp_jam = 0;
            @endphp
            @foreach ($data_jam_mengajar as $item_jam)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item_jam->kelas->kelas }}</td>
                    <td>{{ $item_jam->mapel->mapel }}</td>
                    <td>{{ $item_jam->jml_jam }}</td>
                </tr>
                @php
                    $tmp_jam += $item_jam->jml_jam;
                @endphp
            @endforeach


            <tr>
                <th colspan="3">Total Jam Mengajar</th>
                <th>{{ $tmp_jam }}</th>
            </tr>
        </table>

        <div class="page_break"></div>
    @endforeach

</body>

</html>
