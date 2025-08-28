<?php

namespace App\Modules\Semester\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Semester extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'semester';
	protected $fillable   = ['*'];	


	public static function get_semester_aktif()
	{
		
		$tgl_sekarang =  date('Y-m-d');
		
		return DB::table('semester')
					->select('id', 'semester')
					->where('tgl_mulai', '<=', $tgl_sekarang)
					->where('tgl_selesai', '>=', $tgl_sekarang)
					->first();
	}

	
}
