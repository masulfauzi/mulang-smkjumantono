<?php
namespace App\Modules\BagianTu\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\BagianTu\Models\BagianTu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BagianTuController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Bagian Tu";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = BagianTu::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('BagianTu::bagiantu', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'bagian' => ['Bagian', Form::text("bagian", old("bagian"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('BagianTu::bagiantu_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'bagian' => 'required',
			
		]);

		$bagiantu = new BagianTu();
		$bagiantu->bagian = $request->input("bagian");
		
		$bagiantu->created_by = Auth::id();
		$bagiantu->save();

		$text = 'membuat '.$this->title; //' baru '.$bagiantu->what;
		$this->log($request, $text, ['bagiantu.id' => $bagiantu->id]);
		return redirect()->route('bagiantu.index')->with('message_success', 'Bagian Tu berhasil ditambahkan!');
	}

	public function show(Request $request, BagianTu $bagiantu)
	{
		$data['bagiantu'] = $bagiantu;

		$text = 'melihat detail '.$this->title;//.' '.$bagiantu->what;
		$this->log($request, $text, ['bagiantu.id' => $bagiantu->id]);
		return view('BagianTu::bagiantu_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, BagianTu $bagiantu)
	{
		$data['bagiantu'] = $bagiantu;

		
		$data['forms'] = array(
			'bagian' => ['Bagian', Form::text("bagian", $bagiantu->bagian, ["class" => "form-control","placeholder" => "", "id" => "bagian"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$bagiantu->what;
		$this->log($request, $text, ['bagiantu.id' => $bagiantu->id]);
		return view('BagianTu::bagiantu_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'bagian' => 'required',
			
		]);
		
		$bagiantu = BagianTu::find($id);
		$bagiantu->bagian = $request->input("bagian");
		
		$bagiantu->updated_by = Auth::id();
		$bagiantu->save();


		$text = 'mengedit '.$this->title;//.' '.$bagiantu->what;
		$this->log($request, $text, ['bagiantu.id' => $bagiantu->id]);
		return redirect()->route('bagiantu.index')->with('message_success', 'Bagian Tu berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$bagiantu = BagianTu::find($id);
		$bagiantu->deleted_by = Auth::id();
		$bagiantu->save();
		$bagiantu->delete();

		$text = 'menghapus '.$this->title;//.' '.$bagiantu->what;
		$this->log($request, $text, ['bagiantu.id' => $bagiantu->id]);
		return back()->with('message_success', 'Bagian Tu berhasil dihapus!');
	}

}
