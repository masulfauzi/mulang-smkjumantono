<?php

namespace App\Modules\ProgramKerja\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Semester\Models\Semester;
use App\Modules\Guru\Models\Guru;
use App\Modules\UnitKerja\Models\UnitKerja;


class ProgramKerja extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'program_kerja';
	protected $fillable   = ['*'];	

	public function semester(){
		return $this->belongsTo(Semester::class,"id_semester","id");
	}
public function guru(){
		return $this->belongsTo(Guru::class,"id_guru","id");
	}
public function unitKerja(){
		return $this->belongsTo(UnitKerja::class,"id_unit_kerja","id");
	}

}
