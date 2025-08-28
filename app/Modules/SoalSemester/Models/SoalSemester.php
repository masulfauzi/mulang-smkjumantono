<?php

namespace App\Modules\SoalSemester\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Ujiansemester\Models\Ujiansemester;


class SoalSemester extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'soal_semester';
	protected $fillable   = ['*'];	

	public function ujiansemester(){
		return $this->belongsTo(Ujiansemester::class,"id_ujiansemester","id");
	}

	public static function cek_soal($id_ujian, $no_soal)
	{
		return DB::table('soal_semester')
					->where('id_ujiansemester', $id_ujian)
					->where('no_soal', $no_soal)
					->get();
	}

}
