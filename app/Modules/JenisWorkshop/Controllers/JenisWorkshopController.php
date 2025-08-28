<?php
namespace App\Modules\JenisWorkshop\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\JenisWorkshop\Models\JenisWorkshop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JenisWorkshopController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Jenis Workshop";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = JenisWorkshop::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('JenisWorkshop::jenisworkshop', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'jenis_workshop' => ['Jenis Workshop', Form::text("jenis_workshop", old("jenis_workshop"), ["class" => "form-control","placeholder" => ""]) ],
			'folder' => ['Folder', Form::text("folder", old("folder"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('JenisWorkshop::jenisworkshop_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'jenis_workshop' => 'required',
			'folder' => 'required',
			
		]);

		$jenisworkshop = new JenisWorkshop();
		$jenisworkshop->jenis_workshop = $request->input("jenis_workshop");
		$jenisworkshop->folder = $request->input("folder");
		
		$jenisworkshop->created_by = Auth::id();
		$jenisworkshop->save();

		$text = 'membuat '.$this->title; //' baru '.$jenisworkshop->what;
		$this->log($request, $text, ['jenisworkshop.id' => $jenisworkshop->id]);
		return redirect()->route('jenisworkshop.index')->with('message_success', 'Jenis Workshop berhasil ditambahkan!');
	}

	public function show(Request $request, JenisWorkshop $jenisworkshop)
	{
		$data['jenisworkshop'] = $jenisworkshop;

		$text = 'melihat detail '.$this->title;//.' '.$jenisworkshop->what;
		$this->log($request, $text, ['jenisworkshop.id' => $jenisworkshop->id]);
		return view('JenisWorkshop::jenisworkshop_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, JenisWorkshop $jenisworkshop)
	{
		$data['jenisworkshop'] = $jenisworkshop;

		
		$data['forms'] = array(
			'jenis_workshop' => ['Jenis Workshop', Form::text("jenis_workshop", $jenisworkshop->jenis_workshop, ["class" => "form-control","placeholder" => "", "id" => "jenis_workshop"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$jenisworkshop->what;
		$this->log($request, $text, ['jenisworkshop.id' => $jenisworkshop->id]);
		return view('JenisWorkshop::jenisworkshop_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'jenis_workshop' => 'required',
			
		]);
		
		$jenisworkshop = JenisWorkshop::find($id);
		$jenisworkshop->jenis_workshop = $request->input("jenis_workshop");
		
		$jenisworkshop->updated_by = Auth::id();
		$jenisworkshop->save();


		$text = 'mengedit '.$this->title;//.' '.$jenisworkshop->what;
		$this->log($request, $text, ['jenisworkshop.id' => $jenisworkshop->id]);
		return redirect()->route('jenisworkshop.index')->with('message_success', 'Jenis Workshop berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$jenisworkshop = JenisWorkshop::find($id);
		$jenisworkshop->deleted_by = Auth::id();
		$jenisworkshop->save();
		$jenisworkshop->delete();

		$text = 'menghapus '.$this->title;//.' '.$jenisworkshop->what;
		$this->log($request, $text, ['jenisworkshop.id' => $jenisworkshop->id]);
		return back()->with('message_success', 'Jenis Workshop berhasil dihapus!');
	}

}
