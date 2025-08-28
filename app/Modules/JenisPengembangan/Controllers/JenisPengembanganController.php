<?php
namespace App\Modules\JenisPengembangan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\JenisPengembangan\Models\JenisPengembangan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JenisPengembanganController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Jenis Pengembangan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = JenisPengembangan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('JenisPengembangan::jenispengembangan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'jenis_pengembangan' => ['Jenis Pengembangan', Form::text("jenis_pengembangan", old("jenis_pengembangan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('JenisPengembangan::jenispengembangan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'jenis_pengembangan' => 'required',
			
		]);

		$jenispengembangan = new JenisPengembangan();
		$jenispengembangan->jenis_pengembangan = $request->input("jenis_pengembangan");
		
		$jenispengembangan->created_by = Auth::id();
		$jenispengembangan->save();

		$text = 'membuat '.$this->title; //' baru '.$jenispengembangan->what;
		$this->log($request, $text, ['jenispengembangan.id' => $jenispengembangan->id]);
		return redirect()->route('jenispengembangan.index')->with('message_success', 'Jenis Pengembangan berhasil ditambahkan!');
	}

	public function show(Request $request, JenisPengembangan $jenispengembangan)
	{
		$data['jenispengembangan'] = $jenispengembangan;

		$text = 'melihat detail '.$this->title;//.' '.$jenispengembangan->what;
		$this->log($request, $text, ['jenispengembangan.id' => $jenispengembangan->id]);
		return view('JenisPengembangan::jenispengembangan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, JenisPengembangan $jenispengembangan)
	{
		$data['jenispengembangan'] = $jenispengembangan;

		
		$data['forms'] = array(
			'jenis_pengembangan' => ['Jenis Pengembangan', Form::text("jenis_pengembangan", $jenispengembangan->jenis_pengembangan, ["class" => "form-control","placeholder" => "", "id" => "jenis_pengembangan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$jenispengembangan->what;
		$this->log($request, $text, ['jenispengembangan.id' => $jenispengembangan->id]);
		return view('JenisPengembangan::jenispengembangan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'jenis_pengembangan' => 'required',
			
		]);
		
		$jenispengembangan = JenisPengembangan::find($id);
		$jenispengembangan->jenis_pengembangan = $request->input("jenis_pengembangan");
		
		$jenispengembangan->updated_by = Auth::id();
		$jenispengembangan->save();


		$text = 'mengedit '.$this->title;//.' '.$jenispengembangan->what;
		$this->log($request, $text, ['jenispengembangan.id' => $jenispengembangan->id]);
		return redirect()->route('jenispengembangan.index')->with('message_success', 'Jenis Pengembangan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$jenispengembangan = JenisPengembangan::find($id);
		$jenispengembangan->deleted_by = Auth::id();
		$jenispengembangan->save();
		$jenispengembangan->delete();

		$text = 'menghapus '.$this->title;//.' '.$jenispengembangan->what;
		$this->log($request, $text, ['jenispengembangan.id' => $jenispengembangan->id]);
		return back()->with('message_success', 'Jenis Pengembangan berhasil dihapus!');
	}

}
