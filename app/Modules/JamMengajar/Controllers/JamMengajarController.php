<?php
namespace App\Modules\JamMengajar\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\JamMengajar\Models\JamMengajar;
use App\Modules\Semester\Models\Semester;
use App\Modules\Guru\Models\Guru;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Kelas\Models\Kelas;
use App\Modules\Tingkat\Models\Tingkat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JamMengajarController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Jam Mengajar";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$data['data'] = JamMengajar::get_guru(session('active_semester')['id']);
		$data['kelas'] = JamMengajar::get_kelas(session('active_semester')['id']);
		$data['id_semester'] = session('active_semester')['id'];

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('JamMengajar::jammengajar', array_merge($data, ['title' => $this->title]));
	}

	public function cetak_jam_mengajar(Request $request)
	{
		$data['data'] = JamMengajar::get_guru(session('active_semester')['id']);
		$data['id_semester'] = session('active_semester')['id'];

		$this->log($request, 'mencetak data jam mengajar guru');
		return view('JamMengajar::cetak_jammengajar', array_merge($data, ['title' => $this->title]));
	}

	public function sk_mengajar(Request $request)
	{
		$data['guru'] = JamMengajar::get_guru_mapel();
		$data['tingkat']	= Tingkat::get()->sortBy('tingkat');
		$data['kelas']	= Kelas::get()->sortBy('kelas');

		$this->log($request, 'melihat halaman generate SK mengajar');
		return view('JamMengajar::sk_mengajar', array_merge($data, ['title' => $this->title]));
	}

	public function guru(Request $request, $id_guru)
	{
		$guru = Guru::find($id_guru);
		$data['guru']	= $guru;
		// $data['data']	= JamMengajar::query()->whereIdGuru($id_guru)->orderBy('id_kelas')->get();
		$data['data']	= JamMengajar::join('kelas', 'kelas.id', 'jam_mengajar.id_kelas')
										->select('jam_mengajar.*', 'kelas.kelas')
										->whereIdGuru($id_guru)
										->whereIdSemester(session('active_semester')['id'])
										->orderBy('kelas.kelas')
										->get();

		// dd($data['guru']);

		$this->log($request, 'melihat halaman manajemen jam mengajar guru');
		return view('JamMengajar::jammengajar_guru', array_merge($data, ['title' => $this->title]));
	}
	
	public function kelas(Request $request, $id_kelas)
	{
		$kelas = Kelas::find($id_kelas);
		$data['kelas']	= $kelas;
		// $data['data']	= JamMengajar::query()->whereIdGuru($id_guru)->orderBy('id_kelas')->get();
		$data['data']	= JamMengajar::join('kelas', 'kelas.id', 'jam_mengajar.id_kelas')
										->join('guru', 'jam_mengajar.id_guru', '=', 'guru.id')
										->select('jam_mengajar.*', 'kelas.kelas', 'guru.nama')
										->whereIdKelas($id_kelas)
										->whereIdSemester(session('active_semester')['id'])
										->orderBy('kelas.kelas')
										->get();

		// dd($data['guru']);

		$this->log($request, 'melihat halaman manajemen jam mengajar guru');
		return view('JamMengajar::jammengajar_kelas', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request, $id_guru)
	{
		$guru = Guru::find($id_guru);
		$ref_mapel = Mapel::all()->pluck('mapel','id');
		$ref_kelas = Kelas::all()->sortBy('kelas')->pluck('kelas','id');

		$ref_mapel->prepend('-PILIH SALAH SATU-', '');
		$ref_kelas->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			'nama_guru' => ['Guru', Form::text("id_guru", $guru->nama, ["class" => "form-control", "disabled" => "disabled"]) ],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"]) ],
			'id_kelas' => ['Kelas', Form::select("id_kelas[]", $ref_kelas, null, ["class" => "form-control select2", "multiple"=>"multiple"]) ],
			'jml_jam' => ['Jml Jam', Form::text("jml_jam", old("jml_jam"), ["class" => "form-control","placeholder" => ""]) ],
			'id_semester' => ['', Form::hidden("id_semester", get_semester('active_semester_id'), null) ],
			'id_guru' => ['', Form::hidden("id_guru", $guru->id, null) ],
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('JamMengajar::jammengajar_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_kelas' => 'required',
			'jml_jam' => 'required',
			
		]);

		// dd($request->get('id_kelas'));

		$list_id_kelas = $request->get('id_kelas');

		foreach($list_id_kelas as $key => $list_kelas)
		{
			$jammengajar = new JamMengajar();
			$jammengajar->id_semester = $request->input("id_semester");
			$jammengajar->id_guru = $request->input("id_guru");
			$jammengajar->id_mapel = $request->input("id_mapel");
			$jammengajar->id_kelas = $list_kelas;
			$jammengajar->jml_jam = $request->input("jml_jam");
			
			$jammengajar->created_by = Auth::id();
			$jammengajar->save();

		}


		$text = 'membuat '.$this->title; //' baru '.$jammengajar->what;
		$this->log($request, $text, ['jammengajar.id' => $jammengajar->id]);
		return redirect()->route('jammengajar.guru.index', $request->input('id_guru'))->with('message_success', 'Jam Mengajar berhasil ditambahkan!');
	}

	public function show(Request $request, JamMengajar $jammengajar)
	{
		$data['jammengajar'] = $jammengajar;

		$text = 'melihat detail '.$this->title;//.' '.$jammengajar->what;
		$this->log($request, $text, ['jammengajar.id' => $jammengajar->id]);
		return view('JamMengajar::jammengajar_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, JamMengajar $jammengajar)
	{
		$data['jammengajar'] = $jammengajar;

		$ref_guru = Guru::all()->pluck('nama','id');
		$ref_mapel = Mapel::all()->pluck('mapel','id');
		$ref_kelas = Kelas::all()->sortBy('kelas')->pluck('kelas','id');
		
		$data['forms'] = array(
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, $jammengajar->id_guru, ["class" => "form-control select2"]) ],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, $jammengajar->id_mapel, ["class" => "form-control select2"]) ],
			'id_kelas' => ['Kelas', Form::select("id_kelas", $ref_kelas, $jammengajar->id_kelas, ["class" => "form-control select2"]) ],
			'jml_jam' => ['Jml Jam', Form::text("jml_jam", $jammengajar->jml_jam, ["class" => "form-control","placeholder" => "", "id" => "jml_jam"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$jammengajar->what;
		$this->log($request, $text, ['jammengajar.id' => $jammengajar->id]);
		return view('JamMengajar::jammengajar_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_kelas' => 'required',
			'jml_jam' => 'required',
			
		]);
		
		$jammengajar = JamMengajar::find($id);
		$jammengajar->id_guru = $request->input("id_guru");
		$jammengajar->id_mapel = $request->input("id_mapel");
		$jammengajar->id_kelas = $request->input("id_kelas");
		$jammengajar->jml_jam = $request->input("jml_jam");
		
		$jammengajar->updated_by = Auth::id();
		$jammengajar->save();


		$text = 'mengedit '.$this->title;//.' '.$jammengajar->what;
		$this->log($request, $text, ['jammengajar.id' => $jammengajar->id]);
		return redirect()->route('jammengajar.guru.index', $jammengajar->id_guru)->with('message_success', 'Jam Mengajar berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$jammengajar = JamMengajar::find($id);
		$jammengajar->deleted_by = Auth::id();
		$jammengajar->save();
		$jammengajar->delete();

		$text = 'menghapus '.$this->title;//.' '.$jammengajar->what;
		$this->log($request, $text, ['jammengajar.id' => $jammengajar->id]);
		return back()->with('message_success', 'Jam Mengajar berhasil dihapus!');
	}

}
