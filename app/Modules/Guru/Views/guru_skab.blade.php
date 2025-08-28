<html>
    <head>
        <title>Download SKAB</title>
        <style>
            .center{
                text-align: center;
            }
            hr.atas{
                border-top: 3px solid black;
            }
            hr.bawah{
                border_top: 1px solid black;
                margin-top: -8px;
            }
            .bold{
                font-weight: bold;
            }
            .underline{
                text-decoration: underline;
            }
            .page_break { 
                page-break-before: always; 
            }
        </style>
    </head>
    <body>
        @foreach ($guru as $item)
            <table width="100%">
                <tr>
                    <td><img src="{{ asset('assets/images/logo/logo_jateng_bw.png') }}" alt="" width="100px"></td>
                    <td class="center"><font style="font-weight: bold; font-size: 12pt;">PEMERINTAH PROVINSI JAWA TENGAH</font><br>
                        <font style="font-weight: bold; font-size: 12pt;">DINAS PENDIDIKAN DAN KEBUDAYAAN</font><br>
                        <font style="font-weight: bold; font-size: 14pt;">SEKOLAH MENENGAH KEJURUAN NEGERI 2 SEMARANG</font><br>
                        <font style="font-size: 10pt;">Jalan Dr. Cipto Nomor 121-A, Semarang 50124; Telepon (024) 8455757</font><br>
                        <font style="font-size: 10pt;">Posel: smeansa_smg@yahoo.co.id atau smkn2kotasemarang@gmail.com</font>
                    </td>
                </tr>
            </table>
            <hr class="atas">
            <hr class="bawah">

            <table width="100%">
                <tr>
                    <td class="center bold underline"><font style="font-size: 12pt;">SURAT KETERANGAN AKTIF BEKERJA</font></td>
                </tr>
                <tr>
                    <td class="center"><font style="font-size: 14pt;">Nomor: 227.2 / 800 / VII / 2023</font></td>
                </tr>
            </table>

            <br>

            
            <table>
                <tr>
                    <td colspan="4">Yang bertandatangan dibawah ini:</td>
                </tr>
                <tr>
                    <td width="50pt;"></td>
                    <td>Nama</td>
                    <td>:</td>
                    <td>Sri Suwarno, S.Pd., M.Pd.</td>
                </tr>
                <tr>
                    <td width="50pt;"></td>
                    <td>NIP</td>
                    <td>:</td>
                    <td>19700611 199702 1 003</td>
                </tr>
                <tr>
                    <td width="50pt;"></td>
                    <td>Pangkat / Golongan</td>
                    <td>:</td>
                    <td>PembinaTk I / IV B</td>
                </tr>
                <tr>
                    <td width="50pt;"></td>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Kepala Sekolah</td>
                </tr>
                <tr>
                    <td width="50pt;"></td>
                    <td>Unit Kerja</td>
                    <td>:</td>
                    <td>SMK Negeri 2 Semarang</td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td colspan="4">Menerangkan dengan sesungguhnya bahwa:</td>
                </tr>
                <tr>
                    <td width="50pt;"></td>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $item->nama }}</td>
                </tr>
                <tr>
                    <td width="50pt;"></td>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ \App\Helpers\Format::konversi_nip($item->nip) }}</td>
                </tr>
                <tr>
                    <td width="50pt;"></td>
                    <td>Pangkat / Golongan</td>
                    <td>:</td>
                    <td>
                        @if ($item->golongan == 'IX')
                            {{ $item->golongan }}
                        @else
                            {{ $item->pangkat }} / {{ $item->golongan }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: justify;">Yang bersangkutan benar-benar aktif bekerja di SMK Negeri 2 Semarang sebagai Guru Mata Pelajaran {{ $item->mapel }} terhitung mulai tanggal {{ \App\Helpers\Format::tanggal($item->tmt_cpns) }} hingga sekarang. </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td colspan="4">Demikian surat keterangan ini agar dapat dipergunakan sebagaimana mestinya.</td>
                </tr>
            </table>

            <br><br><br>

            <table>
                <tr>
                    <td width="65%"></td>
                    <td>Semarang, 6 Juli 2023</td>
                </tr>
                <tr>
                    <td width="65%"></td>
                    <td>Kepala SMK Negeri 2 Semarang</td>
                </tr>
                <tr>
                    <td>
                        <br><br>
                    </td>
                </tr>
                <tr>
                    <td width="65%"></td>
                    <td><font style="font-weight: bold;">Sri Suwarno, S.Pd., M.Pd.</font></td>
                </tr>
                <tr>
                    <td width="65%"></td>
                    <td><font>19700611 199702 1 003</font></td>
                </tr>
            </table>

            <div class="page_break"></div>

        @endforeach
        
    </body>
</html>