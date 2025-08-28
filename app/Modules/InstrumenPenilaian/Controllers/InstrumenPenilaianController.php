<?php
namespace App\Modules\InstrumenPenilaian\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\InstrumenPenilaian\Models\InstrumenPenilaian;
use App\Modules\Semester\Models\Semester;
use App\Modules\Guru\Models\Guru;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Kelas\Models\Kelas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InstrumenPenilaianController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Instrumen Penilaian";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = InstrumenPenilaian::query()->whereIdGuru(session('id_guru'));
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('InstrumenPenilaian::instrumenpenilaian', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_semester = Semester::all()->pluck('semester','id');
		$ref_guru = Guru::all()->pluck('nama','id');
		$ref_mapel = Mapel::all()->pluck('mapel','id');
		$ref_kelas = Kelas::all()->pluck('kelas','id');
		
		$data['forms'] = array(
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"]) ],
			'id_kelas' => ['Kelas', Form::select("id_kelas", $ref_kelas, null, ["class" => "form-control select2"]) ],
			'instrumen' => ['Instrumen', Form::file("instrumen", ["class" => "form-control"]) ],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", old("keterangan"), ["class" => "form-control rich-editor"]) ],
			'id_semester' => ['', Form::hidden("id_semester", get_semester('active_semester_id'), null) ],
			'id_guru' => ['', Form::hidden("id_guru", session('id_guru'), null) ],
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('InstrumenPenilaian::instrumenpenilaian_create', array_merge($data, ['title' => $this->title]));
	}

	public function store(Request $request)
	{
		$request->validate([
            'instrumen' => 'required|mimes:pdf,doc,docx|max:10240',
			'id_semester' => 'required',
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_kelas' => 'required',
			'instrumen' => 'required'
        ]);

		$fileName = time().'.'.$request->instrumen->extension();  

        $request->instrumen->move(public_path('uploads/instrumen/'), $fileName);

		$instrumenpenilaian = new InstrumenPenilaian();
		$instrumenpenilaian->id_semester = $request->input("id_semester");
		$instrumenpenilaian->id_guru = $request->input("id_guru");
		$instrumenpenilaian->id_mapel = $request->input("id_mapel");
		$instrumenpenilaian->id_kelas = $request->input("id_kelas");
		$instrumenpenilaian->instrumen = $fileName;
		$instrumenpenilaian->keterangan = $request->input("keterangan");
		
		$instrumenpenilaian->created_by = Auth::id();
		$instrumenpenilaian->save();

		$text = 'membuat '.$this->title; //' baru '.$instrumenpenilaian->what;
		$this->log($request, $text, ['instrumenpenilaian.id' => $instrumenpenilaian->id]);
		return redirect()->route('instrumenpenilaian.index')->with('message_success', 'Instrumen Penilaian berhasil ditambahkan!');

		
	}

	function stores(Request $request)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_kelas' => 'required',
			'instrumen' => 'required',
			'keterangan' => 'required',
			
		]);

		$instrumenpenilaian = new InstrumenPenilaian();
		$instrumenpenilaian->id_semester = $request->input("id_semester");
		$instrumenpenilaian->id_guru = $request->input("id_guru");
		$instrumenpenilaian->id_mapel = $request->input("id_mapel");
		$instrumenpenilaian->id_kelas = $request->input("id_kelas");
		$instrumenpenilaian->instrumen = $request->input("instrumen");
		$instrumenpenilaian->keterangan = $request->input("keterangan");
		
		$instrumenpenilaian->created_by = Auth::id();
		$instrumenpenilaian->save();

		$text = 'membuat '.$this->title; //' baru '.$instrumenpenilaian->what;
		$this->log($request, $text, ['instrumenpenilaian.id' => $instrumenpenilaian->id]);
		return redirect()->route('instrumenpenilaian.index')->with('message_success', 'Instrumen Penilaian berhasil ditambahkan!');
	}

	public function show(Request $request, InstrumenPenilaian $instrumenpenilaian)
	{
		$data['instrumenpenilaian'] = $instrumenpenilaian;

		$text = 'melihat detail '.$this->title;//.' '.$instrumenpenilaian->what;
		$this->log($request, $text, ['instrumenpenilaian.id' => $instrumenpenilaian->id]);
		return view('InstrumenPenilaian::instrumenpenilaian_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, InstrumenPenilaian $instrumenpenilaian)
	{
		$data['instrumenpenilaian'] = $instrumenpenilaian;

		$ref_semester = Semester::all()->pluck('semester','id');
		$ref_guru = Guru::all()->pluck('nama','id');
		$ref_mapel = Mapel::all()->pluck('mapel','id');
		$ref_kelas = Kelas::all()->pluck('kelas','id');
		
		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"]) ],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"]) ],
			'id_kelas' => ['Kelas', Form::select("id_kelas", $ref_kelas, null, ["class" => "form-control select2"]) ],
			'instrumen' => ['Instrumen', Form::text("instrumen", $instrumenpenilaian->instrumen, ["class" => "form-control","placeholder" => "", "id" => "instrumen"]) ],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", $instrumenpenilaian->keterangan, ["class" => "form-control rich-editor"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$instrumenpenilaian->what;
		$this->log($request, $text, ['instrumenpenilaian.id' => $instrumenpenilaian->id]);
		return view('InstrumenPenilaian::instrumenpenilaian_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_guru' => 'required',
			'id_mapel' => 'required',
			'id_kelas' => 'required',
			'instrumen' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$instrumenpenilaian = InstrumenPenilaian::find($id);
		$instrumenpenilaian->id_semester = $request->input("id_semester");
		$instrumenpenilaian->id_guru = $request->input("id_guru");
		$instrumenpenilaian->id_mapel = $request->input("id_mapel");
		$instrumenpenilaian->id_kelas = $request->input("id_kelas");
		$instrumenpenilaian->instrumen = $request->input("instrumen");
		$instrumenpenilaian->keterangan = $request->input("keterangan");
		
		$instrumenpenilaian->updated_by = Auth::id();
		$instrumenpenilaian->save();


		$text = 'mengedit '.$this->title;//.' '.$instrumenpenilaian->what;
		$this->log($request, $text, ['instrumenpenilaian.id' => $instrumenpenilaian->id]);
		return redirect()->route('instrumenpenilaian.index')->with('message_success', 'Instrumen Penilaian berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$instrumenpenilaian = InstrumenPenilaian::find($id);
		$instrumenpenilaian->deleted_by = Auth::id();
		$instrumenpenilaian->save();
		$instrumenpenilaian->delete();

		$text = 'menghapus '.$this->title;//.' '.$instrumenpenilaian->what;
		$this->log($request, $text, ['instrumenpenilaian.id' => $instrumenpenilaian->id]);
		return back()->with('message_success', 'Instrumen Penilaian berhasil dihapus!');
	}

}
