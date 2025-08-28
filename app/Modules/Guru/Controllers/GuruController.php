<?php
namespace App\Modules\Guru\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Guru\Models\Guru;
use App\Modules\Agama\Models\Agama;

use App\Http\Controllers\Controller;
use App\Modules\AlasanKeluar\Models\AlasanKeluar;
use Illuminate\Support\Facades\Auth;

use PDF;

class GuruController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Guru";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Guru::orderBy('is_aktif', 'desc')->orderBy('nama');
		if($request->has('search')){
			$search = $request->get('search');
			$query->where('nama', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(20)->withQueryString();
		$data['aktif'] = [
			'0' => 'Tidak Aktif',
			'1' => 'Aktif'
		];

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Guru::guru', array_merge($data, ['title' => $this->title]));
	}

	public function index_tpg(Request $request)
	{
		// echo "sbmsdfmsdf s,jd fs,jd f,sjd f";
		return view('Guru::guru_tpg');
	}

	public function download_skab(Request $request)
	{
		$data['guru']	= Guru::all()->sortBy('nama');

		return view('Guru::guru_skab', $data);
		// $pdf = PDF::loadview('Guru::guru_skab',$data);
    	// return $pdf->download('SKAB');
	}

	public function create(Request $request)
	{
		$ref_agama = Agama::all()->pluck('agama','id');
		
		$data['forms'] = array(
			'nama' => ['Nama', Form::text("nama", old("nama"), ["class" => "form-control","placeholder" => ""]) ],
			'nip' => ['Nip', Form::text("nip", old("nip"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'nik' => ['Nik', Form::text("nik", old("nik"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'email' => ['Email', Form::text("email", old("email"), ["class" => "form-control","placeholder" => ""]) ],
			'no_hp' => ['No Hp', Form::text("no_hp", old("no_hp"), ["class" => "form-control","placeholder" => ""]) ],
			'tempat_lahir' => ['Tempat Lahir', Form::text("tempat_lahir", old("tempat_lahir"), ["class" => "form-control","placeholder" => ""]) ],
			'tgl_lahir' => ['Tgl Lahir', Form::text("tgl_lahir", old("tgl_lahir"), ["class" => "form-control datepicker"]) ],
			'id_agama' => ['Agama', Form::select("id_agama", $ref_agama, null, ["class" => "form-control select2"]) ],
			'alamat' => ['Alamat', Form::textarea("alamat", old("alamat"), ["class" => "form-control rich-editor"]) ],
			'rt' => ['Rt', Form::text("rt", old("rt"), ["class" => "form-control","placeholder" => ""]) ],
			'rw' => ['Rw', Form::text("rw", old("rw"), ["class" => "form-control","placeholder" => ""]) ],
			'kelurahan' => ['Kelurahan', Form::text("kelurahan", old("kelurahan"), ["class" => "form-control","placeholder" => ""]) ],
			'kecamatan' => ['Kecamatan', Form::text("kecamatan", old("kecamatan"), ["class" => "form-control","placeholder" => ""]) ],
			'kota' => ['Kota', Form::text("kota", old("kota"), ["class" => "form-control","placeholder" => ""]) ],
			'provinsi' => ['Provinsi', Form::text("provinsi", old("provinsi"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Guru::guru_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama' => 'required',
			'nip' => 'required',
			'nik' => 'required',
			'email' => 'required',
			'no_hp' => 'required',
			'tempat_lahir' => 'required',
			'tgl_lahir' => 'required',
			'id_agama' => 'required',
			'alamat' => 'required',
			'rt' => 'required',
			'rw' => 'required',
			'kelurahan' => 'required',
			'kecamatan' => 'required',
			'kota' => 'required',
			'provinsi' => 'required',
			
		]);

		$guru = new Guru();
		$guru->nama = $request->input("nama");
		$guru->nip = $request->input("nip");
		$guru->nik = $request->input("nik");
		$guru->email = $request->input("email");
		$guru->no_hp = $request->input("no_hp");
		$guru->tempat_lahir = $request->input("tempat_lahir");
		$guru->tgl_lahir = $request->input("tgl_lahir");
		$guru->id_agama = $request->input("id_agama");
		$guru->alamat = $request->input("alamat");
		$guru->rt = $request->input("rt");
		$guru->rw = $request->input("rw");
		$guru->kelurahan = $request->input("kelurahan");
		$guru->kecamatan = $request->input("kecamatan");
		$guru->kota = $request->input("kota");
		$guru->provinsi = $request->input("provinsi");
		
		$guru->created_by = Auth::id();
		$guru->save();

		$text = 'membuat '.$this->title; //' baru '.$guru->what;
		$this->log($request, $text, ['guru.id' => $guru->id]);
		return redirect()->route('guru.index')->with('message_success', 'Guru berhasil ditambahkan!');
	}

	public function show(Request $request, Guru $guru)
	{
		$data['guru'] = $guru;

		$text = 'melihat detail '.$this->title;//.' '.$guru->what;
		$this->log($request, $text, ['guru.id' => $guru->id]);
		return view('Guru::guru_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Guru $guru)
	{
		$data['guru'] = $guru;

		$ref_agama = Agama::all()->pluck('agama','id');
		$ref_agama->prepend('-PILIH SALAH SATU-', '');
		$ref_tidak_aktif = AlasanKeluar::all()->pluck('alasan_keluar', 'id');
		$ref_tidak_aktif->prepend('-PILIH SALAH SATU-', '');
		$ref_aktif = [
			'' => '-PILIH SALAH SATU-',
			'1' => 'Aktif',
			'0' => 'Tidak Aktif'
		];
		
		$data['forms'] = array(
			'nama' => ['Nama', Form::text("nama", $guru->nama, ["class" => "form-control","placeholder" => "", "id" => "nama"]) ],
			'nip' => ['Nip', Form::text("nip", $guru->nip, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nip"]) ],
			'nik' => ['Nik', Form::text("nik", $guru->nik, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nik"]) ],
			'email' => ['Email', Form::text("email", $guru->email, ["class" => "form-control","placeholder" => "", "id" => "email"]) ],
			'no_hp' => ['No Hp', Form::text("no_hp", $guru->no_hp, ["class" => "form-control","placeholder" => "", "id" => "no_hp"]) ],
			'tempat_lahir' => ['Tempat Lahir', Form::text("tempat_lahir", $guru->tempat_lahir, ["class" => "form-control","placeholder" => "", "id" => "tempat_lahir"]) ],
			'tgl_lahir' => ['Tgl Lahir', Form::text("tgl_lahir", $guru->tgl_lahir, ["class" => "form-control datepicker", "id" => "tgl_lahir"]) ],
			'id_agama' => ['Agama', Form::select("id_agama", $ref_agama, $guru->id_agama, ["class" => "form-control select2"]) ],
			'alamat' => ['Alamat', Form::textarea("alamat", $guru->alamat, ["class" => "form-control rich-editor"]) ],
			'rt' => ['Rt', Form::text("rt", $guru->rt, ["class" => "form-control","placeholder" => "", "id" => "rt"]) ],
			'rw' => ['Rw', Form::text("rw", $guru->rw, ["class" => "form-control","placeholder" => "", "id" => "rw"]) ],
			'kelurahan' => ['Kelurahan', Form::text("kelurahan", $guru->kelurahan, ["class" => "form-control","placeholder" => "", "id" => "kelurahan"]) ],
			'kecamatan' => ['Kecamatan', Form::text("kecamatan", $guru->kecamatan, ["class" => "form-control","placeholder" => "", "id" => "kecamatan"]) ],
			'kota' => ['Kota', Form::text("kota", $guru->kota, ["class" => "form-control","placeholder" => "", "id" => "kota"]) ],
			'provinsi' => ['Provinsi', Form::text("provinsi", $guru->provinsi, ["class" => "form-control","placeholder" => "", "id" => "provinsi"]) ],
			'is_aktif' => ['Status Aktif', Form::select("is_aktif", $ref_aktif, $guru->is_aktif, ["class" => "form-control select2"]) ],
			'id_alasan_keluar' => ['Alasan Tidak Aktif', Form::select("id_alasan_keluar", $ref_tidak_aktif, $guru->id_alasan_keluar, ["class" => "form-control select2"]) ],
			'tgl_keluar' => ['Tanggal Keluar', Form::text("tgl_keluar", $guru->tgl_keluar, ["class" => "form-control datepicker","placeholder" => "Masukan Tanggal Keluar", "id" => "tgl_keluar"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$guru->what;
		$this->log($request, $text, ['guru.id' => $guru->id]);
		return view('Guru::guru_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$array_validation = [
			'nama' => 'required',
			'nip' => 'required',
			'nik' => 'required',
			'email' => 'required',
			'no_hp' => 'required',
			'tempat_lahir' => 'required',
			'tgl_lahir' => 'required',
			'id_agama' => 'required',
			'alamat' => 'required',
			'rt' => 'required',
			'rw' => 'required',
			'kelurahan' => 'required',
			'kecamatan' => 'required',
			'kota' => 'required',
			'provinsi' => 'required',
		];

		if($request->input('is_aktif') == '0')
		{
			$array_validation['id_alasan_keluar'] = 'required';
			$array_validation['tgl_keluar'] = 'required';
		}

		$this->validate($request, $array_validation);
		
		$guru = Guru::find($id);
		$guru->nama = $request->input("nama");
		$guru->nip = $request->input("nip");
		$guru->nik = $request->input("nik");
		$guru->email = $request->input("email");
		$guru->no_hp = $request->input("no_hp");
		$guru->tempat_lahir = $request->input("tempat_lahir");
		$guru->tgl_lahir = $request->input("tgl_lahir");
		$guru->id_agama = $request->input("id_agama");
		$guru->alamat = $request->input("alamat");
		$guru->rt = $request->input("rt");
		$guru->rw = $request->input("rw");
		$guru->kelurahan = $request->input("kelurahan");
		$guru->kecamatan = $request->input("kecamatan");
		$guru->kota = $request->input("kota");
		$guru->provinsi = $request->input("provinsi");
		$guru->is_aktif = $request->input("is_aktif");
		$guru->id_alasan_keluar = $request->input("id_alasan_keluar");
		$guru->tgl_keluar = $request->input("tgl_keluar");
		
		$guru->updated_by = Auth::id();
		$guru->save();


		$text = 'mengedit '.$this->title;//.' '.$guru->what;
		$this->log($request, $text, ['guru.id' => $guru->id]);
		return redirect()->route('guru.index')->with('message_success', 'Guru berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$guru = Guru::find($id);
		$guru->deleted_by = Auth::id();
		$guru->save();
		$guru->delete();

		$text = 'menghapus '.$this->title;//.' '.$guru->what;
		$this->log($request, $text, ['guru.id' => $guru->id]);
		return back()->with('message_success', 'Guru berhasil dihapus!');
	}

}
