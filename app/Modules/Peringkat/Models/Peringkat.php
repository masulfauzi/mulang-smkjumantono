<?php

namespace App\Modules\Peringkat\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Siswa\Models\Siswa;
use App\Modules\Semester\Models\Semester;


class Peringkat extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'peringkat';
	protected $fillable   = ['*'];	

	public function siswa(){
		return $this->belongsTo(Siswa::class,"id_siswa","id");
	}
public function semester(){
		return $this->belongsTo(Semester::class,"id_semester","id");
	}

	public static function get_peringkat_kelas($filter, $semester_aktif)
	{
		return DB::table('pesertadidik as p')
					->join('siswa as s', 's.id', '=', 'p.id_siswa')
					->join('kelas as k', 'k.id', '=', 'p.id_kelas')
					->join('tingkat as t', 't.id', '=', 'k.id_tingkat')
					->join('peringkat as per', 'per.id_siswa', '=', 's.id')
					->join('semester as sem', 'sem.id', '=', 'per.id_semester')
					->where('p.id_semester', $semester_aktif)
					->where('t.tingkat', 'XII')
					->where('k.id', $filter['id_kelas'])
					->where('per.id_semester', $filter['id_semester'])
					->orderBy('per.jml_nilai', 'DESC')
					->get();
	}
	
	public static function get_peringkat_jurusan($filter, $semester_aktif)
	{
		return DB::table('pesertadidik as p')
					->join('siswa as s', 's.id', '=', 'p.id_siswa')
					->join('kelas as k', 'k.id', '=', 'p.id_kelas')
					->join('tingkat as t', 't.id', '=', 'k.id_tingkat')
					->join('peringkat as per', 'per.id_siswa', '=', 's.id')
					->join('semester as sem', 'sem.id', '=', 'per.id_semester')
					->where('p.id_semester', $semester_aktif)
					->where('t.tingkat', 'XII')
					->where('k.id_jurusan', $filter['id_jurusan'])
					->where('per.id_semester', $filter['id_semester'])
					->orderBy('per.jml_nilai', 'DESC')
					->get();
	}

}
