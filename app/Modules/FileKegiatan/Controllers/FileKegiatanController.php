<?php
namespace App\Modules\FileKegiatan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\FileKegiatan\Models\FileKegiatan;
use App\Modules\Kegiatan\Models\Kegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FileKegiatanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "File Kegiatan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = FileKegiatan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('FileKegiatan::filekegiatan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request, $id_kegiatan)
	{
		$data['kegiatan'] = Kegiatan::find($id_kegiatan);
		$query = FileKegiatan::query()->whereIdKegiatan($id_kegiatan)->orderBy('nama_file');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();
		
		$data['forms'] = array(
			'id_kegiatan' => ['', Form::hidden("id_kegiatan", $id_kegiatan) ],
			// 'nama_file' => ['Nama File', Form::text("nama_file", old('nama_file'), ["class" => "form-control"]) ],
			'file' => ['File', Form::file("file[]", ["class" => "form-control", "multiple"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('FileKegiatan::filekegiatan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$request->validate([
            'file' => 'required',
            'file.*' => 'required|mimes:pdf,doc,docx|max:10240'
        ]);

        if ($request->file('file')){

            foreach($request->file('file') as $key => $file)
            {
                $fileName = time() . $file->extension();
				$nama_file = $file->getClientOriginalName();  

                $file->move(public_path('uploads/kegiatan/'), $fileName);

				$filekegiatan = new FileKegiatan();
				$filekegiatan->id_kegiatan = $request->input("id_kegiatan");
				$filekegiatan->nama_file = $nama_file;
				$filekegiatan->file = $fileName;
				
				$filekegiatan->created_by = Auth::id();
				$filekegiatan->save();

				
            }

        }

		$text = 'membuat '.$this->title; //' baru '.$filekegiatan->what;
		$this->log($request, $text, ['filekegiatan.id' => $filekegiatan->id]);
		return redirect()->route('filekegiatan.create', $request->input("id_kegiatan"))->with('message_success', 'File Kegiatan berhasil ditambahkan!');
	}

	function store2(Request $request)
	{
		// dd($request);
		$this->validate($request, [
			'id_kegiatan' => 'required',
			'file' => 'required|mimes:pdf,doc,docx|max:10240'
			
		]);

		$fileName = time().'.'.$request->file->extension();  

        $request->file->move(public_path('uploads/kegiatan/'), $fileName);

		$filekegiatan = new FileKegiatan();
		$filekegiatan->id_kegiatan = $request->input("id_kegiatan");
		$filekegiatan->nama_file = $request->input("nama_file");
		$filekegiatan->file = $fileName;
		
		$filekegiatan->created_by = Auth::id();
		$filekegiatan->save();

		$text = 'membuat '.$this->title; //' baru '.$filekegiatan->what;
		$this->log($request, $text, ['filekegiatan.id' => $filekegiatan->id]);
		return redirect()->route('filekegiatan.create', $request->input("id_kegiatan"))->with('message_success', 'File Kegiatan berhasil ditambahkan!');
	}

	public function show(Request $request, FileKegiatan $filekegiatan)
	{
		$data['filekegiatan'] = $filekegiatan;

		$text = 'melihat detail '.$this->title;//.' '.$filekegiatan->what;
		$this->log($request, $text, ['filekegiatan.id' => $filekegiatan->id]);
		return view('FileKegiatan::filekegiatan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, FileKegiatan $filekegiatan)
	{
		$data['filekegiatan'] = $filekegiatan;

		$ref_kegiatan = Kegiatan::all()->pluck('kegiatan','id');
		
		$data['forms'] = array(
			'id_kegiatan' => ['Kegiatan', Form::select("id_kegiatan", $ref_kegiatan, null, ["class" => "form-control select2"]) ],
			'file' => ['File', Form::text("file", $filekegiatan->file, ["class" => "form-control","placeholder" => "", "id" => "file"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$filekegiatan->what;
		$this->log($request, $text, ['filekegiatan.id' => $filekegiatan->id]);
		return view('FileKegiatan::filekegiatan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_kegiatan' => 'required',
			'file' => 'required',
			
		]);
		
		$filekegiatan = FileKegiatan::find($id);
		$filekegiatan->id_kegiatan = $request->input("id_kegiatan");
		$filekegiatan->file = $request->input("file");
		
		$filekegiatan->updated_by = Auth::id();
		$filekegiatan->save();


		$text = 'mengedit '.$this->title;//.' '.$filekegiatan->what;
		$this->log($request, $text, ['filekegiatan.id' => $filekegiatan->id]);
		return redirect()->route('filekegiatan.index')->with('message_success', 'File Kegiatan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$filekegiatan = FileKegiatan::find($id);
		$filekegiatan->deleted_by = Auth::id();
		$filekegiatan->save();
		$filekegiatan->delete();

		$text = 'menghapus '.$this->title;//.' '.$filekegiatan->what;
		$this->log($request, $text, ['filekegiatan.id' => $filekegiatan->id]);
		return back()->with('message_success', 'File Kegiatan berhasil dihapus!');
	}

}
