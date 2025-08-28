<?php
namespace App\Modules\PerangkatPembelajaran\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\PerangkatPembelajaran\Models\PerangkatPembelajaran;
use App\Modules\Semester\Models\Semester;
use App\Modules\Guru\Models\Guru;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Tingkat\Models\Tingkat;
use App\Modules\JenisPerangkat\Models\JenisPerangkat;

use App\Http\Controllers\Controller;
use App\Modules\JamMengajar\Models\JamMengajar;
use Illuminate\Support\Facades\Auth;

class PerangkatPembelajaranController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Perangkat Pembelajaran";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		// dd(session('active_role')['id']);

		$id_role = [
			"bf1548f3-295c-4d73-809d-66ab7c240091",
			"1fe8326c-22c4-4732-9c12-f7b83a16b842"
		];

		if(in_array(session('active_role')['id'], $id_role))
		{
			return redirect()->route('perangkatpembelajaran.admin.index');
		}

		$query = JamMengajar::get_mapel_perangkat(get_semester('active_semester_id'), session('id_guru'));
		$data['data'] = $query;

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('PerangkatPembelajaran::perangkatpembelajaran', array_merge($data, ['title' => $this->title]));
	}

	public function index_admin(Request $request)
	{
		$query = JamMengajar::get_mapel_perangkat(get_semester('active_semester_id'));
		$data['data'] = $query;

		// dd($data['data']);

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('PerangkatPembelajaran::perangkatpembelajaran_admin', array_merge($data, ['title' => $this->title]));
	}

	public function upload(Request $request, $id)
	{
		$data['data'] = JamMengajar::find($id);
		// dd($data['data']->kelas->tingkat->id);
		$data['mapel'] = JamMengajar::join('kelas', 'kelas.id', 'jam_mengajar.id_kelas')
							->join('tingkat', 'tingkat.id', 'kelas.id_tingkat')
							->select('jam_mengajar.*')
							->where('tingkat.id', $data['data']->kelas->tingkat->id)
							->whereIdMapel($data['data']->id_mapel)
							->whereIdGuru($data['data']->id_guru)
							->whereIdSemester($data['data']->id_semester)
							->get();
		$data['jns_perangkat'] = JenisPerangkat::get()->sortBy('jenis_perangkat')->pluck('jenis_perangkat', 'id');
		$data['jns_perangkat']->prepend('-PILIH SALAH SATU-', '');
		$data['perangkat'] = PerangkatPembelajaran::query()
							->whereIdGuru($data['data']->id_guru)
							->whereIdMapel($data['data']->id_mapel)
							->whereIdSemester($data['data']->id_semester)
							->whereIdTingkat($data['data']->kelas->tingkat->id)
							->get();

		$this->log($request, 'melihat halaman upload data '.$this->title);
		return view('PerangkatPembelajaran::perangkatpembelajaran_upload', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_semester = Semester::all()->pluck('semester','id');
		$ref_guru = Guru::all()->pluck('nama','id');
		$ref_mapel = Mapel::all()->pluck('mapel','id');
		$ref_tingkat = Tingkat::all()->pluck('tingkat','id');
		$ref_jenis_perangkat = JenisPerangkat::all()->pluck('jenis_perangkat','id');
		
		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"]) ],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"]) ],
			'id_tingkat' => ['Tingkat', Form::select("id_tingkat", $ref_tingkat, null, ["class" => "form-control select2"]) ],
			'id_jenis_perangkat' => ['Jenis Perangkat', Form::select("id_jenis_perangkat", $ref_jenis_perangkat, null, ["class" => "form-control select2"]) ],
			'file' => ['File', Form::text("file", old("file"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('PerangkatPembelajaran::perangkatpembelajaran_create', array_merge($data, ['title' => $this->title]));
	}

	public function lihat_perangkat(Request $request, $id, $jenis)
	{
		$jenis_perangkat = JenisPerangkat::query()->whereSlug($jenis)->first();
		$data['data'] = JamMengajar::find($id);
		$data['mapel'] = PerangkatPembelajaran::get_kelas_by_data($data['data']);
		$data['perangkat'] = PerangkatPembelajaran::query()
							->whereIdGuru($data['data']->id_guru)
							->whereIdMapel($data['data']->id_mapel)
							->whereIdSemester($data['data']->id_semester)
							->whereIdTingkat($data['data']->kelas['id_tingkat'])
							->whereIdJenisPerangkat($jenis_perangkat->id)
							->get();
							
		return view('PerangkatPembelajaran::perangkatpembelajaran_lihat_perangkat', $data);
	}

	public function lihat(Request $request, $id)
	{
		$data['data'] = JamMengajar::find($id);
		$data['mapel'] = JamMengajar::query()
							->whereIdMapel($data['data']->id_mapel)
							->whereIdGuru($data['data']->id_guru)
							->whereIdSemester($data['data']->id_semester)
							->get();
		$data['jns_perangkat'] = JenisPerangkat::get()->sortBy('jenis_perangkat')->pluck('jenis_perangkat', 'id');
		$data['jns_perangkat']->prepend('-PILIH SALAH SATU-', '');
		$data['perangkat'] = PerangkatPembelajaran::query()
							->whereIdGuru($data['data']->id_guru)
							->whereIdMapel($data['data']->id_mapel)
							->whereIdSemester($data['data']->id_semester)
							->get();

		$this->log($request, 'melihat halaman lihat data '.$this->title);
		return view('PerangkatPembelajaran::perangkatpembelajaran_lihat', array_merge($data, ['title' => $this->title]));
	}

	public function detail(Request $request, $id)
	{
		$data['data'] = PerangkatPembelajaran::find($id);

		// dd($data['data']->file);

		$this->log($request, 'melihat halaman detail data '.$this->title);
		return redirect('/uploads/perangkat/'.$data['data']->file);
		// return view('PerangkatPembelajaran::perangkatpembelajaran_detail', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_tingkat' => 'required',
			'id_jenis_perangkat' => 'required',
			'file' => 'required|mimes:pdf,doc,docx|max:10240',
			'nama_perangkat' => 'required',
			
		]);

		$file = time().'.'.$request->file->extension();  

        $request->file->move(public_path('uploads/perangkat/'), $file);

		$perangkatpembelajaran = new PerangkatPembelajaran();
		$perangkatpembelajaran->id_semester = $request->input("id_semester");
		$perangkatpembelajaran->id_guru = $request->input("id_guru");
		$perangkatpembelajaran->id_mapel = $request->input("id_mapel");
		$perangkatpembelajaran->id_tingkat = $request->input("id_tingkat");
		$perangkatpembelajaran->id_jenis_perangkat = $request->input("id_jenis_perangkat");
		$perangkatpembelajaran->nama_perangkat = $request->input("nama_perangkat");
		$perangkatpembelajaran->file = $file;
		
		$perangkatpembelajaran->created_by = Auth::id();
		$perangkatpembelajaran->save();

		$text = 'membuat '.$this->title; //' baru '.$perangkatpembelajaran->what;
		$this->log($request, $text, ['perangkatpembelajaran.id' => $perangkatpembelajaran->id]);
		return redirect()->route('perangkatpembelajaran.upload.index', $request->input("id_jam_mengajar"))->with('message_success', 'Perangkat Pembelajaran berhasil ditambahkan!');
	}

	public function show(Request $request, PerangkatPembelajaran $perangkatpembelajaran)
	{
		$data['perangkatpembelajaran'] = $perangkatpembelajaran;

		$text = 'melihat detail '.$this->title;//.' '.$perangkatpembelajaran->what;
		$this->log($request, $text, ['perangkatpembelajaran.id' => $perangkatpembelajaran->id]);
		return view('PerangkatPembelajaran::perangkatpembelajaran_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, PerangkatPembelajaran $perangkatpembelajaran)
	{
		$data['perangkatpembelajaran'] = $perangkatpembelajaran;

		$ref_semester = Semester::all()->pluck('semester','id');
		$ref_guru = Guru::all()->pluck('nama','id');
		$ref_mapel = Mapel::all()->pluck('mapel','id');
		$ref_tingkat = Tingkat::all()->pluck('tingkat','id');
		$ref_jenis_perangkat = JenisPerangkat::all()->pluck('jenis_perangkat','id');
		
		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"]) ],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"]) ],
			'id_tingkat' => ['Tingkat', Form::select("id_tingkat", $ref_tingkat, null, ["class" => "form-control select2"]) ],
			'id_jenis_perangkat' => ['Jenis Perangkat', Form::select("id_jenis_perangkat", $ref_jenis_perangkat, null, ["class" => "form-control select2"]) ],
			'file' => ['File', Form::text("file", $perangkatpembelajaran->file, ["class" => "form-control","placeholder" => "", "id" => "file"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$perangkatpembelajaran->what;
		$this->log($request, $text, ['perangkatpembelajaran.id' => $perangkatpembelajaran->id]);
		return view('PerangkatPembelajaran::perangkatpembelajaran_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_tingkat' => 'required',
			'id_jenis_perangkat' => 'required',
			'file' => 'required',
			
		]);
		
		$perangkatpembelajaran = PerangkatPembelajaran::find($id);
		$perangkatpembelajaran->id_semester = $request->input("id_semester");
		$perangkatpembelajaran->id_guru = $request->input("id_guru");
		$perangkatpembelajaran->id_mapel = $request->input("id_mapel");
		$perangkatpembelajaran->id_tingkat = $request->input("id_tingkat");
		$perangkatpembelajaran->id_jenis_perangkat = $request->input("id_jenis_perangkat");
		$perangkatpembelajaran->file = $request->input("file");
		
		$perangkatpembelajaran->updated_by = Auth::id();
		$perangkatpembelajaran->save();


		$text = 'mengedit '.$this->title;//.' '.$perangkatpembelajaran->what;
		$this->log($request, $text, ['perangkatpembelajaran.id' => $perangkatpembelajaran->id]);
		return redirect()->route('perangkatpembelajaran.index')->with('message_success', 'Perangkat Pembelajaran berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$perangkatpembelajaran = PerangkatPembelajaran::find($id);
		$perangkatpembelajaran->deleted_by = Auth::id();
		$perangkatpembelajaran->save();
		$perangkatpembelajaran->delete();

		$text = 'menghapus '.$this->title;//.' '.$perangkatpembelajaran->what;
		$this->log($request, $text, ['perangkatpembelajaran.id' => $perangkatpembelajaran->id]);
		return back()->with('message_success', 'Perangkat Pembelajaran berhasil dihapus!');
	}

}
