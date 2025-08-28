@php
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=daftar-hadir_kelas.xls");  //File name extension was wrong
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Daftar Hadir Siswa</title>
    <style>
        .vertical {
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }
    </style>
</head>
<body>

    <table>
        <tr>
            <td></td>
            <td>Mata Pelajaran</td>
            <td>:</td>
            <td colspan="50">{{ $jadwal->mapel }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Kelas</td>
            <td>:</td>
            <td colspan="50">{{ $jadwal->kelas }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Semester</td>
            <td>:</td>
            <td colspan="50">{{ $jadwal->semester }}</td>
        </tr>
    </table>

    <table border="1">
        <tr>
            <td rowspan="3">No</td>
            <td rowspan="3">Nama</td>
            <td colspan="{{ count($jurnal) }}">Pertemuan Ke</td>
            <td colspan="3" rowspan="2">Jumlah</td>
        </tr>
        <tr>
            @for ($i = 1; $i <= count($jurnal); $i++)
                <td>{{ $i }}</td>
            @endfor
        </tr>
        <tr>
            @foreach ($jurnal as $jn)
                <td class="vertical">{{ $jn->tgl_pembelajaran }}</td>
            @endforeach
            <td>S</td>
            <td>I</td>
            <td>A</td>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($siswa as $pd)
            @php
                $s = 0;
                $i = 0;
                $a = 0;
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ strtoupper($pd->nama_siswa) }}</td>
                @foreach ($jurnal as $jn)
                    @php
                        $id_status = $presensi->where('id_pesertadidik', $pd->id)->where('id_jurnal', $jn->id)->first()->id_statuskehadiran;
                        $kehadiran = $status_kehadiran->where('id', $id_status)->first()->status_kehadiran_pendek;

                        if($kehadiran == 'H')
                        {

                        }
                        else if($kehadiran == 'S')
                        {
                            $s++;
                        }
                        else if($kehadiran == 'I')
                        {
                            $i++;
                        }
                        else if($kehadiran == 'A')
                        {
                            $a++;
                        }
                    @endphp

                    <td>{{ $kehadiran }}</td>
                @endforeach
                <td>{{ $s }}</td>
                <td>{{ $i }}</td>
                <td>{{ $a }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>