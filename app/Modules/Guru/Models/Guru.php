<?php

namespace App\Modules\Guru\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Agama\Models\Agama;


class Guru extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'guru';
	protected $fillable   = ['*'];	

	public function agama(){
		return $this->belongsTo(Agama::class,"id_agama","id");
	}

	public static function get_id_guru_by_id_user($id_user)
	{
		return DB::table('guru as a')
					->select('a.id as id_guru')
					->join('users as b', 'a.nik', '=', 'b.identitas')
					->where('b.id', $id_user)
					->get();
	}

}
