<?php
namespace App\Modules\Presensi\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Presensi\Models\Presensi;
use App\Modules\Jurnal\Models\Jurnal;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use App\Modules\Statuskehadiran\Models\Statuskehadiran;

use App\Http\Controllers\Controller;
use App\Modules\Kelas\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class PresensiController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Presensi";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Presensi::query();
		if ($request->has('search')) {
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Presensi::presensi', array_merge($data, ['title' => $this->title]));
	}

	public function presensi_jurnal(Request $request, $id_jurnal)
	{
		$data_jurnal = Jurnal::get_detail_jurnal($id_jurnal);

		// dd($data_jurnal);

		//cek tabel presensi
		$data_siswa = Presensi::get_presensi_by_idjurnal($data_jurnal->id);
		// dd($data_siswa);

		if ($data_siswa->count() == 0) {
			//dd("sampe sini");

			$this->insert_presensi_by_idkelas($data_jurnal->id_kelas, $data_jurnal->id, get_semester('active_semester_id'));
		}

		$data['siswa'] = Presensi::get_presensi_by_idjurnal($data_jurnal->id);
		$data['jurnal'] = $data_jurnal;

		$this->log($request, 'melihat halaman presensi jurnal');
		return view('Presensi::presensi_jurnal', array_merge($data, ['title' => $this->title]));
	}

	public function presensi_jurnal_store(Request $request)
	{
		// dd($request->all());
		for ($i = 1; $i <= count($request->get('id')); $i++) {
			$data_presensi = [
				'id' => $request->get('id')[$i],
				'id_statuskehadiran' => $request->get('id_statuskehadiran')[$i],
				'catatan' => $request->get('catatan')[$i]
			];

			Presensi::update_presensi($data_presensi);
		}

		return redirect()->route('presensi.jurnal.index', $request->get('id_jurnal'))->with('message_success', 'Presensi berhasil disimpan!');
	}

	public function insert_presensi_by_idkelas($id_kelas, $id_jurnal, $id_semester)
	{
		$siswa = Pesertadidik::get_pd_by_idkelas($id_kelas, $id_semester);

		// dd($siswa);

		foreach ($siswa as $data) {
			$data_presensi = [
				'id' => Str::uuid(),
				'id_jurnal' => $id_jurnal,
				'id_pesertadidik' => $data->id,
				'id_statuskehadiran' => '5cb7e9bc-79dc-4deb-8bd2-77930dbca9a3',
				'created_by' => Auth::id(),
				'created_at' => Carbon::now()->toDateTimeString()
			];

			Presensi::insert_presensi($data_presensi);
		}
	}

	public function create(Request $request)
	{
		$ref_jurnal = Jurnal::all()->pluck('id_jadwal', 'id');
		$ref_pesertadidik = Pesertadidik::all()->pluck('id_semester', 'id');
		$ref_statuskehadiran = Statuskehadiran::all()->pluck('status_kehadiran', 'id');

		$data['forms'] = array(
			'id_jurnal' => ['Jurnal', Form::select("id_jurnal", $ref_jurnal, null, ["class" => "form-control select2"])],
			'id_pesertadidik' => ['Pesertadidik', Form::select("id_pesertadidik", $ref_pesertadidik, null, ["class" => "form-control select2"])],
			'id_statuskehadiran' => ['Statuskehadiran', Form::select("id_statuskehadiran", $ref_statuskehadiran, null, ["class" => "form-control select2"])],
			'catatan' => ['Catatan', Form::text("catatan", old("catatan"), ["class" => "form-control", "placeholder" => ""])],

		);

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('Presensi::presensi_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_jurnal' => 'required',
			'id_pesertadidik' => 'required',
			'id_statuskehadiran' => 'required',
			'catatan' => 'required',

		]);

		$presensi = new Presensi();
		$presensi->id_jurnal = $request->input("id_jurnal");
		$presensi->id_pesertadidik = $request->input("id_pesertadidik");
		$presensi->id_statuskehadiran = $request->input("id_statuskehadiran");
		$presensi->catatan = $request->input("catatan");

		$presensi->created_by = Auth::id();
		$presensi->save();

		$text = 'membuat ' . $this->title; //' baru '.$presensi->what;
		$this->log($request, $text, ['presensi.id' => $presensi->id]);
		return redirect()->route('presensi.index')->with('message_success', 'Presensi berhasil ditambahkan!');
	}

	public function show(Request $request, Presensi $presensi)
	{
		$data['presensi'] = $presensi;

		$text = 'melihat detail ' . $this->title;//.' '.$presensi->what;
		$this->log($request, $text, ['presensi.id' => $presensi->id]);
		return view('Presensi::presensi_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Presensi $presensi)
	{
		$data['presensi'] = $presensi;

		$ref_jurnal = Jurnal::all()->pluck('id_jadwal', 'id');
		$ref_pesertadidik = Pesertadidik::all()->pluck('id_semester', 'id');
		$ref_statuskehadiran = Statuskehadiran::all()->pluck('status_kehadiran', 'id');

		$data['forms'] = array(
			'id_jurnal' => ['Jurnal', Form::select("id_jurnal", $ref_jurnal, null, ["class" => "form-control select2"])],
			'id_pesertadidik' => ['Pesertadidik', Form::select("id_pesertadidik", $ref_pesertadidik, null, ["class" => "form-control select2"])],
			'id_statuskehadiran' => ['Statuskehadiran', Form::select("id_statuskehadiran", $ref_statuskehadiran, null, ["class" => "form-control select2"])],
			'catatan' => ['Catatan', Form::text("catatan", $presensi->catatan, ["class" => "form-control", "placeholder" => "", "id" => "catatan"])],

		);

		$text = 'membuka form edit ' . $this->title;//.' '.$presensi->what;
		$this->log($request, $text, ['presensi.id' => $presensi->id]);
		return view('Presensi::presensi_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_jurnal' => 'required',
			'id_pesertadidik' => 'required',
			'id_statuskehadiran' => 'required',
			'catatan' => 'required',

		]);

		$presensi = Presensi::find($id);
		$presensi->id_jurnal = $request->input("id_jurnal");
		$presensi->id_pesertadidik = $request->input("id_pesertadidik");
		$presensi->id_statuskehadiran = $request->input("id_statuskehadiran");
		$presensi->catatan = $request->input("catatan");

		$presensi->updated_by = Auth::id();
		$presensi->save();


		$text = 'mengedit ' . $this->title;//.' '.$presensi->what;
		$this->log($request, $text, ['presensi.id' => $presensi->id]);
		return redirect()->route('presensi.index')->with('message_success', 'Presensi berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$presensi = Presensi::find($id);
		$presensi->deleted_by = Auth::id();
		$presensi->save();
		$presensi->delete();

		$text = 'menghapus ' . $this->title;//.' '.$presensi->what;
		$this->log($request, $text, ['presensi.id' => $presensi->id]);
		return back()->with('message_success', 'Presensi berhasil dihapus!');
	}

	public function get_siswa_kehadiran(Request $request)
	{
		$data['siswa'] = Presensi::get_kehadiran_siswa($request->id, get_semester('active_semester_id'), date('Y-m-d'));
		// dd($request);

		return view('Presensi::status_presensi', $data);
	}

	public function rekap_presensi(Request $request)
	{
		$data['kelas_terpilih'] = $request->get('id_kelas');
		$data['bulan_terpilih'] = $request->get('bulan');

		$filter_bulan = date('Y') . '-' . $request->get('bulan') . '%';

		// dd($filter_bulan);

		$data['kelas'] = Kelas::all()->pluck('kelas', 'id');
		// $data['kelas']->prepend('-PILIH SALAH SATU-');

		$data['pesertadidik'] = Pesertadidik::select('s.nama_siswa', 'pesertadidik.*')
			->join('siswa as s', 'pesertadidik.id_siswa', '=', 's.id')
			->whereIdSemester(session()->get('active_semester')['id'])
			->whereIdKelas($request->get('id_kelas'))
			->orderBy('s.nama_siswa')
			->get();

		$data['presensi'] = Presensi::select('j.tgl_pembelajaran', 's.status_kehadiran_pendek', 'presensi.*')
			->join('jurnal as j', 'presensi.id_jurnal', '=', 'j.id')
			->join('statuskehadiran as s', 'presensi.id_statuskehadiran', '=', 's.id')
			->whereIn('id_pesertadidik', $data['pesertadidik']->pluck('id'))
			->where('j.tgl_pembelajaran', 'LIKE', $filter_bulan)
			// ->limit(10)
			->get();

		// dd($data['presensi']);

		$data['bulan'] = [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember'
		];


		return view('Presensi::rekap_presensi', array_merge($data, ['title' => $this->title]));
	}

	public function export_presensi(Request $request)
	{
		$pesertadidik = Pesertadidik::select('s.nama_siswa', 'pesertadidik.*')
			->join('siswa as s', 'pesertadidik.id_siswa', '=', 's.id')
			->whereIdSemester(session()->get('active_semester')['id'])
			->whereIdKelas($request->get('id_kelas'))
			->orderBy('s.nama_siswa')
			->get();

		$data_bulan = [
			'01' => 'Januari',
			'02' => 'Februari',
			'03' => 'Maret',
			'04' => 'April',
			'05' => 'Mei',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'Agustus',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember'
		];

		$kelas = Kelas::find($request->get('id_kelas'));

		// dd($pesertadidik);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Rekap Presensi Bulanan');

		$sheet->setCellValue('A2', 'Kelas :');
		$sheet->setCellValue('B2', $kelas->kelas);

		$sheet->setCellValue('A3', 'Bulan :');
		$sheet->setCellValue('B3', $data_bulan[$request->get('bulan')] . ' 2025');

		$sheet->setCellValue('A5', 'No');
		$sheet->mergeCells('A5:A6');
		$sheet->setCellValue('B5', 'Nama');
		$sheet->mergeCells('B5:B6');
		$sheet->setCellValue('C5', 'Tanggal');
		$sheet->mergeCells('C5:Z5');

		for ($i = 1; $i <= 31; $i++) {
			$kolom = 3;
			$kolom ++;
			$namakolom = Coordinate::stringFromColumnIndex($kolom);
			$cell = $namakolom . '6';
			$sheet->setCellValue($cell, $i);
		}





		$filename = "exported_data.xlsx";

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}

}
