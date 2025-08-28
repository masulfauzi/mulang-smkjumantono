<?php
namespace App\Modules\Jenissoal\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Jenissoal\Models\Jenissoal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JenissoalController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Jenissoal";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Jenissoal::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Jenissoal::jenissoal', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'jenis_soal' => ['Jenis Soal', Form::text("jenis_soal", old("jenis_soal"), ["class" => "form-control","placeholder" => ""]) ],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", old("keterangan"), ["class" => "form-control rich-editor"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Jenissoal::jenissoal_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'jenis_soal' => 'required',
			'keterangan' => 'required',
			
		]);

		$jenissoal = new Jenissoal();
		$jenissoal->jenis_soal = $request->input("jenis_soal");
		$jenissoal->keterangan = $request->input("keterangan");
		
		$jenissoal->created_by = Auth::id();
		$jenissoal->save();

		$text = 'membuat '.$this->title; //' baru '.$jenissoal->what;
		$this->log($request, $text, ['jenissoal.id' => $jenissoal->id]);
		return redirect()->route('jenissoal.index')->with('message_success', 'Jenissoal berhasil ditambahkan!');
	}

	public function show(Request $request, Jenissoal $jenissoal)
	{
		$data['jenissoal'] = $jenissoal;

		$text = 'melihat detail '.$this->title;//.' '.$jenissoal->what;
		$this->log($request, $text, ['jenissoal.id' => $jenissoal->id]);
		return view('Jenissoal::jenissoal_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Jenissoal $jenissoal)
	{
		$data['jenissoal'] = $jenissoal;

		
		$data['forms'] = array(
			'jenis_soal' => ['Jenis Soal', Form::text("jenis_soal", $jenissoal->jenis_soal, ["class" => "form-control","placeholder" => "", "id" => "jenis_soal"]) ],
			'keterangan' => ['Keterangan', Form::textarea("keterangan", $jenissoal->keterangan, ["class" => "form-control rich-editor"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$jenissoal->what;
		$this->log($request, $text, ['jenissoal.id' => $jenissoal->id]);
		return view('Jenissoal::jenissoal_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'jenis_soal' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$jenissoal = Jenissoal::find($id);
		$jenissoal->jenis_soal = $request->input("jenis_soal");
		$jenissoal->keterangan = $request->input("keterangan");
		
		$jenissoal->updated_by = Auth::id();
		$jenissoal->save();


		$text = 'mengedit '.$this->title;//.' '.$jenissoal->what;
		$this->log($request, $text, ['jenissoal.id' => $jenissoal->id]);
		return redirect()->route('jenissoal.index')->with('message_success', 'Jenissoal berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$jenissoal = Jenissoal::find($id);
		$jenissoal->deleted_by = Auth::id();
		$jenissoal->save();
		$jenissoal->delete();

		$text = 'menghapus '.$this->title;//.' '.$jenissoal->what;
		$this->log($request, $text, ['jenissoal.id' => $jenissoal->id]);
		return back()->with('message_success', 'Jenissoal berhasil dihapus!');
	}

}
