<?php
namespace App\Modules\Soal\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Soal\Models\Soal;
use App\Modules\Ujiansekolah\Models\Ujiansekolah;
use App\Modules\Jenissoal\Models\Jenissoal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SoalController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Soal";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Soal::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Soal::soal', array_merge($data, ['title' => $this->title]));
	}

public function input_soal(Request $request, $id_ujian, $id_jenissoal, $no_soal)
	{

		$soal = Soal::cek_soal($id_ujian, $id_jenissoal, $no_soal);

		$data['id_ujian']		= $id_ujian;
		$data['id_jenissoal']	= $id_jenissoal;
		$data['no_soal']		= $no_soal;
		$data['ujian']			= Ujiansekolah::find($id_ujian);
		$data['soal_terinput']	= Soal::whereIdUjiansekolah($id_ujian)->whereIdJenissoal($id_jenissoal)->pluck("kunci", "no_soal");

		if($soal->count() > 0)
		{
			$data['soal'] = $soal->first();
			$this->log($request, 'membuka form tambah '.$this->title);
			return view('Soal::soal_edit', array_merge($data, ['title' => $this->title]));
		}
		else
		{
			$this->log($request, 'membuka form tambah '.$this->title);
			return view('Soal::soal_input', array_merge($data, ['title' => $this->title]));
		}

		
	}

	public function create(Request $request)
	{
		$ref_ujiansekolah = Ujiansekolah::all()->pluck('id_semester','id');
		$ref_jenissoal = Jenissoal::all()->pluck('jenis_soal','id');
		
		$data['forms'] = array(
			'id_ujiansekolah' => ['Ujiansekolah', Form::select("id_ujiansekolah", $ref_ujiansekolah, null, ["class" => "form-control select2"]) ],
			'id_jenissoal' => ['Jenissoal', Form::select("id_jenissoal", $ref_jenissoal, null, ["class" => "form-control select2"]) ],
			'no_soal' => ['No Soal', Form::text("no_soal", old("no_soal"), ["class" => "form-control","placeholder" => ""]) ],
			'soal' => ['Soal', Form::textarea("soal", old("soal"), ["class" => "form-control rich-editor"]) ],
			'gambar' => ['Gambar', Form::text("gambar", old("gambar"), ["class" => "form-control","placeholder" => ""]) ],
			'opsi_a' => ['Opsi A', Form::textarea("opsi_a", old("opsi_a"), ["class" => "form-control rich-editor"]) ],
			'opsi_b' => ['Opsi B', Form::textarea("opsi_b", old("opsi_b"), ["class" => "form-control rich-editor"]) ],
			'opsi_c' => ['Opsi C', Form::textarea("opsi_c", old("opsi_c"), ["class" => "form-control rich-editor"]) ],
			'opsi_d' => ['Opsi D', Form::textarea("opsi_d", old("opsi_d"), ["class" => "form-control rich-editor"]) ],
			'opsi_e' => ['Opsi E', Form::textarea("opsi_e", old("opsi_e"), ["class" => "form-control rich-editor"]) ],
			'gambar_a' => ['Gambar A', Form::text("gambar_a", old("gambar_a"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar_b' => ['Gambar B', Form::text("gambar_b", old("gambar_b"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar_c' => ['Gambar C', Form::text("gambar_c", old("gambar_c"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar_d' => ['Gambar D', Form::text("gambar_d", old("gambar_d"), ["class" => "form-control","placeholder" => ""]) ],
			'gambar_e' => ['Gambar E', Form::text("gambar_e", old("gambar_e"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Soal::soal_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{

		// dd($reque//st->input("gambar"));

		$this->validate($request, [
			'id_ujiansekolah' => 'required',
			'id_jenissoal' => 'required',
			'no_soal' => 'required',
			'kunci' => 'required',
		]);

		$soal = new Soal();
		$soal->id_ujiansekolah = $request->input("id_ujiansekolah");
		$soal->id_jenissoal = $request->input("id_jenissoal");
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

	public function show(Request $request, Soal $soal)
	{
		$data['soal'] = $soal;

		$text = 'melihat detail '.$this->title;//.' '.$soal->what;
		$this->log($request, $text, ['soal.id' => $soal->id]);
		return view('Soal::soal_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Soal $soal)
	{
		$data['soal'] = $soal;

		$ref_ujiansekolah = Ujiansekolah::all()->pluck('id_semester','id');
		$ref_jenissoal = Jenissoal::all()->pluck('jenis_soal','id');
		
		$data['forms'] = array(
			'id_ujiansekolah' => ['Ujiansekolah', Form::select("id_ujiansekolah", $ref_ujiansekolah, null, ["class" => "form-control select2"]) ],
			'id_jenissoal' => ['Jenissoal', Form::select("id_jenissoal", $ref_jenissoal, null, ["class" => "form-control select2"]) ],
			'no_soal' => ['No Soal', Form::text("no_soal", $soal->no_soal, ["class" => "form-control","placeholder" => "", "id" => "no_soal"]) ],
			'soal' => ['Soal', Form::textarea("soal", $soal->soal, ["class" => "form-control rich-editor"]) ],
			'gambar' => ['Gambar', Form::text("gambar", $soal->gambar, ["class" => "form-control","placeholder" => "", "id" => "gambar"]) ],
			'opsi_a' => ['Opsi A', Form::textarea("opsi_a", $soal->opsi_a, ["class" => "form-control rich-editor"]) ],
			'opsi_b' => ['Opsi B', Form::textarea("opsi_b", $soal->opsi_b, ["class" => "form-control rich-editor"]) ],
			'opsi_c' => ['Opsi C', Form::textarea("opsi_c", $soal->opsi_c, ["class" => "form-control rich-editor"]) ],
			'opsi_d' => ['Opsi D', Form::textarea("opsi_d", $soal->opsi_d, ["class" => "form-control rich-editor"]) ],
			'opsi_e' => ['Opsi E', Form::textarea("opsi_e", $soal->opsi_e, ["class" => "form-control rich-editor"]) ],
			'gambar_a' => ['Gambar A', Form::text("gambar_a", $soal->gambar_a, ["class" => "form-control","placeholder" => "", "id" => "gambar_a"]) ],
			'gambar_b' => ['Gambar B', Form::text("gambar_b", $soal->gambar_b, ["class" => "form-control","placeholder" => "", "id" => "gambar_b"]) ],
			'gambar_c' => ['Gambar C', Form::text("gambar_c", $soal->gambar_c, ["class" => "form-control","placeholder" => "", "id" => "gambar_c"]) ],
			'gambar_d' => ['Gambar D', Form::text("gambar_d", $soal->gambar_d, ["class" => "form-control","placeholder" => "", "id" => "gambar_d"]) ],
			'gambar_e' => ['Gambar E', Form::text("gambar_e", $soal->gambar_e, ["class" => "form-control","placeholder" => "", "id" => "gambar_e"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$soal->what;
		$this->log($request, $text, ['soal.id' => $soal->id]);
		return view('Soal::soal_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'kunci' => 'required',
			
		]);
		
		$soal = Soal::find($id);
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

	public function destroy(Request $request, $id)
	{
		$soal = Soal::find($id);
		$soal->deleted_by = Auth::id();
		$soal->save();
		$soal->delete();

		$text = 'menghapus '.$this->title;//.' '.$soal->what;
		$this->log($request, $text, ['soal.id' => $soal->id]);
		return back()->with('message_success', 'Soal berhasil dihapus!');
	}

	public function hapus_gambar(Request $request, $id_soal, $jenis)
	{
		$soal = Soal::find($id_soal);

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

	public function lihat_soal(Request $request, $id_ujian, $id_jenissoal)
	{
		$data['soal'] = Soal::whereIdUjiansekolah($id_ujian)->whereIdJenissoal($id_jenissoal)->orderBy("no_soal")->get();

		return view('Soal::lihat_soal', $data);
	}

}
