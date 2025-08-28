<?php
namespace App\Modules\Ujiansekolah\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Ujiansekolah\Models\Ujiansekolah;
use App\Modules\Semester\Models\Semester;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Guru\Models\Guru;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Soal\Models\Soal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Illuminate\Support\Str;

class UjiansekolahController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Ujiansekolah";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		if(session('active_role')['id'] == '9ec7541e-5a5e-4a3a-a255-6ffb46895f46')
		{
			return redirect(route('ujiansekolah.guru.index'));
		}

		$query = Ujiansekolah::whereIdSemester(get_semester('active_semester_id'));
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(20)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Ujiansekolah::ujiansekolah', array_merge($data, ['title' => $this->title]));
	}

	public function index_guru(Request $request)
	{
		$query = Ujiansekolah::whereIdSemester(get_semester('active_semester_id'))->whereIdGuru(session('id_guru'));
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Ujiansekolah::ujiansekolah_kelengkapan', array_merge($data, ['title' => $this->title]));
	}

	public function upload(Request $request, $id_ujian)
	{
		$data['data'] 		= Ujiansekolah::find($id_ujian);
		$data['soal_utama'] = Soal::whereIdUjiansekolah($id_ujian)->whereIdJenissoal('c365b003-7203-4e5d-b215-1f934238db2f');
		$data['soal_susulan'] = Soal::whereIdUjiansekolah($id_ujian)->whereIdJenissoal('068aa935-e996-4f86-9689-3da4a9aee8f5');

		$this->log($request, 'melihat halaman upload data '.$this->title);
		return view('Ujiansekolah::ujiansekolah_upload', array_merge($data, ['title' => $this->title]));
	}

	public function aksi_upload(Request $request)
	{
		$request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:10240'
        ]);

		$fileName = time().'.'.$request->file->extension();  

        $request->file->move(public_path('uploads/'.$request->get('jenis')), $fileName);

		$ujian = Ujiansekolah::find($request->get('id'));
		if($request->get('jenis') == 'kisikisi')
		{
			$ujian->kisi_kisi = $fileName;
		}
		else if($request->get('jenis') == 'norma')
		{
			$ujian->norma_penilaian = $fileName;
		}
		else if($request->get('jenis') == 'soal')
		{
			$ujian->soal = $fileName;
		}
		$ujian->save();
		

		$text = 'mengupload '.$this->title; //' baru '.$gurumapel->what;
		$this->log($request, $text);
		return redirect()->route('ujiansekolah.guru.upload.index', $request->get('id'))->with('message_success', 'Berkas berhasil diupload!');
	}

	public function upload_excel(Request $request)
	{
		$request->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240'
        ]);

		// dd($request);

		$soal = $request->file('file');

		try{
			$spreadsheet = IOFactory::load($soal->getRealPath());
			$sheet        = $spreadsheet->getActiveSheet();
			$row_limit    = $sheet->getHighestDataRow();
			$column_limit = $sheet->getHighestDataColumn();
			$row_range    = range( 2, $row_limit );
			$column_range = range( 'F', $column_limit );
			$startcount = 2;
			$data = array();
			foreach ( $row_range as $row ) {
				$data[] = [
					'id'				=> Str::uuid(),
					'id_ujiansekolah'	=> $request->input('id'),
					'id_jenissoal'		=> $request->input('id_jenissoal'),
					'no_soal' =>$sheet->getCell( 'A' . $row )->getValue(),
					'soal' => $sheet->getCell( 'B' . $row )->getValue(),
					'opsi_a' => $sheet->getCell( 'C' . $row )->getValue(),
					'opsi_b' => $sheet->getCell( 'D' . $row )->getValue(),
					'opsi_c' => $sheet->getCell( 'E' . $row )->getValue(),
					'opsi_d' =>$sheet->getCell( 'F' . $row )->getValue(),
					'opsi_e' =>$sheet->getCell( 'G' . $row )->getValue(),
					'kunci' =>$sheet->getCell( 'H' . $row )->getValue(),
				];
				$startcount++;
			}

			// Soal::where(['id_ujiansekolah' => $request->input('id'), 'id_jenissoal' => $request->input('id_jenissoal')])->delete();
			Soal::where('id_ujiansekolah', $request->input('id'))->where('id_jenissoal', $request->input('id_jenissoal'))->forceDelete();
			Soal::insert($data);

			$text = 'mengupload soal'.$this->title; //' baru '.$gurumapel->what;
			$this->log($request, $text);
			return redirect()->route('ujiansekolah.guru.upload.index', $request->get('id'))->with('message_success', 'Soal berhasil diupload!');

		} catch (Exception $e) {
			$error_code = $e->errorInfo[1];
			return back()->withErrors('There was a problem uploading the data!');
		}

		
	}

	public function create(Request $request)
	{
		$ref_mapel = Mapel::all()->sortBy('mapel')->pluck('mapel','id');
		$ref_guru = Guru::all()->sortBy('nama')->pluck('nama','id');
		$ref_jurusan = Jurusan::all()->pluck('jurusan','id');

		$ref_guru->prepend('-PILIH SALAH SATU-', '');
		$ref_mapel->prepend('-PILIH SALAH SATU-', '');
		$ref_jurusan->prepend('-PILIH SALAH SATU-', '');
		
		
		$data['forms'] = array(
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, null, ["class" => "form-control select2"]) ],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, null, ["class" => "form-control select2"]) ],
			'id_jurusan' => ['Jurusan', Form::select("id_jurusan", $ref_jurusan, null, ["class" => "form-control select2"]) ],
			'jml_soal' => ['Jumlah Soal', Form::text("jml_soal", NULL, ["class" => "form-control"]) ],
			'id_semester' => ['', Form::hidden("id_semester", get_semester('active_semester_id'), null) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Ujiansekolah::ujiansekolah_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_mapel' => 'required',
			'id_guru' => 'required',
			'id_jurusan' => 'required',
			'jml_soal' => 'required|numeric',
			
		]);

		$ujiansekolah = new Ujiansekolah();
		$ujiansekolah->id_semester = $request->input("id_semester");
		$ujiansekolah->id_mapel = $request->input("id_mapel");
		$ujiansekolah->id_guru = $request->input("id_guru");
		$ujiansekolah->kisi_kisi = $request->input("kisi_kisi");
		$ujiansekolah->norma_penilaian = $request->input("norma_penilaian");
		$ujiansekolah->id_jurusan = $request->input("id_jurusan");
		$ujiansekolah->jml_soal = $request->input("jml_soal");
		
		$ujiansekolah->created_by = Auth::id();
		$ujiansekolah->save();

		$text = 'membuat '.$this->title; //' baru '.$ujiansekolah->what;
		$this->log($request, $text, ['ujiansekolah.id' => $ujiansekolah->id]);
		return redirect()->route('ujiansekolah.index')->with('message_success', 'Ujiansekolah berhasil ditambahkan!');
	}

	public function show(Request $request, Ujiansekolah $ujiansekolah)
	{
		$data['ujiansekolah'] = $ujiansekolah;

		$text = 'melihat detail '.$this->title;//.' '.$ujiansekolah->what;
		$this->log($request, $text, ['ujiansekolah.id' => $ujiansekolah->id]);
		return view('Ujiansekolah::ujiansekolah_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Ujiansekolah $ujiansekolah)
	{
		$data['ujiansekolah'] = $ujiansekolah;

		$ref_mapel = Mapel::all()->sortBy('mapel')->pluck('mapel','id');
		$ref_guru = Guru::all()->sortBy('nama')->pluck('nama','id');
		$ref_jurusan = Jurusan::all()->pluck('jurusan','id');

		$ref_guru->prepend('-PILIH SALAH SATU-', '');
		$ref_mapel->prepend('-PILIH SALAH SATU-', '');
		$ref_jurusan->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			
			'id_guru' => ['Guru', Form::select("id_guru", $ref_guru, $data['ujiansekolah']['id_guru'], ["class" => "form-control select2"]) ],
			'id_mapel' => ['Mapel', Form::select("id_mapel", $ref_mapel, $data['ujiansekolah']['id_mapel'], ["class" => "form-control select2"]) ],
			'id_jurusan' => ['Jurusan', Form::select("id_jurusan", $ref_jurusan, $data['ujiansekolah']['id_jurusan'], ["class" => "form-control select2"]) ],
			'jml_soal' => ['Jumlah Soal', Form::text("id_jurusan", $data['ujiansekolah']['jml_soal'], ["class" => "form-control"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$ujiansekolah->what;
		$this->log($request, $text, ['ujiansekolah.id' => $ujiansekolah->id]);
		return view('Ujiansekolah::ujiansekolah_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_mapel' => 'required',
			'id_guru' => 'required',
			'id_jurusan' => 'required',
			
		]);
		
		$ujiansekolah = Ujiansekolah::find($id);
		$ujiansekolah->id_mapel = $request->input("id_mapel");
		$ujiansekolah->id_guru = $request->input("id_guru");
		$ujiansekolah->id_jurusan = $request->input("id_jurusan");
		$ujiansekolah->jml_soal = $request->input("jml_soal");
		
		$ujiansekolah->updated_by = Auth::id();
		$ujiansekolah->save();


		$text = 'mengedit '.$this->title;//.' '.$ujiansekolah->what;
		$this->log($request, $text, ['ujiansekolah.id' => $ujiansekolah->id]);
		return redirect()->route('ujiansekolah.index')->with('message_success', 'Ujiansekolah berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$ujiansekolah = Ujiansekolah::find($id);
		$ujiansekolah->deleted_by = Auth::id();
		$ujiansekolah->save();
		$ujiansekolah->delete();

		$text = 'menghapus '.$this->title;//.' '.$ujiansekolah->what;
		$this->log($request, $text, ['ujiansekolah.id' => $ujiansekolah->id]);
		return back()->with('message_success', 'Ujiansekolah berhasil dihapus!');
	}

}
