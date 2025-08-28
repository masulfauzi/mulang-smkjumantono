<?php

namespace App\Modules\Snbp\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Snbp\Models\Snbp;
use App\Modules\Semester\Models\Semester;
use App\Modules\Siswa\Models\Siswa;

use App\Http\Controllers\Controller;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Kelas\Models\Kelas;
use App\Modules\Nilai\Models\Nilai;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use App\Modules\Prestasi\Models\Prestasi;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;

class SnbpController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Snbp";

	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		if (session('active_role')['id'] == 'ce70ee2f-b43b-432b-b71c-30d073a4ba23') {
			return redirect()->route('snbp.siswa.index');
		}

		$data['data'] = Jurusan::all();

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Snbp::snbp', array_merge($data, ['title' => $this->title]));
	}

	public function skl_jurusan(Request $request, Jurusan $jurusan)
	{
		$data['siswa'] = Siswa::join('pesertadidik as p', 'siswa.id', '=', 'p.id_siswa')
			->join('kelas as k', 'p.id_kelas', '=', 'k.id')
			->where('p.id_semester', session('active_semester')['id'])
			->where('k.id_jurusan', $jurusan->id)
			// ->select('siswa.*', 'k.kelas')
			->orderBy('k.kelas')
			->orderBy('siswa.nama_siswa')
			// ->limit(10)
			->get();
		// dd($data);

		$data['semester'] = Semester::orderBy('urutan', 'DESC')->limit(6)->get();
		// dd($data['semester']);

		$id_siswa = [];
		foreach ($data['siswa'] as $siswa) {
			$id_siswa[] = $siswa->id_siswa;
		}

		// dd($id_siswa);

		$data['mapel'] = Nilai::select('m.*')
			->join('mapel as m', 'nilai.id_mapel', '=', 'm.id')
			->whereIn('nilai.id_siswa', $id_siswa)
			->groupBy('nilai.id_mapel')
			->get();

		$data['nilai'] = Nilai::select('nilai.*')
			->join('mapel as m', 'nilai.id_mapel', '=', 'm.id')
			->whereIn('nilai.id_siswa', $id_siswa)
			// ->limit(10)
			->get();

		// dd($data['nilai']);

		return view('Snbp::skl_jurusan', $data);
	}

	public function nilai_jurusan(Request $request, Jurusan $jurusan)
	{
		$data['data'] = Snbp::get_nilai_snbp_jurusan($jurusan->id, session('active_semester')['id'], $request->id_kelas);
		// ->where('is_eligible_final', '1')
		// ->sortBy('peringkat')
		// ->sortBy('peringkat_final');
		$data['ref_semester'] = Semester::orderBy('urutan')->pluck('semester', 'id');
		$data['ref_semester']->prepend('-PILIH SALAH SATU-', '');
		$data['ref_kelas'] = Kelas::join('tingkat as t', 'kelas.id_tingkat', '=', 't.id')->where('t.tingkat', 'XII')->where('id_jurusan', $jurusan->id)->pluck('kelas.kelas', 'kelas.id');
		$data['ref_kelas']->prepend('-PILIH SALAH SATU-', '');

		$semester_aktif = $request->id_semester;
		$kelas_aktif = $request->id_kelas;
		$data['semester_aktif'] = $semester_aktif;
		$data['kelas_aktif'] = $kelas_aktif;
		// dd($semester_aktif);

		if ($semester_aktif) {
			$id_siswa = [];
			foreach ($data['data'] as $siswa) {
				$id_siswa[] = $siswa->id_siswa;
			}
			$data['nilai'] = Nilai::whereIn('id_siswa', $id_siswa)->where('nilai.id_semester', $semester_aktif)->get();
			$data['mapel'] = Nilai::join('mapel as m', 'nilai.id_mapel', '=', 'm.id')
				->whereIn('id_siswa', $id_siswa)
				->where('nilai.id_semester', $semester_aktif)
				->groupBy('nilai.id_mapel')
				->get();
			// dd($mapel);
		} else {
			$data['mapel'] = '';
		}

		$this->log($request, 'melihat halaman nilai snbp');
		return view('Snbp::nilai_jurusan', array_merge($data, ['title' => $this->title]));
	}

	public function index_siswa(Request $request)
	{
		// dd(session('id_siswa'));
		$siswa = Siswa::detail_siswa(session('id_siswa'));

		// dd($siswa);

		$data['pesertadidik'] = Pesertadidik::join('kelas as k', 'pesertadidik.id_kelas', '=', 'k.id')
			->join('snbp as s', 'pesertadidik.id_siswa', '=', 's.id_siswa')
			->where('k.id_jurusan', $siswa->id_jurusan)
			->where('pesertadidik.id_semester', session('active_semester')['id'])
			->get();
		$data['data'] = Snbp::whereIdSiswa(session('id_siswa'))->first();

		// dd($data['data']);

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Snbp::snbp_siswa', array_merge($data, ['title' => $this->title]));
	}

	public function update_minat(Request $request, $id_snbp)
	{
		$snbp = Snbp::find($id_snbp);

		$snbp->is_berminat = $request->input('berminat');

		$snbp->updated_by = Auth::id();
		$snbp->save();

		$this->log($request, 'mengubah status berminat');
		return redirect()->back()->with('message_success', 'Status berhasil disimpan');
	}

	public function upload_super(Request $request, $id_snbp)
	{
		$request->validate([
			'file' => 'required|mimes:pdf,doc,docx|max:10240'
		]);

		$fileName = time() . '.' . $request->file->extension();

		$request->file->move(public_path('uploads/super/'), $fileName);


		$snbp = Snbp::find($id_snbp);

		$snbp->super = $fileName;

		$snbp->updated_by = Auth::id();
		$snbp->save();

		$this->log($request, 'mengupload super');
		return redirect()->back()->with('message_success', 'Surat Pernyataan berhasil disimpan');
	}

	public function index_jurusan(Request $request, Jurusan $jurusan)
	{
		$data['data'] = Snbp::get_nilai_snbp_jurusan($jurusan->id, session('active_semester')['id'])->sortBy('peringkat')->sortBy('peringkat_final');
		$data['jurusan'] = $jurusan;

		$this->log($request, 'melihat halaman manajemen data ' . $this->title);
		return view('Snbp::snbp_jurusan', array_merge($data, ['title' => $this->title]));
	}

	public function finalisasi(Request $request, Jurusan $jurusan)
	{
		// dd($jurusan);

		$urutkan = Snbp::get_nilai_snbp_jurusan_final($jurusan->id, session('active_semester')['id']);

		$kuota = $jurusan->kuota_snbp;

		$no = 1;
		foreach ($urutkan as $urutan) {
			if ($no <= $kuota) {
				$eligible = 1;
			} else {
				$eligible = 0;
			}

			$snbp = Snbp::find($urutan->id);
			$snbp->is_eligible_final = $eligible;
			$snbp->peringkat_final = $no;

			$snbp->updated_by = Auth::id();
			$snbp->save();

			$no++;
		}


		$text = 'membuat ' . $this->title; //' baru '.$snbp->what;
		$this->log($request, $text, ['snbp.id' => $snbp->id]);
		return redirect()->back()->with('message_success', 'Snbp berhasil ditambahkan!');
	}

	public function generate_jurusan(Request $request, Jurusan $jurusan)
	{
		// dd($jurusan->id);

		$id_semester = session('active_semester')['id'];

		$siswa = Siswa::select('siswa.id')
			->join('pesertadidik as b', 'siswa.id', '=', 'b.id_siswa')
			->join('kelas as c', 'b.id_kelas', '=', 'c.id')
			->join('tingkat as d', 'c.id_tingkat', '=', 'd.id')
			->where('b.id_semester', $id_semester)
			->where('c.id_jurusan', $jurusan->id)
			->where('d.tingkat', 'XII')
			->get();

		// dd($siswa);

		// $hapus = Snbp::whereIn('id_siswa',$siswa)->delete();

		// dd($hapus);

		foreach ($siswa as $item) {
			$prestasi = Prestasi::join('juara as j', 'prestasi.id_juara', '=', 'j.id')
				->where('prestasi.id_siswa', $item->id)
				->where('prestasi.is_pakai', '1')
				->orderBy('j.poin', 'desc')
				->first();

			if ($prestasi) {
				$nilai_tambah = $prestasi->poin;
			} else {
				$nilai_tambah = 0;
			}

			$semester = Nilai::whereIdSiswa($item->id)->groupBy('id_semester')->get();

			$data_nilai = array();
			$counter = 1;
			foreach ($semester as $data_semester) {
				$nilai = Nilai::whereIdSemester($data_semester->id_semester)->whereIdSiswa($item->id)->get();

				$total_nilai = $nilai->sum('nilai');

				$pembagi = count($nilai);

				$data_nilai[$counter] = $total_nilai / $pembagi;

				// dd($pembagi);
				$counter++;
			}

			$data_nilai_collection = collect($data_nilai);

			$cek_snbp = Snbp::whereIdSemester(session('active_semester')['id'])
				->whereIdSiswa($item->id)
				->first();
			// dd($cek_snbp);

			$rata_rata = $data_nilai_collection->sum() / count($data_nilai_collection);

			if ($cek_snbp) {
				$snbp = Snbp::find($cek_snbp->id);
				$snbp->rata_rata = $rata_rata;
				$snbp->nilai_tambah = $nilai_tambah;
				$snbp->total = $rata_rata + $nilai_tambah;

				$snbp->updated_by = Auth::id();
				$snbp->save();
			} else {
				$snbp = new Snbp();
				$snbp->id_semester = session('active_semester')['id'];
				$snbp->id_siswa = $item->id;
				$snbp->rata_rata = $rata_rata;
				$snbp->nilai_tambah = $nilai_tambah;
				$snbp->total = $rata_rata + $nilai_tambah;

				$snbp->created_by = Auth::id();
				$snbp->save();
			}
		}




		$urutkan = Snbp::get_nilai_snbp_jurusan($jurusan->id, $id_semester);

		// $kuota = 40 / 100 * count($urutkan);
		$kuota = $jurusan->kuota_snbp;

		$no = 1;
		foreach ($urutkan as $urutan) {
			if ($no <= $kuota) {
				$eligible = 1;
			} else {
				$eligible = 0;
			}

			$snbp = Snbp::find($urutan->id);
			$snbp->is_eligible = $eligible;
			$snbp->peringkat = $no;

			$snbp->updated_by = Auth::id();
			$snbp->save();

			$no++;
		}


		$text = 'membuat ' . $this->title; //' baru '.$snbp->what;
		$this->log($request, $text, ['snbp.id' => $snbp->id]);
		return redirect()->back()->with('message_success', 'Snbp berhasil ditambahkan!');
	}

	public function create(Request $request)
	{
		$ref_semester = Semester::all()->pluck('semester', 'id');
		$ref_siswa = Siswa::all()->pluck('nama_siswa', 'id');

		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"])],
			'id_siswa' => ['Siswa', Form::select("id_siswa", $ref_siswa, null, ["class" => "form-control select2"])],
			'rata_rata' => ['Rata Rata', Form::text("rata_rata", old("rata_rata"), ["class" => "form-control", "placeholder" => ""])],
			'is_berminat' => ['Is Berminat', Form::text("is_berminat", old("is_berminat"), ["class" => "form-control", "placeholder" => ""])],

		);

		$this->log($request, 'membuka form tambah ' . $this->title);
		return view('Snbp::snbp_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_siswa' => 'required',
			'rata_rata' => 'required',
			'is_berminat' => 'required',

		]);

		$snbp = new Snbp();
		$snbp->id_semester = $request->input("id_semester");
		$snbp->id_siswa = $request->input("id_siswa");
		$snbp->rata_rata = $request->input("rata_rata");
		$snbp->is_berminat = $request->input("is_berminat");

		$snbp->created_by = Auth::id();
		$snbp->save();

		$text = 'membuat ' . $this->title; //' baru '.$snbp->what;
		$this->log($request, $text, ['snbp.id' => $snbp->id]);
		return redirect()->route('snbp.index')->with('message_success', 'Snbp berhasil ditambahkan!');
	}

	public function show(Request $request, Snbp $snbp)
	{
		$data['snbp'] = $snbp;

		$text = 'melihat detail ' . $this->title; //.' '.$snbp->what;
		$this->log($request, $text, ['snbp.id' => $snbp->id]);
		return view('Snbp::snbp_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Snbp $snbp)
	{
		$data['snbp'] = $snbp;

		$ref_semester = Semester::all()->pluck('semester', 'id');
		$ref_siswa = Siswa::all()->pluck('nama_siswa', 'id');

		$data['forms'] = array(
			'id_semester' => ['Semester', Form::select("id_semester", $ref_semester, null, ["class" => "form-control select2"])],
			'id_siswa' => ['Siswa', Form::select("id_siswa", $ref_siswa, null, ["class" => "form-control select2"])],
			'rata_rata' => ['Rata Rata', Form::text("rata_rata", $snbp->rata_rata, ["class" => "form-control", "placeholder" => "", "id" => "rata_rata"])],
			'is_berminat' => ['Is Berminat', Form::text("is_berminat", $snbp->is_berminat, ["class" => "form-control", "placeholder" => "", "id" => "is_berminat"])],

		);

		$text = 'membuka form edit ' . $this->title; //.' '.$snbp->what;
		$this->log($request, $text, ['snbp.id' => $snbp->id]);
		return view('Snbp::snbp_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_semester' => 'required',
			'id_siswa' => 'required',
			'rata_rata' => 'required',
			'is_berminat' => 'required',

		]);

		$snbp = Snbp::find($id);
		$snbp->id_semester = $request->input("id_semester");
		$snbp->id_siswa = $request->input("id_siswa");
		$snbp->rata_rata = $request->input("rata_rata");
		$snbp->is_berminat = $request->input("is_berminat");

		$snbp->updated_by = Auth::id();
		$snbp->save();


		$text = 'mengedit ' . $this->title; //.' '.$snbp->what;
		$this->log($request, $text, ['snbp.id' => $snbp->id]);
		return redirect()->route('snbp.index')->with('message_success', 'Snbp berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$snbp = Snbp::find($id);
		$snbp->deleted_by = Auth::id();
		$snbp->save();
		$snbp->delete();

		$text = 'menghapus ' . $this->title; //.' '.$snbp->what;
		$this->log($request, $text, ['snbp.id' => $snbp->id]);
		return back()->with('message_success', 'Snbp berhasil dihapus!');
	}
}
