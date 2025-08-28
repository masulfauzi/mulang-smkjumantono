<?php

namespace App\Modules\Karyawan\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use App\Modules\Bagian\Models\Bagian;
use App\Modules\Jeniskelamin\Models\Jeniskelamin;
use App\Modules\Agama\Models\Agama;
use App\Modules\BagianTu\Models\BagianTu;




class Karyawan extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'karyawan';
	protected $fillable   = ['*'];	

	public function bagian(){
		return $this->belongsTo(BagianTu::class,"id_bagian","id");
	}
public function jenisKelamin(){
		return $this->belongsTo(Jeniskelamin::class,"id_jenis_kelamin","id");
	}
public function agama(){
		return $this->belongsTo(Agama::class,"id_agama","id");
	}

	public static function get_id_karyawan_by_id_user($id_user)
	{
		return DB::table('karyawan as a')
					->select('a.id as id_karyawan')
					->join('users as b', 'a.nik', '=', 'b.identitas')
					->where('b.id', $id_user)
					->get();
	}

}
