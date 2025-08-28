<?php
namespace App\Modules\StatusPekerjaan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\StatusPekerjaan\Models\StatusPekerjaan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StatusPekerjaanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Status Pekerjaan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = StatusPekerjaan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('StatusPekerjaan::statuspekerjaan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'status_pekerjaan' => ['Status Pekerjaan', Form::text("status_pekerjaan", old("status_pekerjaan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('StatusPekerjaan::statuspekerjaan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'status_pekerjaan' => 'required',
			
		]);

		$statuspekerjaan = new StatusPekerjaan();
		$statuspekerjaan->status_pekerjaan = $request->input("status_pekerjaan");
		
		$statuspekerjaan->created_by = Auth::id();
		$statuspekerjaan->save();

		$text = 'membuat '.$this->title; //' baru '.$statuspekerjaan->what;
		$this->log($request, $text, ['statuspekerjaan.id' => $statuspekerjaan->id]);
		return redirect()->route('statuspekerjaan.index')->with('message_success', 'Status Pekerjaan berhasil ditambahkan!');
	}

	public function show(Request $request, StatusPekerjaan $statuspekerjaan)
	{
		$data['statuspekerjaan'] = $statuspekerjaan;

		$text = 'melihat detail '.$this->title;//.' '.$statuspekerjaan->what;
		$this->log($request, $text, ['statuspekerjaan.id' => $statuspekerjaan->id]);
		return view('StatusPekerjaan::statuspekerjaan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, StatusPekerjaan $statuspekerjaan)
	{
		$data['statuspekerjaan'] = $statuspekerjaan;

		
		$data['forms'] = array(
			'status_pekerjaan' => ['Status Pekerjaan', Form::text("status_pekerjaan", $statuspekerjaan->status_pekerjaan, ["class" => "form-control","placeholder" => "", "id" => "status_pekerjaan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$statuspekerjaan->what;
		$this->log($request, $text, ['statuspekerjaan.id' => $statuspekerjaan->id]);
		return view('StatusPekerjaan::statuspekerjaan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'status_pekerjaan' => 'required',
			
		]);
		
		$statuspekerjaan = StatusPekerjaan::find($id);
		$statuspekerjaan->status_pekerjaan = $request->input("status_pekerjaan");
		
		$statuspekerjaan->updated_by = Auth::id();
		$statuspekerjaan->save();


		$text = 'mengedit '.$this->title;//.' '.$statuspekerjaan->what;
		$this->log($request, $text, ['statuspekerjaan.id' => $statuspekerjaan->id]);
		return redirect()->route('statuspekerjaan.index')->with('message_success', 'Status Pekerjaan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$statuspekerjaan = StatusPekerjaan::find($id);
		$statuspekerjaan->deleted_by = Auth::id();
		$statuspekerjaan->save();
		$statuspekerjaan->delete();

		$text = 'menghapus '.$this->title;//.' '.$statuspekerjaan->what;
		$this->log($request, $text, ['statuspekerjaan.id' => $statuspekerjaan->id]);
		return back()->with('message_success', 'Status Pekerjaan berhasil dihapus!');
	}

}
