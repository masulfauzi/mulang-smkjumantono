<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table border="1">
        <tr>
            <td rowspan="2">Nama</td>
            <td rowspan="2">Mapel</td>
            @foreach ($tingkat as $item_tingkat)
                <td colspan="12">{{ $item_tingkat->tingkat }}</td>
            @endforeach
        </tr>
        <tr>
            @foreach ($kelas as $item_kelas)
                <td>{{ $item_kelas->kelas }}</td>
            @endforeach
        </tr>
        @foreach ($guru as $teacher)
            <tr>
                <td>{{ $teacher->nama }}</td>
                <td>{{ $teacher->mapel }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>