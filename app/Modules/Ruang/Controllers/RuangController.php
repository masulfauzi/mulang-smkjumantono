<?php
namespace App\Modules\Ruang\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Ruang\Models\Ruang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RuangController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Ruang";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Ruang::query()->orderBy('ruang');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Ruang::ruang', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'ruang' => ['Ruang', Form::text("ruang", old("ruang"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Ruang::ruang_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'ruang' => 'required',
			
		]);

		$ruang = new Ruang();
		$ruang->ruang = $request->input("ruang");
		
		$ruang->created_by = Auth::id();
		$ruang->save();

		$text = 'membuat '.$this->title; //' baru '.$ruang->what;
		$this->log($request, $text, ['ruang.id' => $ruang->id]);
		return redirect()->route('ruang.index')->with('message_success', 'Ruang berhasil ditambahkan!');
	}

	public function show(Request $request, Ruang $ruang)
	{
		$data['ruang'] = $ruang;

		$text = 'melihat detail '.$this->title;//.' '.$ruang->what;
		$this->log($request, $text, ['ruang.id' => $ruang->id]);
		return view('Ruang::ruang_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Ruang $ruang)
	{
		$data['ruang'] = $ruang;

		
		$data['forms'] = array(
			'ruang' => ['Ruang', Form::text("ruang", $ruang->ruang, ["class" => "form-control","placeholder" => "", "id" => "ruang"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$ruang->what;
		$this->log($request, $text, ['ruang.id' => $ruang->id]);
		return view('Ruang::ruang_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'ruang' => 'required',
			
		]);
		
		$ruang = Ruang::find($id);
		$ruang->ruang = $request->input("ruang");
		
		$ruang->updated_by = Auth::id();
		$ruang->save();


		$text = 'mengedit '.$this->title;//.' '.$ruang->what;
		$this->log($request, $text, ['ruang.id' => $ruang->id]);
		return redirect()->route('ruang.index')->with('message_success', 'Ruang berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$ruang = Ruang::find($id);
		$ruang->deleted_by = Auth::id();
		$ruang->save();
		$ruang->delete();

		$text = 'menghapus '.$this->title;//.' '.$ruang->what;
		$this->log($request, $text, ['ruang.id' => $ruang->id]);
		return back()->with('message_success', 'Ruang berhasil dihapus!');
	}

}
