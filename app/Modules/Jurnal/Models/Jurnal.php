<?php

namespace App\Modules\Jurnal\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Jadwal\Models\Jadwal;


class Jurnal extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'jurnal';
	protected $fillable   = ['*'];	

	public function jadwal(){
		return $this->belongsTo(Jadwal::class,"id_jadwal","id");
	}

	public static function get_detail_jurnal($id_jurnal)
	{
		return DB::table('jurnal as a')
					->select('a.*', 'c.mapel', 'b.id_kelas', 'd.kelas')
					->join('jadwal as b', 'a.id_jadwal', '=', 'b.id')
					->join('mapel as c', 'b.id_mapel', '=', 'c.id')
					->join('kelas as d', 'b.id_kelas', '=', 'd.id')
					->where('a.id', $id_jurnal)
					->first();
	}

	public static function get_jurnal_by_idjadwal_and_date($id_jadwal, $tgl)
	{
		return DB::table('jurnal')
					->where('id_jadwal', $id_jadwal)
					->where('tgl_pembelajaran', $tgl)
					->whereNull('deleted_at')
					->first();
	}

	public static function get_jurnal_guru($id_user, $id_semester)
	{
		return DB::table('jurnal as a')
					->select('a.*', 'c.mapel', 'b.id_kelas', 'd.kelas')
					->join('jadwal as b', 'a.id_jadwal', '=', 'b.id')
					->join('mapel as c', 'b.id_mapel', '=', 'c.id')
					->join('kelas as d', 'b.id_kelas', '=', 'd.id')
					->where('a.created_by', $id_user)
					->where('b.id_semester', $id_semester)
					->whereNull('a.deleted_at')
					->orderBy('a.tgl_pembelajaran', 'DESC');
	}

	public static function get_mapel_guru($id_guru, $id_semester)
	{
		return DB::table('jadwal as a')
					->select('b.id', 'b.mapel')
					->join('mapel as b', 'a.id_mapel', '=', 'b.id')
					->where('a.id_guru', $id_guru)
					->where('a.id_semester', $id_semester)
					->orderBy('b.mapel')
					->get();
	}

	public static function get_kelas_guru($id_guru, $id_semester)
	{
		return DB::table('jadwal as a')
					->select('b.id', 'b.kelas')
					->join('kelas as b', 'a.id_kelas', '=', 'b.id')
					->where('a.id_guru', $id_guru)
					->where('a.id_semester', $id_semester)
					->orderBy('b.kelas')
					->get();
	}

	public static function get_jurnal($id_jadwal)
	{
		return DB::table('jurnal as a')
					->select('a.tgl_pembelajaran', 'c.jam_pelajaran as jam_mulai', 'd.jam_pelajaran as jam_selesai', 'a.materi', 'a.catatan')
					->join('jadwal as b', 'a.id_jadwal', '=', 'b.id')
					->join('jampelajaran as c', 'b.jam_mulai', '=', 'c.id')
					->join('jampelajaran as d', 'b.jam_selesai', '=', 'd.id')
					->whereIn('a.id_jadwal', $id_jadwal)
					->whereNull('a.deleted_at')
					->orderBy('a.tgl_pembelajaran')
					->get();
	}

}
