<?php
namespace App\Modules\FilePesan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\FilePesan\Models\FilePesan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FilePesanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "File Pesan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = FilePesan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('FilePesan::filepesan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'nama_file' => ['Nama File', Form::text("nama_file", old("nama_file"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('FilePesan::filepesan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama_file' => 'required',
			
		]);

		$filepesan = new FilePesan();
		$filepesan->nama_file = $request->input("nama_file");
		
		$filepesan->created_by = Auth::id();
		$filepesan->save();

		$text = 'membuat '.$this->title; //' baru '.$filepesan->what;
		$this->log($request, $text, ['filepesan.id' => $filepesan->id]);
		return redirect()->route('filepesan.index')->with('message_success', 'File Pesan berhasil ditambahkan!');
	}

	public function show(Request $request, FilePesan $filepesan)
	{
		$data['filepesan'] = $filepesan;

		$text = 'melihat detail '.$this->title;//.' '.$filepesan->what;
		$this->log($request, $text, ['filepesan.id' => $filepesan->id]);
		return view('FilePesan::filepesan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, FilePesan $filepesan)
	{
		$data['filepesan'] = $filepesan;

		
		$data['forms'] = array(
			'nama_file' => ['Nama File', Form::text("nama_file", $filepesan->nama_file, ["class" => "form-control","placeholder" => "", "id" => "nama_file"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$filepesan->what;
		$this->log($request, $text, ['filepesan.id' => $filepesan->id]);
		return view('FilePesan::filepesan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_file' => 'required',
			
		]);
		
		$filepesan = FilePesan::find($id);
		$filepesan->nama_file = $request->input("nama_file");
		
		$filepesan->updated_by = Auth::id();
		$filepesan->save();


		$text = 'mengedit '.$this->title;//.' '.$filepesan->what;
		$this->log($request, $text, ['filepesan.id' => $filepesan->id]);
		return redirect()->route('filepesan.index')->with('message_success', 'File Pesan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$filepesan = FilePesan::find($id);
		$filepesan->deleted_by = Auth::id();
		$filepesan->save();
		$filepesan->delete();

		$text = 'menghapus '.$this->title;//.' '.$filepesan->what;
		$this->log($request, $text, ['filepesan.id' => $filepesan->id]);
		return back()->with('message_success', 'File Pesan berhasil dihapus!');
	}

}
