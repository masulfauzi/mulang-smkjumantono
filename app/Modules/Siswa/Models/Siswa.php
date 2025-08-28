<?php

namespace App\Modules\Siswa\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Jeniskelamin\Models\Jeniskelamin;
use App\Modules\Agama\Models\Agama;


class Siswa extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'siswa';
	protected $fillable   = ['*'];

	public function jeniskelamin()
	{
		return $this->belongsTo(Jeniskelamin::class, "id_jeniskelamin", "id");
	}
	public function agama()
	{
		return $this->belongsTo(Agama::class, "id_agama", "id");
	}

	public static function cek_aktivasi_siswa($data)
	{
		return DB::table('siswa')
			// ->where('nis', $data->nis)
			->where('nisn', $data->nisn)
			->where('nik', $data->nik);
	}

	public static function get_biodata($id_semester)
	{
		return DB::table('siswa as s')
			->join('pesertadidik as p', function ($join) use ($id_semester) {
				$join->on('s.id', '=', 'p.id_siswa');
				$join->on('p.id_semester', '=', DB::raw("'" . $id_semester . "'"));
			})
			->join('kelas as k', 'p.id_kelas', '=', 'k.id')
			->join('tingkat as t', function ($join) {
				$join->on('t.id', '=', 'k.id_tingkat');
				$join->on('t.tingkat', '=', DB::raw("'XII'"));
			})
			->orderBy('k.kelas')
			->get();
	}

	public static function get_siswa_by_id_user($id_user)
	{
		// dd();
		return DB::table('siswa as a')
			->select('a.id as id_siswa')
			->join('users as b', 'a.nik', '=', 'b.identitas')
			->where('b.id', $id_user)
			->get();
	}

	public static function detail_siswa($id_siswa)
	{
		return DB::table('siswa as a')
			->join('pesertadidik as b', 'a.id', '=', 'b.id_siswa')
			->join('kelas as c', 'b.id_kelas', '=', 'c.id')
			->join('jurusan as d', 'c.id_jurusan', '=', 'd.id')
			->where('a.id', $id_siswa)
			->first();
	}
}
