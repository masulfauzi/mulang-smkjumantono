<?php

namespace App\Modules\Sertifikat\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Guru\Models\Guru;
use App\Modules\Semester\Models\Semester;
use App\Modules\JenisWorkshop\Models\JenisWorkshop;


class Sertifikat extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'sertifikat';
	protected $fillable   = ['*'];	

	public function guru(){
		return $this->belongsTo(Guru::class,"id_guru","id");
	}
public function semester(){
		return $this->belongsTo(Semester::class,"id_semester","id");
	}
public function jenisWorkshop(){
		return $this->belongsTo(JenisWorkshop::class,"id_jenis_workshop","id");
	}

	public static function get_sertifikat_guru($id_guru,  $id_semester)
	{
		return DB::table('jenis_workshop')
					->select('jenis_workshop.*', 'sertifikat.link_modul_ajar', 'sertifikat.link_video')
					->leftJoin('sertifikat', function($join) use ($id_guru)
					{
						$join->on('jenis_workshop.id', '=', 'sertifikat.id_jenis_workshop');
						$join->where('sertifikat.id_guru','=',$id_guru);
					})
					->get();
	}

}
