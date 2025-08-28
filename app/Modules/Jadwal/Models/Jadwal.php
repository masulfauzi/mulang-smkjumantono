<?php

namespace App\Modules\Jadwal\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Guru\Models\Guru;
use App\Modules\Hari\Models\Hari;
use App\Modules\Kelas\Models\Kelas;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Ruang\Models\Ruang;
use App\Modules\Semester\Models\Semester;


class Jadwal extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'jadwal';
	protected $fillable   = ['*'];	

	public function guru(){
		return $this->belongsTo(Guru::class,"id_guru","id");
	}
public function hari(){
		return $this->belongsTo(Hari::class,"id_hari","id");
	}
public function kelas(){
		return $this->belongsTo(Kelas::class,"id_kelas","id");
	}
public function mapel(){
		return $this->belongsTo(Mapel::class,"id_mapel","id");
	}
public function ruang(){
		return $this->belongsTo(Ruang::class,"id_ruang","id");
	}
public function semester(){
		return $this->belongsTo(Semester::class,"id_semester","id");
	}

	public static function get_detail_jadwal($id_hari, $jam_mulai, $id_guru, $id_semester)
	{
		return DB::table('jadwal as a')
					->select('a.*', 'b.mapel', 'c.ruang', 'd.kelas')
					->join('mapel as b', 'a.id_mapel', '=', 'b.id')
					->join('ruang as c', 'a.id_ruang', '=', 'c.id')
					->join('kelas as d', 'a.id_kelas','=','d.id')
					->where('a.id_hari', $id_hari)
					->where('a.jam_mulai', $jam_mulai)
					->where('a.id_guru', $id_guru)
					->where('a.id_semester', $id_semester)
					->whereNull('a.deleted_at')
					->first();
	}

	public static function get_jadwal_today()
	{
		return DB::table('jadwal as a')
					->join('hari as b', 'a.id_hari', '=', 'b.id')
					->where('b.urutan', date('N'))
					->where('a.id_semester', get_semester('active_semester_id'))
					->get();
	}

	public static function get_jadwal_terlaksana_today()
	{
		return DB::table('jadwal as a')
					->join('jurnal as b', 'a.id', '=', 'b.id_jadwal')
					->where('b.tgl_pembelajaran', date('Y-m-d'))
					->get();
	}

	public static function get_jadwal_by_kelas_mapel($id_kelas, $id_mapel, $id_semester)
	{
		return DB::table('jadwal as a')
					->select('e.nama', 'c.kelas', 'd.semester', 'b.mapel', 'd.id as id_semester', 'a.id as id_jadwal')
					->join('mapel as b', 'a.id_mapel', '=', 'b.id')
					->join('kelas as c', 'a.id_kelas', '=', 'c.id')
					->join('semester as d', 'a.id_semester', '=', 'd.id')
					->join('guru as e', 'a.id_guru', '=', 'e.id')
					->where('a.id_kelas', $id_kelas)
					->where('a.id_mapel', $id_mapel)
					->where('a.id_semester', $id_semester)
					->get();
	}

	public static function get_teachers()
	{
		return DB::table('teachers')->orderBy('name')->get();
	}

	public static function get_lessons()
	{
		return DB::table('lessons as a')
						->select('a.id', 'b.id as id_mapel', 'c.id as id_guru', 'd.kelas', 'e.ruang', 'd.id as id_kelas', 'e.id as id_ruang')
						->join('mapel as b', 'a.subjectid', '=', 'b.subjectids')
						->join('guru as c', 'a.teacherids', '=', 'c.teacherids')
						->join('kelas as d', 'a.classids', '=', 'd.classids')
						->join('ruang as e', 'a.classroomids', '=', 'e.classroomids', 'left')
						->get();
	}

	public static function get_cards_by_lesson($id_lesson, $day)
	{
		return DB::table('cards')
					->where('lessonid', $id_lesson)
					->where('days', $day)
					->get();
	}

}
