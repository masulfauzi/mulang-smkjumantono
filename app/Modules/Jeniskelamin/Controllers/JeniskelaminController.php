<?php
namespace App\Modules\Jeniskelamin\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Jeniskelamin\Models\Jeniskelamin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JeniskelaminController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Jeniskelamin";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Jeniskelamin::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Jeniskelamin::jeniskelamin', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'jeniskelamin' => ['Jeniskelamin', Form::text("jeniskelamin", old("jeniskelamin"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Jeniskelamin::jeniskelamin_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'jeniskelamin' => 'required',
			
		]);

		$jeniskelamin = new Jeniskelamin();
		$jeniskelamin->jeniskelamin = $request->input("jeniskelamin");
		
		$jeniskelamin->created_by = Auth::id();
		$jeniskelamin->save();

		$text = 'membuat '.$this->title; //' baru '.$jeniskelamin->what;
		$this->log($request, $text, ['jeniskelamin.id' => $jeniskelamin->id]);
		return redirect()->route('jeniskelamin.index')->with('message_success', 'Jeniskelamin berhasil ditambahkan!');
	}

	public function show(Request $request, Jeniskelamin $jeniskelamin)
	{
		$data['jeniskelamin'] = $jeniskelamin;

		$text = 'melihat detail '.$this->title;//.' '.$jeniskelamin->what;
		$this->log($request, $text, ['jeniskelamin.id' => $jeniskelamin->id]);
		return view('Jeniskelamin::jeniskelamin_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Jeniskelamin $jeniskelamin)
	{
		$data['jeniskelamin'] = $jeniskelamin;

		
		$data['forms'] = array(
			'jeniskelamin' => ['Jeniskelamin', Form::text("jeniskelamin", $jeniskelamin->jeniskelamin, ["class" => "form-control","placeholder" => "", "id" => "jeniskelamin"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$jeniskelamin->what;
		$this->log($request, $text, ['jeniskelamin.id' => $jeniskelamin->id]);
		return view('Jeniskelamin::jeniskelamin_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'jeniskelamin' => 'required',
			
		]);
		
		$jeniskelamin = Jeniskelamin::find($id);
		$jeniskelamin->jeniskelamin = $request->input("jeniskelamin");
		
		$jeniskelamin->updated_by = Auth::id();
		$jeniskelamin->save();


		$text = 'mengedit '.$this->title;//.' '.$jeniskelamin->what;
		$this->log($request, $text, ['jeniskelamin.id' => $jeniskelamin->id]);
		return redirect()->route('jeniskelamin.index')->with('message_success', 'Jeniskelamin berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$jeniskelamin = Jeniskelamin::find($id);
		$jeniskelamin->deleted_by = Auth::id();
		$jeniskelamin->save();
		$jeniskelamin->delete();

		$text = 'menghapus '.$this->title;//.' '.$jeniskelamin->what;
		$this->log($request, $text, ['jeniskelamin.id' => $jeniskelamin->id]);
		return back()->with('message_success', 'Jeniskelamin berhasil dihapus!');
	}

}
