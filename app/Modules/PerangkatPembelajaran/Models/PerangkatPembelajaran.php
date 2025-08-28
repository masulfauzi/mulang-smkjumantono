<?php

namespace App\Modules\PerangkatPembelajaran\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Semester\Models\Semester;
use App\Modules\Guru\Models\Guru;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Tingkat\Models\Tingkat;
use App\Modules\JenisPerangkat\Models\JenisPerangkat;


class PerangkatPembelajaran extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'perangkat_pembelajaran';
	protected $fillable   = ['*'];	

	public function semester(){
		return $this->belongsTo(Semester::class,"id_semester","id");
	}
public function guru(){
		return $this->belongsTo(Guru::class,"id_guru","id");
	}
public function mapel(){
		return $this->belongsTo(Mapel::class,"id_mapel","id");
	}
public function tingkat(){
		return $this->belongsTo(Tingkat::class,"id_tingkat","id");
	}
public function jenisPerangkat(){
		return $this->belongsTo(JenisPerangkat::class,"id_jenis_perangkat","id");
	}

	public static function cek_upload_perangkat($id)
	{
		$cek = DB::table('jam_mengajar as a')
					->join('kelas as b', 'a.id_kelas', '=', 'b.id')
					->where('a.id', $id)
					->first();

		$data = DB::table('perangkat_pembelajaran as a')
					->where('id_guru', $cek->id_guru)
					->where('id_semester', $cek->id_semester)
					->where('id_mapel', $cek->id_mapel)
					->where('id_tingkat', $cek->id_tingkat)
					->count();

		return $data;
	}

	public static function get_kelas_by_data($data)
	{
		$cari = DB::table('jam_mengajar as a')
					->join('kelas as b', 'a.id_kelas', '=', 'b.id')
					->where('a.id', $data->id)
					->first();

		return DB::table('jam_mengajar as a')
					->join('mapel as b', 'a.id_mapel', '=', 'b.id')
					->join('kelas as c', 'a.id_kelas', '=', 'c.id')
					->where('a.id_mapel', $data->id_mapel)
					->where('a.id_guru', $data->id_guru)
					->where('a.id_semester', $data->id_semester)
					->where('c.id_tingkat', $cari->id_tingkat)
					->get();
	}

}
