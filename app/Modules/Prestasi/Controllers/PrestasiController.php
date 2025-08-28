<?php

namespace App\Modules\Prestasi\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Prestasi\Models\Prestasi;
use App\Modules\Juara\Models\Juara;
use App\Modules\Siswa\Models\Siswa;

use App\Http\Controllers\Controller;
use App\Modules\Kelas\Models\Kelas;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use Illuminate\Support\Facades\Auth;

class PrestasiController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Prestasi";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		// dd(session('active_role'));

		if (session('active_role')['id'] != 'ce70ee2f-b43b-432b-b71c-30d073a4ba23') {
			return redirect()->route('prestasi.admin.index');
		}

		$query = Prestasi::query()->whereIdSiswa(session()->get('id_siswa'));
		if ($request->has('search')) {
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Prestasi::prestasi', array_merge($data, ['title' => $this->title]));
	}

	public function index_admin(Request $request)
	{
		$query = Prestasi::query()->orderBy('is_pakai');
		if ($request->has('search')) {
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(20)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Prestasi::prestasi_admin', array_merge($data, ['title' => $this->title]));
	}

	public function ubah_status(Request $request, $id_prestasi, $is_pakai)
	{
		$prestasi = Prestasi::find($id_prestasi);
		$prestasi->is_pakai = $is_pakai;

		$prestasi->updated_by = Auth::id();
		$prestasi->save();

		$text = 'mengedit ' . $this->title; //.' '.$prestasi->what;
		$this->log($request, $text, ['prestasi.id' => $prestasi->id]);
		return redirect()->back()->with('message_success', 'Prestasi berhasil diubah!');
	}

	public function create(Request $request)
	{
		$ref_juara = Juara::all()->sortBy('poin')->pluck('juara', 'id');
		$ref_juara->prepend('-PILIH SALAH SATU-', '');
		// $ref_siswa = Siswa::all()->pluck('nama_siswa','id');
		$id_siswa = session()->get('id_siswa');

		$data['batas_pengisian'] = "2025-01-13 09:59:59";
		$data['batas_waktu'] = strtotime($data['batas_pengisian']);
		$data['waktu_sekarang'] = time();

		$data['forms'] = array(
			'id_juara' => ['Juara', Form::select("id_juara", $ref_juara, null, ["class" => "form-control select2"])],
			'prestasi' => ['Prestasi', Form::text("prestasi", old("prestasi"), ["class" => "form-control", "placeholder" => ""])],
			'tgl_perolehan' => ['Tgl Perolehan', Form::text("tgl_perolehan", old("tgl_perolehan"), ["class" => "form-control datepicker"])],
			'sertifikat' => ['Sertifikat', Form::file("sertifikat",  ["class" => "form-control", "placeholder" => ""])],
			// 'is_pakai' => ['Is Pakai', Form::text("is_pakai", old("is_pakai"), ["class" => "form-control","placeholder" => ""]) ],
			'id_siswa' => ['', Form::hidden("id_siswa", $id_siswa)],

		);

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('Prestasi::prestasi_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_juara' => 'required',
			'id_siswa' => 'required',
			'prestasi' => 'required',
			'sertifikat' => 'required|mimes:pdf,jpg,jpeg,png|max:10240',
			'tgl_perolehan' => 'required|date',
			// 'is_pakai' => 'required',

		]);

		$fileName = time() . '.' . $request->sertifikat->extension();

		$request->sertifikat->move(public_path('uploads/sertifikat_prestasi/'), $fileName);

		$prestasi = new Prestasi();
		$prestasi->id_juara = $request->input("id_juara");
		$prestasi->id_siswa = $request->input("id_siswa");
		$prestasi->prestasi = $request->input("prestasi");
		$prestasi->sertifikat = $fileName;
		$prestasi->tgl_perolehan = $request->input("tgl_perolehan");
		// $prestasi->is_pakai = $request->input("is_pakai");

		$prestasi->created_by = Auth::id();
		$prestasi->save();

		$text = 'membuat ' . $this->title; //' baru '.$prestasi->what;
		$this->log($request, $text, ['prestasi.id' => $prestasi->id]);
		return redirect()->route('prestasi.index')->with('message_success', 'Prestasi berhasil ditambahkan!');
	}

	public function detail_prestasi(Request $request)
	{

		// dd($request->id_prestasi);

		$data['prestasi'] = Prestasi::find($request->id_prestasi);
		$data['ref_juara']	 = Juara::orderBy('poin')->pluck('juara', 'id');

		$text = 'membuka form verifikasi prestasi ' . $this->title; //.' '.$prestasi->what;
		$this->log($request, $text, ['prestasi.id' => $request->id]);
		return view('Prestasi::verif_detail_prestasi', array_merge($data, ['title' => $this->title]));
	}

	public function aksi_verif_prestasi(Request $request)
	{
		$this->validate($request, [
			'id_juara' => 'required',
			'is_pakai' => 'required',

		]);

		$prestasi = Prestasi::find($request->id_prestasi);
		$prestasi->is_pakai = $request->is_pakai;
		$prestasi->id_juara = $request->id_juara;
		$prestasi->is_verif = 1;

		$prestasi->save();

		$text = 'melakukan verifikasi prestasi ' . $this->title; //' baru '.$prestasi->what;
		$this->log($request, $text, ['prestasi.id' => $prestasi->id]);
		return redirect()->back()->with('message_success', 'Prestasi berhasil ditambahkan!');

		// dd($prestasi);
	}

	public function show(Request $request, Prestasi $prestasi)
	{
		$data['prestasi'] = $prestasi;

		$text = 'melihat detail ' . $this->title; //.' '.$prestasi->what;
		$this->log($request, $text, ['prestasi.id' => $prestasi->id]);
		return view('Prestasi::prestasi_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Prestasi $prestasi)
	{
		$data['prestasi'] = $prestasi;

		$ref_juara = Juara::all()->pluck('id_tingkat_juara', 'id');
		$ref_siswa = Siswa::all()->pluck('nama_siswa', 'id');

		$data['forms'] = array(
			// 'id_juara' => ['Juara', Form::select("id_juara", $ref_juara, null, ["class" => "form-control select2"]) ],
			// 'id_siswa' => ['Siswa', Form::select("id_siswa", $ref_siswa, null, ["class" => "form-control select2"]) ],
			'prestasi' => ['Prestasi', Form::text("prestasi", $prestasi->prestasi, ["class" => "form-control", "placeholder" => "", "id" => "prestasi"])],
			// 'sertifikat' => ['Sertifikat', Form::text("sertifikat", $prestasi->sertifikat, ["class" => "form-control","placeholder" => "", "id" => "sertifikat"]) ],
			'tgl_perolehan' => ['Tgl Perolehan', Form::text("tgl_perolehan", $prestasi->tgl_perolehan, ["class" => "form-control datepicker", "id" => "tgl_perolehan"])],
			// 'is_pakai' => ['Is Pakai', Form::text("is_pakai", $prestasi->is_pakai, ["class" => "form-control","placeholder" => "", "id" => "is_pakai"]) ],

		);

		$text = 'membuka form edit ' . $this->title; //.' '.$prestasi->what;
		$this->log($request, $text, ['prestasi.id' => $prestasi->id]);
		return view('Prestasi::prestasi_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			// 'id_juara' => 'required',
			// 'id_siswa' => 'required',
			'prestasi' => 'required',
			// 'sertifikat' => 'required',
			'tgl_perolehan' => 'required',
			// 'is_pakai' => 'required',

		]);

		$prestasi = Prestasi::find($id);
		// $prestasi->id_juara = $request->input("id_juara");
		// $prestasi->id_siswa = $request->input("id_siswa");
		$prestasi->prestasi = $request->input("prestasi");
		// $prestasi->sertifikat = $request->input("sertifikat");
		$prestasi->tgl_perolehan = $request->input("tgl_perolehan");
		// $prestasi->is_pakai = $request->input("is_pakai");

		$prestasi->updated_by = Auth::id();
		$prestasi->save();


		$text = 'mengedit ' . $this->title; //.' '.$prestasi->what;
		$this->log($request, $text, ['prestasi.id' => $prestasi->id]);
		return redirect()->route('prestasi.index')->with('message_success', 'Prestasi berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$prestasi = Prestasi::find($id);
		$prestasi->deleted_by = Auth::id();
		$prestasi->save();
		$prestasi->delete();

		$text = 'menghapus ' . $this->title; //.' '.$prestasi->what;
		$this->log($request, $text, ['prestasi.id' => $prestasi->id]);
		return back()->with('message_success', 'Prestasi berhasil dihapus!');
	}

	public function verif_prestasi(Request $request)
	{
		$data['kelas'] = Kelas::orderBy('kelas')->paginate(12)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Prestasi::verif_daftar_kelas', array_merge($data, ['title' => $this->title]));
	}

	public function daftar_siswa(Request $request, $id_kelas)
	{
		$data['siswa'] = Pesertadidik::join('siswa as s', 'pesertadidik.id_siswa', '=', 's.id')
			->where('pesertadidik.id_kelas', '=', $id_kelas)
			->where('pesertadidik.id_semester', '=', session('active_semester')['id'])
			->orderBy('s.nama_siswa')
			->get();

		session(['id_kelas' => $id_kelas]);

		// dd($data['siswa']);

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Prestasi::verif_daftar_siswa', array_merge($data, ['title' => $this->title]));
	}

	public function daftar_prestasi(Request $request, $id_siswa)
	{
		$data['prestasi']	= Prestasi::where('id_siswa', '=', $id_siswa)->get();
		$data['siswa']		= Siswa::find($id_siswa);

		// dd($data['konfirmasi']);

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Prestasi::verif_daftar_prestasi', array_merge($data, ['title' => $this->title]));
	}

	public function simpan_verif(Request $request)
	{
		$jumlah_data = count($request->id_nilai);

		for ($i = 0; $i < $jumlah_data; $i++) {
			$nilai = Nilai::find($request->id_nilai[$i]);

			$nilai->nilai = $request->nilai[$i];
			$nilai->save();

			// dd($nilai);
		}

		$konfirmasi = Konfirmasinilai::find($request->id_konfirmasi);

		$konfirmasi->is_verif = 1;
		$konfirmasi->save();

		// dd($jumlah_data);


		$text = 'memverifikasi nilai ' . $this->title; //.' '.$nilai->what;
		$this->log($request, $text, ['nilai.id' => $nilai->id]);
		return back()->with('message_success', 'Nilai berhasil diverifikasi!');
	}
}
