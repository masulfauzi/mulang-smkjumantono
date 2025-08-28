<?php
namespace App\Modules\Siswa\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Siswa\Models\Siswa;
use App\Modules\Jeniskelamin\Models\Jeniskelamin;
use App\Modules\Agama\Models\Agama;

use App\Http\Controllers\Controller;
use App\Modules\Nilai\Models\Nilai;
use App\Modules\Semester\Models\Semester;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Siswa";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{

        if(session('active_role')['id'] == 'ce70ee2f-b43b-432b-b71c-30d073a4ba23')
		{
			return redirect(route('siswa.biodata.index'));
		}
        
		$query = Siswa::query();
		if($request->has('search')){
			$search = $request->get('search');
			$query->where('nama_siswa', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Siswa::siswa', array_merge($data, ['title' => $this->title]));
	}

	public function biodata_admin(Request $request)
	{
		$data['biodata'] = Siswa::get_biodata(session()->get('active_semester')['id']);

		return view('Siswa::biodata_admin', array_merge($data, ['title' => $this->title]));
	}

    public function biodata(Request $request)
	{

		if(session()->get('active_role')['id'] == '1fe8326c-22c4-4732-9c12-f7b83a16b842' or session()->get('active_role')['id'] == 'bf1548f3-295c-4d73-809d-66ab7c240091')
		{
			return redirect()->route('siswa.biodata.admin.index');
		}

		$data['data'] = Siswa::find(session('id_siswa'));

		$this->log($request, 'melihat halaman biodata');
		return view('Siswa::biodata', array_merge($data, ['title' => $this->title]));
	}

    	public function store_biodata(Request $request)
	{
		$validate = $this->validate($request, [
			'id' 			=> 'required',
			'nama_siswa' 	=> 'required',
			'tempat_lahir'	=> 'required',
			'tgl_lahir'		=> 'required|date',
			'nama_ayah'		=> 'required',
			'nama_ibu'		=> 'required',
			'alamat'		=> 'required',
			'sekolah_asal'	=> 'required',
			'no_ijazah_smp'	=> 'required',
			'no_hp'			=> 'required',
		]);

		$siswa = Siswa::find($validate['id']);
		$siswa->nama_siswa 		= $validate['nama_siswa'];
		$siswa->tempat_lahir 	= $validate['tempat_lahir'];
		$siswa->tgl_lahir		= $validate['tgl_lahir'];
		$siswa->nama_ayah		= $validate['nama_ayah'];
		$siswa->nama_ibu		= $validate['nama_ibu'];
		$siswa->alamat			= $validate['alamat'];
		$siswa->sekolah_asal	= $validate['sekolah_asal'];
		$siswa->no_ijazah_smp	= $validate['no_ijazah_smp'];
		$siswa->no_skhun		= $request->input('no_skhun');
		$siswa->no_hp			= $request->input('no_hp');

		$siswa->updated_by 		= Auth::id();
		$siswa->save();


		$text = 'Mengedit biodata';
		$this->log($request, $text, ['siswa.id' => $validate['id']]);
		return redirect()->back()->with('message_success', 'Biodata berhasil disimpan!');
	}

    public function upload_file(Request $request)
	{
		$data['data'] = Siswa::find(session('id_siswa'));

		return view('Siswa::upload_file', array_merge($data, ['title' => $this->title]));
	}

    	public function aksi_upload(Request $request)
	{
		$request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

		$file = time().'.'.$request->file->extension();  

        $request->file->move(public_path('uploads/'.$request->get('jenis')), $file);

		$siswa = Siswa::find($request->get('id'));
		if($request->get('jenis') == 'ijazah')
		{
			$siswa->file_ijazah_smp = $file;
		}
		else if($request->get('jenis') == 'skhun')
		{
			$siswa->file_skhun = $file;
		}
		else if($request->get('jenis') == 'kk')
		{
			$siswa->file_kk = $file;
		}
		else if($request->get('jenis') == 'akta')
		{
			$siswa->file_akta_lahir = $file;
		}
		$siswa->save();


		$text = 'mengupload '.$request->get('jenis'); //' baru '.$gurumapel->what;
		$this->log($request, $text);
		return redirect()->back()->with('message_success', 'Berkas berhasil diupload!');
	}

    	public function lihat_file(Request $request, $file, $jenis)
	{
		$data['file']  = $file;
		$data['jenis']  = $jenis;

		return view('Siswa::lihat_file', $data);
	}

    public function downloads(Request $request)
	{
		$data['data']	= '';
		return view('Siswa::download', array_merge($data, ['title' => $this->title]));
	}

    public function download_biodata(Request $request, $id_siswa = NULL)
	{
		if($id_siswa == NULL)
		{
			$id_siswa = session('id_siswa');
		}

		$data['data']	=	Siswa::find($id_siswa);

		if(!$data['data']->file_ijazah_smp)
		{
			// return redirect()->back()->with('message_error', 'File Ijazah SMP belum di upload');
			return "File Ijazah SMP belum di upload";
		}
		if(!$data['data']->file_kk)
		{
			// return redirect()->back()->with('message_error', 'File Kartu Keluarga belum di upload');
			return "File Kartu Keluarga belum di upload";
		}
		if(!$data['data']->file_akta_lahir)
		{
			// return redirect()->back()->with('message_error', 'File Akta Kelahiran belum di upload');
			return "File Akta Kelahiran belum di upload";
		}

		// return view("Siswa::download_biodata", array_merge($data, ['title' => $this->title]));
		$pdf = PDF::loadview('Siswa::download_biodata',$data);
    	return $pdf->download('BiodataPesertaUjian');
	}

	public function kelulusan(Request $request)
	{
		$data['siswa'] = Siswa::detail_siswa(session('id_siswa'));
		$data['semester']	= Semester::find(get_semester('active_semester_id'));

		$sekarang = Carbon::createFromTimeString(date('Y-m-d H:i:s'));
		$pengumuman = Carbon::createFromTimeString($data['semester']->wkt_kelulusan);

		// dd($sekarang);

		if ($sekarang->gt($pengumuman)) {
			// die("Tampil");
			return view('Siswa::siswa_kelulusan', array_merge($data, ['title' => $this->title]));
		}
		else
		{
			// die("Belum");
			return view('Siswa::timer_kelulusan', array_merge($data, ['title' => $this->title]));
		}

		
	}

	public function detail_siswa(Request $request, Siswa $siswa)
	{
		// $url = url()->current();
		// dd($url);

		$tab = $request->tab;

		if(!$tab)
		{
			$tab = 'biodata';
		}

		$data['tab'] = $tab;
		$data['siswa'] = $siswa;
		$data['nilai'] = Nilai::query()->whereIdSiswa($siswa->id)->get();

		$this->log($request, 'melihat halaman detail siswa '.$this->title);
		return view('Siswa::siswa_detail', array_merge($data, ['title' => $this->title]));
	}

	public function hasil_abm(Request $request)
	{
		$id_siswa = session()->get('id_siswa');

		$siswa = Siswa::find($id_siswa);

		$data['hasil'] = $siswa->nisn . ".pdf";

		$this->log($request, 'melihat halaman hasil ABM');
		return view('Siswa::siswa_abm', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_jeniskelamin = Jeniskelamin::all()->pluck('jeniskelamin','id');
		$ref_agama = Agama::all()->pluck('agama','id');
		
		$data['forms'] = array(
			'nama_siswa' => ['Nama Siswa', Form::text("nama_siswa", old("nama_siswa"), ["class" => "form-control","placeholder" => ""]) ],
			'nis' => ['Nis', Form::text("nis", old("nis"), ["class" => "form-control","placeholder" => ""]) ],
			'nisn' => ['Nisn', Form::text("nisn", old("nisn"), ["class" => "form-control","placeholder" => ""]) ],
			'nik' => ['Nik', Form::text("nik", old("nik"), ["class" => "form-control","placeholder" => ""]) ],
			'id_jeniskelamin' => ['Jeniskelamin', Form::select("id_jeniskelamin", $ref_jeniskelamin, null, ["class" => "form-control select2"]) ],
			'id_agama' => ['Agama', Form::select("id_agama", $ref_agama, null, ["class" => "form-control select2"]) ],
			'tahun_masuk' => ['Tahun Masuk', Form::text("tahun_masuk", old("tahun_masuk"), ["class" => "form-control","placeholder" => ""]) ],
			'tempat_lahir' => ['Tempat Lahir', Form::text("tempat_lahir", old("tempat_lahir"), ["class" => "form-control","placeholder" => ""]) ],
			'tgl_lahir' => ['Tgl Lahir', Form::text("tgl_lahir", old("tgl_lahir"), ["class" => "form-control datepicker"]) ],
			'nama_ayah' => ['Nama Ayah', Form::text("nama_ayah", old("nama_ayah"), ["class" => "form-control","placeholder" => ""]) ],
			'nama_ibu' => ['Nama Ibu', Form::text("nama_ibu", old("nama_ibu"), ["class" => "form-control","placeholder" => ""]) ],
			'alamat' => ['Alamat', Form::textarea("alamat", old("alamat"), ["class" => "form-control rich-editor"]) ],
			'sekolah_asal' => ['Sekolah Asal', Form::text("sekolah_asal", old("sekolah_asal"), ["class" => "form-control","placeholder" => ""]) ],
			'no_ijazah_smp' => ['No Ijazah Smp', Form::text("no_ijazah_smp", old("no_ijazah_smp"), ["class" => "form-control","placeholder" => ""]) ],
			'no_skhun' => ['No Skhun', Form::text("no_skhun", old("no_skhun"), ["class" => "form-control","placeholder" => ""]) ],
			'file_ijazah_smp' => ['File Ijazah Smp', Form::text("file_ijazah_smp", old("file_ijazah_smp"), ["class" => "form-control","placeholder" => ""]) ],
			'file_skhun' => ['File Skhun', Form::text("file_skhun", old("file_skhun"), ["class" => "form-control","placeholder" => ""]) ],
			'file_kk' => ['File Kk', Form::text("file_kk", old("file_kk"), ["class" => "form-control","placeholder" => ""]) ],
			'file_akta_lahir' => ['File Akta Lahir', Form::text("file_akta_lahir", old("file_akta_lahir"), ["class" => "form-control","placeholder" => ""]) ],
			'tgl_lulus' => ['Tgl Lulus', Form::text("tgl_lulus", old("tgl_lulus"), ["class" => "form-control datepicker"]) ],
			'is_lulus' => ['Is Lulus', Form::text("is_lulus", old("is_lulus"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Siswa::siswa_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama_siswa' => 'required',
			'nis' => 'required',
			'nisn' => 'required',
			'nik' => 'required',
			'id_jeniskelamin' => 'required',
			'id_agama' => 'required',
			'tahun_masuk' => 'required',
			'tempat_lahir' => 'required',
			'tgl_lahir' => 'required',
			'nama_ayah' => 'required',
			'nama_ibu' => 'required',
			'alamat' => 'required',
			'sekolah_asal' => 'required',
			'no_ijazah_smp' => 'required',
			'no_skhun' => 'required',
			'file_ijazah_smp' => 'required',
			'file_skhun' => 'required',
			'file_kk' => 'required',
			'file_akta_lahir' => 'required',
			'tgl_lulus' => 'required',
			'is_lulus' => 'required',
			
		]);

		$siswa = new Siswa();
		$siswa->nama_siswa = $request->input("nama_siswa");
		$siswa->nis = $request->input("nis");
		$siswa->nisn = $request->input("nisn");
		$siswa->nik = $request->input("nik");
		$siswa->id_jeniskelamin = $request->input("id_jeniskelamin");
		$siswa->id_agama = $request->input("id_agama");
		$siswa->tahun_masuk = $request->input("tahun_masuk");
		$siswa->tempat_lahir = $request->input("tempat_lahir");
		$siswa->tgl_lahir = $request->input("tgl_lahir");
		$siswa->nama_ayah = $request->input("nama_ayah");
		$siswa->nama_ibu = $request->input("nama_ibu");
		$siswa->alamat = $request->input("alamat");
		$siswa->sekolah_asal = $request->input("sekolah_asal");
		$siswa->no_ijazah_smp = $request->input("no_ijazah_smp");
		$siswa->no_skhun = $request->input("no_skhun");
		$siswa->file_ijazah_smp = $request->input("file_ijazah_smp");
		$siswa->file_skhun = $request->input("file_skhun");
		$siswa->file_kk = $request->input("file_kk");
		$siswa->file_akta_lahir = $request->input("file_akta_lahir");
		$siswa->tgl_lulus = $request->input("tgl_lulus");
		$siswa->is_lulus = $request->input("is_lulus");
		
		$siswa->created_by = Auth::id();
		$siswa->save();

		$text = 'membuat '.$this->title; //' baru '.$siswa->what;
		$this->log($request, $text, ['siswa.id' => $siswa->id]);
		return redirect()->route('siswa.index')->with('message_success', 'Siswa berhasil ditambahkan!');
	}

	public function show(Request $request, Siswa $siswa)
	{
		$data['siswa'] = $siswa;

		$text = 'melihat detail '.$this->title;//.' '.$siswa->what;
		$this->log($request, $text, ['siswa.id' => $siswa->id]);
		return view('Siswa::siswa_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Siswa $siswa)
	{
		$data['siswa'] = $siswa;

		$ref_jeniskelamin = Jeniskelamin::all()->pluck('jeniskelamin','id');
		$ref_agama = Agama::all()->pluck('agama','id');
		
		$data['forms'] = array(
			'nama_siswa' => ['Nama Siswa', Form::text("nama_siswa", $siswa->nama_siswa, ["class" => "form-control","placeholder" => "", "id" => "nama_siswa"]) ],
			'nis' => ['Nis', Form::text("nis", $siswa->nis, ["class" => "form-control","placeholder" => "", "id" => "nis"]) ],
			'nisn' => ['Nisn', Form::text("nisn", $siswa->nisn, ["class" => "form-control","placeholder" => "", "id" => "nisn"]) ],
			'nik' => ['Nik', Form::text("nik", $siswa->nik, ["class" => "form-control","placeholder" => "", "id" => "nik"]) ],
			'id_jeniskelamin' => ['Jeniskelamin', Form::select("id_jeniskelamin", $ref_jeniskelamin, null, ["class" => "form-control select2"]) ],
			'id_agama' => ['Agama', Form::select("id_agama", $ref_agama, null, ["class" => "form-control select2"]) ],
			'tahun_masuk' => ['Tahun Masuk', Form::text("tahun_masuk", $siswa->tahun_masuk, ["class" => "form-control","placeholder" => "", "id" => "tahun_masuk"]) ],
			'tempat_lahir' => ['Tempat Lahir', Form::text("tempat_lahir", $siswa->tempat_lahir, ["class" => "form-control","placeholder" => "", "id" => "tempat_lahir"]) ],
			'tgl_lahir' => ['Tgl Lahir', Form::text("tgl_lahir", $siswa->tgl_lahir, ["class" => "form-control datepicker", "id" => "tgl_lahir"]) ],
			'nama_ayah' => ['Nama Ayah', Form::text("nama_ayah", $siswa->nama_ayah, ["class" => "form-control","placeholder" => "", "id" => "nama_ayah"]) ],
			'nama_ibu' => ['Nama Ibu', Form::text("nama_ibu", $siswa->nama_ibu, ["class" => "form-control","placeholder" => "", "id" => "nama_ibu"]) ],
			'alamat' => ['Alamat', Form::textarea("alamat", $siswa->alamat, ["class" => "form-control rich-editor"]) ],
			'sekolah_asal' => ['Sekolah Asal', Form::text("sekolah_asal", $siswa->sekolah_asal, ["class" => "form-control","placeholder" => "", "id" => "sekolah_asal"]) ],
			'no_ijazah_smp' => ['No Ijazah Smp', Form::text("no_ijazah_smp", $siswa->no_ijazah_smp, ["class" => "form-control","placeholder" => "", "id" => "no_ijazah_smp"]) ],
			'no_skhun' => ['No Skhun', Form::text("no_skhun", $siswa->no_skhun, ["class" => "form-control","placeholder" => "", "id" => "no_skhun"]) ],
			'file_ijazah_smp' => ['File Ijazah Smp', Form::text("file_ijazah_smp", $siswa->file_ijazah_smp, ["class" => "form-control","placeholder" => "", "id" => "file_ijazah_smp"]) ],
			'file_skhun' => ['File Skhun', Form::text("file_skhun", $siswa->file_skhun, ["class" => "form-control","placeholder" => "", "id" => "file_skhun"]) ],
			'file_kk' => ['File Kk', Form::text("file_kk", $siswa->file_kk, ["class" => "form-control","placeholder" => "", "id" => "file_kk"]) ],
			'file_akta_lahir' => ['File Akta Lahir', Form::text("file_akta_lahir", $siswa->file_akta_lahir, ["class" => "form-control","placeholder" => "", "id" => "file_akta_lahir"]) ],
			'tgl_lulus' => ['Tgl Lulus', Form::text("tgl_lulus", $siswa->tgl_lulus, ["class" => "form-control datepicker", "id" => "tgl_lulus"]) ],
			'is_lulus' => ['Is Lulus', Form::text("is_lulus", $siswa->is_lulus, ["class" => "form-control","placeholder" => "", "id" => "is_lulus"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$siswa->what;
		$this->log($request, $text, ['siswa.id' => $siswa->id]);
		return view('Siswa::siswa_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama_siswa' => 'required',
			'nis' => 'required',
			'nisn' => 'required',
			'nik' => 'required',
			'id_jeniskelamin' => 'required',
			'id_agama' => 'required',
			'tahun_masuk' => 'required',
			'tempat_lahir' => 'required',
			'tgl_lahir' => 'required',
			'nama_ayah' => 'required',
			'nama_ibu' => 'required',
			'alamat' => 'required',
			'sekolah_asal' => 'required',
			'no_ijazah_smp' => 'required',
			'no_skhun' => 'required',
			'file_ijazah_smp' => 'required',
			'file_skhun' => 'required',
			'file_kk' => 'required',
			'file_akta_lahir' => 'required',
			'tgl_lulus' => 'required',
			'is_lulus' => 'required',
			
		]);
		
		$siswa = Siswa::find($id);
		$siswa->nama_siswa = $request->input("nama_siswa");
		$siswa->nis = $request->input("nis");
		$siswa->nisn = $request->input("nisn");
		$siswa->nik = $request->input("nik");
		$siswa->id_jeniskelamin = $request->input("id_jeniskelamin");
		$siswa->id_agama = $request->input("id_agama");
		$siswa->tahun_masuk = $request->input("tahun_masuk");
		$siswa->tempat_lahir = $request->input("tempat_lahir");
		$siswa->tgl_lahir = $request->input("tgl_lahir");
		$siswa->nama_ayah = $request->input("nama_ayah");
		$siswa->nama_ibu = $request->input("nama_ibu");
		$siswa->alamat = $request->input("alamat");
		$siswa->sekolah_asal = $request->input("sekolah_asal");
		$siswa->no_ijazah_smp = $request->input("no_ijazah_smp");
		$siswa->no_skhun = $request->input("no_skhun");
		$siswa->file_ijazah_smp = $request->input("file_ijazah_smp");
		$siswa->file_skhun = $request->input("file_skhun");
		$siswa->file_kk = $request->input("file_kk");
		$siswa->file_akta_lahir = $request->input("file_akta_lahir");
		$siswa->tgl_lulus = $request->input("tgl_lulus");
		$siswa->is_lulus = $request->input("is_lulus");
		
		$siswa->updated_by = Auth::id();
		$siswa->save();


		$text = 'mengedit '.$this->title;//.' '.$siswa->what;
		$this->log($request, $text, ['siswa.id' => $siswa->id]);
		return redirect()->route('siswa.index')->with('message_success', 'Siswa berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$siswa = Siswa::find($id);
		$siswa->deleted_by = Auth::id();
		$siswa->save();
		$siswa->delete();

		$text = 'menghapus '.$this->title;//.' '.$siswa->what;
		$this->log($request, $text, ['siswa.id' => $siswa->id]);
		return back()->with('message_success', 'Siswa berhasil dihapus!');
	}

}
