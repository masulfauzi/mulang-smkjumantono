<?php
namespace App\Modules\Jampelajaran\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Jampelajaran\Models\Jampelajaran;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JampelajaranController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Jampelajaran";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Jampelajaran::query()->orderBy('jam_pelajaran');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Jampelajaran::jampelajaran', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'jam_pelajaran' => ['Jam Pelajaran', Form::text("jam_pelajaran", old("jam_pelajaran"), ["class" => "form-control","placeholder" => ""]) ],
			'waktu_mulai' => ['Waktu Mulai', Form::text("waktu_mulai", old("waktu_mulai"), ["class" => "form-control","placeholder" => ""]) ],
			'waktu_selesai' => ['Waktu Selesai', Form::text("waktu_selesai", old("waktu_selesai"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Jampelajaran::jampelajaran_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'jam_pelajaran' => 'required',
			'waktu_mulai' => 'required',
			'waktu_selesai' => 'required',
			
		]);

		$jampelajaran = new Jampelajaran();
		$jampelajaran->jam_pelajaran = $request->input("jam_pelajaran");
		$jampelajaran->waktu_mulai = $request->input("waktu_mulai");
		$jampelajaran->waktu_selesai = $request->input("waktu_selesai");
		
		$jampelajaran->created_by = Auth::id();
		$jampelajaran->save();

		$text = 'membuat '.$this->title; //' baru '.$jampelajaran->what;
		$this->log($request, $text, ['jampelajaran.id' => $jampelajaran->id]);
		return redirect()->route('jampelajaran.index')->with('message_success', 'Jampelajaran berhasil ditambahkan!');
	}

	public function show(Request $request, Jampelajaran $jampelajaran)
	{
		$data['jampelajaran'] = $jampelajaran;

		$text = 'melihat detail '.$this->title;//.' '.$jampelajaran->what;
		$this->log($request, $text, ['jampelajaran.id' => $jampelajaran->id]);
		return view('Jampelajaran::jampelajaran_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Jampelajaran $jampelajaran)
	{
		$data['jampelajaran'] = $jampelajaran;

		
		$data['forms'] = array(
			'jam_pelajaran' => ['Jam Pelajaran', Form::text("jam_pelajaran", $jampelajaran->jam_pelajaran, ["class" => "form-control","placeholder" => "", "id" => "jam_pelajaran"]) ],
			'waktu_mulai' => ['Waktu Mulai', Form::text("waktu_mulai", $jampelajaran->waktu_mulai, ["class" => "form-control","placeholder" => "", "id" => "waktu_mulai"]) ],
			'waktu_selesai' => ['Waktu Selesai', Form::text("waktu_selesai", $jampelajaran->waktu_selesai, ["class" => "form-control","placeholder" => "", "id" => "waktu_selesai"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$jampelajaran->what;
		$this->log($request, $text, ['jampelajaran.id' => $jampelajaran->id]);
		return view('Jampelajaran::jampelajaran_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'jam_pelajaran' => 'required',
			'waktu_mulai' => 'required',
			'waktu_selesai' => 'required',
			
		]);
		
		$jampelajaran = Jampelajaran::find($id);
		$jampelajaran->jam_pelajaran = $request->input("jam_pelajaran");
		$jampelajaran->waktu_mulai = $request->input("waktu_mulai");
		$jampelajaran->waktu_selesai = $request->input("waktu_selesai");
		
		$jampelajaran->updated_by = Auth::id();
		$jampelajaran->save();


		$text = 'mengedit '.$this->title;//.' '.$jampelajaran->what;
		$this->log($request, $text, ['jampelajaran.id' => $jampelajaran->id]);
		return redirect()->route('jampelajaran.index')->with('message_success', 'Jampelajaran berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$jampelajaran = Jampelajaran::find($id);
		$jampelajaran->deleted_by = Auth::id();
		$jampelajaran->save();
		$jampelajaran->delete();

		$text = 'menghapus '.$this->title;//.' '.$jampelajaran->what;
		$this->log($request, $text, ['jampelajaran.id' => $jampelajaran->id]);
		return back()->with('message_success', 'Jampelajaran berhasil dihapus!');
	}

}
