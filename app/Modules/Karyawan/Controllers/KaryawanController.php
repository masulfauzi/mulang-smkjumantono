<?php
namespace App\Modules\Karyawan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Karyawan\Models\Karyawan;
use App\Modules\BagianTu\Models\BagianTu;
use App\Modules\Jeniskelamin\Models\Jeniskelamin;
use App\Modules\Agama\Models\Agama;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Karyawan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Karyawan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Karyawan::karyawan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_bagian_tu = BagianTu::all()->pluck('bagian','id');
		$ref_jeniskelamin = Jeniskelamin::all()->pluck('jeniskelamin','id');
		$ref_agama = Agama::all()->pluck('agama','id');

		$ref_bagian_tu->prepend('-PILIH SALAH SATU-', '');
		$ref_jeniskelamin->prepend('-PILIH SALAH SATU-', '');
		$ref_agama->prepend('-PILIH SALAH SATU', '');
		
		$data['forms'] = array(
			'id_bagian' => ['Bagian', Form::select("id_bagian", $ref_bagian_tu, null, ["class" => "form-control select2"]) ],
			'id_jenis_kelamin' => ['Jenis Kelamin', Form::select("id_jenis_kelamin", $ref_jeniskelamin, null, ["class" => "form-control select2"]) ],
			'id_agama' => ['Agama', Form::select("id_agama", $ref_agama, null, ["class" => "form-control select2"]) ],
			'nama_karyawan' => ['Nama Karyawan', Form::text("nama_karyawan", old("nama_karyawan"), ["class" => "form-control","placeholder" => ""]) ],
			'tempat_lahir' => ['Tempat Lahir', Form::text("tempat_lahir", old("tempat_lahir"), ["class" => "form-control","placeholder" => ""]) ],
			'tgl_lahir' => ['Tgl Lahir', Form::text("tgl_lahir", old("tgl_lahir"), ["class" => "form-control datepicker"]) ],
			'nik' => ['Nik', Form::text("nik", old("nik"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Karyawan::karyawan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_bagian' => 'required',
			'id_jenis_kelamin' => 'required',
			'id_agama' => 'required',
			'nama_karyawan' => 'required',
			'tempat_lahir' => 'required',
			'tgl_lahir' => 'required',
			'nik' => 'required',
			
		]);

		$karyawan = new Karyawan();
		$karyawan->id_bagian = $request->input("id_bagian");
		$karyawan->id_jenis_kelamin = $request->input("id_jenis_kelamin");
		$karyawan->id_agama = $request->input("id_agama");
		$karyawan->nama_karyawan = $request->input("nama_karyawan");
		$karyawan->tempat_lahir = $request->input("tempat_lahir");
		$karyawan->tgl_lahir = $request->input("tgl_lahir");
		$karyawan->nik = $request->input("nik");
		
		$karyawan->created_by = Auth::id();
		$karyawan->save();

		$text = 'membuat '.$this->title; //' baru '.$karyawan->what;
		$this->log($request, $text, ['karyawan.id' => $karyawan->id]);
		return redirect()->route('karyawan.index')->with('message_success', 'Karyawan berhasil ditambahkan!');
	}

	public function show(Request $request, Karyawan $karyawan)
	{
		$data['karyawan'] = $karyawan;

		$text = 'melihat detail '.$this->title;//.' '.$karyawan->what;
		$this->log($request, $text, ['karyawan.id' => $karyawan->id]);
		return view('Karyawan::karyawan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Karyawan $karyawan)
	{
		$data['karyawan'] = $karyawan;

		$ref_bagian_tu = BagianTu::all()->pluck('bagian','id');
		$ref_jeniskelamin = Jeniskelamin::all()->pluck('jeniskelamin','id');
		$ref_agama = Agama::all()->pluck('agama','id');
		
		$data['forms'] = array(
			'id_bagian' => ['Bagian', Form::select("id_bagian", $ref_bagian_tu, null, ["class" => "form-control select2"]) ],
			'id_jenis_kelamin' => ['Jenis Kelamin', Form::select("id_jenis_kelamin", $ref_jeniskelamin, null, ["class" => "form-control select2"]) ],
			'id_agama' => ['Agama', Form::select("id_agama", $ref_agama, null, ["class" => "form-control select2"]) ],
			'nama_karyawan' => ['Nama Karyawan', Form::text("nama_karyawan", $karyawan->nama_karyawan, ["class" => "form-control","placeholder" => "", "id" => "nama_karyawan"]) ],
			'tempat_lahir' => ['Tempat Lahir', Form::text("tempat_lahir", $karyawan->tempat_lahir, ["class" => "form-control","placeholder" => "", "id" => "tempat_lahir"]) ],
			'tgl_lahir' => ['Tgl Lahir', Form::text("tgl_lahir", $karyawan->tgl_lahir, ["class" => "form-control datepicker", "id" => "tgl_lahir"]) ],
			'nik' => ['Nik', Form::text("nik", $karyawan->nik, ["class" => "form-control","placeholder" => "", "id" => "nik"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$karyawan->what;
		$this->log($request, $text, ['karyawan.id' => $karyawan->id]);
		return view('Karyawan::karyawan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_bagian' => 'required',
			'id_jenis_kelamin' => 'required',
			'id_agama' => 'required',
			'nama_karyawan' => 'required',
			'tempat_lahir' => 'required',
			'tgl_lahir' => 'required',
			'nik' => 'required',
			
		]);
		
		$karyawan = Karyawan::find($id);
		$karyawan->id_bagian = $request->input("id_bagian");
		$karyawan->id_jenis_kelamin = $request->input("id_jenis_kelamin");
		$karyawan->id_agama = $request->input("id_agama");
		$karyawan->nama_karyawan = $request->input("nama_karyawan");
		$karyawan->tempat_lahir = $request->input("tempat_lahir");
		$karyawan->tgl_lahir = $request->input("tgl_lahir");
		$karyawan->nik = $request->input("nik");
		
		$karyawan->updated_by = Auth::id();
		$karyawan->save();


		$text = 'mengedit '.$this->title;//.' '.$karyawan->what;
		$this->log($request, $text, ['karyawan.id' => $karyawan->id]);
		return redirect()->route('karyawan.index')->with('message_success', 'Karyawan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$karyawan = Karyawan::find($id);
		$karyawan->deleted_by = Auth::id();
		$karyawan->save();
		$karyawan->delete();

		$text = 'menghapus '.$this->title;//.' '.$karyawan->what;
		$this->log($request, $text, ['karyawan.id' => $karyawan->id]);
		return back()->with('message_success', 'Karyawan berhasil dihapus!');
	}

}
