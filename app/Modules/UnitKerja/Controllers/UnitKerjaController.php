<?php
namespace App\Modules\UnitKerja\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\UnitKerja\Models\UnitKerja;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UnitKerjaController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Unit Kerja";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = UnitKerja::whereNull('induk');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('UnitKerja::unitkerja', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_unit_kerja = UnitKerja::all()->pluck('unit_kerja','id');
		$ref_unit_kerja->prepend('-PILIH SALAH SATU-', '');

		
		$data['forms'] = array(
			'unit_kerja' => ['Unit Kerja', Form::text("unit_kerja", old("unit_kerja"), ["class" => "form-control","placeholder" => ""]) ],
			'induk' => ['Induk', Form::select("induk", $ref_unit_kerja, $request->induk, ["class" => "form-control select2"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('UnitKerja::unitkerja_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'unit_kerja' => 'required',
			// 'induk' => 'required',
			
		]);

		$unitkerja = new UnitKerja();
		$unitkerja->unit_kerja = $request->input("unit_kerja");
		$unitkerja->induk = $request->input("induk");
		
		$unitkerja->created_by = Auth::id();
		$unitkerja->save();

		$text = 'membuat '.$this->title; //' baru '.$unitkerja->what;
		$this->log($request, $text, ['unitkerja.id' => $unitkerja->id]);
		return redirect()->route('unitkerja.index')->with('message_success', 'Unit Kerja berhasil ditambahkan!');
	}

	public function show(Request $request, UnitKerja $unitkerja)
	{
		// dd($unitkerja->id);
		$data['unitkerja'] = $unitkerja;
		$data['data'] = UnitKerja::where('induk', $unitkerja->id)->get();

		$text = 'melihat detail '.$this->title;//.' '.$unitkerja->what;
		$this->log($request, $text, ['unitkerja.id' => $unitkerja->id]);
		return view('UnitKerja::unitkerja_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, UnitKerja $unitkerja)
	{
		$data['unitkerja'] = $unitkerja;

		$ref_unit_kerja = UnitKerja::all()->pluck('unit_kerja','id');
		$ref_unit_kerja->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			'unit_kerja' => ['Unit Kerja', Form::text("unit_kerja", $unitkerja->unit_kerja, ["class" => "form-control","placeholder" => "", "id" => "unit_kerja"]) ],
			'induk' => ['Induk', Form::select("induk", $ref_unit_kerja, null, ["class" => "form-control select2"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$unitkerja->what;
		$this->log($request, $text, ['unitkerja.id' => $unitkerja->id]);
		return view('UnitKerja::unitkerja_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'unit_kerja' => 'required',
			// 'induk' => 'required',
			
		]);
		
		$unitkerja = UnitKerja::find($id);
		$unitkerja->unit_kerja = $request->input("unit_kerja");
		$unitkerja->induk = $request->input("induk");
		
		$unitkerja->updated_by = Auth::id();
		$unitkerja->save();


		$text = 'mengedit '.$this->title;//.' '.$unitkerja->what;
		$this->log($request, $text, ['unitkerja.id' => $unitkerja->id]);
		return redirect()->route('unitkerja.index')->with('message_success', 'Unit Kerja berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$unitkerja = UnitKerja::find($id);
		$unitkerja->deleted_by = Auth::id();
		$unitkerja->save();
		$unitkerja->delete();

		$text = 'menghapus '.$this->title;//.' '.$unitkerja->what;
		$this->log($request, $text, ['unitkerja.id' => $unitkerja->id]);
		return back()->with('message_success', 'Unit Kerja berhasil dihapus!');
	}

}
