<?php
namespace App\Modules\Kosp\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kosp\Models\Kosp;
use App\Modules\TahunAjaran\Models\TahunAjaran;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KospController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kosp";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kosp::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kosp::kosp', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_tahun_ajaran = TahunAjaran::all()->pluck('tahun_ajaran','id');
		
		$data['forms'] = array(
			'nama' => ['Nama', Form::text("nama", old("nama"), ["class" => "form-control","placeholder" => ""]) ],
			'link' => ['Link', Form::textarea("link", old("link"), ["class" => "form-control"]) ],
			'id_tahun_ajaran' => ['Tahun Ajaran', Form::select("id_tahun_ajaran", $ref_tahun_ajaran, null, ["class" => "form-control select2"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kosp::kosp_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama' => 'required',
			'link' => 'required',
			'id_tahun_ajaran' => 'required',
			
		]);

		$kosp = new Kosp();
		$kosp->nama = $request->input("nama");
		$kosp->link = $request->input("link");
		$kosp->id_tahun_ajaran = $request->input("id_tahun_ajaran");
		
		$kosp->created_by = Auth::id();
		$kosp->save();

		$text = 'membuat '.$this->title; //' baru '.$kosp->what;
		$this->log($request, $text, ['kosp.id' => $kosp->id]);
		return redirect()->route('kosp.index')->with('message_success', 'Kosp berhasil ditambahkan!');
	}

	public function show(Request $request, Kosp $kosp)
	{
		$data['kosp'] = $kosp;

		$text = 'melihat detail '.$this->title;//.' '.$kosp->what;
		$this->log($request, $text, ['kosp.id' => $kosp->id]);
		return view('Kosp::kosp_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Kosp $kosp)
	{
		$data['kosp'] = $kosp;

		$ref_tahun_ajaran = TahunAjaran::all()->pluck('tahun_ajaran','id');
		
		$data['forms'] = array(
			'nama' => ['Nama', Form::text("nama", $kosp->nama, ["class" => "form-control","placeholder" => "", "id" => "nama"]) ],
			'link' => ['Link', Form::textarea("link", $kosp->link, ["class" => "form-control"]) ],
			'id_tahun_ajaran' => ['Tahun Ajaran', Form::select("id_tahun_ajaran", $ref_tahun_ajaran, null, ["class" => "form-control select2"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kosp->what;
		$this->log($request, $text, ['kosp.id' => $kosp->id]);
		return view('Kosp::kosp_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama' => 'required',
			'link' => 'required',
			'id_tahun_ajaran' => 'required',
			
		]);
		
		$kosp = Kosp::find($id);
		$kosp->nama = $request->input("nama");
		$kosp->link = $request->input("link");
		$kosp->id_tahun_ajaran = $request->input("id_tahun_ajaran");
		
		$kosp->updated_by = Auth::id();
		$kosp->save();


		$text = 'mengedit '.$this->title;//.' '.$kosp->what;
		$this->log($request, $text, ['kosp.id' => $kosp->id]);
		return redirect()->route('kosp.index')->with('message_success', 'Kosp berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kosp = Kosp::find($id);
		$kosp->deleted_by = Auth::id();
		$kosp->save();
		$kosp->delete();

		$text = 'menghapus '.$this->title;//.' '.$kosp->what;
		$this->log($request, $text, ['kosp.id' => $kosp->id]);
		return back()->with('message_success', 'Kosp berhasil dihapus!');
	}

}
