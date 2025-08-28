<?php

namespace App\Modules\Gurumapel\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Guru\Models\Guru;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Tingkat\Models\Tingkat;
use App\Modules\Jurusan\Models\Jurusan;
use App\Modules\Semester\Models\Semester;


class Gurumapel extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'gurumapel';
	protected $fillable   = ['*'];	

	public function guru(){
		return $this->belongsTo(Guru::class,"id_guru","id");
	}
public function mapel(){
		return $this->belongsTo(Mapel::class,"id_mapel","id");
	}
public function tingkat(){
		return $this->belongsTo(Tingkat::class,"id_tingkat","id");
	}
public function jurusan(){
		return $this->belongsTo(Jurusan::class,"id_jurusan","id");
	}
public function semester(){
		return $this->belongsTo(Semester::class,"id_semester","id");
	}

}
