<?php

namespace App\Modules\Juara\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Juara\Models\Juara;
use App\Modules\TingkatJuara\Models\TingkatJuara;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JuaraController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Juara";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Juara::query()->orderBy('poin');
		if ($request->has('search')) {
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Juara::juara', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{

		$data['forms'] = array(
			'juara' => ['Juara', Form::text("juara", old("juara"), ["class" => "form-control", "placeholder" => ""])],
			'poin' => ['Poin', Form::number("poin", old("poin"), ["class" => "form-control", "placeholder" => ""])],

		);

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('Juara::juara_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'juara' => 'required',
			'poin' => 'required',

		]);

		$juara = new Juara();
		$juara->juara = $request->input("juara");
		$juara->poin = $request->input("poin");

		$juara->created_by = Auth::id();
		$juara->save();

		$text = 'membuat ' . $this->title; //' baru '.$juara->what;
		$this->log($request, $text, ['juara.id' => $juara->id]);
		return redirect()->route('juara.index')->with('message_success', 'Juara berhasil ditambahkan!');
	}

	public function show(Request $request, Juara $juara)
	{
		$data['juara'] = $juara;

		$text = 'melihat detail ' . $this->title; //.' '.$juara->what;
		$this->log($request, $text, ['juara.id' => $juara->id]);
		return view('Juara::juara_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Juara $juara)
	{
		$data['juara'] = $juara;

		$ref_tingkat_juara = TingkatJuara::all()->pluck('tingkat_juara', 'id');

		$data['forms'] = array(
			'id_tingkat_juara' => ['Tingkat Juara', Form::select("id_tingkat_juara", $ref_tingkat_juara, null, ["class" => "form-control select2"])],
			'juara' => ['Juara', Form::text("juara", $juara->juara, ["class" => "form-control", "placeholder" => "", "id" => "juara"])],
			'poin' => ['Poin', Form::text("poin", $juara->poin, ["class" => "form-control", "placeholder" => "", "id" => "poin"])],

		);

		$text = 'membuka form edit ' . $this->title; //.' '.$juara->what;
		$this->log($request, $text, ['juara.id' => $juara->id]);
		return view('Juara::juara_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_tingkat_juara' => 'required',
			'juara' => 'required',
			'poin' => 'required',

		]);

		$juara = Juara::find($id);
		$juara->id_tingkat_juara = $request->input("id_tingkat_juara");
		$juara->juara = $request->input("juara");
		$juara->poin = $request->input("poin");

		$juara->updated_by = Auth::id();
		$juara->save();


		$text = 'mengedit ' . $this->title; //.' '.$juara->what;
		$this->log($request, $text, ['juara.id' => $juara->id]);
		return redirect()->route('juara.index')->with('message_success', 'Juara berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$juara = Juara::find($id);
		$juara->deleted_by = Auth::id();
		$juara->save();
		$juara->delete();

		$text = 'menghapus ' . $this->title; //.' '.$juara->what;
		$this->log($request, $text, ['juara.id' => $juara->id]);
		return back()->with('message_success', 'Juara berhasil dihapus!');
	}
}
