<?php

namespace App\Modules\Snbp\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Semester\Models\Semester;
use App\Modules\Siswa\Models\Siswa;


class Snbp extends Model
{
	// use SoftDeletes;
	use UsesUuid;

	protected $dates = ['deleted_at'];
	protected $table = 'snbp';
	protected $fillable = ['*'];

	public function semester()
	{
		return $this->belongsTo(Semester::class, "id_semester", "id");
	}
	public function siswa()
	{
		return $this->belongsTo(Siswa::class, "id_siswa", "id");
	}

	public static function get_nilai_snbp_jurusan($id_jurusan, $id_semester, $id_kelas)
	{
		if ($id_kelas) {
			return DB::table('snbp')
				->select('snbp.*', 's.nama_siswa', 's.nisn')
				->join('pesertadidik as p', 'p.id_siswa', '=', 'snbp.id_siswa')
				->join('siswa as s', 'p.id_siswa', '=', 's.id')
				->join('kelas as k', 'k.id', '=', 'p.id_kelas')
				->where('k.id_jurusan', $id_jurusan)
				->where('snbp.id_semester', $id_semester)
				->where('p.id_semester', $id_semester)
				->where('k.id', $id_kelas)
				// ->orderBy('snbp.is_berminat', 'DESC')
				->orderBy('s.nama_siswa')
				->get();
		} else {
			return DB::table('snbp')
				->select('snbp.*', 's.nama_siswa', 's.nisn')
				->join('pesertadidik as p', 'p.id_siswa', '=', 'snbp.id_siswa')
				->join('siswa as s', 'p.id_siswa', '=', 's.id')
				->join('kelas as k', 'k.id', '=', 'p.id_kelas')
				->where('k.id_jurusan', $id_jurusan)
				->where('snbp.id_semester', $id_semester)
				->where('p.id_semester', $id_semester)
				// ->orderBy('snbp.is_berminat', 'DESC')
				->orderBy('s.nama_siswa')
				->get();
		}
	}

	public static function get_nilai_snbp_jurusan_final($id_jurusan, $id_semester)
	{
		return DB::table('snbp')
			->select('snbp.*', 's.nama_siswa', 's.nisn')
			->join('pesertadidik as p', 'p.id_siswa', '=', 'snbp.id_siswa')
			->join('siswa as s', 'p.id_siswa', '=', 's.id')
			->join('kelas as k', 'k.id', '=', 'p.id_kelas')
			->where('k.id_jurusan', $id_jurusan)
			->where('snbp.id_semester', $id_semester)
			->where('p.id_semester', $id_semester)
			->orderBy('snbp.is_berminat', 'DESC')
			->orderBy('snbp.total', 'DESC')
			->get();
	}
}
