<?php
namespace App\Modules\Jurnal\Controllers;

use App\Helpers\Logger;
use App\Http\Controllers\Controller;
use App\Modules\Guru\Models\Guru;
use App\Modules\Hari\Models\Hari;
use App\Modules\Jadwal\Models\Jadwal;
use App\Modules\Jampelajaran\Models\Jampelajaran;
use App\Modules\Jurnal\Models\Jurnal;
use App\Modules\Kelas\Models\Kelas;
use App\Modules\Log\Models\Log;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use App\Modules\Presensi\Models\Presensi;
use App\Modules\Statuskehadiran\Models\Statuskehadiran;
use Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// use PhpOffice\PhpSpreadsheet\Shared\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JurnalController extends Controller
{
    use Logger;
    protected $log;
    protected $title = "Jurnal";

    public function __construct(Log $log)
    {
        $this->log = $log;
    }

    public function index(Request $request)
    {
        if (session('active_role')['id'] == '9ec7541e-5a5e-4a3a-a255-6ffb46895f46') {
            return redirect(route('jurnal.guru.index'));
        }

        if ($request->input('bulan') == null) {
            $data['bulan'] = date('m');
        } else {
            $data['bulan'] = $request->input('bulan');
        }

        if ($request->input('tahun') == null) {
            $data['tahun'] = date('Y');
        } else {
            $data['tahun'] = $request->input('tahun');
        }

        $data['guru'] = Guru::query()->whereIsAktif('1')->orderBy('nama')->get();

        $cari           = $data['tahun'] . "-" . $data['bulan'];
        $data['jurnal'] = Jurnal::query()
            ->join('jadwal', 'jadwal.id', '=', 'jurnal.id_jadwal')
            ->where('tgl_pembelajaran', 'like', "%$cari%")
            ->get();

        // dd($data['jurnal']);

        $this->log($request, 'melihat halaman monitoring jurnal ' . $this->title);
        return view('Jurnal::jurnal', array_merge($data, ['title' => $this->title]));
    }

    public function index_guru(Request $request)
    {
        $query        = Jurnal::where('id_guru', session('id_guru'));
        $data['data'] = $query->paginate(20)->withQueryString();

        $this->log($request, 'melihat halaman manajemen data ' . $this->title);
        return view('Jurnal::jurnal_guru', array_merge($data, ['title' => $this->title]));
    }

    public function detail_jurnal(Request $request, Jurnal $jurnal)
    {
        $data_jurnal = $jurnal;

        $data['siswa']  = Presensi::get_presensi_by_idjurnal($data_jurnal->id);
        $data['jurnal'] = $data_jurnal;

        $this->log($request, 'melihat halaman presensi jurnal');
        return view('Jurnal::detail_jurnal', array_merge($data, ['title' => $this->title]));
    }

    public function create(Request $request)
    {
        // $cek_jurnal = Jurnal::get_jurnal_by_idjadwal_and_date($request->get('id_jadwal'), date('Y-m-d'));

        // if ($cek_jurnal) {
        // 	return redirect()->route('presensi.jurnal.index', $cek_jurnal->id)->with('message_success', 'Jurnal berhasil disimpan!');
        // }

        // $ref_jadwal = Jadwal::find($request->get('id_jadwal'));

        $ref_hari         = Hari::all()->sortBy('urutan')->pluck('hari', 'id');
        $ref_kelas        = Kelas::all()->pluck('kelas', 'id');
        $ref_jampelajaran = Jampelajaran::all()->sortBy('jam_pelajaran')->pluck('jam_pelajaran', 'id');
        $ref_mapel        = Mapel::all()->sortBy('mapel')->pluck('mapel', 'id');

        $ref_hari->prepend('-PILIH HARI-', '');
        $ref_kelas->prepend('-PILIH KELAS-', '');
        $ref_jampelajaran->prepend('-PILIH JAM PELAJARAN-', '');
        $ref_mapel->prepend('-PILIH MATA PELAJARAN-', '');

        $data['forms'] = [
            // 'id_jadwal' => ['', Form::hidden("id_jadwal", $ref_jadwal->id, ["class" => "form-control"])],
            // 'jadwal'           => ['Jadwal', Form::text("jadwal", $ref_jadwal->mapel['mapel'], ["class" => "form-control", "disabled" => "disabled"])],
            'id_hari'          => ['Hari', Form::select("id_hari", $ref_hari, null, ["class" => "form-control select2", "required" => "required"])],
            'id_kelas'         => ['Kelas', Form::select("id_kelas", $ref_kelas, null, ["class" => "form-control select2", "required" => "required"])],
            'jam_mulai'        => ['Jam Mulai', Form::select("jam_mulai", $ref_jampelajaran, null, ["class" => "form-control select2", "required" => "required"])],
            'jam_selesai'      => ['Jam Selesai', Form::select("jam_selesai", $ref_jampelajaran, null, ["class" => "form-control select2", "required" => "required"])],
            'id_mapel'         => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2", "required" => "required"])],
            'tgl_pembelajaran' => ['Tanggal Pembelajaran', Form::date("tgl_pembelajaran", date('Y-m-d'), ["class" => "form-control", "required" => "required"])],
            'materi'           => ['Materi', Form::textarea("materi", old("materi"), ["class" => "form-control rich-editor"])],
            'catatan'          => ['Catatan', Form::textarea("catatan", old("catatan"), ["class" => "form-control rich-editor"])],
            'id_semester'      => ['', Form::hidden("id_semester", get_semester('active_semester_id'))],
            'id_guru'          => ['', Form::hidden("id_guru", session('id_guru'))],

        ];

        $this->log($request, 'membuka form tambah ' . $this->title);
        return view('Jurnal::jurnal_create', array_merge($data, ['title' => $this->title]));
    }

    public function cetak_jurnal(Request $request)
    {
        $mapel = Jurnal::get_mapel_guru(session('id_guru'), get_semester('active_semester_id'))->pluck('mapel', 'id');
        $kelas = Jurnal::get_kelas_guru(session('id_guru'), get_semester('active_semester_id'))->pluck('kelas', 'id');
        $mapel->prepend('-PILIH SALAH SATU-', '');
        $kelas->prepend('-PILIH SALAH SATU-', '');

        $data['mapel'] = $mapel;
        $data['kelas'] = $kelas;

        return view('Jurnal::cetak', $data);
    }

    public function aksi_cetak_presensi(Request $request)
    {
        $jadwals = Jadwal::get_jadwal_by_kelas_mapel($request->input('id_kelas'), $request->input('id_mapel'), get_semester('active_semester_id'));
        $jadwal  = $jadwals->first();
        // dd($jadwal);
        $siswa            = Pesertadidik::get_pd_by_idkelas($request->input('id_kelas'), get_semester('active_semester_id'));
        $status_kehadiran = Statuskehadiran::get();

        $id_jadwal = [];
        foreach ($jadwals as $jw) {
            array_push($id_jadwal, $jw->id_jadwal);
        }

        // $pertemuan = $jadwals->pluck('id_jadwal', '');
        // dd($pertemuan);

        $pertemuan = Jurnal::query()->whereIn('id_jadwal', $id_jadwal)->orderBy('tgl_pembelajaran')->get();

        // dd($pertemuan);

        // //buat array jurnal
        $id_jurnal = [];
        foreach ($pertemuan as $jn) {
            array_push($id_jurnal, $jn->id);
        }

        $presensi = Presensi::query()->whereIn('id_jurnal', $id_jurnal)->get();

        $spreadsheet = new Spreadsheet();
        $styleArray  = [
            'font' => [
                'name' => 'Times New Roman',
            ],
        ];
        $spreadsheet->getDefaultStyle()->applyFromArray($styleArray);

        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->mergeCells('B1:B5');
        $activeWorksheet->mergeCells('C1:L5');
        $activeWorksheet->getCell('C1')->setValue('SMK NEGERI JUMANTONO');
        $activeWorksheet->getStyle('C1')->getAlignment()->setHorizontal('center')->setVertical('center')->setWrapText(true);
        $activeWorksheet->getStyle("C1")->getFont()->setSize(16)->setBold(true);

        // $image = file_get_contents('https://upload.wikimedia.org/wikipedia/commons/b/b2/jumantono.png');
        // $imageName = 'logo';

        //You can save the image wherever you want
        //I would highly recommand using a temporary directory
        // $temp_image=tempnam(sys_get_temp_dir(), $imageName);
        // file_put_contents($temp_image, $image);

        // And then PhpSpreadsheet acts just like it would do with a local image
        $drawing = new Drawing();
        $drawing->setPath('assets/images/logo/jumantono.png');
        $drawing->setHeight(100);
        $drawing->setWorksheet($activeWorksheet);
        $drawing->setCoordinates('B1');
        $drawing->setOffsetX(100); // this is how
                                   // $drawing->setOffsetY(3);    // this is how

        $activeWorksheet->mergeCells('M1:U1');
        $activeWorksheet->getCell('M1')->setValue('F KUR-15');
        $activeWorksheet->getStyle('M1')->getAlignment()->setHorizontal('right')->setVertical('center');
        $activeWorksheet->getStyle("M1")->getFont()->setSize(12)->setBold(true);

        $activeWorksheet->mergeCells('M2:U5');
        $activeWorksheet->getCell('M2')->setValue('DAFTAR HADIR');
        $activeWorksheet->getStyle('M2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $activeWorksheet->getStyle("M2")->getFont()->setSize(16)->setBold(true);

        $activeWorksheet->getCell('B7')->setValue('Mata Pelajaran');
        $activeWorksheet->getCell('C7')->setValue(':');
        $activeWorksheet->mergeCells('D7:U7');
        $activeWorksheet->getCell('D7')->setValue($jadwal->mapel);

        $activeWorksheet->getCell('B8')->setValue('Kelas');
        $activeWorksheet->getCell('C8')->setValue(':');
        $activeWorksheet->mergeCells('D8:U8');
        $activeWorksheet->getCell('D8')->setValue($jadwal->kelas);

        $activeWorksheet->getCell('B9')->setValue('Semester');
        $activeWorksheet->getCell('C9')->setValue(':');
        $activeWorksheet->mergeCells('D9:U9');
        $activeWorksheet->getCell('D9')->setValue($jadwal->semester);

        $activeWorksheet->getCell('B10')->setValue('Guru Pengampu');
        $activeWorksheet->getCell('C10')->setValue(':');
        $activeWorksheet->mergeCells('D10:U10');
        $activeWorksheet->getCell('D10')->setValue($jadwal->nama);

        // mulai tabel
        $activeWorksheet->mergeCells('A12:A15');
        $activeWorksheet->getCell('A12')->setValue('NO');
        $activeWorksheet->getStyle('A12')->getAlignment()->setHorizontal('center')->setVertical('center');
        $activeWorksheet->getStyle("A12")->getFont()->setSize(12)->setBold(true);

        $row           = 16;
        $no            = 1;
        $min_pertemuan = 16;
        foreach ($siswa as $sis) {

            $activeWorksheet->getCell('A' . $row)->setValue($no);
            $activeWorksheet->getCell('B' . $row)->setValue(strtoupper($sis->nama_siswa));

            $sakit = 0;
            $ijin  = 0;
            $alfa  = 0;
            $kolom = 'C';

            // dd(count($pertemuan));

            foreach ($pertemuan as $jurnal) {

                // $status = $presensi->where('id_pesertadidik', $sis->id)->where('id_jurnal', $jurnal->id)->first()->;

                // dd($id_status);
                $status = $presensi->where('id_pesertadidik', $sis->id)->where('id_jurnal', $jurnal->id)->first();
                if ($status) {
                    $id_status = $status->id_statuskehadiran;
                } else {
                    echo "ID Jurnal: " . $jurnal->id;
                    echo "<br>";
                    echo "Jadwal dengan ID: " . $jurnal->id_jadwal . " Tidak singkron. silahkan ubah kelas.";
                    die();
                }

                $kehadiran = $status_kehadiran->where('id', $id_status)->first()->status_kehadiran_pendek;

                if ($kehadiran == 'H') {

                } else if ($kehadiran == 'S') {
                    $sakit++;
                } else if ($kehadiran == 'I') {
                    $ijin++;
                } else if ($kehadiran == 'A') {
                    $alfa++;
                }

                $activeWorksheet->getCell($kolom . $row)->setValue($kehadiran);

                $kolom++;

            }

            if (count($pertemuan) < $min_pertemuan) {
                $kurang = $min_pertemuan - count($pertemuan);
            } else {
                $kurang = 0;
            }

            for ($i = 1; $i <= $kurang; $i++) {
                $kolom++;
            }

            $activeWorksheet->getCell($kolom . $row)->setValue($sakit);
            $kolom++;
            $activeWorksheet->getCell($kolom . $row)->setValue($ijin);
            $kolom++;
            $activeWorksheet->getCell($kolom . $row)->setValue($alfa);
            $kolom++;

            $row++;
            $no++;
        }

        $activeWorksheet->mergeCells('B12:B15');
        $activeWorksheet->getCell('B12')->setValue('NAMA PESERTA DIDIK');
        $activeWorksheet->getStyle('B12')->getAlignment()->setHorizontal('center')->setVertical('center');
        $activeWorksheet->getStyle("B12")->getFont()->setSize(12)->setBold(true);

        //mulai presensi
        $kolom = 'B';
        $no    = 1;

        foreach ($pertemuan as $pert) {
            $kolom++;
            $activeWorksheet->getCell($kolom . '13')->setValue($no);
            $activeWorksheet->getCell($kolom . '14')->setValue($pert->tgl_pembelajaran);
            $activeWorksheet->getStyle($kolom . '14')->getAlignment()->setTextRotation(90);
            $no++;
        }

        if (count($pertemuan) < $min_pertemuan) {
            $kurang = $min_pertemuan - count($pertemuan);
        }

        for ($i = 1; $i <= $kurang; $i++) {
            $kolom++;
            $activeWorksheet->getCell($kolom . '13')->setValue($no);
            $no++;
        }

        $activeWorksheet->mergeCells('C12:' . $kolom . '12');
        $activeWorksheet->getCell('C12')->setValue('PERTEMUAN KE-');
        $activeWorksheet->getStyle('C12')->getAlignment()->setHorizontal('center')->setVertical('center');

        // for($i = 1; $i <= 3; $i++)
        // {
        // 	$kolom ++;
        // 	$activeWorksheet->getCell($kolom.'15')->setValue($no);
        // 	$no++;
        // }

        $kolom_jumlah = $kolom;
        $kolom++;

        for ($i = 1; $i <= 3; $i++) {
            $kolom_jumlah++;
            if ($i == 1) {
                $activeWorksheet->getCell($kolom_jumlah . '15')->setValue('S');
            } else if ($i == 2) {
                $activeWorksheet->getCell($kolom_jumlah . '15')->setValue('I');
            } else {
                $activeWorksheet->getCell($kolom_jumlah . '15')->setValue('A');
            }

        }

        // dd($kolom_jumlah);

        $activeWorksheet->mergeCells($kolom . '12:' . $kolom_jumlah . '14');
        $activeWorksheet->getCell($kolom . '12')->setValue('JUMLAH');
        $activeWorksheet->getStyle($kolom . '12')->getAlignment()->setHorizontal('center')->setVertical('center');
        $kolom_jumlah++;
        $activeWorksheet->getCell($kolom_jumlah . '12')->setValue('');
        $kolom++;
        $kolom++;
        $row--;

        // dd($kolom);

        $activeWorksheet->getStyle('B1:U5')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);
        $activeWorksheet->getStyle('A12:' . $kolom . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_MEDIUM);

        for ($i = 'A'; $i != $activeWorksheet->getHighestColumn(); $i++) {
            $activeWorksheet->getColumnDimension($i)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode('Daftar_hadir-' . $jadwal->kelas . '-' . $jadwal->mapel . '.xlsx') . '"');
        $writer->save('php://output');

    }

    public function aksi_cetak_presensi2(Request $request)
    {
        $jadwals        = Jadwal::get_jadwal_by_kelas_mapel($request->input('id_kelas'), $request->input('id_mapel'), get_semester('active_semester_id'));
        $data['jadwal'] = $jadwals->first();
        // dd($data['jadwal']);
        // $data['siswa']	= Pesertadidik::query()->where('id_kelas', $request->input('id_kelas'))->where('id_semester',get_semester('active_semester_id'))->get();
        $data['siswa']            = Pesertadidik::get_pd_by_idkelas($request->input('id_kelas'), get_semester('active_semester_id'));
        $data['status_kehadiran'] = Statuskehadiran::get();
        // dd($data['status_kehadiran']);

        //buat array jadwal
        $jadwal = [];
        foreach ($jadwals as $jw) {
            array_push($jadwal, $jw->id_jadwal);
        }

        $data['jurnal'] = Jurnal::query()->whereIn('id_jadwal', $jadwal)->orderBy('tgl_pembelajaran')->get();

        //buat array jurnal
        $jurnal = [];
        foreach ($data['jurnal'] as $jn) {
            array_push($jurnal, $jn->id);
        }

        $data['presensi'] = Presensi::query()->whereIn('id_jurnal', $jurnal)->get();

        return view('Jurnal::cetak_presensi', $data);

    }

    public function cetak_jurnalmengajar(Request $request)
    {
        $data['jadwal']        = Jadwal::get_jadwal_by_kelas_mapel($request->input('id_kelas'), $request->input('id_mapel'), get_semester('active_semester_id'));
        $data['detail_jadwal'] = $data['jadwal']->first();
        $id_jadwal             = $data['jadwal']->pluck('id_jadwal')->toArray();

        $data['jurnal'] = Jurnal::get_jurnal($id_jadwal);

        return view('Jurnal::jurnal_mengajar', $data);

        // $pdf = PDF::loadview('Jurnal::jurnal_mengajar',$data);
        // return $pdf->download('BiodataPesertaUjian');

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'id_jadwal'        => 'required',
            'materi'           => 'required',
            'tgl_pembelajaran' => 'required',
            'id_hari'          => 'required',
            'id_kelas'         => 'required',
            'jam_mulai'        => 'required',
            'jam_selesai'      => 'required',
            'id_mapel'         => 'required',
            'id_guru'          => 'required',

        ]);

        // dd($request);

        $jurnal = new Jurnal();
        // $jurnal->id_jadwal        = $request->input("id_jadwal");
        $jurnal->materi           = $request->input("materi");
        $jurnal->tgl_pembelajaran = $request->input("tgl_pembelajaran");
        $jurnal->catatan          = $request->input("catatan");
        $jurnal->id_hari          = $request->input("id_hari");
        $jurnal->id_kelas         = $request->input("id_kelas");
        $jurnal->jam_mulai        = $request->input("jam_mulai");
        $jurnal->jam_selesai      = $request->input("jam_selesai");
        $jurnal->id_mapel         = $request->input("id_mapel");
        $jurnal->id_semester      = $request->input("id_semester");
        $jurnal->id_guru          = $request->input("id_guru");
        $jurnal->created_by       = Auth::id();
        $jurnal->save();

        $text = 'membuat ' . $this->title; //' baru '.$jurnal->what;
        $this->log($request, $text, ['jurnal.id' => $jurnal->id]);
        // return redirect()->route('jurnal.index')->with('message_success', 'Jurnal berhasil ditambahkan!');
        return redirect()->route('presensi.jurnal.index', $jurnal->id)->with('message_success', 'Jurnal berhasil disimpan!');
    }

    public function show(Request $request, Jurnal $jurnal)
    {
        $data['jurnal'] = $jurnal;

        $text = 'melihat detail ' . $this->title; //.' '.$jurnal->what;
        $this->log($request, $text, ['jurnal.id' => $jurnal->id]);
        return view('Jurnal::jurnal_detail', array_merge($data, ['title' => $this->title]));
    }

    public function edit(Request $request, Jurnal $jurnal)
    {
        $data['jurnal'] = $jurnal;

        $ref_jadwal = Jadwal::find($jurnal->id_jadwal);

        $data['forms'] = [
            'id_jadwal'        => ['Jadwal', Form::text("id_jadwal", $ref_jadwal->mapel['mapel'], ["class" => "form-control", "disabled"])],
            'materi'           => ['Materi', Form::textarea("materi", $jurnal->materi, ["class" => "form-control rich-editor"])],
            'tgl_pembelajaran' => ['Tgl Pembelajaran', Form::date("tgl_pembelajaran", $jurnal->tgl_pembelajaran, ["class" => "form-control", "id" => "tgl_pembelajaran"])],
            'catatan'          => ['Catatan', Form::textarea("catatan", $jurnal->catatan, ["class" => "form-control rich-editor"])],

        ];

        $text = 'membuka form edit ' . $this->title; //.' '.$jurnal->what;
        $this->log($request, $text, ['jurnal.id' => $jurnal->id]);
        return view('Jurnal::jurnal_update', array_merge($data, ['title' => $this->title]));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'materi'           => 'required',
            'tgl_pembelajaran' => 'required',

        ]);

        $jurnal                   = Jurnal::find($id);
        $jurnal->materi           = $request->input("materi");
        $jurnal->tgl_pembelajaran = $request->input("tgl_pembelajaran");
        $jurnal->catatan          = $request->input("catatan");

        $jurnal->updated_by = Auth::id();
        $jurnal->save();

        $text = 'mengedit ' . $this->title; //.' '.$jurnal->what;
        $this->log($request, $text, ['jurnal.id' => $jurnal->id]);
        return redirect()->route('jurnal.index')->with('message_success', 'Jurnal berhasil diubah!');
    }

    public function destroy(Request $request, $id)
    {
        $jurnal             = Jurnal::find($id);
        $jurnal->deleted_by = Auth::id();
        $jurnal->save();
        $jurnal->delete();

        $text = 'menghapus ' . $this->title; //.' '.$jurnal->what;
        $this->log($request, $text, ['jurnal.id' => $jurnal->id]);
        return back()->with('message_success', 'Jurnal berhasil dihapus!');
    }

}
