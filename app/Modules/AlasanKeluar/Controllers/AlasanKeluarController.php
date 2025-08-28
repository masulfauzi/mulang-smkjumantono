<?php
namespace App\Modules\AlasanKeluar\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\AlasanKeluar\Models\AlasanKeluar;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AlasanKeluarController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Alasan Keluar";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = AlasanKeluar::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('AlasanKeluar::alasankeluar', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'alasan_keluar' => ['Alasan Keluar', Form::text("alasan_keluar", old("alasan_keluar"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('AlasanKeluar::alasankeluar_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'alasan_keluar' => 'required',
			
		]);

		$alasankeluar = new AlasanKeluar();
		$alasankeluar->alasan_keluar = $request->input("alasan_keluar");
		
		$alasankeluar->created_by = Auth::id();
		$alasankeluar->save();

		$text = 'membuat '.$this->title; //' baru '.$alasankeluar->what;
		$this->log($request, $text, ['alasankeluar.id' => $alasankeluar->id]);
		return redirect()->route('alasankeluar.index')->with('message_success', 'Alasan Keluar berhasil ditambahkan!');
	}

	public function show(Request $request, AlasanKeluar $alasankeluar)
	{
		$data['alasankeluar'] = $alasankeluar;

		$text = 'melihat detail '.$this->title;//.' '.$alasankeluar->what;
		$this->log($request, $text, ['alasankeluar.id' => $alasankeluar->id]);
		return view('AlasanKeluar::alasankeluar_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, AlasanKeluar $alasankeluar)
	{
		$data['alasankeluar'] = $alasankeluar;

		
		$data['forms'] = array(
			'alasan_keluar' => ['Alasan Keluar', Form::text("alasan_keluar", $alasankeluar->alasan_keluar, ["class" => "form-control","placeholder" => "", "id" => "alasan_keluar"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$alasankeluar->what;
		$this->log($request, $text, ['alasankeluar.id' => $alasankeluar->id]);
		return view('AlasanKeluar::alasankeluar_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'alasan_keluar' => 'required',
			
		]);
		
		$alasankeluar = AlasanKeluar::find($id);
		$alasankeluar->alasan_keluar = $request->input("alasan_keluar");
		
		$alasankeluar->updated_by = Auth::id();
		$alasankeluar->save();


		$text = 'mengedit '.$this->title;//.' '.$alasankeluar->what;
		$this->log($request, $text, ['alasankeluar.id' => $alasankeluar->id]);
		return redirect()->route('alasankeluar.index')->with('message_success', 'Alasan Keluar berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$alasankeluar = AlasanKeluar::find($id);
		$alasankeluar->deleted_by = Auth::id();
		$alasankeluar->save();
		$alasankeluar->delete();

		$text = 'menghapus '.$this->title;//.' '.$alasankeluar->what;
		$this->log($request, $text, ['alasankeluar.id' => $alasankeluar->id]);
		return back()->with('message_success', 'Alasan Keluar berhasil dihapus!');
	}

}
