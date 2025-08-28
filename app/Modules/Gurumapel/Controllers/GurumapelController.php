<?php
namespace App\Modules\Gurumapel\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Gurumapel\Models\Gurumapel;
use App\Modules\Guru\Models\Guru;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Tingkat\Models\Tingkat;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Semester\Models\Semester;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GurumapelController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Gurumapel";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		// dd(session('active_role')['id']);
		if(session('active_role')['id'] == '9ec7541e-5a5e-4a3a-a255-6ffb46895f46')
		{
			return redirect(route('gurumapel.pas.index'));
		}


		$query = Gurumapel::whereIdSemester(get_semester('active_semester_id'))
							->with('guru')
							->orderBy(Guru::select('nama')->whereColumn('guru.id', 'gurumapel.id_guru'));
		if($request->has('search')){
			$search = $request->get('search');
			//$query->where('nama', 'like', "%$search%");
			$query->whereHas('guru', function($q) use ($search) {
				$q->where('guru.nama', 'like', "%$search%");
			});
			$query->orWhereHas('mapel', function($q) use ($search) {
				$q->where('mapel.mapel', 'like', "%$search%");
			});
		}
		$data['data'] = $query->paginate(20)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Gurumapel::gurumapel', array_merge($data, ['title' => $this->title]));
	}

	public function index_guru(Request $request)
	{
		$data['data'] = Gurumapel::whereIdSemester(get_semester('active_semester_id'))->whereIdGuru(session('id_guru'))->get();

		// dd($data['data']);

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Gurumapel::pas', array_merge($data, ['title' => $this->title]));
	}

	public function upload_file(Request $request, $id_gurumapel)
	{
		$data['data'] = Gurumapel::whereId($id_gurumapel)->get()->first();

		// dd($data['data']);

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Gurumapel::pas_upload', array_merge($data, ['title' => $this->title]));
	}

	public function lihat_file(Request $request, $file, $jenis)
	{
		$data['file']  = $file;
		$data['jenis']  = $jenis;

		return view('Gurumapel::gurumapel_lihat_file', $data);
	}

	public function aksi_upload(Request $request)
	{
		$request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:10240'
        ]);

		$fileName = time().'.'.$request->file->extension();  

        $request->file->move(public_path('uploads/'.$request->get('jenis')), $fileName);

		$gurumapel = Gurumapel::find($request->get('id'));
		if($request->get('jenis') == 'kisikisi')
		{
			$gurumapel->kisikisi = $fileName;
		}
		else if($request->get('jenis') == 'norma')
		{
			$gurumapel->norma = $fileName;
		}
		else if($request->get('jenis') == 'soal')
		{
			$gurumapel->soal = $fileName;
		}
		$gurumapel->save();
		

		$text = 'mengupload '.$this->title; //' baru '.$gurumapel->what;
		$this->log($request, $text);
		return redirect()->route('gurumapel.pas.upload.index', $request->get('id'))->with('message_success', 'Berkas berhasil diupload!');
	}

	public function create(Request $request)
	{
		$ref_guru = Guru::all()->sortBy('nama')->pluck('nama','id');
		$ref_mapel = Mapel::all()->sortBy('mapel')->pluck('mapel','id');
		$ref_tingkat = Tingkat::all()->sortBy('tingkat')->pluck('tingkat','id');
		$ref_jurusan = Jurusan::all()->sortBy('jurusan')->pluck('jurusan','id');
		
		$data['forms'] = array(
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"]) ],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"]) ],
			'id_tingkat' => ['Tingkat', Form::select("id_tingkat", $ref_tingkat, null, ["class" => "form-control select2"]) ],
			'id_jurusan' => ['Jurusan', Form::select("id_jurusan", $ref_jurusan, null, ["class" => "form-control select2"]) ],
			// 'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'id_semester' => ['', Form::hidden("id_semester", get_semester('active_semester_id'), null, ["class" => "form-control select2"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Gurumapel::gurumapel_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_tingkat' => 'required',
			'id_jurusan' => 'required',
			'id_semester' => 'required',
			
		]);

		$gurumapel = new Gurumapel();
		$gurumapel->id_guru = $request->input("id_guru");
		$gurumapel->id_mapel = $request->input("id_mapel");
		$gurumapel->id_tingkat = $request->input("id_tingkat");
		$gurumapel->id_jurusan = $request->input("id_jurusan");
		$gurumapel->id_semester = $request->input("id_semester");
		
		$gurumapel->created_by = Auth::id();
		$gurumapel->save();

		$text = 'membuat '.$this->title; //' baru '.$gurumapel->what;
		$this->log($request, $text, ['gurumapel.id' => $gurumapel->id]);
		return redirect()->route('gurumapel.index')->with('message_success', 'Gurumapel berhasil ditambahkan!');
	}

	public function show(Request $request, Gurumapel $gurumapel)
	{
		$data['gurumapel'] = $gurumapel;

		$text = 'melihat detail '.$this->title;//.' '.$gurumapel->what;
		$this->log($request, $text, ['gurumapel.id' => $gurumapel->id]);
		return view('Gurumapel::gurumapel_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Gurumapel $gurumapel)
	{
		$data['gurumapel'] = $gurumapel;

		$ref_guru = Guru::all()->pluck('nama','id');
		$ref_mapel = Mapel::all()->pluck('mapel','id');
		$ref_tingkat = Tingkat::all()->pluck('tingkat','id');
		$ref_jurusan = Jurusan::all()->pluck('jurusan','id');
		$ref_semester = Semester::all()->pluck('semester','id');
		
		$data['forms'] = array(
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"]) ],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"]) ],
			'id_tingkat' => ['Tingkat', Form::select("id_tingkat", $ref_tingkat, null, ["class" => "form-control select2"]) ],
			'id_jurusan' => ['Jurusan', Form::select("id_jurusan", $ref_jurusan, null, ["class" => "form-control select2"]) ],
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$gurumapel->what;
		$this->log($request, $text, ['gurumapel.id' => $gurumapel->id]);
		return view('Gurumapel::gurumapel_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_tingkat' => 'required',
			'id_jurusan' => 'required',
			'id_semester' => 'required',
			
		]);
		
		$gurumapel = Gurumapel::find($id);
		$gurumapel->id_guru = $request->input("id_guru");
		$gurumapel->id_mapel = $request->input("id_mapel");
		$gurumapel->id_tingkat = $request->input("id_tingkat");
		$gurumapel->id_jurusan = $request->input("id_jurusan");
		$gurumapel->id_semester = $request->input("id_semester");
		
		$gurumapel->updated_by = Auth::id();
		$gurumapel->save();


		$text = 'mengedit '.$this->title;//.' '.$gurumapel->what;
		$this->log($request, $text, ['gurumapel.id' => $gurumapel->id]);
		return redirect()->route('gurumapel.index')->with('message_success', 'Gurumapel berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$gurumapel = Gurumapel::find($id);
		$gurumapel->deleted_by = Auth::id();
		$gurumapel->save();
		$gurumapel->delete();

		$text = 'menghapus '.$this->title;//.' '.$gurumapel->what;
		$this->log($request, $text, ['gurumapel.id' => $gurumapel->id]);
		return back()->with('message_success', 'Gurumapel berhasil dihapus!');
	}

}
