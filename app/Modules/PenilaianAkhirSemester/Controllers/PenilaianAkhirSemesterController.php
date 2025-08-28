<?php

namespace App\Modules\PenilaianAkhirSemester\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\PenilaianAkhirSemester\Models\PenilaianAkhirSemester;
use App\Modules\Guru\Models\Guru;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Tingkat\Models\Tingkat;
use App\Modules\Semester\Models\Semester;

use App\Http\Controllers\Controller;
use App\Modules\JamMengajar\Models\JamMengajar;
use Illuminate\Support\Facades\Auth;

class PenilaianAkhirSemesterController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Penilaian Akhir Semester";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		if (session('active_role')['id'] == '9ec7541e-5a5e-4a3a-a255-6ffb46895f46') {
			$query = JamMengajar::get_mapel_perangkat(get_semester('active_semester_id'), session('id_guru'));
		} else {
			$query = JamMengajar::get_mapel_perangkat(get_semester('active_semester_id'));
		}
		// dd($query);

		$data['data'] = $query;


		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('PenilaianAkhirSemester::penilaianakhirsemester', array_merge($data, ['title' => $this->title]));
	}

	public function upload(Request $request, $id)
	{
		$data['data'] = JamMengajar::find($id);
		$data['perangkat'] = PenilaianAkhirSemester::whereIdGuru($data['data']->id_guru)
			->whereIdMapel($data['data']->id_mapel)
			->whereIdTingkat($data['data']->kelas->id_tingkat)
			->whereIdSemester(session('active_semester')['id'])
			->first();
		// dd($data['perangkat']);

		$this->log($request, 'melihat halaman upload data ' . $this->title);
		return view('PenilaianAkhirSemester::pas_upload', array_merge($data, ['title' => $this->title]));
	}

	public function aksi_upload(Request $request)
	{
		$jam_mengajar = JamMengajar::find($request->id);
		// dd($jam_mengajar->kelas);

		$request->validate([
			'file' => 'required|mimes:pdf,doc,docx|max:10240'
		]);

		$cek_data = PenilaianAkhirSemester::whereIdGuru($jam_mengajar->id_guru)
			->whereIdMapel($jam_mengajar->id_mapel)
			->whereIdTingkat($jam_mengajar->kelas->id_tingkat)
			->whereIdSemester($jam_mengajar->id_semester)
			->first();

		$fileName = time() . '.' . $request->file->extension();

		$request->file->move(public_path('uploads/' . $request->get('jenis')), $fileName);

		if ($cek_data) {
			$pas = PenilaianAkhirSemester::find($cek_data->id);
			if ($request->get('jenis') == 'kisikisi') {
				$pas->kisi_kisi = $fileName;
			} else if ($request->get('jenis') == 'norma') {
				$pas->kunci = $fileName;
			} else if ($request->get('jenis') == 'soal') {
				$pas->perangkat = $fileName;
			}
			$pas->save();
		} else {
			$pas = new PenilaianAkhirSemester();
			$pas->id_guru = $jam_mengajar->id_guru;
			$pas->id_mapel = $jam_mengajar->id_mapel;
			$pas->id_tingkat = $jam_mengajar->kelas->id_tingkat;
			$pas->id_semester = $jam_mengajar->id_semester;

			if ($request->get('jenis') == 'kisikisi') {
				$pas->kisi_kisi = $fileName;
			} else if ($request->get('jenis') == 'norma') {
				$pas->kunci = $fileName;
			} else if ($request->get('jenis') == 'soal') {
				$pas->perangkat = $fileName;
			}
			$pas->save();
		}


		$text = 'mengupload ' . $this->title; //' baru '.$gurumapel->what;
		$this->log($request, $text);
		return redirect()->back()->with('message_success', 'Berkas berhasil diupload!');
	}

	public function create(Request $request)
	{
		$ref_guru = Guru::all()->pluck('nama', 'id');
		$ref_mapel = Mapel::all()->pluck('mapel', 'id');
		$ref_tingkat = Tingkat::all()->pluck('tingkat', 'id');
		$ref_semester = Semester::all()->pluck('semester', 'id');

		$data['forms'] = array(
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"])],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"])],
			'id_tingkat' => ['Tingkat', Form::select("id_tingkat", $ref_tingkat, null, ["class" => "form-control select2"])],
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"])],
			'perangkat' => ['Perangkat', Form::text("perangkat", old("perangkat"), ["class" => "form-control", "placeholder" => ""])],

		);

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('PenilaianAkhirSemester::penilaianakhirsemester_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_tingkat' => 'required',
			'id_semester' => 'required',
			'perangkat' => 'required|mimes:pdf,doc,docx|max:10240',

		]);

		$cek = PenilaianAkhirSemester::whereIdGuru($request->input('id_guru'))
			->whereIdMapel($request->input('id_mapel'))
			->whereIdTingkat($request->input('id_tingkat'))
			->whereIdSemester(session('active_semester')['id'])
			->first();

		if ($cek) {
			$file = time() . '.' . $request->perangkat->extension();

			$request->perangkat->move(public_path('uploads/pas/'), $file);

			$penilaianakhirsemester = PenilaianAkhirSemester::find($cek->id);
			$penilaianakhirsemester->id_guru = $request->input("id_guru");
			$penilaianakhirsemester->id_mapel = $request->input("id_mapel");
			$penilaianakhirsemester->id_tingkat = $request->input("id_tingkat");
			$penilaianakhirsemester->id_semester = $request->input("id_semester");
			$penilaianakhirsemester->perangkat = $file;

			$penilaianakhirsemester->created_by = Auth::id();
			$penilaianakhirsemester->save();
		} else {
			$file = time() . '.' . $request->perangkat->extension();

			$request->perangkat->move(public_path('uploads/pas/'), $file);

			$penilaianakhirsemester = new PenilaianAkhirSemester();
			$penilaianakhirsemester->id_guru = $request->input("id_guru");
			$penilaianakhirsemester->id_mapel = $request->input("id_mapel");
			$penilaianakhirsemester->id_tingkat = $request->input("id_tingkat");
			$penilaianakhirsemester->id_semester = $request->input("id_semester");
			$penilaianakhirsemester->perangkat = $file;

			$penilaianakhirsemester->created_by = Auth::id();
			$penilaianakhirsemester->save();
		}



		$text = 'membuat ' . $this->title; //' baru '.$penilaianakhirsemester->what;
		$this->log($request, $text, ['penilaianakhirsemester.id' => $penilaianakhirsemester->id]);
		return redirect()->back()->with('message_success', 'Penilaian Akhir Semester berhasil ditambahkan!');
	}

	public function show(Request $request, PenilaianAkhirSemester $penilaianakhirsemester)
	{
		$data['penilaianakhirsemester'] = $penilaianakhirsemester;

		$text = 'melihat detail ' . $this->title; //.' '.$penilaianakhirsemester->what;
		$this->log($request, $text, ['penilaianakhirsemester.id' => $penilaianakhirsemester->id]);
		return view('PenilaianAkhirSemester::penilaianakhirsemester_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, PenilaianAkhirSemester $penilaianakhirsemester)
	{
		$data['penilaianakhirsemester'] = $penilaianakhirsemester;

		$ref_guru = Guru::all()->pluck('nama', 'id');
		$ref_mapel = Mapel::all()->pluck('mapel', 'id');
		$ref_tingkat = Tingkat::all()->pluck('tingkat', 'id');
		$ref_semester = Semester::all()->pluck('semester', 'id');

		$data['forms'] = array(
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"])],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"])],
			'id_tingkat' => ['Tingkat', Form::select("id_tingkat", $ref_tingkat, null, ["class" => "form-control select2"])],
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"])],
			'perangkat' => ['Perangkat', Form::text("perangkat", $penilaianakhirsemester->perangkat, ["class" => "form-control", "placeholder" => "", "id" => "perangkat"])],

		);

		$text = 'membuka form edit ' . $this->title; //.' '.$penilaianakhirsemester->what;
		$this->log($request, $text, ['penilaianakhirsemester.id' => $penilaianakhirsemester->id]);
		return view('PenilaianAkhirSemester::penilaianakhirsemester_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_tingkat' => 'required',
			'id_semester' => 'required',
			'perangkat' => 'required',

		]);

		$penilaianakhirsemester = PenilaianAkhirSemester::find($id);
		$penilaianakhirsemester->id_guru = $request->input("id_guru");
		$penilaianakhirsemester->id_mapel = $request->input("id_mapel");
		$penilaianakhirsemester->id_tingkat = $request->input("id_tingkat");
		$penilaianakhirsemester->id_semester = $request->input("id_semester");
		$penilaianakhirsemester->perangkat = $request->input("perangkat");

		$penilaianakhirsemester->updated_by = Auth::id();
		$penilaianakhirsemester->save();


		$text = 'mengedit ' . $this->title; //.' '.$penilaianakhirsemester->what;
		$this->log($request, $text, ['penilaianakhirsemester.id' => $penilaianakhirsemester->id]);
		return redirect()->route('penilaianakhirsemester.index')->with('message_success', 'Penilaian Akhir Semester berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$penilaianakhirsemester = PenilaianAkhirSemester::find($id);
		$penilaianakhirsemester->deleted_by = Auth::id();
		$penilaianakhirsemester->save();
		$penilaianakhirsemester->delete();

		$text = 'menghapus ' . $this->title; //.' '.$penilaianakhirsemester->what;
		$this->log($request, $text, ['penilaianakhirsemester.id' => $penilaianakhirsemester->id]);
		return back()->with('message_success', 'Penilaian Akhir Semester berhasil dihapus!');
	}
}
