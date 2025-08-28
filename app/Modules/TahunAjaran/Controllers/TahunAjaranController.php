<?php
namespace App\Modules\TahunAjaran\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\TahunAjaran\Models\TahunAjaran;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TahunAjaranController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Tahun Ajaran";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = TahunAjaran::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('TahunAjaran::tahunajaran', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'tahun_ajaran' => ['Tahun Ajaran', Form::text("tahun_ajaran", old("tahun_ajaran"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('TahunAjaran::tahunajaran_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'tahun_ajaran' => 'required',
			
		]);

		$tahunajaran = new TahunAjaran();
		$tahunajaran->tahun_ajaran = $request->input("tahun_ajaran");
		
		$tahunajaran->created_by = Auth::id();
		$tahunajaran->save();

		$text = 'membuat '.$this->title; //' baru '.$tahunajaran->what;
		$this->log($request, $text, ['tahunajaran.id' => $tahunajaran->id]);
		return redirect()->route('tahunajaran.index')->with('message_success', 'Tahun Ajaran berhasil ditambahkan!');
	}

	public function show(Request $request, TahunAjaran $tahunajaran)
	{
		$data['tahunajaran'] = $tahunajaran;

		$text = 'melihat detail '.$this->title;//.' '.$tahunajaran->what;
		$this->log($request, $text, ['tahunajaran.id' => $tahunajaran->id]);
		return view('TahunAjaran::tahunajaran_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, TahunAjaran $tahunajaran)
	{
		$data['tahunajaran'] = $tahunajaran;

		
		$data['forms'] = array(
			'tahun_ajaran' => ['Tahun Ajaran', Form::text("tahun_ajaran", $tahunajaran->tahun_ajaran, ["class" => "form-control","placeholder" => "", "id" => "tahun_ajaran"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$tahunajaran->what;
		$this->log($request, $text, ['tahunajaran.id' => $tahunajaran->id]);
		return view('TahunAjaran::tahunajaran_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'tahun_ajaran' => 'required',
			
		]);
		
		$tahunajaran = TahunAjaran::find($id);
		$tahunajaran->tahun_ajaran = $request->input("tahun_ajaran");
		
		$tahunajaran->updated_by = Auth::id();
		$tahunajaran->save();


		$text = 'mengedit '.$this->title;//.' '.$tahunajaran->what;
		$this->log($request, $text, ['tahunajaran.id' => $tahunajaran->id]);
		return redirect()->route('tahunajaran.index')->with('message_success', 'Tahun Ajaran berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$tahunajaran = TahunAjaran::find($id);
		$tahunajaran->deleted_by = Auth::id();
		$tahunajaran->save();
		$tahunajaran->delete();

		$text = 'menghapus '.$this->title;//.' '.$tahunajaran->what;
		$this->log($request, $text, ['tahunajaran.id' => $tahunajaran->id]);
		return back()->with('message_success', 'Tahun Ajaran berhasil dihapus!');
	}

}
