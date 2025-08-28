<?php
namespace App\Modules\Pesertadidik\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use App\Modules\Semester\Models\Semester;
use App\Modules\Siswa\Models\Siswa;
use App\Modules\Kelas\Models\Kelas;

use App\Http\Controllers\Controller;
use App\Modules\Tingkat\Models\Tingkat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesertadidikController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Pesertadidik";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{

		if((session('active_role')['id'] == 'f6622918-84dd-42b4-a7b4-f78ca35a8614') OR (session('active_role')['id'] == '7e30f046-7af4-44b7-8d9a-9294ed93abfd'))
		{
			return redirect()->route('pesertadidik.data.index');
		}

		$query = Pesertadidik::query()->whereIdSemester(get_semester('active_semester_id'));
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Pesertadidik::pesertadidik', array_merge($data, ['title' => $this->title]));
	}

	public function data(Request $request)
	{
		$data['tingkat'] = Tingkat::all()->sortBy('tingkat')->pluck('tingkat', 'id');
		$data['tingkat']->prepend('-PILIH SALAH SATU-', '');
		$data['filter']['tingkat'] = $request->input('tingkat');
		

		$pesertadidik = Pesertadidik::query()
									->join('siswa as a', 'a.id', 'pesertadidik.id_siswa')
									->join('kelas as b', 'b.id', 'pesertadidik.id_kelas')
									->join('jurusan as c', 'c.id', 'b.id_jurusan')
									->join('jeniskelamin as d', 'a.id_jeniskelamin', 'd.id')
									->join('agama as e', 'a.id_agama', 'e.id')
									->whereIdSemester(session('active_semester')['id']);
		
		if($request->has('tingkat'))
		{
			$pesertadidik->where('b.id_tingkat', $request->input('tingkat'));
			
		}
									

		$perjurusan = clone $pesertadidik;
		$jenis_kelamin = clone $pesertadidik;
		$jk = clone $pesertadidik;
		$agama = clone $pesertadidik;
		$kelas = clone $pesertadidik;

		$data['kelas'] = $kelas->select('b.kelas', 
										DB::raw("sum(if(a.id_jeniskelamin = '3faaf482-206c-4bdb-9a77-5dc78bbb16a6', 1, 0)) as 'laki_laki'"),
										DB::raw("sum(if(a.id_jeniskelamin = 'a26cae71-5de5-457a-bba2-dc8ff4bfb29a', 1, 0)) as 'perempuan'"))
								->groupBy('b.id')
								->get();

		$data['agama'] = $agama->select('e.agama', DB::raw("count('a.*') as jml"))
								->groupBy('a.id_agama')
								->get();

		$data['jk'] = $jk->select('d.jeniskelamin', DB::raw("count('a.*') as jml"))
									->groupBy('a.id_jeniskelamin')
									->get();

		

		$data['perjurusan'] = $perjurusan->select('c.jurusan', DB::raw("count('a.*') as jml"))
											->groupBy('b.id_jurusan')
											->get();
		
		$data['jenis_kelamin'] = $jenis_kelamin->select('c.jurusan', 
														DB::raw("sum(if(a.id_jeniskelamin = '3faaf482-206c-4bdb-9a77-5dc78bbb16a6', 1, 0)) as 'laki_laki'"),
														DB::raw("sum(if(a.id_jeniskelamin = 'a26cae71-5de5-457a-bba2-dc8ff4bfb29a', 1, 0)) as 'perempuan'"))
												->groupBy('b.id_jurusan')
												->get();

		

		// dd($data['jk']);

		// dd($pesertadidik);

		return view('Pesertadidik::pesertadidik_data', array_merge($data, ['title' => $this->title]));
	}

	public function mutasi(Request $request)
	{
		return view('Pesertadidik::mutasi');
	}

	public function cetak_mutasi(Request $request)
	{
		$data['data'] = Pesertadidik::get_all(get_semester('active_semester_id'));

		return view('Pesertadidik::cetak_mutasi', $data);
	}

	public function create(Request $request)
	{
		$ref_siswa = Siswa::all()->pluck('nama_siswa','id');
		$ref_kelas = Kelas::all()->pluck('kelas','id');

		$ref_siswa->prepend('-PILIH SALAH SATU-', '');
		$ref_kelas->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			'id_semester' => ['', Form::hidden("id_semester", get_semester('active_semester_id'), ["class" => "form-control"]) ],
			'id_siswa' => ['Siswa', Form::select("id_siswa", $ref_siswa, null, ["class" => "form-control select2"]) ],
			'id_kelas' => ['Kelas', Form::select("id_kelas", $ref_kelas, null, ["class" => "form-control select2"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Pesertadidik::pesertadidik_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_siswa' => 'required',
			'id_kelas' => 'required',
			
		]);

		$pesertadidik = new Pesertadidik();
		$pesertadidik->id_semester = $request->input("id_semester");
		$pesertadidik->id_siswa = $request->input("id_siswa");
		$pesertadidik->id_kelas = $request->input("id_kelas");
		
		$pesertadidik->created_by = Auth::id();
		$pesertadidik->save();

		$text = 'membuat '.$this->title; //' baru '.$pesertadidik->what;
		$this->log($request, $text, ['pesertadidik.id' => $pesertadidik->id]);
		return redirect()->route('pesertadidik.index')->with('message_success', 'Pesertadidik berhasil ditambahkan!');
	}

	public function show(Request $request, Pesertadidik $pesertadidik)
	{
		$data['pesertadidik'] = $pesertadidik;

		$text = 'melihat detail '.$this->title;//.' '.$pesertadidik->what;
		$this->log($request, $text, ['pesertadidik.id' => $pesertadidik->id]);
		return view('Pesertadidik::pesertadidik_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Pesertadidik $pesertadidik)
	{
		$data['pesertadidik'] = $pesertadidik;

		$ref_semester = Semester::all()->pluck('semester','id');
		$ref_siswa = Siswa::all()->pluck('nama_siswa','id');
		$ref_kelas = Kelas::all()->pluck('kelas','id');
		
		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"]) ],
			'id_siswa' => ['Siswa', Form::select("id_siswa", $ref_siswa, null, ["class" => "form-control select2"]) ],
			'id_kelas' => ['Kelas', Form::select("id_kelas", $ref_kelas, null, ["class" => "form-control select2"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$pesertadidik->what;
		$this->log($request, $text, ['pesertadidik.id' => $pesertadidik->id]);
		return view('Pesertadidik::pesertadidik_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_siswa' => 'required',
			'id_kelas' => 'required',
			
		]);
		
		$pesertadidik = Pesertadidik::find($id);
		$pesertadidik->id_semester = $request->input("id_semester");
		$pesertadidik->id_siswa = $request->input("id_siswa");
		$pesertadidik->id_kelas = $request->input("id_kelas");
		
		$pesertadidik->updated_by = Auth::id();
		$pesertadidik->save();


		$text = 'mengedit '.$this->title;//.' '.$pesertadidik->what;
		$this->log($request, $text, ['pesertadidik.id' => $pesertadidik->id]);
		return redirect()->route('pesertadidik.index')->with('message_success', 'Pesertadidik berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$pesertadidik = Pesertadidik::find($id);
		$pesertadidik->deleted_by = Auth::id();
		$pesertadidik->save();
		$pesertadidik->delete();

		$text = 'menghapus '.$this->title;//.' '.$pesertadidik->what;
		$this->log($request, $text, ['pesertadidik.id' => $pesertadidik->id]);
		return back()->with('message_success', 'Pesertadidik berhasil dihapus!');
	}

}
