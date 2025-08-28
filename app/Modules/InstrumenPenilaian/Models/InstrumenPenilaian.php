<?php

namespace App\Modules\InstrumenPenilaian\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Semester\Models\Semester;
use App\Modules\Guru\Models\Guru;
use App\Modules\Mapel\Models\Mapel;
use App\Modules\Kelas\Models\Kelas;


class InstrumenPenilaian extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'instrumen_penilaian';
	protected $fillable   = ['*'];	

	public function semester(){
		return $this->belongsTo(Semester::class,"id_semester","id");
	}
public function guru(){
		return $this->belongsTo(Guru::class,"id_guru","id");
	}
public function mapel(){
		return $this->belongsTo(Mapel::class,"id_mapel","id");
	}
public function kelas(){
		return $this->belongsTo(Kelas::class,"id_kelas","id");
	}

}
