<?php
namespace App\Modules\SkMengajar\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\SkMengajar\Models\SkMengajar;
use App\Modules\Semester\Models\Semester;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SkMengajarController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "SK Mengajar";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$data['allow'] = [
			'1fe8326c-22c4-4732-9c12-f7b83a16b842',
			'bf1548f3-295c-4d73-809d-66ab7c240091'
		];

		$query = SkMengajar::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('SkMengajar::skmengajar', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_semester = Semester::all()->pluck('semester','id');
		$ref_semester->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'nama' => ['Nama', Form::text("nama", old("nama"), ["class" => "form-control","placeholder" => ""]) ],
			'file' => ['File', Form::file("file", ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('SkMengajar::skmengajar_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'nama' => 'required',
			'file' => 'required|mimes:pdf,doc,docx|max:10240'
			
		]);

		$fileName = time().'.'.$request->file->extension();  

        $request->file->move(public_path('uploads/sk'), $fileName);

		$skmengajar = new SkMengajar();
		$skmengajar->id_semester = $request->input("id_semester");
		$skmengajar->nama = $request->input("nama");
		$skmengajar->file = $fileName;
		
		$skmengajar->created_by = Auth::id();
		$skmengajar->save();

		$text = 'membuat '.$this->title; //' baru '.$skmengajar->what;
		$this->log($request, $text, ['skmengajar.id' => $skmengajar->id]);
		return redirect()->route('skmengajar.index')->with('message_success', 'Sk Mengajar berhasil ditambahkan!');
	}

	public function show(Request $request, SkMengajar $skmengajar)
	{
		$data['skmengajar'] = $skmengajar;

		$text = 'melihat detail '.$this->title;//.' '.$skmengajar->what;
		$this->log($request, $text, ['skmengajar.id' => $skmengajar->id]);
		return view('SkMengajar::skmengajar_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, SkMengajar $skmengajar)
	{
		$data['skmengajar'] = $skmengajar;

		$ref_semester = Semester::all()->pluck('semester','id');
		
		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'nama' => ['Nama', Form::text("nama", $skmengajar->nama, ["class" => "form-control","placeholder" => "", "id" => "nama"]) ],
			'file' => ['File', Form::text("file", $skmengajar->file, ["class" => "form-control","placeholder" => "", "id" => "file"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$skmengajar->what;
		$this->log($request, $text, ['skmengajar.id' => $skmengajar->id]);
		return view('SkMengajar::skmengajar_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'nama' => 'required',
			'file' => 'required',
			
		]);
		
		$skmengajar = SkMengajar::find($id);
		$skmengajar->id_semester = $request->input("id_semester");
		$skmengajar->nama = $request->input("nama");
		$skmengajar->file = $request->input("file");
		
		$skmengajar->updated_by = Auth::id();
		$skmengajar->save();


		$text = 'mengedit '.$this->title;//.' '.$skmengajar->what;
		$this->log($request, $text, ['skmengajar.id' => $skmengajar->id]);
		return redirect()->route('skmengajar.index')->with('message_success', 'Sk Mengajar berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$skmengajar = SkMengajar::find($id);
		$skmengajar->deleted_by = Auth::id();
		$skmengajar->save();
		$skmengajar->delete();

		$text = 'menghapus '.$this->title;//.' '.$skmengajar->what;
		$this->log($request, $text, ['skmengajar.id' => $skmengajar->id]);
		return back()->with('message_success', 'Sk Mengajar berhasil dihapus!');
	}

}
