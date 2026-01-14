<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jurnal Mengajar Guru</title>
    <style>
        .border{
            border: 1px solid black;
            border-collapse: collapse;
            }
        .center{
            text-align: center;
        }
        .bold{
            font-weight: bold;
        }
    </style>
    <script type="text/javascript">
        window.print();
window.close();
    </script>
</head>
<body>
    <table class="border" width="100%">
        <tr class="border">
            <td rowspan="2" class="border" align="center"><img src="{{ asset('assets/images/logo/jumantono.png') }}" alt="" width="80px"></td>
            <td rowspan="2" class="border" align="center"><font style="font-weight: bold;">SMK NEGERI JUMANTONO</font></td>
            <td height="80%" class="border" align="right"><font style="font-weight: bold;">F-KUR.12</font></td>
        </tr>
        <tr>
            <td align="center"><font style="font-weight: bold;">JURNAL MENGAJAR</font></td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>Mata Pelajaran</td>
            <td>:</td>
            <td>{{ $detail_jadwal->mapel }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td>{{ $detail_jadwal->kelas }}</td>
        </tr>
        <tr>
            <td>Semester</td>
            <td>:</td>
            <td>{{ $detail_jadwal->semester }}</td>
        </tr>
        <tr>
            <td>Guru Mata Pelajaran</td>
            <td>:</td>
            <td>{{ $detail_jadwal->nama }}</td>
        </tr>
    </table>
    <br>
    <table width="100%" class="border">
        <tr class="border">
            <td class="border center bold">Hari/Tanggal</td>
            <td class="border center bold">Jam ke</td>
            <td class="border center bold">Uraian Materi & Kegiatan</td>
            <td class="border center bold">Catatan</td>
        </tr>
        @foreach ($jurnal as $item)
            <tr class="border">
                <td class="border">{{ \App\Helpers\Format::tanggal($item->tgl_pembelajaran) }}</td>
                <td class="border center">{{ $jam_pelajaran[$item->jam_mulai] }} - {{ $jam_pelajaran[$item->jam_selesai] }}</td>
                <td class="border">{!! $item->materi !!}</td>
                <td class="border">{!! $item->catatan !!}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>