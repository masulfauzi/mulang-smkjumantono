<?php

namespace App\Modules\Snmptn\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Pesertadidik\Models\Pesertadidik;


class Snmptn extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'snmptn';
	protected $fillable   = ['*'];	

	public function pesertadidik(){
		return $this->belongsTo(Pesertadidik::class,"id_pesertadidik","id");
	}

	public static function get_data_peringkat($id_kelas = NULL, $semester, $id_jurusan)
	{
		$nilai = "jml_nilai_".$semester;
		$pembagi = "pembagi_".$semester;

		// $data = DB::table('siswa as a')
		// 			->select('a.nama_siswa', 'a.nisn')
		// 			->selectRaw("c.$nilai / c.$pembagi as nilai")
		// 			->join('pesertadidik as b', 'a.id', 'b.id_siswa')
		// 			->join('snmptn as c', 'b.id', 'c.id_pesertadidik')
		// 			->join('kelas as d', 'b.id_kelas', 'd.id');

		// if($id_kelas == NULL)
		// {
		// 	$data->where('d.id_jurusan', $id_jurusan);
		// }
		// else
		// {
		// 	$data->where('b.id_kelas', $id_kelas);
		// }

		// $data->orderBy('nilai', 'desc')->get();

		// return $data;

		if($id_kelas == NULL)
		{
			return DB::table('siswa as a')
					->select('a.nama_siswa', 'a.nisn')
					->selectRaw("c.$nilai / c.$pembagi as nilai")
					->join('pesertadidik as b', 'a.id', 'b.id_siswa')
					->join('snmptn as c', 'b.id', 'c.id_pesertadidik')
					->join('kelas as d', 'b.id_kelas', 'd.id')
					->where('d.id_jurusan', $id_jurusan)
					->orderBy('nilai', 'desc')
					->get();
		}
		else
		{
			return DB::table('siswa as a')
					->select('a.nama_siswa', 'a.nisn')
					->selectRaw("c.$nilai / c.$pembagi as nilai")
					->join('pesertadidik as b', 'a.id', 'b.id_siswa')
					->join('snmptn as c', 'b.id', 'c.id_pesertadidik')
					->join('kelas as d', 'b.id_kelas', 'd.id')
					->where('b.id_kelas', $id_kelas)
					->where('d.id_jurusan', $id_jurusan)
					->orderBy('nilai', 'desc')
					->get();
		}

		
	}

	public static function get_kelas_xii()
	{
		return DB::table('kelas as a')
						->select('a.kelas', 'a.id')
						->join('tingkat as b', 'a.id_tingkat', 'b.id')
						->where('b.tingkat', 'XII')
						->get();
	}

	public static function get_peringkat($id_jurusan)
	{
		return DB::table('snmptn as a')
					->select('a.*', 'c.nama_siswa', 'e.prestasi', 'c.nisn', 'd.kelas')
					->join('pesertadidik as b', 'a.id_pesertadidik', '=', 'b.id')
					->join('siswa as c', 'b.id_siswa', '=', 'c.id')
					->join('kelas as d', 'b.id_kelas', '=', 'd.id')
					->join('prestasi as e', 'a.id_prestasi', '=', 'e.id', 'left')
					->where('d.id_jurusan', $id_jurusan)
					->orderBy('a.peringkat')
					->get();
	}

	public static  function get_pd_by_jurusan($id_jurusan)
	{
		return DB::table('snmptn as a')
					->select('a.*')
					->join('pesertadidik as b', 'a.id_pesertadidik', '=', 'b.id')
					->join('kelas as c', 'b.id_kelas', '=', 'c.id')
					->where('c.id_jurusan',$id_jurusan);
	}

	public static function update_nilai($data)
	{
		return DB::table('snmptn')
					->where('id', $data['id'])
					->update($data);
	}

	public static function get_detail_snmptn_by_nisn($nisn)
	{
		return DB::table('snmptn as a')
					->join('pesertadidik as b', 'a.id_pesertadidik', '=', 'b.id')
					->join('siswa as c', 'b.id_siswa', '=', 'c.id')
					->join('kelas as d', 'b.id_kelas', '=', 'd.id')
					->join('jurusan as e', 'd.id_jurusan', '=', 'e.id')
					->where('c.nisn', $nisn)
					->first();
	}

}
