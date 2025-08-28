<?php
namespace App\Modules\Peringkat\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Peringkat\Models\Peringkat;
use App\Modules\Siswa\Models\Siswa;
use App\Modules\Semester\Models\Semester;

use App\Http\Controllers\Controller;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Kelas\Models\Kelas;
use App\Modules\Nilai\Models\Nilai;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use Illuminate\Support\Facades\Auth;

use function Clue\StreamFilter\prepend;

class PeringkatController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Peringkat";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$data['selected'] = [
			'id_semester' 	=> $request->id_semester,
			'id_jurusan'	=> $request->id_jurusan,
			'id_kelas'		=> $request->id_kelas
		];

		// dd($data);

		$data['jurusan'] 	= Jurusan::all()->pluck('jurusan', 'id');
		$data['jurusan']->prepend('-PILIH SALAH SATU-', '');
		$data['kelas'] 		= Kelas::orderBy('kelas')->get()->pluck('kelas', 'id');
		$data['kelas']->prepend('-PILIH SALAH SATU-', '');
		$data['semester']	= Semester::orderBy('urutan')->get()->pluck('semester', 'id');
		$data['semester']->prepend('-PILIH SALAH SATU-', '');

		if($request->id_kelas)
		{
			$data['data'] = Peringkat::get_peringkat_kelas($data['selected'], session('active_semester')['id']);

			// dd($data['data']);
		}
		else
		{
			$data['data'] = Peringkat::get_peringkat_jurusan($data['selected'], session('active_semester')['id']);
		}

		
		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Peringkat::peringkat', array_merge($data, ['title' => $this->title]));
	}

	public function generate(Request $request, $id_semester)
	{
		$siswa = Pesertadidik::select('s.id')
								->join('siswa as s', 's.id', '=', 'pesertadidik.id_siswa')
								->join('kelas as k', 'k.id', '=', 'pesertadidik.id_kelas')
								->join('tingkat as t', 't.id', '=', 'k.id_tingkat')
								->where('pesertadidik.id_semester', session('active_semester')['id'])
								->where('t.tingkat', 'XII')
								->get();


		// compile data nilai ke tabel peringkat

		foreach($siswa as $item_siswa)
		{
			$jml_nilai = 0;
			$nilai = Nilai::whereIdSemester($id_semester)->whereIdSiswa($item_siswa->id)->get();

			foreach($nilai as $item_nilai)
			{
				$jml_nilai += $item_nilai->nilai;
			}
			
			$peringkat = new Peringkat();

			$peringkat->id_siswa = $item_siswa->id;
			$peringkat->id_semester = $id_semester;
			$peringkat->jml_nilai = $jml_nilai;

			$peringkat->created_by = Auth::id();
			$peringkat->save();

		}


		$this->log($request, 'melakukan generate peringkat '.$this->title);
		return redirect()->back()->with('message_success', 'Peringkat berhasil di generate');
	}

	public function create(Request $request)
	{
		$ref_siswa = Siswa::all()->pluck('nama_siswa','id');
		$ref_semester = Semester::all()->pluck('semester','id');
		
		$data['forms'] = array(
			'id_siswa' => ['Siswa', Form::select("id_siswa", $ref_siswa, null, ["class" => "form-control select2"]) ],
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'jml_nilai' => ['Jml Nilai', Form::text("jml_nilai", old("jml_nilai"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Peringkat::peringkat_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_siswa' => 'required',
			'id_semester' => 'required',
			'jml_nilai' => 'required',
			
		]);

		$peringkat = new Peringkat();
		$peringkat->id_siswa = $request->input("id_siswa");
		$peringkat->id_semester = $request->input("id_semester");
		$peringkat->jml_nilai = $request->input("jml_nilai");
		
		$peringkat->created_by = Auth::id();
		$peringkat->save();

		$text = 'membuat '.$this->title; //' baru '.$peringkat->what;
		$this->log($request, $text, ['peringkat.id' => $peringkat->id]);
		return redirect()->route('peringkat.index')->with('message_success', 'Peringkat berhasil ditambahkan!');
	}

	public function show(Request $request, Peringkat $peringkat)
	{
		$data['peringkat'] = $peringkat;

		$text = 'melihat detail '.$this->title;//.' '.$peringkat->what;
		$this->log($request, $text, ['peringkat.id' => $peringkat->id]);
		return view('Peringkat::peringkat_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Peringkat $peringkat)
	{
		$data['peringkat'] = $peringkat;

		$ref_siswa = Siswa::all()->pluck('nama_siswa','id');
		$ref_semester = Semester::all()->pluck('semester','id');
		
		$data['forms'] = array(
			'id_siswa' => ['Siswa', Form::select("id_siswa", $ref_siswa, null, ["class" => "form-control select2"]) ],
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'jml_nilai' => ['Jml Nilai', Form::text("jml_nilai", $peringkat->jml_nilai, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$peringkat->what;
		$this->log($request, $text, ['peringkat.id' => $peringkat->id]);
		return view('Peringkat::peringkat_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_siswa' => 'required',
			'id_semester' => 'required',
			'jml_nilai' => 'required',
			
		]);
		
		$peringkat = Peringkat::find($id);
		$peringkat->id_siswa = $request->input("id_siswa");
		$peringkat->id_semester = $request->input("id_semester");
		$peringkat->jml_nilai = $request->input("jml_nilai");
		
		$peringkat->updated_by = Auth::id();
		$peringkat->save();


		$text = 'mengedit '.$this->title;//.' '.$peringkat->what;
		$this->log($request, $text, ['peringkat.id' => $peringkat->id]);
		return redirect()->route('peringkat.index')->with('message_success', 'Peringkat berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$peringkat = Peringkat::find($id);
		$peringkat->deleted_by = Auth::id();
		$peringkat->save();
		$peringkat->delete();

		$text = 'menghapus '.$this->title;//.' '.$peringkat->what;
		$this->log($request, $text, ['peringkat.id' => $peringkat->id]);
		return back()->with('message_success', 'Peringkat berhasil dihapus!');
	}

}
