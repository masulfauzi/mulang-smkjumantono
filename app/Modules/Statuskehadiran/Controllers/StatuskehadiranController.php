<?php
namespace App\Modules\Statuskehadiran\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Statuskehadiran\Models\Statuskehadiran;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StatuskehadiranController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Statuskehadiran";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Statuskehadiran::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Statuskehadiran::statuskehadiran', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'status_kehadiran' => ['Status Kehadiran', Form::text("status_kehadiran", old("status_kehadiran"), ["class" => "form-control","placeholder" => ""]) ],
			'status_kehadiran_pendek' => ['Status Kehadiran Pendek', Form::text("status_kehadiran_pendek", old("status_kehadiran_pendek"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Statuskehadiran::statuskehadiran_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'status_kehadiran' => 'required',
			'status_kehadiran_pendek' => 'required',
			
		]);

		$statuskehadiran = new Statuskehadiran();
		$statuskehadiran->status_kehadiran = $request->input("status_kehadiran");
		$statuskehadiran->status_kehadiran_pendek = $request->input("status_kehadiran_pendek");
		
		$statuskehadiran->created_by = Auth::id();
		$statuskehadiran->save();

		$text = 'membuat '.$this->title; //' baru '.$statuskehadiran->what;
		$this->log($request, $text, ['statuskehadiran.id' => $statuskehadiran->id]);
		return redirect()->route('statuskehadiran.index')->with('message_success', 'Statuskehadiran berhasil ditambahkan!');
	}

	public function show(Request $request, Statuskehadiran $statuskehadiran)
	{
		$data['statuskehadiran'] = $statuskehadiran;

		$text = 'melihat detail '.$this->title;//.' '.$statuskehadiran->what;
		$this->log($request, $text, ['statuskehadiran.id' => $statuskehadiran->id]);
		return view('Statuskehadiran::statuskehadiran_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Statuskehadiran $statuskehadiran)
	{
		$data['statuskehadiran'] = $statuskehadiran;

		
		$data['forms'] = array(
			'status_kehadiran' => ['Status Kehadiran', Form::text("status_kehadiran", $statuskehadiran->status_kehadiran, ["class" => "form-control","placeholder" => "", "id" => "status_kehadiran"]) ],
			'status_kehadiran_pendek' => ['Status Kehadiran Pendek', Form::text("status_kehadiran_pendek", $statuskehadiran->status_kehadiran_pendek, ["class" => "form-control","placeholder" => "", "id" => "status_kehadiran_pendek"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$statuskehadiran->what;
		$this->log($request, $text, ['statuskehadiran.id' => $statuskehadiran->id]);
		return view('Statuskehadiran::statuskehadiran_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'status_kehadiran' => 'required',
			'status_kehadiran_pendek' => 'required',
			
		]);
		
		$statuskehadiran = Statuskehadiran::find($id);
		$statuskehadiran->status_kehadiran = $request->input("status_kehadiran");
		$statuskehadiran->status_kehadiran_pendek = $request->input("status_kehadiran_pendek");
		
		$statuskehadiran->updated_by = Auth::id();
		$statuskehadiran->save();


		$text = 'mengedit '.$this->title;//.' '.$statuskehadiran->what;
		$this->log($request, $text, ['statuskehadiran.id' => $statuskehadiran->id]);
		return redirect()->route('statuskehadiran.index')->with('message_success', 'Statuskehadiran berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$statuskehadiran = Statuskehadiran::find($id);
		$statuskehadiran->deleted_by = Auth::id();
		$statuskehadiran->save();
		$statuskehadiran->delete();

		$text = 'menghapus '.$this->title;//.' '.$statuskehadiran->what;
		$this->log($request, $text, ['statuskehadiran.id' => $statuskehadiran->id]);
		return back()->with('message_success', 'Statuskehadiran berhasil dihapus!');
	}

}
