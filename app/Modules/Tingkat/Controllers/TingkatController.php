<?php
namespace App\Modules\Tingkat\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Tingkat\Models\Tingkat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TingkatController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Tingkat";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Tingkat::query()->orderBy('tingkat');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Tingkat::tingkat', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'tingkat' => ['Tingkat', Form::text("tingkat", old("tingkat"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Tingkat::tingkat_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'tingkat' => 'required',
			
		]);

		$tingkat = new Tingkat();
		$tingkat->tingkat = $request->input("tingkat");
		
		$tingkat->created_by = Auth::id();
		$tingkat->save();

		$text = 'membuat '.$this->title; //' baru '.$tingkat->what;
		$this->log($request, $text, ['tingkat.id' => $tingkat->id]);
		return redirect()->route('tingkat.index')->with('message_success', 'Tingkat berhasil ditambahkan!');
	}

	public function show(Request $request, Tingkat $tingkat)
	{
		$data['tingkat'] = $tingkat;

		$text = 'melihat detail '.$this->title;//.' '.$tingkat->what;
		$this->log($request, $text, ['tingkat.id' => $tingkat->id]);
		return view('Tingkat::tingkat_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Tingkat $tingkat)
	{
		$data['tingkat'] = $tingkat;

		
		$data['forms'] = array(
			'tingkat' => ['Tingkat', Form::text("tingkat", $tingkat->tingkat, ["class" => "form-control","placeholder" => "", "id" => "tingkat"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$tingkat->what;
		$this->log($request, $text, ['tingkat.id' => $tingkat->id]);
		return view('Tingkat::tingkat_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'tingkat' => 'required',
			
		]);
		
		$tingkat = Tingkat::find($id);
		$tingkat->tingkat = $request->input("tingkat");
		
		$tingkat->updated_by = Auth::id();
		$tingkat->save();


		$text = 'mengedit '.$this->title;//.' '.$tingkat->what;
		$this->log($request, $text, ['tingkat.id' => $tingkat->id]);
		return redirect()->route('tingkat.index')->with('message_success', 'Tingkat berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$tingkat = Tingkat::find($id);
		$tingkat->deleted_by = Auth::id();
		$tingkat->save();
		$tingkat->delete();

		$text = 'menghapus '.$this->title;//.' '.$tingkat->what;
		$this->log($request, $text, ['tingkat.id' => $tingkat->id]);
		return back()->with('message_success', 'Tingkat berhasil dihapus!');
	}

}
