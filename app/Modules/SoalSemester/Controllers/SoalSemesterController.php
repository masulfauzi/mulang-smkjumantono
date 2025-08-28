<?php
namespace App\Modules\SoalSemester\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\SoalSemester\Models\SoalSemester;
use App\Modules\UjianSemester\Models\UjianSemester;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SoalSemesterController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Soal Semester";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = SoalSemester::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('SoalSemester::soalsemester', array_merge($data, ['title' => $this->title]));
	}

	public function lihat_soal(Request $request, $id_ujian)
	{
		$data['soal'] = SoalSemester::whereIdUjiansemester($id_ujian)->orderBy("no_soal")->get();

		return view('Soal::lihat_soal', $data);
	}

	public function input(Request $request, $id_ujian, $no_soal)
	{
		$soal = SoalSemester::cek_soal($id_ujian, $no_soal);

		$data['id_ujian']		= $id_ujian;
		$data['no_soal']		= $no_soal;
		$data['ujian']			= UjianSemester::find($id_ujian);
		$data['soal_terinput']	= SoalSemester::whereIdUjiansemester($id_ujian)->pluck("kunci", "no_soal");

		if($soal->count() > 0)
		{
			$data['soal'] = $soal->first();
			$this->log($request, 'membuka form tambah '.$this->title);
			return view('SoalSemester::soal_edit', array_merge($data, ['title' => $this->title]));
		}
		else
		{
			$this->log($request, 'membuka form tambah '.$this->title);
			return view('SoalSemester::soal_input', array_merge($data, ['title' => $this->title]));
		}
	}

	public function create(Request $request)
	{
		$ref_ujian_semester = UjianSemester::all()->pluck('id_semester','id');
		
		$data['forms'] = array(
			'id_ujiansemester' => ['Ujiansemester', Form::select("id_ujiansemester", $ref_ujian_semester, null, ["class" => "form-control select2"]) ],
			'no_soal' => ['No Soal', Form::text("no_soal", old("no_soal"), ["class" => "form-control","placeholder" => ""]) ],
			'soal' => ['Soal', Form::text("soal", old("soal"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar' => ['Gambar', Form::text("gambar", old("gambar"), ["class" => "form-control","placeholder" => ""]) ],
			'opsi_a' => ['Opsi A', Form::text("opsi_a", old("opsi_a"), ["class" => "form-control","placeholder" => ""]) ],
			'opsi_b' => ['Opsi B', Form::text("opsi_b", old("opsi_b"), ["class" => "form-control","placeholder" => ""]) ],
			'opsi_c' => ['Opsi C', Form::text("opsi_c", old("opsi_c"), ["class" => "form-control","placeholder" => ""]) ],
			'opsi_d' => ['Opsi D', Form::text("opsi_d", old("opsi_d"), ["class" => "form-control","placeholder" => ""]) ],
			'opsi_e' => ['Opsi E', Form::text("opsi_e", old("opsi_e"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar_a' => ['Gambar A', Form::text("gambar_a", old("gambar_a"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar_b' => ['Gambar B', Form::text("gambar_b", old("gambar_b"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar_c' => ['Gambar C', Form::text("gambar_c", old("gambar_c"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar_d' => ['Gambar D', Form::text("gambar_d", old("gambar_d"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar_e' => ['Gambar E', Form::text("gambar_e", old("gambar_e"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('SoalSemester::soalsemester_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		// dd($request->input("soal"));

		$this->validate($request, [
			'id_ujiansemester' => 'required',
			'no_soal' => 'required',
			// 'soal' => 'required',
			// 'gambar' => 'required',
			// 'opsi_a' => 'required',
			// 'opsi_b' => 'required',
			// 'opsi_c' => 'required',
			// 'opsi_d' => 'required',
			// 'opsi_e' => 'required',
			// 'gambar_a' => 'required',
			// 'gambar_b' => 'required',
			// 'gambar_c' => 'required',
			// 'gambar_d' => 'required',
			'kunci' => 'required',
			
		]);

		$soal = new SoalSemester();
		$soal->id_ujiansemester = $request->input("id_ujiansemester");
		$soal->no_soal = $request->input("no_soal");
		$soal->soal = $request->input("soal");

		if($request->hasFile('gambar'))
		{
			$gambar = time().'.'.$request->gambar->extension();  

        	$request->gambar->move(public_path('ujian/soal'), $gambar);
			$soal->gambar = $gambar;
		}
		
		$soal->opsi_a = $request->input("opsi_a");
		$soal->opsi_b = $request->input("opsi_b");
		$soal->opsi_c = $request->input("opsi_c");
		$soal->opsi_d = $request->input("opsi_d");
		$soal->opsi_e = $request->input("opsi_e");

		if($request->hasFile('gambar_a'))
		{
			$opsi_a = "a_" . time().'.'.$request->gambar_a->extension();  

        	$request->gambar_a->move(public_path('ujian/jawaban'), $opsi_a);
			$soal->gambar_a = $opsi_a;
		}

		if($request->hasFile('gambar_b'))
		{
			$opsi_b = "b_" . time().'.'.$request->gambar_b->extension();  

        	$request->gambar_b->move(public_path('ujian/jawaban'), $opsi_b);
			$soal->gambar_b = $opsi_b;
		}

		if($request->hasFile('gambar_c'))
		{
			$opsi_c = "c_" . time().'.'.$request->gambar_c->extension();  

        	$request->gambar_c->move(public_path('ujian/jawaban'), $opsi_c);
			$soal->gambar_c = $opsi_c;
		}

		if($request->hasFile('gambar_d'))
		{
			$opsi_d = "d_" . time().'.'.$request->gambar_d->extension();  

        	$request->gambar_d->move(public_path('ujian/jawaban'), $opsi_d);
			$soal->gambar_d = $opsi_d;
		}

		if($request->hasFile('gambar_e'))
		{
			$opsi_e = "e_" . time().'.'.$request->gambar_e->extension();  

        	$request->gambar_e->move(public_path('ujian/jawaban'), $opsi_e);
			$soal->gambar_e = $opsi_e;
		}

		$soal->kunci = $request->input("kunci");
		
		$soal->created_by = Auth::id();
		$soal->save();

		$text = 'membuat '.$this->title; //' baru '.$soal->what;
		$this->log($request, $text, ['soal.id' => $soal->id]);
		return redirect()->back()->with('message_success', 'Soal berhasil ditambahkan!');
	}

	public function show(Request $request, SoalSemester $soalsemester)
	{
		$data['soalsemester'] = $soalsemester;

		$text = 'melihat detail '.$this->title;//.' '.$soalsemester->what;
		$this->log($request, $text, ['soalsemester.id' => $soalsemester->id]);
		return view('SoalSemester::soalsemester_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, SoalSemester $soalsemester)
	{
		$data['soalsemester'] = $soalsemester;

		$ref_ujian_semester = UjianSemester::all()->pluck('id_semester','id');
		
		$data['forms'] = array(
			'id_ujiansemester' => ['Ujiansemester', Form::select("id_ujiansemester", $ref_ujian_semester, null, ["class" => "form-control select2"]) ],
			'no_soal' => ['No Soal', Form::text("no_soal", $soalsemester->no_soal, ["class" => "form-control","placeholder" => "", "id" => "no_soal"]) ],
			'soal' => ['Soal', Form::text("soal", $soalsemester->soal, ["class" => "form-control","placeholder" => "", "id" => "soal"]) ],
			'gambar' => ['Gambar', Form::text("gambar", $soalsemester->gambar, ["class" => "form-control","placeholder" => "", "id" => "gambar"]) ],
			'opsi_a' => ['Opsi A', Form::text("opsi_a", $soalsemester->opsi_a, ["class" => "form-control","placeholder" => "", "id" => "opsi_a"]) ],
			'opsi_b' => ['Opsi B', Form::text("opsi_b", $soalsemester->opsi_b, ["class" => "form-control","placeholder" => "", "id" => "opsi_b"]) ],
			'opsi_c' => ['Opsi C', Form::text("opsi_c", $soalsemester->opsi_c, ["class" => "form-control","placeholder" => "", "id" => "opsi_c"]) ],
			'opsi_d' => ['Opsi D', Form::text("opsi_d", $soalsemester->opsi_d, ["class" => "form-control","placeholder" => "", "id" => "opsi_d"]) ],
			'opsi_e' => ['Opsi E', Form::text("opsi_e", $soalsemester->opsi_e, ["class" => "form-control","placeholder" => "", "id" => "opsi_e"]) ],
			'gambar_a' => ['Gambar A', Form::text("gambar_a", $soalsemester->gambar_a, ["class" => "form-control","placeholder" => "", "id" => "gambar_a"]) ],
			'gambar_b' => ['Gambar B', Form::text("gambar_b", $soalsemester->gambar_b, ["class" => "form-control","placeholder" => "", "id" => "gambar_b"]) ],
			'gambar_c' => ['Gambar C', Form::text("gambar_c", $soalsemester->gambar_c, ["class" => "form-control","placeholder" => "", "id" => "gambar_c"]) ],
			'gambar_d' => ['Gambar D', Form::text("gambar_d", $soalsemester->gambar_d, ["class" => "form-control","placeholder" => "", "id" => "gambar_d"]) ],
			'gambar_e' => ['Gambar E', Form::text("gambar_e", $soalsemester->gambar_e, ["class" => "form-control","placeholder" => "", "id" => "gambar_e"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$soalsemester->what;
		$this->log($request, $text, ['soalsemester.id' => $soalsemester->id]);
		return view('SoalSemester::soalsemester_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		// dd($request->all());

		$this->validate($request, [
			// 'id_ujiansemester' => 'required',
			// 'no_soal' => 'required',
			// 'soal' => 'required',
			// 'gambar' => 'required',
			// 'opsi_a' => 'required',
			// 'opsi_b' => 'required',
			// 'opsi_c' => 'required',
			// 'opsi_d' => 'required',
			// 'opsi_e' => 'required',
			// 'gambar_a' => 'required',
			// 'gambar_b' => 'required',
			// 'gambar_c' => 'required',
			// 'gambar_d' => 'required',
			// 'gambar_e' => 'required',
			'kunci' => 'required',
			
		]);
		
		$soal = SoalSemester::find($id);
		$soal->soal = $request->input("soal");
		$soal->opsi_a = $request->input("opsi_a");
		$soal->opsi_b = $request->input("opsi_b");
		$soal->opsi_c = $request->input("opsi_c");
		$soal->opsi_d = $request->input("opsi_d");
		$soal->opsi_e = $request->input("opsi_e");
		$soal->kunci = $request->input("kunci");

		if($request->hasFile('gambar'))
		{
			$gambar = time().'.'.$request->gambar->extension();  

        	$request->gambar->move(public_path('ujian/soal'), $gambar);
			$soal->gambar = $gambar;
		}

		if($request->hasFile('gambar_a'))
		{
			$opsi_a = "a_" . time().'.'.$request->gambar_a->extension();  

        	$request->gambar_a->move(public_path('ujian/jawaban'), $opsi_a);
			$soal->gambar_a = $opsi_a;
		}

		if($request->hasFile('gambar_b'))
		{
			$opsi_b = "b_" . time().'.'.$request->gambar_b->extension();  

        	$request->gambar_b->move(public_path('ujian/jawaban'), $opsi_b);
			$soal->gambar_b = $opsi_b;
		}

		if($request->hasFile('gambar_c'))
		{
			$opsi_c = "c_" . time().'.'.$request->gambar_c->extension();  

        	$request->gambar_c->move(public_path('ujian/jawaban'), $opsi_c);
			$soal->gambar_c = $opsi_c;
		}

		if($request->hasFile('gambar_d'))
		{
			$opsi_d = "d_" . time().'.'.$request->gambar_d->extension();  

        	$request->gambar_d->move(public_path('ujian/jawaban'), $opsi_d);
			$soal->gambar_d = $opsi_d;
		}

		if($request->hasFile('gambar_e'))
		{
			$opsi_e = "e_" . time().'.'.$request->gambar_e->extension();  

        	$request->gambar_e->move(public_path('ujian/jawaban'), $opsi_e);
			$soal->gambar_e = $opsi_e;
		}
		
		$soal->updated_by = Auth::id();
		$soal->save();


		$text = 'mengedit '.$this->title;//.' '.$soal->what;
		$this->log($request, $text, ['soal.id' => $soal->id]);
		return redirect()->back()->with('message_success', 'Soal berhasil diubah!');
	}

	public function hapus_gambar(Request $request, $id_soal, $jenis)
	{
		$soal = SoalSemester::find($id_soal);

		if($jenis == 'gambar')
		{
			$soal->gambar = '';
		}
		else if($jenis == 'gambar_a')
		{
			$soal->gambar_a = '';
		}
		else if($jenis == 'gambar_b')
		{
			$soal->gambar_b = '';
		}
		else if($jenis == 'gambar_c')
		{
			$soal->gambar_c = '';
		}
		else if($jenis == 'gambar_d')
		{
			$soal->gambar_d = '';
		}
		else if($jenis == 'gambar_e')
		{
			$soal->gambar_e = '';
		}

		$soal->save();

		return redirect()->back()->with('message_success', 'Gambar berhasil dihapus.');

	}

	public function destroy(Request $request, $id)
	{
		$soalsemester = SoalSemester::find($id);
		$soalsemester->deleted_by = Auth::id();
		$soalsemester->save();
		$soalsemester->delete();

		$text = 'menghapus '.$this->title;//.' '.$soalsemester->what;
		$this->log($request, $text, ['soalsemester.id' => $soalsemester->id]);
		return back()->with('message_success', 'Soal Semester berhasil dihapus!');
	}

}
