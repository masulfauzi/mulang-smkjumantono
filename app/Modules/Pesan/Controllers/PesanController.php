<?php

namespace App\Modules\Pesan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Pesan\Models\Pesan;

use App\Http\Controllers\Controller;
use App\Modules\FilePesan\Models\FilePesan;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Pesan";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Pesan::query();
		if ($request->has('search')) {
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Pesan::pesan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{

		$data['forms'] = array();

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('Pesan::pesan_create', array_merge($data, ['title' => $this->title]));
	}
	
	public function create_semua_siswa(Request $request)
	{

		$data['forms'] = array();

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('Pesan::pesan_semua_siswa_create', array_merge($data, ['title' => $this->title]));
	}
	public function create_banyak_nomor(Request $request)
	{

		$data['forms'] = array();

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('Pesan::pesan_banyak_nomor_create', array_merge($data, ['title' => $this->title]));
	}

	function store_banyak_nomor(Request $request)
	{
		$this->validate($request, [
			'nomor' => 'required',
			'isi_pesan' => 'required',
			// 'status' => 'required',
		]);

		$pecah_nomor = explode(',', $request->input('nomor'));

		if ($request->has('file')) {
			$fileName = time() . '.' . $request->file->extension();

			$request->file->move(public_path('file_pesan/'), $fileName);

			$file = new FilePesan();
			$file->nama_file = $fileName;

			$file->created_by = Auth::id();
			$file->save();

			for($i=0; $i<count($pecah_nomor); $i++)
			{
				$pesan = new Pesan();
				$pesan->nomor = trim($pecah_nomor[$i]);
				$pesan->isi_pesan = $request->input("isi_pesan");
				$pesan->status = 0;
				$pesan->id_file = $file->id;

				$pesan->created_by = Auth::id();
				$pesan->save();
			}

			
		} else {
			for($i=0; $i<count($pecah_nomor); $i++)
			{
				$pesan = new Pesan();
				$pesan->nomor = trim($pecah_nomor[$i]);
				$pesan->isi_pesan = $request->input("isi_pesan");
				$pesan->status = 0;

				$pesan->created_by = Auth::id();
				$pesan->save();
			}
		}

		$text = 'membuat ' . $this->title; //' baru '.$pesan->what;
		$this->log($request, $text, ['pesan.id' => $pesan->id]);
		return redirect()->route('pesan.index')->with('message_success', 'Pesan berhasil ditambahkan!');
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nomor' => 'required',
			'isi_pesan' => 'required',
			// 'status' => 'required',
		]);

		if ($request->has('file')) {
			$fileName = time() . '.' . $request->file->extension();

			$request->file->move(public_path('file_pesan/'), $fileName);

			$file = new FilePesan();
			$file->nama_file = $fileName;

			$file->created_by = Auth::id();
			$file->save();

			$pesan = new Pesan();
			$pesan->nomor = $request->input("nomor");
			$pesan->isi_pesan = $request->input("isi_pesan");
			$pesan->status = 0;
			$pesan->id_file = $file->id;

			$pesan->created_by = Auth::id();
			$pesan->save();
		} else {
			$pesan = new Pesan();
			$pesan->nomor = $request->input("nomor");
			$pesan->isi_pesan = $request->input("isi_pesan");
			$pesan->status = 0;

			$pesan->created_by = Auth::id();
			$pesan->save();
		}

		$text = 'membuat ' . $this->title; //' baru '.$pesan->what;
		$this->log($request, $text, ['pesan.id' => $pesan->id]);
		return redirect()->route('pesan.index')->with('message_success', 'Pesan berhasil ditambahkan!');
	}

	public function store_semua_siswa(Request $request)
	{
		$this->validate($request, [
			// 'nomor' => 'required',
			'isi_pesan' => 'required',
			// 'status' => 'required',
		]);

		$siswa = Pesertadidik::whereIdSemester(session('active_semester')['id'])
			->select('s.no_hp')
			->join('siswa as s', 's.id', '=', 'pesertadidik.id_siswa')
			->get();

		if ($request->has('file')) {
			$fileName = time() . '.' . $request->file->extension();

			$request->file->move(public_path('file_pesan/'), $fileName);

			$file = new FilePesan();
			$file->nama_file = $fileName;

			$file->created_by = Auth::id();
			$file->save();

			foreach ($siswa as $sis) {
				$pesan = new Pesan();
				$pesan->nomor = $sis->no_hp;
				$pesan->isi_pesan = $request->input("isi_pesan");
				$pesan->status = 0;
				$pesan->id_file = $file->id;

				$pesan->created_by = Auth::id();
				$pesan->save();
			}
		} else {
			foreach ($siswa as $sis) {
				$pesan = new Pesan();
				$pesan->nomor = $sis->no_hp;
				$pesan->isi_pesan = $request->input("isi_pesan");
				$pesan->status = 0;

				$pesan->created_by = Auth::id();
				$pesan->save();
			}
		}

		$text = 'membuat ' . $this->title; //' baru '.$pesan->what;
		$this->log($request, $text, ['pesan.id' => $pesan->id]);
		return redirect()->route('pesan.index')->with('message_success', 'Pesan berhasil ditambahkan!');
	}

	public function show(Request $request, Pesan $pesan)
	{
		$data['pesan'] = $pesan;

		$text = 'melihat detail ' . $this->title; //.' '.$pesan->what;
		$this->log($request, $text, ['pesan.id' => $pesan->id]);
		return view('Pesan::pesan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Pesan $pesan)
	{
		$data['pesan'] = $pesan;


		$data['forms'] = array(
			'nomor' => ['Nomor', Form::text("nomor", $pesan->nomor, ["class" => "form-control", "placeholder" => "", "id" => "nomor"])],
			'isi_pesan' => ['Isi Pesan', Form::textarea("isi_pesan", $pesan->isi_pesan, ["class" => "form-control rich-editor"])],
			'status' => ['Status', Form::text("status", $pesan->status, ["class" => "form-control", "placeholder" => "", "id" => "status"])],

		);

		$text = 'membuka form edit ' . $this->title; //.' '.$pesan->what;
		$this->log($request, $text, ['pesan.id' => $pesan->id]);
		return view('Pesan::pesan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nomor' => 'required',
			'isi_pesan' => 'required',
			'status' => 'required',

		]);

		$pesan = Pesan::find($id);
		$pesan->nomor = $request->input("nomor");
		$pesan->isi_pesan = $request->input("isi_pesan");
		$pesan->status = $request->input("status");

		$pesan->updated_by = Auth::id();
		$pesan->save();


		$text = 'mengedit ' . $this->title; //.' '.$pesan->what;
		$this->log($request, $text, ['pesan.id' => $pesan->id]);
		return redirect()->route('pesan.index')->with('message_success', 'Pesan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$pesan = Pesan::find($id);
		$pesan->deleted_by = Auth::id();
		$pesan->save();
		$pesan->delete();

		$text = 'menghapus ' . $this->title; //.' '.$pesan->what;
		$this->log($request, $text, ['pesan.id' => $pesan->id]);
		return back()->with('message_success', 'Pesan berhasil dihapus!');
	}
}
