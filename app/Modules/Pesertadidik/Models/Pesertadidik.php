<?php

namespace App\Modules\Pesertadidik\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Semester\Models\Semester;
use App\Modules\Siswa\Models\Siswa;
use App\Modules\Kelas\Models\Kelas;


class Pesertadidik extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'pesertadidik';
	protected $fillable   = ['*'];	

	public function semester(){
		return $this->belongsTo(Semester::class,"id_semester","id");
	}
public function siswa(){
		return $this->belongsTo(Siswa::class,"id_siswa","id");
	}
public function kelas(){
		return $this->belongsTo(Kelas::class,"id_kelas","id");
	}

	public static function get_pd_by_idkelas($id_kelas, $id_semester)
	{
		return DB::table('pesertadidik as a')
					->select('a.*', 'b.nama_siswa')
					->join('siswa as b', 'a.id_siswa', 'b.id')
					->where('a.id_kelas', $id_kelas)
					->where('a.is_magang', '0')
					->where('a.id_semester', $id_semester)
					->orderBy('b.nama_siswa')
					->get();
	}

	public static function get_pd_by_id($id_pd)
	{
		return DB::table('pesertadidik as a')
					->join('siswa as b', 'a.id_siswa', '=', 'b.id')
					->where('a.id', $id_pd);
	}

	public static function get_all($id_semester)
	{
		return DB::table('siswa as a')
					->select('a.nama_siswa', 'c.kelas')
					->join('pesertadidik as b', 'a.id', '=', 'b.id_siswa')
					->join('kelas as c', 'b.id_kelas', '=', 'c.id')
					->join('tingkat as d', 'c.id_tingkat', '=', 'd.id')
					->where('b.id_semester', $id_semester)
					->where('d.tingkat', 'XII')
					->orderBy('c.kelas')
					->orderBy('a.nama_siswa')
					->get();
	}

}
