<?php
namespace App\Modules\Agama\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Agama\Models\Agama;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AgamaController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Agama";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Agama::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Agama::agama', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'agama' => ['Agama', Form::text("agama", old("agama"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", old("keterangan"), ["class" => "form-control rich-editor"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Agama::agama_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'agama' => 'required',
			'keterangan' => 'required',
			
		]);

		$agama = new Agama();
		$agama->agama = $request->input("agama");
		$agama->keterangan = $request->input("keterangan");
		
		$agama->created_by = Auth::id();
		$agama->save();

		$text = 'membuat '.$this->title; //' baru '.$agama->what;
		$this->log($request, $text, ['agama.id' => $agama->id]);
		return redirect()->route('agama.index')->with('message_success', 'Agama berhasil ditambahkan!');
	}

	public function show(Request $request, Agama $agama)
	{
		$data['agama'] = $agama;

		$text = 'melihat detail '.$this->title;//.' '.$agama->what;
		$this->log($request, $text, ['agama.id' => $agama->id]);
		return view('Agama::agama_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Agama $agama)
	{
		$data['agama'] = $agama;

		
		$data['forms'] = array(
			'agama' => ['Agama', Form::text("agama", $agama->agama, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "agama"]) ],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", $agama->keterangan, ["class" => "form-control rich-editor"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$agama->what;
		$this->log($request, $text, ['agama.id' => $agama->id]);
		return view('Agama::agama_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'agama' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$agama = Agama::find($id);
		$agama->agama = $request->input("agama");
		$agama->keterangan = $request->input("keterangan");
		
		$agama->updated_by = Auth::id();
		$agama->save();


		$text = 'mengedit '.$this->title;//.' '.$agama->what;
		$this->log($request, $text, ['agama.id' => $agama->id]);
		return redirect()->route('agama.index')->with('message_success', 'Agama berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$agama = Agama::find($id);
		$agama->deleted_by = Auth::id();
		$agama->save();
		$agama->delete();

		$text = 'menghapus '.$this->title;//.' '.$agama->what;
		$this->log($request, $text, ['agama.id' => $agama->id]);
		return back()->with('message_success', 'Agama berhasil dihapus!');
	}

}
