<?php
namespace App\Modules\Semester\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Semester\Models\Semester;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SemesterController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Semester";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Semester::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Semester::semester', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'semester' => ['Semester', Form::text("semester", old("semester"), ["class" => "form-control","placeholder" => ""]) ],
			'tgl_mulai' => ['Tgl Mulai', Form::date("tgl_mulai", old("tgl_mulai"), ["class" => "form-control"]) ],
			'tgl_selesai' => ['Tgl Selesai', Form::date("tgl_selesai", old("tgl_selesai"), ["class" => "form-control"]) ],
			'wkt_kelulusan' => ['Waktu Kelulusan', Form::datetimeLocal("wkt_kelulusan", old("wkt_kelulusan"), ["class" => "form-control"]) ],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", old("keterangan"), ["class" => "form-control rich-editor"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Semester::semester_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'semester' => 'required',
			'tgl_mulai' => 'required',
			'tgl_selesai' => 'required',
			'keterangan' => 'required',
			'wkt_kelulusan' => 'required',
			
		]);

		$semester = new Semester();
		$semester->semester = $request->input("semester");
		$semester->tgl_mulai = $request->input("tgl_mulai");
		$semester->tgl_selesai = $request->input("tgl_selesai");
		$semester->keterangan = $request->input("keterangan");
		$semester->wkt_kelulusan = $request->input("wkt_kelulusan");
		
		$semester->created_by = Auth::id();
		$semester->save();

		$text = 'membuat '.$this->title; //' baru '.$semester->what;
		$this->log($request, $text, ['semester.id' => $semester->id]);
		return redirect()->route('semester.index')->with('message_success', 'Semester berhasil ditambahkan!');
	}

	public function show(Request $request, Semester $semester)
	{
		$data['semester'] = $semester;

		$text = 'melihat detail '.$this->title;//.' '.$semester->what;
		$this->log($request, $text, ['semester.id' => $semester->id]);
		return view('Semester::semester_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Semester $semester)
	{
		$data['semester'] = $semester;

		
		$data['forms'] = array(
			'semester' => ['Semester', Form::text("semester", $semester->semester, ["class" => "form-control","placeholder" => "", "id" => "semester"]) ],
			'tgl_mulai' => ['Tgl Mulai', Form::date("tgl_mulai", $semester->tgl_mulai, ["class" => "form-control", "id" => "tgl_mulai"]) ],
			'tgl_selesai' => ['Tgl Selesai', Form::date("tgl_selesai", $semester->tgl_selesai, ["class" => "form-control", "id" => "tgl_selesai"]) ],
			'wkt_kelulusan' => ['Waktu Kelulusan', Form::datetimeLocal("wkt_kelulusan", $semester->wkt_kelulusan, ["class" => "form-control", "id" => "wkt_kelulusan"]) ],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", $semester->keterangan, ["class" => "form-control rich-editor"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$semester->what;
		$this->log($request, $text, ['semester.id' => $semester->id]);
		return view('Semester::semester_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'semester' => 'required',
			'tgl_mulai' => 'required',
			'tgl_selesai' => 'required',
			'keterangan' => 'required',
			'wkt_kelulusan' => 'required',
			
		]);
		
		$semester = Semester::find($id);
		$semester->semester = $request->input("semester");
		$semester->tgl_mulai = $request->input("tgl_mulai");
		$semester->tgl_selesai = $request->input("tgl_selesai");
		$semester->keterangan = $request->input("keterangan");
		$semester->wkt_kelulusan = $request->input("wkt_kelulusan");
		
		$semester->updated_by = Auth::id();
		$semester->save();


		$text = 'mengedit '.$this->title;//.' '.$semester->what;
		$this->log($request, $text, ['semester.id' => $semester->id]);
		return redirect()->route('semester.index')->with('message_success', 'Semester berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$semester = Semester::find($id);
		$semester->deleted_by = Auth::id();
		$semester->save();
		$semester->delete();

		$text = 'menghapus '.$this->title;//.' '.$semester->what;
		$this->log($request, $text, ['semester.id' => $semester->id]);
		return back()->with('message_success', 'Semester berhasil dihapus!');
	}

}
