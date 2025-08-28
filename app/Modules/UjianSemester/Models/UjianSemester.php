<?php

namespace App\Modules\UjianSemester\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Semester\Models\Semester;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Guru\Models\Guru;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Tingkat\Models\Tingkat;


class UjianSemester extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'ujian_semester';
	protected $fillable   = ['*'];	

	public function semester(){
		return $this->belongsTo(Semester::class,"id_semester","id");
	}
public function mapel(){
		return $this->belongsTo(Mapel::class,"id_mapel","id");
	}
public function guru(){
		return $this->belongsTo(Guru::class,"id_guru","id");
	}
public function jurusan(){
		return $this->belongsTo(Jurusan::class,"id_jurusan","id");
	}
public function tingkat(){
		return $this->belongsTo(Tingkat::class,"id_tingkat","id");
	}

}
