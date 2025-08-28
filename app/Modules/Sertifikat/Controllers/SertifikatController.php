<?php

namespace App\Modules\Sertifikat\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Sertifikat\Models\Sertifikat;
use App\Modules\Guru\Models\Guru;
use App\Modules\Semester\Models\Semester;
use App\Modules\JenisWorkshop\Models\JenisWorkshop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SertifikatController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Sertifikat";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		// dd(Auth::user()->username);

		$data['data'] = Sertifikat::get_sertifikat_guru(session('id_guru'), session('active_semester')['id']);

		// dd($data['data']);

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Sertifikat::sertifikat', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{


		$id_guru = session('id_guru');
		$id_semester = session('active_semester')['id'];
		$jenis_workshop = JenisWorkshop::find($request->id_jenis_workshop);
		$sertifikat = Sertifikat::whereIdJenisWorkshop($jenis_workshop->id)->whereIdGuru($id_guru)->first();

		if($sertifikat)
		{
			$link_modul_ajar = $sertifikat->link_modul_ajar;
			$link_video = $sertifikat->link_video;
		}
		else{
			$link_modul_ajar = '';
			$link_video = '';
		}

		// dd($jenis_workshop);

		$data['forms'] = array(
			'id_guru' => ['', Form::hidden("id_guru", $id_guru, null, ["class" => "form-control"])],
			'id_jenis_workshop' => ['', Form::hidden("id_jenis_workshop", $jenis_workshop->id, null, ["class" => "form-control"])],
			'id_semester' => ['', Form::hidden("id_semester", $id_semester, null, ["class" => "form-control"])],
			'jenis_workshop' => ['Jenis Workshop', Form::text("jenis_workshop", $jenis_workshop->jenis_workshop, ["class" => "form-control select2", "disabled"])],
			'link_modul_ajar' => ['Link Modul Ajar', Form::text("link_modul_ajar", $link_modul_ajar, ["class" => "form-control"])],
			'link Video' => ['Link Video', Form::text("link_video", $link_video, ["class" => "form-control"])],

		);

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('Sertifikat::sertifikat_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_guru' => 'required',
			'id_semester' => 'required',
			'id_jenis_workshop' => 'required',
			'link_modul_ajar' => 'required',
			'link_video' => 'required',

		]);

		$cek_sertifikat = Sertifikat::whereIdGuru($request->id_guru)->whereIdJenisWorkshop($request->id_jenis_workshop)->first();

		if ($cek_sertifikat) {
			$sertifikat = Sertifikat::find($cek_sertifikat->id);

			$sertifikat->id_guru = $request->input("id_guru");
			$sertifikat->id_semester = $request->input("id_semester");
			$sertifikat->id_jenis_workshop = $request->input("id_jenis_workshop");
			$sertifikat->link_modul_ajar = $request->input("link_modul_ajar");
			$sertifikat->link_video = $request->input("link_video");
			// $sertifikat->folder_sertifikat = $request->input("folder_sertifikat");

			$sertifikat->updated_by = Auth::id();
			$sertifikat->save();
		} else {
			$sertifikat = new Sertifikat();
			$sertifikat->id_guru = $request->input("id_guru");
			$sertifikat->id_semester = $request->input("id_semester");
			$sertifikat->id_jenis_workshop = $request->input("id_jenis_workshop");
			$sertifikat->link_modul_ajar = $request->input("link_modul_ajar");
			$sertifikat->link_video = $request->input("link_video");
			$sertifikat->folder_sertifikat = $request->input("folder_sertifikat");

			$sertifikat->created_by = Auth::id();
			$sertifikat->save();
		}



		$text = 'membuat ' . $this->title; //' baru '.$sertifikat->what;
		$this->log($request, $text, ['sertifikat.id' => $sertifikat->id]);
		return redirect()->route('sertifikat.index')->with('message_success', 'Sertifikat berhasil ditambahkan!');
	}

	public function show(Request $request, Sertifikat $sertifikat)
	{
		$data['sertifikat'] = $sertifikat;

		$text = 'melihat detail ' . $this->title; //.' '.$sertifikat->what;
		$this->log($request, $text, ['sertifikat.id' => $sertifikat->id]);
		return view('Sertifikat::sertifikat_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Sertifikat $sertifikat)
	{
		$data['sertifikat'] = $sertifikat;

		$ref_guru = Guru::all()->pluck('nama', 'id');
		$ref_semester = Semester::all()->pluck('semester', 'id');
		$ref_jenis_workshop = JenisWorkshop::all()->pluck('jenis_workshop', 'id');

		$data['forms'] = array(
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"])],
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"])],
			'id_jenis_workshop' => ['Jenis Workshop', Form::select("id_jenis_workshop", $ref_jenis_workshop, null, ["class" => "form-control select2"])],
			'link' => ['Link', Form::textarea("link", $sertifikat->link, ["class" => "form-control rich-editor"])],
			'folder_sertifikat' => ['Folder Sertifikat', Form::text("folder_sertifikat", $sertifikat->folder_sertifikat, ["class" => "form-control", "placeholder" => "", "id" => "folder_sertifikat"])],

		);

		$text = 'membuka form edit ' . $this->title; //.' '.$sertifikat->what;
		$this->log($request, $text, ['sertifikat.id' => $sertifikat->id]);
		return view('Sertifikat::sertifikat_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_guru' => 'required',
			'id_semester' => 'required',
			'id_jenis_workshop' => 'required',
			'link' => 'required',
			'folder_sertifikat' => 'required',

		]);

		$sertifikat = Sertifikat::find($id);
		$sertifikat->id_guru = $request->input("id_guru");
		$sertifikat->id_semester = $request->input("id_semester");
		$sertifikat->id_jenis_workshop = $request->input("id_jenis_workshop");
		$sertifikat->link = $request->input("link");
		$sertifikat->folder_sertifikat = $request->input("folder_sertifikat");

		$sertifikat->updated_by = Auth::id();
		$sertifikat->save();


		$text = 'mengedit ' . $this->title; //.' '.$sertifikat->what;
		$this->log($request, $text, ['sertifikat.id' => $sertifikat->id]);
		return redirect()->route('sertifikat.index')->with('message_success', 'Sertifikat berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$sertifikat = Sertifikat::find($id);
		$sertifikat->deleted_by = Auth::id();
		$sertifikat->save();
		$sertifikat->delete();

		$text = 'menghapus ' . $this->title; //.' '.$sertifikat->what;
		$this->log($request, $text, ['sertifikat.id' => $sertifikat->id]);
		return back()->with('message_success', 'Sertifikat berhasil dihapus!');
	}
}
