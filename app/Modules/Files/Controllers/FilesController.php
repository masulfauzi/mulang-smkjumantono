<?php
namespace App\Modules\Files\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Files\Models\Files;
use App\Modules\JenisFile\Models\JenisFile;

use Form;

class FilesController extends Controller
{
	protected $title = "Files";
	public function index(Request $request)
	{
		$query = Files::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();
		return view('Files::files', array_merge($data, ['title' => $this->title]));
	}

	public function create()
	{
		$ref_jenis_file = JenisFile::all()->pluck('nama','id');
		
		$data['forms'] = array(
			'table_name' => ['Table Name', Form::text("table_name", old("table_name"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'table_id' => ['Table Id', Form::text("table_id", old("table_id"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'id_jenis' => ['Jenis', Form::select("id_jenis", $ref_jenis_file, null, ["class" => "form-control select2"]) ],
			'nama_file' => ['Nama File', Form::text("nama_file", old("nama_file"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'path_file' => ['Path File', Form::text("path_file", old("path_file"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'file_size' => ['File Size', Form::text("file_size", old("file_size"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'file_type' => ['File Type', Form::text("file_type", old("file_type"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			
		);
		return view('Files::files_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'table_name' => 'required',
			'table_id' => 'required',
			'id_jenis' => 'required',
			'nama_file' => 'required',
			'path_file' => 'required',
			'file_size' => 'required',
			'file_type' => 'required',
			
		]);

		$files = new Files();
		$files->table_name = $request->input("table_name");
		$files->table_id = $request->input("table_id");
		$files->id_jenis = $request->input("id_jenis");
		$files->nama_file = $request->input("nama_file");
		$files->path_file = $request->input("path_file");
		$files->file_size = $request->input("file_size");
		$files->file_type = $request->input("file_type");
		
		$files->created_by = Auth::id();
		$files->save();

		return redirect()->route('files.index')->with('message_success', 'Files berhasil ditambahkan!');
	}

	public function show(Files $files)
	{
		$data['files'] = $files;

		return view('Files::files_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Files $files)
	{
		$data['files'] = $files;

		$ref_jenis_file = JenisFile::all()->pluck('nama','id');
		
		$data['forms'] = array(
			'table_name' => ['Table Name', Form::text("table_name", $files->table_name, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "table_name"]) ],
			'table_id' => ['Table Id', Form::text("table_id", $files->table_id, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "table_id"]) ],
			'id_jenis' => ['Jenis', Form::select("id_jenis", $ref_jenis_file, null, ["class" => "form-control select2"]) ],
			'nama_file' => ['Nama File', Form::text("nama_file", $files->nama_file, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama_file"]) ],
			'path_file' => ['Path File', Form::text("path_file", $files->path_file, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "path_file"]) ],
			'file_size' => ['File Size', Form::text("file_size", $files->file_size, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "file_size"]) ],
			'file_type' => ['File Type', Form::text("file_type", $files->file_type, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "file_type"]) ],
			
		);

		return view('Files::files_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'table_name' => 'required',
			'table_id' => 'required',
			'id_jenis' => 'required',
			'nama_file' => 'required',
			'path_file' => 'required',
			'file_size' => 'required',
			'file_type' => 'required',
			
		]);
		
		$files = Files::find($id);
		$files->table_name = $request->input("table_name");
		$files->table_id = $request->input("table_id");
		$files->id_jenis = $request->input("id_jenis");
		$files->nama_file = $request->input("nama_file");
		$files->path_file = $request->input("path_file");
		$files->file_size = $request->input("file_size");
		$files->file_type = $request->input("file_type");
		
		$files->updated_by = Auth::id();
		$files->save();

		return redirect()->route('files.index')->with('message_success', 'Files berhasil diubah!');
	}

	public function destroy($id)
	{
		$files = Files::find($id);
		$files->deleted_by = Auth::id();
		$files->save();
		$files->delete();

		return back()->with('message_success', 'Files berhasil dihapus!');
	}

}
