<?php
namespace App\Modules\TingkatJuara\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\TingkatJuara\Models\TingkatJuara;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TingkatJuaraController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Tingkat Juara";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = TingkatJuara::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('TingkatJuara::tingkatjuara', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'tingkat_juara' => ['Tingkat Juara', Form::text("tingkat_juara", old("tingkat_juara"), ["class" => "form-control","placeholder" => ""]) ],
			'urutan' => ['Urutan', Form::text("urutan", old("urutan"), ["class" => "form-control","placeholder" => "n"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('TingkatJuara::tingkatjuara_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'tingkat_juara' => 'required',
			'urutan' => 'required',
			
		]);

		$tingkatjuara = new TingkatJuara();
		$tingkatjuara->tingkat_juara = $request->input("tingkat_juara");
		$tingkatjuara->urutan = $request->input("urutan");
		
		$tingkatjuara->created_by = Auth::id();
		$tingkatjuara->save();

		$text = 'membuat '.$this->title; //' baru '.$tingkatjuara->what;
		$this->log($request, $text, ['tingkatjuara.id' => $tingkatjuara->id]);
		return redirect()->route('tingkatjuara.index')->with('message_success', 'Tingkat Juara berhasil ditambahkan!');
	}

	public function show(Request $request, TingkatJuara $tingkatjuara)
	{
		$data['tingkatjuara'] = $tingkatjuara;

		$text = 'melihat detail '.$this->title;//.' '.$tingkatjuara->what;
		$this->log($request, $text, ['tingkatjuara.id' => $tingkatjuara->id]);
		return view('TingkatJuara::tingkatjuara_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, TingkatJuara $tingkatjuara)
	{
		$data['tingkatjuara'] = $tingkatjuara;

		
		$data['forms'] = array(
			'tingkat_juara' => ['Tingkat Juara', Form::text("tingkat_juara", $tingkatjuara->tingkat_juara, ["class" => "form-control","placeholder" => "", "id" => "tingkat_juara"]) ],
			'urutan' => ['Urutan', Form::text("urutan", $tingkatjuara->urutan, ["class" => "form-control","placeholder" => "n", "id" => "urutan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$tingkatjuara->what;
		$this->log($request, $text, ['tingkatjuara.id' => $tingkatjuara->id]);
		return view('TingkatJuara::tingkatjuara_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'tingkat_juara' => 'required',
			'urutan' => 'required',
			
		]);
		
		$tingkatjuara = TingkatJuara::find($id);
		$tingkatjuara->tingkat_juara = $request->input("tingkat_juara");
		$tingkatjuara->urutan = $request->input("urutan");
		
		$tingkatjuara->updated_by = Auth::id();
		$tingkatjuara->save();


		$text = 'mengedit '.$this->title;//.' '.$tingkatjuara->what;
		$this->log($request, $text, ['tingkatjuara.id' => $tingkatjuara->id]);
		return redirect()->route('tingkatjuara.index')->with('message_success', 'Tingkat Juara berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$tingkatjuara = TingkatJuara::find($id);
		$tingkatjuara->deleted_by = Auth::id();
		$tingkatjuara->save();
		$tingkatjuara->delete();

		$text = 'menghapus '.$this->title;//.' '.$tingkatjuara->what;
		$this->log($request, $text, ['tingkatjuara.id' => $tingkatjuara->id]);
		return back()->with('message_success', 'Tingkat Juara berhasil dihapus!');
	}

}
