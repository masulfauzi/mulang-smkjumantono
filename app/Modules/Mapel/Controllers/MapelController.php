<?php
namespace App\Modules\Mapel\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Mapel\Models\Mapel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Mapel";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Mapel::query();
		if($request->has('search')){
			$search = $request->get('search');
			$query->where('mapel', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Mapel::mapel', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'mapel' => ['Mapel', Form::text("mapel", old("mapel"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Mapel::mapel_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'mapel' => 'required',
			
		]);

		$mapel = new Mapel();
		$mapel->mapel = $request->input("mapel");
		
		$mapel->created_by = Auth::id();
		$mapel->save();

		$text = 'membuat '.$this->title; //' baru '.$mapel->what;
		$this->log($request, $text, ['mapel.id' => $mapel->id]);
		return redirect()->route('mapel.index')->with('message_success', 'Mapel berhasil ditambahkan!');
	}

	public function show(Request $request, Mapel $mapel)
	{
		$data['mapel'] = $mapel;

		$text = 'melihat detail '.$this->title;//.' '.$mapel->what;
		$this->log($request, $text, ['mapel.id' => $mapel->id]);
		return view('Mapel::mapel_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Mapel $mapel)
	{
		$data['mapel'] = $mapel;

		
		$data['forms'] = array(
			'mapel' => ['Mapel', Form::text("mapel", $mapel->mapel, ["class" => "form-control","placeholder" => "", "id" => "mapel"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$mapel->what;
		$this->log($request, $text, ['mapel.id' => $mapel->id]);
		return view('Mapel::mapel_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'mapel' => 'required',
			
		]);
		
		$mapel = Mapel::find($id);
		$mapel->mapel = $request->input("mapel");
		
		$mapel->updated_by = Auth::id();
		$mapel->save();


		$text = 'mengedit '.$this->title;//.' '.$mapel->what;
		$this->log($request, $text, ['mapel.id' => $mapel->id]);
		return redirect()->route('mapel.index')->with('message_success', 'Mapel berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$mapel = Mapel::find($id);
		$mapel->deleted_by = Auth::id();
		$mapel->save();
		$mapel->delete();

		$text = 'menghapus '.$this->title;//.' '.$mapel->what;
		$this->log($request, $text, ['mapel.id' => $mapel->id]);
		return back()->with('message_success', 'Mapel berhasil dihapus!');
	}

}
