<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi SKL</title>
</head>

<body>
    <table border="1">
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama</th>
            <th rowspan="2">NISN</th>
            <th rowspan="2">Kelas</th>
            @foreach ($mapel as $item_mapel)
                <th colspan="6">{{ $item_mapel->mapel }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($mapel as $item_mapel)
                @foreach ($semester->sortBy('urutan') as $item_semester)
                    <th>{{ $item_semester->semester }}</th>
                @endforeach
            @endforeach
        </tr>
        @php
            $no = 1;
            // dd($semester->sortBy('urutan'));
        @endphp
        @foreach ($siswa as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->nama_siswa }}</td>
                <td>{{ $item->nisn }}</td>
                <td>{{ $item->kelas }}</td>
                @foreach ($mapel as $item_mapel)
                    @foreach ($semester->sortBy('urutan') as $item_semester)
                        @php
                            $nilai_mapel = $nilai
                                ->where('id_semester', $item_semester->id)
                                ->where('id_siswa', $item->id_siswa)
                                ->where('id_mapel', $item_mapel->id)
                                ->first();
                            // dd($nilai_mapel);
                        @endphp
                        @if ($nilai_mapel)
                            <td>{{ $nilai_mapel->nilai }}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </table>
</body>

</html>
