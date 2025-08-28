<?php

namespace App\Modules\Konfirmasinilai\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Konfirmasinilai\Models\Konfirmasinilai;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KonfirmasinilaiController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Konfirmasinilai";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function batal_konfirmasi(Request $request, Konfirmasinilai $konfirmasinilai)
	{
		$konfirmasinilai->delete();

		$text = 'menghapus ' . $this->title; //.' '.$konfirmasinilai->what;
		$this->log($request, $text, ['konfirmasinilai.id' => $konfirmasinilai->id]);
		return back()->with('message_success', 'Konfirmasinilai berhasil dihapus!');
	}

	public function index(Request $request)
	{
		$query = Konfirmasinilai::query();
		if ($request->has('search')) {
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Konfirmasinilai::konfirmasinilai', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{

		$data['forms'] = array(
			'id_siswa' => ['Siswa', Form::text("id_siswa", old("id_siswa"), ["class" => "form-control", "placeholder" => ""])],
			'id_semester' => ['Semester', Form::text("id_semester", old("id_semester"), ["class" => "form-control", "placeholder" => ""])],
			'is_sesuai' => ['Is Sesuai', Form::text("is_sesuai", old("is_sesuai"), ["class" => "form-control", "placeholder" => ""])],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", old("keterangan"), ["class" => "form-control rich-editor"])],
			'bukti' => ['Bukti', Form::text("bukti", old("bukti"), ["class" => "form-control", "placeholder" => ""])],

		);

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('Konfirmasinilai::konfirmasinilai_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_siswa' => 'required',
			'id_semester' => 'required',
			'is_sesuai' => 'required',
			// 'keterangan' => 'required',
			'bukti' => 'max:1024',

		]);

		if ($request->has('bukti')) {
			$bukti_nilai = "bukti_nilai_" . time() . '.' . $request->bukti->extension();

			$request->bukti->move(public_path('uploads/bukti_nilai/'), $bukti_nilai);
		} else {
			$bukti_nilai = NULL;
		}

		$konfirmasinilai = new Konfirmasinilai();
		$konfirmasinilai->id_siswa = $request->input("id_siswa");
		$konfirmasinilai->id_semester = $request->input("id_semester");
		$konfirmasinilai->is_sesuai = $request->input("is_sesuai");
		$konfirmasinilai->keterangan = $request->input("keterangan");
		$konfirmasinilai->bukti = $bukti_nilai;

		$konfirmasinilai->created_by = Auth::id();
		$konfirmasinilai->save();

		$text = 'membuat ' . $this->title; //' baru '.$konfirmasinilai->what;
		$this->log($request, $text, ['konfirmasinilai.id' => $konfirmasinilai->id]);
		return redirect()->back()->with('message_success', 'Konfirmasinilai berhasil ditambahkan!');
	}

	public function show(Request $request, Konfirmasinilai $konfirmasinilai)
	{
		$data['konfirmasinilai'] = $konfirmasinilai;

		$text = 'melihat detail ' . $this->title; //.' '.$konfirmasinilai->what;
		$this->log($request, $text, ['konfirmasinilai.id' => $konfirmasinilai->id]);
		return view('Konfirmasinilai::konfirmasinilai_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Konfirmasinilai $konfirmasinilai)
	{
		$data['konfirmasinilai'] = $konfirmasinilai;


		$data['forms'] = array(
			'id_siswa' => ['Siswa', Form::text("id_siswa", $konfirmasinilai->id_siswa, ["class" => "form-control", "placeholder" => "", "id" => "id_siswa"])],
			'id_semester' => ['Semester', Form::text("id_semester", $konfirmasinilai->id_semester, ["class" => "form-control", "placeholder" => "", "id" => "id_semester"])],
			'is_sesuai' => ['Is Sesuai', Form::text("is_sesuai", $konfirmasinilai->is_sesuai, ["class" => "form-control", "placeholder" => "", "id" => "is_sesuai"])],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", $konfirmasinilai->keterangan, ["class" => "form-control rich-editor"])],
			'bukti' => ['Bukti', Form::text("bukti", $konfirmasinilai->bukti, ["class" => "form-control", "placeholder" => "", "id" => "bukti"])],

		);

		$text = 'membuka form edit ' . $this->title; //.' '.$konfirmasinilai->what;
		$this->log($request, $text, ['konfirmasinilai.id' => $konfirmasinilai->id]);
		return view('Konfirmasinilai::konfirmasinilai_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_siswa' => 'required',
			'id_semester' => 'required',
			'is_sesuai' => 'required',
			'keterangan' => 'required',
			'bukti' => 'required',

		]);

		$konfirmasinilai = Konfirmasinilai::find($id);
		$konfirmasinilai->id_siswa = $request->input("id_siswa");
		$konfirmasinilai->id_semester = $request->input("id_semester");
		$konfirmasinilai->is_sesuai = $request->input("is_sesuai");
		$konfirmasinilai->keterangan = $request->input("keterangan");
		$konfirmasinilai->bukti = $request->input("bukti");

		$konfirmasinilai->updated_by = Auth::id();
		$konfirmasinilai->save();


		$text = 'mengedit ' . $this->title; //.' '.$konfirmasinilai->what;
		$this->log($request, $text, ['konfirmasinilai.id' => $konfirmasinilai->id]);
		return redirect()->route('konfirmasinilai.index')->with('message_success', 'Konfirmasinilai berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$konfirmasinilai = Konfirmasinilai::find($id);
		$konfirmasinilai->deleted_by = Auth::id();
		$konfirmasinilai->save();
		$konfirmasinilai->delete();

		$text = 'menghapus ' . $this->title; //.' '.$konfirmasinilai->what;
		$this->log($request, $text, ['konfirmasinilai.id' => $konfirmasinilai->id]);
		return back()->with('message_success', 'Konfirmasinilai berhasil dihapus!');
	}
}
