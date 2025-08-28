<?php
namespace App\Modules\JenisPerangkat\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\JenisPerangkat\Models\JenisPerangkat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JenisPerangkatController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Jenis Perangkat";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = JenisPerangkat::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('JenisPerangkat::jenisperangkat', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'jenis_perangkat' => ['Jenis Perangkat', Form::text("jenis_perangkat", old("jenis_perangkat"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('JenisPerangkat::jenisperangkat_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'jenis_perangkat' => 'required',
			
		]);

		$jenisperangkat = new JenisPerangkat();
		$jenisperangkat->jenis_perangkat = $request->input("jenis_perangkat");
		
		$jenisperangkat->created_by = Auth::id();
		$jenisperangkat->save();

		$text = 'membuat '.$this->title; //' baru '.$jenisperangkat->what;
		$this->log($request, $text, ['jenisperangkat.id' => $jenisperangkat->id]);
		return redirect()->route('jenisperangkat.index')->with('message_success', 'Jenis Perangkat berhasil ditambahkan!');
	}

	public function show(Request $request, JenisPerangkat $jenisperangkat)
	{
		$data['jenisperangkat'] = $jenisperangkat;

		$text = 'melihat detail '.$this->title;//.' '.$jenisperangkat->what;
		$this->log($request, $text, ['jenisperangkat.id' => $jenisperangkat->id]);
		return view('JenisPerangkat::jenisperangkat_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, JenisPerangkat $jenisperangkat)
	{
		$data['jenisperangkat'] = $jenisperangkat;

		
		$data['forms'] = array(
			'jenis_perangkat' => ['Jenis Perangkat', Form::text("jenis_perangkat", $jenisperangkat->jenis_perangkat, ["class" => "form-control","placeholder" => "", "id" => "jenis_perangkat"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$jenisperangkat->what;
		$this->log($request, $text, ['jenisperangkat.id' => $jenisperangkat->id]);
		return view('JenisPerangkat::jenisperangkat_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'jenis_perangkat' => 'required',
			
		]);
		
		$jenisperangkat = JenisPerangkat::find($id);
		$jenisperangkat->jenis_perangkat = $request->input("jenis_perangkat");
		
		$jenisperangkat->updated_by = Auth::id();
		$jenisperangkat->save();


		$text = 'mengedit '.$this->title;//.' '.$jenisperangkat->what;
		$this->log($request, $text, ['jenisperangkat.id' => $jenisperangkat->id]);
		return redirect()->route('jenisperangkat.index')->with('message_success', 'Jenis Perangkat berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$jenisperangkat = JenisPerangkat::find($id);
		$jenisperangkat->deleted_by = Auth::id();
		$jenisperangkat->save();
		$jenisperangkat->delete();

		$text = 'menghapus '.$this->title;//.' '.$jenisperangkat->what;
		$this->log($request, $text, ['jenisperangkat.id' => $jenisperangkat->id]);
		return back()->with('message_success', 'Jenis Perangkat berhasil dihapus!');
	}

}
