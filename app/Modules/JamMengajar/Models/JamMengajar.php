<?php

namespace App\Modules\JamMengajar\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Semester\Models\Semester;
use App\Modules\Guru\Models\Guru;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Kelas\Models\Kelas;


class JamMengajar extends Model
{
	// use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'jam_mengajar';
	protected $fillable   = ['*'];

	public function semester()
	{
		return $this->belongsTo(Semester::class, "id_semester", "id");
	}
	public function guru()
	{
		return $this->belongsTo(Guru::class, "id_guru", "id");
	}
	public function mapel()
	{
		return $this->belongsTo(Mapel::class, "id_mapel", "id");
	}
	public function kelas()
	{
		return $this->belongsTo(Kelas::class, "id_kelas", "id");
	}

	public static function get_guru($id_semester)
	{
		return DB::table('guru as a')
			->select('a.nama', 'a.id as id_guru', DB::raw('sum(b.jml_jam) as jml_jam'))
			->leftJoin('jam_mengajar as b', function ($join) use ($id_semester) {
				$join->on('a.id', '=', 'b.id_guru');
				$join->on('b.id_semester', '=', DB::raw("'" . $id_semester . "'"));
			})
			// ->whereNull('b.deleted_at')
			// ->where('b.id_semester', '=', $id_semester)
			->groupBy('a.id')
			->orderBy('a.nama')
			->get();
	}

	public static function get_kelas($id_semester)
	{
		return DB::table('kelas as a')
			->select('a.kelas', 'a.id as id_kelas', DB::raw('sum(b.jml_jam) as jml_jam'))
			->leftJoin('jam_mengajar as b', function ($join) use ($id_semester) {
				$join->on('a.id', '=', 'b.id_kelas');
				$join->on('b.id_semester', '=', DB::raw("'" . $id_semester . "'"));
			})
			// ->whereNull('b.deleted_at')
			// ->where('b.id_semester', '=', $id_semester)
			->groupBy('a.id')
			->orderBy('a.kelas')
			->get();
	}

	public static function get_mapel_perangkat($id_semester, $id_guru = NULL)
	{
		if ($id_guru != NULL) {
			$query = DB::table('jam_mengajar as a')
				->select('a.*', 'c.mapel', 'e.tingkat')
				->join('guru as b', 'a.id_guru', '=', 'b.id')
				->join('mapel as c', 'a.id_mapel', '=', 'c.id')
				->join('kelas as d', 'a.id_kelas', '=', 'd.id')
				->join('tingkat as e', 'd.id_tingkat', '=', 'e.id')
				->where('a.id_semester', $id_semester)
				->where('b.is_aktif', '1')
				->where('a.id_guru', $id_guru)
				->groupBy('a.id_guru', 'e.id', 'c.id')
				->orderBy('e.tingkat')
				->orderBy('c.mapel')
				// ->limit(1)
				->get();
		} else {
			$query = DB::table('jam_mengajar as a')
				->select('a.*', 'c.mapel', 'e.tingkat', 'b.nama as nama_guru')
				->join('guru as b', 'a.id_guru', '=', 'b.id')
				->join('mapel as c', 'a.id_mapel', '=', 'c.id')
				->join('kelas as d', 'a.id_kelas', '=', 'd.id')
				->join('tingkat as e', 'd.id_tingkat', '=', 'e.id')
				->where('a.id_semester', $id_semester)
				->where('b.is_aktif', '1')
				->whereNull('b.deleted_at')
				->groupBy('e.id', 'c.id', 'b.id')
				->orderBy('b.nama')
				->orderBy('e.tingkat')
				->orderBy('c.mapel')
				->get();
		}



		return $query;
	}

	public static function get_guru_mapel()
	{
		return DB::table('jam_mengajar as a')
			->select('b.mapel', 'c.nama')
			->join('mapel as b', 'a.id_mapel', '=', 'b.id')
			->join('guru as c', 'a.id_guru', '=', 'c.id')
			->groupBy('a.id_mapel', 'a.id_guru')
			->orderBy('c.nama')
			->get();
	}
}
