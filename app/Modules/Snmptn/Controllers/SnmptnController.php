<?php
namespace App\Modules\Snmptn\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Snmptn\Models\Snmptn;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Prestasi\Models\Prestasi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SnmptnController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Snmptn";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Jurusan::query();
		
		$data['data'] = $query->get();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Snmptn::snmptn', array_merge($data, ['title' => $this->title]));
	}

	public function peringkat_kelas(Request $request)
	{
		$kelas = Snmptn::get_kelas_xii()->sortBy('kelas')->pluck('kelas','id');
		$jurusan = Jurusan::all()->sortBy('jurusan')->pluck('jurusan','id');
		$kelas->prepend('-SEMUA KELAS-', '');
		$jurusan->prepend('-PILIH SALAH SATU-', '');

		$data['kelas'] = $kelas;
		$data['jurusan'] = $jurusan;
		$data['id_kelas'] = $request->input('id_kelas');
		$data['semester'] = $request->input('semester');
		$data['id_jurusan'] = $request->input('id_jurusan');

		if($request->input('semester') == '')
		{
			$data['data'] =  FALSE;
		}
		else{
			$data['data']	= Snmptn::get_data_peringkat($request->input('id_kelas'), $request->input('semester'), $request->input('id_jurusan'));
		}

		// dd($data['data']);

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Snmptn::peringkat_kelas', array_merge($data, ['title' => $this->title]));
	}

	public function peringkat(Request $request, $id_jurusan)
	{
		$data['siswa']	= Snmptn::get_peringkat($id_jurusan);
		$data['id_jurusan']	= $id_jurusan;
		$data['jurusan'] = Jurusan::find($id_jurusan);

		$this->log($request, 'melihat halaman peringkat '.$this->title);
		return view('Snmptn::snmptn_peringkat', array_merge($data, ['title' => $this->title]));
	}

	public function hitung(Request $request, $id_jurusan)
	{
		$siswa = Snmptn::get_pd_by_jurusan($id_jurusan)->get();

		foreach($siswa as $item)
		{
			$nilai = (($item->jml_nilai_1/$item->pembagi_1)+($item->jml_nilai_2/$item->pembagi_2)+($item->jml_nilai_3/$item->pembagi_3)+($item->jml_nilai_4/$item->pembagi_4)+($item->jml_nilai_5/$item->pembagi_5))/5;

			$data = [
				'id'		=> $item->id,
				'rata_rata'	=> $nilai
			];

			Snmptn::update_nilai($data);
		}

		$this->hitung_peringkat($id_jurusan);

		return redirect()->back()->with('message_success', 'Nilai berhasil dihitung!');		
	}

	public function hitung_peringkat($id_jurusan)
	{
		$siswa = Snmptn::get_pd_by_jurusan($id_jurusan)
							->orderBy('is_bersedia', 'DESC')
							->orderBy('id_prestasi', 'DESC')
							->orderBy('rata_rata', 'DESC')
							->get();

		$peringkat = 1;

		$kuota = ceil((40/100) * count($siswa));

		

		


		foreach($siswa as $item)
		{
			if($peringkat <= $kuota)
			{
				$eligible = 1;
			}
			else
			{
				$eligible = 0;
			}

			$data = [
				'id'		=> $item->id,
				'peringkat'	=> $peringkat,
				'is_eligible'  => $eligible
			];

			$peringkat++;

			Snmptn::update_nilai($data);
		}
	}

	public function edit_snmptn(Request $request, $id_snmptn)
	{
		$snmptn = Snmptn::find($id_snmptn);
		$data['snmptn'] = $snmptn;

		$siswa = Pesertadidik::get_pd_by_id($snmptn->id_pesertadidik)->first();
		$ref_prestasi = Prestasi::all()->pluck('prestasi','id');
		
		$data['forms'] = array(
			'id_pesertadidik' => ['Peserta Didik', Form::text("id_pesertadidik", $siswa->nama_siswa, ["class" => "form-control", "disabled"]) ],
			'jml_nilai_1' => ['Jml Nilai 1', Form::text("jml_nilai_1", $snmptn->jml_nilai_1, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_1"]) ],
			'pembagi_1' => ['Pembagi 1', Form::text("pembagi_1", $snmptn->pembagi_1, ["class" => "form-control","placeholder" => "", "id" => "pembagi_1"]) ],
			'jml_nilai_2' => ['Jml Nilai 2', Form::text("jml_nilai_2", $snmptn->jml_nilai_2, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_2"]) ],
			'pembagi_2' => ['Pembagi 2', Form::text("pembagi_2", $snmptn->pembagi_2, ["class" => "form-control","placeholder" => "", "id" => "pembagi_2"]) ],
			'jml_nilai_3' => ['Jml Nilai 3', Form::text("jml_nilai_3", $snmptn->jml_nilai_3, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_3"]) ],
			'pembagi_3' => ['Pembagi 3', Form::text("pembagi_3", $snmptn->pembagi_3, ["class" => "form-control","placeholder" => "", "id" => "pembagi_3"]) ],
			'jml_nilai_4' => ['Jml Nilai 4', Form::text("jml_nilai_4", $snmptn->jml_nilai_4, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_4"]) ],
			'pembagi_4' => ['Pembagi 4', Form::text("pembagi_4", $snmptn->pembagi_4, ["class" => "form-control","placeholder" => "", "id" => "pembagi_4"]) ],
			'jml_nilai_5' => ['Jml Nilai 5', Form::text("jml_nilai_5", $snmptn->jml_nilai_5, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_5"]) ],
			'pembagi_5' => ['Pembagi 5', Form::text("pembagi_5", $snmptn->pembagi_5, ["class" => "form-control","placeholder" => "", "id" => "pembagi_5"]) ],
			'rata_rata' => ['Rata Rata', Form::text("rata_rata", $snmptn->rata_rata, ["class" => "form-control","placeholder" => "", "id" => "rata_rata"]) ],
			'id_prestasi' => ['Prestasi', Form::select("id_prestasi", $ref_prestasi, null, ["class" => "form-control select2"]) ],
		);

		$text = 'membuka form edit '.$this->title;//.' '.$snmptn->what;
		$this->log($request, $text, ['snmptn.id' => $snmptn->id]);
		return view('Snmptn::snmptn_update', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_pesertadidik = Pesertadidik::all()->pluck('id_semester','id');
		
		$data['forms'] = array(
			'id_pesertadidik' => ['Pesertadidik', Form::select("id_pesertadidik", $ref_pesertadidik, null, ["class" => "form-control select2"]) ],
			'jml_nilai_1' => ['Jml Nilai 1', Form::text("jml_nilai_1", old("jml_nilai_1"), ["class" => "form-control","placeholder" => ""]) ],
			'pembagi_1' => ['Pembagi 1', Form::text("pembagi_1", old("pembagi_1"), ["class" => "form-control","placeholder" => ""]) ],
			'jml_nilai_2' => ['Jml Nilai 2', Form::text("jml_nilai_2", old("jml_nilai_2"), ["class" => "form-control","placeholder" => ""]) ],
			'pembagi_2' => ['Pembagi 2', Form::text("pembagi_2", old("pembagi_2"), ["class" => "form-control","placeholder" => ""]) ],
			'jml_nilai_3' => ['Jml Nilai 3', Form::text("jml_nilai_3", old("jml_nilai_3"), ["class" => "form-control","placeholder" => ""]) ],
			'pembagi_3' => ['Pembagi 3', Form::text("pembagi_3", old("pembagi_3"), ["class" => "form-control","placeholder" => ""]) ],
			'jml_nilai_4' => ['Jml Nilai 4', Form::text("jml_nilai_4", old("jml_nilai_4"), ["class" => "form-control","placeholder" => ""]) ],
			'pembagi_4' => ['Pembagi 4', Form::text("pembagi_4", old("pembagi_4"), ["class" => "form-control","placeholder" => ""]) ],
			'jml_nilai_5' => ['Jml Nilai 5', Form::text("jml_nilai_5", old("jml_nilai_5"), ["class" => "form-control","placeholder" => ""]) ],
			'pembagi_5' => ['Pembagi 5', Form::text("pembagi_5", old("pembagi_5"), ["class" => "form-control","placeholder" => ""]) ],
			'rata_rata' => ['Rata Rata', Form::text("rata_rata", old("rata_rata"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Snmptn::snmptn_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_pesertadidik' => 'required',
			'jml_nilai_1' => 'required',
			'pembagi_1' => 'required',
			'jml_nilai_2' => 'required',
			'pembagi_2' => 'required',
			'jml_nilai_3' => 'required',
			'pembagi_3' => 'required',
			'jml_nilai_4' => 'required',
			'pembagi_4' => 'required',
			'jml_nilai_5' => 'required',
			'pembagi_5' => 'required',
			'rata_rata' => 'required',
			
		]);

		$snmptn = new Snmptn();
		$snmptn->id_pesertadidik = $request->input("id_pesertadidik");
		$snmptn->jml_nilai_1 = $request->input("jml_nilai_1");
		$snmptn->pembagi_1 = $request->input("pembagi_1");
		$snmptn->jml_nilai_2 = $request->input("jml_nilai_2");
		$snmptn->pembagi_2 = $request->input("pembagi_2");
		$snmptn->jml_nilai_3 = $request->input("jml_nilai_3");
		$snmptn->pembagi_3 = $request->input("pembagi_3");
		$snmptn->jml_nilai_4 = $request->input("jml_nilai_4");
		$snmptn->pembagi_4 = $request->input("pembagi_4");
		$snmptn->jml_nilai_5 = $request->input("jml_nilai_5");
		$snmptn->pembagi_5 = $request->input("pembagi_5");
		$snmptn->rata_rata = $request->input("rata_rata");
		
		$snmptn->created_by = Auth::id();
		$snmptn->save();

		$text = 'membuat '.$this->title; //' baru '.$snmptn->what;
		$this->log($request, $text, ['snmptn.id' => $snmptn->id]);
		return redirect()->route('snmptn.index')->with('message_success', 'Snmptn berhasil ditambahkan!');
	}

	public function show(Request $request, Snmptn $snmptn)
	{
		$data['snmptn'] = $snmptn;

		$text = 'melihat detail '.$this->title;//.' '.$snmptn->what;
		$this->log($request, $text, ['snmptn.id' => $snmptn->id]);
		return view('Snmptn::snmptn_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Snmptn $snmptn)
	{
		$data['snmptn'] = $snmptn;

		$ref_pesertadidik = Pesertadidik::all()->pluck('id_semester','id');
		
		$data['forms'] = array(
			'id_pesertadidik' => ['Pesertadidik', Form::select("id_pesertadidik", $ref_pesertadidik, null, ["class" => "form-control select2"]) ],
			'jml_nilai_1' => ['Jml Nilai 1', Form::text("jml_nilai_1", $snmptn->jml_nilai_1, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_1"]) ],
			'pembagi_1' => ['Pembagi 1', Form::text("pembagi_1", $snmptn->pembagi_1, ["class" => "form-control","placeholder" => "", "id" => "pembagi_1"]) ],
			'jml_nilai_2' => ['Jml Nilai 2', Form::text("jml_nilai_2", $snmptn->jml_nilai_2, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_2"]) ],
			'pembagi_2' => ['Pembagi 2', Form::text("pembagi_2", $snmptn->pembagi_2, ["class" => "form-control","placeholder" => "", "id" => "pembagi_2"]) ],
			'jml_nilai_3' => ['Jml Nilai 3', Form::text("jml_nilai_3", $snmptn->jml_nilai_3, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_3"]) ],
			'pembagi_3' => ['Pembagi 3', Form::text("pembagi_3", $snmptn->pembagi_3, ["class" => "form-control","placeholder" => "", "id" => "pembagi_3"]) ],
			'jml_nilai_4' => ['Jml Nilai 4', Form::text("jml_nilai_4", $snmptn->jml_nilai_4, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_4"]) ],
			'pembagi_4' => ['Pembagi 4', Form::text("pembagi_4", $snmptn->pembagi_4, ["class" => "form-control","placeholder" => "", "id" => "pembagi_4"]) ],
			'jml_nilai_5' => ['Jml Nilai 5', Form::text("jml_nilai_5", $snmptn->jml_nilai_5, ["class" => "form-control","placeholder" => "", "id" => "jml_nilai_5"]) ],
			'pembagi_5' => ['Pembagi 5', Form::text("pembagi_5", $snmptn->pembagi_5, ["class" => "form-control","placeholder" => "", "id" => "pembagi_5"]) ],
			'rata_rata' => ['Rata Rata', Form::text("rata_rata", $snmptn->rata_rata, ["class" => "form-control","placeholder" => "", "id" => "rata_rata"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$snmptn->what;
		$this->log($request, $text, ['snmptn.id' => $snmptn->id]);
		return view('Snmptn::snmptn_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			
			'jml_nilai_1' => 'required',
			'pembagi_1' => 'required',
			'jml_nilai_2' => 'required',
			'pembagi_2' => 'required',
			'jml_nilai_3' => 'required',
			'pembagi_3' => 'required',
			'jml_nilai_4' => 'required',
			'pembagi_4' => 'required',
			'jml_nilai_5' => 'required',
			'pembagi_5' => 'required',
			
		]);
		
		$snmptn = Snmptn::find($id);
		$snmptn->jml_nilai_1 = $request->input("jml_nilai_1");
		$snmptn->pembagi_1 = $request->input("pembagi_1");
		$snmptn->jml_nilai_2 = $request->input("jml_nilai_2");
		$snmptn->pembagi_2 = $request->input("pembagi_2");
		$snmptn->jml_nilai_3 = $request->input("jml_nilai_3");
		$snmptn->pembagi_3 = $request->input("pembagi_3");
		$snmptn->jml_nilai_4 = $request->input("jml_nilai_4");
		$snmptn->pembagi_4 = $request->input("pembagi_4");
		$snmptn->jml_nilai_5 = $request->input("jml_nilai_5");
		$snmptn->pembagi_5 = $request->input("pembagi_5");
		$snmptn->id_prestasi = $request->input("id_prestasi");
		
		$snmptn->updated_by = Auth::id();
		$snmptn->save();


		$text = 'mengedit '.$this->title;//.' '.$snmptn->what;
		$this->log($request, $text, ['snmptn.id' => $snmptn->id]);
		return redirect()->back()->with('message_success', 'Snmptn berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$snmptn = Snmptn::find($id);
		$snmptn->deleted_by = Auth::id();
		$snmptn->save();
		$snmptn->delete();

		$text = 'menghapus '.$this->title;//.' '.$snmptn->what;
		$this->log($request, $text, ['snmptn.id' => $snmptn->id]);
		return back()->with('message_success', 'Snmptn berhasil dihapus!');
	}

}
