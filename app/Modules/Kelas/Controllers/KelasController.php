<?php
namespace App\Modules\Kelas\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kelas\Models\Kelas;
use App\Modules\Tingkat\Models\Tingkat;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Ruang\Models\Ruang;

use App\Http\Controllers\Controller;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use App\Modules\Semester\Models\Semester;
use App\Modules\Siswa\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class KelasController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kelas";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kelas::query()->orderBy('kelas');
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kelas::kelas', array_merge($data, ['title' => $this->title]));
	}

	public function download_file_smp_pdf(Request $request, $id_kelas)
	{
		$file = Kelas::select('*')
						->join('pesertadidik as p', 'p.id_kelas', '=', 'kelas.id')
						->join('siswa as s', 'p.id_siswa', '=', 's.id')
						->where('p.id_semester', session()->get('active_semester')['id'])
						->where('kelas.id', $id_kelas)
						->get();

		// dd($file);

		$oMerger = PDFMerger::init();

		foreach($file as $item)
		{
			$cek_pdf = pathinfo($item->file_ijazah_smp, PATHINFO_EXTENSION);
			// dd($cek_pdf);
			

			if($cek_pdf == 'pdf')
			{
				// dd($item->file_ijazah_smp);
				$oMerger->addPDF('uploads/ijazah/'.$item->file_ijazah_smp, 'all');
			}
		}
		
		$oMerger->merge();
		$oMerger->download('merged_result.pdf');

		
	}

	public function download_file_smp_image(Request $request, $id_kelas)
	{
		$file = Kelas::select('*')
						->join('pesertadidik as p', 'p.id_kelas', '=', 'kelas.id')
						->join('siswa as s', 'p.id_siswa', '=', 's.id')
						->where('p.id_semester', session()->get('active_semester')['id'])
						->where('kelas.id', $id_kelas)
						->get();

		$data['data'] = $file;

		$this->log($request, 'download file ijazah gamba '.$this->title);
		return view('Kelas::download_ijazah_gambar', array_merge($data, ['title' => $this->title]));
	}
	
	public function asesmen(Request $request)
	{
		$query = Kelas::query()->orderBy('kelas');
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kelas::kelas_asesmen', array_merge($data, ['title' => $this->title]));
	}

	public function detail_asesmen(Request $request, $id_kelas)
	{
		$data['kelas'] = Kelas::find($id_kelas);
		$data_asesmen = DB::table('asesmen')->where('id_kelas', $id_kelas)->get();

		if($data['kelas']->tingkat->tingkat == 'X')
		{
			$mudah_sakit = $data_asesmen->sum('p_1');
			$kurang_istirahat = $data_asesmen->sum('p_2');
			$tidak_sarapan = $data_asesmen->sum('p_3');
			$pendengaran_kurang = $data_asesmen->sum('p_4');
			$penglihatan_kurang = $data_asesmen->sum('p_5');
			$mudah_lelah = $data_asesmen->sum('p_6');
			$mudah_ngantuk = $data_asesmen->sum('p_7');

			$total_aspek_fisik = $mudah_sakit + $kurang_istirahat + $tidak_sarapan + $pendengaran_kurang + $penglihatan_kurang + $mudah_lelah + $mudah_ngantuk;

			$data['aspek_fisik'] = [
				"Mudah Sakit" => $mudah_sakit/$total_aspek_fisik*100,
				"Kurang Istirahat" => $kurang_istirahat/$total_aspek_fisik*100,
				"Tidak Sarapan" => $tidak_sarapan/$total_aspek_fisik*100,
				"Pendengaran Kurang" => $pendengaran_kurang/$total_aspek_fisik*100,
				"Penglihatan Kurang" => $penglihatan_kurang/$total_aspek_fisik*100,
				"Mudah Lelah" => $mudah_lelah/$total_aspek_fisik*100,
				"Mudah Ngantuk" => $mudah_ngantuk/$total_aspek_fisik*100
			];

			$senang = $data_asesmen->sum('p_8');
			$ikhlas = $data_asesmen->sum('p_9');
			$berusaha = $data_asesmen->sum('p_10');
			$yakin = $data_asesmen->sum('p_11');
			$berani = $data_asesmen->sum('p_12');
			$percaya = $data_asesmen->sum('p_13');

			$total_aspek_psikis = $senang + $ikhlas + $berusaha + $yakin + $berani + $percaya;

			$data['aspek_psikis'] = [
				"Senang" => $senang / $total_aspek_psikis * 100,
				"Ikhlas Tanpa Paksaan" => $ikhlas / $total_aspek_psikis * 100,
				"Berusaha Dengan Giat" => $berusaha / $total_aspek_psikis * 100,
				"Yakin Atas Usaha" => $yakin / $total_aspek_psikis * 100,
				"Berani Berpendapat, Bertanya, Menanggah" => $berani / $total_aspek_psikis * 100,
				"Percaya Dengan Kemampuan" => $percaya / $total_aspek_psikis * 100,
			];

			$kamar = $data_asesmen->sum('p_14');
			$tempat = $data_asesmen->sum('p_15');
			$hp = $data_asesmen->sum('p_16');
			$laptop = $data_asesmen->sum('p_17');
			$buku = $data_asesmen->sum('p_18');
			$akses = $data_asesmen->sum('p_19');
			$support = $data_asesmen->sum('p_20');

			$total_aspek_sarana = $kamar + $tempat + $hp + $laptop + $buku + $akses + $support;

			$data['aspek_sarana'] = [
				"Kamar Sendiri" => $kamar / $total_aspek_sarana * 100,
				"Tempat Belajar Nyaman" => $tempat / $total_aspek_sarana * 100,
				"HP" => $hp / $total_aspek_sarana * 100,
				"Laptop" => $laptop / $total_aspek_sarana * 100,
				"Buku Penunjang" => $buku / $total_aspek_sarana * 100,
				"Akses Perjalanan" => $akses / $total_aspek_sarana * 100,
				"Support Orang Tua" => $support / $total_aspek_sarana * 100
			];

			$visual = 0;
			$auditorial = 0;
			$kinestetik = 0;

			foreach($data_asesmen as $item)
			{
				$item = collect($item);
				$item->toArray();

				// dd($item);

				$a = 0;
				$b = 0;
				$c = 0;

				foreach($item as $key => $value)
				{
					if($value == 'A')
					{
						$a ++;
					}
					else if($value == 'B')
					{
						$b ++;
					}
					else if($value == 'C')
					{
						$c ++;
					}
				}

				if(($a > $b) && ($a > $c))
				{
					$visual ++;
				}

				if(($b > $a) && ($b > $c))
				{
					$auditorial ++;
				}

				if(($c > $a) && ($c > $b))
				{
					$kinestetik ++;
				}
			}

			$data['gaya_belajar'] = [
				'Visual' => $visual,
				'Auditorial' => $auditorial,
				'Kinestetik' => $kinestetik
			];
		}

		if($data['kelas']->tingkat->tingkat == 'XI')
		{
			$rendah = 0;
			$sedang = 0;
			$tinggi = 0;

			foreach($data_asesmen as $item)
			{
				$nilai = $item->p_36 + $item->p_37 + $item->p_38 + $item->p_39 + $item->p_40 + $item->p_41 + $item->p_42 + $item->p_43 +$item->p_44 +$item->p_45;

				if($nilai <= 40)
				{
					$rendah ++;
				}
				else if(($nilai > 40) && ($nilai <= 70))
				{
					$sedang ++;
				}
				else{
					$tinggi ++;
				}
			}

			$data['kesesuaian'] = [
				"Rendah" => $rendah,
				"Sedang" => $sedang,
				"Tinggi" => $tinggi
			];
		}
		
		


		return view('Kelas::detail_asesmen', array_merge($data, ['title' => $this->title])); 
	}

	public function naik_kelas(Request $request, $id_kelas)
	{
		$data['data'] = Pesertadidik::query()
						->whereIdSemester(get_semester('active_semester_id'))
						->whereIdKelas($id_kelas)
						->get();
		$data['kelas'] = Kelas::find($id_kelas);
		$data['data_kelas']	= Kelas::all()->sortBy('kelas')->pluck('kelas', 'id');
		$data['data_kelas']->prepend('-PILIH SALAH SATU-', '');
		$data['semester']		= get_semester('active_semester_id');
		$data['data_semester']	= Semester::all()->pluck('semester', 'id');
		$data['data_semester']->prepend('-PILIH SALAH SATU-', '');

		
		$this->log($request, 'melihat halaman naik kelas');
		return view('Kelas::kelas_naik', array_merge($data, ['title' => $this->title]));
	}

	public function aksi_naik_kelas(Request $request)
	{
		$request->validate([
			"id_kelas" 			=> 'required',
			'id_kelas_naik'		=> 'required',
			'id_semester'		=> 'required',
			'id_semester_naik'	=> 'required'
		]);

		foreach($request->input('id_pesertadidik') as $item)
		{
			$pesertadidik = Pesertadidik::find($item);
			$siswa = Siswa::find($pesertadidik->id_siswa);

			$data = [
				'id'			=> Str::uuid(),
				'id_semester'	=> $request->input('id_semester_naik'),
				'id_siswa'		=> $siswa->id,
				'id_kelas'		=> $request->input('id_kelas_naik'),
				'created_at'	=> now()
			];

			Pesertadidik::insert($data);
		}

		return redirect()->route('kelas.naik.index', $request->input('id_kelas'))->with('message_success', 'Berhasil naik kelas.');
	}

	public function create(Request $request)
	{
		$ref_tingkat = Tingkat::all()->sortBy('tingkat')->pluck('tingkat','id');
		$ref_jurusan = Jurusan::all()->sortBy('jurusan')->pluck('jurusan','id');
		
		$data['forms'] = array(
			'kelas' => ['Kelas', Form::text("kelas", old("kelas"), ["class" => "form-control","placeholder" => ""]) ],
			'id_tingkat' => ['Tingkat', Form::select("id_tingkat", $ref_tingkat, null, ["class" => "form-control select2"]) ],
			'id_jurusan' => ['Jurusan', Form::select("id_jurusan", $ref_jurusan, null, ["class" => "form-control select2"]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kelas::kelas_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'kelas' => 'required',
			'id_tingkat' => 'required',
			'id_jurusan' => 'required',
			
		]);

		$kelas = new Kelas();
		$kelas->kelas = $request->input("kelas");
		$kelas->id_tingkat = $request->input("id_tingkat");
		$kelas->id_jurusan = $request->input("id_jurusan");
		
		$kelas->created_by = Auth::id();
		$kelas->save();

		$text = 'membuat '.$this->title; //' baru '.$kelas->what;
		$this->log($request, $text, ['kelas.id' => $kelas->id]);
		return redirect()->route('kelas.index')->with('message_success', 'Kelas berhasil ditambahkan!');
	}

	public function show(Request $request, Kelas $kelas)
	{
		$data['kelas'] = $kelas;

		$text = 'melihat detail '.$this->title;//.' '.$kelas->what;
		$this->log($request, $text, ['kelas.id' => $kelas->id]);
		return view('Kelas::kelas_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Kelas $kelas)
	{
		$data['kelas'] = $kelas;

		// dd($data['kelas']);

		$ref_tingkat = Tingkat::all()->pluck('tingkat','id');
		$ref_jurusan = Jurusan::all()->pluck('jurusan','id');
		$ref_ruang	= Ruang::all()->pluck('ruang', 'id');

		$ref_tingkat->prepend('-PILIH SALAH SATU-', '');
		$ref_jurusan->prepend('-PILIH SALAH SATU-', '');
		$ref_ruang->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			'kelas' => ['Kelas', Form::text("kelas", $kelas->kelas, ["class" => "form-control","placeholder" => "", "id" => "kelas"]) ],
			'id_tingkat' => ['Tingkat', Form::select("id_tingkat", $ref_tingkat, $kelas->id_tingkat, ["class" => "form-control select2"]) ],
			'id_jurusan' => ['Jurusan', Form::select("id_jurusan", $ref_jurusan, $kelas->id_jurusan, ["class" => "form-control select2"]) ],
			'id_ruang' => ['Ruang', Form::select("id_ruang", $ref_ruang, $kelas->id_ruang, ["class" => "form-control select2"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kelas->what;
		$this->log($request, $text, ['kelas.id' => $kelas->id]);
		return view('Kelas::kelas_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'kelas' => 'required',
			'id_tingkat' => 'required',
			'id_jurusan' => 'required',
			
		]);
		
		$kelas = Kelas::find($id);
		$kelas->kelas = $request->input("kelas");
		$kelas->id_tingkat = $request->input("id_tingkat");
		$kelas->id_jurusan = $request->input("id_jurusan");
		$kelas->id_ruang = $request->input("id_ruang");
		
		$kelas->updated_by = Auth::id();
		$kelas->save();


		$text = 'mengedit '.$this->title;//.' '.$kelas->what;
		$this->log($request, $text, ['kelas.id' => $kelas->id]);
		return redirect()->route('kelas.index')->with('message_success', 'Kelas berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kelas = Kelas::find($id);
		$kelas->deleted_by = Auth::id();
		$kelas->save();
		$kelas->delete();

		$text = 'menghapus '.$this->title;//.' '.$kelas->what;
		$this->log($request, $text, ['kelas.id' => $kelas->id]);
		return back()->with('message_success', 'Kelas berhasil dihapus!');
	}

}
