<?php
namespace App\Modules\Kegiatan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kegiatan\Models\Kegiatan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kegiatan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kegiatan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kegiatan::kegiatan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'kegiatan' => ['Kegiatan', Form::text("kegiatan", old("kegiatan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kegiatan::kegiatan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'kegiatan' => 'required',
			
		]);

		$kegiatan = new Kegiatan();
		$kegiatan->kegiatan = $request->input("kegiatan");
		
		$kegiatan->created_by = Auth::id();
		$kegiatan->save();

		$text = 'membuat '.$this->title; //' baru '.$kegiatan->what;
		$this->log($request, $text, ['kegiatan.id' => $kegiatan->id]);
		return redirect()->route('kegiatan.index')->with('message_success', 'Kegiatan berhasil ditambahkan!');
	}

	public function show(Request $request, Kegiatan $kegiatan)
	{
		$data['kegiatan'] = $kegiatan;

		$text = 'melihat detail '.$this->title;//.' '.$kegiatan->what;
		$this->log($request, $text, ['kegiatan.id' => $kegiatan->id]);
		return view('Kegiatan::kegiatan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Kegiatan $kegiatan)
	{
		$data['kegiatan'] = $kegiatan;

		
		$data['forms'] = array(
			'kegiatan' => ['Kegiatan', Form::text("kegiatan", $kegiatan->kegiatan, ["class" => "form-control","placeholder" => "", "id" => "kegiatan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kegiatan->what;
		$this->log($request, $text, ['kegiatan.id' => $kegiatan->id]);
		return view('Kegiatan::kegiatan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'kegiatan' => 'required',
			
		]);
		
		$kegiatan = Kegiatan::find($id);
		$kegiatan->kegiatan = $request->input("kegiatan");
		
		$kegiatan->updated_by = Auth::id();
		$kegiatan->save();


		$text = 'mengedit '.$this->title;//.' '.$kegiatan->what;
		$this->log($request, $text, ['kegiatan.id' => $kegiatan->id]);
		return redirect()->route('kegiatan.index')->with('message_success', 'Kegiatan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kegiatan = Kegiatan::find($id);
		$kegiatan->deleted_by = Auth::id();
		$kegiatan->save();
		$kegiatan->delete();

		$text = 'menghapus '.$this->title;//.' '.$kegiatan->what;
		$this->log($request, $text, ['kegiatan.id' => $kegiatan->id]);
		return back()->with('message_success', 'Kegiatan berhasil dihapus!');
	}

}
