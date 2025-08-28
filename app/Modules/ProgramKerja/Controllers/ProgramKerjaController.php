<?php
namespace App\Modules\ProgramKerja\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\ProgramKerja\Models\ProgramKerja;
use App\Modules\Semester\Models\Semester;
use App\Modules\Guru\Models\Guru;
use App\Modules\UnitKerja\Models\UnitKerja;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProgramKerjaController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Program Kerja";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		
		$data['data'] = UnitKerja::whereNull('induk')->get();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('ProgramKerja::programkerja_unit', array_merge($data, ['title' => $this->title]));
	}

	public function upload(Request $request, $id_unit)
	{
		$data['unitkerja'] = UnitKerja::find($id_unit);
		$data['data'] = ProgramKerja::whereIdUnitKerja($id_unit)->get();

		$data['forms'] = array(
			'nama_file' => ['Nama File', Form::text("nama_file", old("file"), ["class" => "form-control","placeholder" => ""]) ],
			'file' => ['File', Form::file("file", ["class" => "form-control","placeholder" => ""]) ],
			'id_semester' => ['', Form::hidden("id_semester", session()->get('active_semester')['id'], null, ["class" => "form-control select2"]) ],
			'id_guru' => ['', Form::hidden("id_guru", session()->get('id_guru'), null, ["class" => "form-control select2"]) ],
			'id_unit_kerja' => ['', Form::hidden("id_unit_kerja", $id_unit, null, ["class" => "form-control select2"]) ],
			
		);

		$this->log($request, 'melihat halaman upload program kerja '.$this->title);
		return view('ProgramKerja::programkerja_upload', array_merge($data, ['title' => $this->title]));
	}

	public function show_child(Request $request, $id_unit)
	{
		$data['data'] = UnitKerja::whereInduk($id_unit)->get();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('ProgramKerja::programkerja_unit', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_semester = Semester::all()->pluck('semester','id');
		$ref_guru = Guru::all()->pluck('nama','id');
		$ref_unit_kerja = UnitKerja::all()->pluck('unit_kerja','id');
		
		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"]) ],
			'file' => ['File', Form::text("file", old("file"), ["class" => "form-control","placeholder" => ""]) ],
			'id_unit_kerja' => ['Unit Kerja', Form::select("id_unit_kerja", $ref_unit_kerja, null, ["class" => "form-control select2"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('ProgramKerja::programkerja_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_guru' => 'required',
			'id_unit_kerja' => 'required',
			'nama_file' => 'required',
			'file' => 'required|mimes:pdf,jpg,jpeg,png,doc,docx,ppt,pptx|max:10240',
		]);

		$fileName = time().'.'.$request->file->extension();  

        $request->file->move(public_path('uploads/program_kerja/'), $fileName);

		$programkerja = new ProgramKerja();
		$programkerja->id_semester = $request->input("id_semester");
		$programkerja->nama_file = $request->input("nama_file");
		$programkerja->id_guru = $request->input("id_guru");
		$programkerja->file = $fileName;
		$programkerja->id_unit_kerja = $request->input("id_unit_kerja");
		
		$programkerja->created_by = Auth::id();
		$programkerja->save();

		$text = 'membuat '.$this->title; //' baru '.$programkerja->what;
		$this->log($request, $text, ['programkerja.id' => $programkerja->id]);
		return redirect()->back()->with('message_success', 'Program Kerja berhasil ditambahkan!');
	}

	public function show(Request $request, ProgramKerja $programkerja)
	{
		$data['programkerja'] = $programkerja;

		$text = 'melihat detail '.$this->title;//.' '.$programkerja->what;
		$this->log($request, $text, ['programkerja.id' => $programkerja->id]);
		return view('ProgramKerja::programkerja_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, ProgramKerja $programkerja)
	{
		$data['programkerja'] = $programkerja;

		$ref_semester = Semester::all()->pluck('semester','id');
		$ref_guru = Guru::all()->pluck('nama','id');
		$ref_unit_kerja = UnitKerja::all()->pluck('unit_kerja','id');
		
		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"]) ],
			'file' => ['File', Form::text("file", $programkerja->file, ["class" => "form-control","placeholder" => "", "id" => "file"]) ],
			'id_unit_kerja' => ['Unit Kerja', Form::select("id_unit_kerja", $ref_unit_kerja, null, ["class" => "form-control select2"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$programkerja->what;
		$this->log($request, $text, ['programkerja.id' => $programkerja->id]);
		return view('ProgramKerja::programkerja_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_guru' => 'required',
			'file' => 'required',
			'id_unit_kerja' => 'required',
			
		]);
		
		$programkerja = ProgramKerja::find($id);
		$programkerja->id_semester = $request->input("id_semester");
		$programkerja->id_guru = $request->input("id_guru");
		$programkerja->file = $request->input("file");
		$programkerja->id_unit_kerja = $request->input("id_unit_kerja");
		
		$programkerja->updated_by = Auth::id();
		$programkerja->save();


		$text = 'mengedit '.$this->title;//.' '.$programkerja->what;
		$this->log($request, $text, ['programkerja.id' => $programkerja->id]);
		return redirect()->route('programkerja.index')->with('message_success', 'Program Kerja berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$programkerja = ProgramKerja::find($id);
		$programkerja->deleted_by = Auth::id();
		$programkerja->save();
		$programkerja->delete();

		$text = 'menghapus '.$this->title;//.' '.$programkerja->what;
		$this->log($request, $text, ['programkerja.id' => $programkerja->id]);
		return back()->with('message_success', 'Program Kerja berhasil dihapus!');
	}

}
