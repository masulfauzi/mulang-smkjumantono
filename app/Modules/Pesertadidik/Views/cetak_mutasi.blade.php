<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Halaman Mutasi</title>
    <style>
        body {
            font-family: Calibri;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .border {
            border-left: 0.01em solid #000000;
            border-right: 0;
            border-top: 0.01em solid #000000;
            border-bottom: 0;
            border-collapse: collapse;

        }

        .border td {
            border-left: 0;
            border-right: 0.01em solid #000000;
            border-top: 0;
            border-bottom: 0.01em solid #000000;
            padding: 5px;
        }

        .page_break {
            page-break-before: always;
        }

        .underline {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    @foreach ($data as $item)
        <p class="center bold">KETERANGAN PINDAH SEKOLAH</p>

        <table width="100%">
            <tr>
                <td width="5%"></td>
                <td width="23%">Nama Peserta Didik</td>
                <td width="2%">:</td>
                <td>{{ strtoupper($item->nama_siswa) }}</td>
            </tr>
        </table>

        <table class="border" width="100%">
            <tr>
                <td colspan="4" class="center bold">KELUAR</td>
            </tr>
            <tr>
                <td class="center bold">Tanggal</td>
                <td class="bold">Kelas yang ditinggalkan</td>
                <td class="bold">Sebab-sebab Keluar atau Atas Permintaan (Tertulis)</td>
                <td class="bold">Tanda Tangan Kepala Sekolah, Stempel Sekolah, dan Tanda Tangan Orang Tua/Wali</td>
            </tr>
            <tr>
                <td class="center">6 Mei 2025</td>
                <td class="center">{{ $item->kelas }}</td>
                <td class="center">LULUS</td>
                <td>
                    Semarang, 6 Mei 2025
                    <br>
                    Kepala Sekolah
                    <br>
                    <br>
                    <br>
                    Sri Suwarno, S.Pd., M.Pd.
                    <br>
                    NIP. 19700611 199702 1 003
                    <br>
                    <br>
                    Orang Tua/Wali
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td></td>
                <td></td>
                <td>
                    .........., ........................................
                    <br>
                    Kepala Sekolah,
                    <br>
                    <br>
                    <br>

                    <br>
                    NIP.
                    <br>
                    <br>
                    Orang Tua/Wali
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td></td>
                <td></td>
                <td>
                    .........., ........................................
                    <br>
                    Kepala Sekolah,
                    <br>
                    <br>
                    <br>

                    <br>
                    NIP.
                    <br>
                    <br>
                    Orang Tua/Wali
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td></td>
                <td></td>
                <td>
                    .........., ........................................
                    <br>
                    Kepala Sekolah,
                    <br>
                    <br>
                    <br>

                    <br>
                    NIP.
                    <br>
                    <br>
                    Orang Tua/Wali
                    <br>
                    <br>
                    <br>
                </td>
            </tr>
        </table>
        <div class="page_break"></div>
    @endforeach
</body>

</html>
