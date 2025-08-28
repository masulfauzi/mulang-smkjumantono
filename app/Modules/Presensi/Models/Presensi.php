<?php

namespace App\Modules\Presensi\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Jurnal\Models\Jurnal;
use App\Modules\Pesertadidik\Models\Pesertadidik;
use App\Modules\Statuskehadiran\Models\Statuskehadiran;


class Presensi extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'presensi';
	protected $fillable   = ['*'];	

	public function jurnal(){
		return $this->belongsTo(Jurnal::class,"id_jurnal","id");
	}
public function pesertadidik(){
		return $this->belongsTo(Pesertadidik::class,"id_pesertadidik","id");
	}
public function statuskehadiran(){
		return $this->belongsTo(Statuskehadiran::class,"id_statuskehadiran","id");
	}

	public static function get_presensi_by_idjurnal($id_jurnal)
	{
		return DB::table('presensi as a')
					->select('a.*', 'c.nama_siswa', 'd.status_kehadiran', 'b.is_magang')
					->join('pesertadidik as b', 'a.id_pesertadidik', '=', 'b.id')
					->join('siswa as c', 'b.id_siswa', '=', 'c.id')
					->join('statuskehadiran as d', 'a.id_statuskehadiran', '=', 'd.id')
					->where('a.id_jurnal', $id_jurnal)
					
					->orderBy('b.is_magang')
					->orderBy('c.nama_siswa')
					->get();
	}

	public static function insert_presensi($data)
	{
		return DB::table('presensi')
					->insert($data);
	}

	public static function update_presensi($data)
	{
		return DB::table('presensi')
					->where('id', $data['id'])
					->update($data);
	}

	public static function get_kehadiran_siswa($status, $id_semester, $tanggal)
	{
		return DB::table('presensi as a')
					->join('pesertadidik as b', 'a.id_pesertadidik', '=', 'b.id')
					->join('jurnal as c', 'a.id_jurnal', '=', 'c.id')
					->join('statuskehadiran as d', 'a.id_statuskehadiran', '=', 'd.id')
					->join('siswa as e', 'b.id_siswa', '=', 'e.id')
					->join('kelas as f', 'b.id_kelas',  '=', 'f.id')
					->where('b.id_semester', $id_semester)
					->where('d.status_kehadiran_pendek', $status)
					->where('c.tgl_pembelajaran', $tanggal)
					->groupBy('a.id_pesertadidik')
					->get();
	}

	public static function get_siswa_magang($id_semester)
	{
		return DB::table('pesertadidik')
					->where('is_magang', '1')
					->where('id_semester', $id_semester)
					->get();
	}

}
