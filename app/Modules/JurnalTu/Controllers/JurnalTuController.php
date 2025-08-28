<?php
namespace App\Modules\JurnalTu\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\JurnalTu\Models\JurnalTu;
use App\Modules\StatusPekerjaan\Models\StatusPekerjaan;
use App\Modules\Karyawan\Models\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JurnalTuController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Jurnal Tu";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = JurnalTu::query()->whereIdKaryawan(session('id_karyawan'));
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('JurnalTu::jurnaltu', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_status_pekerjaan = StatusPekerjaan::all()->pluck('status_pekerjaan','id');
		$ref_status_pekerjaan->prepend('-PILIH SALAH SATU-', '');
		// $ref_karyawan = Karyawan::all()->pluck('id_bagian','id');

		$id_karyawan = session('id_karyawan');

		// dd($id_karyawan);
		
		$data['forms'] = array(
			'id_status_pekerjaan' => ['Status Pekerjaan', Form::select("id_status_pekerjaan", $ref_status_pekerjaan, null, ["class" => "form-control select2"]) ],
			'detail_pekerjaan' => ['Detail Pekerjaan', Form::textarea("detail_pekerjaan", old("detail_pekerjaan"), ["class" => "form-control rich-editor"]) ],
			'tanggal' => ['Tanggal', Form::text("tanggal", old("tanggal"), ["class" => "form-control datepicker"]) ],
			// 'foto' => ['Foto', Form::file("foto", ["class" => "form-control","accept"=>"image/*", "capture"=>"camera"]) ],
			'foto' => ['Foto', Form::file("foto", ["class" => "form-control","accept"=>"capture=camera,image/*"]) ],
			'id_karyawan' => ['', Form::hidden("id_karyawan", $id_karyawan) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('JurnalTu::jurnaltu_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_status_pekerjaan' => 'required',
			'id_karyawan' => 'required',
			'detail_pekerjaan' => 'required',
			'tanggal' => 'required|date',
			'foto' => 'required|mimes:jpg,jpeg,png|max:10240'
			
		]);

		$fileName = time().'.'.$request->foto->extension();  

        $request->foto->move(public_path('uploads/jurnal_tu/'), $fileName);

		$jurnaltu = new JurnalTu();
		$jurnaltu->id_status_pekerjaan = $request->input("id_status_pekerjaan");
		$jurnaltu->id_karyawan = $request->input("id_karyawan");
		$jurnaltu->detail_pekerjaan = $request->input("detail_pekerjaan");
		$jurnaltu->tanggal = $request->input("tanggal");
		$jurnaltu->foto = $fileName;
		
		$jurnaltu->created_by = Auth::id();
		$jurnaltu->save();

		$text = 'membuat '.$this->title; //' baru '.$jurnaltu->what;
		$this->log($request, $text, ['jurnaltu.id' => $jurnaltu->id]);
		return redirect()->route('jurnaltu.index')->with('message_success', 'Jurnal Tu berhasil ditambahkan!');
	}

	public function show(Request $request, JurnalTu $jurnaltu)
	{
		$data['jurnaltu'] = $jurnaltu;

		$text = 'melihat detail '.$this->title;//.' '.$jurnaltu->what;
		$this->log($request, $text, ['jurnaltu.id' => $jurnaltu->id]);
		return view('JurnalTu::jurnaltu_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, JurnalTu $jurnaltu)
	{
		$data['jurnaltu'] = $jurnaltu;

		$ref_status_pekerjaan = StatusPekerjaan::all()->pluck('status_pekerjaan','id');
		$ref_karyawan = Karyawan::all()->pluck('id_bagian','id');
		
		$data['forms'] = array(
			'id_status_pekerjaan' => ['Status Pekerjaan', Form::select("id_status_pekerjaan", $ref_status_pekerjaan, null, ["class" => "form-control select2"]) ],
			'id_karyawan' => ['Karyawan', Form::select("id_karyawan", $ref_karyawan, null, ["class" => "form-control select2"]) ],
			'detail_pekerjaan' => ['Detail Pekerjaan', Form::textarea("detail_pekerjaan", $jurnaltu->detail_pekerjaan, ["class" => "form-control rich-editor"]) ],
			'tanggal' => ['Tanggal', Form::text("tanggal", $jurnaltu->tanggal, ["class" => "form-control datepicker", "id" => "tanggal"]) ],
			'foto' => ['Foto', Form::text("foto", $jurnaltu->foto, ["class" => "form-control","placeholder" => "", "id" => "foto"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$jurnaltu->what;
		$this->log($request, $text, ['jurnaltu.id' => $jurnaltu->id]);
		return view('JurnalTu::jurnaltu_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_status_pekerjaan' => 'required',
			'id_karyawan' => 'required',
			'detail_pekerjaan' => 'required',
			'tanggal' => 'required',
			'foto' => 'required',
			
		]);
		
		$jurnaltu = JurnalTu::find($id);
		$jurnaltu->id_status_pekerjaan = $request->input("id_status_pekerjaan");
		$jurnaltu->id_karyawan = $request->input("id_karyawan");
		$jurnaltu->detail_pekerjaan = $request->input("detail_pekerjaan");
		$jurnaltu->tanggal = $request->input("tanggal");
		$jurnaltu->foto = $request->input("foto");
		
		$jurnaltu->updated_by = Auth::id();
		$jurnaltu->save();


		$text = 'mengedit '.$this->title;//.' '.$jurnaltu->what;
		$this->log($request, $text, ['jurnaltu.id' => $jurnaltu->id]);
		return redirect()->route('jurnaltu.index')->with('message_success', 'Jurnal Tu berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$jurnaltu = JurnalTu::find($id);
		$jurnaltu->deleted_by = Auth::id();
		$jurnaltu->save();
		$jurnaltu->delete();

		$text = 'menghapus '.$this->title;//.' '.$jurnaltu->what;
		$this->log($request, $text, ['jurnaltu.id' => $jurnaltu->id]);
		return back()->with('message_success', 'Jurnal Tu berhasil dihapus!');
	}

}
