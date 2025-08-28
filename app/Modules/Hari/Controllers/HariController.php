<?php
namespace App\Modules\Hari\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Hari\Models\Hari;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HariController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Hari";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Hari::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Hari::hari', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'hari' => ['Hari', Form::text("hari", old("hari"), ["class" => "form-control","placeholder" => ""]) ],
			'urutan' => ['Urutan', Form::text("urutan", old("urutan"), ["class" => "form-control","placeholder" => "n"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Hari::hari_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'hari' => 'required',
			'urutan' => 'required',
			
		]);

		$hari = new Hari();
		$hari->hari = $request->input("hari");
		$hari->urutan = $request->input("urutan");
		
		$hari->created_by = Auth::id();
		$hari->save();

		$text = 'membuat '.$this->title; //' baru '.$hari->what;
		$this->log($request, $text, ['hari.id' => $hari->id]);
		return redirect()->route('hari.index')->with('message_success', 'Hari berhasil ditambahkan!');
	}

	public function show(Request $request, Hari $hari)
	{
		$data['hari'] = $hari;

		$text = 'melihat detail '.$this->title;//.' '.$hari->what;
		$this->log($request, $text, ['hari.id' => $hari->id]);
		return view('Hari::hari_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Hari $hari)
	{
		$data['hari'] = $hari;

		
		$data['forms'] = array(
			'hari' => ['Hari', Form::text("hari", $hari->hari, ["class" => "form-control","placeholder" => "", "id" => "hari"]) ],
			'urutan' => ['Urutan', Form::text("urutan", $hari->urutan, ["class" => "form-control","placeholder" => "n", "id" => "urutan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$hari->what;
		$this->log($request, $text, ['hari.id' => $hari->id]);
		return view('Hari::hari_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'hari' => 'required',
			'urutan' => 'required',
			
		]);
		
		$hari = Hari::find($id);
		$hari->hari = $request->input("hari");
		$hari->urutan = $request->input("urutan");
		
		$hari->updated_by = Auth::id();
		$hari->save();


		$text = 'mengedit '.$this->title;//.' '.$hari->what;
		$this->log($request, $text, ['hari.id' => $hari->id]);
		return redirect()->route('hari.index')->with('message_success', 'Hari berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$hari = Hari::find($id);
		$hari->deleted_by = Auth::id();
		$hari->save();
		$hari->delete();

		$text = 'menghapus '.$this->title;//.' '.$hari->what;
		$this->log($request, $text, ['hari.id' => $hari->id]);
		return back()->with('message_success', 'Hari berhasil dihapus!');
	}

}
